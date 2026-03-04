<?php
// core/controllers/CartController.php

require_once __DIR__ . '/../models/Product.php';

class CartController {
    private $db;
    private $productModel;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->productModel = new Product($db);

        // Ensure cart exists in session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Display the shopping cart
     */
    public function index() {
        $cartItems = [];
        $subtotal = 0;

        // Fetch current product details for items in cart
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            // We use a direct query here since findBySlug requires slug.
            // Let's add findById to Product model or just query it here.
            $stmt = $this->db->prepare("SELECT id, name, slug, price, image_url, stock_quantity FROM products WHERE id = :id AND is_active = 1");
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch();

            if ($product) {
                // Adjust quantity if it exceeds stock
                $actualQuantity = min($quantity, $product['stock_quantity']);
                if ($actualQuantity != $quantity) {
                    $_SESSION['cart'][$productId] = $actualQuantity;
                }

                $itemTotal = $product['price'] * $actualQuantity;
                $subtotal += $itemTotal;

                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $actualQuantity,
                    'total' => $itemTotal
                ];
            } else {
                // Product no longer exists or is inactive, remove from cart
                unset($_SESSION['cart'][$productId]);
            }
        }

        $pageTitle = "Shopping Cart | ShopSwift";
        require_once __DIR__ . '/../views/storefront/cart.php';
    }

    /**
     * Add an item to the cart
     */
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/products');
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        if ($productId > 0 && $quantity > 0) {
            // Check if product exists and has stock
            $stmt = $this->db->prepare("SELECT stock_quantity, name FROM products WHERE id = :id AND is_active = 1");
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch();

            if ($product) {
                $currentQty = $_SESSION['cart'][$productId] ?? 0;
                $newQty = $currentQty + $quantity;

                if ($newQty > $product['stock_quantity']) {
                    setFlashMessage('error', 'Cannot add more of ' . sanitize($product['name']) . '. Only ' . $product['stock_quantity'] . ' in stock.');
                } else {
                    $_SESSION['cart'][$productId] = $newQty;
                    setFlashMessage('success', sanitize($product['name']) . ' added to your cart.');
                }
            } else {
                setFlashMessage('error', 'Product not found or unavailable.');
            }
        }

        // Redirect back to the referring page if possible, else cart
        $referer = $_SERVER['HTTP_REFERER'] ?? '/cart';
        redirect(parse_url($referer, PHP_URL_PATH));
    }

    /**
     * Update quantity of an item
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cart');
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $action = $_POST['action'] ?? ''; // 'increase' or 'decrease'

        if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
            $stmt = $this->db->prepare("SELECT stock_quantity FROM products WHERE id = :id AND is_active = 1");
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch();

            if ($product) {
                $currentQty = $_SESSION['cart'][$productId];

                if ($action === 'increase') {
                    if ($currentQty < $product['stock_quantity']) {
                        $_SESSION['cart'][$productId]++;
                    } else {
                        setFlashMessage('error', 'Maximum stock reached.');
                    }
                } elseif ($action === 'decrease') {
                    if ($currentQty > 1) {
                        $_SESSION['cart'][$productId]--;
                    } else {
                        // Remove if decreased below 1
                        unset($_SESSION['cart'][$productId]);
                    }
                }
            }
        }
        redirect('/cart');
    }

    /**
     * Remove an item from the cart completely
     */
    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($_POST['product_id'] ?? 0);
            if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
                setFlashMessage('success', 'Item removed from cart.');
            }
        }
        redirect('/cart');
    }
}
?>