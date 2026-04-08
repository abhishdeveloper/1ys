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
                        <img src="<?php echo sanitize($item['image_url'] ?? '/assets/images/placeholder.svg'); ?>" alt="" class="w-16 h-16 rounded-md object-cover">
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

        <!-- Shiprocket Integration -->
        <?php if ($order['order_status'] === 'processing' || $order['order_status'] === 'pending'): ?>
        <div class="bg-white shadow sm:rounded-lg mb-6 border border-blue-200">
            <div class="px-4 py-5 sm:px-6 bg-blue-50 border-b border-blue-200 sm:rounded-t-lg flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-blue-900">Shiprocket Automation</h3>
                <img src="https://sr-website.shiprocket.in/wp-content/uploads/2023/11/shiprocket-logo.webp" alt="Shiprocket" class="h-6 object-contain">
            </div>
            <div class="px-4 py-5 sm:px-6">
                <p class="text-sm text-gray-600 mb-4">Automatically create a shipment for this order in Shiprocket and generate an AWB & tracking URL.</p>
                <form action="/admin/orders/show?id=<?php echo $order['id']; ?>" method="POST">
                    <button type="submit" name="push_to_shiprocket" value="1" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Push to Shiprocket
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- Order Management Form -->
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Manage Order</h3>
            </div>
            <div class="px-4 py-5 sm:px-6">
                <form action="/admin/orders/show?id=<?php echo $order['id']; ?>" method="POST" class="space-y-6">

                    <div>
                        <label for="order_status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="order_status" name="order_status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md border" onchange="toggleShippingFields()">
                            <?php
                            $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
                            foreach ($statuses as $st) {
                                $selected = $order['order_status'] === $st ? 'selected' : '';
                                echo "<option value=\"$st\" $selected>" . ucfirst($st) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div id="shipping_fields" class="space-y-6 <?php echo ($order['order_status'] === 'shipped' || !empty($order['tracking_url'])) ? '' : 'hidden'; ?>">
                        <div>
                            <label for="tracking_url" class="block text-sm font-medium text-gray-700">Tracking URL</label>
                            <input type="url" id="tracking_url" name="tracking_url" value="<?php echo sanitize($order['tracking_url'] ?? ''); ?>" class="mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="https://...">
                            <p class="mt-1 text-xs text-gray-500">Automatically populated if pushed to Shiprocket.</p>
                        </div>
                    </div>

                    <div>
                        <label for="delivery_instructions" class="block text-sm font-medium text-gray-700">Delivery Instructions (Optional)</label>
                        <textarea id="delivery_instructions" name="delivery_instructions" rows="4" class="mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="E.g., Leave package at back door..."><?php echo sanitize($order['delivery_instructions'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary_hover focus:outline-none">
                        Update Order
                    </button>

                    <script>
                        function toggleShippingFields() {
                            const status = document.getElementById('order_status').value;
                            const trackingUrl = document.getElementById('tracking_url').value;
                            const fields = document.getElementById('shipping_fields');
                            if (status === 'shipped' || status === 'delivered' || trackingUrl !== '') {
                                fields.classList.remove('hidden');
                            } else {
                                fields.classList.add('hidden');
                            }
                        }
                        // Initialize on load just in case
                        document.addEventListener('DOMContentLoaded', toggleShippingFields);
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>