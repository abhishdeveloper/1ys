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
        $total = $subtotal + $shipping;

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
        $total = $subtotal + $shipping;

        $orderData = [
            'total_amount' => $total,
            'shipping_cost' => $shipping,
            'shipping_address' => $fullAddress,
            'payment_method' => 'dummy_card',
            'payment_status' => 'paid', // Simulating successful immediate payment for demo
        ];

        // Process order creation
        $orderId = $this->orderModel->create($_SESSION['user_id'], $orderData, $cartItems);

        if ($orderId) {
            // Clear cart
            $_SESSION['cart'] = [];
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