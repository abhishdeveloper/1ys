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
            // Fetch dynamic SMTP settings from the database using centralized function
            $db = getDB();
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
                <p>This is a security notification to confirm that your password for AAYU CARE has been successfully changed.</p>
                <p>If you did not initiate this change, please contact our support team immediately.</p>
                <br>
                <p><strong>The AAYU CARE Team</strong></p>
            ";
            $mail->AltBody = "Hello {$toName}, your AAYU CARE password has been successfully changed. If you did not initiate this, contact support immediately.";

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
            $mail->Subject = 'Welcome to AAYU CARE!';
            $mail->Body    = "
                <h2>Welcome to AAYU CARE, {$toName}!</h2>
                <p>Your account has been successfully created.</p>
                <p>You can now browse our catalog, manage your orders, and track your shipments from your personalized dashboard.</p>
                <br>
                <p>Happy Shopping!</p>
                <p><strong>The AAYU CARE Team</strong></p>
            ";
            $mail->AltBody = "Welcome to AAYU CARE, {$toName}! Your account has been successfully created. Happy Shopping!";

            return $mail->send();
        } catch (Exception $e) {
            error_log("Failed to send welcome email to {$toEmail}: {$mail->ErrorInfo}");
            return false;
        }
    }

    public function sendOrderConfirmationEmail($toEmail, $toName, $orderData, $isSeller = false) {
        $mail = $this->getMailer();
        if (!$mail) return false;

        try {
            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);

            if ($isSeller) {
                $mail->Subject = "New Order Received - #" . $orderData['order_number'];
                $greeting = "<h2>New Order Received!</h2><p>You have received a new order <strong>#{$orderData['order_number']}</strong> from {$orderData['customer_name']}.</p>";
            } else {
                $mail->Subject = "Order Confirmation - #" . $orderData['order_number'];
                $greeting = "<h2>Thank you, {$toName}!</h2><p>Your order is confirmed.<br>You'll receive an email when your order is ready.</p>";
            }

            // Generate Map HTML if coordinates exist
            $mapHtml = "";
            if (!empty($orderData['latitude']) && !empty($orderData['longitude'])) {
                $lat = $orderData['latitude'];
                $lng = $orderData['longitude'];
                // Use OpenStreetMap Static Map via MapQuest or a simple OSM embed link since true static requires an API key for most services.
                // We'll use an iframe link for webmail clients that support it, and a fallback link.
                $mapUrl = "https://www.openstreetmap.org/?mlat={$lat}&mlon={$lng}#map=15/{$lat}/{$lng}";
                // Since email clients block iframes, we use a static map generator URL.
                // Note: OSM doesn't have an official free high-traffic static map API, but MapQuest open provides one if registered.
                // We will use a generic placeholder or a constructed link for this demo.
                $staticMapUrl = "https://static-maps.yandex.ru/1.x/?lang=en-US&ll={$lng},{$lat}&z=14&l=map&size=600,300&pt={$lng},{$lat},pm2rdm";

                $mapHtml = "
                <div style='margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; font-family: sans-serif;'>
                    <a href='{$mapUrl}' target='_blank'>
                        <img src='{$staticMapUrl}' alt='Map Location' style='width: 100%; height: auto; display: block;' />
                    </a>
                    <div style='padding: 15px; background: #fff; text-align: center;'>
                        <p style='margin: 0; font-size: 16px; font-weight: bold;'>Shipping Address</p>
                        <p style='margin: 5px 0 0 0; color: #555;'>{$orderData['shipping_address']}</p>
                    </div>
                </div>";
            }

            $body = "<div style='max-w-xl mx-auto; font-family: Arial, sans-serif;'>";
            $body .= $mapHtml;
            $body .= $greeting;
            $body .= "<hr style='border: none; border-top: 1px solid #eee; margin: 20px 0;'>";
            $body .= "<h3>Order details</h3>";
            $body .= "<p><strong>Contact information</strong><br>{$orderData['customer_email']}</p>";
            $body .= "<p><strong>Shipping address</strong><br>" . nl2br(sanitize($orderData['shipping_address'])) . "</p>";
            $body .= "<p><strong>Payment method</strong><br>" . ucfirst($orderData['payment_method']) . " - ₹" . number_format($orderData['total_amount'], 2) . "</p>";
            if (!empty($orderData['delivery_instructions'])) {
                $body .= "<p><strong>Delivery Instructions:</strong> {$orderData['delivery_instructions']}</p>";
            }
            if (!$isSeller) {
                $body .= "<br><p style='text-align: center; color: #888;'>Need help? <a href='mailto:info@aayucare.com' style='color: #b89053;'>Contact us</a></p>";
            }
            $body .= "</div>";

            $mail->Body = $body;
            $mail->AltBody = "Order details: " . strip_tags($body);

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
                <p><strong>The AAYU CARE Team</strong></p>
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