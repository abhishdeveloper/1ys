<?php
// core/views/admin/settings/index.php
require_once __DIR__ . '/../partials/header.php';
?>

<div class="sm:flex sm:items-center mb-8">
    <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Site Settings</h1>
        <p class="mt-2 text-sm text-gray-700">Manage global site settings, logo, and promotional banners.</p>
    </div>
</div>

<form action="/admin/settings" method="POST" enctype="multipart/form-data" class="space-y-8 divide-y divide-gray-200 bg-white p-8 rounded-lg shadow max-w-3xl">
    <div class="space-y-8 divide-y divide-gray-200">
        <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">Brand Identity</h3>
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                <div class="sm:col-span-6">
                    <label class="block text-sm font-medium text-gray-700"> Current Logo </label>
                    <div class="mt-2 mb-4 p-4 border border-gray-200 rounded bg-gray-50 flex items-center justify-center">
                        <?php if(!empty($settings['site_logo'])): ?>
                            <img src="<?php echo htmlspecialchars($settings['site_logo']); ?>" alt="Current Logo" class="h-16 object-contain">
                        <?php else: ?>
                            <span class="text-gray-400">No logo uploaded</span>
                        <?php endif; ?>
                    </div>

                    <label for="site_logo" class="block text-sm font-medium text-gray-700"> Upload New Logo </label>
                    <div class="mt-1 flex items-center">
                        <input type="file" id="site_logo" name="site_logo" accept="image/*" class="shadow-sm block w-full sm:text-sm border-gray-300 p-2">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Leave empty to keep current logo. Recommended height: 40px - 80px.</p>
                </div>
            </div>
        </div>

        <div class="pt-8">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Promotional Banner (Typewriter)</h3>
            <p class="mt-1 text-sm text-gray-500">These 3 messages will cycle in the top banner of the website.</p>
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-6">
                    <label for="promo_banner_1" class="block text-sm font-medium text-gray-700"> Message 1 </label>
                    <div class="mt-1">
                        <input type="text" name="promo_banner_1" id="promo_banner_1" value="<?php echo htmlspecialchars($settings['promo_banner_1'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>
                <div class="sm:col-span-6">
                    <label for="promo_banner_2" class="block text-sm font-medium text-gray-700"> Message 2 </label>
                    <div class="mt-1">
                        <input type="text" name="promo_banner_2" id="promo_banner_2" value="<?php echo htmlspecialchars($settings['promo_banner_2'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>
                <div class="sm:col-span-6">
                    <label for="promo_banner_3" class="block text-sm font-medium text-gray-700"> Message 3 </label>
                    <div class="mt-1">
                        <input type="text" name="promo_banner_3" id="promo_banner_3" value="<?php echo htmlspecialchars($settings['promo_banner_3'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Contact Information</h3>
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="contact_whatsapp" class="block text-sm font-medium text-gray-700"> WhatsApp Number </label>
                    <div class="mt-1">
                        <input type="text" name="contact_whatsapp" id="contact_whatsapp" value="<?php echo htmlspecialchars($settings['contact_whatsapp'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border" placeholder="e.g. 919876543210">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Include country code without '+'</p>
                </div>
                <div class="sm:col-span-3">
                    <label for="contact_email" class="block text-sm font-medium text-gray-700"> Contact Email </label>
                    <div class="mt-1">
                        <input type="email" name="contact_email" id="contact_email" value="<?php echo htmlspecialchars($settings['contact_email'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Google OAuth (Login with Google)</h3>
            <p class="mt-1 text-sm text-gray-500">Configure your Google OAuth 2.0 credentials for user authentication.</p>
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                <div class="sm:col-span-3">
                    <label for="google_client_id" class="block text-sm font-medium text-gray-700"> Client ID </label>
                    <div class="mt-1">
                        <input type="text" name="google_client_id" id="google_client_id" value="<?php echo htmlspecialchars($settings['google_client_id'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="google_client_secret" class="block text-sm font-medium text-gray-700"> Client Secret </label>
                    <div class="mt-1">
                        <input type="password" name="google_client_secret" id="google_client_secret" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border" placeholder="Leave blank to keep current">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Callback URL: <?php echo getBaseUrl() . '/auth/google/callback'; ?></p>
                </div>
            </div>
        </div>

        <div class="pt-8">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Razorpay Payment Gateway</h3>
            <p class="mt-1 text-sm text-gray-500">Configure your Razorpay API credentials for online payments.</p>
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                <div class="sm:col-span-3">
                    <label for="razorpay_key_id" class="block text-sm font-medium text-gray-700"> Key ID </label>
                    <div class="mt-1">
                        <input type="text" name="razorpay_key_id" id="razorpay_key_id" value="<?php echo htmlspecialchars($settings['razorpay_key_id'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="razorpay_key_secret" class="block text-sm font-medium text-gray-700"> Key Secret </label>
                    <div class="mt-1">
                        <input type="password" name="razorpay_key_secret" id="razorpay_key_secret" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border" placeholder="Leave blank to keep current">
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Shiprocket Integration</h3>
            <p class="mt-1 text-sm text-gray-500">Configure your Shiprocket API credentials for automated tracking updates.</p>
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                <div class="sm:col-span-3">
                    <label for="shiprocket_email" class="block text-sm font-medium text-gray-700"> Shiprocket Email </label>
                    <div class="mt-1">
                        <input type="email" name="shiprocket_email" id="shiprocket_email" value="<?php echo htmlspecialchars($settings['shiprocket_email'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="shiprocket_password" class="block text-sm font-medium text-gray-700"> Shiprocket Password </label>
                    <div class="mt-1">
                        <input type="password" name="shiprocket_password" id="shiprocket_password" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border" placeholder="Leave blank to keep current">
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Email SMTP Configuration</h3>
            <p class="mt-1 text-sm text-gray-500">Configure mail server credentials to enable automated system emails.</p>
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                <div class="sm:col-span-4">
                    <label for="smtp_host" class="block text-sm font-medium text-gray-700"> SMTP Host </label>
                    <div class="mt-1">
                        <input type="text" name="smtp_host" id="smtp_host" value="<?php echo htmlspecialchars($settings['smtp_host'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border" placeholder="smtp.gmail.com">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="smtp_port" class="block text-sm font-medium text-gray-700"> SMTP Port </label>
                    <div class="mt-1">
                        <input type="text" name="smtp_port" id="smtp_port" value="<?php echo htmlspecialchars($settings['smtp_port'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border" placeholder="587">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="smtp_user" class="block text-sm font-medium text-gray-700"> SMTP Username </label>
                    <div class="mt-1">
                        <input type="text" name="smtp_user" id="smtp_user" value="<?php echo htmlspecialchars($settings['smtp_user'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="smtp_password" class="block text-sm font-medium text-gray-700"> SMTP Password </label>
                    <div class="mt-1">
                        <input type="password" name="smtp_password" id="smtp_password" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border" placeholder="Leave blank to keep current">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">If using Gmail, use an App Password.</p>
                </div>

                <div class="sm:col-span-2">
                    <label for="smtp_encryption" class="block text-sm font-medium text-gray-700"> Encryption </label>
                    <div class="mt-1">
                        <select id="smtp_encryption" name="smtp_encryption" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                            <option value="tls" <?php echo ($settings['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : ''; ?>>TLS</option>
                            <option value="ssl" <?php echo ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                            <option value="none" <?php echo ($settings['smtp_encryption'] ?? '') === 'none' ? 'selected' : ''; ?>>None</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="smtp_from_name" class="block text-sm font-medium text-gray-700"> From Name </label>
                    <div class="mt-1">
                        <input type="text" name="smtp_from_name" id="smtp_from_name" value="<?php echo htmlspecialchars($settings['smtp_from_name'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="smtp_from_email" class="block text-sm font-medium text-gray-700"> From Email </label>
                    <div class="mt-1">
                        <input type="email" name="smtp_from_email" id="smtp_from_email" value="<?php echo htmlspecialchars($settings['smtp_from_email'] ?? ''); ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="pt-5">
        <div class="flex justify-end">
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none">Save Settings</button>
        </div>
    </div>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>