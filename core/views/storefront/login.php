<?php
/**
 * Customer Login View
 * Displays the login form and handles flash messages.
 */
$pageTitle = "Login | ShopSwift";
require_once __DIR__ . '/partials/header.php';
?>

<div class="flex items-center justify-center min-h-[70vh]">
<div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md w-full max-w-md border dark:border-gray-700">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white text-center">Log in to your Account</h2>

    <?php
    // Flash messages are now handled by the global header, so we don't need to duplicate them here unless preferred.
    ?>

    <form action="/login" method="POST" class="space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
            <input type="email" id="email" name="email" required
                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
            <input type="password" id="password" name="password" required
                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" name="remember_me" type="checkbox"
                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                    Remember me
                </label>
            </div>

            <div class="text-sm">
                <a href="/forgot-password" class="font-medium text-primary dark:text-accent hover:text-accent_hover dark:hover:text-white transition-colors">
                    Forgot your password?
                </a>
            </div>
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary_hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                Sign in
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Don't have an account? <a href="/register" class="font-medium text-primary dark:text-accent hover:text-accent_hover dark:hover:text-white transition-colors">Register here</a>
        </p>
    </div>
</div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
