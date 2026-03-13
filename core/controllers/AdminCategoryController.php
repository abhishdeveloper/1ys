<?php
// core/controllers/AdminCategoryController.php

class AdminCategoryController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;

        $role = $_SESSION['role'] ?? '';
        if ($role !== 'admin') {
            redirect('/login');
        }
    }

    public function index() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY created_at DESC");
        $categories = $stmt->fetchAll();

        $pageTitle = "Manage Categories | Admin Panel";
        require_once __DIR__ . '/../views/admin/categories/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = sanitize($_POST['name']);
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
            $description = sanitize($_POST['description']);

            try {
                $stmt = $this->db->prepare("INSERT INTO categories (name, slug, description) VALUES (:name, :slug, :description)");
                $stmt->execute([
                    'name' => $name,
                    'slug' => $slug,
                    'description' => $description
                ]);
                setFlashMessage('success', 'Category created successfully.');
                redirect('/admin/categories');
            } catch (Exception $e) {
                setFlashMessage('error', 'Error creating category. Slug might already exist.');
            }
        }

        $pageTitle = "Add Category | Admin Panel";
        require_once __DIR__ . '/../views/admin/categories/create.php';
    }

    public function edit($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $category = $stmt->fetch();

        if (!$category) {
            setFlashMessage('error', 'Category not found.');
            redirect('/admin/categories');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = sanitize($_POST['name']);
            $description = sanitize($_POST['description']);
            $status = isset($_POST['status']) ? 1 : 0;

            try {
                $stmt = $this->db->prepare("UPDATE categories SET name = :name, description = :description, status = :status WHERE id = :id");
                $stmt->execute([
                    'name' => $name,
                    'description' => $description,
                    'status' => $status,
                    'id' => $id
                ]);
                setFlashMessage('success', 'Category updated successfully.');
                redirect('/admin/categories');
            } catch (Exception $e) {
                setFlashMessage('error', 'Error updating category.');
            }
        }

        $pageTitle = "Edit Category | Admin Panel";
        require_once __DIR__ . '/../views/admin/categories/edit.php';
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Check if category is used in products
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM products WHERE category_id = :id");
                $stmt->execute(['id' => $id]);
                if ($stmt->fetchColumn() > 0) {
                    setFlashMessage('error', 'Cannot delete category. It is being used by products.');
                    redirect('/admin/categories');
                }

                $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
                $stmt->execute(['id' => $id]);
                setFlashMessage('success', 'Category deleted successfully.');
            } catch (Exception $e) {
                setFlashMessage('error', 'Error deleting category.');
            }
        }
        redirect('/admin/categories');
    }
}
?>