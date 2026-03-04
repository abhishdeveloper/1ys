<?php
// core/helpers/InvoiceGenerator.php

require_once __DIR__ . '/../libs/fpdf/fpdf.php';

class InvoiceGenerator {

    /**
     * Generates a PDF invoice.
     * @param array $order The order details
     * @param string $dest The destination mode ('I' for inline browser, 'S' to return as string)
     * @return string The PDF document content (if $dest='S') or outputs directly (if $dest='I').
     */
    public static function generate($order, $dest = 'I') {
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

        return $pdf->Output($dest, 'Invoice_' . $order['order_number'] . '.pdf');
    }
}
?>