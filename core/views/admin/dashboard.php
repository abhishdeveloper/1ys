<?php
// core/views/admin/dashboard.php
require_once __DIR__ . '/partials/header.php';
?>

<h1 class="text-2xl font-semibold text-gray-900">Dashboard Overview</h1>

<div class="mt-8">
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

        <!-- Total Orders -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900"><?php echo (int)$stats['total_orders']; ?></div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="/admin/orders" class="font-medium text-indigo-700 hover:text-indigo-900">View all</a>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900">$<?php echo number_format($stats['total_revenue'], 2); ?></div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="/admin/orders" class="font-medium text-indigo-700 hover:text-indigo-900">View orders</a>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Products Listed</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900"><?php echo (int)$stats['total_products']; ?></div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="/admin/products" class="font-medium text-indigo-700 hover:text-indigo-900">Manage products</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Traffic Analytics Section (Admin Only) -->
    <?php if ($_SESSION['role'] === 'admin'): ?>
    <h2 class="text-xl font-semibold text-gray-900 mt-12 mb-6">Traffic Analytics</h2>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg p-5">
            <dt class="text-sm font-medium text-gray-500 truncate">Total Page Views</dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo number_format($stats['total_visits']); ?></dd>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg p-5">
            <dt class="text-sm font-medium text-gray-500 truncate">Unique Visitors (IPs)</dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo number_format($stats['unique_visitors']); ?></dd>
        </div>
    </div>

    <!-- Top Pages Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Most Visited Pages</h3>
            <p class="mt-1 text-sm text-gray-500">Top 5 landing spots by hit count.</p>
        </div>
        <ul role="list" class="divide-y divide-gray-200">
            <?php if (!empty($stats['top_pages'])): ?>
                <?php foreach ($stats['top_pages'] as $page): ?>
                <li class="px-4 py-4 sm:px-6 flex items-center justify-between">
                    <div class="text-sm font-medium text-indigo-600 truncate"><?php echo htmlspecialchars($page['page_url']); ?></div>
                    <div class="ml-2 flex-shrink-0 flex">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            <?php echo number_format($page['views']); ?> views
                        </span>
                    </div>
                </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="px-4 py-4 sm:px-6 text-sm text-gray-500">No traffic data yet.</li>
            <?php endif; ?>
        </ul>
    </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>