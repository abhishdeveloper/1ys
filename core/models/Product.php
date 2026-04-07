<?php
// core/models/Product.php

class Product {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Get a single product by its slug, including rich data, variants, and reviews
     */
    public function findBySlug($slug) {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug,
                   (SELECT COALESCE(AVG(rating), 0) FROM reviews WHERE product_id = p.id AND status = 'approved') as average_rating,
                   (SELECT COUNT(id) FROM reviews WHERE product_id = p.id AND status = 'approved') as review_count
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.slug = :slug AND p.is_active = 1
            LIMIT 1
        ");
        $stmt->execute(['slug' => $slug]);
        $product = $stmt->fetch();

        if ($product) {
            $product['variants'] = $this->getVariants($product['id']);
            $product['reviews'] = $this->getApprovedReviews($product['id']);
        }

        return $product;
    }

    /**
     * Find a product by its ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = :id AND p.is_active = 1
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Get active variants for a product
     */
    public function getVariants($productId) {
        $stmt = $this->db->prepare("
            SELECT * FROM product_variants
            WHERE product_id = :product_id AND is_active = 1
            ORDER BY price ASC
        ");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll();
    }

    /**
     * Get a specific variant by ID
     */
    public function getVariantById($variantId) {
        $stmt = $this->db->prepare("SELECT * FROM product_variants WHERE id = :id AND is_active = 1 LIMIT 1");
        $stmt->execute(['id' => $variantId]);
        return $stmt->fetch();
    }

    /**
     * Get approved reviews for a product
     */
    public function getApprovedReviews($productId) {
        $stmt = $this->db->prepare("
            SELECT r.*, u.name as user_name
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.product_id = :product_id AND r.status = 'approved'
            ORDER BY r.created_at DESC
        ");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll();
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
            $query .= " AND (p.name LIKE :search1 OR p.description LIKE :search2)";
            $params['search1'] = '%' . $filters['search'] . '%';
            $params['search2'] = '%' . $filters['search'] . '%';
        }

        $query .= " ORDER BY p.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>