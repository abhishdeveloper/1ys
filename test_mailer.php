<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configure Mailhog for testing
$db = new PDO('mysql:host=localhost;dbname=shopswift', 'root', '');
$db->query("UPDATE settings SET setting_value = 'localhost' WHERE setting_key = 'smtp_host'");
$db->query("UPDATE settings SET setting_value = '1025' WHERE setting_key = 'smtp_port'");
$db->query("UPDATE settings SET setting_value = 'none' WHERE setting_key = 'smtp_encryption'");

require_once __DIR__ . '/core/helpers/Mailer.php';
$mailer = new Mailer();

echo "Testing sendAccountCreationEmail...\n";
$res1 = $mailer->sendAccountCreationEmail('test@example.com', 'Test User');
if ($res1) {
    echo "Account creation email initiated successfully.\n";
} else {
    echo "Account creation email failed.\n";
}
