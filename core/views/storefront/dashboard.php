<?php
// core/views/storefront/dashboard.php
require_once __DIR__ . '/partials/header.php';
?>

<div class="mb-16">
    <div class="max-w-7xl mx-auto sm:px-2 lg:px-8">
        <div class="max-w-2xl mx-auto px-4 lg:max-w-4xl lg:px-0 flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-3xl">My Dashboard</h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Manage your orders and account settings.</p>
            </div>
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'seller'): ?>
                <a href="/admin" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary_hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Go to <?php echo ucfirst($_SESSION['role']); ?> Panel
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-10 max-w-7xl mx-auto sm:px-2 lg:px-8">
        <div class="max-w-2xl mx-auto px-4 lg:max-w-4xl lg:px-0">
            <!-- Account Settings Form -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-10">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Profile Information</h3>
                    <div class="mt-2 max-w-xl text-sm text-gray-500 dark:text-gray-400">
                        <p>Update your account details and password.</p>
                    </div>
                    <form class="mt-5 sm:flex sm:items-center" method="POST" action="/dashboard">
                        <div class="w-full sm:max-w-xs space-y-4">
                            <div>
                                <label for="name" class="sr-only">Name</label>
                                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="John Doe" required>
                            </div>
                            <div>
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="you@example.com" required>
                            </div>
                            <div>
                                <label for="phone" class="sr-only">Phone</label>
                                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Phone Number">
                            </div>
                            <div>
                                <label for="address" class="sr-only">Address</label>
                                <textarea name="address" id="address" rows="2" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                            </div>
                            <div>
                                <label for="password" class="sr-only">New Password (leave blank to keep current)</label>
                                <input type="password" name="password" id="password" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="New Password (Optional)">
                            </div>
                            <button type="submit" class="mt-3 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-primary hover:bg-primary_hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:w-auto sm:text-sm">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-2xl mb-6">Recent orders</h2>
        </div>
    </div>

    <div class="mt-4">
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

                            <!-- View Details Link -->
                            <div class="p-4 sm:p-6 bg-white dark:bg-gray-800 flex justify-between items-center flex-wrap gap-4">
                                <div class="flex items-center space-x-4">
                                    <a href="/order/success?id=<?php echo $order['id']; ?>" class="text-sm font-medium text-primary hover:text-indigo-500 flex items-center">
                                        View Receipt
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>

                                    <?php if (!empty($order['tracking_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($order['tracking_url']); ?>" target="_blank" class="text-sm font-medium text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 flex items-center border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 px-3 py-1 rounded-full">
                                            Track Order
                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <a href="/order/invoice?id=<?php echo $order['id']; ?>" target="_blank" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-white flex items-center">
                                    <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Invoice PDF
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