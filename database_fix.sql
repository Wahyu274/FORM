-- ==============================================================
-- STARLINK (Life Solution Connection) - Database Repair & Setup
-- Database: u660474867_lsc
-- ==============================================================

USE `u660474867_lsc`;

-- 1. Table: devices (Penyebab utama error: Base table or view not found: 1146 Table 'devices' doesn't exist)
CREATE TABLE IF NOT EXISTS `devices` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `response_id` BIGINT UNSIGNED NOT NULL,
  `device_type` VARCHAR(100) NOT NULL,
  `brand` VARCHAR(100) NULL,
  `model` VARCHAR(100) NULL,
  `quantity` INT DEFAULT 1,
  `specs` TEXT NULL,
  `condition` VARCHAR(100) DEFAULT 'Baik',
  `notes` TEXT NULL,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `devices_response_id_index` (`response_id`),
  CONSTRAINT `fk_devices_response` FOREIGN KEY (`response_id`) REFERENCES `responses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Table: antennas
CREATE TABLE IF NOT EXISTS `antennas` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `response_id` BIGINT UNSIGNED NOT NULL,
  `antenna_code` VARCHAR(100) NOT NULL,
  `brand_model` VARCHAR(100) NULL,
  `frequency` VARCHAR(50) NULL,
  `install_location` VARCHAR(255) NULL,
  `client_count` INT DEFAULT 0,
  `max_clients` INT DEFAULT 25,
  `notes` TEXT NULL,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `antennas_response_id_index` (`response_id`),
  CONSTRAINT `fk_antennas_response` FOREIGN KEY (`response_id`) REFERENCES `responses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Table: uploads
CREATE TABLE IF NOT EXISTS `uploads` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `response_id` BIGINT UNSIGNED NOT NULL,
  `field_name` VARCHAR(100) NOT NULL,
  `category` VARCHAR(50) DEFAULT 'dokumentasi',
  `original_name` VARCHAR(255) NOT NULL,
  `filename` VARCHAR(255) NOT NULL,
  `filepath` VARCHAR(255) NOT NULL,
  `mime_type` VARCHAR(100) NULL,
  `file_size` BIGINT UNSIGNED DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `uploads_response_id_index` (`response_id`),
  CONSTRAINT `fk_uploads_response` FOREIGN KEY (`response_id`) REFERENCES `responses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
