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

// Handle subdirectories: remove the script's directory path from the URI
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
if ($scriptName !== '/' && $scriptName !== '\\') {
    if (strpos($requestUri, $scriptName) === 0) {
        $requestUri = substr($requestUri, strlen($scriptName));
    }
}

// Strip out any trailing 'index.php' if it was explicitly typed
$requestUri = str_replace('/index.php', '', $requestUri);

$route = trim($requestUri, '/');
if (empty($route)) {
    $route = 'home';
}

// Map the request to an action
try {
    $db = getDB();

    switch ($route) {
        case 'home':
            require_once __DIR__ . '/core/controllers/HomeController.php';
            $home = new HomeController($db);
            $home->index();
            break;

        case 'products':
            require_once __DIR__ . '/core/controllers/ProductController.php';
            $productCtrl = new ProductController($db);
            $productCtrl->index();
            break;

        case 'api/search':
            require_once __DIR__ . '/core/controllers/ProductController.php';
            $productCtrl = new ProductController($db);
            $productCtrl->search();
            break;

        case 'categories':
            require_once __DIR__ . '/core/controllers/CategoryController.php';
            $categoryCtrl = new CategoryController($db);
            $categoryCtrl->index();
            break;

        case 'cart':
        case 'contact':
        case 'faq':
            // Placeholder routes for upcoming features
            $pageTitle = ucfirst($route) . " | ShopSwift";
            require_once __DIR__ . '/core/views/storefront/coming_soon.php';
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
            // Dynamic routing for categories and products
            // Expected format: /category/slug or /product/slug
            $routeParts = explode('/', $route);
            if (count($routeParts) == 2) {
                require_once __DIR__ . '/core/controllers/ProductController.php';
                $productCtrl = new ProductController($db);

                if ($routeParts[0] === 'category') {
                    $productCtrl->index($routeParts[1]);
                    break;
                } elseif ($routeParts[0] === 'product') {
                    $productCtrl->show($routeParts[1]);
                    break;
                }
            }

            // If no dynamic route matched, show 404
            http_response_code(404);
            require_once __DIR__ . '/core/views/storefront/404.php';
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "An unexpected error occurred.";
    error_log("General Application Error: " . $e->getMessage());
}
?>