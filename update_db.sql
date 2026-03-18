ALTER TABLE `orders` ADD COLUMN `tracking_url` varchar(255) DEFAULT NULL AFTER `delivery_instructions`;
ALTER TABLE `orders` ADD COLUMN `awb_code` varchar(100) DEFAULT NULL AFTER `tracking_url`;
INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES ('shiprocket_email', ''), ('shiprocket_password', '');
