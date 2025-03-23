-- Create users table
CREATE TABLE `users` (
 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
 `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
 `email_verified_at` timestamp NULL DEFAULT NULL,
 `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
 `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `created_at` timestamp NULL DEFAULT NULL,
 `updated_at` timestamp NULL DEFAULT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create bookings table
CREATE TABLE `bookings` (
 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
 `user_id` bigint unsigned NOT NULL,
 `business_id` bigint unsigned NOT NULL,
 `date_time` datetime NOT NULL,
 `client_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
 `personal_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
 `description` text COLLATE utf8mb4_general_ci,
 `notification_method` enum('SMS','Email') COLLATE utf8mb4_general_ci NOT NULL,
 `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `doctor_id` bigint unsigned DEFAULT NULL,
 `hairstylist_id` bigint unsigned DEFAULT NULL,
 `table_id` bigint unsigned DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `fk_bookings_user` (`user_id`),
 KEY `bookings_doctor_id_foreign` (`doctor_id`),
 KEY `fk_bookings_business` (`business_id`),
 KEY `fk_bookings_hairstylist` (`hairstylist_id`),
 KEY `fk_bookings_table` (`table_id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create business_types table
CREATE TABLE `business_types` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert business_types
INSERT INTO `business_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Doctor', NOW(), NOW()),
(2, 'Restaurant', NOW(), NOW()),
(3, 'Hair Salon', NOW(), NOW());

-- Create businesses table
CREATE TABLE `businesses` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    `business_type_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `location` VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `phone` VARCHAR(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `email` VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `description` TEXT COLLATE utf8mb4_general_ci,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert businesses
INSERT INTO `businesses` (`id`, `name`, `business_type_id`, `user_id`, `location`, `phone`, `email`, `description`, `created_at`, `updated_at`) VALUES
(1, 'City Medical Center', 1, 1, 'Downtown', '123-456-7890', 'info@citymed.com', 'Welcome to City Medical Center, your best choice for healthcare.', NOW(), NOW()),
(2, 'The Fancy Restaurant', 2, 1, 'Main Street', '555-789-1234', 'contact@fancyrest.com', 'Welcome to The Fancy Restaurant, your best choice for dining.', NOW(), NOW()),
(3, 'Modern Hair Studio', 3, 1, 'Market Square', '987-654-3210', 'hello@modernhair.com', 'Welcome to Modern Hair Studio, your best choice for hair styling.', NOW(), NOW());

-- Create doctors table
CREATE TABLE `doctors` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `business_id` BIGINT UNSIGNED DEFAULT NULL,
    `name` VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    `specialty` VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert doctors
INSERT INTO `doctors` (`id`, `business_id`, `name`, `specialty`, `created_at`, `updated_at`) VALUES
(1, 1, 'д-р Иванов', 'Очен', NULL, NULL),
(2, 1, 'д-р Петрова', 'Кардиолог', NULL, NULL),
(3, 1, 'д-р Антонова', 'Педиатър', NULL, NULL);

-- Create hairstylists table
CREATE TABLE `hairstylists` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `business_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    `specialization` VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert hairstylists
INSERT INTO `hairstylists` (`id`, `business_id`, `name`, `specialization`, `created_at`, `updated_at`) VALUES
(1, 3, 'Анна Петрова', 'Боядисване и стилизиране', '2025-03-21 13:15:25', '2025-03-21 15:12:11'),
(2, 3, 'Иван Стоянов', 'Подстригване и бради', '2025-03-21 13:15:25', '2025-03-21 15:12:18'),
(3, 3, 'Мила Николова', 'Мъжки прически', '2025-03-21 13:15:25', '2025-03-21 15:12:25');

-- Create tables (restaurant tables)
CREATE TABLE `tables` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `business_id` BIGINT UNSIGNED NOT NULL,
    `number` INT NOT NULL,
    `seats` INT NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert tables
INSERT INTO `tables` (`id`, `business_id`, `number`, `seats`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 4, '2025-03-21 13:17:41', '2025-03-21 15:13:00'),
(2, 2, 2, 2, '2025-03-21 13:17:41', '2025-03-21 15:13:09'),
(3, 2, 3, 6, '2025-03-21 13:17:41', '2025-03-21 15:13:16'),
(4, 2, 1, 2, '2025-03-21 13:17:41', '2025-03-21 15:13:24'),
(5, 2, 2, 4, '2025-03-21 13:17:41', '2025-03-21 15:13:33');
