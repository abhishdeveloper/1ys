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
     * Initiate Google Login Flow
     */
    public function google() {
        $stmt = $this->db->prepare("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('google_client_id', 'google_client_secret')");
        $stmt->execute();
        $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        if (empty($settings['google_client_id'])) {
            setFlashMessage('error', 'Google Login is not configured yet.');
            redirect('/login');
        }

        $clientId = $settings['google_client_id'];
        $redirectUri = getBaseUrl() . '/auth/google/callback';
        $scope = 'email profile';

        $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => $scope,
            'access_type' => 'online',
            'prompt' => 'select_account consent'
        ]);

        header('Location: ' . $authUrl);
        exit;
    }

    /**
     * Handle Google OAuth Callback
     */
    public function googleCallback() {
        if (isset($_GET['error'])) {
            setFlashMessage('error', 'Google Login was cancelled or failed.');
            redirect('/login');
        }

        if (!isset($_GET['code'])) {
            redirect('/login');
        }

        $code = $_GET['code'];

        $stmt = $this->db->prepare("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('google_client_id', 'google_client_secret')");
        $stmt->execute();
        $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $clientId = $settings['google_client_id'] ?? '';
        $clientSecret = $settings['google_client_secret'] ?? '';
        $redirectUri = getBaseUrl() . '/auth/google/callback';

        // Exchange code for token via cURL
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        $ch = curl_init($tokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
            'code' => $code
        ]));

        $tokenResponse = curl_exec($ch);
        curl_close($ch);

        $tokenData = json_decode($tokenResponse, true);

        if (!isset($tokenData['access_token'])) {
            error_log("Google OAuth Token Error: " . $tokenResponse);
            setFlashMessage('error', 'Failed to authenticate with Google.');
            redirect('/login');
        }

        $accessToken = $tokenData['access_token'];

        // Get user profile data
        $userInfoUrl = 'https://www.googleapis.com/oauth2/v2/userinfo';
        $ch = curl_init($userInfoUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken
        ]);
        $userInfoResponse = curl_exec($ch);
        curl_close($ch);

        $userInfo = json_decode($userInfoResponse, true);

        if (!isset($userInfo['email'])) {
            setFlashMessage('error', 'Failed to retrieve email from Google.');
            redirect('/login');
        }

        $email = $userInfo['email'];
        $name = $userInfo['name'] ?? 'Google User';

        // Check if user exists
        $user = $this->userModel->findByEmail($email);

        if ($user) {
            // Log them in
            regenerateSession();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Initialize cart if not exists
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            setFlashMessage('success', "Welcome back, " . htmlspecialchars($user['name']) . "!");
            redirect($user['role'] === 'admin' ? '/admin' : '/dashboard');
        } else {
            // Create a new account with a random password
            $randomPassword = bin2hex(random_bytes(10));
            $userId = $this->userModel->create($name, $email, $randomPassword);

            if ($userId) {
                // Send welcome email
                require_once __DIR__ . '/../helpers/Mailer.php';
                $mailer = new Mailer();
                $mailer->sendAccountCreationEmail($email, $name);

                // Auto login
                regenerateSession();
                $_SESSION['user_id'] = $userId;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = 'customer';

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                setFlashMessage('success', 'Account successfully created via Google!');
                redirect('/dashboard');
            } else {
                setFlashMessage('error', 'Failed to create account.');
                redirect('/register');
            }
        }
    }

    /**
     * Handle Forgot Password Request
     */
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = sanitize($_POST['email'] ?? '');

            if (empty($email)) {
                setFlashMessage('error', 'Email is required.');
                redirect('/forgot-password');
            }

            $user = $this->userModel->findByEmail($email);

            if ($user) {
                // Generate temporary password
                $tempPassword = bin2hex(random_bytes(4)); // 8 character random string

                // Update user password to the temp one
                if ($this->userModel->updatePassword($user['id'], $tempPassword)) {
                    require_once __DIR__ . '/../helpers/Mailer.php';
                    $mailer = new Mailer();
                    if ($mailer->sendTemporaryPasswordEmail($user['email'], $user['name'], $tempPassword)) {
                        setFlashMessage('success', 'A temporary password has been sent to your email address.');
                        redirect('/login');
                    } else {
                        setFlashMessage('error', 'Failed to send email. Please try again later.');
                    }
                } else {
                    setFlashMessage('error', 'An error occurred while resetting your password.');
                }
            } else {
                // Security: Don't reveal if email exists or not
                setFlashMessage('success', 'If the email exists in our system, a temporary password has been sent.');
                redirect('/login');
            }
        } else {
            // Load the view
            $pageTitle = "Forgot Password | ShopSwift";
            require_once __DIR__ . '/../views/storefront/forgot_password.php';
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