<?php
// core/controllers/HomeController.php

class HomeController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function index() {
        // Fetch featured/active categories
        $stmt = $this->db->query("SELECT * FROM categories WHERE status = 1 ORDER BY name ASC LIMIT 6");
        $categories = $stmt->fetchAll();

        // Fetch latest active products for the homepage
        $stmt = $this->db->query("
            SELECT p.*, c.name as category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.is_active = 1
            ORDER BY p.created_at DESC
            LIMIT 8
        ");
        $featuredProducts = $stmt->fetchAll();

        // Load the view
        $pageTitle = "ShopSwift | Modern Shopping Simplified";
        require_once __DIR__ . '/../views/storefront/home.php';
    }
}
?>