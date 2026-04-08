-- Add rich content and badges to products table
ALTER TABLE `products`
ADD COLUMN `how_to_use` TEXT NULL AFTER `description`,
ADD COLUMN `ingredients` TEXT NULL AFTER `how_to_use`,
ADD COLUMN `benefits` TEXT NULL AFTER `ingredients`,
ADD COLUMN `faqs` JSON NULL AFTER `benefits`,
ADD COLUMN `badges` JSON NULL AFTER `faqs`;

-- Create product variants table
CREATE TABLE `product_variants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `name` varchar(100) NOT NULL, -- e.g., '50g', '100ml'
  `sku` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int NOT NULL DEFAULT '0',
  `weight_kg` decimal(6,2) DEFAULT '0.00',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_variant_product` (`product_id`),
  CONSTRAINT `fk_variant_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create reviews table
CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` tinyint NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `comment` text,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_review_product` (`product_id`),
  KEY `fk_review_user` (`user_id`),
  CONSTRAINT `fk_review_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_review_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add variant_id to order items
ALTER TABLE `order_items` ADD COLUMN `variant_id` INT NULL AFTER `product_id`;
ALTER TABLE `order_items` ADD CONSTRAINT `fk_order_item_variant` FOREIGN KEY (`variant_id`) REFERENCES `product_variants`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Add coordinates to orders
ALTER TABLE `orders` ADD COLUMN `latitude` DECIMAL(10,8) NULL AFTER `shipping_address`;
ALTER TABLE `orders` ADD COLUMN `longitude` DECIMAL(11,8) NULL AFTER `latitude`;

-- Add Google Auth Settings
INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES
('google_client_id', ''),
('google_client_secret', '');
