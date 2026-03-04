<?php
// core/models/Product.php

class Product {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Get a single product by its slug
     */
    public function findBySlug($slug) {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.slug = :slug AND p.is_active = 1
            LIMIT 1
        ");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    /**
     * Get products with optional category filtering and search
     */
    public function getProducts($filters = []) {
        $query = "
            SELECT p.*, c.name as category_name, c.slug as category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.is_active = 1
        ";

        $params = [];

        // Category filter
        if (!empty($filters['category_id'])) {
            $query .= " AND p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        // Search text
        if (!empty($filters['search'])) {
            $query .= " AND (p.name LIKE :search OR p.description LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        $query .= " ORDER BY p.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>