<?php
// core/views/storefront/404.php
require_once __DIR__ . '/partials/header.php';
?>

<div class="flex flex-col items-center justify-center min-h-[50vh] text-center">
    <h1 class="text-6xl font-extrabold text-gray-900 dark:text-white">404</h1>
    <p class="text-2xl mt-4 text-gray-600 dark:text-gray-400">Oops! We couldn't find what you were looking for.</p>
    <a href="/" class="mt-8 px-6 py-3 bg-primary text-white rounded-md hover:bg-indigo-700 transition-colors">Return Home</a>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>