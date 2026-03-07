<?php
// core/views/storefront/home.php
require_once __DIR__ . '/partials/header.php';
?>

<!-- Royal Ayurvedic Hero Section -->
<div class="relative bg-secondary dark:bg-gray-900 overflow-hidden rounded-sm mb-20 border border-accent/30 dark:border-gray-800 animate-slide-up shadow-sm">
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center">
        <!-- Text Content -->
        <div class="relative z-10 w-full lg:w-1/2 px-6 py-16 sm:py-24 lg:px-16 text-center lg:text-left flex flex-col justify-center">

            <div class="mb-6">
                <span class="font-serif italic text-accent text-lg tracking-widest">Discover Luxurious Ayurveda</span>
                <div class="h-px w-24 bg-accent mx-auto lg:mx-0 mt-3 mb-2"></div>
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-6xl font-serif font-bold text-primary dark:text-white leading-tight mb-6">
                Pure, Potent <br>
                <span class="text-accent italic font-normal">&amp; Time-Honored</span>
            </h1>

            <p class="text-base text-gray-700 dark:text-gray-300 sm:text-lg mb-10 font-light leading-relaxed max-w-lg mx-auto lg:mx-0">
                Crafted with nature's rarest botanicals, our artisanal formulations deliver profound healing and radiant vitality rooted in ancient wisdom.
            </p>

            <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                <a href="/products" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-sm font-semibold uppercase tracking-widest text-secondary bg-primary hover:bg-primary_hover transition-colors shadow-lg shadow-primary/30">
                    Explore Collection
                </a>
                <a href="/categories" class="inline-flex items-center justify-center px-8 py-3.5 border border-accent text-sm font-semibold uppercase tracking-widest text-primary dark:text-accent bg-transparent hover:bg-accent hover:text-white transition-colors">
                    Our Heritage
                </a>
            </div>
        </div>

        <!-- Hero Image -->
        <div class="w-full lg:w-1/2 relative min-h-[400px] lg:min-h-[600px]">
            <!-- Elegant image frame with subtle border -->
            <div class="absolute inset-4 lg:inset-8 border border-accent/40 z-20 pointer-events-none"></div>
            <img class="absolute inset-0 w-full h-full object-cover z-10 animate-fade-in" src="https://myaayucare.com/wp-content/uploads/2025/02/IMG-20250204-WA0009.jpg" alt="AAYU CARE Luxurious Ayurvedic Products">
            <div class="absolute inset-0 bg-gradient-to-r from-secondary dark:from-gray-900 via-transparent to-transparent z-10 lg:hidden pointer-events-none"></div>
            <div class="absolute inset-0 bg-gradient-to-l from-transparent via-transparent to-secondary dark:to-gray-900 z-10 hidden lg:block pointer-events-none"></div>
        </div>
    </div>
</div>

<!-- Shop by Curated Categories -->
<div class="mb-24 px-4">
    <div class="text-center mb-16">
        <h2 class="font-serif italic text-accent text-xl mb-2">Curated With Care</h2>
        <h3 class="text-3xl font-serif font-bold tracking-widest text-primary dark:text-white uppercase">The Collections</h3>
        <div class="h-px w-16 bg-accent mx-auto mt-6"></div>
    </div>

    <?php if (empty($categories)): ?>
        <p class="text-gray-500 text-center font-light">The collections are currently being prepared for you.</p>
    <?php else: ?>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-10 max-w-6xl mx-auto">
            <?php foreach ($categories as $category): ?>
                <a href="/category/<?php echo sanitize($category['slug']); ?>" class="group flex flex-col items-center text-center transition-all duration-500">
                    <div class="w-full aspect-w-1 aspect-h-1 rounded-full border border-gray-200 dark:border-gray-700 p-2 group-hover:border-accent transition-colors mb-4 relative overflow-hidden bg-secondary dark:bg-gray-800">
                        <!-- Simulated inner image area -->
                        <div class="w-full h-full rounded-full bg-primary/5 flex items-center justify-center">
                            <span class="font-serif text-3xl text-accent opacity-50 group-hover:scale-110 transition-transform duration-700">✧</span>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-primary dark:text-white uppercase tracking-widest group-hover:text-accent transition-colors"><?php echo sanitize($category['name']); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Royal Features Section -->
<div class="mb-24 bg-primary text-secondary py-16 px-4 relative overflow-hidden">
    <!-- Subtle background pattern -->
    <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMSIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==')]"></div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 text-center relative z-10">
        <div class="flex flex-col items-center p-4 group">
            <span class="text-accent text-4xl mb-4 group-hover:-translate-y-2 transition-transform duration-300">✦</span>
            <h4 class="font-serif text-lg tracking-widest uppercase text-accent mb-3">Pure Ingredients</h4>
            <p class="text-sm text-gray-300 font-light leading-relaxed max-w-xs mx-auto">Sourced from the pristine valleys of the Himalayas, preserving the life force of every herb.</p>
        </div>
        <div class="flex flex-col items-center p-4 group">
            <span class="text-accent text-4xl mb-4 group-hover:-translate-y-2 transition-transform duration-300">✦</span>
            <h4 class="font-serif text-lg tracking-widest uppercase text-accent mb-3">Time-Honored Recipes</h4>
            <p class="text-sm text-gray-300 font-light leading-relaxed max-w-xs mx-auto">Authentic formulations passed down through generations of Ayurvedic masters.</p>
        </div>
        <div class="flex flex-col items-center p-4 group">
            <span class="text-accent text-4xl mb-4 group-hover:-translate-y-2 transition-transform duration-300">✦</span>
            <h4 class="font-serif text-lg tracking-widest uppercase text-accent mb-3">Modern Elegance</h4>
            <p class="text-sm text-gray-300 font-light leading-relaxed max-w-xs mx-auto">Ancient wisdom meticulously crafted to meet the exacting standards of luxury skincare.</p>
        </div>
    </div>
</div>

<!-- Featured Bestsellers -->
<div class="mb-24">
    <div class="text-center mb-16">
        <h2 class="font-serif italic text-accent text-xl mb-2">Discover Our</h2>
        <h3 class="text-3xl font-serif font-bold tracking-widest text-primary dark:text-white uppercase">Bestsellers</h3>
        <div class="h-px w-16 bg-accent mx-auto mt-6"></div>
    </div>

    <?php if (empty($featuredProducts)): ?>
        <p class="text-gray-500 text-center font-light">No exquisite products available at the moment.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="group relative flex flex-col items-center text-center transition-all duration-300">
                    <!-- Image -->
                    <div class="w-full aspect-w-4 aspect-h-5 mb-6 overflow-hidden border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-800 relative shadow-sm hover:shadow-md transition-shadow">
                        <?php if ($product['image_url']): ?>
                            <img src="<?php echo sanitize($product['image_url']); ?>" alt="<?php echo sanitize($product['name']); ?>" class="w-full h-full object-center object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-300 bg-secondary dark:bg-gray-900">
                                <span class="font-serif italic">Aayu Care</span>
                            </div>
                        <?php endif; ?>

                        <!-- Quick Add Overlay (Hover) -->
                        <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                            <form action="/cart/add" method="POST" class="w-3/4">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full py-3 bg-white text-primary text-xs font-bold uppercase tracking-widest hover:bg-accent hover:text-white transition-colors border border-transparent hover:border-accent">
                                    Add to Bag
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="flex-grow flex flex-col justify-between w-full">
                        <div>
                            <p class="text-xs text-accent uppercase tracking-widest mb-2 font-semibold"><?php echo sanitize($product['category_name'] ?? 'Uncategorized'); ?></p>
                            <h3 class="text-base font-serif font-medium text-primary dark:text-gray-200 mb-2 leading-snug">
                                <a href="/product/<?php echo sanitize($product['slug']); ?>" class="hover:text-accent transition-colors">
                                    <?php echo sanitize($product['name']); ?>
                                </a>
                            </h3>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600 dark:text-gray-400 font-light tracking-wider">₹<?php echo number_format($product['price'], 2); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-16 text-center">
            <a href="/products" class="inline-block border-b-2 border-accent text-sm font-semibold uppercase tracking-widest text-primary dark:text-gray-300 hover:text-accent pb-1 transition-colors">
                View All Products
            </a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>