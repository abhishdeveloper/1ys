<?php
/**
 * Application Entry Point (Front Controller)
 * Handles all requests, routing, and initialization.
 */

// Initialize standard environment
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load required configuration and helper functions
require_once __DIR__ . '/core/config/database.php';
require_once __DIR__ . '/core/helpers/functions.php';

// Initialize session handling
startSession();

// Setup minimal routing mapping paths to controllers/methods
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = trim($requestUri, '/');
if (empty($route)) {
    $route = 'home';
}

// Map the request to an action
try {
    $db = getDB();

    switch ($route) {
        case 'home':
            // TODO: Create a HomeController
            echo "Welcome to the E-commerce Homepage.";
            break;

        case 'login':
            require_once __DIR__ . '/core/models/User.php';
            require_once __DIR__ . '/core/controllers/AuthController.php';
            $auth = new AuthController($db);
            $auth->login();
            break;

        case 'register':
            require_once __DIR__ . '/core/models/User.php';
            require_once __DIR__ . '/core/controllers/AuthController.php';
            $auth = new AuthController($db);
            $auth->register();
            break;

        case 'logout':
            require_once __DIR__ . '/core/models/User.php';
            require_once __DIR__ . '/core/controllers/AuthController.php';
            $auth = new AuthController($db);
            $auth->logout();
            break;

        case 'dashboard':
            // Simple check to ensure user is logged in
            if (!isset($_SESSION['user_id'])) {
                redirect('/login');
            }
            echo "Welcome to your dashboard, " . htmlspecialchars($_SESSION['name']) . "!";
            echo "<br><a href='/logout'>Logout</a>";
            break;

        case 'admin':
            // Check admin role
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
                http_response_code(403);
                echo "Access Denied.";
                exit();
            }
            echo "Welcome to the Admin Panel!";
            echo "<br><a href='/logout'>Logout</a>";
            break;

        default:
            http_response_code(404);
            echo "404 Page Not Found";
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "An unexpected error occurred.";
    error_log("General Application Error: " . $e->getMessage());
}
?>