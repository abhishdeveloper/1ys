<?php
// core/models/Category.php

class Category {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Get all active categories
     */
    public function getAllActive() {
        $stmt = $this->db->query("SELECT * FROM categories WHERE status = 1 ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    /**
     * Find a category by its slug
     */
    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE slug = :slug AND status = 1 LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }
}
?>