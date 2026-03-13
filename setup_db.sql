CREATE TABLE IF NOT EXISTS `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('site_logo', 'https://myaayucare.com/wp-content/uploads/2025/02/logoaayucare-2.png'),
('promo_banner_1', '✨ Free delivery over ₹399/- ✨'),
('promo_banner_2', '✨ 10% off on orders over ₹599/- ✨'),
('promo_banner_3', '✨ 100% Natural, Cruelty-Free Ayurvedic Care ✨'),
('contact_whatsapp', '910000000000'),
('contact_email', 'info@aayucare.com')
ON DUPLICATE KEY UPDATE `setting_value`=VALUES(`setting_value`);
