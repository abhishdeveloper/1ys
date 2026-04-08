<?php
// core/helpers/ShiprocketHelper.php

class ShiprocketHelper {
    private $db;
    private $email;
    private $password;
    private $token = null;
    private $baseUrl = 'https://apiv2.shiprocket.in/v1/payload';

    public function __construct() {
        $this->db = getDB();

        $stmt = $this->db->query("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('shiprocket_email', 'shiprocket_password')");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        $this->email = $settings['shiprocket_email'] ?? '';
        $this->password = $settings['shiprocket_password'] ?? '';
    }

    /**
     * Authenticate and get token
     */
    private function authenticate() {
        if ($this->token) {
            return $this->token;
        }

        if (empty($this->email) || empty($this->password)) {
            return false;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . '/user/login/email');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'email' => $this->email,
            'password' => $this->password
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        if (isset($data['token'])) {
            $this->token = $data['token'];
            return $this->token;
        }

        return false;
    }

    /**
     * Create a custom order payload for Shiprocket
     */
    public function createOrder($orderId) {
        $token = $this->authenticate();
        if (!$token) return false;

        $stmt = $this->db->prepare("
            SELECT o.*, u.name as customer_name, u.email as customer_email, u.phone as customer_phone
            FROM orders o
            JOIN users u ON o.user_id = u.id
            WHERE o.id = :id
        ");
        $stmt->execute(['id' => $orderId]);
        $order = $stmt->fetch();

        if (!$order) return false;

        $itemsStmt = $this->db->prepare("
            SELECT oi.*, p.name, p.sku, pv.weight_kg
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            LEFT JOIN product_variants pv ON oi.variant_id = pv.id
            WHERE oi.order_id = :id
        ");
        $itemsStmt->execute(['id' => $orderId]);
        $items = $itemsStmt->fetchAll();

        // Extract shipping info from comma separated string: Address, City, State, Pincode
        $addressParts = array_map('trim', explode(',', $order['shipping_address']));
        $pincode = array_pop($addressParts);
        $state = array_pop($addressParts);
        $city = array_pop($addressParts);
        $addressLine = implode(', ', $addressParts);

        $orderItems = [];
        $totalWeight = 0;
        foreach ($items as $item) {
            $weight = floatval($item['weight_kg'] ?? 0.5); // default 500g
            $totalWeight += ($weight * $item['quantity']);
            $orderItems[] = [
                "name" => $item['name'],
                "sku" => $item['sku'] ?? 'SKU-'.$item['product_id'],
                "units" => $item['quantity'],
                "selling_price" => $item['price'],
                "discount" => "",
                "tax" => "",
                "hsn" => ""
            ];
        }

        if ($totalWeight == 0) $totalWeight = 0.5;

        $payload = [
            "order_id" => $order['order_number'],
            "order_date" => date('Y-m-d H:i', strtotime($order['created_at'])),
            "pickup_location" => "Primary",
            "billing_customer_name" => $order['customer_name'],
            "billing_last_name" => "",
            "billing_address" => $addressLine,
            "billing_address_2" => "",
            "billing_city" => $city,
            "billing_pincode" => $pincode,
            "billing_state" => $state,
            "billing_country" => "India",
            "billing_email" => $order['customer_email'],
            "billing_phone" => $order['customer_phone'] ?? '9999999999',
            "shipping_is_billing" => true,
            "order_items" => $orderItems,
            "payment_method" => "Prepaid",
            "sub_total" => $order['total_amount'],
            "length" => 10,
            "breadth" => 10,
            "height" => 10,
            "weight" => $totalWeight
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . '/orders/create/adhoc');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['order_id']) && isset($result['shipment_id'])) {
            // Success, update our database with tracking info
            $trackingUrl = 'https://shiprocket.co/tracking/' . $result['shipment_id'];

            $updateStmt = $this->db->prepare("UPDATE orders SET tracking_url = :url, order_status = 'shipped' WHERE id = :id");
            $updateStmt->execute(['url' => $trackingUrl, 'id' => $orderId]);
            return true;
        }

        error_log("Shiprocket Error: " . print_r($result, true));
        return false;
    }
}
?>