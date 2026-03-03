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