<?php
// core/controllers/AdminProductController.php

class AdminProductController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;

        $role = $_SESSION['role'] ?? '';
        if ($role !== 'admin' && $role !== 'seller') {
            redirect('/login');
        }
    }

    public function index() {
        $role = $_SESSION['role'];
        $userId = $_SESSION['user_id'];

        if ($role === 'admin') {
            $stmt = $this->db->query("SELECT p.*, c.name as category_name, u.name as seller_name FROM products p JOIN categories c ON p.category_id = c.id JOIN users u ON p.seller_id = u.id ORDER BY p.created_at DESC");
            $products = $stmt->fetchAll();
        } else {
            $stmt = $this->db->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.seller_id = :seller_id ORDER BY p.created_at DESC");
            $stmt->execute(['seller_id' => $userId]);
            $products = $stmt->fetchAll();
        }

        $pageTitle = "Manage Products | Admin Panel";
        require_once __DIR__ . '/../views/admin/products/index.php';
    }

    public function create() {
        $stmt = $this->db->query("SELECT * FROM categories WHERE status = 1");
        $categories = $stmt->fetchAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = sanitize($_POST['name']);
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
            $categoryId = (int)$_POST['category_id'];
            $price = (float)$_POST['price'];
            $stock = (int)$_POST['stock_quantity'];
            $description = sanitize($_POST['description']);
            $sellerId = $_SESSION['role'] === 'admin' && isset($_POST['seller_id']) ? (int)$_POST['seller_id'] : $_SESSION['user_id'];

            $imageUrl = null;

            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../uploads/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                // Sanitize filename to prevent XSS/Path Traversal
                $safeFileName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', basename($_FILES['image']['name']));
                $fileName = time() . '_' . $safeFileName;
                $targetFile = $uploadDir . $fileName;

                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                if (in_array($fileType, ['jpg', 'jpeg', 'png', 'webp'])) {
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        $imageUrl = '/uploads/' . $fileName;
                    }
                }
            }

            try {
                $stmt = $this->db->prepare("INSERT INTO products (seller_id, category_id, name, slug, description, price, stock_quantity, image_url) VALUES (:seller_id, :category_id, :name, :slug, :description, :price, :stock, :image_url)");
                $stmt->execute([
                    'seller_id' => $sellerId,
                    'category_id' => $categoryId,
                    'name' => $name,
                    'slug' => $slug,
                    'description' => $description,
                    'price' => $price,
                    'stock' => $stock,
                    'image_url' => $imageUrl
                ]);
                setFlashMessage('success', 'Product created successfully.');
                redirect('/admin/products');
            } catch (Exception $e) {
                setFlashMessage('error', 'Error creating product: ' . $e->getMessage());
            }
        }

        $pageTitle = "Add Product | Admin Panel";
        require_once __DIR__ . '/../views/admin/products/create.php';
    }

    public function edit($id) {
        // Validation of ownership
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();

        if (!$product || ($_SESSION['role'] !== 'admin' && $product['seller_id'] != $_SESSION['user_id'])) {
            setFlashMessage('error', 'Product not found or access denied.');
            redirect('/admin/products');
        }

        $stmt = $this->db->query("SELECT * FROM categories WHERE status = 1");
        $categories = $stmt->fetchAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = sanitize($_POST['name']);
            $categoryId = (int)$_POST['category_id'];
            $price = (float)$_POST['price'];
            $stock = (int)$_POST['stock_quantity'];
            $description = sanitize($_POST['description']);
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            $imageUrl = $product['image_url'];

            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../uploads/';
                // Sanitize filename to prevent XSS/Path Traversal
                $safeFileName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', basename($_FILES['image']['name']));
                $fileName = time() . '_' . $safeFileName;
                $targetFile = $uploadDir . $fileName;

                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                if (in_array($fileType, ['jpg', 'jpeg', 'png', 'webp'])) {
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        $imageUrl = '/uploads/' . $fileName;
                    }
                }
            }

            try {
                $stmt = $this->db->prepare("UPDATE products SET category_id = :cat, name = :name, description = :desc, price = :price, stock_quantity = :stock, is_active = :active, image_url = :img WHERE id = :id");
                $stmt->execute([
                    'cat' => $categoryId,
                    'name' => $name,
                    'desc' => $description,
                    'price' => $price,
                    'stock' => $stock,
                    'active' => $isActive,
                    'img' => $imageUrl,
                    'id' => $id
                ]);
                setFlashMessage('success', 'Product updated successfully.');
                redirect('/admin/products');
            } catch (Exception $e) {
                setFlashMessage('error', 'Error updating product.');
            }
        }

        $pageTitle = "Edit Product | Admin Panel";
        require_once __DIR__ . '/../views/admin/products/edit.php';
    }
}
?>