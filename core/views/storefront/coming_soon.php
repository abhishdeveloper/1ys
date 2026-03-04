<?php
// core/views/storefront/coming_soon.php
require_once __DIR__ . '/partials/header.php';
?>

<div class="flex flex-col items-center justify-center min-h-[50vh] text-center">
    <div class="rounded-full bg-indigo-50 p-6 mb-6">
        <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
    </div>
    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">Coming Soon</h1>
    <p class="text-xl mt-4 text-gray-600 dark:text-gray-400">We are currently working hard to bring you this feature. Check back later!</p>
    <a href="/" class="mt-8 px-6 py-3 bg-primary text-white rounded-md hover:bg-indigo-700 transition-colors">Return Home</a>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>