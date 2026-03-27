<?php
// helpers/functions.php - Global utility functions

/**
 * Clean user input to prevent XSS
 */
function sanitize($string) {
    return htmlspecialchars(trim((string)($string ?? '')), ENT_QUOTES, 'UTF-8');
}

/**
 * Basic routing utility based on URL path
 */
function redirect($path) {
    header("Location: /" . ltrim($path, '/'));
    exit();
}

/**
 * Start a secure session
 */
function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        // Secure session cookie settings
        session_set_cookie_params([
            'lifetime' => 86400, // 1 day
            'path' => '/',
            'domain' => '',
            'secure' => isset($_SERVER['HTTPS']), // True if HTTPS
            'httponly' => true, // Accessible only through the HTTP protocol
            'samesite' => 'Strict' // Protects against CSRF
        ]);
        session_start();
    }
}

/**
 * Regenerate session ID to prevent fixation attacks
 */
function regenerateSession() {
    startSession();
    session_regenerate_id(true);
}

/**
 * Add a flash message
 */
function setFlashMessage($type, $message) {
    startSession();
    $_SESSION['flash'][$type] = $message;
}

/**
 * Get and clear flash messages
 */
function getFlashMessages() {
    startSession();
    if (isset($_SESSION['flash'])) {
        $messages = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $messages;
    }
    return [];
}

/**
 * Handle Language Settings & Translations
 */
function __($key, $default = null) {
    startSession();
    $lang = $_SESSION['lang'] ?? 'en';

    // Simple caching for translations to avoid multiple file reads per request
    static $translations = [];
    if (!isset($translations[$lang])) {
        $langFile = __DIR__ . '/../lang/' . $lang . '.php';
        if (file_exists($langFile)) {
            $translations[$lang] = require $langFile;
        } else {
            // fallback to en
            $translations[$lang] = require __DIR__ . '/../lang/en.php';
        }
    }

    return $translations[$lang][$key] ?? ($default ?? ucfirst(str_replace('_', ' ', $key)));
}
?>