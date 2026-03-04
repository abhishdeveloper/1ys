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
        <div class="mt-12 border-t border-gray-200 dark:border-gray-700 pt-8">
            <p class="text-base text-gray-400 xl:text-center">&copy; <?php echo date('Y'); ?> AAYU CARE. All rights reserved.</p>
        </div>
    </div>
</footer>

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