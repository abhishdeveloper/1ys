<?php
// core/views/storefront/checkout.php
require_once __DIR__ . '/partials/header.php';
?>

<div class="mb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-8 gap-y-10">
        <!-- Order Summary Column -->
        <div class="lg:col-span-5 bg-gray-50 dark:bg-gray-800 p-8 rounded-xl border border-gray-200 dark:border-gray-700 order-2 lg:order-1 sticky top-24">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Order Summary</h2>

            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php foreach ($cartItems as $item):
                    $product = $item['product'];
                ?>
                    <li class="flex py-4">
                        <div class="flex-1 flex flex-col justify-between">
                            <div class="flex justify-between">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                    <?php echo sanitize($product['name']); ?>
                                </h3>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    $<?php echo number_format($item['total'], 2); ?>
                                </p>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Qty <?php echo $item['quantity']; ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <dl class="mt-8 space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                <div class="flex items-center justify-between">
                    <dt class="text-sm text-gray-600 dark:text-gray-400">Subtotal</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">$<?php echo number_format($subtotal, 2); ?></dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-sm text-gray-600 dark:text-gray-400">Shipping Estimate</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">$<?php echo number_format($shipping, 2); ?></dd>
                </div>
                <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4">
                    <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                    <dd class="text-base font-bold text-gray-900 dark:text-white">$<?php echo number_format($total, 2); ?></dd>
                </div>
            </dl>
        </div>

        <!-- Checkout Form Column -->
        <div class="lg:col-span-7 order-1 lg:order-2">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-8">Checkout</h1>

            <form action="/checkout/process" method="POST" class="space-y-8">
                <!-- Shipping Details -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Shipping Information</h2>
                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div class="sm:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Street Address</label>
                            <input type="text" id="address" name="address" required
                                class="mt-1 block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                            <input type="text" id="city" name="city" required
                                class="mt-1 block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        </div>

                        <div>
                            <label for="zip" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ZIP / Postal Code</label>
                            <input type="text" id="zip" name="zip" required
                                class="mt-1 block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Payment Details (Dummy) -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Payment Method</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">This is a demo environment. No real credit card information is required or processed.</p>

                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-4 sm:gap-x-4">
                        <div class="sm:col-span-4">
                            <label for="card_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name on Card</label>
                            <input type="text" id="card_name" name="card_name" value="Demo User" readonly
                                class="mt-1 block w-full bg-gray-100 dark:bg-gray-600 border border-gray-300 dark:border-gray-500 text-gray-500 dark:text-gray-400 rounded-md shadow-sm py-2 px-3 focus:outline-none sm:text-sm cursor-not-allowed">
                        </div>

                        <div class="sm:col-span-4">
                            <label for="card_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Card Number</label>
                            <input type="text" id="card_number" name="card_number" value="**** **** **** 4242" readonly
                                class="mt-1 block w-full bg-gray-100 dark:bg-gray-600 border border-gray-300 dark:border-gray-500 text-gray-500 dark:text-gray-400 rounded-md shadow-sm py-2 px-3 focus:outline-none sm:text-sm cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full bg-primary border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-primary transition-colors">
                        Place Order (Demo)
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>