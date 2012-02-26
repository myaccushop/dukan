ALTER TABLE `customers` ADD COLUMN `guest_account` TINYINT NOT NULL DEFAULT '0' AFTER `customers_newsletter`;

ALTER TABLE `customers` MODIFY COLUMN `customers_password` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `orders` ADD COLUMN `customers_dummy_account` TINYINT UNSIGNED NOT NULL AFTER `customers_address_format_id`;