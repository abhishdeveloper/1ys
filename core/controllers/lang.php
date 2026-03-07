<?php
require_once __DIR__ . '/../helpers/functions.php';

startSession();

$lang = $_GET['lang'] ?? 'en';
if (in_array($lang, ['en', 'hi'])) {
    $_SESSION['lang'] = $lang;
}

// Redirect back to referring page or home
$redirectUrl = $_SERVER['HTTP_REFERER'] ?? '/';
header("Location: " . $redirectUrl);
exit;
