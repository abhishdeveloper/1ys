<?php require_once 'partials/header.php'; ?>

<div class="bg-gray-50 dark:bg-gray-900 py-16 md:py-24 animate-fade-in min-h-[70vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16">
            <h1 class="text-3xl md:text-5xl font-light text-primary dark:text-white uppercase tracking-[0.2em] mb-4">
                <?php echo __('3rd_party_manufacturing') ?? '3rd Party Manufacturing'; ?>
            </h1>
            <div class="h-px w-24 bg-accent mx-auto mb-6"></div>
            <p class="text-gray-600 dark:text-gray-400 text-lg max-w-2xl mx-auto font-light leading-relaxed">
                Partner with AAYU CARE for premium, GMP-certified Ayurvedic and botanical cosmetic manufacturing. We bring your vision to life with uncompromising purity and modern elegance.
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden mb-16 border border-gray-100 dark:border-gray-700">
            <div class="p-8 md:p-12">
                <h2 class="text-2xl text-primary dark:text-white mb-6 font-medium">Why Choose Us?</h2>
                <ul class="space-y-4 text-gray-600 dark:text-gray-300 mb-8">
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-accent shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>State-of-the-Art Facility:</strong> GMP compliant and strictly adhering to global quality standards.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-accent shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Custom Formulations:</strong> Our Ayurvedic experts can develop unique, high-efficacy formulas tailored to your brand.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-accent shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>End-to-End Solutions:</strong> From sourcing the purest Himalayan herbs to final packaging and labeling.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-accent shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Confidentiality Assured:</strong> Strict NDAs ensure your proprietary blends remain securely yours.</span>
                    </li>
                </ul>

                <h2 class="text-2xl text-primary dark:text-white mb-6 font-medium">Our Capabilities</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center border border-gray-100 dark:border-gray-600">
                        <span class="block text-primary dark:text-white font-medium mb-1">Skincare</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Creams, Serums, Lotions</span>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center border border-gray-100 dark:border-gray-600">
                        <span class="block text-primary dark:text-white font-medium mb-1">Haircare</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Oils, Shampoos, Masks</span>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center border border-gray-100 dark:border-gray-600">
                        <span class="block text-primary dark:text-white font-medium mb-1">Wellness</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Supplements, Teas</span>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center border border-gray-100 dark:border-gray-600">
                        <span class="block text-primary dark:text-white font-medium mb-1">Bath & Body</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Soaps, Scrubs, Salts</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h3 class="text-xl text-primary dark:text-white mb-4 font-medium">Ready to start your manufacturing journey?</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-8">Contact our B2B team to discuss minimum order quantities, timelines, and sample development.</p>
            <a href="/contact" class="inline-block bg-primary text-white px-8 py-3 rounded-md hover:bg-accent transition-colors duration-300 uppercase tracking-widest text-sm font-medium shadow-md hover:shadow-lg">
                Get In Touch
            </a>
        </div>

    </div>
</div>

<?php require_once 'partials/footer.php'; ?>
