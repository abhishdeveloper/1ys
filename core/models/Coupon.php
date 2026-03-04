<?php
// core/models/Coupon.php

class Coupon {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Find an active coupon by its code
     */
    public function findByCode($code) {
        $stmt = $this->db->prepare("
            SELECT * FROM coupons
            WHERE code = :code
            AND is_active = 1
            AND (valid_from IS NULL OR valid_from <= NOW())
            AND (valid_until IS NULL OR valid_until >= NOW())
            LIMIT 1
        ");
        $stmt->execute(['code' => strtoupper($code)]);
        $coupon = $stmt->fetch();

        if ($coupon) {
            // Check usage limits
            if ($coupon['usage_limit'] !== null && $coupon['times_used'] >= $coupon['usage_limit']) {
                return false; // Reached limit
            }
            return $coupon;
        }

        return false;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount($coupon, $subtotal) {
        // Check minimum order value
        if ($subtotal < $coupon['min_order_value']) {
            return 0;
        }

        $discount = 0;
        if ($coupon['discount_type'] === 'fixed') {
            $discount = min($subtotal, $coupon['discount_value']);
        } elseif ($coupon['discount_type'] === 'percentage') {
            $discount = ($subtotal * $coupon['discount_value']) / 100;
            // Cap at max discount if set
            if ($coupon['max_discount'] > 0) {
                $discount = min($discount, $coupon['max_discount']);
            }
        }

        return round($discount, 2);
    }
}
?>