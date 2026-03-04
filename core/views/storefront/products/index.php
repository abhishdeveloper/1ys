<?php
// core/views/storefront/products/index.php
require_once __DIR__ . '/../partials/header.php';
?>

<div class="flex flex-col md:flex-row gap-8 pb-16">
    <!-- Sidebar: Categories & Filters -->
    <aside class="w-full md:w-64 flex-shrink-0">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sticky top-24">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Categories</h3>
            <ul class="space-y-3">
                <li>
                    <a href="/products" class="<?php echo !isset($currentCategory) ? 'text-primary font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary'; ?> flex items-center transition-colors">
                        All Products
                    </a>
                </li>
                <?php foreach ($categories as $cat): ?>
                    <li>
                        <a href="/category/<?php echo sanitize($cat['slug']); ?>"
                           class="<?php echo (isset($currentCategory) && $currentCategory['id'] == $cat['id']) ? 'text-primary font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary'; ?> flex items-center transition-colors">
                            <?php echo sanitize($cat['name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>

    <!-- Main Content: Product Grid -->
    <main class="flex-grow">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                <?php echo isset($currentCategory) ? sanitize($currentCategory['name']) : 'All Products'; ?>
            </h1>
            <p class="mt-2 sm:mt-0 text-sm text-gray-500 dark:text-gray-400">
                Showing <?php echo count($products); ?> result(s)
            </p>
        </div>

        <?php if (empty($products)): ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No products found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your category or check back later.</p>
                <div class="mt-6">
                    <a href="/products" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        View All Products
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-10 gap-x-6">
                <?php foreach ($products as $product): ?>
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
                                <button class="relative z-10 p-2 rounded-full bg-indigo-50 text-primary hover:bg-primary hover:text-white transition-colors focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>