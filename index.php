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
            require_once __DIR__ . '/core/controllers/CartController.php';
            $cartCtrl = new CartController($db);
            $cartCtrl->index();
            break;

        case 'cart/add':
            require_once __DIR__ . '/core/controllers/CartController.php';
            $cartCtrl = new CartController($db);
            $cartCtrl->add();
            break;

        case 'cart/update':
            require_once __DIR__ . '/core/controllers/CartController.php';
            $cartCtrl = new CartController($db);
            $cartCtrl->update();
            break;

        case 'cart/remove':
            require_once __DIR__ . '/core/controllers/CartController.php';
            $cartCtrl = new CartController($db);
            $cartCtrl->remove();
            break;

        case 'checkout':
            require_once __DIR__ . '/core/controllers/CheckoutController.php';
            $checkoutCtrl = new CheckoutController($db);
            $checkoutCtrl->index();
            break;

        case 'checkout/process':
            require_once __DIR__ . '/core/controllers/CheckoutController.php';
            $checkoutCtrl = new CheckoutController($db);
            $checkoutCtrl->process();
            break;

        case 'coupon/apply':
            require_once __DIR__ . '/core/controllers/CouponController.php';
            $couponCtrl = new CouponController($db);
            $couponCtrl->apply();
            break;

        case 'coupon/remove':
            require_once __DIR__ . '/core/controllers/CouponController.php';
            $couponCtrl = new CouponController($db);
            $couponCtrl->remove();
            break;

        case 'order/success':
            require_once __DIR__ . '/core/controllers/CheckoutController.php';
            $checkoutCtrl = new CheckoutController($db);
            $checkoutCtrl->success();
            break;

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

        case 'change-password':
            require_once __DIR__ . '/core/models/User.php';
            require_once __DIR__ . '/core/controllers/AuthController.php';
            $auth = new AuthController($db);
            $auth->changePassword();
            break;

        case 'dashboard':
            require_once __DIR__ . '/core/controllers/DashboardController.php';
            $dashboardCtrl = new DashboardController($db);
            $dashboardCtrl->index();
            break;

        case 'admin':
            require_once __DIR__ . '/core/controllers/AdminController.php';
            $adminCtrl = new AdminController($db);
            $adminCtrl->index();
            break;

        case 'admin/products':
            require_once __DIR__ . '/core/controllers/AdminProductController.php';
            $adminProductCtrl = new AdminProductController($db);
            $adminProductCtrl->index();
            break;

        case 'admin/products/add':
            require_once __DIR__ . '/core/controllers/AdminProductController.php';
            $adminProductCtrl = new AdminProductController($db);
            $adminProductCtrl->create();
            break;

        case 'admin/products/edit':
            require_once __DIR__ . '/core/controllers/AdminProductController.php';
            $adminProductCtrl = new AdminProductController($db);
            $id = (int)($_GET['id'] ?? 0);
            $adminProductCtrl->edit($id);
            break;

        case 'admin/orders':
            require_once __DIR__ . '/core/controllers/AdminOrderController.php';
            $adminOrderCtrl = new AdminOrderController($db);
            $adminOrderCtrl->index();
            break;

        case 'admin/orders/show':
            require_once __DIR__ . '/core/controllers/AdminOrderController.php';
            $adminOrderCtrl = new AdminOrderController($db);
            $id = (int)($_GET['id'] ?? 0);
            $adminOrderCtrl->show($id);
            break;

        case 'admin/coupons':
            require_once __DIR__ . '/core/controllers/AdminCouponController.php';
            $adminCouponCtrl = new AdminCouponController($db);
            $adminCouponCtrl->index();
            break;

        // Note: For brevity in iteration, add product is a similar implementation to edit.

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