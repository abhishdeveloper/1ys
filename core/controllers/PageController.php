<?php
// core/controllers/PageController.php

class PageController {
    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Simple mock processing for contact form
            $name = sanitize($_POST['name'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            $message = sanitize($_POST['message'] ?? '');

            if (empty($name) || empty($email) || empty($message)) {
                setFlashMessage('error', 'All fields are required.');
            } else {
                // Here we would typically save to DB or send an email to admin
                // require_once __DIR__ . '/../helpers/Mailer.php'; ...
                setFlashMessage('success', 'Thank you for contacting us. We will get back to you shortly.');
            }
            redirect('/contact');
        }

        $pageTitle = "Contact Us | ShopSwift";
        require_once __DIR__ . '/../views/storefront/contact.php';
    }

    public function faq() {
        $pageTitle = "Frequently Asked Questions | ShopSwift";
        require_once __DIR__ . '/../views/storefront/faq.php';
    }
}
?>