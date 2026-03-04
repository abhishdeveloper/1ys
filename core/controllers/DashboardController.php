<?php
// core/controllers/DashboardController.php

require_once __DIR__ . '/../models/Order.php';

class DashboardController {
    private $db;
    private $orderModel;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->orderModel = new Order($db);

        // User must be logged in
        if (!isset($_SESSION['user_id'])) {
            setFlashMessage('error', 'Please log in to access your dashboard.');
            redirect('/login');
        }
    }

    public function index() {
        $userId = $_SESSION['user_id'];

        // Fetch user's orders
        $orders = $this->orderModel->getUserOrders($userId);

        $pageTitle = "My Dashboard | ShopSwift";
        require_once __DIR__ . '/../views/storefront/dashboard.php';
    }
}
?>