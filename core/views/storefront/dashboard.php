<?php
// core/views/storefront/dashboard.php
require_once __DIR__ . '/partials/header.php';
?>

<div class="mb-16">
    <div class="max-w-7xl mx-auto sm:px-2 lg:px-8">
        <div class="max-w-2xl mx-auto px-4 lg:max-w-4xl lg:px-0">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-3xl">Order history</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Check the status of recent orders, manage returns, and download invoices.</p>
        </div>
    </div>

    <div class="mt-16">
        <h2 class="sr-only">Recent orders</h2>
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-8">
            <div class="max-w-2xl mx-auto space-y-8 sm:px-4 lg:max-w-4xl lg:px-0">
                <?php if (empty($orders)): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No orders</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You haven't placed any orders yet.</p>
                        <div class="mt-6">
                            <a href="/products" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Start Shopping
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="bg-white dark:bg-gray-800 border-t border-b sm:rounded-lg sm:border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750 sm:p-6 sm:grid sm:grid-cols-4 sm:gap-x-6">
                                <dl class="grid grid-cols-2 gap-x-6 text-sm sm:col-span-3 sm:grid-cols-3 lg:col-span-2">
                                    <div>
                                        <dt class="font-medium text-gray-900 dark:text-white">Order number</dt>
                                        <dd class="mt-1 text-gray-500 dark:text-gray-400">
                                            <?php echo sanitize($order['order_number']); ?>
                                        </dd>
                                    </div>
                                    <div class="hidden sm:block">
                                        <dt class="font-medium text-gray-900 dark:text-white">Date placed</dt>
                                        <dd class="mt-1 text-gray-500 dark:text-gray-400">
                                            <time datetime="<?php echo $order['created_at']; ?>">
                                                <?php echo date('M j, Y', strtotime($order['created_at'])); ?>
                                            </time>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-900 dark:text-white">Total amount</dt>
                                        <dd class="mt-1 font-medium text-gray-900 dark:text-white">
                                            $<?php echo number_format($order['total_amount'], 2); ?>
                                        </dd>
                                    </div>
                                </dl>

                                <!-- Status Badge -->
                                <div class="mt-6 sm:mt-0 sm:col-span-1 lg:col-span-2 flex justify-end">
                                    <?php
                                    $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'; // Default pending
                                    if ($order['order_status'] === 'processing') {
                                        $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300';
                                    } elseif ($order['order_status'] === 'shipped') {
                                        $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300';
                                    } elseif ($order['order_status'] === 'delivered') {
                                        $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300';
                                    } elseif ($order['order_status'] === 'cancelled') {
                                        $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300';
                                    }
                                    ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo $statusClass; ?>">
                                        <?php echo ucfirst(sanitize($order['order_status'])); ?>
                                    </span>
                                </div>
                            </div>

                            <!-- View Details Link (Expanding order items can be added later, for now just link to the success receipt page) -->
                            <div class="p-4 sm:p-6 bg-white dark:bg-gray-800">
                                <a href="/order/success?id=<?php echo $order['id']; ?>" class="text-sm font-medium text-primary hover:text-indigo-500 flex items-center">
                                    View Receipt & Details
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>