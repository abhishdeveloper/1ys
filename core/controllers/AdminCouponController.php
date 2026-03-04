<?php
// core/controllers/AdminCouponController.php

class AdminCouponController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;

        $role = $_SESSION['role'] ?? '';
        if ($role !== 'admin') {
            setFlashMessage('error', 'Only administrators can manage coupons.');
            redirect('/admin');
        }
    }

    public function index() {
        $stmt = $this->db->query("SELECT * FROM coupons ORDER BY created_at DESC");
        $coupons = $stmt->fetchAll();

        $pageTitle = "Manage Coupons | Admin Panel";
        require_once __DIR__ . '/../views/admin/coupons/index.php';
    }
}
?>