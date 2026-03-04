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
                $stmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
                $stmt->execute(['order_id' => $orderId]);
                $order['items'] = $stmt->fetchAll();
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

        $this->buildPdf($order);
    }

    private function buildPdf($order) {
        $pdf = new FPDF();
        $pdf->AddPage();

        // Header
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(100, 10, 'ShopSwift', 0, 0, 'L');

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(90, 10, 'INVOICE', 0, 1, 'R');
        $pdf->Ln(10);

        // Store Details
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(100, 5, '123 E-Commerce Blvd.', 0, 0, 'L');
        $pdf->Cell(90, 5, 'Order Number: ' . $order['order_number'], 0, 1, 'R');

        $pdf->Cell(100, 5, 'Suite 400', 0, 0, 'L');
        $pdf->Cell(90, 5, 'Date: ' . date('F j, Y', strtotime($order['created_at'])), 0, 1, 'R');

        $pdf->Cell(100, 5, 'Tech City, TC 12345', 0, 0, 'L');
        $pdf->Cell(90, 5, 'Status: ' . ucfirst($order['order_status']), 0, 1, 'R');
        $pdf->Ln(15);

        // Customer Details
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 8, 'Bill To:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(190, 5, $order['customer_name'], 0, 1, 'L');
        $pdf->Cell(190, 5, $order['customer_email'], 0, 1, 'L');
        $pdf->MultiCell(190, 5, $order['shipping_address'], 0, 'L');
        $pdf->Ln(10);

        // Items Table Header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(90, 8, 'Item', 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'Price', 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'Qty', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Total', 1, 1, 'C', true);

        // Items Table Body
        $pdf->SetFont('Arial', '', 10);
        foreach ($order['items'] as $item) {
            $pdf->Cell(90, 8, mb_strimwidth($item['product_name'], 0, 45, '...'), 1, 0, 'L');
            $pdf->Cell(30, 8, '$' . number_format($item['unit_price'], 2), 1, 0, 'R');
            $pdf->Cell(30, 8, $item['quantity'], 1, 0, 'C');
            $pdf->Cell(40, 8, '$' . number_format($item['total_price'], 2), 1, 1, 'R');
        }

        $pdf->Ln(5);

        // Totals
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(150, 8, 'Shipping:', 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 8, '$' . number_format($order['shipping_cost'], 2), 0, 1, 'R');

        if ($order['discount_amount'] > 0) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(150, 8, 'Discount:', 0, 0, 'R');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(40, 8, '-$' . number_format($order['discount_amount'], 2), 0, 1, 'R');
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(150, 10, 'Total:', 0, 0, 'R');
        $pdf->Cell(40, 10, '$' . number_format($order['total_amount'], 2), 0, 1, 'R');

        // Output to browser
        $pdf->Output('I', 'Invoice_' . $order['order_number'] . '.pdf');
    }
}
?>