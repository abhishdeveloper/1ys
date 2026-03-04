<?php
// core/views/storefront/change_password.php
require_once __DIR__ . '/partials/header.php';
?>

<div class="flex items-center justify-center min-h-[60vh]">
<div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md w-full max-w-md border dark:border-gray-700">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white text-center">Change Password</h2>

    <form action="/change-password" method="POST" class="space-y-4">
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
            <input type="password" id="current_password" name="current_password" required
                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        </div>

        <div>
            <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
            <input type="password" id="new_password" name="new_password" required minlength="8"
                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
            <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters.</p>
        </div>

        <div>
            <label for="confirm_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required minlength="8"
                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                Update Password
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            <a href="/dashboard" class="font-medium text-primary hover:text-indigo-500">Back to Dashboard</a>
        </p>
    </div>
</div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>