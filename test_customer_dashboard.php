<?php
session_start();
require_once __DIR__ . '/core/helpers/functions.php';

$db = new PDO('mysql:host=localhost;dbname=shopswift', 'root', '');
$stmt = $db->query("SELECT setting_key, setting_value FROM settings");
$settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$user = ['name' => 'John Doe', 'email' => 'john@example.com', 'created_at' => date('Y-m-d')];
$orders = [
    [
        'id' => 1,
        'order_number' => 'ORD-12345',
        'created_at' => date('Y-m-d H:i:s'),
        'total_amount' => 50.00,
        'order_status' => 'shipped',
        'tracking_url' => 'https://shiprocket.co/track/123456789'
    ]
];
require_once __DIR__ . '/core/views/storefront/dashboard.php';
