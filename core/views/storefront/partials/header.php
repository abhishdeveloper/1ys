<?php
// core/views/storefront/partials/header.php
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic SEO Meta Tags -->
    <title><?php echo $pageTitle ?? 'AAYU CARE | Premium Ayurvedic Manufacturing'; ?></title>
    <meta name="description" content="<?php echo $metaDescription ?? 'Discover nature\'s healing with AAYU CARE. We specialize in high-quality Ayurvedic medicines, roll-ons, and natural care products.'; ?>">
    <meta name="keywords" content="<?php echo $metaKeywords ?? 'Ayurveda, herbal medicine, natural care, third party manufacturing, roll ons, lip balm, health'; ?>">
    <link rel="canonical" href="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>" />

    <!-- Open Graph for Social Sharing -->
    <meta property="og:title" content="<?php echo $pageTitle ?? 'AAYU CARE | Premium Ayurvedic Manufacturing'; ?>" />
    <meta property="og:description" content="<?php echo $metaDescription ?? 'Discover nature\'s healing with AAYU CARE. High-quality Ayurvedic medicines and natural care products.'; ?>" />
    <meta property="og:image" content="<?php echo $ogImage ?? 'https://myaayucare.com/wp-content/uploads/2025/02/logoaayucare-2.png'; ?>" />
    <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>" />
    <meta property="og:type" content="<?php echo isset($product) ? 'product' : 'website'; ?>" />

    <!-- Google Fonts for Royal Aesthetic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN for simple deployment) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Configure Tailwind for Dark Mode -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#1a3622', // Deep Forest Green
                        primary_hover: '#122618',
                        secondary: '#fbf8f1', // Off-white/Cream
                        accent: '#c27b3b', // Elegant Gold/Orange
                        accent_hover: '#a66831',
                    },
                    fontFamily: {
                        sans: ['Lato', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out forwards',
                        'zoom-in': 'zoomIn 1.5s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        zoomIn: {
                            '0%': { transform: 'scale(1.05)' },
                            '100%': { transform: 'scale(1)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Main Styles -->
    <style>
        body { font-family: 'Lato', sans-serif; background-color: #fbf8f1; color: #1a3622; transition: background-color 0.3s, color 0.3s; scroll-behavior: smooth; }
        .font-serif { font-family: 'Playfair Display', serif; }
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        .dark ::-webkit-scrollbar-track { background: #1f2937; }
        ::-webkit-scrollbar-thumb { background: #166534; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #14532d; }

        /* Floating Animation for Hero Images */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* Glassmorphism utility */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .dark .glass {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(255,255,255,0.05);
        }

        /* Sticky Header Transition */
        #main-nav.scrolled {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            background: rgba(255, 255, 255, 0.95);
        }
        .dark #main-nav.scrolled {
            background: rgba(31, 41, 55, 0.95);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex flex-col antialiased selection:bg-primary selection:text-white">

<!-- Top Banner -->
<div id="top-banner" class="bg-gradient-to-r from-primary to-green-600 text-white text-center py-2 text-sm font-medium tracking-wide shadow-inner transition-all duration-300">
    ✨ Free Delivery above order value ₹299/-
</div>

<!-- Navigation Bar -->
<nav id="main-nav" class="bg-secondary dark:bg-gray-900 shadow-sm sticky top-0 z-50 border-b border-gray-200 dark:border-gray-800 transition-all duration-300 py-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center h-16">

            <!-- Left Navigation (Desktop) -->
            <div class="hidden md:flex space-x-8">
                <a href="/products" class="text-sm font-semibold text-primary dark:text-gray-300 hover:text-accent uppercase tracking-widest transition-colors">Shop</a>
                <a href="/categories" class="text-sm font-semibold text-primary dark:text-gray-300 hover:text-accent uppercase tracking-widest transition-colors">Collections</a>
            </div>

            <!-- Logo & Brand (Centered) -->
            <div class="flex-1 flex justify-center md:flex-none md:absolute md:left-1/2 md:transform md:-translate-x-1/2">
                <a href="/" class="flex flex-col items-center">
                    <img class="h-12 w-auto mb-1" src="https://myaayucare.com/wp-content/uploads/2025/02/logoaayucare-2.png" alt="AAYU CARE Logo">
                    <span class="font-serif font-bold text-xl tracking-widest text-primary dark:text-white uppercase">Aayu Care</span>
                </a>
            </div>

            <!-- Right side elements (Search, Theme Toggle, Cart, Profile) -->
            <div class="flex items-center space-x-4 md:space-x-6">

                <!-- Desktop Search Trigger (Expands) -->
                <div class="hidden sm:block relative group">
                    <form action="/search" method="GET" class="relative flex items-center">
                        <input type="text" id="desktop-search" name="q" placeholder="Search..." autocomplete="off"
                            value="<?php echo isset($_GET['q']) && is_string($_GET['q']) ? sanitize($_GET['q']) : ''; ?>"
                            class="w-48 focus:w-64 bg-transparent border-b border-gray-300 dark:border-gray-600 text-primary dark:text-white py-1 px-2 focus:outline-none focus:border-accent transition-all duration-300 text-sm placeholder-gray-400">
                        <button type="submit" class="absolute right-2 text-gray-400 hover:text-accent transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        <!-- Loading Spinner -->
                        <div id="desktop-search-spinner" class="absolute right-8 text-accent hidden animate-spin">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <!-- Search Results Dropdown -->
                        <div id="search-results" class="absolute right-0 top-full mt-4 w-80 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded shadow-xl hidden z-50 max-h-[70vh] overflow-y-auto transform opacity-0 translate-y-2 transition-all duration-200">
                            <!-- Results injected via JS -->
                        </div>
                    </form>
                </div>

                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="text-primary hover:text-accent dark:text-gray-300 dark:hover:text-accent focus:outline-none transition-colors">
                    <!-- Sun Icon -->
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4.22 3.22a1 1 0 011.415 0l.708.707a1 1 0 01-1.414 1.414l-.708-.707a1 1 0 010-1.414zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM14.22 15.364a1 1 0 010 1.414l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 0zM10 18a1 1 0 01-1-1v-1a1 1 0 112 0v1a1 1 0 01-1 1zm-4.22-1.22a1 1 0 01-1.415 0l-.708-.707a1 1 0 011.414-1.414l.708.707a1 1 0 010 1.414zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zm1.22-4.22a1 1 0 010-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707a1 1 0 01-1.414 0zM10 5a5 5 0 100 10 5 5 0 000-10z"></path>
                    </svg>
                    <!-- Moon Icon -->
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>

                <!-- User Account / Login -->
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="relative group">
                        <button class="flex items-center text-primary dark:text-gray-300 hover:text-accent font-medium focus:outline-none uppercase tracking-widest text-xs transition-colors">
                            <span>Account</span>
                        </button>
                        <!-- Dropdown -->
                        <div class="absolute right-0 w-48 mt-4 py-2 bg-white dark:bg-gray-800 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-100 dark:border-gray-700">
                            <a href="/dashboard" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-accent transition-colors">My Orders</a>
                            <a href="/change-password" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-accent transition-colors">Change Password</a>
                            <?php if(isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'seller'])): ?>
                                <a href="/admin" class="block px-4 py-2 text-sm text-accent font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">Management Panel</a>
                            <?php endif; ?>
                            <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                            <a href="/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" class="text-xs font-semibold text-primary dark:text-gray-300 hover:text-accent uppercase tracking-widest transition-colors">Sign In</a>
                <?php endif; ?>

                <!-- Shopping Cart -->
                <?php
                // Calculate total items in cart
                $cartCount = 0;
                if (isset($_SESSION['cart'])) {
                    $cartCount = array_sum($_SESSION['cart']);
                }
                ?>
                <a href="/cart" class="relative text-primary dark:text-gray-300 hover:text-accent transition-colors flex items-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <?php if ($cartCount > 0): ?>
                    <span class="absolute -top-1 -right-2 inline-flex items-center justify-center px-1.5 py-0.5 text-[9px] font-bold leading-none text-white bg-accent rounded-full border border-white dark:border-gray-900">
                        <?php echo $cartCount > 99 ? '99+' : $cartCount; ?>
                    </span>
                    <?php endif; ?>
                </a>

            </div>
        </div>

        <!-- Mobile Search Bar (Visible only on small screens) -->
        <div class="sm:hidden mt-2 relative z-50">
            <form action="/search" method="GET" class="relative w-full">
                <input type="text" id="mobile-search" name="q" placeholder="Search Ayurveda..." autocomplete="off"
                    value="<?php echo isset($_GET['q']) && is_string($_GET['q']) ? sanitize($_GET['q']) : ''; ?>"
                    class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-primary dark:text-white rounded py-2 pl-10 pr-10 focus:outline-none focus:border-accent transition-all shadow-sm text-sm">
                <button type="submit" class="absolute left-3 top-2 text-gray-400 hover:text-accent transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <div id="mobile-search-spinner" class="absolute right-3 top-2 text-accent hidden animate-spin">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </form>
            <!-- Mobile Search Results Dropdown -->
            <div id="mobile-search-results" class="absolute w-full mt-1 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-2xl hidden z-[60] max-h-96 overflow-y-auto transform opacity-0 translate-y-2 transition-all duration-200">
                <!-- Results injected via JS -->
            </div>
        </div>
    </div>
</nav>

<!-- Main Content Area -->
<main class="flex-grow w-full py-8 animate-fade-in pb-16">

    <!-- Display Global Flash Messages -->
    <?php
    $messages = getFlashMessages();
    foreach ($messages as $type => $message): ?>
        <div class="mb-6 p-4 rounded-lg shadow-sm <?php echo $type === 'error' ? 'bg-red-50 text-red-800 border-l-4 border-red-500 dark:bg-red-900/30 dark:text-red-300' : 'bg-green-50 text-green-800 border-l-4 border-green-500 dark:bg-green-900/30 dark:text-green-300'; ?>">
            <?php echo sanitize($message); ?>
        </div>
    <?php endforeach; ?>
