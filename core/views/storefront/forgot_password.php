<?php
/**
 * Forgot Password View
 */
$pageTitle = "Forgot Password | ShopSwift";
require_once __DIR__ . '/partials/header.php';
?>

<div class="flex items-center justify-center min-h-[70vh]">
<div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md w-full max-w-md border dark:border-gray-700">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white text-center">Reset Password</h2>

    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 text-center">
        Enter your email address and we'll send you a temporary password to regain access to your account.
    </p>

    <form action="/forgot-password" method="POST" class="space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
            <input type="email" id="email" name="email" required
                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary_hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                Send Temporary Password
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Remembered your password? <a href="/login" class="font-medium text-primary hover:text-indigo-500">Log in</a>
        </p>
    </div>
</div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
