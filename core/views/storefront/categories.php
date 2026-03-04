<?php
// core/views/storefront/categories.php
require_once __DIR__ . '/partials/header.php';
?>

<div class="mb-16">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">All Categories</h1>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Browse our complete collection of product categories.</p>
    </div>

    <?php if (empty($categories)): ?>
        <p class="text-gray-500 dark:text-gray-400">No categories currently available.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($categories as $category): ?>
                <a href="/category/<?php echo sanitize($category['slug']); ?>" class="group flex items-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all hover:-translate-y-1">
                    <div class="flex-shrink-0 w-16 h-16 rounded-full bg-indigo-50 dark:bg-gray-700 flex items-center justify-center mr-6 group-hover:bg-indigo-100 dark:group-hover:bg-gray-600 transition-colors">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white"><?php echo sanitize($category['name']); ?></h3>
                        <?php if(!empty($category['description'])): ?>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2"><?php echo sanitize($category['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>