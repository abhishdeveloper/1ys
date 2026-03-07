<?php
// core/views/storefront/products/show.php
require_once __DIR__ . '/../partials/header.php';
?>

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border dark:border-gray-700 overflow-hidden mb-16">
    <div class="pt-6 pb-16 sm:pb-24">
        <nav aria-label="Breadcrumb" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ol role="list" class="flex items-center space-x-2">
                <li>
                    <div class="flex items-center">
                        <a href="/products" class="mr-2 text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Shop</a>
                        <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-5 text-gray-300 dark:text-gray-600">
                            <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                        </svg>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <a href="/category/<?php echo sanitize($product['category_slug'] ?? 'uncategorized'); ?>" class="mr-2 text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                            <?php echo sanitize($product['category_name'] ?? 'Uncategorized'); ?>
                        </a>
                        <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-5 text-gray-300 dark:text-gray-600">
                            <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                        </svg>
                    </div>
                </li>
                <li class="text-sm">
                    <span aria-current="page" class="font-medium text-gray-900 dark:text-white"><?php echo sanitize($product['name']); ?></span>
                </li>
            </ol>
        </nav>

        <!-- JSON-LD Structured Data for Google Rich Snippets -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Product",
            "name": "<?php echo sanitize($product['name']); ?>",
            "image": "<?php echo sanitize($product['image_url'] ?? 'https://myaayucare.com/wp-content/uploads/2025/02/logoaayucare-2.png'); ?>",
            "description": "<?php echo sanitize($product['description']); ?>",
            "sku": "<?php echo sanitize($product['slug']); ?>",
            "brand": {
                "@type": "Brand",
                "name": "AAYU CARE"
            },
            "offers": {
                "@type": "Offer",
                "url": "<?php echo 'https://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>",
                "priceCurrency": "USD",
                "price": "<?php echo number_format($product['price'], 2, '.', ''); ?>",
                "availability": "<?php echo $product['stock_quantity'] > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock'; ?>"
            }
        }
        </script>

        <div class="mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 lg:grid lg:grid-cols-2 lg:gap-x-12">

            <!-- Product Gallery -->
            <div class="flex flex-col-reverse">
                <!-- Image selector (Mocked for single image but structured for gallery) -->
                <div class="hidden mt-6 w-full max-w-2xl mx-auto sm:block lg:max-w-none">
                    <div class="grid grid-cols-4 gap-6" aria-orientation="horizontal" role="tablist">
                        <button id="tabs-1-tab-1" class="relative h-24 bg-white dark:bg-gray-700 rounded-md flex items-center justify-center text-sm font-medium uppercase text-gray-900 cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-offset-4" aria-controls="tabs-1-panel-1" role="tab" type="button">
                            <span class="sr-only">Product image</span>
                            <span class="absolute inset-0 rounded-md overflow-hidden">
                                <img src="<?php echo sanitize($product['image_url'] ?? '/assets/images/placeholder.svg'); ?>" alt="" class="w-full h-full object-center object-cover">
                            </span>
                            <span class="ring-transparent absolute inset-0 rounded-md ring-2 ring-offset-2 pointer-events-none" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>

                <div class="w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm">
                    <img src="<?php echo sanitize($product['image_url'] ?? '/assets/images/placeholder.svg'); ?>" alt="<?php echo sanitize($product['name']); ?>" class="w-full h-full object-center object-cover">
                </div>
            </div>

            <!-- Product info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white"><?php echo sanitize($product['name']); ?></h1>

                <div class="mt-3">
                    <h2 class="sr-only">Product information</h2>
                    <p class="text-3xl text-gray-900 dark:text-white font-bold">$<?php echo number_format($product['price'], 2); ?></p>
                </div>

                <!-- Stock / Weight Info -->
                <div class="mt-6 flex flex-col gap-2">
                    <?php if ($product['stock_quantity'] > 0): ?>
                        <div class="flex items-center text-green-600 dark:text-green-400 font-medium">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            In Stock (<?php echo (int)$product['stock_quantity']; ?> available)
                        </div>
                    <?php else: ?>
                        <div class="flex items-center text-red-600 dark:text-red-400 font-medium">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Out of Stock
                        </div>
                    <?php endif; ?>

                    <?php if ($product['weight_kg'] > 0): ?>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Weight: <?php echo number_format($product['weight_kg'], 2); ?> kg
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-6">
                    <h3 class="sr-only">Description</h3>
                    <div class="text-base text-gray-700 dark:text-gray-300 space-y-6">
                        <p><?php echo nl2br(sanitize($product['description'])); ?></p>
                    </div>
                </div>

                <form action="/cart/add" method="POST" class="mt-8">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <!-- Quantity & Add to Cart -->
                    <div class="flex sm:flex-row mt-8 items-center gap-4">
                        <div class="w-24">
                            <label for="quantity" class="sr-only">Quantity</label>
                            <input type="number" id="quantity" name="quantity" min="1" max="<?php echo (int)$product['stock_quantity']; ?>" value="1"
                                class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md py-3 px-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <button type="submit" <?php echo $product['stock_quantity'] <= 0 ? 'disabled' : ''; ?>
                            class="max-w-xs flex-1 bg-primary border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-primary sm:w-full transition-colors <?php echo $product['stock_quantity'] <= 0 ? 'opacity-50 cursor-not-allowed' : ''; ?>">
                            Add to bag
                        </button>
                    </div>
                </form>

                <!-- Shipping / Returns Policy Snippet -->
                <section aria-labelledby="details-heading" class="mt-12 border-t dark:border-gray-700 pt-8">
                    <h2 id="details-heading" class="text-lg font-medium text-gray-900 dark:text-white mb-4">Shipping & Returns</h2>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2 list-disc pl-5">
                        <li>Free standard shipping on orders over $50</li>
                        <li>Estimated delivery: 3-5 business days</li>
                        <li>30-day return policy for unused items in original packaging</li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
<?php if (!empty($relatedProducts)): ?>
<div class="mb-16">
    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-8">Customers also purchased</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-10 gap-x-6">
        <?php foreach ($relatedProducts as $related): ?>
            <div class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col transition-all hover:shadow-lg">
                <div class="w-full min-h-64 bg-gray-200 aspect-w-1 aspect-h-1 overflow-hidden group-hover:opacity-75 relative">
                    <?php if ($related['image_url']): ?>
                        <img src="<?php echo sanitize($related['image_url']); ?>" alt="<?php echo sanitize($related['name']); ?>" class="w-full h-full object-center object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-4 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm text-gray-700 dark:text-gray-300">
                            <a href="/product/<?php echo sanitize($related['slug']); ?>">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                <?php echo sanitize($related['name']); ?>
                            </a>
                        </h3>
                    </div>
                    <p class="text-base font-medium text-gray-900 dark:text-white mt-2">$<?php echo number_format($related['price'], 2); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>