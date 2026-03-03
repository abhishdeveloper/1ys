# PHP E-commerce Platform Architecture

This project is a high-performance, custom-built e-commerce platform developed from scratch in core PHP 8.x, tailored for a standard shared hosting environment (e.g., cPanel) where SSH/CLI access is restricted and Composer cannot be used.

## FTP Directory Structure

Since this is designed for shared hosting, all sensitive files (like database configurations and core application logic) are placed inside a `core` directory. This directory is heavily protected by `.htaccess` rules to block direct web access. All files that are meant to be publicly accessible (like images, CSS, JS, and the main `index.php` front controller) are placed in the public root.

```
/public_html
├── .htaccess                   <-- Main routing file (Clean URLs, basic security headers)
├── index.php                   <-- Main Front Controller (Handles all traffic)
├── assets/                     <-- Publicly accessible static files
│   ├── css/                    <-- Custom CSS (Tailwind CDN will be in HTML head)
│   ├── js/                     <-- Custom JS scripts (Vanilla JS / jQuery)
│   └── images/                 <-- Product images and site assets
├── core/                       <-- SENSITIVE: Contains backend logic, blocked from public access
│   ├── .htaccess               <-- Rule: "Require all denied" (Blocks HTTP access to this folder)
│   ├── config/
│   │   └── database.php        <-- SENSITIVE: PDO database connection & credentials
│   ├── helpers/                <-- Helper functions (Routing, Validation, Session handling)
│   ├── models/                 <-- Database interaction classes (User, Product, Order)
│   ├── controllers/            <-- Request handlers
│   ├── views/                  <-- HTML templates (Header, Footer, Product Pages, Dashboard)
│   │   ├── admin/              <-- Admin Dashboard templates
│   │   └── storefront/         <-- Customer-facing templates
│   └── libs/                   <-- Third-party standalone libraries (Manually downloaded)
│       ├── fpdf/               <-- FPDF library for generating PDF invoices
│       └── phpmailer/          <-- PHPMailer library for sending emails
└── uploads/                    <-- Dynamic file uploads (e.g., product images)
    └── .htaccess               <-- Security rule: Disable PHP execution in this folder
```

## Security Measures

1. **`core/.htaccess`:** Contains `Require all denied` to prevent any browser from directly loading files like `database.php`. Only PHP scripts running on the server can `require_once` them.
2. **`uploads/.htaccess`:** Contains rules to prevent the execution of PHP files. Even if a malicious user manages to upload a PHP shell masquerading as an image, the server will not execute it.
3. **`.env` Alternative:** Since we don't have Composer/dotenv, credentials will be stored directly in `core/config/database.php` as plain PHP variables, which is perfectly safe because the folder is inaccessible via HTTP.
4. **Prepared Statements:** The application purely uses PDO Prepared Statements for all database interactions to prevent SQL injection.
5. **XSS Protection:** Output will be escaped using `htmlspecialchars()` before rendering in views.
6. **Password Hashing:** Passwords are hashed using PHP's native `password_hash()` and verified with `password_verify()`.

## Third-Party Library Manual Setup

Because Composer is strictly prohibited, any external library must be manually downloaded and placed in the `core/libs/` directory.

### 1. FPDF (PDF Generation)
We will use FPDF to generate the professional tax invoices cleanly and quickly, without relying on complex external dependencies.

**Instructions:**
1. Download the latest release from the official website: http://www.fpdf.org/
2. Extract the downloaded ZIP file.
3. Upload the `fpdf.php` file and the `font/` directory to your FTP inside `/public_html/core/libs/fpdf/`.
4. Inclusion method: `require_once __DIR__ . '/core/libs/fpdf/fpdf.php';`

### 2. PHPMailer (Email Delivery)
Used for reliable email delivery (SMTP) to send the PDF invoice to customers.

**Instructions:**
1. Go to the PHPMailer GitHub Repository: https://github.com/PHPMailer/PHPMailer
2. Download the source code as a ZIP file (Code -> Download ZIP).
3. Extract the ZIP. You only need the files located inside the `src/` directory (`Exception.php`, `PHPMailer.php`, `SMTP.php`).
4. Upload these files to your FTP inside `/public_html/core/libs/phpmailer/`.
5. Inclusion method:
   ```php
   require_once __DIR__ . '/core/libs/phpmailer/Exception.php';
   require_once __DIR__ . '/core/libs/phpmailer/PHPMailer.php';
   require_once __DIR__ . '/core/libs/phpmailer/SMTP.php';
   ```

### 3. Razorpay (Payment Gateway)
We will **NOT** use the official Razorpay PHP SDK to avoid dragging in large dependencies. Instead, we will implement pure PHP cURL calls to the Razorpay API for backend verification. The frontend will utilize `Razorpay.js` loaded via CDN.

**Instructions:**
1. No backend download is required.
2. The logic for validating webhook signatures and capturing payments will be written purely in PHP using `curl_init()` inside a dedicated controller.