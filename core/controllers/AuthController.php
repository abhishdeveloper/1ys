<?php
/**
 * Auth Controller
 * Handles user login, registration, and logout logic.
 */
class AuthController {
    private $db;
    private $userModel;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->userModel = new User($db);
    }

    /**
     * Process user login submission
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                setFlashMessage('error', 'Email and password are required.');
                redirect('/login');
            }

            $user = $this->userModel->findByEmail($email);

            // Use password_verify to check if the provided password matches the hash
            if ($user && password_verify($password, $user['password_hash'])) {
                regenerateSession();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];

                setFlashMessage('success', 'Welcome back, ' . $user['name'] . '!');

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    redirect('/admin');
                } else {
                    redirect('/dashboard');
                }
            } else {
                setFlashMessage('error', 'Invalid email or password.');
                redirect('/login');
            }
        } else {
            // Load the login view
            require_once __DIR__ . '/../views/storefront/login.php';
        }
    }

    /**
     * Handle Google OAuth Callback
     */
    public function googleCallback() {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];

            // Get Google OAuth credentials from settings
            $stmt = $this->db->query("SELECT setting_value FROM settings WHERE setting_key = 'google_client_id'");
            $clientId = $stmt->fetchColumn();

            $stmt = $this->db->query("SELECT setting_value FROM settings WHERE setting_key = 'google_client_secret'");
            $clientSecret = $stmt->fetchColumn();

            if (empty($clientId) || empty($clientSecret)) {
                setFlashMessage('error', 'Google Sign-in is not configured properly.');
                redirect('/login');
            }

            $redirectUri = getBaseUrl() . '/auth/google/callback';

            // Exchange code for access token using cURL
            $ch = curl_init('https://oauth2.googleapis.com/token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'grant_type' => 'authorization_code',
                'code' => $code,
            ]));
            $response = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($response, true);

            if (isset($data['access_token'])) {
                $accessToken = $data['access_token'];

                // Get user info
                $ch = curl_init('https://www.googleapis.com/oauth2/v2/userinfo');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $accessToken]);
                $userResponse = curl_exec($ch);
                curl_close($ch);

                $googleUser = json_decode($userResponse, true);

                if (isset($googleUser['email'])) {
                    $email = $googleUser['email'];
                    $name = $googleUser['name'] ?? 'Google User';

                    // Check if user exists
                    $user = $this->userModel->findByEmail($email);

                    if (!$user) {
                        // Create a random secure password for auto-registered users
                        $randomPassword = bin2hex(random_bytes(16));
                        $userId = $this->userModel->create($name, $email, $randomPassword);

                        if ($userId) {
                            $user = $this->userModel->findById($userId);

                            require_once __DIR__ . '/../helpers/Mailer.php';
                            $mailer = new Mailer();
                            $mailer->sendAccountCreationEmail($email, $name);
                        } else {
                            setFlashMessage('error', 'Failed to create an account from Google profile.');
                            redirect('/login');
                        }
                    }

                    // Log the user in
                    regenerateSession();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['name'] = $user['name'];

                    setFlashMessage('success', 'Welcome, ' . $user['name'] . '!');

                    if ($user['role'] === 'admin') {
                        redirect('/admin');
                    } else {
                        redirect('/dashboard');
                    }
                }
            } else {
                setFlashMessage('error', 'Failed to authenticate with Google.');
                redirect('/login');
            }
        }

        // If we get here without a code or it failed
        redirect('/login');
    }

    /**
     * Process user registration submission
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = sanitize($_POST['name'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Basic validation
            if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
                setFlashMessage('error', 'All fields are required.');
                redirect('/register');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                setFlashMessage('error', 'Invalid email format.');
                redirect('/register');
            }

            if ($password !== $confirmPassword) {
                setFlashMessage('error', 'Passwords do not match.');
                redirect('/register');
            }

            if (strlen($password) < 8) {
                setFlashMessage('error', 'Password must be at least 8 characters long.');
                redirect('/register');
            }

            // Attempt to create the user
            $userId = $this->userModel->create($name, $email, $password);

            if ($userId) {
                // Attempt to send welcome email (fail silently if SMTP is not configured)
                require_once __DIR__ . '/../helpers/Mailer.php';
                $mailer = new Mailer();
                $mailer->sendAccountCreationEmail($email, $name);

                // Log the user in immediately after registration
                regenerateSession();
                $_SESSION['user_id'] = $userId;
                $_SESSION['role'] = 'customer';
                $_SESSION['name'] = $name;

                setFlashMessage('success', 'Registration successful! Welcome to the store.');
                redirect('/dashboard');
            } else {
                setFlashMessage('error', 'An account with this email already exists.');
                redirect('/register');
            }
        } else {
            // Load the registration view
            require_once __DIR__ . '/../views/storefront/register.php';
        }
    }

    /**
     * Logout a user and destroy the session
     */
    /**
     * Process password change request for logged-in user
     */
    public function changePassword() {
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                setFlashMessage('error', 'All fields are required.');
                redirect('/change-password');
            }

            if ($newPassword !== $confirmPassword) {
                setFlashMessage('error', 'New passwords do not match.');
                redirect('/change-password');
            }

            if (strlen($newPassword) < 8) {
                setFlashMessage('error', 'New password must be at least 8 characters long.');
                redirect('/change-password');
            }

            $user = $this->userModel->findById($_SESSION['user_id']);

            if ($user && password_verify($currentPassword, $user['password_hash'])) {
                if ($this->userModel->updatePassword($user['id'], $newPassword)) {

                    // Attempt to send email notification
                    require_once __DIR__ . '/../helpers/Mailer.php';
                    $mailer = new Mailer();
                    $mailer->sendPasswordChangeEmail($user['email'], $user['name']);

                    setFlashMessage('success', 'Your password has been successfully updated.');
                    redirect('/dashboard');
                } else {
                    setFlashMessage('error', 'Failed to update password. Please try again.');
                    redirect('/change-password');
                }
            } else {
                setFlashMessage('error', 'Incorrect current password.');
                redirect('/change-password');
            }
        } else {
            // Load the view
            $pageTitle = "Change Password | ShopSwift";
            require_once __DIR__ . '/../views/storefront/change_password.php';
        }
    }

    /**
     * Logout a user and destroy the session
     */
    public function logout() {
        startSession();
        // Unset all session variables
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        redirect('/');
    }
}
?>