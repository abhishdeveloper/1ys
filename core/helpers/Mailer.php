<?php
// core/helpers/Mailer.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../libs/phpmailer/Exception.php';
require_once __DIR__ . '/../libs/phpmailer/PHPMailer.php';
require_once __DIR__ . '/../libs/phpmailer/SMTP.php';

class Mailer {

    private function getMailer() {
        $mail = new PHPMailer(true);

        try {
            // Fetch dynamic SMTP settings from the database
            $db = new PDO('mysql:host=localhost;dbname=shopswift', 'root', '');
            $stmt = $db->query("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'smtp_%'");
            $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

            $host = $settings['smtp_host'] ?? 'localhost';
            $port = $settings['smtp_port'] ?? 1025;
            $user = $settings['smtp_user'] ?? '';
            $pass = $settings['smtp_password'] ?? '';
            $encryption = $settings['smtp_encryption'] ?? 'tls';
            $fromEmail = $settings['smtp_from_email'] ?? 'noreply@aayucare.com';
            $fromName = $settings['smtp_from_name'] ?? 'Aayu Care';

            // Server settings
            $mail->isSMTP();
            $mail->Host       = $host;
            $mail->SMTPAuth   = !empty($user) && !empty($pass);
            $mail->Username   = $user;
            $mail->Password   = $pass;

            if ($mail->SMTPAuth) {
                if (strtolower($encryption) === 'ssl') {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                } else {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                }
            } else {
                $mail->SMTPSecure = '';
                $mail->SMTPAutoTLS = false;
            }

            $mail->Port       = (int)$port;

            $mail->setFrom($fromEmail, $fromName);

            return $mail;
        } catch (Exception $e) {
            error_log("Mailer configuration error: " . $e->getMessage());
            return false;
        }
    }

    public function sendPasswordChangeEmail($toEmail, $toName) {
        $mail = $this->getMailer();
        if (!$mail) return false;

        try {
            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);
            $mail->Subject = 'Security Alert: Password Changed';
            $mail->Body    = "
                <h2>Hello {$toName},</h2>
                <p>This is a security notification to confirm that your password for ShopSwift has been successfully changed.</p>
                <p>If you did not initiate this change, please contact our support team immediately.</p>
                <br>
                <p><strong>The ShopSwift Team</strong></p>
            ";
            $mail->AltBody = "Hello {$toName}, your ShopSwift password has been successfully changed. If you did not initiate this, contact support immediately.";

            return $mail->send();
        } catch (Exception $e) {
            error_log("Failed to send password change email to {$toEmail}: {$mail->ErrorInfo}");
            return false;
        }
    }

    public function sendAccountCreationEmail($toEmail, $toName) {
        $mail = $this->getMailer();
        if (!$mail) return false;

        try {
            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to ShopSwift!';
            $mail->Body    = "
                <h2>Welcome to ShopSwift, {$toName}!</h2>
                <p>Your account has been successfully created.</p>
                <p>You can now browse our catalog, manage your orders, and track your shipments from your personalized dashboard.</p>
                <br>
                <p>Happy Shopping!</p>
                <p><strong>The ShopSwift Team</strong></p>
            ";
            $mail->AltBody = "Welcome to ShopSwift, {$toName}! Your account has been successfully created. Happy Shopping!";

            return $mail->send();
        } catch (Exception $e) {
            error_log("Failed to send welcome email to {$toEmail}: {$mail->ErrorInfo}");
            return false;
        }
    }

    public function sendOrderConfirmationEmail($toEmail, $toName, $orderData) {
        $mail = $this->getMailer();
        if (!$mail) return false;

        try {
            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);
            $mail->Subject = "Order Confirmation - #" . $orderData['order_number'];

            $body = "<h2>Thank you for your order, {$toName}!</h2>";
            $body .= "<p>We have received your order <strong>#{$orderData['order_number']}</strong> and it is currently being processed.</p>";
            $body .= "<h3>Order Details:</h3>";
            $body .= "<ul>";
            $body .= "<li><strong>Total Amount:</strong> $" . number_format($orderData['total_amount'], 2) . "</li>";
            $body .= "<li><strong>Shipping Address:</strong> {$orderData['shipping_address']}</li>";
            if (!empty($orderData['delivery_instructions'])) {
                $body .= "<li><strong>Delivery Instructions:</strong> {$orderData['delivery_instructions']}</li>";
            }
            $body .= "</ul>";
            $body .= "<p>We have attached a copy of your invoice to this email for your records.</p>";
            $body .= "<p>We will notify you once your order has shipped.</p>";
            $body .= "<br><p><strong>The ShopSwift Team</strong></p>";

            $mail->Body = $body;
            $mail->AltBody = "Thank you for your order! Order number: {$orderData['order_number']}. Total: $" . number_format($orderData['total_amount'], 2);

            // Generate and attach PDF invoice
            require_once __DIR__ . '/InvoiceGenerator.php';
            $pdfContent = InvoiceGenerator::generate($orderData, 'S'); // 'S' returns the document as a string
            $mail->addStringAttachment($pdfContent, 'Invoice_' . $orderData['order_number'] . '.pdf', 'base64', 'application/pdf');

            return $mail->send();
        } catch (Exception $e) {
            error_log("Failed to send order confirmation email to {$toEmail}: {$mail->ErrorInfo}");
            return false;
        }
    }

    public function sendOrderStatusUpdateEmail($toEmail, $toName, $orderNumber, $newStatus) {
        $mail = $this->getMailer();
        if (!$mail) return false;

        try {
            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);
            $mail->Subject = "Order Status Update - #" . $orderNumber;

            $statusText = ucfirst($newStatus);
            $mail->Body = "
                <h2>Order Update</h2>
                <p>Hello {$toName},</p>
                <p>The status of your order <strong>#{$orderNumber}</strong> has been updated to: <strong>{$statusText}</strong>.</p>
                <p>You can check your dashboard for more details.</p>
                <br>
                <p><strong>The ShopSwift Team</strong></p>
            ";
            $mail->AltBody = "Hello {$toName}, the status of your order #{$orderNumber} is now: {$statusText}.";

            return $mail->send();
        } catch (Exception $e) {
            error_log("Failed to send status update email to {$toEmail}: {$mail->ErrorInfo}");
            return false;
        }
    }
}
?>