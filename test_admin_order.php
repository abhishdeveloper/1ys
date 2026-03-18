<?php
require_once __DIR__ . '/core/helpers/functions.php';
$order = [
    'id' => 1,
    'order_number' => 'ORD-12345',
    'customer_name' => 'John Doe',
    'customer_email' => 'john@example.com',
    'shipping_address' => '123 Test St, NY',
    'order_status' => 'pending',
    'delivery_instructions' => '',
    'awb_code' => '',
    'tracking_url' => ''
];
$items = [
    ['product_name' => 'Test Item', 'quantity' => 1, 'total_price' => 20.00, 'image_url' => '']
];
require_once __DIR__ . '/core/views/admin/orders/show.php';
