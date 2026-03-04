<?php
// core/controllers/AdminController.php

class AdminController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;

        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        // Ensure user is an admin or seller
        $role = $_SESSION['role'] ?? 'customer';
        if ($role !== 'admin' && $role !== 'seller') {
            http_response_code(403);
            die("Access Denied: You do not have permission to view this area.");
        }
    }

    public function index() {
        $role = $_SESSION['role'];
        $userId = $_SESSION['user_id'];

        // Basic dashboard stats
        $stats = [
            'total_orders' => 0,
            'total_revenue' => 0,
            'total_products' => 0
        ];

        if ($role === 'admin') {
            $stmt = $this->db->query("SELECT COUNT(*) as count, SUM(total_amount) as revenue FROM orders");
            $row = $stmt->fetch();
            $stats['total_orders'] = $row['count'] ?? 0;
            $stats['total_revenue'] = $row['revenue'] ?? 0;

            $stmt = $this->db->query("SELECT COUNT(*) as count FROM products");
            $stats['total_products'] = $stmt->fetch()['count'] ?? 0;
        } else {
            // Seller stats
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM products WHERE seller_id = :seller_id");
            $stmt->execute(['seller_id' => $userId]);
            $stats['total_products'] = $stmt->fetch()['count'] ?? 0;

            // For orders, sellers see orders containing their products
            $stmt = $this->db->prepare("
                SELECT COUNT(DISTINCT o.id) as count, SUM(oi.total_price) as revenue
                FROM orders o
                JOIN order_items oi ON o.id = oi.order_id
                JOIN products p ON oi.product_id = p.id
                WHERE p.seller_id = :seller_id
            ");
            $stmt->execute(['seller_id' => $userId]);
            $row = $stmt->fetch();
            $stats['total_orders'] = $row['count'] ?? 0;
            $stats['total_revenue'] = $row['revenue'] ?? 0;
        }

        $pageTitle = "Dashboard | Admin Panel";
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }
}
?>