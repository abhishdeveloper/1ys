<?php
require_once __DIR__ . '/core/helpers/functions.php';
$settings = [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => '587',
    'smtp_user' => 'admin@example.com',
    'smtp_encryption' => 'tls',
    'smtp_from_name' => 'Store Admin',
    'smtp_from_email' => 'noreply@store.com'
];
require_once __DIR__ . '/core/views/admin/settings/index.php';
