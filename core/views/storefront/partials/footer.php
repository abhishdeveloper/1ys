<?php
// core/views/storefront/partials/footer.php
?>
</main> <!-- End Main Content -->

<!-- Footer -->
<footer class="bg-white dark:bg-gray-800 shadow-inner mt-auto border-t dark:border-gray-700">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="space-y-8 xl:col-span-1">
                <a href="/" class="flex items-center gap-2">
                    <img class="h-12 w-auto" src="https://myaayucare.com/wp-content/uploads/2025/02/logoaayucare-2.png" alt="AAYU CARE Logo">
                    <span class="font-bold text-2xl tracking-tight text-primary dark:text-white">AAYU CARE</span>
                </a>
                <p class="text-gray-500 dark:text-gray-400 text-base">
                    An Ayurvedic pharma medicine manufacturing company dedicated to providing high-quality, natural health solutions.
                </p>
                <div class="flex space-x-6">
                    <!-- Social Links -->
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Shop</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="/products" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">All Products</a></li>
                            <li><a href="/categories" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Categories</a></li>
                        </ul>
                    </div>
                    <div class="mt-12 md:mt-0">
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Support</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="/contact" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Contact Us</a></li>
                            <li><a href="/faq" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">FAQ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-12 border-t border-gray-200 dark:border-gray-700 pt-8 lg:flex lg:items-center lg:justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Subscribe to our newsletter</h3>
                <p class="mt-2 text-base text-gray-500">The latest news, articles, and resources, sent to your inbox weekly.</p>
            </div>
            <form class="mt-4 sm:flex sm:max-w-md lg:mt-0" onsubmit="event.preventDefault(); alert('Subscribed successfully!');">
                <label for="email-address" class="sr-only">Email address</label>
                <input type="email" name="email-address" id="email-address" autocomplete="email" required class="appearance-none min-w-0 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-4 text-base text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-primary focus:border-primary focus:placeholder-gray-400 sm:max-w-xs" placeholder="Enter your email">
                <div class="mt-3 rounded-md sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                    <button type="submit" class="w-full bg-primary flex items-center justify-center border border-transparent rounded-md py-2 px-4 text-base font-medium text-white hover:bg-primary_hover focus:ring-2 focus:ring-offset-2 focus:ring-primary">Subscribe</button>
                </div>
            </form>
        </div>
        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-base text-gray-400">&copy; <?php echo date('Y'); ?> AAYU CARE. All rights reserved.</p>
            <p class="text-sm text-gray-400 mt-4 md:mt-0">Designed and developed by <a href="https://abhish.in/" target="_blank" class="text-primary hover:underline">abhish.in</a></p>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="back-to-top" class="fixed bottom-24 right-6 sm:bottom-20 z-50 bg-gray-900 text-white p-3 rounded-full shadow-lg hover:bg-gray-700 transition-all transform translate-y-20 opacity-0 focus:outline-none" aria-label="Back to top">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
</button>

<!-- Mobile Bottom App-like Navigation Bar -->
<div class="sm:hidden fixed bottom-0 w-full bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-50 px-6 py-3 flex justify-between items-center pb-safe">
    <a href="/" class="flex flex-col items-center text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        <span class="text-[10px] font-medium">Home</span>
    </a>
    <a href="/categories" class="flex flex-col items-center text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        <span class="text-[10px] font-medium">Categories</span>
    </a>
    <a href="/cart" class="relative flex flex-col items-center text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        <span class="text-[10px] font-medium">Cart</span>
        <?php if ($cartCount > 0): ?>
            <span class="absolute top-0 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[8px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full"><?php echo $cartCount > 99 ? '99+' : $cartCount; ?></span>
        <?php endif; ?>
    </a>
    <a href="<?php echo isset($_SESSION['user_id']) ? '/dashboard' : '/login'; ?>" class="flex flex-col items-center text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        <span class="text-[10px] font-medium">Account</span>
    </a>
</div>

<!-- Add padding to body so bottom nav doesn't hide content -->
<style>
    @media (max-width: 640px) {
        body { padding-bottom: 70px; }
    }
</style>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/910000000000" target="_blank" class="fixed bottom-20 right-6 sm:bottom-6 z-[60] bg-green-500 text-white p-3 rounded-full shadow-2xl hover:bg-green-600 transition-all transform hover:scale-110 flex items-center justify-center animate-bounce shadow-green-500/50" aria-label="Chat on WhatsApp">
    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.489-1.761-1.663-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01a1.08 1.08 0 00-.792.372c-.297.322-1.139 1.115-1.139 2.716s1.164 3.146 1.327 3.369c.163.223 2.296 3.504 5.56 4.908 2.128.917 2.911 1.002 3.966.839 1.206-.188 3.708-1.516 4.228-2.979.52-1.462.52-2.716.366-2.979-.153-.263-.57-.411-.867-.56zM11.996 22C6.483 22 2 17.517 2 12S6.483 2 11.996 2s10.004 4.483 10.004 10-4.49 10-10.004 10z"></path>
    </svg>
</a>

<!-- Promotional Popup -->
<div id="promo-popup" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 hidden opacity-0 transition-opacity duration-500">
    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-sm mx-4 transform scale-95 transition-transform duration-500" id="promo-popup-content">
        <button id="close-popup" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Welcome to AAYU CARE</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Get 10% off your first order of premium Ayurvedic medicines and natural care products!</p>
            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 mb-6 border border-dashed border-gray-300 dark:border-gray-500">
                <span class="text-xl font-mono font-bold tracking-widest text-primary dark:text-green-400">WELCOME10</span>
            </div>
            <button id="copy-code" class="w-full bg-primary text-white font-medium py-3 px-4 rounded-full shadow-lg hover:bg-primary_hover transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Copy Code & Shop Now
            </button>
        </div>
    </div>
</div>

<!-- Global Scripts -->
<script>
    // ----- Promotional Popup Logic -----
    document.addEventListener('DOMContentLoaded', () => {
        const popup = document.getElementById('promo-popup');
        const popupContent = document.getElementById('promo-popup-content');
        const closeBtn = document.getElementById('close-popup');
        const copyBtn = document.getElementById('copy-code');

        // Show after 5 seconds if not seen before
        if (!localStorage.getItem('promo_seen')) {
            setTimeout(() => {
                popup.classList.remove('hidden');
                // Trigger reflow for transition
                void popup.offsetWidth;
                popup.classList.remove('opacity-0');
                popup.classList.add('opacity-100');
                popupContent.classList.remove('scale-95');
                popupContent.classList.add('scale-100');
            }, 5000);
        }

        const closePopup = () => {
            popup.classList.remove('opacity-100');
            popup.classList.add('opacity-0');
            popupContent.classList.remove('scale-100');
            popupContent.classList.add('scale-95');
            setTimeout(() => popup.classList.add('hidden'), 500);
            localStorage.setItem('promo_seen', 'true');
        };

        closeBtn.addEventListener('click', closePopup);

        popup.addEventListener('click', (e) => {
            if (e.target === popup) closePopup();
        });

        copyBtn.addEventListener('click', () => {
            navigator.clipboard.writeText('WELCOME10').then(() => {
                copyBtn.innerHTML = 'Copied! <svg class="w-5 h-5 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                copyBtn.classList.replace('bg-primary', 'bg-green-600');
                setTimeout(() => closePopup(), 1500);
            });
        });
    });

    // ----- Scroll Reveal Animation Logic -----
    document.addEventListener('DOMContentLoaded', () => {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-slide-up');
                    entry.target.classList.remove('opacity-0');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Select elements to animate (e.g., product cards, category boxes)
        const revealElements = document.querySelectorAll('.group.relative, .bg-white.dark\\:bg-gray-800.rounded-xl.shadow-sm');
        revealElements.forEach(el => {
            if (!el.closest('#promo-popup')) {
                el.classList.add('opacity-0');
                observer.observe(el);
            }
        });
    });

    // ----- Sticky Header & Scroll Effects Logic -----
    document.addEventListener('scroll', () => {
        const nav = document.getElementById('main-nav');
        const banner = document.getElementById('top-banner');
        const backToTopBtn = document.getElementById('back-to-top');

        if (window.scrollY > 40) {
            nav.classList.add('scrolled');
            if(banner) banner.classList.add('hidden');
        } else {
            nav.classList.remove('scrolled');
            if(banner) banner.classList.remove('hidden');
        }

        // Back to top button visibility
        if (window.scrollY > 300) {
            backToTopBtn.classList.remove('opacity-0', 'translate-y-20');
            backToTopBtn.classList.add('opacity-100', 'translate-y-0');
        } else {
            backToTopBtn.classList.remove('opacity-100', 'translate-y-0');
            backToTopBtn.classList.add('opacity-0', 'translate-y-20');
        }
    });

    document.getElementById('back-to-top').addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // ----- Theme Toggling Logic -----
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    // On page load or when changing themes, best to add inline in `head` to avoid FOUC,
    // but putting it here for simplicity.
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        darkIcon.classList.remove('hidden');
    } else {
        document.documentElement.classList.remove('dark');
        lightIcon.classList.remove('hidden');
    }

    themeToggleBtn.addEventListener('click', function() {
        // Toggle icons
        darkIcon.classList.toggle('hidden');
        lightIcon.classList.toggle('hidden');

        // If is set in localStorage
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        // If NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
    });

    // ----- AJAX Search Logic -----
    const desktopSearch = document.getElementById('desktop-search');
    const mobileSearch = document.getElementById('mobile-search');
    const desktopResults = document.getElementById('search-results');
    const mobileResults = document.getElementById('mobile-search-results');
    const desktopSpinner = document.getElementById('desktop-search-spinner');
    const mobileSpinner = document.getElementById('mobile-search-spinner');

    // Debounce function to limit API calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => { clearTimeout(timeout); func(...args); };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Function to fetch and display results
    const fetchSearchResults = debounce(async (query, resultsContainer, spinner) => {
        if (!query || query.length < 2) {
            resultsContainer.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => resultsContainer.classList.add('hidden'), 200);
            return;
        }

        if (spinner) spinner.classList.remove('hidden');

        try {
            const response = await fetch('/api/search?q=' + encodeURIComponent(query));
            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();

            if (data.length > 0) {
                let html = '<ul class="divide-y divide-gray-100 dark:divide-gray-700">';
                data.forEach(product => {
                    html += `
                        <li>
                            <a href="/product/${product.slug}" class="block hover:bg-green-50 dark:hover:bg-gray-700 transition-colors p-4 group">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 bg-white rounded-lg overflow-hidden border border-gray-100 shadow-sm group-hover:border-green-200 transition-colors">
                                        <img class="h-12 w-12 object-contain p-1" src="${product.image_url || '/assets/images/placeholder.jpg'}" alt="">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white truncate group-hover:text-primary transition-colors">${product.name}</div>
                                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">$${product.price}</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    `;
                });
                html += '</ul>';
                // Add a "view all" link
                html += `<div class="p-3 bg-gray-50 dark:bg-gray-750 text-center border-t border-gray-100 dark:border-gray-700 rounded-b-xl"><a href="/search?q=${encodeURIComponent(query)}" class="text-sm font-medium text-primary hover:text-primary_hover">View all results &rarr;</a></div>`;

                resultsContainer.innerHTML = html;
            } else {
                resultsContainer.innerHTML = `
                    <div class="p-8 text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">No products found.</p>
                        <p class="text-xs text-gray-500 mt-1">Try adjusting your search terms.</p>
                    </div>`;
            }

            resultsContainer.classList.remove('hidden');
            // small delay for transition
            setTimeout(() => resultsContainer.classList.remove('opacity-0', 'translate-y-2'), 10);

        } catch (error) {
            console.error('Search error:', error);
        } finally {
            if (spinner) spinner.classList.add('hidden');
        }
    }, 300);

    if (desktopSearch && desktopResults) {
        desktopSearch.addEventListener('input', (e) => fetchSearchResults(e.target.value, desktopResults, desktopSpinner));
        desktopSearch.addEventListener('focus', (e) => {
            if (e.target.value.length >= 2) {
                desktopResults.classList.remove('hidden');
                setTimeout(() => desktopResults.classList.remove('opacity-0', 'translate-y-2'), 10);
            }
        });
        document.addEventListener('click', (e) => {
            if (!desktopSearch.contains(e.target) && !desktopResults.contains(e.target)) {
                desktopResults.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => desktopResults.classList.add('hidden'), 200);
            }
        });
    }

    if (mobileSearch && mobileResults) {
        mobileSearch.addEventListener('input', (e) => fetchSearchResults(e.target.value, mobileResults, mobileSpinner));
        mobileSearch.addEventListener('focus', (e) => {
            if (e.target.value.length >= 2) {
                mobileResults.classList.remove('hidden');
                setTimeout(() => mobileResults.classList.remove('opacity-0', 'translate-y-2'), 10);
            }
        });
        document.addEventListener('click', (e) => {
            if (!mobileSearch.contains(e.target) && !mobileResults.contains(e.target)) {
                mobileResults.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => mobileResults.classList.add('hidden'), 200);
            }
        });
    }
</script>
</body>
</html>