<?php
// core/controllers/AdminCouponController.php

class AdminCouponController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;

        $role = $_SESSION['role'] ?? '';
        if ($role !== 'admin') {
            setFlashMessage('error', 'Only administrators can manage coupons.');
            redirect('/admin');
        }
    }

    public function index() {
        $stmt = $this->db->query("SELECT * FROM coupons ORDER BY created_at DESC");
        $coupons = $stmt->fetchAll();

        $pageTitle = "Manage Coupons | Admin Panel";
        require_once __DIR__ . '/../views/admin/coupons/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = strtoupper(sanitize($_POST['code']));
            $type = sanitize($_POST['discount_type']);
            $value = (float)$_POST['discount_value'];
            $minOrder = (float)$_POST['min_order_value'];
            $maxDiscount = !empty($_POST['max_discount']) ? (float)$_POST['max_discount'] : null;
            $usageLimit = !empty($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : null;
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            try {
                $stmt = $this->db->prepare("
                    INSERT INTO coupons (code, discount_type, discount_value, min_order_value, max_discount, usage_limit, is_active)
                    VALUES (:code, :type, :val, :min, :max, :limit, :active)
                ");
                $stmt->execute([
                    'code' => $code,
                    'type' => $type,
                    'val' => $value,
                    'min' => $minOrder,
                    'max' => $maxDiscount,
                    'limit' => $usageLimit,
                    'active' => $isActive
                ]);
                setFlashMessage('success', 'Coupon created successfully.');
                redirect('/admin/coupons');
            } catch (Exception $e) {
                if ($e->getCode() == 23000) {
                    setFlashMessage('error', 'Coupon code already exists.');
                } else {
                    setFlashMessage('error', 'Error creating coupon.');
                }
            }
        }

        $pageTitle = "Add Coupon | Admin Panel";
        require_once __DIR__ . '/../views/admin/coupons/create.php';
    }

    public function edit($id) {
        $stmt = $this->db->prepare("SELECT * FROM coupons WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $coupon = $stmt->fetch();

        if (!$coupon) {
            setFlashMessage('error', 'Coupon not found.');
            redirect('/admin/coupons');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = strtoupper(sanitize($_POST['code']));
            $type = sanitize($_POST['discount_type']);
            $value = (float)$_POST['discount_value'];
            $minOrder = (float)$_POST['min_order_value'];
            $maxDiscount = !empty($_POST['max_discount']) ? (float)$_POST['max_discount'] : null;
            $usageLimit = !empty($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : null;
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            try {
                $stmt = $this->db->prepare("
                    UPDATE coupons
                    SET code = :code, discount_type = :type, discount_value = :val,
                        min_order_value = :min, max_discount = :max, usage_limit = :limit, is_active = :active
                    WHERE id = :id
                ");
                $stmt->execute([
                    'code' => $code,
                    'type' => $type,
                    'val' => $value,
                    'min' => $minOrder,
                    'max' => $maxDiscount,
                    'limit' => $usageLimit,
                    'active' => $isActive,
                    'id' => $id
                ]);
                setFlashMessage('success', 'Coupon updated successfully.');
                redirect('/admin/coupons');
            } catch (Exception $e) {
                setFlashMessage('error', 'Error updating coupon. Code may already exist.');
            }
        }

        $pageTitle = "Edit Coupon | Admin Panel";
        require_once __DIR__ . '/../views/admin/coupons/edit.php';
    }
}
?>