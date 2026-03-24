<?php
// core/views/storefront/order_success.php
require_once __DIR__ . '/partials/header.php';
?>

<div class="mb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
        <div class="flex items-center justify-center mb-6">
            <div class="rounded-full bg-green-100 dark:bg-green-900 p-4">
                <svg class="h-16 w-16 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl mb-4">
            Thank You for Your Order!
        </h1>
        <p class="text-lg text-gray-500 dark:text-gray-400 mb-8">
            Your order <strong>#<?php echo sanitize($order['order_number']); ?></strong> has been successfully placed. We will send you an email confirmation shortly.
        </p>

        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 sm:p-8 shadow-sm text-left">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b dark:border-gray-700 pb-4">Order Details</h2>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Order Number</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white font-medium">#<?php echo sanitize($order['order_number']); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date Placed</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white font-medium"><?php echo date('F j, Y', strtotime($order['created_at'])); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Amount</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white font-medium">₹<?php echo number_format($order['total_amount'], 2); ?></dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Shipping Address</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white font-medium"><?php echo sanitize($order['shipping_address']); ?></dd>
                </div>
                <?php if (!empty($order['delivery_instructions'])): ?>
                <div class="sm:col-span-2 border-t dark:border-gray-700 pt-4 mt-2">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Delivery Instructions</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo nl2br(sanitize($order['delivery_instructions'])); ?></dd>
                </div>
                <?php endif; ?>
            </dl>

            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Items Ordered</h3>
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($order['items'] as $item): ?>
                        <li class="py-4 flex justify-between">
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    <?php echo sanitize($item['product_name']); ?>
                                </p>
                                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">x<?php echo $item['quantity']; ?></span>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">₹<?php echo number_format($item['total_price'], 2); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="/order/invoice?id=<?php echo $order['id']; ?>" target="_blank" class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 shadow-sm text-base font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Download Invoice
            </a>
            <a href="/dashboard" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                View Dashboard
            </a>
            <a href="/products" class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 shadow-sm text-base font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                Continue Shopping
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>