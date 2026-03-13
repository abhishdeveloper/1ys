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

    </div>

    <div class="pt-5">
        <div class="flex justify-end">
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none">Save Settings</button>
        </div>
    </div>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>