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
                        primary: '#1c3125', // Deeper, more muted Forest Green
                        primary_hover: '#14251b',
                        secondary: '#faf7f2', // Soft Off-white/Cream
                        accent: '#b89053', // Metallic Gold/Bronze
                        accent_hover: '#9a7642',
                    },
                    fontFamily: {
                        sans: ['Lato', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 1.2s ease-out',
                        'slide-up': 'slideUp 1.2s cubic-bezier(0.2, 0.8, 0.2, 1) forwards',
                        'slide-up-fade': 'slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'zoom-in': 'zoomIn 2s ease-out forwards',
                        'slow-pan': 'slowPan 30s linear infinite alternate',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(40px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideUpFade: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        zoomIn: {
                            '0%': { transform: 'scale(1.05)' },
                            '100%': { transform: 'scale(1)' },
                        },
                        slowPan: {
                            '0%': { backgroundPosition: '0% 0%' },
                            '100%': { backgroundPosition: '100% 100%' },
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
<body class="bg-[#fcfaf7] text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex flex-col antialiased selection:bg-primary selection:text-white relative">
<!-- Elegant subtle textured background overlaid on body -->
<div class="fixed inset-0 pointer-events-none z-[-1] opacity-40 mix-blend-multiply bg-[url('https://www.transparenttextures.com/patterns/cream-paper.png')] dark:hidden"></div>

<?php
// Check if we are on the home page for transparent header logic
$isHome = ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/home');

// Wrap both Top Banner and Nav in a single container for homepage to handle absolute positioning properly
$headerContainerClasses = 'sticky top-0 w-full z-50';
$navClasses = $isHome
    ? 'bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-white/10 shadow-[0_4px_30px_rgba(0,0,0,0.1)]'
    : 'bg-secondary dark:bg-gray-900 shadow-sm border-b border-gray-200/50 dark:border-gray-800/50';
?>

<div class="<?php echo $headerContainerClasses; ?>">
    <!-- Top Banner (Typewriter Effect) -->
    <div id="top-banner" class="bg-primary text-secondary text-center py-2 text-sm font-medium tracking-wider shadow-inner transition-all duration-300 border-b border-accent/30 relative z-50 overflow-hidden h-9 flex items-center justify-center">
        <span id="typewriter-text" class="inline-block border-r-2 border-accent pr-1 animate-pulse"></span>
    </div>

    <!-- Navigation Bar -->
    <nav id="main-nav" class="<?php echo $navClasses; ?> transition-all duration-500 font-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-4 md:py-6">

        <!-- Row 1: Logo, Brand Text, and Menu -->
        <div class="flex justify-between items-center">

            <!-- Logo & Brand (Left) -->
            <div class="flex items-center space-x-4">
                <a href="/" class="flex items-center space-x-3 group">
                    <img class="h-10 w-auto group-hover:opacity-80 transition-opacity duration-300" src="https://myaayucare.com/wp-content/uploads/2025/02/logoaayucare-2.png" alt="AAYU CARE Logo">
                    <span class="font-serif font-medium text-2xl tracking-[0.2em] text-primary dark:text-white uppercase transition-colors group-hover:text-accent">Aayu Care</span>
                </a>
            </div>

            <!-- Main Menu (Right/Center) -->
            <div class="hidden md:flex space-x-10">
                <a href="/" class="text-[11px] font-medium text-primary dark:text-gray-200 hover:text-accent uppercase tracking-[0.15em] transition-colors pb-1 border-b border-transparent hover:border-accent"><?php echo __('home'); ?></a>
                <a href="/products" class="text-[11px] font-medium text-primary dark:text-gray-200 hover:text-accent uppercase tracking-[0.15em] transition-colors pb-1 border-b border-transparent hover:border-accent"><?php echo __('shop'); ?></a>
                <a href="/categories" class="text-[11px] font-medium text-primary dark:text-gray-200 hover:text-accent uppercase tracking-[0.15em] transition-colors pb-1 border-b border-transparent hover:border-accent"><?php echo __('categories'); ?></a>
            </div>

            <!-- Right Actions (Cart, Profile, Theme) -->
            <div class="flex items-center space-x-6">

                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="text-primary hover:text-accent dark:text-gray-300 dark:hover:text-accent focus:outline-none transition-colors">
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>

                <!-- User Account / Login -->
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="relative group">
                        <button class="flex items-center text-primary dark:text-gray-300 hover:text-accent font-medium focus:outline-none uppercase tracking-[0.15em] text-[11px] transition-colors">
                            <span><?php echo __('dashboard'); ?></span>
                        </button>
                        <!-- Dropdown -->
                        <div class="absolute right-0 w-48 mt-4 py-2 bg-white/95 backdrop-blur-md dark:bg-gray-900/95 shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-100 dark:border-gray-800">
                            <a href="/dashboard" class="block px-4 py-2.5 text-xs tracking-wider text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-accent transition-colors">My Orders</a>
                            <a href="/change-password" class="block px-4 py-2.5 text-xs tracking-wider text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-accent transition-colors">Change Password</a>
                            <?php if(isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'seller'])): ?>
                                <a href="/admin" class="block px-4 py-2.5 text-xs tracking-wider text-accent font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">Management Panel</a>
                            <?php endif; ?>
                            <div class="border-t border-gray-100 dark:border-gray-800 my-1"></div>
                            <a href="/logout" class="block px-4 py-2.5 text-xs tracking-wider text-red-500 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" class="text-[11px] font-medium text-primary dark:text-gray-300 hover:text-accent uppercase tracking-[0.15em] transition-colors pb-1 border-b border-transparent hover:border-accent"><?php echo __('login'); ?></a>
                <?php endif; ?>

                <!-- Shopping Cart -->
                <?php
                $cartCount = 0;
                if (isset($_SESSION['cart'])) {
                    $cartCount = array_sum($_SESSION['cart']);
                }
                ?>
                <a href="/cart" class="relative text-primary dark:text-gray-300 hover:text-accent transition-colors flex items-center">
                    <svg class="h-6 w-6 stroke-[1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <?php if ($cartCount > 0): ?>
                    <span class="absolute -top-1.5 -right-2.5 inline-flex items-center justify-center w-4 h-4 text-[9px] font-semibold text-white bg-accent rounded-full shadow-sm">
                        <?php echo $cartCount > 99 ? '99+' : $cartCount; ?>
                    </span>
                    <?php endif; ?>
                </a>
            </div>
        </div>

        <!-- Row 2: Search Bar and Language Toggle -->
        <div class="flex justify-between items-end mt-4 md:mt-6 pb-2 border-b border-primary/20 dark:border-gray-700/50">

            <!-- Minimal Search Bar -->
            <div class="w-full max-w-xl relative">
                <form action="/search" method="GET" class="relative flex items-center w-full">
                    <input type="text" id="desktop-search" name="q" placeholder="<?php echo __('search_placeholder'); ?>" autocomplete="off"
                        value="<?php echo isset($_GET['q']) && is_string($_GET['q']) ? sanitize($_GET['q']) : ''; ?>"
                        class="w-full bg-transparent border-none text-primary dark:text-white py-1 px-1 focus:outline-none transition-all duration-300 text-sm placeholder-gray-400 dark:placeholder-gray-500 font-light">
                    <button type="submit" class="absolute right-1 text-gray-400 hover:text-accent transition-colors">
                        <svg class="h-4 w-4 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
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
                    <div id="search-results" class="absolute left-0 top-full mt-3 w-full bg-white/95 backdrop-blur-md dark:bg-gray-900/95 border border-gray-100 dark:border-gray-800 shadow-2xl hidden z-50 max-h-[70vh] overflow-y-auto transform opacity-0 translate-y-2 transition-all duration-300">
                        <!-- Results injected via JS -->
                    </div>
                </form>
            </div>

            <!-- Language Toggle (Text-based, elegant) -->
            <div class="ml-6 shrink-0 mb-1">
                <?php $currentLang = $_SESSION['lang'] ?? 'en'; ?>
                <a href="/lang?lang=<?php echo $currentLang === 'en' ? 'hi' : 'en'; ?>"
                   class="text-[10px] text-gray-500 hover:text-accent dark:text-gray-400 uppercase tracking-[0.2em] transition-colors pb-1 border-b border-transparent hover:border-accent">
                   <?php echo __('switch_lang'); ?>
                </a>
            </div>

        </div>

    </div>
    </nav>
</div>

<!-- Main Content Area -->
<?php
// Adjust top padding if not on home to account for fixed header
$mainClasses = $isHome ? 'w-full animate-fade-in pb-16' : 'flex-grow w-full py-8 animate-fade-in pb-16';
?>
<main class="<?php echo $mainClasses; ?>">

    <!-- Display Global Flash Messages -->
    <?php
    $messages = getFlashMessages();
    foreach ($messages as $type => $message): ?>
        <div class="mb-6 p-4 rounded-lg shadow-sm max-w-7xl mx-auto mt-4 <?php echo $type === 'error' ? 'bg-red-50 text-red-800 border-l-4 border-red-500 dark:bg-red-900/30 dark:text-red-300' : 'bg-green-50 text-green-800 border-l-4 border-green-500 dark:bg-green-900/30 dark:text-green-300'; ?>">
            <?php echo sanitize($message); ?>
        </div>
    <?php endforeach; ?>
