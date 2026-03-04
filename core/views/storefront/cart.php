<?php
// core/views/storefront/cart.php
require_once __DIR__ . '/partials/header.php';
?>

<div class="mb-16">
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-8">Shopping Cart</h1>

    <?php if (empty($cartItems)): ?>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Your cart is empty</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Looks like you haven't added anything to your cart yet.</p>
            <div class="mt-6">
                <a href="/products" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Start Shopping
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="flex-grow">
                <ul role="list" class="border-t border-b border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($cartItems as $item):
                        $product = $item['product'];
                    ?>
                        <li class="flex py-6 sm:py-10">
                            <div class="flex-shrink-0">
                                <img src="<?php echo sanitize($product['image_url'] ?? 'https://via.placeholder.com/150'); ?>" alt="<?php echo sanitize($product['name']); ?>" class="w-24 h-24 rounded-md object-center object-cover sm:w-32 sm:h-32 border dark:border-gray-700">
                            </div>

                            <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                                <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                    <div>
                                        <div class="flex justify-between">
                                            <h3 class="text-lg">
                                                <a href="/product/<?php echo sanitize($product['slug']); ?>" class="font-medium text-gray-700 dark:text-white hover:text-gray-800">
                                                    <?php echo sanitize($product['name']); ?>
                                                </a>
                                            </h3>
                                        </div>
                                        <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-300">$<?php echo number_format($product['price'], 2); ?></p>
                                    </div>

                                    <div class="mt-4 sm:mt-0 sm:pr-9">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md w-24">
                                            <form action="/cart/update" method="POST" class="w-1/3">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <input type="hidden" name="action" value="decrease">
                                                <button type="submit" class="w-full h-full text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white px-2 py-1 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-primary rounded-l-md">
                                                    -
                                                </button>
                                            </form>
                                            <div class="w-1/3 text-center text-gray-900 dark:text-white py-1">
                                                <?php echo $item['quantity']; ?>
                                            </div>
                                            <form action="/cart/update" method="POST" class="w-1/3">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <input type="hidden" name="action" value="increase">
                                                <button type="submit" class="w-full h-full text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white px-2 py-1 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-primary rounded-r-md">
                                                    +
                                                </button>
                                            </form>
                                        </div>

                                        <div class="absolute top-0 right-0">
                                            <form action="/cart/remove" method="POST">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <button type="submit" class="-m-2 p-2 inline-flex text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Remove</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <p class="mt-4 flex text-sm text-gray-700 dark:text-gray-300 space-x-2">
                                    <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span>In stock</span>
                                </p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Order Summary -->
            <div class="lg:w-96 flex-shrink-0">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 px-4 py-6 sm:p-6 lg:p-8 sticky top-24">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Order summary</h2>

                    <dl class="mt-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">Subtotal</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">$<?php echo number_format($subtotal, 2); ?></dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4">
                            <dt class="text-base font-medium text-gray-900 dark:text-white">Order total</dt>
                            <dd class="text-base font-medium text-gray-900 dark:text-white">$<?php echo number_format($subtotal, 2); ?></dd>
                        </div>
                    </dl>

                    <div class="mt-6">
                        <a href="/checkout" class="w-full bg-primary border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-primary flex justify-center transition-colors">
                            Checkout
                        </a>
                    </div>
                    <div class="mt-6 text-sm text-center text-gray-500 dark:text-gray-400">
                        <p>
                            or <a href="/products" class="text-primary font-medium hover:text-indigo-500">Continue Shopping<span aria-hidden="true"> &rarr;</span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>