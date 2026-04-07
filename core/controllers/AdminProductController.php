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
            $howToUse = sanitize($_POST['how_to_use'] ?? '');
            $ingredients = sanitize($_POST['ingredients'] ?? '');
            $benefits = sanitize($_POST['benefits'] ?? '');

            // Process FAQs (JSON)
            $faqs = null;
            if (!empty($_POST['faq_questions']) && is_array($_POST['faq_questions'])) {
                $faqArray = [];
                foreach ($_POST['faq_questions'] as $key => $question) {
                    if (!empty($question) && !empty($_POST['faq_answers'][$key])) {
                        $faqArray[] = [
                            'question' => sanitize($question),
                            'answer' => sanitize($_POST['faq_answers'][$key])
                        ];
                    }
                }
                if (!empty($faqArray)) {
                    $faqs = json_encode($faqArray);
                }
            }

            // Process Badges (JSON)
            $badges = null;
            if (!empty($_POST['badges']) && is_array($_POST['badges'])) {
                $badges = json_encode(array_map('sanitize', $_POST['badges']));
            }

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
                $this->db->beginTransaction();

                $stmt = $this->db->prepare("
                    INSERT INTO products (seller_id, category_id, name, slug, description, how_to_use, ingredients, benefits, faqs, badges, price, stock_quantity, image_url)
                    VALUES (:seller_id, :category_id, :name, :slug, :description, :how_to_use, :ingredients, :benefits, :faqs, :badges, :price, :stock, :image_url)
                ");
                $stmt->execute([
                    'seller_id' => $sellerId,
                    'category_id' => $categoryId,
                    'name' => $name,
                    'slug' => $slug,
                    'description' => $description,
                    'how_to_use' => $howToUse,
                    'ingredients' => $ingredients,
                    'benefits' => $benefits,
                    'faqs' => $faqs,
                    'badges' => $badges,
                    'price' => $price,
                    'stock' => $stock,
                    'image_url' => $imageUrl
                ]);

                $productId = $this->db->lastInsertId();

                // Handle Variants
                if (!empty($_POST['variant_name']) && is_array($_POST['variant_name'])) {
                    $variantStmt = $this->db->prepare("
                        INSERT INTO product_variants (product_id, name, sku, price, stock_quantity)
                        VALUES (:product_id, :name, :sku, :price, :stock_quantity)
                    ");
                    foreach ($_POST['variant_name'] as $key => $vName) {
                        if (!empty($vName)) {
                            $variantStmt->execute([
                                'product_id' => $productId,
                                'name' => sanitize($vName),
                                'sku' => sanitize($_POST['variant_sku'][$key] ?? ''),
                                'price' => (float)($_POST['variant_price'][$key] ?? 0),
                                'stock_quantity' => (int)($_POST['variant_stock'][$key] ?? 0)
                            ]);
                        }
                    }
                }

                $this->db->commit();
                setFlashMessage('success', 'Product created successfully.');
                redirect('/admin/products');
            } catch (Exception $e) {
                $this->db->rollBack();
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
            $howToUse = sanitize($_POST['how_to_use'] ?? '');
            $ingredients = sanitize($_POST['ingredients'] ?? '');
            $benefits = sanitize($_POST['benefits'] ?? '');

            // Process FAQs (JSON)
            $faqs = null;
            if (!empty($_POST['faq_questions']) && is_array($_POST['faq_questions'])) {
                $faqArray = [];
                foreach ($_POST['faq_questions'] as $key => $question) {
                    if (!empty($question) && !empty($_POST['faq_answers'][$key])) {
                        $faqArray[] = [
                            'question' => sanitize($question),
                            'answer' => sanitize($_POST['faq_answers'][$key])
                        ];
                    }
                }
                if (!empty($faqArray)) {
                    $faqs = json_encode($faqArray);
                }
            }

            // Process Badges (JSON)
            $badges = null;
            if (!empty($_POST['badges']) && is_array($_POST['badges'])) {
                $badges = json_encode(array_map('sanitize', $_POST['badges']));
            }

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
                $this->db->beginTransaction();

                $stmt = $this->db->prepare("
                    UPDATE products
                    SET category_id = :cat, name = :name, description = :desc,
                        how_to_use = :how_to_use, ingredients = :ingredients, benefits = :benefits,
                        faqs = :faqs, badges = :badges, price = :price,
                        stock_quantity = :stock, is_active = :active, image_url = :img
                    WHERE id = :id
                ");
                $stmt->execute([
                    'cat' => $categoryId,
                    'name' => $name,
                    'desc' => $description,
                    'how_to_use' => $howToUse,
                    'ingredients' => $ingredients,
                    'benefits' => $benefits,
                    'faqs' => $faqs,
                    'badges' => $badges,
                    'price' => $price,
                    'stock' => $stock,
                    'active' => $isActive,
                    'img' => $imageUrl,
                    'id' => $id
                ]);

                // Handle updating/inserting variants without mass deleting
                $submittedVariantIds = [];
                if (!empty($_POST['variant_name']) && is_array($_POST['variant_name'])) {
                    $insertVariantStmt = $this->db->prepare("
                        INSERT INTO product_variants (product_id, name, sku, price, stock_quantity)
                        VALUES (:product_id, :name, :sku, :price, :stock_quantity)
                    ");
                    $updateVariantStmt = $this->db->prepare("
                        UPDATE product_variants
                        SET name = :name, sku = :sku, price = :price, stock_quantity = :stock_quantity
                        WHERE id = :vid AND product_id = :product_id
                    ");

                    foreach ($_POST['variant_name'] as $key => $vName) {
                        if (!empty($vName)) {
                            $vId = !empty($_POST['variant_id'][$key]) ? (int)$_POST['variant_id'][$key] : 0;
                            $vSku = sanitize($_POST['variant_sku'][$key] ?? '');
                            $vPrice = (float)($_POST['variant_price'][$key] ?? 0);
                            $vStock = (int)($_POST['variant_stock'][$key] ?? 0);

                            if ($vId > 0) {
                                // Update existing
                                $updateVariantStmt->execute([
                                    'name' => sanitize($vName),
                                    'sku' => $vSku,
                                    'price' => $vPrice,
                                    'stock_quantity' => $vStock,
                                    'vid' => $vId,
                                    'product_id' => $id
                                ]);
                                $submittedVariantIds[] = $vId;
                            } else {
                                // Insert new
                                $insertVariantStmt->execute([
                                    'product_id' => $id,
                                    'name' => sanitize($vName),
                                    'sku' => $vSku,
                                    'price' => $vPrice,
                                    'stock_quantity' => $vStock
                                ]);
                                $submittedVariantIds[] = $this->db->lastInsertId();
                            }
                        }
                    }
                }

                // Delete variants that were removed in the UI
                if (!empty($submittedVariantIds)) {
                    $placeholders = implode(',', array_fill(0, count($submittedVariantIds), '?'));
                    $deleteStmt = $this->db->prepare("DELETE FROM product_variants WHERE product_id = ? AND id NOT IN ($placeholders)");
                    $params = array_merge([$id], $submittedVariantIds);
                    $deleteStmt->execute($params);
                } else {
                    // All variants were removed
                    $this->db->prepare("DELETE FROM product_variants WHERE product_id = :id")->execute(['id' => $id]);
                }

                $this->db->commit();
                setFlashMessage('success', 'Product updated successfully.');
                redirect('/admin/products');
            } catch (Exception $e) {
                $this->db->rollBack();
                error_log("Error updating product: " . $e->getMessage());
                setFlashMessage('error', 'Error updating product.');
            }
        }

        $pageTitle = "Edit Product | Admin Panel";
        require_once __DIR__ . '/../views/admin/products/edit.php';
    }

    public function delete($id) {
        // Validation of ownership
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();

        if (!$product || ($_SESSION['role'] !== 'admin' && $product['seller_id'] != $_SESSION['user_id'])) {
            setFlashMessage('error', 'Product not found or access denied.');
            redirect('/admin/products');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // We should also check if the product is in any orders before deleting it.
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM order_items WHERE product_id = :id");
                $stmt->execute(['id' => $id]);
                if ($stmt->fetchColumn() > 0) {
                    setFlashMessage('error', 'Cannot delete product because it is associated with existing orders. Consider making it inactive instead.');
                    redirect('/admin/products');
                }

                $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
                $stmt->execute(['id' => $id]);
                setFlashMessage('success', 'Product deleted successfully.');
            } catch (Exception $e) {
                setFlashMessage('error', 'Error deleting product.');
            }
        }
        redirect('/admin/products');
    }
}
?>