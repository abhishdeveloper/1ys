<?php
// core/views/admin/partials/header.php
$role = $_SESSION['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Admin Panel'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#166534', // Green-800 (Ayurvedic theme)
                        primary_hover: '#14532d', // Green-900
                    }
                }
            }
        }
    </script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="h-full">

<div class="min-h-full flex">
    <!-- Sidebar Navigation -->
    <div class="hidden md:flex md:w-64 md:flex-col">
        <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-gray-800">
            <div class="flex items-center flex-shrink-0 px-4">
                <span class="text-white text-xl font-bold tracking-wider">AAYU CARE Admin</span>
            </div>
            <div class="mt-5 flex-1 flex flex-col">
                <nav class="flex-1 px-2 pb-4 space-y-1">
                    <a href="/admin" class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        Dashboard
                    </a>

                    <a href="/admin/products" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        Products
                    </a>

                    <a href="/admin/orders" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        Orders
                    </a>

                    <?php if ($role === 'admin'): ?>
                    <a href="/admin/coupons" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        Coupons
                    </a>
                    <?php endif; ?>
                </nav>
            </div>
            <div class="flex-shrink-0 flex bg-gray-700 p-4">
                <a href="/" class="flex-shrink-0 w-full group block">
                    <div class="flex items-center">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">Back to Store</p>
                            <p class="text-xs font-medium text-gray-300 group-hover:text-gray-200">View Public Site</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col flex-1 w-0 overflow-hidden">
        <!-- Top header -->
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
            <div class="flex-1 px-4 flex justify-between">
                <div class="flex-1 flex items-center">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <?php echo ucfirst($role); ?> Panel
                    </h2>
                </div>
                <div class="ml-4 flex items-center md:ml-6">
                    <a href="/logout" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none">
                        Logout
                    </a>
                </div>
            </div>
        </div>

        <main class="flex-1 relative overflow-y-auto focus:outline-none">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    <!-- Flash Messages -->
                    <?php
                    $messages = getFlashMessages();
                    foreach ($messages as $type => $message): ?>
                        <div class="mb-4 p-4 rounded-md shadow-sm <?php echo $type === 'error' ? 'bg-red-50 text-red-800 border-l-4 border-red-500' : 'bg-green-50 text-green-800 border-l-4 border-green-500'; ?>">
                            <?php echo sanitize($message); ?>
                        </div>
                    <?php endforeach; ?>
