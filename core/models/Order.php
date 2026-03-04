<?php
// core/models/Order.php

class Order {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Create a new order
     * Returns the created order ID or false on failure.
     */
    public function create($userId, $orderData, $cartItems) {
        try {
            $this->db->beginTransaction();

            // Insert into orders table
            $stmt = $this->db->prepare("
                INSERT INTO orders (
                    user_id, order_number, total_amount, shipping_cost, discount_amount,
                    coupon_id, payment_method, payment_status, order_status, shipping_address, delivery_instructions
                ) VALUES (
                    :user_id, :order_number, :total_amount, :shipping_cost, :discount_amount,
                    :coupon_id, :payment_method, :payment_status, :order_status, :shipping_address, :delivery_instructions
                )
            ");

            $orderNumber = 'ORD-' . strtoupper(uniqid());

            $couponId = !empty($orderData['coupon_id']) ? $orderData['coupon_id'] : null;

            $stmt->execute([
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'total_amount' => $orderData['total_amount'],
                'shipping_cost' => $orderData['shipping_cost'] ?? 0,
                'discount_amount' => $orderData['discount_amount'] ?? 0,
                'coupon_id' => $couponId,
                'payment_method' => $orderData['payment_method'] ?? 'dummy',
                'payment_status' => $orderData['payment_status'] ?? 'pending',
                'order_status' => 'pending',
                'shipping_address' => $orderData['shipping_address'],
                'delivery_instructions' => $orderData['delivery_instructions'] ?? null
            ]);

            $orderId = $this->db->lastInsertId();

            // Insert order items
            $itemStmt = $this->db->prepare("
                INSERT INTO order_items (
                    order_id, product_id, product_name, quantity, unit_price, total_price
                ) VALUES (
                    :order_id, :product_id, :product_name, :quantity, :unit_price, :total_price
                )
            ");

            // Update product stock
            $stockStmt = $this->db->prepare("
                UPDATE products
                SET stock_quantity = stock_quantity - :quantity
                WHERE id = :id AND stock_quantity >= :quantity
            ");

            foreach ($cartItems as $item) {
                $itemStmt->execute([
                    'order_id' => $orderId,
                    'product_id' => $item['product']['id'],
                    'product_name' => $item['product']['name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['product']['price'],
                    'total_price' => $item['total']
                ]);

                $stockStmt->execute([
                    'quantity' => $item['quantity'],
                    'id' => $item['product']['id']
                ]);

                if ($stockStmt->rowCount() === 0) {
                    throw new Exception("Insufficient stock for product ID: " . $item['product']['id']);
                }
            }

            // Note: If a coupon was applied, update its usage count
            if (!empty($orderData['coupon_id'])) {
                $couponStmt = $this->db->prepare("UPDATE coupons SET times_used = times_used + 1 WHERE id = :id");
                $couponStmt->execute(['id' => $orderData['coupon_id']]);
            }

            $this->db->commit();
            return $orderId;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Order Creation Error: " . $e->getMessage());
            return false;
        }
    }

    public function findById($id, $userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = :id AND user_id = :user_id LIMIT 1");
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        $order = $stmt->fetch();

        if ($order) {
            $stmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
            $stmt->execute(['order_id' => $id]);
            $order['items'] = $stmt->fetchAll();
        }

        return $order;
    }

    public function getUserOrders($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
?>