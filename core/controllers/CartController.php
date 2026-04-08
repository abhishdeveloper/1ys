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

        foreach ($_SESSION['cart'] as $cartKey => $quantity) {
            // Check if cart key contains a variant separator
            $parts = explode('-', $cartKey);
            $productId = (int)$parts[0];
            $variantId = isset($parts[1]) ? (int)$parts[1] : null;

            $stmt = $this->db->prepare("SELECT id, name, slug, price, image_url, stock_quantity FROM products WHERE id = :id AND is_active = 1");
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch();

            if ($product) {
                // Handle variant overrides
                if ($variantId) {
                    $vStmt = $this->db->prepare("SELECT name, price, stock_quantity FROM product_variants WHERE id = :id AND product_id = :pid AND is_active = 1");
                    $vStmt->execute(['id' => $variantId, 'pid' => $productId]);
                    $variant = $vStmt->fetch();

                    if ($variant) {
                        $product['name'] = $product['name'] . ' - ' . $variant['name'];
                        $product['price'] = $variant['price'];
                        $product['stock_quantity'] = $variant['stock_quantity'];
                    } else {
                        unset($_SESSION['cart'][$cartKey]);
                        continue;
                    }
                }

                $actualQuantity = min($quantity, $product['stock_quantity']);
                if ($actualQuantity != $quantity) {
                    $_SESSION['cart'][$cartKey] = $actualQuantity;
                }

                $itemTotal = $product['price'] * $actualQuantity;
                $subtotal += $itemTotal;

                $cartItems[] = [
                    'cartKey' => $cartKey,
                    'product' => $product,
                    'quantity' => $actualQuantity,
                    'total' => $itemTotal
                ];
            } else {
                unset($_SESSION['cart'][$cartKey]);
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
        $variantId = !empty($_POST['variant_id']) ? (int)$_POST['variant_id'] : null;
        $quantity = (int)($_POST['quantity'] ?? 1);

        if ($productId > 0 && $quantity > 0) {
            $stmt = $this->db->prepare("SELECT stock_quantity, name FROM products WHERE id = :id AND is_active = 1");
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch();

            if ($product) {
                $stockAvailable = $product['stock_quantity'];
                $productName = $product['name'];

                if ($variantId) {
                    $vStmt = $this->db->prepare("SELECT stock_quantity, name FROM product_variants WHERE id = :id AND product_id = :pid AND is_active = 1");
                    $vStmt->execute(['id' => $variantId, 'pid' => $productId]);
                    $variant = $vStmt->fetch();
                    if ($variant) {
                        $stockAvailable = $variant['stock_quantity'];
                        $productName = $productName . ' - ' . $variant['name'];
                    } else {
                        setFlashMessage('error', 'Variant not found.');
                        redirect(parse_url($_SERVER['HTTP_REFERER'] ?? '/cart', PHP_URL_PATH));
                    }
                }

                $cartKey = $variantId ? "{$productId}-{$variantId}" : (string)$productId;
                $currentQty = $_SESSION['cart'][$cartKey] ?? 0;
                $newQty = $currentQty + $quantity;

                if ($newQty > $stockAvailable) {
                    setFlashMessage('error', 'Cannot add more of ' . sanitize($productName) . '. Only ' . $stockAvailable . ' in stock.');
                } else {
                    $_SESSION['cart'][$cartKey] = $newQty;
                    setFlashMessage('success', sanitize($productName) . ' added to your cart.');
                }
            } else {
                setFlashMessage('error', 'Product not found or unavailable.');
            }
        }

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

        $cartKey = $_POST['cart_key'] ?? '';
        // Fallback for old forms without cart_key
        if (empty($cartKey) && isset($_POST['product_id'])) {
            $cartKey = (string)$_POST['product_id'];
        }

        $action = $_POST['action'] ?? '';

        if (!empty($cartKey) && isset($_SESSION['cart'][$cartKey])) {
            $parts = explode('-', $cartKey);
            $productId = (int)$parts[0];
            $variantId = isset($parts[1]) ? (int)$parts[1] : null;

            $stmt = $this->db->prepare("SELECT stock_quantity FROM products WHERE id = :id AND is_active = 1");
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch();

            if ($product) {
                $stockAvailable = $product['stock_quantity'];

                if ($variantId) {
                    $vStmt = $this->db->prepare("SELECT stock_quantity FROM product_variants WHERE id = :id AND product_id = :pid AND is_active = 1");
                    $vStmt->execute(['id' => $variantId, 'pid' => $productId]);
                    $variant = $vStmt->fetch();
                    if ($variant) $stockAvailable = $variant['stock_quantity'];
                }

                $currentQty = $_SESSION['cart'][$cartKey];

                if ($action === 'increase') {
                    if ($currentQty < $stockAvailable) {
                        $_SESSION['cart'][$cartKey]++;
                    } else {
                        setFlashMessage('error', 'Maximum stock reached.');
                    }
                } elseif ($action === 'decrease') {
                    if ($currentQty > 1) {
                        $_SESSION['cart'][$cartKey]--;
                    } else {
                        unset($_SESSION['cart'][$cartKey]);
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
            $cartKey = $_POST['cart_key'] ?? '';
            // Fallback for old forms
            if (empty($cartKey) && isset($_POST['product_id'])) {
                $cartKey = (string)$_POST['product_id'];
            }

            if (!empty($cartKey) && isset($_SESSION['cart'][$cartKey])) {
                unset($_SESSION['cart'][$cartKey]);
                setFlashMessage('success', 'Item removed from cart.');
            }
        }
        redirect('/cart');
    }
}
?>