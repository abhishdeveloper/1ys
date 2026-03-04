<?php
// core/controllers/CategoryController.php

require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    private $db;
    private $categoryModel;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->categoryModel = new Category($db);
    }

    public function index() {
        // Fetch all active categories
        $categories = $this->categoryModel->getAllActive();

        // Load the view
        $pageTitle = "All Categories | ShopSwift";
        require_once __DIR__ . '/../views/storefront/categories.php';
    }
}
?>