-- ========================================
-- Somiti Management System Database
-- Version 1.0
-- ========================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ========================================
-- Users Table
-- ========================================
CREATE TABLE IF NOT EXISTS `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `mobile` VARCHAR(20) NOT NULL,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `photo` VARCHAR(255) NULL,
    `nid_number` VARCHAR(50) NULL,
    `nid_image` VARCHAR(255) NULL,
    `birth_certificate` VARCHAR(255) NULL,
    `address` TEXT NOT NULL,
    `member_id` VARCHAR(50) NULL UNIQUE,
    `tracking_code` VARCHAR(50) NOT NULL UNIQUE,
    `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    `role` VARCHAR(50) DEFAULT 'user',
    `is_admin` TINYINT(1) DEFAULT 0,
    `approved_at` TIMESTAMP NULL,
    `rejected_reason` TEXT NULL,
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_email` (`email`),
    INDEX `idx_tracking_code` (`tracking_code`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Settings Table
-- ========================================
CREATE TABLE IF NOT EXISTS `settings` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) NOT NULL UNIQUE,
    `value` LONGTEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- News Table
-- ========================================
CREATE TABLE IF NOT EXISTS `news` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title_bn` VARCHAR(255) NOT NULL,
    `title_en` VARCHAR(255) NOT NULL,
    `content_bn` LONGTEXT NOT NULL,
    `content_en` LONGTEXT NOT NULL,
    `image` VARCHAR(255) NULL,
    `status` ENUM('draft', 'published') DEFAULT 'draft',
    `admin_id` BIGINT UNSIGNED NOT NULL,
    `published_at` TIMESTAMP NULL,
    `deleted_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Notices Table
-- ========================================
CREATE TABLE IF NOT EXISTS `notices` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title_bn` VARCHAR(255) NOT NULL,
    `title_en` VARCHAR(255) NOT NULL,
    `content_bn` LONGTEXT NOT NULL,
    `content_en` LONGTEXT NOT NULL,
    `priority` INT DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `admin_id` BIGINT UNSIGNED NOT NULL,
    `published_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    INDEX `idx_priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Activities Table
-- ========================================
CREATE TABLE IF NOT EXISTS `activities` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title_bn` VARCHAR(255) NOT NULL,
    `title_en` VARCHAR(255) NOT NULL,
    `description_bn` LONGTEXT NOT NULL,
    `description_en` LONGTEXT NOT NULL,
    `image` VARCHAR(255) NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `admin_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Comments Table
-- ========================================
CREATE TABLE IF NOT EXISTS `comments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `news_id` BIGINT UNSIGNED NULL,
    `content` TEXT NOT NULL,
    `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- DPS Schemes Table
-- ========================================
CREATE TABLE IF NOT EXISTS `dps_schemes` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name_bn` VARCHAR(255) NOT NULL,
    `name_en` VARCHAR(255) NOT NULL,
    `description_bn` LONGTEXT NOT NULL,
    `description_en` LONGTEXT NOT NULL,
    `monthly_amount` DECIMAL(10, 2) NOT NULL,
    `total_months` INT NOT NULL,
    `profit_rate` DECIMAL(5, 2) NOT NULL DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- DPS Accounts Table
-- ========================================
CREATE TABLE IF NOT EXISTS `dps_accounts` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `dps_scheme_id` BIGINT UNSIGNED NOT NULL,
    `account_number` VARCHAR(50) NOT NULL UNIQUE,
    `total_amount` DECIMAL(12, 2) DEFAULT 0,
    `current_month` INT DEFAULT 0,
    `status` ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    `started_at` TIMESTAMP NULL,
    `completed_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`dps_scheme_id`) REFERENCES `dps_schemes` (`id`) ON DELETE CASCADE,
    INDEX `idx_user_id` (`user_id`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Loans Table
-- ========================================
CREATE TABLE IF NOT EXISTS `loans` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `amount` DECIMAL(12, 2) NOT NULL,
    `duration_months` INT NOT NULL,
    `interest_rate` DECIMAL(5, 2) NOT NULL DEFAULT 0,
    `purpose_bn` TEXT NOT NULL,
    `purpose_en` TEXT NOT NULL,
    `status` ENUM('pending', 'approved', 'rejected', 'completed') DEFAULT 'pending',
    `approved_at` TIMESTAMP NULL,
    `rejected_reason` TEXT NULL,
    `admin_id` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
    INDEX `idx_user_id` (`user_id`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Loan Payments Table
-- ========================================
CREATE TABLE IF NOT EXISTS `loan_payments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `loan_id` BIGINT UNSIGNED NOT NULL,
    `amount` DECIMAL(12, 2) NOT NULL,
    `payment_date` DATE NOT NULL,
    `status` ENUM('pending', 'completed') DEFAULT 'completed',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Transactions Table
-- ========================================
CREATE TABLE IF NOT EXISTS `transactions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `transaction_id` VARCHAR(50) NOT NULL UNIQUE,
    `type` ENUM('dps_deposit', 'loan_payment', 'donation', 'withdrawal') DEFAULT 'dps_deposit',
    `amount` DECIMAL(12, 2) NOT NULL,
    `description_bn` TEXT NULL,
    `description_en` TEXT NULL,
    `status` ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    `dps_account_id` BIGINT UNSIGNED NULL,
    `loan_id` BIGINT UNSIGNED NULL,
    `reference` VARCHAR(100) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
    FOREIGN KEY (`dps_account_id`) REFERENCES `dps_accounts` (`id`) ON DELETE SET NULL,
    FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE SET NULL,
    INDEX `idx_transaction_id` (`transaction_id`),
    INDEX `idx_type` (`type`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Chats Table
-- ========================================
CREATE TABLE IF NOT EXISTS `chats` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `sender_id` BIGINT UNSIGNED NOT NULL,
    `receiver_id` BIGINT UNSIGNED NOT NULL,
    `message` LONGTEXT NOT NULL,
    `is_read` TINYINT(1) DEFAULT 0,
    `read_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    INDEX `idx_sender_id` (`sender_id`),
    INDEX `idx_receiver_id` (`receiver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Default Settings
-- ========================================
INSERT INTO `settings` (`key`, `value`) VALUES
('site_name', 'সমিতি ম্যানেজমেন্ট সিস্টেম'),
('site_email', 'admin@somiti.local'),
('default_language', 'bn'),
('installed', '1')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);

-- ========================================
-- Sample DPS Schemes
-- ========================================
INSERT INTO `dps_schemes` (`name_bn`, `name_en`, `description_bn`, `description_en`, `monthly_amount`, `total_months`, `profit_rate`, `status`) VALUES
('ডিপিএস ৫০০', 'DPS 500', 'মাসিক ৫০০ টাকার জন্য ১২ মাসের প্ল্যান', 'Monthly 500 Taka for 12 months scheme', 500.00, 12, 5.00, 'active'),
('ডিপিএস ১০০০', 'DPS 1000', 'মাসিক ১০০০ টাকার জন্য ২৪ মাসের প্ল্যান', 'Monthly 1000 Taka for 24 months scheme', 1000.00, 24, 6.00, 'active'),
('ডিপিএস ২০০০', 'DPS 2000', 'মাসিক ২০০০ টাকার জন্য ৩৬ মাসের প্ল্যান', 'Monthly 2000 Taka for 36 months scheme', 2000.00, 36, 7.00, 'active');

COMMIT;
