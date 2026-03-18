<?php
// core/controllers/AdminOrderController.php

class AdminOrderController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;

        $role = $_SESSION['role'] ?? '';
        if ($role !== 'admin' && $role !== 'seller') {
            redirect('/login');
        }
    }

    public function index() {
        $role = $_SESSION['role'];
        $userId = $_SESSION['user_id'];

        if ($role === 'admin') {
            $stmt = $this->db->query("
                SELECT o.*, u.name as customer_name
                FROM orders o
                JOIN users u ON o.user_id = u.id
                ORDER BY o.created_at DESC
            ");
            $orders = $stmt->fetchAll();
        } else {
            // Seller sees orders that contain at least one of their products
            $stmt = $this->db->prepare("
                SELECT DISTINCT o.*, u.name as customer_name
                FROM orders o
                JOIN users u ON o.user_id = u.id
                JOIN order_items oi ON o.id = oi.order_id
                JOIN products p ON oi.product_id = p.id
                WHERE p.seller_id = :seller_id
                ORDER BY o.created_at DESC
            ");
            $stmt->execute(['seller_id' => $userId]);
            $orders = $stmt->fetchAll();
        }

        $pageTitle = "Manage Orders | Admin Panel";
        require_once __DIR__ . '/../views/admin/orders/index.php';
    }

    public function show($id) {
        $role = $_SESSION['role'];
        $userId = $_SESSION['user_id'];

        // Fetch Order
        $stmt = $this->db->prepare("
            SELECT o.*, u.name as customer_name, u.email as customer_email
            FROM orders o
            JOIN users u ON o.user_id = u.id
            WHERE o.id = :id
        ");
        $stmt->execute(['id' => $id]);
        $order = $stmt->fetch();

        if (!$order) {
            setFlashMessage('error', 'Order not found.');
            redirect('/admin/orders');
        }

        // Fetch Items. If seller, ideally only show their items, but for context showing full order is fine,
        // we'll fetch all items but maybe mark which ones belong to them.
        $stmt = $this->db->prepare("
            SELECT oi.*, p.seller_id, p.image_url
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :order_id
        ");
        $stmt->execute(['order_id' => $id]);
        $items = $stmt->fetchAll();

        // Validation for seller: must have at least one item in this order
        if ($role === 'seller') {
            $hasItem = false;
            foreach ($items as $item) {
                if ($item['seller_id'] == $userId) {
                    $hasItem = true;
                    break;
                }
            }
            if (!$hasItem) {
                setFlashMessage('error', 'Access denied to this order.');
                redirect('/admin/orders');
            }
        }

        // Handle Update Post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = sanitize($_POST['order_status']);
            $instructions = sanitize($_POST['delivery_instructions'] ?? '');
            $awbCode = sanitize($_POST['awb_code'] ?? '');
            $trackingUrl = sanitize($_POST['tracking_url'] ?? '');

            // Generate Shiprocket tracking URL if AWB is provided and tracking URL is not
            if (!empty($awbCode) && empty($trackingUrl)) {
                require_once __DIR__ . '/../helpers/Shiprocket.php';
                $shiprocket = new Shiprocket();
                $generatedUrl = $shiprocket->getTrackingUrlByAwb($awbCode);
                if ($generatedUrl) {
                    $trackingUrl = $generatedUrl;
                }
            }

            try {
                $stmt = $this->db->prepare("UPDATE orders SET order_status = :status, delivery_instructions = :instructions, awb_code = :awb, tracking_url = :track WHERE id = :id");
                $stmt->execute([
                    'status' => $status,
                    'instructions' => $instructions,
                    'awb' => $awbCode,
                    'track' => $trackingUrl,
                    'id' => $id
                ]);

                // If the status changed, send an email update
                if ($status !== $order['order_status']) {
                    require_once __DIR__ . '/../helpers/Mailer.php';
                    $mailer = new Mailer();
                    $mailer->sendOrderStatusUpdateEmail(
                        $order['customer_email'],
                        $order['customer_name'],
                        $order['order_number'],
                        $status
                    );
                }

                setFlashMessage('success', 'Order updated successfully.');
                redirect('/admin/orders/show?id=' . $id);
            } catch (Exception $e) {
                setFlashMessage('error', 'Error updating order.');
            }
        }

        $pageTitle = "Order Details | Admin Panel";
        require_once __DIR__ . '/../views/admin/orders/show.php';
    }
}
?>