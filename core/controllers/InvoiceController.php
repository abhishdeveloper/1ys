<?php
// core/controllers/InvoiceController.php

require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../libs/fpdf/fpdf.php';

class InvoiceController {
    private $db;
    private $orderModel;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->orderModel = new Order($db);

        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }
    }

    public function generate($orderId) {
        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        // If admin/seller, they can view any invoice. If customer, only their own.
        // For simplicity, let's allow admins/sellers to bypass user restriction by fetching differently,
        // or just use a generic query.

        if ($role === 'admin' || $role === 'seller') {
            $stmt = $this->db->prepare("SELECT o.*, u.name as customer_name, u.email as customer_email FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = :id LIMIT 1");
            $stmt->execute(['id' => $orderId]);
            $order = $stmt->fetch();

            if ($order) {
                // Fetch items and check seller ownership
                $stmt = $this->db->prepare("SELECT oi.*, p.seller_id, p.name as product_name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = :order_id");
                $stmt->execute(['order_id' => $orderId]);
                $items = $stmt->fetchAll();

                if ($role === 'seller') {
                    $hasItem = false;
                    foreach ($items as $item) {
                        if ($item['seller_id'] == $userId) {
                            $hasItem = true;
                            break;
                        }
                    }
                    if (!$hasItem) {
                        http_response_code(403);
                        die("Access denied to this order's invoice.");
                    }
                }

                $order['items'] = $items;
            }
        } else {
            $order = $this->orderModel->findById($orderId, $userId);
            if ($order) {
                $stmt = $this->db->prepare("SELECT name, email FROM users WHERE id = :id");
                $stmt->execute(['id' => $userId]);
                $u = $stmt->fetch();
                $order['customer_name'] = $u['name'];
                $order['customer_email'] = $u['email'];
            }
        }

        if (!$order) {
            http_response_code(404);
            die("Order not found or access denied.");
        }

        require_once __DIR__ . '/../helpers/InvoiceGenerator.php';
        InvoiceGenerator::generate($order, 'I');
    }
}
?>