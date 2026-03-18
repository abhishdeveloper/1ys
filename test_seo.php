<?php
$_SERVER['HTTP_HOST'] = 'myaayucare.com';
$_SERVER['REQUEST_URI'] = '/product/my-item';
$pageTitle = "Test Page";
$product = [
    'id' => 1,
    'name' => 'Awesome Balm',
    'description' => 'Best balm',
    'image_url' => 'http://example.com/img.jpg',
    'price' => '100.00',
    'stock_quantity' => 10
];

require_once __DIR__ . '/core/helpers/functions.php';
$db = new PDO('mysql:host=localhost;dbname=shopswift', 'root', '');
require_once __DIR__ . '/core/views/storefront/partials/header.php';
