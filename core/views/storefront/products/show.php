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
                <div class="w-full rounded-lg overflow-hidden relative group">
                    <img src="<?php echo sanitize($product['image_url'] ?? 'https://myaayucare.com/wp-content/uploads/2025/02/logoaayucare-2.png'); ?>" alt="<?php echo sanitize($product['name']); ?>" class="w-full h-auto object-center object-cover group-hover:scale-105 transition-transform duration-700 ease-out">

                    <!-- Badges Overlaid on Image -->
                    <?php if (!empty($product['badges'])):
                        $badges = json_decode($product['badges'], true);
                        if (is_array($badges) && count($badges) > 0): ?>
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            <?php foreach ($badges as $badge): ?>
                                <span class="bg-accent text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1 shadow-md">
                                    <?php echo sanitize($badge); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; endif; ?>
                </div>
            </div>

            <!-- Product info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-0 lg:mt-0">
                <h1 class="text-3xl md:text-4xl font-serif font-medium text-primary dark:text-white mb-2"><?php echo sanitize($product['name']); ?></h1>

                <!-- Reviews Summary -->
                <div class="flex items-center mb-6">
                    <div class="flex items-center">
                        <?php
                        $avgRating = round($product['average_rating'] ?? 0);
                        for ($i = 1; $i <= 5; $i++):
                        ?>
                            <svg class="w-4 h-4 <?php echo $i <= $avgRating ? 'text-accent' : 'text-gray-300 dark:text-gray-600'; ?>" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        <?php endfor; ?>
                    </div>
                    <a href="#reviews" class="ml-3 text-sm font-medium text-accent hover:text-accent_hover transition-colors">
                        <?php echo $product['review_count'] ?? 0; ?> reviews
                    </a>
                </div>

                <div class="mt-3 border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h2 class="sr-only">Product information</h2>
                    <p id="product-price" class="text-2xl text-primary dark:text-white font-medium tracking-wider">₹<?php echo number_format($product['price'], 2); ?></p>
                </div>

                <div class="mt-6">
                    <h3 class="sr-only"><?php echo __('description'); ?></h3>
                    <div class="text-sm text-gray-600 dark:text-gray-400 font-light leading-relaxed space-y-6">
                        <p><?php echo nl2br(sanitize($product['description'])); ?></p>
                    </div>
                </div>

                <form action="/cart/add" method="POST" class="mt-8">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" id="selected_variant_id" name="variant_id" value="">

                    <?php if (!empty($product['variants'])): ?>
                        <div class="mt-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-primary dark:text-white uppercase tracking-widest">Select Size</h3>
                            </div>
                            <div class="mt-4 grid grid-cols-3 gap-3">
                                <?php foreach ($product['variants'] as $index => $variant): ?>
                                    <label class="variant-label border border-gray-200 dark:border-gray-600 rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase hover:border-accent cursor-pointer transition-colors <?php echo $index === 0 ? 'ring-1 ring-accent border-accent' : ''; ?>"
                                           data-price="<?php echo $variant['price']; ?>"
                                           data-stock="<?php echo $variant['stock_quantity']; ?>"
                                           data-id="<?php echo $variant['id']; ?>">
                                        <input type="radio" name="variant" value="<?php echo $variant['id']; ?>" class="sr-only" <?php echo $index === 0 ? 'checked' : ''; ?>>
                                        <span class="text-primary dark:text-gray-300"><?php echo sanitize($variant['name']); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Stock Info dynamic -->
                    <div class="mt-6 flex flex-col gap-2">
                        <?php
                        // Initial stock logic depends on if variants exist
                        $initialStock = !empty($product['variants']) ? $product['variants'][0]['stock_quantity'] : $product['stock_quantity'];
                        ?>
                        <div id="stock-indicator" class="flex items-center text-sm font-medium <?php echo $initialStock > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'; ?>">
                            <?php if ($initialStock > 0): ?>
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>In Stock (<?php echo (int)$initialStock; ?> available)</span>
                            <?php else: ?>
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                <span>Out of Stock</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Quantity & Add to Cart -->
                    <div class="flex sm:flex-row mt-8 items-center gap-4">
                        <div class="w-24">
                            <label for="quantity" class="sr-only">Quantity</label>
                            <input type="number" id="quantity" name="quantity" min="1" max="<?php echo (int)$initialStock; ?>" value="1"
                                class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-center text-primary dark:text-white rounded-none py-3 focus:outline-none focus:ring-0 focus:border-accent">
                        </div>

                        <button type="submit" id="add-to-cart-btn" <?php echo $initialStock <= 0 ? 'disabled' : ''; ?>
                            class="flex-1 bg-primary border border-transparent py-3 px-8 flex items-center justify-center text-sm font-medium uppercase tracking-[0.2em] text-white hover:bg-primary_hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors <?php echo $initialStock <= 0 ? 'opacity-50 cursor-not-allowed' : ''; ?>">
                            <?php echo $initialStock <= 0 ? __('out_of_stock') : __('add_to_bag'); ?>
                        </button>
                    </div>
                </form>

                <!-- Rich Content Accordions -->
                <div class="mt-12 border-t border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">

                    <?php if (!empty($product['how_to_use'])): ?>
                    <div class="py-4">
                        <button type="button" class="accordion-trigger flex w-full items-center justify-between text-left focus:outline-none" aria-expanded="false">
                            <span class="text-sm font-medium uppercase tracking-widest text-primary dark:text-white">How To Use</span>
                            <span class="ml-6 flex items-center">
                                <svg class="h-5 w-5 text-accent transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </span>
                        </button>
                        <div class="accordion-content mt-4 hidden pr-12 text-sm font-light text-gray-600 dark:text-gray-400 leading-relaxed">
                            <p><?php echo nl2br(sanitize($product['how_to_use'])); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($product['ingredients'])): ?>
                    <div class="py-4">
                        <button type="button" class="accordion-trigger flex w-full items-center justify-between text-left focus:outline-none" aria-expanded="false">
                            <span class="text-sm font-medium uppercase tracking-widest text-primary dark:text-white">Ingredients</span>
                            <span class="ml-6 flex items-center">
                                <svg class="h-5 w-5 text-accent transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </span>
                        </button>
                        <div class="accordion-content mt-4 hidden pr-12 text-sm font-light text-gray-600 dark:text-gray-400 leading-relaxed">
                            <p><?php echo nl2br(sanitize($product['ingredients'])); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($product['benefits'])): ?>
                    <div class="py-4">
                        <button type="button" class="accordion-trigger flex w-full items-center justify-between text-left focus:outline-none" aria-expanded="false">
                            <span class="text-sm font-medium uppercase tracking-widest text-primary dark:text-white">Benefits</span>
                            <span class="ml-6 flex items-center">
                                <svg class="h-5 w-5 text-accent transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </span>
                        </button>
                        <div class="accordion-content mt-4 hidden pr-12 text-sm font-light text-gray-600 dark:text-gray-400 leading-relaxed">
                            <p><?php echo nl2br(sanitize($product['benefits'])); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php
                    $faqs = !empty($product['faqs']) ? json_decode($product['faqs'], true) : [];
                    if (!empty($faqs) && is_array($faqs)):
                    ?>
                    <div class="py-4">
                        <button type="button" class="accordion-trigger flex w-full items-center justify-between text-left focus:outline-none" aria-expanded="false">
                            <span class="text-sm font-medium uppercase tracking-widest text-primary dark:text-white">FAQ</span>
                            <span class="ml-6 flex items-center">
                                <svg class="h-5 w-5 text-accent transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </span>
                        </button>
                        <div class="accordion-content mt-4 hidden pr-12 text-sm font-light text-gray-600 dark:text-gray-400 leading-relaxed space-y-4">
                            <?php foreach($faqs as $faq): ?>
                                <div>
                                    <p class="font-medium text-primary dark:text-gray-200">Q: <?php echo sanitize($faq['question']); ?></p>
                                    <p class="mt-1 pl-4 border-l-2 border-accent">A: <?php echo sanitize($faq['answer']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <!-- Reviews Section -->
        <div id="reviews" class="mt-24 w-full border-t border-gray-200 dark:border-gray-700 pt-16">
            <h2 class="text-2xl font-serif font-medium text-primary dark:text-white mb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">Customer Reviews</h2>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                <div class="lg:col-span-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Average Rating</h3>
                    <div class="mt-3 flex items-center">
                        <div class="flex items-center">
                            <?php
                            $avgRating = round($product['average_rating'] ?? 0);
                            for ($i = 1; $i <= 5; $i++):
                            ?>
                                <svg class="w-6 h-6 flex-shrink-0 <?php echo $i <= $avgRating ? 'text-accent' : 'text-gray-300 dark:text-gray-600'; ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <p class="ml-2 text-sm text-gray-900 dark:text-gray-300">Based on <?php echo $product['review_count'] ?? 0; ?> reviews</p>
                    </div>
                </div>

                <div class="mt-10 lg:col-span-8 lg:mt-0">
                    <?php if (!empty($product['reviews'])): ?>
                        <div class="space-y-10">
                            <?php foreach($product['reviews'] as $review): ?>
                                <div class="pb-10 border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center mb-4">
                                        <div class="h-10 w-10 rounded-full bg-accent/20 flex items-center justify-center text-accent font-serif font-bold text-lg">
                                            <?php echo strtoupper(substr($review['user_name'], 0, 1)); ?>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-bold text-gray-900 dark:text-white"><?php echo sanitize($review['user_name']); ?></h4>
                                            <div class="mt-1 flex items-center">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <svg class="w-4 h-4 <?php echo $i <= $review['rating'] ? 'text-accent' : 'text-gray-300 dark:text-gray-600'; ?>" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div class="ml-auto text-sm text-gray-500 font-light">
                                            <?php echo date('M d, Y', strtotime($review['created_at'])); ?>
                                        </div>
                                    </div>
                                    <div class="mt-4 space-y-6 text-sm italic text-gray-600 dark:text-gray-400">
                                        <p>"<?php echo nl2br(sanitize($review['comment'])); ?>"</p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-light italic">No reviews yet. Be the first to review this product!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Accordion logic
    const accordions = document.querySelectorAll('.accordion-trigger');
    accordions.forEach(acc => {
        acc.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const icon = this.querySelector('svg');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            if (isExpanded) {
                this.setAttribute('aria-expanded', 'false');
                content.classList.add('hidden');
                icon.classList.remove('rotate-45');
            } else {
                this.setAttribute('aria-expanded', 'true');
                content.classList.remove('hidden');
                icon.classList.add('rotate-45');
            }
        });
    });

    // Variant selection logic
    const variantLabels = document.querySelectorAll('.variant-label');
    const priceElement = document.getElementById('product-price');
    const stockIndicator = document.getElementById('stock-indicator');
    const qtyInput = document.getElementById('quantity');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const hiddenVariantInput = document.getElementById('selected_variant_id');

    if (variantLabels.length > 0) {
        // Set initial hidden variant ID
        hiddenVariantInput.value = variantLabels[0].getAttribute('data-id');

        variantLabels.forEach(label => {
            label.addEventListener('click', function() {
                // Update UI classes
                variantLabels.forEach(l => {
                    l.classList.remove('ring-1', 'ring-accent', 'border-accent');
                });
                this.classList.add('ring-1', 'ring-accent', 'border-accent');

                // Update Price
                const price = parseFloat(this.getAttribute('data-price')).toFixed(2);
                priceElement.textContent = `₹${price}`;

                // Update Stock
                const stock = parseInt(this.getAttribute('data-stock'));
                const variantId = this.getAttribute('data-id');

                hiddenVariantInput.value = variantId;
                qtyInput.max = stock;

                if (parseInt(qtyInput.value) > stock) {
                    qtyInput.value = stock;
                }

                if (stock > 0) {
                    stockIndicator.innerHTML = `
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>In Stock (${stock} available)</span>
                    `;
                    stockIndicator.className = 'flex items-center text-sm font-medium text-green-600 dark:text-green-400';
                    addToCartBtn.disabled = false;
                    addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    addToCartBtn.textContent = '<?php echo __('add_to_bag'); ?>';
                } else {
                    stockIndicator.innerHTML = `
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <span>Out of Stock</span>
                    `;
                    stockIndicator.className = 'flex items-center text-sm font-medium text-red-600 dark:text-red-400';
                    addToCartBtn.disabled = true;
                    addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    addToCartBtn.textContent = '<?php echo __('out_of_stock'); ?>';
                }
            });
        });
    }
});
</script>

<!-- Related Products -->
<?php if (!empty($relatedProducts)): ?>
<div class="mb-16">
    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-8"><?php echo __('related_products'); ?></h2>
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
                    <p class="text-base font-medium text-gray-900 dark:text-white mt-2">₹<?php echo number_format($related['price'], 2); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>