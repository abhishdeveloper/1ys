<?php
// core/controllers/CheckoutController.php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';

class CheckoutController {
    private $db;
    private $productModel;
    private $orderModel;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->productModel = new Product($db);
        $this->orderModel = new Order($db);

        // Require user to be logged in
        if (!isset($_SESSION['user_id'])) {
            setFlashMessage('error', 'Please log in to complete your purchase.');
            redirect('/login');
        }

        // Require cart to be not empty
        if (empty($_SESSION['cart'])) {
            setFlashMessage('error', 'Your cart is empty.');
            redirect('/products');
        }
    }

    public function index() {
        $cartItems = $this->getCartDetails();
        $subtotal = array_sum(array_column($cartItems, 'total'));
        $shipping = 10.00; // Flat rate for demo

        $discountAmount = 0;

        // Calculate coupon discount
        if (isset($_SESSION['coupon'])) {
            require_once __DIR__ . '/../models/Coupon.php';
            $couponModel = new Coupon($this->db);
            $coupon = $_SESSION['coupon'];
            $discountAmount = $couponModel->calculateDiscount($coupon, $subtotal);

            // If the subtotal dropped below the min_order_value due to cart changes, remove the coupon
            if ($subtotal < $coupon['min_order_value']) {
                unset($_SESSION['coupon']);
                $discountAmount = 0;
                setFlashMessage('error', 'The coupon was removed because your subtotal dropped below the minimum required order value.');
            }
        }

        $total = max(0, ($subtotal - $discountAmount) + $shipping);

        $pageTitle = "Checkout | ShopSwift";
        require_once __DIR__ . '/../views/storefront/checkout.php';
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/checkout');
        }

        $address = sanitize($_POST['address'] ?? '');
        $city = sanitize($_POST['city'] ?? '');
        $zip = sanitize($_POST['zip'] ?? '');

        if (empty($address) || empty($city) || empty($zip)) {
            setFlashMessage('error', 'Please complete all shipping address fields.');
            redirect('/checkout');
        }

        $fullAddress = "$address, $city, $zip";
        $cartItems = $this->getCartDetails();
        $subtotal = array_sum(array_column($cartItems, 'total'));
        $shipping = 10.00;

        $discountAmount = 0;
        $couponId = null;

        if (isset($_SESSION['coupon'])) {
            require_once __DIR__ . '/../models/Coupon.php';
            $couponModel = new Coupon($this->db);
            $coupon = $_SESSION['coupon'];
            $discountAmount = $couponModel->calculateDiscount($coupon, $subtotal);

            if ($subtotal >= $coupon['min_order_value']) {
                $couponId = $coupon['id'];
            } else {
                $discountAmount = 0;
                unset($_SESSION['coupon']);
            }
        }

        $total = max(0, ($subtotal - $discountAmount) + $shipping);

        $orderData = [
            'total_amount' => $total,
            'shipping_cost' => $shipping,
            'discount_amount' => $discountAmount,
            'coupon_id' => $couponId,
            'shipping_address' => $fullAddress,
            'payment_method' => 'dummy_card',
            'payment_status' => 'paid', // Simulating successful immediate payment for demo
        ];

        // Process order creation
        $orderId = $this->orderModel->create($_SESSION['user_id'], $orderData, $cartItems);

        if ($orderId) {
            // Attempt to send order confirmation email
            require_once __DIR__ . '/../helpers/Mailer.php';
            $mailer = new Mailer();

            // Retrieve actual order details including the generated order_number
            $createdOrder = $this->orderModel->findById($orderId, $_SESSION['user_id']);

            // We need the user's email to send the confirmation. Fetch it from the session or DB.
            $stmt = $this->db->prepare("SELECT email, name FROM users WHERE id = :id");
            $stmt->execute(['id' => $_SESSION['user_id']]);
            $user = $stmt->fetch();

            if ($user && $createdOrder) {
                $mailer->sendOrderConfirmationEmail($user['email'], $user['name'], $createdOrder);
            }

            // Clear cart
            $_SESSION['cart'] = [];

            // Also clear any applied coupon
            if (isset($_SESSION['coupon'])) {
                unset($_SESSION['coupon']);
            }

            setFlashMessage('success', 'Thank you! Your order has been placed successfully.');
            redirect('/order/success?id=' . $orderId);
        } else {
            setFlashMessage('error', 'An error occurred while processing your order. Please try again.');
            redirect('/checkout');
        }
    }

    public function success() {
        $orderId = (int)($_GET['id'] ?? 0);
        $order = $this->orderModel->findById($orderId, $_SESSION['user_id']);

        if (!$order) {
            redirect('/dashboard');
        }

        $pageTitle = "Order Success | ShopSwift";
        require_once __DIR__ . '/../views/storefront/order_success.php';
    }

    private function getCartDetails() {
        $cartItems = [];
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $stmt = $this->db->prepare("SELECT id, name, slug, price, stock_quantity FROM products WHERE id = :id AND is_active = 1");
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch();

            if ($product) {
                // Ensure quantity doesn't exceed stock
                $qty = min($quantity, $product['stock_quantity']);
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $qty,
                    'total' => $product['price'] * $qty
                ];
            }
        }
        return $cartItems;
    }
}
?>