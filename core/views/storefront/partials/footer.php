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
        <div class="mt-12 border-t border-gray-200 dark:border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-base text-gray-400">&copy; <?php echo date('Y'); ?> AAYU CARE. All rights reserved.</p>
            <p class="text-sm text-gray-400 mt-4 md:mt-0">Designed and developed by <a href="https://abhish.in/" target="_blank" class="text-primary hover:underline">abhish.in</a></p>
        </div>
    </div>
</footer>

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

<!-- Global Scripts -->
<script>
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
    const fetchSearchResults = debounce(async (query, resultsContainer) => {
        if (!query || query.length < 2) {
            resultsContainer.classList.add('hidden');
            return;
        }

        try {
            const response = await fetch('/api/search?q=' + encodeURIComponent(query));
            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();

            if (data.length > 0) {
                let html = '<ul class="divide-y divide-gray-200 dark:divide-gray-700">';
                data.forEach(product => {
                    html += `
                        <li>
                            <a href="/product/${product.slug}" class="block hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-md overflow-hidden">
                                        <img class="h-10 w-10 object-cover" src="${product.image_url || '/assets/images/placeholder.jpg'}" alt="">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">${product.name}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">$${product.price}</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    `;
                });
                html += '</ul>';
                resultsContainer.innerHTML = html;
                resultsContainer.classList.remove('hidden');
            } else {
                resultsContainer.innerHTML = '<div class="p-4 text-sm text-gray-500">No products found.</div>';
                resultsContainer.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Search error:', error);
        }
    }, 300);

    if (desktopSearch && desktopResults) {
        desktopSearch.addEventListener('input', (e) => fetchSearchResults(e.target.value, desktopResults));
        document.addEventListener('click', (e) => {
            if (!desktopSearch.contains(e.target) && !desktopResults.contains(e.target)) {
                desktopResults.classList.add('hidden');
            }
        });
    }

    if (mobileSearch && mobileResults) {
        mobileSearch.addEventListener('input', (e) => fetchSearchResults(e.target.value, mobileResults));
        document.addEventListener('click', (e) => {
            if (!mobileSearch.contains(e.target) && !mobileResults.contains(e.target)) {
                mobileResults.classList.add('hidden');
            }
        });
    }
</script>
</body>
</html>