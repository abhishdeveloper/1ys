<?php
// core/views/storefront/home.php
require_once __DIR__ . '/partials/header.php';
?>

<!-- SaaS/Ayurvedic Style Hero Section -->
<div class="relative bg-gradient-to-b from-green-50 to-white dark:from-gray-800 dark:to-gray-900 overflow-hidden rounded-3xl shadow-lg mb-16 border border-green-100 dark:border-gray-700 animate-slide-up">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 px-4 sm:px-6 lg:px-8 mt-10 sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
            <div class="sm:text-center lg:text-left">
                <span class="inline-block py-1 px-3 rounded-full bg-green-100 text-green-800 text-xs font-semibold tracking-wide uppercase mb-4 shadow-sm border border-green-200">100% Pure & Natural</span>
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl leading-tight">
                    <span class="block xl:inline">Authentic Ayurvedic</span>
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-primary to-green-500 xl:inline">Healing & Care.</span>
                </h1>
                <p class="mt-3 text-base text-gray-600 dark:text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0 font-light">
                    Rooted in ancient wisdom, meticulously manufactured for modern wellness. We specialize in premium third-party Ayurvedic medicine, skincare, and pain-relief formulations.
                </p>
                <div class="mt-8 sm:flex sm:justify-center lg:justify-start gap-4">
                    <div class="rounded-full shadow-lg">
                        <a href="/products" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-primary hover:bg-primary_hover md:py-4 md:text-lg md:px-10 transition-all transform hover:-translate-y-1 hover:shadow-xl">
                            Shop Collections
                        </a>
                    </div>
                    <div class="mt-3 sm:mt-0 rounded-full shadow-sm">
                        <a href="/categories" class="w-full flex items-center justify-center px-8 py-3 border border-green-200 text-base font-medium rounded-full text-primary bg-white hover:bg-green-50 md:py-4 md:text-lg md:px-10 transition-all transform hover:-translate-y-1">
                            Explore Categories
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 p-8">
        <!-- Floating organic style hero images -->
        <div class="h-full w-full relative">
            <div class="absolute inset-0 bg-green-200 dark:bg-green-900/40 rounded-full blur-3xl opacity-50 animate-pulse" style="animation-duration: 8s;"></div>
            <img class="relative z-10 w-full h-full object-cover rounded-2xl shadow-2xl animate-float border-4 border-white dark:border-gray-800" src="https://myaayucare.com/wp-content/uploads/2025/02/IMG-20250204-WA0009.jpg" alt="AAYU CARE Products">
            <!-- Decorative floating badge -->
            <div class="absolute bottom-10 left-[-20px] z-20 glass rounded-xl p-4 shadow-xl flex items-center gap-3 animate-float" style="animation-delay: 1s;">
                <div class="bg-green-100 p-2 rounded-full"><svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></div>
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">Quality Tested</p>
                    <p class="text-xs text-gray-500">GMP Certified</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shop by Category -->
<div class="mb-20 pt-8 border-t border-gray-100 dark:border-gray-800">
    <div class="text-center mb-10">
        <h2 class="text-sm text-primary font-bold tracking-widest uppercase mb-2">Curated for You</h2>
        <h3 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Shop by Category</h3>
    </div>
    <?php if (empty($categories)): ?>
        <p class="text-gray-500 dark:text-gray-400 text-center">No categories found. Start by adding some in the admin panel.</p>
    <?php else: ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6">
            <?php foreach ($categories as $category): ?>
                <a href="/category/<?php echo sanitize($category['slug']); ?>" class="group flex flex-col items-center justify-center p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:border-green-200 dark:hover:border-green-800 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-20 h-20 rounded-full bg-green-50 dark:bg-gray-700 flex items-center justify-center mb-6 group-hover:bg-green-100 dark:group-hover:bg-gray-600 transition-colors shadow-inner">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <span class="text-base font-bold text-gray-900 dark:text-white text-center group-hover:text-primary transition-colors"><?php echo sanitize($category['name']); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Testimonial / Features Section -->
<div class="mb-20 bg-green-50 dark:bg-gray-800 rounded-3xl p-8 sm:p-12 border border-green-100 dark:border-gray-700">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div class="flex flex-col items-center p-4">
            <div class="w-16 h-16 bg-white dark:bg-gray-700 rounded-full flex items-center justify-center shadow-md mb-4 text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">100% Authentic</h4>
            <p class="text-sm text-gray-600 dark:text-gray-300">Pure Ayurvedic formulations sourced from nature.</p>
        </div>
        <div class="flex flex-col items-center p-4">
            <div class="w-16 h-16 bg-white dark:bg-gray-700 rounded-full flex items-center justify-center shadow-md mb-4 text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Lab Tested</h4>
            <p class="text-sm text-gray-600 dark:text-gray-300">Rigorously tested for quality, safety, and efficacy.</p>
        </div>
        <div class="flex flex-col items-center p-4">
            <div class="w-16 h-16 bg-white dark:bg-gray-700 rounded-full flex items-center justify-center shadow-md mb-4 text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Fast Delivery</h4>
            <p class="text-sm text-gray-600 dark:text-gray-300">Prompt and secure shipping straight to your doorstep.</p>
        </div>
    </div>
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