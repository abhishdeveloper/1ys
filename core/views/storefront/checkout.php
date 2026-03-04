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
                <?php if (isset($discountAmount) && $discountAmount > 0): ?>
                <div class="flex items-center justify-between">
                    <dt class="text-sm text-green-600 dark:text-green-400">
                        Discount (<?php echo sanitize($_SESSION['coupon']['code']); ?>)
                    </dt>
                    <dd class="text-sm font-medium text-green-600 dark:text-green-400">-$<?php echo number_format($discountAmount, 2); ?></dd>
                </div>
                <?php endif; ?>
                <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4">
                    <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                    <dd class="text-base font-bold text-gray-900 dark:text-white">$<?php echo number_format($total, 2); ?></dd>
                </div>
            </dl>
        </div>

        <!-- Checkout Form Column -->
        <div class="lg:col-span-7 order-1 lg:order-2">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-8">Checkout</h1>

            <!-- Coupon Code Section -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm mb-8">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Have a Coupon?</h2>
                <?php if (isset($_SESSION['coupon'])): ?>
                    <div class="flex items-center justify-between bg-green-50 dark:bg-green-900/30 p-4 rounded-md border border-green-200 dark:border-green-800">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-green-800 dark:text-green-300 font-medium">
                                <?php echo sanitize($_SESSION['coupon']['code']); ?> applied!
                            </span>
                        </div>
                        <form action="/coupon/remove" method="POST">
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium focus:outline-none">
                                Remove
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <form action="/coupon/apply" method="POST" class="flex gap-4">
                        <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
                        <input type="text" name="coupon_code" placeholder="Enter coupon code (e.g., WELCOME10)" required
                            class="flex-1 block w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm uppercase">
                        <button type="submit" class="bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-white px-4 py-2 border border-gray-300 dark:border-gray-500 rounded-md shadow-sm hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary font-medium text-sm">
                            Apply
                        </button>
                    </form>
                <?php endif; ?>
            </div>

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