<?php
// core/views/storefront/home.php
require_once __DIR__ . '/partials/header.php';
?>

<!-- Hero Section -->
<div class="relative bg-white dark:bg-gray-800 overflow-hidden rounded-2xl shadow-sm mb-12 border dark:border-gray-700">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white dark:bg-gray-800 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white dark:text-gray-800 transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100" />
            </svg>

            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Premium Ayurvedic</span>
                        <span class="block text-primary xl:inline">Manufacturing.</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Discover nature's healing with AAYU CARE. We specialize in third-party manufacturing of high-quality Ayurvedic medicines, roll-ons, and natural care products.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="/products" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary_hover md:py-4 md:text-lg md:px-10 transition-colors">
                                View Products
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="/categories" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-green-100 hover:bg-green-200 md:py-4 md:text-lg md:px-10 transition-colors">
                                Browse Categories
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-green-50 dark:bg-gray-700">
        <!-- Hero image related to Ayurveda -->
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full opacity-90" src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Ayurvedic herbs and nature">
    </div>
</div>

<!-- Shop by Category -->
<div class="mb-16">
    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-8">Shop by Category</h2>
    <?php if (empty($categories)): ?>
        <p class="text-gray-500 dark:text-gray-400">No categories found. Start by adding some in the admin panel.</p>
    <?php else: ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <?php foreach ($categories as $category): ?>
                <a href="/category/<?php echo sanitize($category['slug']); ?>" class="group flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all hover:-translate-y-1">
                    <div class="w-16 h-16 rounded-full bg-indigo-50 dark:bg-gray-700 flex items-center justify-center mb-4 group-hover:bg-indigo-100 dark:group-hover:bg-gray-600 transition-colors">
                        <!-- Generic category icon -->
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white text-center"><?php echo sanitize($category['name']); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Featured Products -->
<div>
    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-8">Featured Products</h2>
    <?php if (empty($featuredProducts)): ?>
        <p class="text-gray-500 dark:text-gray-400">No featured products currently available.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-10 gap-x-6 xl:gap-x-8">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col transition-all hover:shadow-lg">
                    <!-- Image -->
                    <div class="w-full min-h-64 bg-gray-200 aspect-w-1 aspect-h-1 overflow-hidden group-hover:opacity-75 relative">
                        <?php if ($product['image_url']): ?>
                            <img src="<?php echo sanitize($product['image_url']); ?>" alt="<?php echo sanitize($product['name']); ?>" class="w-full h-full object-center object-cover">
                        <?php else: ?>
                            <div class="w-full h-48 flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Details -->
                    <div class="p-4 flex-grow flex flex-col justify-between">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1"><?php echo sanitize($product['category_name'] ?? 'Uncategorized'); ?></p>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                <a href="/product/<?php echo sanitize($product['slug']); ?>">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    <?php echo sanitize($product['name']); ?>
                                </a>
                            </h3>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <p class="text-xl font-bold text-gray-900 dark:text-white">$<?php echo number_format($product['price'], 2); ?></p>
                            <!-- Simple add to cart icon button (z-10 to be clickable over the absolute link) -->
                            <form action="/cart/add" method="POST" class="relative z-10">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="p-2 rounded-full bg-indigo-50 text-primary hover:bg-primary hover:text-white transition-colors focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>