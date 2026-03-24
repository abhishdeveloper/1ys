<?php
// core/views/admin/coupons/edit.php
require_once __DIR__ . '/../partials/header.php';
?>

<div class="sm:flex sm:items-center mb-8">
    <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Edit Coupon: <?php echo sanitize($coupon['code']); ?></h1>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="/admin/coupons" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">Back</a>
    </div>
</div>

<form action="/admin/coupons/edit?id=<?php echo $coupon['id']; ?>" method="POST" class="space-y-8 divide-y divide-gray-200 bg-white p-8 rounded-lg shadow">
    <div class="space-y-8 divide-y divide-gray-200">
        <div>
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                <div class="sm:col-span-3">
                    <label for="code" class="block text-sm font-medium text-gray-700"> Coupon Code </label>
                    <div class="mt-1">
                        <input type="text" name="code" id="code" value="<?php echo sanitize($coupon['code']); ?>" required class="uppercase shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="discount_type" class="block text-sm font-medium text-gray-700"> Discount Type </label>
                    <div class="mt-1">
                        <select id="discount_type" name="discount_type" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                            <option value="percentage" <?php echo $coupon['discount_type'] == 'percentage' ? 'selected' : ''; ?>>Percentage (%)</option>
                            <option value="fixed" <?php echo $coupon['discount_type'] == 'fixed' ? 'selected' : ''; ?>>Fixed Amount (₹)</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="discount_value" class="block text-sm font-medium text-gray-700"> Discount Value </label>
                    <div class="mt-1">
                        <input type="number" step="0.01" name="discount_value" id="discount_value" value="<?php echo $coupon['discount_value']; ?>" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="min_order_value" class="block text-sm font-medium text-gray-700"> Minimum Order Value (₹) </label>
                    <div class="mt-1">
                        <input type="number" step="0.01" name="min_order_value" id="min_order_value" value="<?php echo $coupon['min_order_value']; ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="max_discount" class="block text-sm font-medium text-gray-700"> Max Discount ($) - Optional </label>
                    <div class="mt-1">
                        <input type="number" step="0.01" name="max_discount" id="max_discount" value="<?php echo $coupon['max_discount']; ?>" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="usage_limit" class="block text-sm font-medium text-gray-700"> Usage Limit (Total times code can be used) </label>
                    <div class="mt-1">
                        <input type="number" name="usage_limit" id="usage_limit" value="<?php echo $coupon['usage_limit']; ?>" placeholder="Leave blank for unlimited" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Currently used: <?php echo $coupon['times_used']; ?> times</p>
                </div>

                <div class="sm:col-span-6">
                    <div class="flex items-start">
                        <div class="flex h-5 items-center">
                            <input id="is_active" name="is_active" type="checkbox" <?php echo $coupon['is_active'] ? 'checked' : ''; ?> class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_active" class="font-medium text-gray-700">Active</label>
                            <p class="text-gray-500">Customers can use this coupon.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="pt-5">
        <div class="flex justify-end">
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none">Update Coupon</button>
        </div>
    </div>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>