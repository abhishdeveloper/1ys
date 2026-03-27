<?php
// core/views/storefront/home.php
require_once __DIR__ . '/partials/header.php';
?>

<!-- Royal Ayurvedic Hero Slider Section -->
<div class="relative bg-secondary dark:bg-gray-900 overflow-hidden mb-20 shadow-sm border-b-4 border-accent z-0">

    <!-- Slider Container -->
    <div id="hero-slider" class="relative w-full h-[700px] md:h-[800px] overflow-hidden group">

        <!-- Slide 1 -->
        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100 flex flex-col items-center justify-center text-center">
            <!-- Full Background Image -->
            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover object-center transform scale-105 transition-transform duration-[10000ms] slide-img" src="https://myaayucare.com/wp-content/uploads/2025/02/IMG-20250204-WA0009.jpg" alt="Luxurious Ayurvedic Products">
                <!-- Overlay to ensure text readability -->
                <div class="absolute inset-0 bg-black/40 z-10 pointer-events-none"></div>
            </div>

            <!-- Text Content (Centered over image) -->
            <div class="relative z-20 w-full max-w-4xl px-6 pt-32 pb-16 flex flex-col justify-center items-center h-full">
                <div class="mb-6 animate-slide-up" style="animation-delay: 0.1s;">
                    <span class="font-serif italic text-accent text-xl tracking-widest drop-shadow-md">Discover Luxurious Ayurveda</span>
                    <div class="h-px w-24 bg-accent mx-auto mt-3 mb-2"></div>
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-7xl font-serif font-bold text-white leading-tight mb-6 animate-slide-up drop-shadow-lg" style="animation-delay: 0.3s;">
                    Pure, Potent <br>
                    <span class="text-accent italic font-normal">&amp; Time-Honored</span>
                </h1>
                <p class="text-base text-gray-100 sm:text-xl mb-10 font-light leading-relaxed max-w-2xl mx-auto animate-slide-up drop-shadow-md" style="animation-delay: 0.5s;">
                    Crafted with nature's rarest botanicals, our artisanal formulations deliver profound healing and radiant vitality rooted in ancient wisdom.
                </p>
                <div class="flex justify-center animate-slide-up" style="animation-delay: 0.7s;">
                    <a href="/products" class="inline-flex items-center justify-center px-10 py-4 border border-transparent text-sm font-semibold uppercase tracking-widest text-secondary bg-primary hover:bg-primary_hover transition-colors shadow-xl hover:shadow-2xl">
                        Explore Collection
                    </a>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 flex flex-col items-center justify-center text-center pointer-events-none">

            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover object-center transform scale-105 transition-transform duration-[10000ms] slide-img" src="https://myaayucare.com/wp-content/uploads/2025/02/banner2.jpg" onerror="this.src='https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?auto=format&fit=crop&q=80&w=1200';" alt="Wellness Supplements">
                <div class="absolute inset-0 bg-black/40 z-10 pointer-events-none"></div>
            </div>

            <div class="relative z-20 w-full max-w-4xl px-6 pt-32 pb-16 flex flex-col justify-center items-center h-full">
                <div class="mb-6">
                    <span class="font-serif italic text-accent text-xl tracking-widest drop-shadow-md">The Art of Wellness</span>
                    <div class="h-px w-24 bg-accent mx-auto mt-3 mb-2"></div>
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-7xl font-serif font-bold text-white leading-tight mb-6 drop-shadow-lg">
                    Nourish Your <br>
                    <span class="text-accent italic font-normal">Mind, Body &amp; Soul</span>
                </h1>
                <p class="text-base text-gray-100 sm:text-xl mb-10 font-light leading-relaxed max-w-2xl mx-auto drop-shadow-md">
                    Experience the ultimate indulgence with our exquisite range of natural wellness supplements and herbal oils.
                </p>
                <div class="flex justify-center pointer-events-auto">
                    <a href="/category/herbal-oils" class="inline-flex items-center justify-center px-10 py-4 border border-transparent text-sm font-semibold uppercase tracking-widest text-secondary bg-primary hover:bg-primary_hover transition-colors shadow-xl hover:shadow-2xl">
                        Shop Herbal Oils
                    </a>
                </div>
            </div>
        </div>

        <!-- Slider Controls -->
        <button id="prev-slide" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-30 p-2 rounded-full bg-white/50 hover:bg-white text-primary hover:text-accent transition-all opacity-0 group-hover:opacity-100 backdrop-blur-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button id="next-slide" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-30 p-2 rounded-full bg-white/50 hover:bg-white text-primary hover:text-accent transition-all opacity-0 group-hover:opacity-100 backdrop-blur-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Slider Indicators -->
        <div class="absolute bottom-6 left-0 right-0 flex justify-center space-x-3 z-30">
            <button class="slide-dot w-2.5 h-2.5 rounded-full bg-accent transition-all duration-300 transform scale-125" data-slide="0"></button>
            <button class="slide-dot w-2.5 h-2.5 rounded-full bg-gray-300 dark:bg-gray-600 hover:bg-accent/50 transition-all duration-300" data-slide="1"></button>
        </div>

    </div>
</div>

<!-- Shop by Curated Categories -->
<div class="mb-32 mt-16 px-4">
    <div class="text-center mb-20">
        <h2 class="font-serif italic text-accent text-xl mb-3 font-light tracking-wide">Curated With Care</h2>
        <h3 class="text-2xl md:text-3xl font-serif font-medium tracking-[0.2em] text-primary dark:text-white uppercase">The Collections</h3>
        <div class="flex items-center justify-center mt-8">
            <div class="h-[1px] w-12 md:w-20 bg-accent/60"></div>
            <div class="w-1.5 h-1.5 rounded-full bg-accent/60 mx-4"></div>
            <div class="h-[1px] w-12 md:w-20 bg-accent/60"></div>
        </div>
    </div>

    <?php if (empty($categories)): ?>
        <p class="text-gray-400 text-center font-light tracking-widest">The collections are currently being prepared for you.</p>
    <?php else: ?>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-16 max-w-6xl mx-auto px-4 sm:px-8">
            <?php foreach ($categories as $category): ?>
                <a href="/category/<?php echo sanitize($category['slug']); ?>" class="group flex flex-col items-center text-center transition-all duration-700 hover:-translate-y-2">
                    <div class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 rounded-full border border-gray-200/50 dark:border-gray-800 p-1 mb-6 relative overflow-hidden bg-transparent group-hover:border-accent/50 transition-colors duration-500">
                        <!-- Inner Container -->
                        <div class="w-full h-full rounded-full bg-[#f9f8f6] dark:bg-gray-900 flex flex-col items-center justify-center border border-transparent group-hover:bg-accent/5 transition-all duration-500">
                            <!-- Custom SVG Icon for Categories (Botanical Theme) -->
                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-primary dark:text-gray-400 group-hover:text-accent transition-colors duration-500 mb-2 stroke-[1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1.5.5 2 2s-.5 2-2 2h-.5c-.276 0-.5.224-.5.5v2c0 .276.224.5.5.5h2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1.5.5 2 2s-.5 2-2 2h-.5c-.276 0-.5.224-.5.5v2c0 .276.224.5.5.5h2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8" />
                            </svg>
                        </div>
                    </div>
                    <span class="text-[11px] sm:text-xs font-medium text-primary dark:text-gray-300 uppercase tracking-[0.2em] group-hover:text-accent transition-colors duration-500"><?php echo sanitize($category['name']); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Royal Features Section -->
<div class="mb-32 bg-[#172a20] text-secondary py-24 px-4 relative overflow-hidden border-y border-accent/30 shadow-[0_0_50px_rgba(0,0,0,0.2)]">
    <!-- Detailed background pattern -->
    <div class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')] mix-blend-overlay"></div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-16 md:gap-8 text-center relative z-10">
        <div class="flex flex-col items-center p-4 group">
            <div class="w-16 h-16 rounded-full border border-accent/30 flex items-center justify-center mb-6 group-hover:border-accent transition-colors duration-500">
                <svg class="w-8 h-8 text-accent stroke-[1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h4 class="font-serif text-[15px] tracking-[0.2em] uppercase text-accent mb-4">Pure Ingredients</h4>
            <p class="text-sm text-gray-400 font-light leading-loose max-w-xs mx-auto">Sourced from the pristine valleys of the Himalayas, preserving the life force of every herb.</p>
        </div>
        <div class="flex flex-col items-center p-4 group">
            <div class="w-16 h-16 rounded-full border border-accent/30 flex items-center justify-center mb-6 group-hover:border-accent transition-colors duration-500">
                <svg class="w-8 h-8 text-accent stroke-[1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <h4 class="font-serif text-[15px] tracking-[0.2em] uppercase text-accent mb-4">Time-Honored Recipes</h4>
            <p class="text-sm text-gray-400 font-light leading-loose max-w-xs mx-auto">Authentic formulations passed down through generations of Ayurvedic masters.</p>
        </div>
        <div class="flex flex-col items-center p-4 group">
            <div class="w-16 h-16 rounded-full border border-accent/30 flex items-center justify-center mb-6 group-hover:border-accent transition-colors duration-500">
                <svg class="w-8 h-8 text-accent stroke-[1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
            </div>
            <h4 class="font-serif text-[15px] tracking-[0.2em] uppercase text-accent mb-4">Modern Elegance</h4>
            <p class="text-sm text-gray-400 font-light leading-loose max-w-xs mx-auto">Ancient wisdom meticulously crafted to meet the exacting standards of luxury skincare.</p>
        </div>
    </div>
</div>

<!-- Featured Bestsellers -->
<div class="mb-32 px-4">
    <div class="text-center mb-20">
        <h2 class="font-serif italic text-accent text-xl mb-3 font-light tracking-wide">Discover Our</h2>
        <h3 class="text-2xl md:text-3xl font-serif font-medium tracking-[0.2em] text-primary dark:text-white uppercase">Bestsellers</h3>
        <div class="flex items-center justify-center mt-8">
            <div class="h-[1px] w-12 md:w-20 bg-accent/60"></div>
            <div class="w-1.5 h-1.5 rounded-full bg-accent/60 mx-4"></div>
            <div class="h-[1px] w-12 md:w-20 bg-accent/60"></div>
        </div>
    </div>

    <?php if (empty($featuredProducts)): ?>
        <p class="text-gray-400 text-center font-light tracking-widest reveal-on-scroll">No exquisite products available at the moment.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-16 max-w-7xl mx-auto">
            <?php foreach ($featuredProducts as $index => $product): ?>
                <div class="group relative flex flex-col items-center text-center transition-all duration-500 hover:-translate-y-2 reveal-on-scroll" data-stagger="true">
                    <!-- Badge (Optional, can be conditional based on product data if added later) -->
                    <?php if ($index === 0 || $index === 2): // Faking a 'Bestseller' badge for visual effect ?>
                    <div class="absolute top-4 left-4 z-20 bg-accent text-white text-[9px] font-bold uppercase tracking-widest px-3 py-1 shadow-sm">
                        <?php echo __('bestseller_badge'); ?>
                    </div>
                    <?php endif; ?>

                    <!-- Image -->
                    <div class="w-full aspect-w-4 aspect-h-5 mb-8 overflow-hidden border border-gray-100 dark:border-gray-800 bg-[#f9f8f6] dark:bg-gray-900 relative shadow-sm group-hover:shadow-[0_20px_40px_rgba(184,144,83,0.15)] transition-shadow duration-500">
                        <?php if ($product['image_url']): ?>
                            <img src="<?php echo sanitize($product['image_url']); ?>" alt="<?php echo sanitize($product['name']); ?>" class="w-full h-full object-center object-cover group-hover:scale-105 transition-transform duration-1000 ease-out">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-300 bg-[#f9f8f6] dark:bg-gray-900">
                                <span class="font-serif italic text-2xl opacity-50">Aayu Care</span>
                            </div>
                        <?php endif; ?>

                        <!-- Quick Add Overlay (Hover) -->
                        <div class="absolute inset-0 bg-primary/30 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end justify-center pb-8">
                            <form action="/cart/add" method="POST" class="w-5/6 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full py-3.5 bg-white text-primary text-[11px] font-medium uppercase tracking-[0.2em] hover:bg-accent hover:text-white transition-colors duration-300 shadow-xl flex items-center justify-center space-x-2">
                                    <span><?php echo __('add_to_bag'); ?></span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="flex-grow flex flex-col justify-between w-full px-2">
                        <div>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] mb-3"><?php echo sanitize($product['category_name'] ?? 'Uncategorized'); ?></p>
                            <h3 class="text-[15px] font-serif font-medium text-primary dark:text-gray-200 mb-3 leading-relaxed">
                                <a href="/product/<?php echo sanitize($product['slug']); ?>" class="hover:text-accent transition-colors duration-300">
                                    <?php echo sanitize($product['name']); ?>
                                </a>
                            </h3>
                        </div>
                        <div class="mt-3">
                            <p class="text-[13px] text-accent font-medium tracking-wider">₹<?php echo number_format($product['price'], 2); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-24 text-center reveal-on-scroll">
            <a href="/products" class="inline-block border border-accent/50 text-[11px] font-medium uppercase tracking-[0.2em] text-primary dark:text-gray-300 hover:bg-accent hover:text-white px-10 py-4 transition-all duration-500 hover:shadow-lg group">
                <?php echo __('view_all_products'); ?>
                <svg class="w-4 h-4 inline-block ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Newsletter Section -->
<div class="bg-secondary dark:bg-gray-800 py-24 border-t border-gray-200 dark:border-gray-700 reveal-on-scroll">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h3 class="text-2xl md:text-3xl font-serif font-medium text-primary dark:text-white mb-4"><?php echo __('join_circle'); ?></h3>
        <p class="text-gray-500 dark:text-gray-400 font-light mb-8 max-w-lg mx-auto"><?php echo __('subscribe_desc'); ?></p>
        <form class="flex flex-col sm:flex-row max-w-lg mx-auto gap-4">
            <input type="email" placeholder="<?php echo __('enter_email'); ?>" class="flex-grow bg-transparent border-b border-gray-400 dark:border-gray-600 py-3 px-2 focus:outline-none focus:border-accent transition-colors text-sm text-primary dark:text-white" required>
            <button type="submit" class="bg-primary hover:bg-accent text-white text-xs tracking-[0.2em] uppercase font-medium px-8 py-4 transition-colors duration-300"><?php echo __('subscribe'); ?></button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>