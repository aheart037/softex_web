-- MySQL Database Schema for Softex Invoice Management System
-- Database name: softex_invoice_db

CREATE DATABASE IF NOT EXISTS `softex_invoice_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `softex_invoice_db`;

-- 1. Admins Table
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Clients Table
CREATE TABLE IF NOT EXISTS `clients` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Invoices Table
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `invoice_number` VARCHAR(50) UNIQUE NOT NULL,
  `client_id` INT NOT NULL,
  `invoice_date` DATE NOT NULL,
  `due_date` DATE NOT NULL,
  `status` ENUM('UNPAID', 'PAID') DEFAULT 'UNPAID',
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Invoice Items Table
CREATE TABLE IF NOT EXISTS `invoice_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `invoice_id` INT NOT NULL,
  `description` TEXT NOT NULL,
  `price` DECIMAL(12,2) NOT NULL,
  `discount` DECIMAL(12,2) DEFAULT 0.00,
  `total` DECIMAL(12,2) NOT NULL,
  FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Settings Table
CREATE TABLE IF NOT EXISTS `settings` (
  `setting_key` VARCHAR(50) PRIMARY KEY,
  `setting_value` TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ==========================================
-- INSERT SEED DATA
-- ==========================================

-- Seed default admin account (Username: admin@softex.pk, Password: admin123)
INSERT INTO `admins` (`id`, `username`, `password`, `name`) VALUES
(1, 'admin@softex.pk', '$2y$12$jLTkHXGsakJkalVJfUdhgu0FZwkd8kSDNOPOzVpXP7d3sq/YLkulG', 'System Admin')
ON DUPLICATE KEY UPDATE `username` = VALUES(`username`);

-- Seed default settings
INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('company_name', 'Softex Technologies'),
('company_address', 'H606 Nisther Block Iqbal Town, Lahore, Pakistan'),
('company_phone', '+92 345 0789192'),
('company_email', 'info@softex.pk'),
('company_website', 'www.softex.pk'),
('company_logo', 'assets/images/logo.png'),
('terms_conditions', '1. Payment due within 7 days.\r\n2. No refund after payment confirmation.\r\n3. Thank you for your business.'),
('smtp_host', 'smtp.softex.pk'),
('smtp_port', '587'),
('smtp_user', 'info@softex.pk'),
('smtp_pass', 'secure_password_here'),
('smtp_secure', 'tls')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);

-- Seed default clients
INSERT INTO `clients` (`id`, `name`, `phone`, `email`, `address`) VALUES
(1, 'Alpha Tech Solutions', '+92 300 1234567', 'billing@alphatech.com', 'Suite 402, Commercial Area Phase 5 DHA, Lahore, Pakistan'),
(2, 'InnoWeb Digital', '+92 423 5556677', 'finance@innoweb.pk', 'Block D, Gulberg III, Lahore, Pakistan'),
(3, 'Global Trading Corp', '+1 415 9876543', 'accounts@globaltrade.com', '120 Pine Street, San Francisco, CA 94111, USA')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`);

-- Seed default invoices
INSERT INTO `invoices` (`id`, `invoice_number`, `client_id`, `invoice_date`, `due_date`, `status`, `notes`) VALUES
(1, 'INV-0001', 1, '2026-05-15', '2026-06-22', 'PAID', 'This includes initial set up and first month support.'),
(2, 'INV-0002', 2, '2026-05-25', '2026-06-05', 'UNPAID', 'Payment milestone for Website UI/UX Redesign project.'),
(3, 'INV-0003', 3, '2026-05-28', '2026-06-04', 'UNPAID', 'Dedicated development resources for May 2026.')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`);

-- Seed default invoice items
INSERT INTO `invoice_items` (`id`, `invoice_id`, `description`, `price`, `discount`, `total`) VALUES
(1, 1, 'Enterprise Cloud Server Setup & Migration Services', 1500.00, 100.00, 1400.00),
(2, 1, 'Database Optimization and High Availability Setup', 800.00, 0.00, 800.00),
(3, 2, 'Website Frontend UI/UX Mockups & Revision Work', 1200.00, 150.00, 1050.00),
(4, 2, 'React.js Frontend Integration & Mobile Responsive Styling', 2500.00, 200.00, 2300.00),
(5, 3, 'Senior Full-Stack PHP Developer Resource (Full Time, May 2026)', 3500.00, 0.00, 3500.00)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`);
