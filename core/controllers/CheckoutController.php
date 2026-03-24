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

    public function initPayment() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit;
        }

        header('Content-Type: application/json');

        // Verify Razorpay keys exist
        $stmt = $this->db->prepare("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('razorpay_key_id', 'razorpay_key_secret')");
        $stmt->execute();
        $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        if (empty($settings['razorpay_key_id']) || empty($settings['razorpay_key_secret'])) {
            echo json_encode(['success' => false, 'message' => 'Payment gateway is not configured.']);
            exit;
        }

        // Calculate total
        $cartItems = $this->getCartDetails();
        $subtotal = array_sum(array_column($cartItems, 'total'));
        $shipping = 10.00;
        $discountAmount = 0;

        if (isset($_SESSION['coupon'])) {
            require_once __DIR__ . '/../models/Coupon.php';
            $couponModel = new Coupon($this->db);
            $coupon = $_SESSION['coupon'];
            $discountAmount = $couponModel->calculateDiscount($coupon, $subtotal);

            if ($subtotal < $coupon['min_order_value']) {
                $discountAmount = 0; // Coupon invalid due to cart changes
            }
        }

        $total = max(0, ($subtotal - $discountAmount) + $shipping);

        // Create Razorpay Order
        require_once __DIR__ . '/../helpers/RazorpayHelper.php';
        $razorpay = new RazorpayHelper($settings['razorpay_key_id'], $settings['razorpay_key_secret']);
        $order = $razorpay->createOrder($total, 'INR', 'order_rcptid_' . $_SESSION['user_id'] . '_' . time());

        if ($order) {
            $_SESSION['razorpay_order_id'] = $order['id'];
            echo json_encode([
                'success' => true,
                'key_id' => trim($settings['razorpay_key_id']),
                'order' => $order
            ]);
        } else {
            $errorMessage = $razorpay->lastError ? $razorpay->lastError : 'Failed to create payment order with gateway.';
            echo json_encode(['success' => false, 'message' => $errorMessage]);
        }
        exit;
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/checkout');
        }

        $address = sanitize($_POST['address'] ?? '');
        $city = sanitize($_POST['city'] ?? '');
        $state = sanitize($_POST['state'] ?? '');
        $zip = sanitize($_POST['zip'] ?? '');

        if (empty($address) || empty($city) || empty($state) || empty($zip)) {
            setFlashMessage('error', 'Please complete all shipping address fields.');
            redirect('/checkout');
        }

        $fullAddress = "$address, $city, $state, $zip";
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

        // Verify Razorpay signature
        $razorpayPaymentId = $_POST['razorpay_payment_id'] ?? null;
        $razorpayOrderId = $_POST['razorpay_order_id'] ?? null;
        $razorpaySignature = $_POST['razorpay_signature'] ?? null;

        if (!$razorpayPaymentId || !$razorpayOrderId || !$razorpaySignature) {
            setFlashMessage('error', 'Payment verification failed: Missing payment details.');
            redirect('/checkout');
        }

        // Verify order ID against session to prevent tampering
        if (!isset($_SESSION['razorpay_order_id']) || $_SESSION['razorpay_order_id'] !== $razorpayOrderId) {
            setFlashMessage('error', 'Payment verification failed: Invalid session.');
            redirect('/checkout');
        }

        $stmt = $this->db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'razorpay_key_secret'");
        $stmt->execute();
        $keySecret = $stmt->fetchColumn();

        require_once __DIR__ . '/../helpers/RazorpayHelper.php';
        $razorpay = new RazorpayHelper('', $keySecret);

        if (!$razorpay->verifySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature)) {
            setFlashMessage('error', 'Payment verification failed: Invalid signature.');
            redirect('/checkout');
        }

        // Clear the order ID from session after successful verification
        unset($_SESSION['razorpay_order_id']);

        $orderData = [
            'total_amount' => $total,
            'shipping_cost' => $shipping,
            'discount_amount' => $discountAmount,
            'coupon_id' => $couponId,
            'shipping_address' => $fullAddress,
            'payment_method' => 'razorpay',
            'payment_status' => 'paid',
            'razorpay_order_id' => $razorpayOrderId,
            'razorpay_payment_id' => $razorpayPaymentId,
            'razorpay_signature' => $razorpaySignature
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
                $createdOrder['customer_name'] = $user['name'];
                $createdOrder['customer_email'] = $user['email'];
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