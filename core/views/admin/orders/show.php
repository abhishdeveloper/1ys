<?php
// core/views/admin/orders/show.php
require_once __DIR__ . '/../partials/header.php';
?>

<div class="sm:flex sm:items-center mb-8">
    <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Order #<?php echo sanitize($order['order_number']); ?></h1>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="/admin/orders" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Back to Orders</a>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    <div class="lg:col-span-2 space-y-6">
        <!-- Items -->
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Order Items</h3>
            </div>
            <ul role="list" class="divide-y divide-gray-200">
                <?php foreach ($items as $item): ?>
                    <li class="p-4 sm:px-6 flex items-center">
                        <img src="<?php echo sanitize($item['image_url'] ?? 'https://via.placeholder.com/50'); ?>" alt="" class="w-16 h-16 rounded-md object-cover">
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-900"><?php echo sanitize($item['product_name']); ?></p>
                            <p class="text-sm text-gray-500">Qty: <?php echo $item['quantity']; ?></p>
                        </div>
                        <div class="text-sm font-medium text-gray-900">
                            $<?php echo number_format($item['total_price'], 2); ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Customer Details -->
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Customer & Shipping</h3>
            </div>
            <div class="px-4 py-5 sm:px-6 text-sm text-gray-700 space-y-2">
                <p><strong>Name:</strong> <?php echo sanitize($order['customer_name']); ?></p>
                <p><strong>Email:</strong> <?php echo sanitize($order['customer_email']); ?></p>
                <p><strong>Address:</strong><br> <?php echo sanitize($order['shipping_address']); ?></p>
            </div>
        </div>

        <!-- Order Management Form -->
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Manage Order</h3>
            </div>
            <div class="px-4 py-5 sm:px-6">
                <form action="/admin/orders/show?id=<?php echo $order['id']; ?>" method="POST" class="space-y-6">

                    <div>
                        <label for="order_status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="order_status" name="order_status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md border">
                            <?php
                            $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
                            foreach ($statuses as $st) {
                                $selected = $order['order_status'] === $st ? 'selected' : '';
                                echo "<option value=\"$st\" $selected>" . ucfirst($st) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="delivery_instructions" class="block text-sm font-medium text-gray-700">Delivery Instructions (Optional)</label>
                        <textarea id="delivery_instructions" name="delivery_instructions" rows="4" class="mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="E.g., Leave package at back door..."><?php echo sanitize($order['delivery_instructions'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                        Update Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>