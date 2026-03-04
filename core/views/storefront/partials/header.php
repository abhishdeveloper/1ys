<?php
// core/views/storefront/partials/header.php
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Custom E-Commerce Platform'; ?></title>

    <!-- Tailwind CSS (CDN for simple deployment) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Configure Tailwind for Dark Mode -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5', // Indigo-600
                        secondary: '#1f2937', // Gray-800
                    }
                }
            }
        }
    </script>

    <!-- Main Styles -->
    <style>
        body { font-family: 'Inter', sans-serif; transition: background-color 0.3s, color 0.3s; }
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        .dark ::-webkit-scrollbar-track { background: #1f2937; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex flex-col">

<!-- Navigation Bar -->
<nav class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo & Brand -->
            <div class="flex items-center">
                <a href="/" class="flex-shrink-0 flex items-center gap-2">
                    <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">ShopSwift</span>
                </a>
            </div>

            <!-- Intelligent AJAX Search Bar (Desktop) -->
            <div class="hidden sm:flex flex-1 items-center justify-center px-8 relative">
                <div class="w-full max-w-lg relative">
                    <input type="text" id="desktop-search" placeholder="Search for products..."
                        class="w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-full py-2 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white dark:focus:bg-gray-600 transition-colors">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <!-- Search Results Dropdown -->
                    <div id="search-results" class="absolute w-full mt-2 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-xl hidden z-50 max-h-96 overflow-y-auto">
                        <!-- Results injected via JS -->
                    </div>
                </div>
            </div>

            <!-- Right side elements (Theme Toggle, Cart, Profile) -->
            <div class="flex items-center space-x-4">

                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none transition-colors">
                    <!-- Sun Icon -->
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4.22 3.22a1 1 0 011.415 0l.708.707a1 1 0 01-1.414 1.414l-.708-.707a1 1 0 010-1.414zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM14.22 15.364a1 1 0 010 1.414l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 0zM10 18a1 1 0 01-1-1v-1a1 1 0 112 0v1a1 1 0 01-1 1zm-4.22-1.22a1 1 0 01-1.415 0l-.708-.707a1 1 0 011.414-1.414l.708.707a1 1 0 010 1.414zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zm1.22-4.22a1 1 0 010-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707a1 1 0 01-1.414 0zM10 5a5 5 0 100 10 5 5 0 000-10z"></path>
                    </svg>
                    <!-- Moon Icon -->
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>

                <!-- Shopping Cart -->
                <?php
                // Calculate total items in cart
                $cartCount = 0;
                if (isset($_SESSION['cart'])) {
                    $cartCount = array_sum($_SESSION['cart']);
                }
                ?>
                <a href="/cart" class="relative p-2 text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-white transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <?php if ($cartCount > 0): ?>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                        <?php echo $cartCount > 99 ? '99+' : $cartCount; ?>
                    </span>
                    <?php endif; ?>
                </a>

                <!-- User Account / Login -->
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="relative group">
                        <button class="flex items-center space-x-1 text-gray-700 dark:text-gray-300 hover:text-primary font-medium focus:outline-none">
                            <span>Account</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <!-- Dropdown -->
                        <div class="absolute right-0 w-48 mt-2 py-2 bg-white dark:bg-gray-800 rounded-md shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border dark:border-gray-700">
                            <a href="/dashboard" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">My Orders</a>
                            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a href="/admin" class="block px-4 py-2 text-sm text-primary font-semibold hover:bg-gray-100 dark:hover:bg-gray-700">Admin Panel</a>
                            <?php endif; ?>
                            <div class="border-t dark:border-gray-700 my-1"></div>
                            <a href="/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary">Login</a>
                    <a href="/register" class="hidden sm:inline-block text-sm font-medium bg-primary text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Search Bar (Visible only on small screens) -->
        <div class="sm:hidden pb-4 relative">
            <div class="relative w-full">
                <input type="text" id="mobile-search" placeholder="Search..."
                    class="w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-md py-2 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white dark:focus:bg-gray-600">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <!-- Mobile Search Results Dropdown -->
            <div id="mobile-search-results" class="absolute w-full mt-2 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-xl hidden z-50 max-h-96 overflow-y-auto">
                <!-- Results injected via JS -->
            </div>
        </div>
    </div>
</nav>

<!-- Main Content Area -->
<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Display Global Flash Messages -->
    <?php
    $messages = getFlashMessages();
    foreach ($messages as $type => $message): ?>
        <div class="mb-6 p-4 rounded-lg shadow-sm <?php echo $type === 'error' ? 'bg-red-50 text-red-800 border-l-4 border-red-500 dark:bg-red-900/30 dark:text-red-300' : 'bg-green-50 text-green-800 border-l-4 border-green-500 dark:bg-green-900/30 dark:text-green-300'; ?>">
            <?php echo sanitize($message); ?>
        </div>
    <?php endforeach; ?>
