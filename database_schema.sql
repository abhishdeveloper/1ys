-- phpMyAdmin SQL Dump
-- Host: localhost
-- Server version: 8.x
-- PHP Version: 8.x
--
-- Database: `ecommerce_db`
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
-- The password for the admin account is: password123
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `password_hash`, `phone`, `address`) VALUES
(1, 'admin', 'Admin User', 'admin@shopswift.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0100', '123 Admin Street, Tech City'),
(2, 'customer', 'Demo Customer', 'customer@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0101', '456 Shopper Lane, Commerce Town');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`) VALUES
(1, 'Electronics', 'electronics', 'The latest gadgets and tech accessories.', 1),
(2, 'Clothing', 'clothing', 'Apparel for all seasons and styles.', 1),
(3, 'Home & Garden', 'home-garden', 'Everything you need to make your house a home.', 1),
(4, 'Sports & Outdoors', 'sports-outdoors', 'Gear up for your next adventure.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `weight_kg` decimal(6,2) DEFAULT '0.00',
  `stock_quantity` int NOT NULL DEFAULT '0',
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_product_category` (`category_id`),
  CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `weight_kg`, `stock_quantity`, `image_url`, `is_active`) VALUES
(1, 1, 'Premium Wireless Headphones', 'premium-wireless-headphones', 'Experience the ultimate sound quality with our premium wireless headphones. Features active noise cancellation, 40 hours of battery life, and plush ear cushions for all-day comfort.', 149.99, '0.45', 50, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80', 1),
(2, 1, 'Smart Watch Series X', 'smart-watch-series-x', 'Stay connected and track your fitness goals with the Smart Watch Series X. Includes heart rate monitoring, GPS, and a water-resistant design.', 199.50, '0.15', 30, 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=800&q=80', 1),
(3, 1, 'Portable Bluetooth Speaker', 'portable-bluetooth-speaker', 'Take your music anywhere with this rugged, waterproof portable Bluetooth speaker. Delivers 360-degree sound and deep bass.', 59.99, '0.80', 100, 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=800&q=80', 1),
(4, 2, 'Classic Cotton T-Shirt', 'classic-cotton-t-shirt', 'A wardrobe essential. Made from 100% organic cotton, this t-shirt is breathable, durable, and stylishly simple.', 19.99, '0.20', 200, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80', 1),
(5, 2, 'Denim Jacket', 'denim-jacket', 'A timeless classic. This vintage-wash denim jacket features a comfortable fit and durable construction.', 89.99, '1.20', 45, 'https://images.unsplash.com/photo-1576871337622-98d48d1cf531?w=800&q=80', 1),
(6, 3, 'Ceramic Coffee Mug', 'ceramic-coffee-mug', 'Start your morning right with this handcrafted ceramic coffee mug. Microwave and dishwasher safe.', 14.50, '0.40', 120, 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=800&q=80', 1),
(7, 3, 'Indoor Potted Plant', 'indoor-potted-plant', 'Bring a touch of nature indoors. This low-maintenance potted plant is perfect for desks and shelves.', 34.00, '2.50', 25, 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=800&q=80', 1),
(8, 4, 'Yoga Mat', 'yoga-mat', 'Eco-friendly, non-slip yoga mat with alignment lines. Includes a carrying strap for easy transport.', 29.99, '1.10', 80, 'https://images.unsplash.com/photo-1592432678016-e910b452f9a2?w=800&q=80', 1);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_order_value` decimal(10,2) DEFAULT '0.00',
  `max_discount` decimal(10,2) DEFAULT NULL,
  `valid_from` datetime DEFAULT NULL,
  `valid_until` datetime DEFAULT NULL,
  `usage_limit` int DEFAULT NULL,
  `times_used` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `min_order_value`, `max_discount`, `valid_from`, `valid_until`, `usage_limit`, `times_used`, `is_active`) VALUES
(1, 'WELCOME10', 'percentage', 10.00, '50.00', '20.00', '2023-01-01 00:00:00', '2030-12-31 23:59:59', 1000, 0, 1),
(2, 'SAVE20', 'fixed', 20.00, '100.00', NULL, '2023-01-01 00:00:00', '2030-12-31 23:59:59', 500, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) DEFAULT '0.00',
  `discount_amount` decimal(10,2) DEFAULT '0.00',
  `coupon_id` int DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'razorpay',
  `razorpay_order_id` varchar(100) DEFAULT NULL,
  `razorpay_payment_id` varchar(100) DEFAULT NULL,
  `razorpay_signature` varchar(255) DEFAULT NULL,
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `order_status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `fk_order_user` (`user_id`),
  KEY `fk_order_coupon` (`coupon_id`),
  CONSTRAINT `fk_order_coupon` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_item_order` (`order_id`),
  KEY `fk_order_item_product` (`product_id`),
  CONSTRAINT `fk_order_item_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_item_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;
