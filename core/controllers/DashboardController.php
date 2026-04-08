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

        require_once __DIR__ . '/../models/User.php';
        $userModel = new User($this->db);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = sanitize($_POST['name'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            $phone = sanitize($_POST['phone'] ?? null);
            $address = sanitize($_POST['address'] ?? null);

            // Update details
            if ($userModel->update($userId, $name, $email, $phone, $address)) {
                $_SESSION['user_name'] = $name;
                $_SESSION['name'] = $name; // Sync with AuthController logic
                setFlashMessage('success', 'Profile updated successfully.');
            } else {
                setFlashMessage('error', 'Could not update profile.');
            }

            // Update password if provided
            $password = $_POST['password'] ?? '';
            if (!empty($password)) {
                $userModel->updatePassword($userId, $password);
                setFlashMessage('success', 'Profile and password updated successfully.');
            }

            redirect('/dashboard');
            exit;
        }

        $user = $userModel->findById($userId);

        // Fetch user's orders
        $orders = $this->orderModel->getUserOrders($userId);

        $pageTitle = "My Dashboard | AAYU CARE";
        require_once __DIR__ . '/../views/storefront/dashboard.php';
    }
}
?>