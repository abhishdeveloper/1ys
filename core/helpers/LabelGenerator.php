<?php
// core/helpers/LabelGenerator.php

require_once __DIR__ . '/../libs/fpdf/fpdf.php';

class LabelGenerator {

    /**
     * Generates a PDF shipping label.
     * @param array $order The order details
     * @param array $items The items in the order
     * @param string $dest The destination mode ('I' for inline browser, 'D' for download)
     */
    public static function generate($order, $items, $dest = 'I') {
        $pdf = new FPDF('P', 'mm', array(100, 150)); // Shipping label size (4x6 inches approx)
        $pdf->AddPage();

        // Sender info (From store settings or hardcoded default)
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, 'FROM: AAYU CARE', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, '123 E-Commerce Blvd, Suite 400', 0, 1, 'L');
        $pdf->Cell(0, 5, 'Tech City, TC 12345', 0, 1, 'L');

        $pdf->Line(10, 30, 90, 30);
        $pdf->Ln(10);

        // Recipient Info (SHIP TO)
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, 'SHIP TO:', 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, mb_strimwidth(strtoupper($order['customer_name']), 0, 40, ''), 0, 1, 'L');

        $pdf->SetFont('Arial', '', 10);
        // The shipping address now includes State and Pincode as it is saved as "Address, City, State, ZIP"
        $pdf->MultiCell(0, 6, $order['shipping_address'], 0, 'L');

        // Phone number if we had one could go here. We'll use email as fallback contact.
        $pdf->Cell(0, 6, 'Contact: ' . $order['customer_email'], 0, 1, 'L');

        $pdf->Line(10, 85, 90, 85);
        $pdf->Ln(5);

        // Order Info
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 6, 'Order #: ' . $order['order_number'], 0, 0, 'L');
        $pdf->Cell(40, 6, 'Date: ' . date('Y-m-d', strtotime($order['created_at'])), 0, 1, 'R');
        $pdf->Ln(5);

        // Product Details
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(65, 5, 'Item', 'B', 0, 'L');
        $pdf->Cell(15, 5, 'Qty', 'B', 1, 'C');

        $pdf->SetFont('Arial', '', 8);
        foreach ($items as $item) {
            $pdf->Cell(65, 5, mb_strimwidth($item['product_name'], 0, 40, '...'), 0, 0, 'L');
            $pdf->Cell(15, 5, $item['quantity'], 0, 1, 'C');
        }

        // Output
        $pdf->Output($dest, 'Shipping_Label_' . $order['order_number'] . '.pdf');
    }
}
?>