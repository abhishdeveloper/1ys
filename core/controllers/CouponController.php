<?php
// core/controllers/CouponController.php

require_once __DIR__ . '/../models/Coupon.php';

class CouponController {
    private $db;
    private $couponModel;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->couponModel = new Coupon($db);
    }

    public function apply() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/checkout');
        }

        $code = sanitize($_POST['coupon_code'] ?? '');
        $subtotal = (float)($_POST['subtotal'] ?? 0);

        if (empty($code)) {
            setFlashMessage('error', 'Please enter a coupon code.');
            redirect('/checkout');
        }

        $coupon = $this->couponModel->findByCode($code);

        if (!$coupon) {
            setFlashMessage('error', 'Invalid or expired coupon code.');
            redirect('/checkout');
        }

        if ($subtotal < $coupon['min_order_value']) {
            setFlashMessage('error', 'This coupon requires a minimum order value of $' . number_format($coupon['min_order_value'], 2) . '.');
            redirect('/checkout');
        }

        // Coupon is valid, store it in the session
        $_SESSION['coupon'] = [
            'id' => $coupon['id'],
            'code' => $coupon['code'],
            'discount_type' => $coupon['discount_type'],
            'discount_value' => $coupon['discount_value'],
            'min_order_value' => $coupon['min_order_value'],
            'max_discount' => $coupon['max_discount']
        ];

        setFlashMessage('success', 'Coupon applied successfully!');
        redirect('/checkout');
    }

    public function remove() {
        if (isset($_SESSION['coupon'])) {
            unset($_SESSION['coupon']);
            setFlashMessage('success', 'Coupon removed.');
        }
        redirect('/checkout');
    }
}
?>