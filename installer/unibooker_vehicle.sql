-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 20, 2025 at 06:25 AM
-- Server version: 8.0.36-28
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cardemo`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_coupons`
--

CREATE TABLE `add_coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `coupon_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_expiry_date` date DEFAULT NULL,
  `coupon_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_order_amount` decimal(15,2) DEFAULT NULL,
  `coupon_value` decimal(15,2) NOT NULL,
  `coupon_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` tinyint(1) NOT NULL DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `all_packages`
--

CREATE TABLE `all_packages` (
  `id` bigint UNSIGNED NOT NULL,
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_total_day` int NOT NULL,
  `package_price` decimal(15,2) NOT NULL,
  `package_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `max_item` int NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `module` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `all_packages`
--

INSERT INTO `all_packages` (`id`, `package_name`, `package_total_day`, `package_price`, `package_description`, `max_item`, `status`, `created_at`, `updated_at`, `module`) VALUES
(1, 'Basic', 365, 10.00, '<p>Basic</p>', 30, '1', '2023-07-04 22:49:25', '2024-12-13 18:41:26', NULL),
(2, 'Gold', 365, 150.00, '<p>Gold</p>', 20, '1', '2023-07-04 22:50:15', '2024-08-13 08:35:54', NULL),
(3, 'Silver', 15, 30.00, '<p>Silver</p>', 15, '1', '2023-07-04 22:51:02', '2025-04-29 11:24:52', NULL),
(5, 'Platinum', 30, 1000.00, NULL, 2, '1', '2024-11-02 11:06:40', '2024-11-02 11:06:40', NULL),
(6, 'child seat', 10, 11.00, '<p>child seat 1</p>', 1, '1', '2024-11-08 17:25:49', '2025-01-30 15:38:26', NULL),
(7, 'Testing', 20, 10.00, '<p>tttteessssiinggg</p>', 5, '0', '2024-12-10 16:40:36', '2024-12-10 16:42:37', NULL),
(8, 'Test', 5, 1500.00, NULL, 3, '0', '2024-12-13 02:39:49', '2025-01-13 13:38:16', NULL),
(9, '11111111', 12, 111.00, '<p>1111</p>', 1, '1', '2025-04-16 22:50:19', '2025-06-27 16:08:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `langauge` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wallet` decimal(15,2) DEFAULT NULL,
  `otp_value` int DEFAULT '0',
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `reset_token` int DEFAULT '0',
  `verified` tinyint DEFAULT '0',
  `phone_verify` tinyint NOT NULL DEFAULT '0',
  `email_verify` tinyint NOT NULL DEFAULT '0',
  `login_type` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` enum('user','vendor') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `host_status` enum('0','1','2','') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `birthdate` date DEFAULT NULL,
  `social_id` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ave_host_rate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `avr_guest_rate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) DEFAULT '1',
  `package_id` bigint UNSIGNED DEFAULT '1',
  `fcm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_notification` tinyint NOT NULL DEFAULT '0',
  `email_notification` tinyint NOT NULL DEFAULT '0',
  `push_notification` tinyint NOT NULL DEFAULT '0',
  `device_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_users_bank_accounts`
--

CREATE TABLE `app_users_bank_accounts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `account_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `iban` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `swift_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_user_meta`
--

CREATE TABLE `app_user_meta` (
  `id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_user_otps`
--

CREATE TABLE `app_user_otps` (
  `id` int NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `token` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `itemid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `userid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `host_id` bigint NOT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime DEFAULT NULL,
  `start_time` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Cancelled','Confirmed','Declined','Expired','Refunded','Completed','Live') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(15,2) DEFAULT '0.00',
  `currency_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_to_pay` decimal(15,2) DEFAULT '0.00',
  `payment_status` enum('notpaid','paid','offline') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'notpaid',
  `item_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancellation_reasion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_cancellation_policies`
--

CREATE TABLE `booking_cancellation_policies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` enum('fixed','percent','none') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(15,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `module` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cancellation_time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_cancellation_policies`
--

INSERT INTO `booking_cancellation_policies` (`id`, `name`, `description`, `type`, `value`, `status`, `module`, `created_at`, `updated_at`, `cancellation_time`) VALUES
(1, 'Normal Policy', '0% deduction will apply if canceled at least 24 hours before the rental start time', 'percent', 0.00, 1, 2, '2024-07-12 07:02:22', '2024-12-04 15:50:31', 48),
(8, 'Super Policy', '80% deduction will apply if canceled within 12 hours of the rental start time.', 'percent', 80.00, 1, 2, '2024-11-29 11:39:29', '2024-12-04 15:50:45', 12),
(9, 'Flexible Policy', '50% deduction will be issued if canceled between 24 and 12 hours prior to the rental start time.', 'percent', 50.00, 1, 2, '2024-11-29 11:43:19', '2024-12-04 15:50:13', 24);

-- --------------------------------------------------------

--
-- Table structure for table `booking_cancellation_reasons`
--

CREATE TABLE `booking_cancellation_reasons` (
  `order_cancellation_id` int NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `module` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_cancellation_reasons`
--

INSERT INTO `booking_cancellation_reasons` (`order_cancellation_id`, `reason`, `user_type`, `status`, `module`, `created_at`, `updated_at`) VALUES
(1, 'Change of plans', 'user', 1, 2, '2024-07-12 06:59:16', '2024-11-02 12:10:49'),
(2, 'Found a better deal', 'user', 1, 2, '2024-07-12 06:59:27', '2024-07-12 06:59:27'),
(3, 'Vehicle not needed anymore', 'user', 1, 2, '2024-07-12 06:59:39', '2024-07-12 06:59:39'),
(4, 'Vehicle already booked', 'host', 1, 2, '2024-07-12 07:00:08', '2024-07-12 07:00:08'),
(5, 'Maintenance issues', 'host', 1, 2, '2024-07-12 07:00:19', '2024-07-12 07:00:19'),
(6, 'Insurance coverage problems', 'host', 1, 2, '2024-07-12 07:00:42', '2024-09-16 11:09:53');

-- --------------------------------------------------------

--
-- Table structure for table `booking_extensions`
--

CREATE TABLE `booking_extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `is_item_delivered` tinyint(1) DEFAULT '0',
  `is_item_received` tinyint(1) DEFAULT '0',
  `is_item_returned` tinyint(1) DEFAULT '0',
  `pick_otp` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `drop_otp` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `doorStep_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `doorStep_price` decimal(15,2) DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_finance`
--

CREATE TABLE `booking_finance` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `total_day` int NOT NULL,
  `per_day` decimal(15,2) NOT NULL,
  `base_price` decimal(15,2) NOT NULL,
  `doorstep_price` decimal(15,2) DEFAULT '0.00',
  `security_money` decimal(15,2) DEFAULT '0.00',
  `iva_tax` decimal(15,2) DEFAULT '0.00',
  `coupon_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_discount` double(15,2) NOT NULL DEFAULT '0.00',
  `discount_price` double(15,2) NOT NULL DEFAULT '0.00',
  `admin_commission` decimal(24,2) NOT NULL DEFAULT '0.00',
  `vendor_commission` decimal(24,2) NOT NULL DEFAULT '0.00',
  `vendor_commission_given` tinyint NOT NULL DEFAULT '0',
  `cancelled_charge` decimal(15,2) NOT NULL DEFAULT '0.00',
  `wall_amt` decimal(15,2) DEFAULT '0.00',
  `deductedAmount` double(15,2) NOT NULL DEFAULT '0.00',
  `refundableAmount` double(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_meta`
--

CREATE TABLE `booking_meta` (
  `id` bigint NOT NULL,
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_type_relation`
--

CREATE TABLE `category_type_relation` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `type_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `city_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longtitude` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int NOT NULL,
  `tittle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` int NOT NULL,
  `status` int NOT NULL,
  `module` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int UNSIGNED NOT NULL,
  `currency_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `currency_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value_against_default_currency` double DEFAULT NULL,
  `currency_symbol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `locale_currency` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `currency_name`, `currency_code`, `value_against_default_currency`, `currency_symbol`, `locale_currency`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Thai Baht', 'THB', 34.3457, '฿', 'th-TH', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(2, 'Albanian Lek', 'ALL', 93.1414, 'L', 'sq-AL', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(3, 'Armenian Dram', 'AMD', 394.3745, '֏', 'hy-AM', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(4, 'Netherlands Antillean Guilder', 'ANG', 1.79, 'ƒ', 'nl-AN', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(6, 'Argentine Peso', 'ARS', 1011.75, '$', 'es-AR', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(7, 'Australian Dollar', 'AUD', 1.5381, '$', 'en-AU', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(8, 'Aruban Florin', 'AWG', 1.79, 'ƒ', 'nl-AW', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(9, 'Azerbaijani Manat', 'AZN', 1.7002, '₼', 'az-AZ', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(10, 'Bosnia-Herzegovina Convertible Mark', 'BAM', 1.8524, 'KM', 'bs-BA', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(11, 'Barbadian Dollar', 'BBD', 2, '$', 'en-BB', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(12, 'Bangladeshi Taka', 'BDT', 119.4888, '৳', 'bn-BD', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(13, 'Bulgarian Lev', 'BGN', 1.8524, 'лв', 'bg-BG', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(14, 'Bahraini Dinar', 'BHD', 0.376, '.د.ب', 'ar-BH', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(15, 'Burundian Franc', 'BIF', 2930.5659, 'FBu', 'fr-BI', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(16, 'Bermudan Dollar', 'BMD', 1, '$', 'en-BM', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(17, 'Brunei Dollar', 'BND', 1.3394, '$', 'ms-BN', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(18, 'Bolivian Boliviano', 'BOB', 6.9137, '$b', 'es-BO', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(19, 'Brazilian Real', 'BRL', 5.9862, 'R$', 'pt-BR', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(20, 'Bahamian Dollar', 'BSD', 1, '$', 'en-BS', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(21, 'Bhutanese Ngultrum', 'BTN', 84.6214, 'Nu.', 'dz-BT', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(22, 'Botswanan Pula', 'BWP', 13.6266, 'P', 'en-BW', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(23, 'New Belarusian Ruble', 'BYN', 3.2754, 'Br', 'be-BY', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(24, 'Belize Dollar', 'BZD', 2, 'BZ$', 'en-BZ', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(25, 'Canadian Dollar', 'CAD', 1.4007, '$', 'en-CA', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(26, 'Congolese Franc', 'CDF', 2854.1544, 'FC', 'fr-CD', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(27, 'Swiss Franc', 'CHF', 0.8814, 'CHF', 'fr-CH', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(28, 'Chilean Peso', 'CLP', 977.8676, '$', 'es-CL', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(29, 'Chinese Yuan', 'CNY', 7.2569, '¥', 'zh-CN', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(30, 'Colombian Peso', 'COP', 4414.1048, '$', 'es-CO', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(31, 'Costa Rican Colón', 'CRC', 508.8708, '₡', 'es-CR', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(32, 'Cuban Peso', 'CUP', 24, '₱', 'es-CU', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(33, 'Cape Verdean Escudo', 'CVE', 104.4359, '$', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(34, 'Czech Republic Koruna', 'CZK', 23.9276, 'Kč', 'cs-CZ', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(35, 'Djiboutian Franc', 'DJF', 177.721, 'Fdj', NULL, 1, '2024-07-29 11:30:57', '2024-10-05 14:56:36'),
(36, 'Danish Krone', 'DKK', 7.0674, 'kr', 'da-DK', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(37, 'Dominican Peso', 'DOP', 60.3143, 'RD$', 'es-DO', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(38, 'Algerian Dinar', 'DZD', 133.4414, 'دج', 'ar-DZ', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(39, 'Egyptian Pound', 'EGP', 49.5863, '£', 'ar-EG', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(40, 'Eritrean Nakfa', 'ERN', 15, 'Nfk', NULL, 1, '2024-07-29 11:30:57', '2024-10-05 14:56:36'),
(41, 'Ethiopian Birr', 'ETB', 124.5949, 'Br', 'am-ET', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(42, 'Euro', 'EUR', 0.9472, '€', 'fr-FR', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(43, 'Fijian Dollar', 'FJD', 2.2662, '$', 'en-FJ', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(44, 'Falkland Islands Pound', 'FKP', 0.7873, '£', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(45, 'Faroese Króna', 'FOK', 7.0667, 'kr', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(46, 'British Pound Sterling', 'GBP', 0.7873, '£', 'en-GB', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(47, 'Georgian Lari', 'GEL', 2.7813, '₾', 'ka-GE', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(48, 'Guernsey Pound', 'GGP', 0.7873, '£', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(49, 'Ghanaian Cedi', 'GHS', 15.3832, '¢', 'en-GH', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(50, 'Gibraltar Pound', 'GIP', 0.7873, '£', 'en-GI', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(51, 'Gambian Dalasi', 'GMD', 71.8837, 'D', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(52, 'Guinean Franc', 'GNF', 8601.202, 'Fr', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(53, 'Guatemalan Quetzal', 'GTQ', 7.7109, 'Q', 'es-GT', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(54, 'Guyanaese Dollar', 'GYD', 209.2041, '$', 'en-GY', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(55, 'Hong Kong Dollar', 'HKD', 7.7822, '$', 'zh-HK', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(56, 'Honduran Lempira', 'HNL', 25.2812, 'L', 'es-HN', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(57, 'Croatian Kuna', 'HRK', 7.1362, 'kn', 'hr-HR', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(58, 'Haitian Gourde', 'HTG', 131.0987, 'G', 'fr-HT', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(59, 'Hungarian Forint', 'HUF', 391.2825, 'Ft', 'hu-HU', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(60, 'Indonesian Rupiah', 'IDR', 15851.4664, 'Rp', 'id-ID', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(61, 'Israeli New Sheqel', 'ILS', 3.6336, '₪', 'he-IL', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(62, 'Manx pound', 'IMP', 0.7873, '£', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(63, 'Indian Rupee', 'INR', 84.6255, '₹', 'en-IN', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(64, 'Iraqi Dinar', 'IQD', 1311.5071, 'ع.د', 'ar-IQ', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(65, 'Iranian Rial', 'IRR', 41959.1659, '﷼', 'fa-IR', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(66, 'Icelandic Króna', 'ISK', 137.9322, 'kr', 'is-IS', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(67, 'Jersey Pound', 'JEP', 0.7873, '£', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(68, 'Jamaican Dollar', 'JMD', 158.8805, 'J$', 'en-JM', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(69, 'Jordanian Dinar', 'JOD', 0.709, 'د.ا', 'ar-JO', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(70, 'Japanese Yen', 'JPY', 149.9179, '¥', 'ja-JP', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(71, 'Kenyan Shilling', 'KES', 129.5985, 'KSh', 'en-KE', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(72, 'Kyrgystani Som', 'KGS', 86.1646, 'лв', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(73, 'Cambodian Riel', 'KHR', 4033.4761, '៛', 'km-KH', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(74, 'Kiribati Dollar', 'KID', 1.538, '$', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(75, 'Comorian Franc', 'KMF', 465.9601, 'CF', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(76, 'South Korean Won', 'KRW', 1394.7292, '₩', 'ko-KR', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(77, 'Kuwaiti Dinar', 'KWD', 0.3073, 'د.ك', 'ar-KW', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(78, 'Cayman Islands Dollar', 'KYD', 0.8333, '$', NULL, 1, '2024-07-29 11:30:57', '2024-10-05 14:56:36'),
(79, 'Kazakhstani Tenge', 'KZT', 515.6733, '₸', 'kk-KZ', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(80, 'Laotian Kip', 'LAK', 21934.0436, '₭', 'lo-LA', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(81, 'Lebanese Pound', 'LBP', 89500, '£', 'ar-LB', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(82, 'Sri Lankan Rupee', 'LKR', 290.38, '₨', 'si-LK', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(83, 'Liberian Dollar', 'LRD', 179.2644, '$', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(84, 'Lesotho Loti', 'LSL', 18.0741, 'L', 'en-LS', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(85, 'Libyan Dinar', 'LYD', 4.8936, 'ل.د', 'ar-LY', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(86, 'Moroccan Dirham', 'MAD', 10.0038, 'د.م.', 'ar-MA', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(87, 'Moldovan Leu', 'MDL', 18.2954, 'L', 'ro-MD', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(88, 'Malagasy Ariary', 'MGA', 4663.9262, 'Ar', 'mg-MG', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(89, 'Macedonian Denar', 'MKD', 58.2791, 'ден', 'mk-MK', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(90, 'Myanmar Kyat', 'MMK', 2098.4077, 'Ks', 'my-MM', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(91, 'Mongolian Tugrik', 'MNT', 3407.5983, '₮', 'mn-MN', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(92, 'Macanese Pataca', 'MOP', 8.0154, 'MOP$', 'zh-MO', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(93, 'Mauritanian Ouguiya', 'MRU', 39.9233, 'UM', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(94, 'Mauritian Rupee', 'MUR', 46.3722, '₨', 'en-MU', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(95, 'Maldivian Rufiyaa', 'MVR', 15.4361, '.ރ', 'dv-MV', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(96, 'Malawian Kwacha', 'MWK', 1743.8614, 'MK', 'en-MW', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(97, 'Mexican Peso', 'MXN', 20.3787, '$', 'es-MX', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(98, 'Malaysian Ringgit', 'MYR', 4.4449, 'RM', 'ms-MY', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(99, 'Mozambican Metical', 'MZN', 64.2907, 'MT', 'pt-MZ', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(100, 'Namibian Dollar', 'NAD', 18.0741, '$', 'en-NA', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(101, 'Nigerian Naira', 'NGN', 1682.6035, '₦', 'en-NG', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(102, 'Nicaraguan Córdoba', 'NIO', 36.7807, 'C$', 'es-NI', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(103, 'Norwegian Krone', 'NOK', 11.0586, 'kr', 'nb-NO', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(104, 'Nepalese Rupee', 'NPR', 135.3942, '₨', 'ne-NP', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(105, 'New Zealand Dollar', 'NZD', 1.6927, '$', 'en-NZ', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(106, 'Omani Rial', 'OMR', 0.3845, '﷼', 'ar-OM', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(107, 'Panamanian Balboa', 'PAB', 1, 'B/.', 'es-PA', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(108, 'Peruvian Nuevo Sol', 'PEN', 3.7521, 'S/.', 'es-PE', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(109, 'Papua New Guinean Kina', 'PGK', 3.9967, 'K', 'en-PG', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(110, 'Philippine Peso', 'PHP', 58.6325, '₱', 'tl-PH', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(111, 'Pakistani Rupee', 'PKR', 278.2104, '₨', 'ur-PK', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(112, 'Polish Zloty', 'PLN', 4.0718, 'zł', 'pl-PL', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(113, 'Paraguayan Guarani', 'PYG', 7800.4242, 'Gs', 'es-PY', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(114, 'Qatari Rial', 'QAR', 3.64, '﷼', 'ar-QA', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(115, 'Romanian Leu', 'RON', 4.7136, 'lei', 'ro-RO', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(116, 'Serbian Dinar', 'RSD', 110.7972, 'Дин.', 'sr-RS', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(117, 'Russian Ruble', 'RUB', 106.8035, '₽', 'ru-RU', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(118, 'Rwandan Franc', 'RWF', 1381.4006, 'R₣', 'rw-RW', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(119, 'Saudi Riyal', 'SAR', 3.75, '﷼', 'ar-SA', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(120, 'Solomon Islands Dollar', 'SBD', 8.5029, '$', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(121, 'Seychellois Rupee', 'SCR', 13.8809, '₨', 'en-SC', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(122, 'Sudanese Pound', 'SDG', 532.9884, '£', 'ar-SD', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(123, 'Swedish Krona', 'SEK', 10.9181, 'kr', 'sv-SE', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(124, 'Singapore Dollar', 'SGD', 1.3399, '$', 'en-SG', 1, '2024-07-29 11:30:57', '2025-07-11 06:04:20'),
(125, 'Saint Helena Pound', 'SHP', 0.7873, '£', NULL, 1, '2024-07-29 11:30:57', '2024-12-02 11:29:37'),
(126, 'UAE Dirham', 'AED', 3.6725, 'د.إ', NULL, 1, '2024-07-29 11:32:16', '2024-10-05 14:56:36'),
(127, 'Afghan Afghani', 'AFN', 67.9054, '؋', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(128, 'Sierra Leonean Leone', 'SLL', 22732.2912, 'Le', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(129, 'Somali Shilling', 'SOS', 571.3539, 'S', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(130, 'Surinamese Dollar', 'SRD', 35.5256, '$', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(131, 'South Sudanese Pound', 'SSP', 3670.1302, '£', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(132, 'São Tomé and Príncipe Dobra', 'STN', 23.2048, 'Db', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(133, 'Salvadoran Colón', 'SVC', 0.2429, '$', NULL, 1, '2024-07-29 11:32:16', '2024-07-29 11:32:16'),
(134, 'Syrian Pound', 'SYP', 12986.2026, '£', 'ar-SY', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(135, 'Swazi Lilangeni', 'SZL', 18.0741, 'L', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(136, 'Tajikistani Somoni', 'TJS', 10.8958, 'ЅМ', 'tg-TJ', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(137, 'Turkmenistani Manat', 'TMT', 3.5001, 'm', 'tk-TM', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(138, 'Tunisian Dinar', 'TND', 3.145, 'د.ت', 'ar-TN', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(139, 'Tongan Paʻanga', 'TOP', 2.3502, 'T$', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(140, 'Turkish Lira', 'TRY', 34.715, '₺', 'tr-TR', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(141, 'Trinidad and Tobago Dollar', 'TTD', 6.7731, 'TT$', 'en-TT', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(142, 'New Taiwan Dollar', 'TWD', 32.4795, 'NT$', 'zh-TW', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(143, 'Tanzanian Shilling', 'TZS', 2640.0422, 'TSh', 'sw-TZ', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(144, 'Ukrainian Hryvnia', 'UAH', 41.584, '₴', 'uk-UA', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(145, 'Ugandan Shilling', 'UGX', 3693.4838, 'USh', 'en-UG', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(146, 'United States Dollar', 'USD', 1, '$', 'en-US', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(147, 'Uruguayan Peso', 'UYU', 42.7834, '$U', 'es-UY', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(148, 'Uzbekistan Som', 'UZS', 12833.1935, 'лв', 'uz-UZ', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(151, 'Vanuatu Vatu', 'VUV', 118.5907, 'VT', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(152, 'Samoan Tala', 'WST', 2.7815, 'WS$', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(153, 'CFA Franc BEAC', 'XAF', 621.2801, 'FCFA', 'fr-CM', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(154, 'East Caribbean Dollar', 'XCD', 2.7, '$', 'en-KN', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(155, 'CFA Franc BCEAO', 'XOF', 621.2801, 'CFA', 'fr-SN', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(156, 'CFP Franc', 'XPF', 113.0236, '₣', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(157, 'Yemeni Rial', 'YER', 249.6749, '﷼', NULL, 1, '2024-07-29 11:32:16', '2024-12-02 11:29:37'),
(158, 'South African Rand', 'ZAR', 18.079, 'R', 'en-ZA', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20'),
(159, 'Zambian Kwacha', 'ZMW', 27.1708, 'ZK', 'en-ZM', 1, '2024-07-29 11:32:16', '2025-07-11 06:04:20');

-- --------------------------------------------------------

--
-- Table structure for table `email_notification_mappings`
--

CREATE TABLE `email_notification_mappings` (
  `email_type_id` int UNSIGNED NOT NULL,
  `email_sms_notification_id` int UNSIGNED NOT NULL,
  `module` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_notification_mappings`
--

INSERT INTO `email_notification_mappings` (`email_type_id`, `email_sms_notification_id`, `module`) VALUES
(1, 1, 2),
(2, 2, 2),
(3, 3, 2),
(4, 4, 2),
(6, 6, 2),
(7, 7, 2),
(8, 8, 2),
(12, 12, 2),
(13, 13, 2),
(10, 14, 2),
(9, 18, 2),
(5, 22, 2),
(11, 26, 2),
(14, 34, 2),
(15, 35, 2),
(16, 36, 2),
(17, 37, 2),
(18, 38, 2),
(19, 39, 2),
(20, 40, 2),
(21, 41, 2),
(22, 42, 2),
(23, 43, 2),
(24, 44, 2),
(25, 45, 2);

-- --------------------------------------------------------

--
-- Table structure for table `email_sms_notification`
--

CREATE TABLE `email_sms_notification` (
  `id` int UNSIGNED NOT NULL,
  `temp_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` tinyint NOT NULL DEFAULT '1',
  `role` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_id` int DEFAULT '0',
  `sms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `push_notification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `emailsent` tinyint(1) DEFAULT '1',
  `smssent` tinyint(1) NOT NULL DEFAULT '1',
  `pushsent` tinyint(1) NOT NULL DEFAULT '1',
  `vendorsubject` varchar(91) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendorbody` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `vendorpush_notification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `vendoremailsent` tinyint NOT NULL DEFAULT '0',
  `vendorsmssent` tinyint NOT NULL DEFAULT '0',
  `vendorpushsent` tinyint NOT NULL DEFAULT '0',
  `vendorsms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `adminsubject` varchar(99) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adminbody` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `adminpush_notification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `adminemailsent` tinyint NOT NULL DEFAULT '0',
  `adminsmssent` tinyint NOT NULL DEFAULT '0',
  `adminpushsent` tinyint NOT NULL DEFAULT '0',
  `adminsms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_sms_notification`
--

INSERT INTO `email_sms_notification` (`id`, `temp_name`, `module`, `role`, `subject`, `body`, `link_text`, `lang`, `lang_id`, `sms`, `push_notification`, `emailsent`, `smssent`, `pushsent`, `vendorsubject`, `vendorbody`, `vendorpush_notification`, `vendoremailsent`, `vendorsmssent`, `vendorpushsent`, `vendorsms`, `adminsubject`, `adminbody`, `adminpush_notification`, `adminemailsent`, `adminsmssent`, `adminpushsent`, `adminsms`, `status`, `created_at`, `updated_at`) VALUES
(1, 'User Registration', 1, 'user#admin', 'Registration Successful - Welcome to {{website_name}}', '<p>Hi <strong>{{first_name}} {{last_name}}</strong>, </p><p>You\'re now registered with  {{website_name}}. </p><p><strong>Email: {{email}}</strong></p><p><strong>Phone:{{phone}} </strong></p><p>Log in, explore, and enjoy! Need help? Contact us at {{support_email}}. </p><p>Cheers,</p><p>{{website_name}} Team</p>', 'abc', 'en', 1, 'Welcome to  {{website_name}}! You\'re successfully registered. Email:{{email}}. Any issues? Contact {{website_name}}.', 'Registration successful! Welcome to  {{website_name}}. 🎉', 0, 0, 0, 'Vendor Subject', '', 'Vendor Push', 1, 0, 1, 'Vendor Message', 'New User Registration Alert for  {{website_name}}', '<p><strong>Dear Admin, </strong></p><p>We are pleased to inform you that a new user has successfully registered on {{website_name}}, </p><p><strong>Details:</strong></p><p>Name: {{first_name}} {{last_name}} </p><p>Email: {{email}} </p><p>Phone: {{phone}} </p><p>Please monitor their activities and provide assistance if required.Thank you for ensuring the smooth functioning of our platform.</p><p>Best Regards,</p><p>{{website_name}} Team</p>', 'Admin Push Notification', 1, 0, 1, 'Admin Message', 1, '2023-08-30 16:41:50', '2025-06-28 15:21:29'),
(2, 'Signup OTP', 1, 'user', 'Your OTP {{OTP}}', '<p>Hi,</p><p>Your OTP : {{OTP}}</p><p>If you didn\'t request this, please ignore.</p><p>Thanks,</p><p>{{website_name}}</p>', 'abc', 'en', 1, 'Your OTP: {{OTP}}. If not requested, ignore. -   {{website_name}}', 'OTP: {{OTP}}. If not requested, please ignore.', 1, 0, 1, 'Vendor  Signup', 'Vendor Email Enable', 'Vendor Push', 0, 0, 1, 'Vendor Message', '', '', '', 0, 0, 0, '', 1, '2023-08-30 16:42:54', '2025-02-21 13:47:05'),
(3, 'Forgot Password OTP', 1, 'user', '🔒 Secure OTP for  {{website_name}} Password Update', '<p>Dear {{first_name}} {{last_name}},</p><p>We received a request to reset your password for your  {{website_name}}</p><p>account.🔐 Your One-Time Password (OTP): <strong> {{OTP}}</strong></p><p>Please use this OTP to reset your password. It\'s valid for the next 10 minutes. </p><p>Warm regards, </p><p>{{website_name}} Team</p>', 'abc', 'en', 1, 'OTP for password reset: {{OTP}}. Valid for 10 mins. Don\'t share!', 'Hey there! 🙋‍♂️ Your OTP to reset your password is: {{OTP}}. Please enter it within the next 10 minutes. ⏳ Stay secure! 👍', 1, 0, 1, '', '', '', 0, 0, 0, '', '', '', '', 0, 0, 0, '', 1, '2023-08-30 16:52:11', '2025-02-21 13:47:12'),
(4, 'Payout Request', 1, 'user#admin', 'Payout Request Submitted', '<p>Dear {{first_name}} {{last_name}},</p><p>We hope this email finds you well. This is to confirm that we have received your payout request at {{website_name}}.</p><p>Payout Details:</p><p>- Amount: {{currency_code}} <strong>{{payout_amount}}</strong></p><p>- Requested Date: {{payout_date}}</p><p>Please note that your payout request is currently being processed. Our team at {{website_name}} is working diligently to review and approve your request. Once approved, the funds will be transferred to your designated payment account.</p><p>If you have any questions or need further assistance, please don\'t hesitate to reach out to our support team at {{support_email}}. We are here to help you.</p><p> </p><p>Thank you for your patience and trust in {{website_name}}.</p><p>Best regards,</p><p>{{website_name}} Team</p>', 'abc', 'en', 1, '{{first_name}}, your {{website_name}} payout request of {{payout_amount}} is being processed. We\'ll notify you once approved.', '{{first_name}}, your payout request of {{payout_amount}} has been received at {{website_name}} and is being processed. We\'ll notify you once it\'s approved.', 0, 0, 0, '', '', '', 0, 0, 0, '', 'New Payout Request from {{first_name}} {{last_name}}', '<p><strong>Dear Admin,</strong></p><p>I hope this email finds you well. This is to notify you that we have received a new payout request from one of our users at {{website_name}}.</p><p><strong>User Details:</strong></p><p>- Name: {{first_name}} {{last_name}}</p><p>- Email: {{email}}</p><p>- Phone: {{phone}}</p><p> </p><p><strong>Payout Request Details:</strong></p><p>- Amount: {{currency_code}} {{payout_amount}}</p><p>- Requested Date: {{payout_date}}</p><p> </p><p>Please review the payout request and take the necessary actions to process it. Here are the steps to follow:</p><p>1. Verify the user\'s account and ensure they meet the eligibility criteria for payouts.</p><p>2. Check the payout amount and payment method for accuracy.</p><p>3. Approve or reject the payout request based on your assessment.</p><p>4. If approved, initiate the fund transfer to the user\'s designated payment account.</p><p>5. Update the payout request status in our system.</p><p>6. Send a confirmation email to the user about the status of their payout request.</p><p> </p><p>If you have any questions or need further information, please don\'t hesitate to reach out to the user directly using the provided contact details.</p><p>Thank you for your prompt attention to this matter.</p><p><strong>Best regards,</strong></p><p>{{website_name}} Team</p>', '', 1, 0, 0, '', 1, '2023-08-30 18:51:21', '2025-06-28 15:22:02'),
(6, 'Payment Sent', 1, 'user#admin', 'Payment Processed Successfully', '<p><strong>Dear {{first_name}} {{last_name}},</strong></p><p>We hope this email finds you well. This is to confirm that your payout request has been successfully processed and the payment has been sent.</p><p>Please check your original payment method or wallet for the transaction details.</p><p><strong>Payout Details:</strong></p><ul><li><strong>Amount:</strong> {{currency_code}} <strong>{{payout_amount}}</strong></li><li><strong>Payment Date:</strong> {{payout_date}}</li></ul><p>Thank you for your patience and for choosing {{website_name}}. If you have any questions or need further assistance, please feel free to reach out.</p><p><strong>Best regards,</strong></p><p><strong>{{website_name}} Team</strong></p>', 'abc', 'en', 1, 'Good news! Your payment has been sent. Please check your wallet or payment method', 'Good news! Your payment has been sent. Please check your wallet or payment method', 0, 0, 0, '', '', '', 0, 0, 0, '', 'Payout Request Successfully Processed', '<p><strong>Dear Admin,</strong></p><p>I hope this email finds you well. We are pleased to inform you that a payout request has been successfully processed for one of our users at {{website_name}}.</p><p><strong>User Details:</strong></p><ul><li><strong>Name:</strong> {{first_name}} {{last_name}}</li><li><strong>Email:</strong> {{email}}</li><li><strong>Phone:</strong> {{phone}}</li></ul><p><strong>Payout Details:</strong></p><ul><li><strong>Amount:</strong>{{currency_code}} {{payout_amount}}</li><li><strong>Payment Date:</strong> {{payout_date}}</li></ul><p>Thank you for your attention to this matter.</p><p>Best regards,<br>{{website_name}} Team</p>', '', 0, 0, 0, '', 1, '2023-09-01 11:50:21', '2025-06-28 15:22:05'),
(7, 'Wallet Transaction', 1, 'user', 'Wallet Transaction Alert', '<p>Dear {{first_name}} {{last_name}},</p><p>We hope this email finds you well. We are writing to inform you that a recent transaction has occurred in your wallet. Please find the details below:</p><p><strong>Transaction Type: {{transaction_type}}</strong></p><p><strong>Payout Details:</strong></p><ul><li><strong>Amount:</strong> {{currency_code}} {{payout_amount}}</li><li><strong>Transaction Date:</strong> {{payout_date}}</li></ul><p>Your account has been<strong> {{transaction_type}}ed </strong>with the amount of {{currency_code}} <strong>{{payout_amount}}</strong>. Please check your wallet or account statement for further details</p><p>Thank you for choosing {{website_name}}. If you have any questions or need further assistance, please feel free to reach out.</p><p>Best regards,</p><p>{{website_name}} Team</p>', 'abc', 'en', 1, 'payment send message', 'Wallet Transaction Alert ! Your account has been {{transaction_type}}ed with the amount of {{currency_code}} {{payout_amount}}.', 0, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', 0, 0, 0, '', 1, '2023-09-01 12:42:54', '2025-06-28 15:22:10'),
(8, 'Message', 1, 'user', 'New Message from {{sender}}', '<p>wallet transaction email</p>', 'abc', 'en', 1, 'wallet transaction Message', '{{sender}} sent you a new message: \'{{message}}...\'', 1, 0, 1, '', '', '', 0, 0, 0, '', '', '', '', 0, 0, 0, '', 0, '2023-09-01 12:53:31', '2024-08-07 07:17:52'),
(12, 'Review by Vendor', 1, 'user#vendor', 'Review Received for {{item_name}}', '<p>Dear {{first_name}} {{last_name}},</p><p>We are pleased to inform you that <strong>{{vendor_name}}</strong> has reviewed you for <strong>{{item_name}}</strong>.</p><p>Booking Reference: {{bookingid}}</p><p>Pick-up: {{check_in}}</p><p>Return: {{check_out}}</p><p>Amount: {{currency_code}} {{amount}}</p><p> </p><p>We look forward to hosting you. If you have any questions or special requests, please don\'t hesitate to contact us.</p><p>Warm regards,</p><p>{{website_name}}</p><p> </p>', 'abc', 'en', 1, '{{vendor_name}} has reviewed you for {{item_name}} Ref: {{bookingid}} on {{website_name}}', '{{vendor_name}} has reviewed you for {{item_name}} Ref: {{bookingid}} on {{website_name}}', 0, 0, 1, 'Review Submitted for {{item_name}}', '<p>Dear {{vendor_name}},</p><p>You have reviewed the product {{item_name}}</p><p>Booking Reference: {{bookingid}}</p><p>Pick-up: {{check_in}}</p><p>Return: {{check_out}}</p><p>Amount: {{currency_code}} {{amount}}</p><p> </p><p>We look forward to hosting you. If you have any questions or special requests, please don\'t hesitate to contact us.</p><p>Warm regards,</p><p>{{website_name}}</p>', 'Review Submitted for {{item_name}} Ref: {{bookingid}}', 1, 0, 1, 'Review Submitted for {{item_name}} Ref: {{bookingid}}', 'New Booking Confirmed for {{item_name}} #{{bookingid}}', '<p>Dear Admin,</p><p>A new booking has been confirmed on our platform:</p><p>Vehicle: {{item_name}}</p><p>Guest: {{first_name}} {{last_name}}</p><p>Booking Reference: {{bookingid}}</p><p>Check-in: {{check_in}}</p><p>Check-out: {{check_out}}</p><p>Amount: {{currency_code}} {{amount}}</p><p> </p><p>Please oversee the process to ensure a smooth experience for all parties.</p><p> </p><p>Warm regards,</p><p>UniBooker.com</p><p> </p>', '', 0, 0, 0, '', 1, '2023-09-01 12:53:31', '2024-12-20 15:07:14'),
(13, 'Review by User', 1, 'user#vendor', 'Review Submitted for {{item_name}}', '<p>Dear {{first_name}} {{last_name}},</p><p>You have reviewed the booking of {{item_name}}</p><p>Booking Reference: {{bookingid}}</p><p>Check-in: {{check_in}}</p><p>Check-out: {{check_out}}</p><p>Amount: {{currency_code}} {{amount}}</p><p> </p><p>We look forward to hosting you. If you have any questions or special requests, please don\'t hesitate to contact us.</p><p>Warm regards,</p><p>{{website_name}}</p><p> </p>', 'abc', 'en', 1, 'Review Submitted for {{item_name}} Ref: {{bookingid}}', 'Review Submitted for {{item_name}} Ref: {{bookingid}}', 0, 0, 1, 'Review Received for {{item_name}}', '<p>Dear {{vendor_name}},</p><p>We are pleased to inform you that {{first_name}} {{last_name}} has reviewed you for <strong>{{item_name}}</strong>.</p><p>Booking Reference: {{bookingid}}</p><p>Pick-up: {{check_in}}</p><p>Return: {{check_out}}</p><p>Amount: {{currency_code}} {{amount}}</p><p> </p><p>We look forward to hosting you. If you have any questions or special requests, please don\'t hesitate to contact us.</p><p>Warm regards,</p><p>{{website_name}}</p>', '{{first_name}} {{last_name}} has reviewed you for {{item_name}} Ref: {{bookingid}} on {{website_name}}', 1, 0, 1, '{{first_name}} {{last_name}} has reviewed you for {{item_name}} Ref: {{bookingid}} on {{website_name}}', 'New Booking Confirmed for {{item_name}} #{{bookingid}}', '<p>Dear Admin,</p><p>A new booking has been confirmed on our platform:</p><p>Vehicle: {{item_name}}</p><p>Guest: {{first_name}} {{last_name}}</p><p>Booking Reference: {{bookingid}}</p><p>Check-in: {{check_in}}</p><p>Check-out: {{check_out}}</p><p>Amount: {{currency_code}} {{amount}}</p><p> </p><p>Please oversee the process to ensure a smooth experience for all parties.</p><p> </p><p>Warm regards,</p><p>UniBooker.com</p><p> </p>', '', 0, 0, 0, '', 1, '2023-09-01 12:53:31', '2024-12-20 15:07:35'),
(14, 'Booking for Vehicle', 2, 'user#vendor#admin', 'Thanks for booking {{item_name}} #{{bookingid}}', '<p>Dear <strong>{{first_name}} {{last_name}},</strong></p><p>We are pleased to inform you of a new booking of {{item_name}}. Below are the details for your records: </p><ul><li><strong>Booking Reference :</strong>  #{{bookingid}}</li><li><strong>Pickup :</strong> {{check_in}} {{start_time}}</li><li><strong>Return : </strong>{{check_out}} {{end_time}}</li><li><strong>Total Amount:</strong>  {{currency_code}} {{amount}}</li><li><strong>Payment Status:</strong>  {{payment_status}}</li></ul><p><strong>Address:</strong><br><strong>{{item_address}}</strong></p><p><strong>Vendor Contact Details:</strong><br>Phone: {{phone_country}} {{vendor_phone}}<br>Email:  {{vendor_email}}</p><p>Should you require any further assistance or have any special requests, please don\'t hesitate to reach out to support : {{support_email}}</p><p>Thank you for choosing {{item_name}}. We look forward to hosting you!</p><p>Warm regards,<br><strong>{{website_name}}</strong></p>', 'abc', 'en', 1, 'Hello {first_name} {last_name},\r\n\r\nYour booking at  {{item_name}} is confirmed!\r\n\r\nPickup Date: {{check_in}} {{start_time}}\r\nReturn Date: {{check_out}} {{end_time}}\r\nRef:  {{bookingid}}\r\nQuestions? Contact us at  {{vendor_phone}} Safe travels!', 'Your booking with {{item_name}} at {{item_address}} from {{check_in}} to {{check_out}} is confirmed. Ref: {{bookingid}} Looking forward to hosting you!', 0, 0, 1, 'New Booking Alert for {{item_name}} # {{bookingid}}', '<p>Dear <strong>{{vendor_name}},</strong></p><p>We are delighted to confirm a booking by a customer for {{item_name}}. Here are the details:</p><ul><li><strong>Booking Reference:</strong>  #{{bookingid}}</li><li><strong>Pickup :</strong> {{check_in}} {{start_time}}</li><li><strong>Return : </strong>{{check_out}} {{end_time}}</li><li><strong>Total Amount:</strong>  {{currency_code}} {{amount}}</li><li><strong>Payment Status:</strong>  {{payment_status}}</li></ul><p><strong>Address:</strong><br><strong>{{item_address}}</strong></p><p><strong>Customer Contact Details:</strong><br>Phone: {{user_phone_country}} {{user_phone}}<br>Email:  {{user_email}}</p><p>Should you require any further assistance or have any special requests, please don\'t hesitate to reach out to support: {{support_email}}.</p><p>Warm regards,<br>{{website_name}}</p>', 'Customer {{first_name}} {{last_name}} has booked {{item_name}}.Pick-up : {{check_in}}, Return : {{check_out}}. Ref: {{bookingid}}', 1, 0, 1, 'New Booking Alert!\r\nBooked By: {{first_name}} {{last_name}}\r\nItem: {{item_name}}\r\nPickup: {{check_in}}\r\nReturn: {{check_out}}\r\nReference: {{bookingid}}\r\nFor details, check your dashboard or email.', 'New Booking Received for {{item_name}} # {{bookingid}}', '<p>Dear Admin,</p><p>We are pleased to inform you of a new booking on our platform. Below are the details:</p><p>**Customer Information:**</p><p>- Full Name: {{first_name}} {{last_name}}</p><p>- Email: {{user_email}}</p><p>- Phone: {{user_phone_country}}{{user_phone}}</p><p>**Booking Details:**</p><p>- Item name : {{item_name}}</p><p>- Booking Reference: #{{bookingid}}</p><p><strong>- </strong>Pickup <strong>:</strong> {{check_in}} {{start_time}}</p><p><strong>- </strong>Return <strong>: </strong>{{check_out}} {{end_time}}</p><p>- Total Amount: {{currency_code}} {{amount}}</p><p>- Payment Status: {{payment_status}}</p><p> </p><p>**Vendor Information:**</p><p>- Vendor Name: {{vendor_name}}</p><p>- Vendor Phone: {{vendor_phone}}</p><p>- Vendor Email: {{vendor_email}}</p><p> </p><p>Please ensure that the necessary procedures are followed to ensure a smooth experience for the guest. Should any issues or concerns arise, liaise with the vendor or reach out to the guest as necessary.</p><p> </p><p>Thank you for ensuring our platform continues to deliver outstanding service to all parties involved.</p><p> </p><p>Warm regards,</p><p>{{website_name}}</p>', NULL, 0, 0, 0, NULL, 1, NULL, '2025-06-28 15:22:17'),
(18, 'Booking Confirmed by Vendor Vehicle', 2, 'user#vendor#admin', 'Booking Confirmed for {{item_name}} #{{bookingid}}', '<p>Dear {{first_name}} {{last_name}},</p><p>Your booking at {{item_name}} has been confirmed! Here are the details:</p><p>Booking Reference: {{bookingid}}</p><p>Pick-up: {{check_in}} {{start_time}}</p><p>Return: {{check_out}} {{end_time}}</p><p>Amount: {{currency_code}} {{amount}}</p><p> </p><p>We look forward to hosting you. If you have any questions or special requests, please don\'t hesitate to contact us.</p><p>Warm regards,</p><p>{{website_name}}</p><p> </p>', 'abc', 'en', 1, 'Booking Confirmed! \r\nFor {{item_name}}\r\nPick-up: {{check_in}}, Return: {{check_out}}\r\nRef: {{bookingid}}', 'Booking Confirmed!  Pick-up: {{check_in}}, Return: {{check_out}}. Ref: {{bookingid}}', 0, 0, 1, 'Confirmation: New Booking for {{item_name}} #{{bookingid}}', '<p>Dear {{vendor_name}},</p><p>A new booking has been confirmed for {{item_name}}. Here are the details:</p><p>Guest: {{first_name}} {{last_name}}</p><p>Booking Reference: #{{bookingid}}</p><p>Pick-up: {{check_in}} {{start_time}}</p><p>Return: {{check_out}} {{end_time}}</p><p>Amount: {{currency_code}} {{amount}}</p><p>Please ensure everything is in order for the customer\'s arrival.</p><p>Warm regards,</p><p>{{website_name}}</p>', 'Booking Confirmed for {{item_name}} #{{bookingid}} ! Booked By : {{first_name}} {{last_name}}. Pick-up: {{check_in}}, Return: {{check_out}}.', 0, 0, 0, 'New Booking Alert for {{item_name}}!\r\nBooked By: {{first_name}} {{last_name}}\r\nPick-up: {{check_in}}, Return: {{check_out}}\r\nRef: {{bookingid}}', 'New Booking Confirmed for {{item_name}} #{{bookingid}}', '<p>Dear Admin,</p><p>A new booking has been confirmed on our platform:</p><p>Vehicle: {{item_name}}</p><p>Booked By: {{first_name}} {{last_name}}</p><p>Booking Reference: {{bookingid}}</p><p>Pick-up: {{check_in}}</p><p>Return: {{check_out}}</p><p>Amount: {{currency_code}} {{amount}}</p><p> </p><p>Please oversee the process to ensure a smooth experience for all parties.</p><p> </p><p>Warm regards,</p><p>{{website_name}}</p><p> </p>', '', 0, 0, 0, '', 1, '2023-09-01 12:53:31', '2024-09-10 13:54:25'),
(22, 'Booking Cancellation by Guest Vehicle', 2, 'user#vendor#admin', 'Booking Cancellation Confirmation for {{item_name}}', '<p>Dear {{first_name}} {{last_name}},</p><p>You have cancelled the booking. The details of your cancelled booking are as follows:</p><p>Booking Details:</p><p>- Booking ID: #{{bookingid}}</p><p>- Vehicle Name: {{item_name}}</p><p>- Pick-up Date: {{check_in}} {{start_time}}</p><p>- Return Date: {{check_out}} {{end_time}}</p><p>Please note that any refund, if applicable, will be processed according to our cancellation policy. The refund amount will be credited back to your Wallet.</p><p>If you have any questions or need further assistance, please don\'t hesitate to reach out to our customer support team at {{support_email}} or by calling {{support_phone}}. We are here to help you.</p><p>Thank you for your understanding.</p><p> </p><p>Best regards,</p><p>{{website_name}} Team</p>', 'abc', 'en', 1, '{{first_name}}, your booking #{{bookingid}} at {{item_name}} has been cancelled. Any applicable refund will be processed. Contact us at {{support_phone}} for assistance.', 'Your booking #{{bookingid}} at {{item_name}} has been cancelled. Refund, if applicable, will be processed. Tap for more details.', 0, 0, 1, 'Booking Cancellation Notification for {{item_name}}', '<p>Dear {{vendor_name}},</p><p>We would like to inform you that a booking has been cancelled by the customer. The details of the cancelled booking are as follows:</p><p>Booking Details:</p><p>- Booking ID: #{{bookingid}}</p><p>- Vehicle Name: {{item_name}}</p><p>- Pick-up Date: {{check_in}}</p><p>- Return Date: {{check_out}}</p><p>- Customer Name: {{first_name}} {{last_name}}</p><p> </p><p>Please take note of this cancellation and update your records accordingly.</p><p>If you have any questions or need further information, please don\'t hesitate to reach out to our  support team at {{support_email}} or by calling {{support_phone}}. We are here to assist you.</p><p>Thank you for your cooperation.</p><p>Best regards,</p><p>{{website_name}} Team</p>', 'Booking #{{bookingid}} at {{item_name}} has been cancelled by the customer. Tap for more details.', 1, 0, 1, '{{vendor_name}}, booking #{{bookingid}} at {{item_name}} has been cancelled by the guest. Please update your records. Contact us at {{vendor_support_phone}} for assistance.', 'Booking Cancellation Notification - Admin', '<p>Dear Admin,</p><p>We would like to inform you that a booking has been cancelled by the customer. The details of the cancelled booking are as follows:</p><p> </p><p>Booking Details:</p><p>- Booking ID: #{{bookingid}}</p><p>- Vehicle Name: {{item_name}}</p><p>- Pick-up Date: {{check_in}}</p><p>- Return Date: {{check_out}}</p><p>- Customer Name: {{first_name}} {{last_name}}</p><p>- Vendor Name: {{vendor_name}}</p><p> </p><p>Thank you for your prompt attention to this matter.</p><p>Best regards,</p><p>{{website_name}}</p>', '', 0, 0, 0, '', 1, '2023-09-01 11:32:00', '2025-06-28 15:22:23'),
(26, 'Booking Decline by Vendor Vehicle', 2, 'user#vendor#admin', 'Booking Rejected: {{item_name}} #{{bookingid}}', '<p>Dear {{first_name}} {{last_name}},</p><p>Your booking at {{item_name}} has been Rejected ! Here are the details:</p><p>Booking Reference: #{{bookingid}}</p><p>Pick-up: {{check_in}}</p><p>Return: {{check_out}}</p><p>Amount: {{currency_code}} {{amount}}</p><p>Payment Status:  {{payment_status}}</p><p> </p><p>We look forward to hosting you. If you have any questions or special requests, please don\'t hesitate to contact us.</p><p>Warm regards,</p><p>{{website_name}}</p><p> </p>', 'abc', 'en', 1, 'Booking Rejected! For {{item_name}}\r\nPick-up: {{check_in}}, Return: {{check_out}}\r\nRef: {{bookingid}}', '{{first_name}}, your booking #{{bookingid}} at {{item_name}} has been rejected. Any applicable refund will be processed. Contact us at {{support_phone}} for assistance.', 0, 0, 1, 'Rejected: Booking for {{item_name}} {{bookingid}}', '<p>Dear {{vendor_name}},</p><p>You have Rejected one booking of {{item_name}}. Here are the details:</p><p>Customer: {{first_name}} {{last_name}}</p><p>Booking Reference: #{{bookingid}}</p><p>Pick-up: {{check_in}}</p><p>Return: {{check_out}}</p><p>Amount: {{currency_code}} {{amount}}</p><p>Payment Status:  {{payment_status}}</p><p>Please ensure everything is in order for the guest\'s arrival.</p><p>Warm regards,</p><p>{{website_name}}</p>', '{{vendor_name}}, your have rejected booking #{{bookingid}} at {{item_name}}.Contact us at {{support_phone}} for assistance.', 1, 0, 1, 'Booking Rejected for {{item_name}}!\r\nBooked by: {{first_name}} {{last_name}}\r\nPick-up: {{check_in}}, Return: {{check_out}}\r\nRef: {{bookingid}}', 'Booking Rejected for {{item_name}} #{{bookingid}}', '<p>Dear Admin,</p><p>A  booking has been Rejected on our platform:</p><p>Vehicle: {{item_name}}</p><p>Customer: {{first_name}} {{last_name}}</p><p>Vendor: {{vendor_name}}</p><p>Booking Reference: #{{bookingid}}</p><p>Pick-up: {{check_in}}</p><p>Return: {{check_out}}</p><p>Amount: {{currency_code}} {{amount}}</p><p>Payment Status:  {{payment_status}}</p><p>Please oversee the process to ensure a smooth experience for all parties.</p><p> </p><p>Warm regards,</p><p>{{website_name}}</p>', '', 1, 0, 0, '', 1, '2023-09-01 12:53:31', '2025-06-28 15:22:28'),
(34, 'User Host Request', 2, 'user#admin', 'Host Request Submitted for {{website_name}}', '<p>Hi <strong>{{first_name}} {{last_name}}</strong>, </p><p>Thank you for submitting your host request for {{website_name}}. We are excited to have you on board!</p><p><strong>Email: {{email}}</strong></p><p><strong>Phone:{{phone}} </strong></p><p>Log in, explore, and enjoy! Need help? Contact us at  {{support_email}}. </p><p>Cheers,</p><p>{{website_name}} Team</p>', 'abc', 'en', 1, 'You have successfully submitted your host request for {{website_name}}. Your Email:{{email}}. Any issues? Contact{{support_email}}.', 'Host request submitted successfully. Thank You 🎉', 0, 0, 1, 'Vendor Subject', '', 'Vendor Push', 1, 0, 1, 'Vendor Message', 'Host Request Submitted for {{website_name}}', '<p><strong>Dear Admin, </strong></p><p>We are pleased to inform you that a new user has requested to become a host on {{website_name}}.</p><p><strong>Details:</strong></p><p>Name: {{first_name}} {{last_name}} </p><p>Email: {{email}} </p><p>Phone: {{phone}} </p><p>Please monitor their activities and provide assistance if required.Thank you for ensuring the smooth functioning of our platform.</p><p>Best Regards,</p><p>{{website_name}} Team</p>', 'Admin Push Notification', 1, 0, 1, 'Admin Message', 1, '2023-08-30 16:41:50', '2025-06-28 15:22:32'),
(35, 'Approved Host Request', 2, 'user', 'Host Request Approved with {{website_name}}', '<p>Hi <strong>{{first_name}} {{last_name}}</strong>, </p><p>Congratulations ! Your Host request with {{website_name}} has been approved successfully. </p><p><strong>Email: {{email}}</strong></p><p><strong>Phone:{{phone}} </strong></p><p>Log in, explore, and enjoy! Need help? Contact us at {{support_email}}. </p><p>Cheers,</p><p>{{website_name}} Team</p>', 'abc', 'en', 1, 'Congratulations!  Your Host request with {{website_name}} has been approved. Email:{{email}}.', 'Congratulations! Host request approved with {{website_name}} . 🎉', 0, 0, 1, 'Vendor Subject', '', 'Vendor Push', 1, 0, 0, '', '', '', '', 0, 0, 0, '0', 1, '2023-08-30 16:41:50', '2025-06-28 15:22:37'),
(36, 'Email change OTP', 1, 'user', 'Your Email Change OTP {{OTP}}', '<p>Hi,</p><p>Your Email Change OTP : {{OTP}}</p><p>If you didn\'t request this, please ignore.</p><p>Thanks,</p><p>{{website_name}}</p>', 'abc', 'en', 1, 'Your OTP: {{OTP}}. If not requested, ignore. -   {{website_name}}', 'OTP: {{OTP}}. If not requested, please ignore.', 1, 0, 0, 'Vendor  Signup', 'Vendor Email Enable', 'Vendor Push', 0, 0, 1, 'Vendor Message', '', '', '', 0, 0, 0, '', 1, '2023-08-30 16:42:54', '2024-07-31 10:04:00'),
(37, 'Resend OTP', 1, 'user', '🔒Resend OTP', '<p>Dear {{first_name}} {{last_name}},</p><p>🔐 Your (OTP): <strong> {{OTP}}</strong></p><p>Please use this OTP . It\'s valid for the next 10 minutes. </p><p>Warm regards, </p><p>{{website_name}} Team</p>', 'abc', 'en', 1, 'OTP : {{OTP}}. Valid for 10 mins. Don\'t share!', 'Hey there! 🙋‍♂️ Your OTP is: {{OTP}}. Please enter it within the next 10 minutes. ⏳ Stay secure! 👍', 1, 0, 0, '', '', '', 0, 0, 0, '', '', '', '', 0, 0, 0, '', 1, '2023-08-30 16:52:11', '2024-07-31 10:42:07'),
(38, 'Change Mobile OTP', 1, 'user', 'Your Mobile Change OTP {{OTP}}', '<p>Hi,</p><p>Your Mobile Change OTP : {{OTP}}</p><p>If you didn\'t request this, please ignore.</p><p>Thanks,</p><p>{{website_name}}</p>', 'abc', 'en', 1, 'Your OTP: {{OTP}}. If not requested, ignore. -   {{website_name}}', 'OTP: {{OTP}}. If not requested, please ignore.', 1, 0, 0, 'Vendor  Signup', 'Vendor Email Enable', 'Vendor Push', 0, 0, 1, 'Vendor Message', '', '', '', 0, 0, 0, '', 1, '2023-08-30 16:42:54', '2024-12-18 15:12:08'),
(39, 'Item Publish Notification', 2, 'user', 'Item Publish with {{website_name}}', '<p>Hi <strong>{{first_name}} {{last_name}}</strong>, </p><p>Congratulations ! Your Item \"{{title}}\" has been published with {{website_name}} .</p><p><strong>Email: {{email}}</strong></p><p><strong>Phone:{{phone}} </strong></p><p>Log in, explore, and enjoy! Need help? Contact us at [{{website_name}}]. </p><p>Cheers,</p><p>{{website_name}} Team</p>', 'abc', 'en', 1, 'Congratulations!  Your Item has been published with {{website_name}} . Email:{{email}}. Any issues? Contact {{website_name}}.', 'Congratulations! Your Item \"{{title}}\" has been published with {{website_name}} . 🎉', 0, 0, 1, 'Vendor Subject', '', 'Vendor Push', 1, 0, 0, '', '', '', '', 0, 0, 0, '0', 1, '2023-08-30 16:41:50', '2025-06-28 15:21:38'),
(40, 'Item Unpublish Notification', 2, 'user', 'Item Unpublished with {{website_name}}', '<p>Hi <strong>{{first_name}} {{last_name}}</strong>, </p><p>Sorry ! Your Item \"{{title}}\" has been unpublished with {{website_name}}.</p><p><strong>Email: {{email}}</strong></p><p><strong>Phone:{{phone}} </strong></p><p>Log in, explore, and enjoy! Need help? Contact us at [{{website_name}}]. </p><p>Cheers,</p><p>{{website_name}} Team</p>', 'abc', 'en', 1, 'Sorry ! Your Item \"{{title}}\" has been unpublished with {{website_name}}.. Email:{{email}}. Any issues? Contact {{website_name}}.', 'Sorry ! Your Item \"{{title}}\" has been unpublished with {{website_name}}.', 0, 0, 1, 'Vendor Subject', '', 'Vendor Push', 1, 0, 0, '', '', '', '', 0, 0, 0, '0', 1, '2023-08-30 16:41:50', '2025-06-28 15:21:44'),
(41, 'Ticket Reply By User', 1, 'user#admin', 'Your Support Ticket with {{website_name}}', '<p>Hi {{first_name}} {{last_name}},</p><p>We wanted to inform you about your support ticket with {{website_name}}.</p><h4>Ticket Details:</h4><ul><li><strong>Ticket ID:</strong> {{ticket_id}}</li><li><strong>Subject</strong>: {{subject}}</li><li><strong>Last Modified on:</strong> {{update_date}}</li></ul><p>We’ve received your request and are currently working on it. We’ll keep you updated with any significant developments. If you have further questions or need to provide additional information, please reply to this email or contact us at {{website_name}}.</p>', 'abc', 'en', 1, 'Ticket Submitted at {{website_name}}.Ticket ID: {{ticket_id}}, Email:{{email}}. Any issues? Contact {{website_name}}.', 'Ticket Submitted at {{website_name}}. Ticket ID: {{ticket_id}}', 0, 0, 0, 'Vendor Subject', '', 'Vendor Push', 1, 0, 1, 'Vendor Message', 'New Support Ticket / Reply Notification at {{website_name}}', '<p>Hi Admin,</p><p>A support ticket has been received or updated at {{website_name}}.</p><h3>Ticket Details:</h3><ul><li><strong>Ticket ID:</strong> {{ticket_id}}</li><li><strong>Subject</strong>: {{subject}}</li><li><strong>Submitted by:</strong> {{first_name}} {{last_name}}</li><li><strong>Last Modified on:</strong> {{update_date}}</li></ul><p>Please review the ticket details and take the necessary action through the admin panel. If you have any questions or need assistance, feel free to contact the support team.</p><p>Thank you for your attention.</p>', 'Admin Push Notification', 1, 0, 1, 'Admin Message', 1, '2023-08-30 16:41:50', '2024-12-20 14:58:47'),
(42, 'Ticket Reply By Admin', 1, 'user#admin', 'Update on Your Support Ticket at {{website_name}}', '<p>Hi {{first_name}} {{last_name}},</p><p>We wanted to inform you that there has been a new reply to your support ticket. Please review the details below:</p><h4>Ticket Details:</h4><ul><li><strong>Ticket ID:</strong> {{ticket_id}}</li><li><strong>Subject</strong>: {{subject}}</li><li><strong>Last Modified on:</strong> {{update_date}}</li></ul><p>To view and respond to the latest reply, please log into your account and navigate to the ticket section.</p><p>If you have any further questions or need assistance, feel free to reach out to our support team.</p><p>Thank you for your patience and continued support.</p><p>Best regards,<br>{{website_name}}</p>', 'abc', 'en', 1, 'Ticket Submitted at {{website_name}}. Ticket ID: {{ticket_id}}. Email:{{email}}. Any issues? Contact {{website_name}}.', 'Ticket Submitted at {{website_name}}. Ticket ID: {{ticket_id}}', 0, 0, 0, 'Vendor Subject', '', 'Vendor Push', 1, 0, 1, 'Vendor Message', 'Support Ticket Reply Sent to User at  {{website_name}}', '<p>Hi Admin,</p><p>A support ticket has been received or updated at {{website_name}}.</p><h3>Ticket Details:</h3><ul><li><strong>Ticket ID:</strong> {{ticket_id}}</li><li><strong>Subject</strong>: {{subject}}</li><li><strong>Submitted by:</strong> {{first_name}} {{last_name}}</li><li><strong>Last Modified on:</strong> {{update_date}}</li></ul><p>Please review the ticket details and take the necessary action through the admin panel.</p><p>Thank you for your attention.</p>', 'Admin Push Notification', 1, 0, 1, 'Admin Message', 1, '2023-08-30 16:41:50', '2024-12-20 14:58:30'),
(43, 'Item Delivered', 1, 'user#vendor#admin', 'Item \"{{item_name}}\" Delivered Successfully', '<p>Dear <strong>{{first_name}} {{last_name}}</strong>,</p><p>We are pleased to inform you that item has been successfully delivered to you. Thank you for your trust and patience.</p><p><strong>Delivery Details:</strong></p><ul><li><strong>Item Name:</strong> {{item_name}}</li><li><strong>Booking ID:</strong> {{bookingid}}</li><li><strong>Delivery Date:</strong> {{current_date}}</li></ul><p>If you have any questions or concerns about your order, or if there’s anything else we can assist you with, please don’t hesitate to get in touch.</p><p>Thank you for choosing {{website_name}}.</p><p>Best regards,<br>The {{website_name}} Team</p>', 'abc', 'en', 1, 'Good news! Your item \"{{item_name}}\" has been delivered from {{website_name}}.', 'Good news! Your item \"{{item_name}}\" has been delivered from {{website_name}}.', 0, 0, 1, 'Item \"{{item_name}}\" Delivered Successfully', '<p>Dear <strong>{{vendor_name}}</strong> ,</p><p>We are pleased to inform you that the item <strong>\"{{item_name}}\"</strong> for your customer has been successfully delivered. Thank you for ensuring a smooth delivery process and your continued partnership.</p><p><strong>Delivery Details:</strong></p><ul><li><strong>Customer Name:</strong> {{first_name}} {{last_name}}</li><li><strong>Item Name:</strong> {{item_name}}</li><li><strong>Booking ID:</strong> {{bookingid}}</li><li><strong>Delivery Date:</strong> {{current_date}}</li></ul><p>If you have any questions or need further assistance, feel free to reach out to our support team.</p><p>Thank you for your hard work and for choosing to partner with {{website_name}}.</p><p>Best regards,<br>The {{website_name}} Team</p>', 'Good news! Your item \"{{item_name}}\" has been delivered to customer.', 1, 0, 1, 'Good news! Your item \"{{item_name}}\" has been received by customer.', 'Item Delivery Confirmation', '<p>Dear <strong>Admin,</strong></p><p>I hope this email finds you well. We are pleased to inform you that an item delivery has been successfully completed for one of our users at <strong>{{website_name}}</strong>.</p><p><strong>Customer Details:</strong><br>Name: {{first_name}} {{last_name}}<br>Email: {{user_email}}<br>Phone: {{user_phone_country}}{{user_phone}}</p><p><strong>Delivery Details:</strong><br>Item: {{item_name}}<br>Delivery Date: {{current_date}}</p><p><strong>Vendor Details:</strong><br>Vendor Name: {{vendor_name}}</p><p>Vendor Name: {{vendor_email}}<br>Vendor Contact: {{phone_country}}{{vendor_phone}}</p><p>Thank you for your attention to this matter.</p><p>Best regards,<br><strong>{{website_name}} Team</strong></p>', '', 1, 0, 0, '', 1, '2023-09-01 11:50:21', '2024-12-20 14:58:17'),
(44, 'Item Received', 1, 'user#vendor#admin', 'Item \"{{item_name}}\" Received Successfully', '<p>Dear <strong>{{first_name}} {{last_name}}</strong>,</p><p>We are pleased to inform you that item has been successfully received. Thank you for your trust and patience.</p><p><strong>Delivery Details:</strong></p><ul><li><strong>Item Name:</strong> {{item_name}}</li><li><strong>Booking ID:</strong> {{bookingid}}</li><li><strong>Received Date:</strong> {{current_date}}</li></ul><p>If you have any questions or concerns about your order, or if there’s anything else we can assist you with, please don’t hesitate to get in touch.</p><p>Thank you for choosing {{website_name}}.</p><p>Best regards,<br>The {{website_name}} Team</p>', 'abc', 'en', 1, 'Good news! item \"{{item_name}}\" has been received at customer end.', 'Good news! item \"{{item_name}}\" has been received at customer end.', 0, 0, 1, 'Item \"{{item_name}}\" Delivered Successfully', '<p>Dear <strong>{{vendor_name}},</strong></p><p>We are pleased to inform you that the item <strong>\"{{item_name}}\"</strong> for your customer has been successfully received.</p><p><strong>Delivery Details:</strong></p><ul><li><strong>Customer Name:</strong> {{first_name}} {{last_name}}</li><li><strong>Item Name:</strong> {{item_name}}</li><li><strong>Booking ID:</strong> {{bookingid}}</li><li><strong>Received Date:</strong> {{current_date}}</li></ul><p>If you have any questions or need further assistance, feel free to reach out to our support team.</p><p>Thank you for your hard work and for choosing to partner with {{website_name}}.</p><p>Best regards,<br>The {{website_name}} Team</p>', 'Good news! Your item \"{{item_name}}\" has been received by customer.', 1, 0, 1, 'Good news! Your item \"{{item_name}}\" has been received by customer.', 'Item Delivery Confirmation', '<p>Dear <strong>Admin,</strong></p><p>I hope this email finds you well. We are pleased to inform you that an item received successfully by one of our users at <strong>{{website_name}}</strong>.</p><p><strong>Customer Details:</strong><br>Name: {{first_name}} {{last_name}}<br>Email: {{user_email}}<br>Phone: {{user_phone_country}}{{user_phone}}</p><p><strong>Delivery Details:</strong><br>Item: {{item_name}}<br>Received Date: {{current_date}}</p><p><strong>Vendor Details:</strong><br>Vendor Name: {{vendor_name}} </p><p>Vendor Email : {{vendor_email}}<br>Vendor Contact: {{phone_country}}{{vendor_phone}}</p><p>Thank you for your attention to this matter.</p><p>Best regards,<br><strong>{{website_name}} Team</strong></p>', '', 1, 0, 0, '', 1, '2023-09-01 11:50:21', '2024-12-20 14:58:06'),
(45, 'Item Returned', 1, 'user#vendor#admin', 'Item \"{{item_name}}\" Returned Successfully', '<p>Dear <strong>{{first_name}} {{last_name}},</strong></p><p>We are pleased to inform you that the item <strong>\"{{item_name}}\"</strong> for your vendor has been successfully returned.</p><p><strong>Delivery Details:</strong></p><ul><li><strong>Vendor Name:</strong> {{vendor_name}}</li><li><strong>Item Name:</strong> {{item_name}}</li><li><strong>Booking ID:</strong> {{bookingid}}</li><li><strong>Returned Date:</strong> {{current_date}}</li></ul><p>If you have any questions or need further assistance, feel free to reach out to our support team.</p><p>Thank you for your hard work and for choosing to partner with {{website_name}}.</p><p>Best regards,<br>The {{website_name}} Team</p>', 'abc', 'en', 1, 'Good news! item \"{{item_name}}\" has been returned to vendor.', 'Good news! item \"{{item_name}}\" has been returned to vendor.', 0, 0, 1, 'Item  \"{{item_name}}\"  Returned Successfully', '<p>Dear <strong>{{vendor_name}},</strong></p><p>We are pleased to inform you that your item has been successfully returned by customer . Thank you for your trust and patience.</p><p><strong>Delivery Details:</strong></p><ul><li><strong>Item Name:</strong> {{item_name}}</li><li><strong>Customer Name:</strong> {{first_name}} {{last_name}}</li><li><strong>Booking ID:</strong> {{bookingid}}</li><li><strong>Returned Date:</strong> {{current_date}}</li></ul><p>If you have any questions or concerns about your order, or if there’s anything else we can assist you with, please don’t hesitate to get in touch.</p><p>Thank you for choosing {{website_name}}.</p><p>Best regards,<br>The {{website_name}} Team</p>', 'Good news! Your item \"{{item_name}}\" has been returned by customer.', 1, 0, 1, 'Good news! Your item \"{{item_name}}\" has been returned by customer.', 'Item Return Confirmation', '<p>Dear <strong>Admin,</strong></p><p>I hope this email finds you well. We are pleased to inform you that an item returned successfully by one of our users at <strong>{{website_name}}</strong>.</p><p><strong>Customer Details:</strong><br>Name: {{first_name}} {{last_name}}<br>Email: {{user_email}}<br>Phone: {{user_phone_country}}{{user_phone}}</p><p><strong>Delivery Details:</strong><br>Item: {{item_name}}<br>Returned Date: {{current_date}}</p><p><strong>Vendor Details:</strong><br>Vendor Name: {{vendor_name}}</p><p>Vendor Email: {{vendor_email}}<br>Vendor Contact: {{phone_country}}{{vendor_phone}}                                                                                                                                 </p><p>Thank you for your attention to this matter.</p><p>Best regards,<br><strong>{{website_name}} Team</strong></p>', '', 1, 0, 0, '', 1, '2023-09-01 11:50:21', '2024-12-20 14:57:58');

-- --------------------------------------------------------

--
-- Table structure for table `email_type`
--

CREATE TABLE `email_type` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_type`
--

INSERT INTO `email_type` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'User Registration Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(2, 'Signup OTP Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(3, 'Forgot Password OTP Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(4, 'Payout Request Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(5, 'Booking Cancellation by Guest Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(6, 'Payment Sent Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(7, 'Wallet Transaction Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(8, 'Message Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(9, 'Booking Confirmed by Vendor Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(10, 'Booking Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(11, 'Booking Decline by Vendor Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(12, 'Review by Vendor Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(13, 'Review by User Template', '2024-01-21 19:24:30', '2024-01-21 19:24:30'),
(14, 'User Host Request', '2024-07-20 11:48:51', '2024-07-20 11:48:51'),
(15, 'Approved Host Request', '2024-07-20 11:48:51', '2024-07-20 11:48:51'),
(16, 'Email Change OTP', '2024-07-31 15:31:36', '2024-07-31 15:31:36'),
(17, 'Resend OTP', '2024-07-31 15:31:36', '2024-07-31 15:31:36'),
(18, 'Change Mobile OTP', '2024-07-31 15:31:36', '2024-07-31 15:31:36'),
(19, 'Item Publish', NULL, NULL),
(20, 'Item Unpublish', NULL, NULL),
(21, 'Ticket Reply By User', NULL, NULL),
(22, 'Ticket Reply By Admin', NULL, NULL),
(23, 'Item Delivered', '2024-11-28 17:54:10', '2024-11-28 17:54:10'),
(24, 'Item Received', '2024-11-28 17:54:10', '2024-11-28 17:54:10'),
(25, 'Item Returned', '2024-11-28 17:56:35', '2024-11-28 17:56:35');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `meta_key`, `meta_value`, `module`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'general_name', 'vehicle.unibooker.app', 1, '2023-07-27 13:59:49', '2024-10-28 14:41:34', NULL),
(2, 'general_email', 'sizhitsolutions@gmail.com', 1, '2023-07-27 13:59:49', '2024-12-16 10:49:25', NULL),
(3, 'general_phone', '9540223464', 1, '2023-07-27 13:59:49', '2024-12-05 15:01:06', NULL),
(4, 'general_default_currency', 'USD', 1, '2023-07-27 13:59:49', '2025-07-14 13:26:30', NULL),
(5, 'general_default_language', 'en', 1, '2023-07-27 13:59:49', '2024-04-25 21:29:04', NULL),
(6, 'general_logo', 'logo/329845.Group 1000003144.png', 1, '2023-07-27 13:59:49', '2025-01-22 11:39:46', NULL),
(7, 'general_favicon', 'logo/694506.LOGO.png', 1, '2023-07-27 13:59:49', '2025-01-21 16:38:36', NULL),
(8, 'personalization_row_per_page', '10', 1, '2023-07-27 16:07:41', '2023-07-27 16:23:10', NULL),
(9, 'personalization_min_search_price', '10', 1, '2023-07-27 16:07:41', '2023-08-02 18:41:24', NULL),
(10, 'personalization_max_search_price', '12', 1, '2023-07-27 16:07:41', '2023-08-02 18:41:24', NULL),
(11, 'personalization_date_separator', '/', 1, '2023-07-27 16:07:41', '2023-07-27 17:10:20', NULL),
(12, 'personalization_date_format', '2', 1, '2023-07-27 16:07:41', '2023-07-27 16:07:41', NULL),
(13, 'personalization_timeZone', '4', 1, '2023-07-27 16:07:41', '2023-07-27 16:20:25', NULL),
(14, 'personalization_money_format', 'after', 1, '2023-07-27 16:07:41', '2023-07-27 16:23:10', NULL),
(15, 'messagewizard_phone_no', '9625847856', 1, '2023-07-27 16:57:59', '2023-07-28 16:54:18', NULL),
(16, 'messagewizard_twilio_sid', 'ytuyti', 1, '2023-07-27 16:57:59', '2023-08-02 18:41:24', NULL),
(17, 'messagewizard_twilio_token', 'yturtu', 1, '2023-07-27 16:57:59', '2023-08-02 18:41:24', NULL),
(18, 'messagewizard_defaults', 'ytutyu', 1, '2023-07-27 16:57:59', '2023-08-02 19:16:02', NULL),
(19, 'messagewizard_status', '1', 1, '2023-07-27 16:59:12', '2023-08-02 19:20:06', NULL),
(20, 'emailwizard_driver', 'smtp', 1, '2023-07-27 17:41:21', '2023-07-27 17:41:21', NULL),
(21, 'emailwizard_emai_host', 'admin@gmail.com', 1, '2023-07-27 17:41:21', '2023-07-27 17:41:21', NULL),
(22, 'emailwizard_port', '507', 1, '2023-07-27 17:41:21', '2023-07-27 17:41:21', NULL),
(23, 'emailwizard_from_address', 'testuser@gmail.com', 1, '2023-07-27 17:41:21', '2023-07-27 17:41:21', NULL),
(25, 'emailwizard_encryption', 'tls', 1, '2023-07-27 17:41:21', '2023-07-27 17:41:21', NULL),
(26, 'emailwizard_username', 'rwer', 1, '2023-07-27 17:41:21', '2023-08-02 18:41:24', NULL),
(27, 'emailwizard_password', 'ewrwer', 1, '2023-07-27 17:41:21', '2023-08-02 18:41:24', NULL),
(28, 'feesetup_guest_service_charge', '2', 1, '2023-07-27 18:30:08', '2023-10-11 19:23:24', NULL),
(29, 'feesetup_iva_tax', '10', 1, '2023-07-27 18:30:08', '2024-12-05 11:28:34', NULL),
(30, 'feesetup_accomodation_tax', '3', 1, '2023-07-27 18:30:08', '2024-04-29 19:37:52', NULL),
(33, 'api_google_client_id', 'ewtret', 1, '2023-07-27 19:18:32', '2023-08-02 18:41:24', NULL),
(34, 'api_google_client_secret', 'wetretret', 1, '2023-07-27 19:18:32', '2023-08-02 18:41:24', NULL),
(35, 'api_google_map_key', 'test', 1, '2023-07-27 19:18:32', '2025-07-14 13:26:03', NULL),
(36, 'socialmedia_facebook', '', 1, '2023-07-28 12:17:53', '2023-08-04 14:26:50', NULL),
(37, 'socialmedia_google_plus', '#', 1, '2023-07-28 12:19:42', '2023-08-04 14:26:50', NULL),
(38, 'socialmedia_twitter', '#', 1, '2023-07-28 12:19:42', '2023-08-04 14:26:50', NULL),
(39, 'socialmedia_linkedin', '#', 1, '2023-07-28 12:19:42', '2023-08-04 14:26:50', NULL),
(40, 'socialmedia_pinterest', '#', 1, '2023-07-28 12:19:42', '2023-08-04 14:26:50', NULL),
(41, 'socialmedia_youtube', '#', 1, '2023-07-28 12:19:42', '2023-08-04 14:26:50', NULL),
(42, 'socialmedia_instagram', '#', 1, '2023-07-28 12:19:42', '2023-08-04 14:26:50', NULL),
(43, 'socialnetwork_facebook_login', '1', 1, '2023-07-28 12:44:12', '2024-05-07 19:30:15', NULL),
(44, 'socialnetwork_google_login', '1', 1, '2023-07-28 12:45:56', '2024-05-24 10:07:53', NULL),
(45, 'paypal_status', 'Active', 1, '2023-07-28 14:28:27', '2025-07-14 10:17:40', NULL),
(46, 'paypal_username', 'agds', 1, '2023-07-28 14:28:27', '2023-08-02 18:41:24', NULL),
(47, 'paypal_password', 'desd', 1, '2023-07-28 14:28:27', '2023-08-02 18:41:24', NULL),
(48, 'paypal_signature', 'etret', 1, '2023-07-28 14:28:27', '2023-08-02 18:41:24', NULL),
(49, 'paypal_mode', 'were', 1, '2023-07-28 14:28:27', '2023-08-02 18:41:24', NULL),
(50, 'stripe_status', 'Active', 1, '2023-07-28 14:44:23', '2025-07-14 10:17:49', NULL),
(51, 'stripe_secret_key', 'rtyrtfgg', 1, '2023-07-28 14:44:23', '2023-08-02 18:41:24', NULL),
(52, 'stripe_publishable_key', 'sddkjl', 1, '2023-07-28 14:44:23', '2023-08-02 18:41:24', NULL),
(53, 'test_paydunya_master_key', 'DJn3I34M-mgE3-q4iR-U5ir-9d5DoDzX62R4', 1, '2023-07-28 16:20:32', '2023-09-04 11:45:07', NULL),
(54, 'test_paydunya_private_key', 'test_private_9iUppTmxofZtzbRzG928HyaU6pB', 1, '2023-07-28 16:20:32', '2023-09-04 11:45:07', NULL),
(55, 'test_paydunya_status', '1', 1, '2023-07-28 16:20:38', '2023-09-29 17:25:03', NULL),
(56, 'messagewizard_key', 'test', 1, '2023-08-28 13:56:59', '2025-07-14 13:26:03', NULL),
(57, 'messagewizard_secret', 'test', 1, '2023-08-28 13:56:59', '2025-07-14 13:26:03', NULL),
(58, 'emailwizard_key', 'postmaster@sandbox70f6bbf8761741ee89c40d0bd18dcb4a.mailgun.org', 1, '2023-08-28 14:04:43', '2024-05-07 19:15:15', NULL),
(59, 'emailwizard_secret', 'd7c365ca9fca566718058fc5631ce26f-451410ff-4556eb25', 1, '2023-08-28 14:04:43', '2024-05-07 19:15:15', NULL),
(60, 'general_maximum_price', '4000', 1, '2023-08-28 14:41:59', '2024-07-19 07:47:45', NULL),
(61, 'general_minimum_price', '1', 1, '2023-08-28 14:43:50', '2023-10-11 16:37:43', NULL),
(62, 'test_paydunya_token', 'SyJS67an38rtT2TrmkiG', 1, '2023-09-02 14:42:00', '2024-03-16 15:30:27', NULL),
(63, 'live_paydunya_status', '0', 1, '2023-09-02 16:16:11', '2023-09-29 17:24:51', NULL),
(64, 'options', 'test', 1, '2023-09-02 16:16:11', '2024-03-16 17:15:08', NULL),
(65, 'live_paydunya_master_key', 'DJn3I34M-mgE3-q4iR-U5ir-9d5DoDzX62R4', 1, '2023-09-02 16:16:11', '2024-03-16 17:14:54', NULL),
(66, 'live_paydunya_private_key', 'test_private_9iUppTmxofZtzbRzG928HyaU6pB', 1, '2023-09-02 16:16:11', '2023-09-04 11:04:43', NULL),
(67, 'live_paydunya_token', 'SyJS67an38rtT2TrmkiG', 1, '2023-09-02 16:16:11', '2023-09-04 11:04:43', NULL),
(68, 'feesetup_admin_commission', '5', 1, '2023-09-05 11:39:31', '2024-08-07 09:52:12', NULL),
(69, 'feesetup_guest_service_charge_get', 'vendor', 1, '2023-09-05 13:21:27', '2023-10-10 21:05:59', NULL),
(70, 'feesetup_iva_tax_get', 'vendor', 1, '2023-09-05 13:21:27', '2023-09-05 13:45:32', NULL),
(71, 'feesetup_accomodation_tax_get', 'admin', 1, '2023-09-05 13:21:27', '2024-08-07 09:48:33', NULL),
(72, 'general_host_title_first', 'Hosting Free for as', 1, '2023-09-28 14:53:08', '2023-10-09 19:13:55', NULL),
(73, 'general_host_link', 'Becom A Host', 1, '2023-09-28 14:53:08', '2023-10-09 19:14:31', NULL),
(74, 'general_becomehost_image', '374099.istockphoto-1312447551-612x612 1.jpg', 1, '2023-09-28 14:53:08', '2023-10-09 19:20:17', NULL),
(75, 'general_host_title_second', 'low as 1%.', 1, '2023-09-28 16:13:25', '2023-10-09 19:14:13', NULL),
(76, 'general_host_title_third', 'Start earning', 1, '2023-10-09 19:13:55', '2023-10-09 19:14:39', NULL),
(77, 'general_host_title_fourth', 'while sharing a room', 1, '2023-10-09 19:13:55', '2023-10-09 19:13:55', NULL),
(78, 'timer', '12', 1, '2023-10-10 18:48:24', '2023-10-10 18:48:32', NULL),
(79, 'feedback_intro', 'We’ll start with some questions and get you to the right place. let’s get you some help. We’re going to ask you somequestions and then connect you with a member of our support team. Can you describe p[pyour issue in a few sentences? This will help our', 1, '2023-10-10 18:48:24', '2023-10-12 13:39:43', NULL),
(80, 'ticket_intro', 'We’ll start with some questions and get you to the right place. let’s get you some help. We’re going to ask you somequestions and then connect you with a member of our support team. Can you describe p[pyour issue in a few sentences? This will help our', 1, '2023-10-10 18:48:24', '2023-10-12 13:37:24', NULL),
(81, 'general_description', 'Multivendor Car Booking & Vehicle Rental App with Admin Panel', 1, '2023-12-08 19:22:11', '2024-12-18 12:28:54', NULL),
(82, 'general_loginBackgroud', 'logo/826379.screen3.jpg', 1, '2023-12-08 20:34:32', '2023-12-08 20:42:34', NULL),
(83, 'title', 'uniBooker', 1, '2024-03-07 12:39:06', '2024-03-21 17:42:26', NULL),
(84, 'head_title', 'Explore the World by Trevelling uniBooker', 1, '2024-03-07 12:39:06', '2024-03-21 17:42:26', NULL),
(85, 'image_text', 'Seamless item booking experience with efficient management and robust features', 1, '2024-03-07 12:39:06', '2024-03-22 16:37:48', NULL),
(88, 'module', '1', 1, '2024-03-07 14:11:56', '2024-03-12 13:16:50', NULL),
(114, 'msg91_key', 'msg91key 132422', 1, '2024-03-16 12:49:27', '2024-03-16 14:40:36', NULL),
(115, 'msg91_secret', 'msg91key hidden1', 1, '2024-03-16 12:49:27', '2024-03-16 13:04:10', NULL),
(116, 'twillio_key', 'test', 1, '2024-03-16 13:03:55', '2025-07-14 13:26:03', NULL),
(117, 'twillio_secret', 'test', 1, '2024-03-16 13:03:55', '2025-07-14 13:26:03', NULL),
(118, 'nexmo_key', 'nexmo key5', 1, '2024-03-16 13:12:06', '2024-03-16 14:40:48', NULL),
(119, 'nexmo_secret', 'nexmo Secret', 1, '2024-03-16 13:12:06', '2024-03-16 13:12:25', NULL),
(120, 'twofactor_key', 'key6', 1, '2024-03-16 13:21:18', '2024-03-16 14:40:55', NULL),
(121, 'twofactor_secret', 'Secret', 1, '2024-03-16 13:21:18', '2024-03-16 14:06:51', NULL),
(122, 'twofactor_merchant_id', 'twofactor merchant_id', 1, '2024-03-16 13:21:18', '2024-03-16 13:21:18', NULL),
(123, 'twofactor_authentication_token', 'twofactor authentication token', 1, '2024-03-16 13:21:18', '2024-03-16 13:21:18', NULL),
(124, 'item_setting_image', 'logo/285477.jason-briscoe-AQl-J19ocWE-unsplash.jpg', 1, '2024-03-16 14:04:23', '2024-04-19 12:48:02', NULL),
(126, 'test_paypal_client_id', 'test', 1, '2024-03-16 16:46:20', '2025-07-14 13:26:04', NULL),
(127, 'test_paypal_secret_key', 'test', 1, '2024-03-16 16:46:20', '2025-07-14 13:26:04', NULL),
(128, 'live_paypal_client_id', 'test', 1, '2024-03-16 16:48:24', '2025-07-14 13:26:04', NULL),
(129, 'live_paypal_secret_key', 'test', 1, '2024-03-16 16:48:24', '2025-07-14 13:26:04', NULL),
(130, 'paydunya_options', 'test', 1, '2024-03-16 17:14:50', '2024-05-24 17:25:10', NULL),
(131, 'paypal_options', 'live', 1, '2024-03-16 17:19:42', '2025-07-14 09:43:23', NULL),
(132, 'stripe_options', 'live', 1, '2024-03-16 17:39:09', '2025-07-14 08:06:25', NULL),
(133, 'test_stripe_public_key', 'test', 1, '2024-03-16 17:39:09', '2025-07-14 13:26:04', NULL),
(134, 'test_stripe_secret_key', 'test', 1, '2024-03-16 17:39:09', '2025-07-14 13:26:04', NULL),
(135, 'live_stripe_public_key', 'test', 1, '2024-03-16 17:39:19', '2025-07-14 13:26:04', NULL),
(136, 'live_stripe_secret_key', 'test', 1, '2024-03-16 17:39:19', '2025-07-14 13:26:04', NULL),
(137, 'razorpay_options', 'test', 1, '2024-03-16 17:49:37', '2025-01-08 13:38:07', NULL),
(138, 'test_razorpay_key_id', 'test', 1, '2024-03-16 17:49:37', '2025-07-14 13:26:04', NULL),
(139, 'test_razorpay_secret_key', 'test', 1, '2024-03-16 17:49:37', '2025-07-14 13:26:04', NULL),
(140, 'live_razorpay_key_id', 'test', 1, '2024-03-16 17:49:47', '2025-07-14 13:26:04', NULL),
(141, 'live_razorpay_secret_key', 'test', 1, '2024-03-16 17:49:47', '2025-07-14 13:26:04', NULL),
(142, 'paystack_options', 'test', 1, '2024-03-16 17:57:19', '2024-03-16 19:23:38', NULL),
(143, 'test_paystack_public_key', 'paystack_public_Key', 1, '2024-03-16 17:57:19', '2024-03-16 17:57:19', NULL),
(144, 'test_paystack_secret_key', 'paystack_secret_key', 1, '2024-03-16 17:57:19', '2024-03-16 17:57:19', NULL),
(145, 'live_paystack_public_key', 'paystack_public_key', 1, '2024-03-16 17:57:35', '2024-03-16 17:57:35', NULL),
(146, 'live_paystack_secret_key', 'paystack_secret_key', 1, '2024-03-16 17:57:35', '2024-03-16 17:57:35', NULL),
(147, 'flutterwave_options', 'test', 1, '2024-03-16 18:00:14', '2024-03-16 19:23:43', NULL),
(148, 'test_flutterwave_public_key', 'flutterwave_public_Key', 1, '2024-03-16 18:00:14', '2024-03-16 18:00:14', NULL),
(149, 'test_flutterwave_secret_key', 'flutterwave_secret_key', 1, '2024-03-16 18:00:14', '2024-03-16 18:00:14', NULL),
(150, 'live_flutterwave_public_key', 'flutterwave_public_key', 1, '2024-03-16 18:00:28', '2024-03-16 18:00:28', NULL),
(151, 'live_flutterwave_secret_key', 'flutterwave_secret_key', 1, '2024-03-16 18:00:28', '2024-03-16 18:00:28', NULL),
(153, 'general_captcha', 'no', 1, '2024-04-26 18:44:22', '2025-01-20 13:34:22', NULL),
(154, 'site_key', 'test', 1, '2024-04-26 19:05:53', '2025-07-14 13:26:03', NULL),
(155, 'private_key', 'test', 1, '2024-04-26 19:05:53', '2025-07-14 13:26:03', NULL),
(156, 'socialnetwork_apple_login', '1', 1, '2024-05-07 19:31:11', '2024-05-07 19:51:03', NULL),
(157, 'twillio_number', 'test', 1, '2024-05-24 09:59:34', '2025-07-14 13:26:03', NULL),
(158, 'pushnotification_key', 'AAAArMZjlK0:APA91bHBFYGyQbU40zONnMHgznc4TEnu324hkfDlorWRsoy1nL84kpTAtMis2NiL5bOyzwW22xL-UrvmfkvpAFGXNhZWBBgpwW4QrK_ep0VIgimiLhAwLVHk2J522lEyW-o673G2i775', 1, '2024-05-27 15:33:58', '2024-05-28 11:59:22', NULL),
(159, 'nonage_status', 'Active', 1, '2024-05-28 09:03:05', '2024-07-19 09:54:06', NULL),
(160, 'twillio_status', 'Inactive', 1, '2024-05-28 09:35:36', '2024-07-19 09:54:06', NULL),
(161, 'host', 'test', 1, '2024-05-31 15:32:35', '2025-07-14 13:26:03', NULL),
(162, 'port', '111', 1, '2024-05-31 15:32:35', '2025-07-14 13:26:03', NULL),
(163, 'username', 'test', 1, '2024-05-31 15:32:35', '2025-07-14 13:26:03', NULL),
(164, 'password', 'test', 1, '2024-05-31 15:32:35', '2025-07-14 13:26:03', NULL),
(165, 'encryption', 'test', 1, '2024-05-31 15:32:35', '2025-07-14 13:26:03', NULL),
(166, 'from_email', 'test', 1, '2024-05-31 15:32:35', '2025-07-14 13:26:03', NULL),
(167, 'paydunya_status', 'Inactive', 1, '2024-06-14 19:17:07', '2024-09-20 15:46:43', NULL),
(168, 'onesignal_app_id', 'test', 1, '2024-07-18 07:22:57', '2025-07-14 13:26:04', NULL),
(169, 'onesignal_rest_api_key', 'test', 1, '2024-07-18 07:22:57', '2025-07-14 13:26:04', NULL),
(170, 'push_notification_status', 'onesignal', 1, NULL, '2024-07-30 13:06:36', NULL),
(172, 'sinch_service_plan_id', 'test', 1, '2024-07-19 07:00:46', '2025-07-14 13:26:03', NULL),
(173, 'sinch_api_token', 'test', 1, '2024-07-19 07:00:46', '2025-07-14 13:26:03', NULL),
(174, 'sinch_sender_number', 'test', 1, '2024-07-19 07:00:46', '2025-07-14 13:26:03', NULL),
(175, 'sinch_status', 'Inactive', 1, NULL, NULL, NULL),
(176, 'sms_provider_name', 'msg91', 1, NULL, '2025-01-16 13:14:57', NULL),
(177, 'messagewizard_sender_number', 'test', 1, '2024-07-19 10:26:55', '2025-07-14 13:26:03', NULL),
(178, 'onlinepayment', 'Inactive', 1, '2024-07-24 10:04:04', '2025-07-14 13:26:03', NULL),
(179, 'msg91_auth_key', 'test', 1, '2024-07-26 07:52:22', '2025-07-14 13:26:03', NULL),
(180, 'msg91_template_id', 'test', 1, '2024-07-26 07:52:22', '2025-07-14 13:26:03', NULL),
(181, 'currency_auth_key', 'test', 1, '2024-07-30 10:40:06', '2025-07-14 13:26:04', NULL),
(182, 'auto_fill_otp', '1', 1, '2024-07-30 11:21:52', '2025-05-07 10:39:46', NULL),
(183, 'total_number_of_bookings_per_day', '20', 1, '2024-08-02 12:07:41', '2024-09-11 14:49:47', NULL),
(184, 'multicurrency_status', '0', 1, '2024-10-28 10:12:21', '2024-12-12 11:29:33', NULL),
(185, 'razorpay_status', 'Active', 1, '2024-11-13 16:56:47', '2025-07-14 09:02:28', NULL),
(186, 'general_default_phone_country', '+995', 1, '2024-12-05 14:59:29', '2025-07-02 16:22:01', NULL),
(187, 'general_default_country_code', 'GE', 1, '2024-12-05 14:59:29', '2025-07-02 16:22:01', NULL),
(188, 'app_item_type', 'Active', 1, '2024-12-11 16:12:30', '2025-07-10 08:31:10', NULL),
(189, 'app_popular_region', 'Active', 1, '2024-12-11 16:12:30', '2025-07-10 08:31:10', NULL),
(190, 'app_near_you', 'Active', 1, '2024-12-11 16:12:30', '2025-07-10 08:31:10', NULL),
(191, 'app_make', 'Active', 1, '2024-12-11 16:12:30', '2025-07-10 08:31:10', NULL),
(192, 'app_most_viewed', 'Active', 1, '2024-12-11 16:12:30', '2025-07-09 07:00:56', NULL),
(193, 'app_become_lend', 'Active', 1, '2024-12-11 16:12:30', '2025-07-10 08:31:10', NULL),
(194, 'app_show_distance', 'Inactive', 1, '2025-07-09 07:22:26', '2025-07-10 11:39:55', NULL),
(196, 'cash_status', 'Active', 1, '2025-07-10 15:17:18', '2025-07-14 10:27:40', NULL),
(197, 'general_default_currency_symbol', '$', 1, '2025-07-11 12:30:14', '2025-07-12 05:49:19', NULL),
(198, 'default_locale_currency', 'en-US', 1, '2025-07-11 12:30:14', '2025-07-14 13:26:30', NULL),
(199, 'transbank_status', 'Active', 1, '2025-07-12 07:01:37', '2025-07-14 09:05:15', NULL),
(200, 'transbank_options', 'test', 1, '2025-07-12 07:02:57', '2025-07-14 10:20:39', NULL),
(201, 'live_transbank_client_id', 'live', 1, '2025-07-12 07:03:09', '2025-07-12 07:17:15', NULL),
(202, 'live_transbank_secret_key', 'live', 1, '2025-07-12 07:03:09', '2025-07-12 07:17:15', NULL),
(203, 'test_transbank_client_id', '597055555532', 1, '2025-07-12 07:16:09', '2025-07-14 10:20:39', NULL),
(204, 'test_transbank_secret_key', '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C', 1, '2025-07-12 07:16:09', '2025-07-14 10:20:39', NULL),
(205, 'test_stripe_client_id', 'Jt59m8klS6HO', 1, '2025-07-12 11:48:57', '2025-07-14 07:55:08', NULL),
(206, 'live_stripe_client_id', '123456', 1, '2025-07-12 11:49:09', '2025-07-14 07:55:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `short_name`, `language_status`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '2023-07-28 18:26:08', '2023-07-28 19:10:40'),
(3, 'French', 'fr', 1, '2023-07-29 12:33:08', '2023-07-29 12:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `order_column` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '0',
  `default_module` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name`, `description`, `status`, `default_module`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Vehicle / Bike', 'Vehicle Booking', 1, 1, '2023-10-13 13:36:26', '2024-07-12 07:19:06', NULL),
(3, 'Boat', 'Boat', 0, 0, '2023-10-13 13:43:22', '2024-09-11 14:17:17', '2024-09-11 10:17:17'),
(4, 'Parking', 'Parking', 0, 0, '2023-10-13 13:57:39', '2024-09-11 14:17:20', '2024-09-11 10:17:20'),
(5, 'Bookable', 'Bookable', 0, 0, '2024-01-19 17:08:31', '2024-09-11 14:17:23', '2024-09-11 10:17:23'),
(6, 'Space', 'Space', 0, 0, '2024-02-08 16:28:51', '2024-09-11 14:17:28', '2024-09-11 10:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('info@sizhitsolutions.com', '$2y$10$RbYFq.aMueCPWXKQGHBOKO4jDOBzj3jd.DfuiWDWVhI7FNM4G.AIe', '2024-12-18 11:09:00'),
('sizhitsolutions@gmail.com', '$2y$10$KCPlqyHkLkEzH7R65wNuGu99DrA0THpePQJMoBsjJy1pZTKAe5IdS', '2025-01-23 16:26:44'),
('admin@sizhitsolutions.com', '$2y$10$Tsw8O6XJNM/8rC4bScG.JOxgVCWhx3GtRFVsdP0eDuRNkDF1XMqlC', '2025-05-11 16:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` bigint UNSIGNED NOT NULL,
  `vendorid` int NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payout_status` enum('Pending','Success','Rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `module` tinyint(1) NOT NULL DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'user_management_access', NULL, NULL, NULL),
(2, 'permission_create', NULL, NULL, NULL),
(3, 'permission_edit', NULL, NULL, NULL),
(4, 'permission_show', NULL, NULL, NULL),
(5, 'permission_delete', NULL, NULL, NULL),
(6, 'permission_access', NULL, NULL, NULL),
(7, 'role_create', NULL, NULL, NULL),
(8, 'role_edit', NULL, NULL, NULL),
(9, 'role_show', NULL, NULL, NULL),
(10, 'role_delete', NULL, NULL, NULL),
(11, 'role_access', NULL, NULL, NULL),
(12, 'user_create', NULL, NULL, NULL),
(13, 'user_edit', NULL, NULL, NULL),
(14, 'user_show', NULL, NULL, NULL),
(15, 'user_delete', NULL, NULL, NULL),
(16, 'user_access', NULL, NULL, NULL),
(17, 'item_setting_access', NULL, NULL, NULL),
(18, 'slider_create', NULL, NULL, NULL),
(19, 'slider_edit', NULL, NULL, NULL),
(20, 'slider_show', NULL, NULL, NULL),
(21, 'slider_delete', NULL, NULL, NULL),
(22, 'slider_access', NULL, '2024-05-21 14:46:33', '2024-05-21 14:46:33'),
(23, 'faq_management_access', NULL, '2024-09-11 14:16:35', '2024-09-11 14:16:35'),
(24, 'faq_category_create', NULL, '2024-09-11 14:16:35', '2024-09-11 14:16:35'),
(25, 'faq_category_edit', NULL, '2024-09-11 14:16:35', '2024-09-11 14:16:35'),
(26, 'faq_category_show', NULL, '2024-09-11 14:16:35', '2024-09-11 14:16:35'),
(27, 'faq_category_delete', NULL, '2024-09-11 14:16:35', '2024-09-11 14:16:35'),
(28, 'faq_category_access', NULL, '2024-09-11 14:16:35', '2024-09-11 14:16:35'),
(29, 'faq_question_create', NULL, '2024-09-11 14:16:35', '2024-09-11 14:16:35'),
(30, 'faq_question_edit', NULL, '2024-09-11 14:16:35', '2024-09-11 14:16:35'),
(31, 'faq_question_show', NULL, '2024-09-11 14:16:35', '2024-09-11 14:16:35'),
(32, 'faq_question_delete', NULL, '2024-09-11 14:16:35', '2024-09-11 14:16:35'),
(33, 'faq_question_access', NULL, '2024-09-11 14:16:35', '2024-09-11 14:16:35'),
(34, 'city_create', NULL, NULL, NULL),
(35, 'city_edit', NULL, NULL, NULL),
(36, 'city_show', NULL, NULL, NULL),
(37, 'city_access', NULL, NULL, NULL),
(38, 'item_types_create', NULL, '2024-09-03 14:28:28', NULL),
(39, 'item_types_edit', NULL, '2024-09-03 14:28:18', NULL),
(40, 'item_types_show', NULL, '2024-09-03 14:28:07', NULL),
(41, 'item_types_access', NULL, '2024-09-03 14:27:43', NULL),
(42, 'space_type_create', NULL, '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(43, 'space_type_edit', NULL, '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(44, 'space_type_show', NULL, '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(45, 'space_type_access', NULL, '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(46, 'bed_type_create', NULL, '2024-09-11 14:17:02', '2024-09-11 14:17:02'),
(47, 'bed_type_edit', NULL, '2024-09-11 14:17:02', '2024-09-11 14:17:02'),
(48, 'bed_type_show', NULL, '2024-09-11 14:17:02', '2024-09-11 14:17:02'),
(49, 'bed_type_access', NULL, '2024-09-11 14:17:02', '2024-09-11 14:17:02'),
(50, 'features_create', NULL, '2024-09-11 14:16:23', NULL),
(51, 'features_edit', NULL, '2024-09-11 14:16:06', NULL),
(52, 'features_show', NULL, '2024-09-11 14:15:56', NULL),
(53, 'features_access', NULL, '2024-09-11 14:15:39', NULL),
(54, 'app_user_create', NULL, NULL, NULL),
(55, 'app_user_edit', NULL, NULL, NULL),
(56, 'app_user_show', NULL, NULL, NULL),
(57, 'app_user_access', NULL, NULL, NULL),
(58, 'front_management_access', NULL, NULL, NULL),
(59, 'item_create', NULL, '2024-09-03 14:27:33', NULL),
(60, 'item_edit', NULL, '2024-09-03 14:27:23', NULL),
(61, 'item_show', NULL, '2024-09-03 14:27:12', NULL),
(62, 'item_delete', NULL, '2024-09-03 14:27:00', NULL),
(63, 'item_access', NULL, '2024-09-03 14:26:49', NULL),
(64, 'item_management_access', NULL, '2024-09-03 14:26:09', NULL),
(65, 'availability_create', NULL, NULL, NULL),
(66, 'availability_edit', NULL, NULL, NULL),
(67, 'availability_show', NULL, NULL, NULL),
(68, 'availability_access', NULL, NULL, NULL),
(69, 'testimonial_create', NULL, NULL, NULL),
(70, 'testimonial_edit', NULL, NULL, NULL),
(71, 'testimonial_show', NULL, NULL, NULL),
(72, 'testimonial_delete', NULL, NULL, NULL),
(73, 'testimonial_access', NULL, NULL, NULL),
(74, 'booking_create', NULL, NULL, NULL),
(75, 'booking_edit', NULL, NULL, NULL),
(76, 'booking_show', NULL, NULL, NULL),
(77, 'booking_access', NULL, NULL, NULL),
(78, 'review_create', NULL, NULL, NULL),
(79, 'review_edit', NULL, NULL, NULL),
(80, 'review_show', NULL, NULL, NULL),
(81, 'review_access', NULL, NULL, NULL),
(82, 'static_page_create', NULL, NULL, NULL),
(83, 'static_page_edit', NULL, NULL, NULL),
(84, 'static_page_show', NULL, NULL, NULL),
(85, 'static_page_delete', NULL, NULL, NULL),
(86, 'static_page_access', NULL, NULL, NULL),
(87, 'package_access', NULL, NULL, NULL),
(88, 'all_package_create', NULL, NULL, NULL),
(89, 'all_package_edit', NULL, NULL, NULL),
(90, 'all_package_show', NULL, NULL, NULL),
(91, 'all_package_access', NULL, NULL, NULL),
(92, 'general_setting_edit', NULL, NULL, NULL),
(93, 'general_setting_access', NULL, NULL, NULL),
(94, 'all_general_setting_access', NULL, NULL, NULL),
(95, 'coupon_access', NULL, NULL, NULL),
(96, 'add_coupon_create', NULL, NULL, NULL),
(97, 'add_coupon_edit', NULL, NULL, NULL),
(98, 'add_coupon_show', NULL, NULL, NULL),
(99, 'add_coupon_delete', NULL, NULL, NULL),
(100, 'add_coupon_access', NULL, NULL, NULL),
(101, 'payout_create', NULL, NULL, NULL),
(102, 'payout_edit', NULL, NULL, NULL),
(103, 'payout_show', NULL, NULL, NULL),
(104, 'payout_access', NULL, NULL, NULL),
(105, 'profile_password_edit', NULL, NULL, NULL),
(106, 'contact_access', '2023-08-09 13:45:44', '2024-05-06 20:58:47', '2024-05-06 20:58:47'),
(107, 'contact_create', '2023-08-09 14:21:40', '2024-05-06 20:58:58', '2024-05-06 20:58:58'),
(108, 'contact_edit', '2023-08-09 14:22:26', '2024-05-06 20:58:58', '2024-05-06 20:58:58'),
(109, 'contact_show', '2023-08-09 14:24:01', '2024-05-06 20:58:58', '2024-05-06 20:58:58'),
(110, 'app_user_detail', '2023-08-23 13:28:45', '2023-08-23 13:28:45', NULL),
(111, 'payout_delete', '2023-08-25 12:06:53', '2023-08-25 12:06:53', NULL),
(112, 'email_access', '2023-08-29 10:59:18', '2023-08-29 10:59:18', NULL),
(113, 'cancellation_access', '2023-09-04 16:53:45', '2023-09-04 16:53:45', NULL),
(114, 'cancellation_policies', '2023-09-04 16:56:52', '2023-09-04 16:56:52', NULL),
(115, 'support_ticket', '2023-09-05 12:16:35', '2023-09-05 12:16:35', NULL),
(116, 'vendor_items', '2023-09-15 14:42:21', '2024-09-03 14:25:58', NULL),
(117, 'ticket_create', '2023-10-09 11:02:54', '2023-10-09 11:02:54', NULL),
(118, 'ticket_edit', '2023-10-12 11:19:19', '2023-10-12 11:20:03', '2023-10-12 11:20:03'),
(119, 'city_delete', '2023-12-11 17:26:59', '2023-12-11 17:26:59', NULL),
(120, 'item_types_delete', '2023-12-11 21:34:38', '2024-09-03 14:25:42', NULL),
(121, 'features_delete', '2023-12-11 21:35:02', '2024-09-11 14:15:27', NULL),
(122, 'boat_make_delete', '2024-02-21 16:56:22', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(123, 'boat_make_show', '2024-02-21 17:05:59', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(124, 'boat_make_edit', '2024-02-21 17:06:08', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(125, 'boat_model_delete', '2024-02-21 17:26:10', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(126, 'boat_model_edit', '2024-02-21 17:26:20', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(127, 'boat_model_show', '2024-02-21 17:26:31', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(128, 'boat_features_show', '2024-02-21 18:36:34', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(129, 'boat_features_edit', '2024-02-21 18:36:41', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(130, 'boat_features_delete', '2024-02-21 18:36:47', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(131, 'boat_type_show', '2024-02-21 18:50:15', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(132, 'boat_type_edit', '2024-02-21 18:50:23', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(133, 'boat_type_delete', '2024-02-21 18:50:29', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(134, 'boat_location_show', '2024-02-21 18:56:10', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(135, 'boat_location_edit', '2024-02-21 18:56:20', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(136, 'boat_location_delete', '2024-02-21 18:56:32', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(137, 'vehicle_features_show', '2024-02-21 19:08:48', '2024-09-23 12:29:52', NULL),
(138, 'vehicle_features_edit', '2024-02-21 19:08:54', '2024-09-23 12:29:40', NULL),
(139, 'vehicle_features_delete', '2024-02-21 19:09:02', '2024-09-23 12:29:30', NULL),
(140, 'vehicle_type_show', '2024-02-21 19:29:24', '2024-02-21 19:29:24', NULL),
(141, 'vehicle_type_edit', '2024-02-21 19:29:31', '2024-02-21 19:29:31', NULL),
(142, 'vehicle_type_delete', '2024-02-21 19:29:39', '2024-02-21 19:29:39', NULL),
(143, 'vehicle_location_delete', '2024-02-22 11:43:50', '2024-02-22 11:43:50', NULL),
(144, 'vehicle_location_edit', '2024-02-22 11:43:58', '2024-02-22 11:43:58', NULL),
(145, 'vehicle_location_show', '2024-02-22 11:44:07', '2024-03-15 16:39:30', NULL),
(146, 'vehicle_makes_show', '2024-02-22 12:10:17', '2024-02-22 12:10:17', NULL),
(147, 'vehicle_makes_edit', '2024-02-22 12:10:23', '2024-02-22 12:10:23', NULL),
(148, 'vehicle_makes_delete', '2024-02-22 12:10:30', '2024-02-22 12:10:30', NULL),
(149, 'vehicle_model_show', '2024-02-22 12:17:21', '2024-02-22 12:17:21', NULL),
(150, 'vehicle_model_edit', '2024-02-22 12:17:28', '2024-02-22 12:17:28', NULL),
(151, 'vehicle_model_delete', '2024-02-22 12:17:35', '2024-02-22 12:17:35', NULL),
(152, 'parking_type_show', '2024-02-22 14:00:45', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(153, 'parking_type_edit', '2024-02-22 14:00:52', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(154, 'parking_type_delete', '2024-02-22 14:01:00', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(155, 'parking_location_show', '2024-02-22 14:20:03', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(156, 'parking_location_edit', '2024-02-22 14:20:16', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(157, 'parking_location_delete', '2024-02-22 14:20:22', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(158, 'parking_features_show', '2024-02-22 14:36:31', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(159, 'parking_features_edit', '2024-02-22 14:36:39', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(160, 'parking_features_delete', '2024-02-22 14:36:49', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(161, 'slider_access', '2024-03-01 18:57:23', '2024-03-01 18:57:23', NULL),
(162, 'vehicle_edit', '2024-03-02 13:04:55', '2024-03-02 13:04:55', NULL),
(163, 'booking_location_delete', '2024-03-05 17:44:33', '2024-03-05 17:44:33', NULL),
(164, 'booking_location_edit', '2024-03-05 17:44:42', '2024-03-05 17:44:42', NULL),
(165, 'booking_location_show', '2024-03-05 17:44:51', '2024-03-05 17:44:51', NULL),
(166, 'space_location_delete', '2024-03-05 17:55:25', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(167, 'space_location_edit', '2024-03-05 17:55:35', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(168, 'space_location_show', '2024-03-05 17:55:44', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(169, 'space_features_delete', '2024-03-06 15:40:30', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(170, 'space_features_edit', '2024-03-06 15:40:37', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(171, 'space_features_show', '2024-03-06 15:40:46', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(172, 'booking_categories_delete', '2024-03-06 15:54:10', '2024-03-06 15:54:10', NULL),
(173, 'booking_categories_edit', '2024-03-06 15:54:20', '2024-03-06 15:54:20', NULL),
(174, 'booking_categories_show', '2024-03-06 15:54:29', '2024-03-06 15:54:29', NULL),
(175, 'booking_subcategories_delete', '2024-03-06 16:11:09', '2024-03-06 16:11:09', NULL),
(176, 'booking_subcategories_edit', '2024-03-06 16:11:19', '2024-03-06 16:11:19', NULL),
(177, 'booking_subcategories_show', '2024-03-06 16:11:24', '2024-03-06 16:11:24', NULL),
(178, 'bookable_type_show', '2024-03-08 17:10:43', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(179, 'bookable_type_edit', '2024-03-08 17:10:51', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(180, 'bookable_type_delete', '2024-03-08 17:10:55', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(181, 'bookable-type\'', '2024-03-08 17:11:04', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(182, 'bookable_attribute_delete', '2024-03-11 16:48:55', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(183, 'bookable_attribute_edit', '2024-03-11 16:49:02', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(184, 'bookable_attribute_show', '2024-03-11 16:49:09', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(185, 'bookable_location_delete', '2024-03-11 17:06:12', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(186, 'bookable_location_edit', '2024-03-11 17:06:18', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(187, 'bookable_location_show', '2024-03-11 17:06:25', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(188, 'bookable_categories_delete', '2024-03-11 17:30:09', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(189, 'bookable_categories_edit', '2024-03-11 17:30:17', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(190, 'bookable_categories_show', '2024-03-11 17:30:26', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(191, 'bookable_subcategories_delete', '2024-03-11 17:43:21', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(192, 'bookable_subcategories_edit', '2024-03-11 17:43:31', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(193, 'bookable_subcategories_show', '2024-03-11 17:43:41', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(194, 'location_show', '2024-03-12 13:47:20', '2024-03-12 13:47:20', NULL),
(195, 'location_edit', '2024-03-12 13:47:27', '2024-03-12 13:47:27', NULL),
(196, 'location_delete', '2024-03-12 13:47:35', '2024-03-12 13:47:35', NULL),
(198, 'item_location_show', '2024-03-15 14:02:19', '2024-09-03 14:25:32', NULL),
(199, 'item_location_edit', '2024-03-15 14:02:30', '2024-09-03 14:25:17', NULL),
(200, 'item_location_delete', '2024-03-15 14:02:40', '2024-09-03 14:25:05', NULL),
(201, 'item_location_access', '2024-03-15 14:02:50', '2024-09-03 14:24:54', NULL),
(202, 'vehicle_location_access', '2024-03-15 16:42:37', '2024-03-15 16:42:37', NULL),
(203, 'boat_location_update', '2024-03-15 16:49:30', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(204, 'boat_location_access', '2024-03-15 16:49:41', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(205, 'boat_location_edit', '2024-03-15 16:49:52', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(206, 'boat_location_delete', '2024-03-15 16:50:01', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(207, 'parking_location_access', '2024-03-15 16:52:12', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(208, 'bookable_location_access', '2024-03-15 16:54:11', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(209, 'space_location_access', '2024-03-15 16:56:04', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(210, 'vehicle_type_access', '2024-03-15 18:08:16', '2024-03-15 18:08:16', NULL),
(211, 'vehicle_type_create', '2024-03-15 18:11:58', '2024-03-15 18:11:58', NULL),
(212, 'boat_type_create', '2024-03-15 18:16:31', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(213, 'boat_type_access', '2024-03-15 18:16:47', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(214, 'parking_type_access', '2024-03-15 18:33:21', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(215, 'parking_type_create', '2024-03-15 18:35:32', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(216, 'bookable_type_access', '2024-03-15 18:39:32', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(217, 'bookable_type_create', '2024-03-15 18:39:42', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(218, 'space_type_delete', '2024-03-15 18:43:41', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(219, 'vehicle_features_access', '2024-03-16 12:57:15', '2024-09-23 12:29:08', NULL),
(220, 'vehicle_features_create', '2024-03-16 12:59:53', '2024-09-23 12:28:59', NULL),
(221, 'boat_features_create', '2024-03-16 13:06:45', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(222, 'boat_features_access', '2024-03-16 13:06:54', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(223, 'parking_features_access', '2024-03-16 13:12:31', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(224, 'parking_features_create', '2024-03-16 13:12:40', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(225, 'bookable_attribute_access', '2024-03-16 13:16:35', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(226, 'bookable_attribute_create', '2024-03-16 13:16:43', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(227, 'space_features_access', '2024-03-16 13:20:21', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(228, 'space_features_create', '2024-03-16 13:20:29', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(229, 'items_setting_access', '2024-03-16 13:57:58', '2024-09-03 14:24:39', NULL),
(230, 'items_setting_edit', '2024-03-16 14:02:48', '2024-09-03 14:24:20', NULL),
(231, 'vehicle_setting_access', '2024-03-16 14:07:59', '2024-03-16 14:07:59', NULL),
(232, 'vehicle_setting_edit', '2024-03-16 14:08:08', '2024-03-16 14:08:08', NULL),
(233, 'space_setting_access', '2024-03-16 14:22:11', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(234, 'space_setting_edit', '2024-03-16 14:22:19', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(235, 'boat_setting_access', '2024-03-16 14:22:45', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(236, 'boat_setting_edit', '2024-03-16 14:22:52', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(237, 'parking_setting_access', '2024-03-16 14:23:06', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(238, 'parking_setting_edit', '2024-03-16 14:23:13', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(239, 'bookable_setting_access', '2024-03-16 14:23:29', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(240, 'bookable_setting_edit', '2024-03-16 14:23:36', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(241, 'space_setting_access', '2024-03-16 14:23:50', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(242, 'space_setting_edit', '2024-03-16 14:24:05', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(243, 'bookable_location_create', '2024-03-16 14:33:02', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(244, 'vehicle_makes_access', '2024-03-16 15:11:29', '2024-03-16 15:11:29', NULL),
(245, 'vehicle_makes_create', '2024-03-16 15:11:38', '2024-03-16 15:11:38', NULL),
(246, 'bookable_categories_access', '2024-03-16 16:08:38', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(247, 'bookable_categories_create', '2024-03-16 16:08:47', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(248, 'vehicle_model_access', '2024-03-16 17:39:01', '2024-03-16 17:39:01', NULL),
(249, 'vehicle_model_create', '2024-03-16 17:39:09', '2024-03-16 17:39:09', NULL),
(250, 'bookable_subcategories_create', '2024-03-16 19:09:02', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(251, 'bookable_subcategories_access', '2024-03-16 19:09:11', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(252, 'transactions_reports_access', '2024-05-06 20:55:10', '2024-05-06 20:55:10', NULL),
(253, 'finance_access', '2024-05-06 21:13:34', '2024-05-06 21:13:34', NULL),
(254, 'bookable_fit_access', '2024-05-18 14:13:26', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(255, 'bookable_fit_edit', '2024-05-18 14:15:12', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(256, 'bookable_fit_show', '2024-05-18 14:15:39', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(257, 'bookable_fit_delete', '2024-05-18 14:16:17', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(258, 'bookable_fit_create', '2024-05-18 14:21:33', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(259, 'bookable_size_access', '2024-05-18 14:50:40', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(260, 'bookable_size_edit', '2024-05-18 14:51:01', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(261, 'bookable_size_create', '2024-05-18 14:51:21', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(262, 'bookable_size_delete', '2024-05-18 14:51:42', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(263, 'bookable_size_show', '2024-05-18 14:52:12', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(264, 'bookable_color_access', '2024-05-18 14:55:36', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(265, 'bookable_color_create', '2024-05-18 14:55:52', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(266, 'bookable_color_show', '2024-05-18 14:56:11', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(267, 'bookable_color_edit', '2024-05-18 14:56:27', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(268, 'bookable_color_delete', '2024-05-18 14:56:44', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(269, 'module_access', '2024-05-18 17:12:43', '2024-05-18 17:12:43', NULL),
(270, 'module_create', '2024-05-18 17:13:07', '2024-05-18 17:13:07', NULL),
(271, 'vehicle_odometer_access', '2024-05-18 17:35:02', '2024-05-18 17:35:02', NULL),
(272, 'vehicle_create', '2024-05-18 17:38:55', '2024-05-18 17:38:55', NULL),
(273, 'language_setting_access', '2024-05-18 17:43:58', '2024-05-18 17:43:58', NULL),
(274, 'vehicle_access', '2024-05-18 17:46:21', '2024-05-18 17:46:21', NULL),
(275, 'vehicle_setting_generalform_access', '2024-05-18 17:49:34', '2024-05-18 17:49:34', NULL),
(276, 'space_module_access', '2024-05-18 17:55:05', '2024-05-18 17:55:42', '2024-05-18 17:55:42'),
(277, 'boats_module_access', '2024-05-18 18:02:50', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(278, 'boats_features_access', '2024-05-18 18:05:40', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(279, 'boats_type_access', '2024-05-18 18:09:28', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(280, 'boats_location_access', '2024-05-18 18:10:03', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(281, 'boat_create', '2024-05-18 18:11:34', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(282, 'boat_access', '2024-05-18 18:12:48', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(283, 'boats_setting_access', '2024-05-18 18:14:06', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(284, 'parking_module_access', '2024-05-18 18:16:32', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(285, 'parking_create', '2024-05-18 18:47:48', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(286, 'parking_access', '2024-05-18 18:50:08', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(287, 'bookable_product_access', '2024-05-18 18:55:25', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(288, 'bookable_fit_access', '2024-05-18 19:00:46', '2024-05-18 19:01:39', '2024-05-18 19:01:39'),
(289, 'bookable_create', '2024-05-18 19:06:56', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(290, 'bookable_access', '2024-05-18 19:08:51', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(291, 'space_module_access', '2024-05-18 19:11:41', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(292, 'space_access', '2024-05-18 19:16:30', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(293, 'space_create', '2024-05-18 19:16:45', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(294, 'contact_access', '2024-05-18 19:32:00', '2024-07-12 08:01:28', '2024-07-12 08:01:28'),
(295, 'item_rule', '2024-05-18 19:45:06', '2024-05-18 19:45:06', NULL),
(296, 'sliders_access', '2024-05-18 19:46:53', '2024-05-18 19:46:53', NULL),
(297, 'message_access', '2024-05-18 19:49:08', '2024-05-18 19:49:08', NULL),
(298, 'reports_access', '2024-05-18 19:52:51', '2024-05-18 19:52:51', NULL),
(299, 'contact_create', '2024-05-20 12:56:04', '2024-07-12 08:01:28', '2024-07-12 08:01:28'),
(300, 'vehicle_delete', '2024-05-31 11:12:29', '2024-05-31 11:12:29', NULL),
(301, 'boat_delete', '2024-05-31 11:12:44', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(302, 'parking_delete', '2024-05-31 11:17:03', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(303, 'bookable_delete', '2024-05-31 11:17:48', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(304, 'space_delete', '2024-05-31 11:18:25', '2024-08-29 12:35:20', '2024-08-29 12:35:20'),
(305, 'booking_delete', '2024-06-01 14:35:55', '2024-06-01 14:35:55', NULL),
(306, 'app_user_delete', '2024-06-04 14:15:24', '2024-06-04 14:15:24', NULL),
(307, 'boat_edit', '2024-06-05 16:11:05', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(308, 'bookable_edit', '2024-06-05 16:12:03', '2024-09-11 14:13:50', '2024-09-11 14:13:50'),
(309, 'parking_edit', '2024-06-05 16:12:29', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(310, 'space_edit', '2024-06-05 16:13:14', '2024-08-29 12:35:09', '2024-08-29 12:35:09'),
(311, 'item_location_create', '2024-06-10 10:49:39', '2024-09-03 14:24:06', NULL),
(312, 'vehicle_location_create', '2024-06-10 16:25:11', '2024-06-10 16:25:11', NULL),
(313, 'boat_location_create', '2024-06-10 16:54:47', '2024-09-11 14:13:29', '2024-09-11 14:13:29'),
(314, 'parking_location_create', '2024-06-10 16:55:22', '2024-09-11 14:14:29', '2024-09-11 14:14:29'),
(315, 'space_location_create', '2024-06-10 16:56:18', '2024-08-29 12:31:40', '2024-08-29 12:31:40'),
(316, 'cancellation_delete', '2024-06-12 16:38:51', '2024-06-12 16:38:51', NULL),
(317, 'message_delete', '2024-06-12 16:39:36', '2024-06-12 16:39:36', NULL),
(318, 'ticket_delete', '2024-06-12 16:40:40', '2024-06-12 16:40:40', NULL),
(319, 'currency_access', '2024-07-30 07:54:33', '2024-07-30 07:54:33', NULL),
(320, 'currency_delete', '2024-07-30 07:54:59', '2024-07-30 07:54:59', NULL),
(321, 'currency_show', '2024-07-30 07:55:11', '2024-07-30 07:55:11', NULL),
(322, 'currency_edit', '2024-07-30 07:55:22', '2024-07-30 07:55:22', NULL),
(323, 'currency_create', '2024-07-30 07:55:37', '2024-07-30 07:55:37', NULL),
(324, 'add_cancellation_policies', '2024-10-07 15:12:50', '2024-10-07 15:12:50', NULL),
(325, 'email_update', '2024-10-07 16:14:06', '2024-10-07 16:14:06', NULL),
(326, 'app_user_contact_access', '2024-10-10 10:19:04', '2024-10-10 10:19:04', NULL),
(327, 'vehicle_odometer_delete', '2024-10-22 12:41:39', '2024-10-22 12:41:39', NULL),
(328, 'vehicle_odometer_edit', '2024-10-22 14:30:16', '2024-10-22 14:30:16', NULL),
(329, 'item_rule_edit', '2024-10-22 16:29:13', '2024-10-22 16:29:13', NULL),
(330, 'item_rule_delete', '2024-10-22 16:39:53', '2024-10-22 16:39:53', NULL),
(331, 'item_rule_create', '2024-10-23 10:05:42', '2024-10-23 10:05:42', NULL),
(332, 'cancellation_policies_edit', '2024-10-23 12:09:47', '2024-10-23 12:09:47', NULL),
(333, 'cancellation_policies_delete', '2024-10-23 12:12:58', '2024-10-23 12:12:58', NULL),
(334, 'cancellation_create', '2024-10-23 14:18:09', '2024-10-23 14:18:09', NULL),
(335, 'cancellation_reason_delete', '2024-10-23 14:35:33', '2024-10-23 14:35:33', NULL),
(336, 'cancellation_reason_edit', '2024-10-23 15:25:26', '2024-10-23 15:25:26', NULL),
(337, 'title_delete', '2024-10-25 15:06:30', '2024-10-25 15:06:30', NULL),
(338, 'title_edit', '2024-10-25 15:38:13', '2024-10-25 15:38:13', NULL),
(339, 'booking_access', '2024-12-12 11:56:51', '2024-12-12 11:56:51', NULL),
(340, 'trash_booking_access', '2024-12-12 12:02:13', '2024-12-12 12:02:13', NULL),
(341, 'all_package_delete', '2024-12-12 12:25:00', '2024-12-12 12:25:00', NULL),
(342, 'vehicle_fuel_type_access', '2025-06-28 11:48:57', '2025-06-28 11:48:57', NULL),
(343, 'vehicle_fuel_type_show', '2025-06-28 12:42:43', '2025-06-28 12:42:43', NULL),
(344, 'vehicle_fuel_type_edit', '2025-06-28 12:42:49', '2025-06-28 12:42:49', NULL),
(345, 'vehicle_fuel_type_create', '2025-06-28 12:42:58', '2025-06-28 12:42:58', NULL),
(346, 'vehicle_fuel_type_delete', '2025-06-28 12:43:04', '2025-06-28 12:43:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`role_id`, `permission_id`) VALUES
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 73),
(1, 74),
(1, 75),
(1, 76),
(1, 77),
(1, 78),
(1, 80),
(1, 81),
(1, 82),
(1, 84),
(1, 86),
(1, 87),
(1, 88),
(1, 90),
(1, 91),
(1, 92),
(1, 93),
(1, 94),
(1, 95),
(1, 96),
(1, 97),
(1, 98),
(1, 99),
(1, 100),
(1, 101),
(1, 102),
(1, 103),
(1, 104),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(2, 35),
(2, 36),
(2, 37),
(2, 38),
(2, 39),
(2, 40),
(2, 41),
(2, 42),
(2, 43),
(2, 44),
(2, 45),
(2, 46),
(2, 47),
(2, 48),
(2, 49),
(2, 50),
(2, 51),
(2, 52),
(2, 53),
(2, 54),
(2, 55),
(2, 56),
(2, 57),
(2, 58),
(2, 59),
(2, 60),
(2, 61),
(2, 62),
(2, 63),
(2, 64),
(2, 65),
(2, 66),
(2, 67),
(2, 68),
(2, 69),
(2, 70),
(2, 71),
(2, 72),
(2, 73),
(2, 74),
(2, 75),
(2, 76),
(2, 77),
(2, 78),
(2, 79),
(2, 80),
(2, 81),
(2, 82),
(2, 83),
(2, 84),
(2, 85),
(2, 86),
(2, 87),
(2, 88),
(2, 89),
(2, 90),
(2, 91),
(2, 92),
(2, 93),
(2, 94),
(2, 95),
(2, 96),
(2, 97),
(2, 98),
(2, 99),
(2, 100),
(2, 101),
(2, 102),
(2, 103),
(2, 104),
(2, 105),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 34),
(3, 35),
(3, 36),
(3, 37),
(3, 38),
(3, 39),
(3, 40),
(3, 41),
(3, 50),
(3, 51),
(3, 52),
(3, 53),
(3, 54),
(3, 55),
(3, 56),
(3, 57),
(3, 58),
(3, 59),
(3, 60),
(3, 61),
(3, 62),
(3, 63),
(3, 64),
(3, 65),
(3, 66),
(3, 67),
(3, 68),
(3, 69),
(3, 70),
(3, 71),
(3, 72),
(3, 73),
(3, 74),
(3, 75),
(3, 76),
(3, 77),
(3, 78),
(3, 79),
(3, 80),
(3, 81),
(3, 82),
(3, 83),
(3, 84),
(3, 85),
(3, 86),
(3, 87),
(3, 88),
(3, 89),
(3, 90),
(3, 91),
(3, 92),
(3, 93),
(3, 94),
(3, 95),
(3, 96),
(3, 97),
(3, 98),
(3, 99),
(3, 100),
(3, 101),
(3, 102),
(3, 103),
(3, 104),
(3, 105),
(2, 106),
(2, 107),
(2, 108),
(2, 109),
(3, 110),
(2, 110),
(1, 110),
(3, 111),
(2, 111),
(1, 111),
(3, 112),
(2, 112),
(1, 112),
(3, 113),
(2, 113),
(1, 113),
(3, 114),
(2, 114),
(3, 115),
(2, 115),
(1, 115),
(1, 116),
(1, 117),
(1, 119),
(1, 121),
(1, 137),
(1, 140),
(1, 145),
(1, 146),
(1, 149),
(1, 163),
(1, 164),
(1, 165),
(1, 172),
(1, 173),
(1, 174),
(1, 175),
(1, 176),
(1, 177),
(1, 194),
(1, 195),
(1, 198),
(1, 199),
(1, 201),
(1, 202),
(1, 210),
(1, 211),
(1, 219),
(1, 220),
(1, 229),
(1, 230),
(1, 231),
(1, 232),
(1, 244),
(1, 245),
(1, 248),
(1, 249),
(1, 252),
(1, 253),
(1, 270),
(1, 271),
(1, 272),
(1, 274),
(1, 275),
(1, 295),
(1, 297),
(1, 298),
(1, 311),
(1, 312),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(5, 6),
(5, 7),
(5, 8),
(5, 9),
(5, 10),
(5, 11),
(5, 12),
(5, 13),
(5, 14),
(5, 15),
(5, 16),
(5, 17),
(5, 18),
(5, 19),
(5, 20),
(5, 21),
(5, 34),
(5, 35),
(5, 36),
(5, 37),
(5, 38),
(5, 39),
(5, 40),
(5, 41),
(5, 50),
(5, 51),
(5, 52),
(5, 53),
(5, 54),
(5, 55),
(5, 56),
(5, 57),
(5, 58),
(5, 59),
(5, 60),
(5, 61),
(5, 62),
(5, 63),
(5, 64),
(5, 65),
(5, 66),
(5, 67),
(5, 68),
(5, 69),
(5, 70),
(5, 71),
(5, 72),
(5, 73),
(5, 74),
(5, 75),
(5, 76),
(5, 77),
(5, 78),
(5, 79),
(5, 80),
(5, 81),
(5, 82),
(5, 83),
(5, 84),
(5, 85),
(5, 86),
(5, 87),
(5, 88),
(5, 89),
(5, 90),
(5, 91),
(5, 92),
(5, 93),
(5, 94),
(5, 95),
(5, 96),
(5, 97),
(5, 98),
(5, 99),
(5, 100),
(5, 101),
(5, 102),
(5, 103),
(5, 104),
(5, 105),
(5, 110),
(5, 111),
(5, 112),
(5, 113),
(5, 114),
(5, 115),
(5, 116),
(5, 117),
(5, 119),
(5, 120),
(5, 121),
(5, 137),
(5, 138),
(5, 139),
(5, 140),
(5, 141),
(5, 142),
(5, 143),
(5, 144),
(5, 145),
(5, 146),
(5, 147),
(5, 148),
(5, 149),
(5, 150),
(5, 151),
(5, 161),
(5, 162),
(5, 163),
(5, 164),
(5, 165),
(5, 172),
(5, 173),
(5, 174),
(5, 175),
(5, 176),
(5, 177),
(5, 194),
(5, 195),
(5, 196),
(5, 198),
(5, 199),
(5, 200),
(5, 201),
(5, 202),
(5, 210),
(5, 211),
(5, 219),
(5, 220),
(5, 229),
(5, 230),
(5, 231),
(5, 232),
(5, 244),
(5, 245),
(5, 248),
(5, 249),
(5, 252),
(5, 253),
(5, 269),
(5, 270),
(5, 271),
(5, 273),
(5, 274),
(5, 275),
(5, 295),
(5, 296),
(5, 297),
(5, 298),
(5, 300),
(5, 305),
(5, 306),
(5, 311),
(5, 312),
(5, 316),
(5, 317),
(5, 318),
(5, 319),
(5, 320),
(5, 321),
(5, 322),
(5, 323),
(5, 272),
(1, 114),
(5, 325),
(5, 326),
(5, 327),
(5, 328),
(5, 329),
(5, 330),
(5, 331),
(1, 331),
(5, 332),
(5, 333),
(5, 334),
(1, 334),
(5, 335),
(5, 336),
(6, 2),
(6, 3),
(6, 4),
(6, 7),
(6, 8),
(6, 9),
(6, 11),
(6, 17),
(6, 18),
(6, 19),
(6, 20),
(6, 34),
(6, 35),
(6, 36),
(6, 37),
(6, 38),
(6, 39),
(6, 40),
(6, 41),
(6, 50),
(6, 51),
(6, 52),
(6, 53),
(6, 54),
(6, 56),
(6, 57),
(6, 58),
(6, 59),
(6, 60),
(6, 61),
(6, 63),
(6, 64),
(6, 65),
(6, 66),
(6, 67),
(6, 68),
(6, 69),
(6, 70),
(6, 71),
(6, 73),
(6, 74),
(6, 75),
(6, 76),
(6, 78),
(6, 79),
(6, 80),
(6, 81),
(6, 82),
(6, 84),
(6, 86),
(6, 87),
(6, 88),
(6, 90),
(6, 91),
(6, 93),
(6, 94),
(6, 95),
(6, 96),
(6, 98),
(6, 100),
(6, 101),
(6, 102),
(6, 103),
(6, 104),
(6, 112),
(6, 113),
(6, 114),
(6, 115),
(6, 116),
(6, 117),
(6, 137),
(6, 140),
(6, 145),
(6, 146),
(6, 149),
(6, 161),
(6, 164),
(6, 165),
(6, 173),
(6, 174),
(6, 176),
(6, 177),
(6, 194),
(6, 195),
(6, 198),
(6, 199),
(6, 201),
(6, 202),
(6, 210),
(6, 211),
(6, 219),
(6, 220),
(6, 229),
(6, 230),
(6, 231),
(6, 232),
(6, 244),
(6, 245),
(6, 248),
(6, 249),
(6, 252),
(6, 253),
(6, 269),
(6, 270),
(6, 271),
(6, 272),
(6, 273),
(6, 274),
(6, 275),
(6, 295),
(6, 297),
(6, 298),
(6, 311),
(6, 312),
(6, 319),
(6, 321),
(6, 323),
(6, 324),
(6, 331),
(5, 337),
(5, 338),
(6, 162),
(6, 77),
(5, 340),
(5, 324),
(5, 339),
(5, 341),
(5, 342),
(5, 343),
(5, 344),
(5, 345),
(5, 346);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_items`
--

CREATE TABLE `rental_items` (
  `id` bigint UNSIGNED NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `full_text_search` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `item_rating` double(15,2) DEFAULT '0.00',
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `state_region` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` int DEFAULT NULL,
  `country` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_postal_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `userid_id` bigint UNSIGNED DEFAULT NULL,
  `item_type_id` bigint UNSIGNED DEFAULT NULL,
  `features_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place_id` bigint UNSIGNED DEFAULT NULL,
  `booking_policies_id` int DEFAULT NULL,
  `subcategory_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `service_type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views_count` int DEFAULT '0',
  `module` int DEFAULT '1',
  `steps_completed` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `step_progress` decimal(5,2) NOT NULL DEFAULT '0.00',
  `is_featured` tinyint DEFAULT '0',
  `is_verified` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_item_category`
--

CREATE TABLE `rental_item_category` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` int NOT NULL DEFAULT '1',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_item_dates`
--

CREATE TABLE `rental_item_dates` (
  `id` int UNSIGNED NOT NULL,
  `item_id` int NOT NULL,
  `status` enum('Available','Not available') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Available',
  `booking_id` int NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `min_stay` tinyint NOT NULL DEFAULT '0',
  `min_day` int NOT NULL DEFAULT '0',
  `range_index` int NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `time_slot` time DEFAULT NULL,
  `type` enum('calendar','normal','slot') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `module` tinyint NOT NULL DEFAULT '1',
  `additional_hour` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_item_features`
--

CREATE TABLE `rental_item_features` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` tinyint DEFAULT '2',
  `type` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_item_meta`
--

CREATE TABLE `rental_item_meta` (
  `id` bigint UNSIGNED NOT NULL,
  `rental_item_id` bigint UNSIGNED NOT NULL,
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_item_rules`
--

CREATE TABLE `rental_item_rules` (
  `id` int NOT NULL,
  `rule_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` int NOT NULL DEFAULT '1',
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_item_subcategory`
--

CREATE TABLE `rental_item_subcategory` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `make_id` int DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` tinyint NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_item_types`
--

CREATE TABLE `rental_item_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_item_vehicle`
--

CREATE TABLE `rental_item_vehicle` (
  `id` bigint NOT NULL,
  `item_id` bigint NOT NULL,
  `year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `odometer` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fuel_type_id` int DEFAULT NULL,
  `transmission` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_seats` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_item_wishlists`
--

CREATE TABLE `rental_item_wishlists` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `item_id` int NOT NULL,
  `module` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `bookingid` int NOT NULL,
  `item_id` int DEFAULT '0',
  `item_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `guestid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostid` int DEFAULT NULL,
  `host_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_rating` int NOT NULL DEFAULT '0',
  `guest_message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `host_rating` int DEFAULT '0',
  `host_message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `module` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', NULL, '2023-09-18 18:04:28', NULL),
(2, 'User', NULL, NULL, NULL),
(3, 'manager', '2023-07-05 22:50:57', '2023-07-05 22:50:57', NULL),
(5, 'supper admin', '2024-07-15 06:42:53', '2024-07-15 06:42:53', NULL),
(6, 'demo', '2024-10-25 12:21:56', '2024-10-25 12:21:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(14, 1),
(14, 5),
(18, 6),
(19, 5),
(19, 1),
(19, 2),
(19, 3),
(19, 6),
(14, 2),
(14, 3),
(14, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `heading` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subheading` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `static_pages`
--

CREATE TABLE `static_pages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `static_pages`
--

INSERT INTO `static_pages` (`id`, `name`, `content`, `status`, `module`, `created_at`, `updated_at`) VALUES
(1, 'Terms of Service for Users in English', '<p>Terms of Service for Users</p><p>1. Acceptance of Terms</p><p>1.1. By using our app, you agree to comply with these Terms of Service. If you do not agree with these terms, please do not use the app.</p><p>2. Registration and Account</p><p>2.1. To use the app, you must create an account by providing accurate information.</p><p>2.2. You are responsible for maintaining the confidentiality of your login and password and for all activities conducted under your account.</p><p>2.3. If you suspect any unauthorized use of your account, you must immediately notify the app administration.</p><p>3. Using the App</p><p>3.1. Users can use the app to search and book cars and motorcycles listed by vehicle owners.</p><p>3.2. The app provides access to information about the vehicles, including photos, current mileage, year of manufacture, make, and model, which are uploaded by vehicle owners.</p><p>3.3. Users are responsible for reviewing all provided information and contacting the vehicle owner to clarify any additional details before booking.</p><p>3.4. Users must comply with all rental terms set by the vehicle owners, including rental periods, costs, and rules for using the vehicle.</p><p>4. Payment Issues</p><p>4.1. The app does not process payments for rentals and does not guarantee the reliability of users or vehicle owners.</p><p>4.2. All payment issues, including rental fees and deposits, must be resolved directly between the user and the vehicle owner.</p><p>5. Reviews and Ratings</p><p>5.1. After the rental is completed, both users and vehicle owners can leave reviews and ratings for each other.</p><p>5.2. The app reserves the right to delete or modify reviews that contain inappropriate content or violate platform rules.</p><p>6. Limitation of Liability</p><p>6.1. The app provides a platform for connecting vehicle owners and users but is not responsible for the quality, safety, or truthfulness of listings, nor for the actions of vehicle owners or users.</p><p>6.2. The app is not liable for any losses incurred as a result of using the platform, including but not limited to loss of data, profits, or damage to vehicles.</p><p>7. Privacy</p><p>7.1. We respect your privacy and are committed to protecting your personal information in accordance with our Privacy Policy.</p><p>8. Changes to Terms</p><p>8.1. We reserve the right to modify these Terms of Service at any time. Users will be notified of any changes through the app.</p><p>8.2. Continued use of the app after changes are made signifies your acceptance of the new terms.</p><p>9. Termination of Use</p><p>9.1. We reserve the right to block or delete your account in the event of a violation of the Terms of Service or other app rules.</p><p>Privacy Policy</p><p>1. Information Collection</p><p>1.1. We collect information you provide during registration, including your name, contact details, and any other information necessary to use the app.</p><p>1.2. We also collect information about your activities in the app, including bookings, interactions with users, and reviews.</p><p>2. Use of Information</p><p>2.1. We use your information to provide services, improve app performance, and deliver a personalized experience.</p><p>2.2. Your contact information may be used to send you notifications about bookings, changes to terms, and other important information.</p><p>2.3. We may anonymize your information and use it for analytical and marketing purposes.</p><p>3. Sharing Information</p><p>3.1. We do not share your personal information with third parties, except when necessary to provide services (e.g., sharing data with vehicle owners) or as required by law.</p><p>3.2. In case of partnerships with third parties, your information will only be shared with your consent and in accordance with our Privacy Policy.</p><p>4. Security</p><p>4.1. We take all necessary measures to protect your personal information from unauthorized access, use, or disclosure.</p><p>4.2. Despite our efforts, we cannot guarantee absolute security of data in case of breaches or security attacks.</p><p>5. Access and Modification of Information</p><p>5.1. You have the right to access your personal information stored in the app and request its modification or deletion.</p><p>5.2. You can change your contact details and other privacy settings through the app interface.</p><p>6. Changes to Privacy Policy</p><p>6.1. We reserve the right to modify this Privacy Policy at any time. Users will be notified of any changes through the app.</p><p>6.2. Continued use of the app after changes are made signifies your acceptance of the new Privacy Policy.</p><p>7. Contact Us</p><p>7.1. If you have any questions or concerns regarding our Privacy Policy, please contact us through the feedback form in the app.</p>', '1', 1, '2023-08-08 13:24:28', '2024-12-13 12:46:53'),
(2, 'About us', '<p><strong>About Unibooker Vehicle</strong></p><p>Welcome to <strong>Unibooker Vehicle</strong>, your ultimate platform for seamless and efficient vehicle rentals. Our innovative app connects you with a wide range of cars and bikes, making it incredibly simple to find and book the ideal vehicle for any occasion.</p><p>At <strong>Unibooker Vehicle</strong>, we are dedicated to enhancing your rental experience with features that ensure convenience and flexibility:</p><ul><li><strong>Instant Rentals</strong>: Effortlessly browse and reserve cars and bikes tailored to your needs.</li><li><strong>Direct Communication</strong>: Engage with vehicle owners through our app to get all the details you need.</li><li><strong>Feedback and Ratings</strong>: Share your experiences and benefit from the insights of others.</li><li><strong>Streamlined Interface</strong>: Enjoy an intuitive app experience that makes vehicle rental hassle-free.</li></ul><p><strong>About SIZH IT Solutions Pvt Ltd</strong></p><p><strong>SIZH IT Solutions Pvt Ltd</strong> is your premier partner for web application development, specializing in crafting exceptional online experiences. For over 11 years, we have been the go-to destination for businesses seeking to create or revamp their websites. Our expertise lies in delivering highly responsive, functional, and creatively unique websites that stand out and make a lasting impact.</p><p><strong>Our Location:</strong></p><ul><li><strong>Noida</strong><br>Address: D-52 Sector 2, Noida, Uttar Pradesh 201301<br>Phone: +91 9540223464<br>Email: info@sizhitsolutions.com</li></ul><p>Explore how <strong>SIZH IT Solutions Pvt Ltd</strong> can transform your digital presence and enhance your business with our bespoke web solutions. Visit us to learn more and experience the difference of working with industry leaders in web development.</p>', '1', 1, '2023-08-08 13:25:14', '2024-09-06 11:11:23'),
(4, 'Get help', '<p><strong>Support</strong></p><p><strong>Contact Us</strong></p><p>We are here to ensure that your experience with <strong>Unibooker Vehicle</strong> is as smooth and enjoyable as possible. If you have any questions or need assistance, please don\'t hesitate to contact us through the following channels:</p><p><strong>Email Support</strong>: For all support-related inquiries, please reach out to us at: info@sizhitsolutions.com. Our team is available to assist you with any issues or concerns you may have, and we aim to respond to all emails within 24 hours.</p><p><strong>Phone Support</strong>: If you prefer to speak with someone directly, you can call us at: +91 9540223464. Our phone support team is available during business hours to provide immediate assistance and resolve any urgent issues.</p><p><strong>Frequently Asked Questions (FAQs)</strong></p><p><strong>How do I reset my password?</strong><br>If you\'ve forgotten your password or need to reset it, go to the login screen of the <strong>Unibooker Vehicle</strong> app and click on the \"Forgot Password\" link. Enter your registered email address, and you\'ll receive instructions to create a new password. Follow the prompts to reset your password and regain access to your account.</p><p><strong>How do I update my profile information?</strong><br>To update your profile details, open the app and navigate to the \"Profile\" section found in the app settings. Here, you can edit your personal information, such as your name, contact details, and profile picture. Once you\'ve made the necessary changes, ensure you save them to update your profile.</p><p><strong>How do I report a bug or issue with the app?</strong><br>If you encounter a bug or any issues while using the app, please report it to us by emailing info@sizhitsolutions.com. Provide a detailed description of the issue, including any error messages or screenshots if available. This information helps us resolve the problem more efficiently and improve the app\'s performance.</p><p><strong>How do I cancel my rental or booking?</strong><br>To cancel a rental or booking, open the app and go to the \"Bookings\" section. Select the reservation you wish to cancel and follow the provided instructions. Depending on the rental terms, you may receive a confirmation of the cancellation and information about any applicable fees or refunds.</p><p><strong>How do I provide feedback or suggest improvements?</strong><br>We welcome your feedback and suggestions to help us enhance the <strong>Unibooker Vehicle</strong> experience. You can send your comments and ideas to info@sizhitsolutions.com. Your input is valuable in helping us make continuous improvements to our app.</p><p><strong>Thank you for choosing Unibooker Vehicle!</strong> We are committed to providing exceptional service and ensuring your satisfaction. Should you need further assistance or have any additional questions, please feel free to reach out to us.</p>', '1', 1, '2023-08-08 13:26:04', '2024-10-04 13:23:02'),
(5, 'Give us Feedback', '<p><strong>Give Us Feedback</strong></p><p>At <strong>Unibooker Vehicle</strong>, we are committed to continuously improving our app and delivering the best possible experience for our users. Your feedback is invaluable to us and helps us enhance our services to better meet your needs.</p><p><strong>How to Provide Feedback:</strong></p><p><strong>Feedback Form</strong>: Please fill out our online feedback form to share your thoughts, suggestions, or experiences. You can access the form directly within the app by navigating to the \"Feedback\" section under the settings menu. Your responses will be reviewed by our team, and we will use them to make informed improvements to the app.</p><p><strong>Email Us</strong>: If you prefer, you can email your feedback directly to us at info@sizhitsolutions.com. Please include a detailed description of your feedback, any issues you encountered, and suggestions for improvement. We appreciate any insights you can provide.</p><p><strong>Phone Feedback</strong>: For immediate feedback or to discuss your experience directly, you can call us at +91 9540223464. Our team is available during business hours to listen to your feedback and address any concerns you may have.</p><p><strong>Why Your Feedback Matters:</strong></p><p><strong>Enhancing User Experience</strong>: Your feedback helps us identify areas where we can improve the app\'s functionality and user interface, ensuring a smoother and more enjoyable experience.</p><p><strong>Addressing Issues</strong>: Reporting any issues or bugs allows us to address them promptly, improving the overall reliability and performance of the app.</p><p><strong>Feature Requests</strong>: Let us know if there are features you would like to see in future updates. Your suggestions guide us in developing new features that meet your needs.</p><p><strong>We Value Your Input!</strong></p><p>Thank you for taking the time to provide feedback on <strong>Unibooker Vehicle</strong>. We are dedicated to making continuous improvements and appreciate your contribution to making our app better for everyone. Your satisfaction is our priority, and we look forward to hearing from you.</p>', '1', 1, '2023-08-08 13:26:39', '2024-09-06 11:26:06'),
(6, 'Cancellation policy', '<p>Cancellation policy</p>', '1', 1, '2023-08-08 13:27:22', '2024-05-20 14:06:05'),
(11, 'Terms and Conditions for Owner in English', '<p>Terms of Service for Vehicle Owners</p><p>1. Acceptance of Terms</p><p>1.1. By using our app, you agree to comply with these Terms of Service. If you do not agree with these terms, please do not use the app.</p><p>2. Registration and Account</p><p>2.1. To use the app, you must create an account by providing accurate information.</p><p>2.2. You are responsible for maintaining the confidentiality of your login and password and for all activities conducted under your account.</p><p>2.3. If you suspect any unauthorized use of your account, you must immediately notify the app administration.</p><p>3. Listing Vehicles</p><p>3.1. The vehicle owner agrees to provide accurate and up-to-date information about the vehicles listed for rent.</p><p>3.2. The vehicle owner is required to upload a document proving ownership of the vehicle they are listing. If the vehicle owner is acting under a rental agreement with the vehicle owner, they must provide the appropriate subleasing document.</p><p>3.3. The vehicle owner must accurately list prices and rental conditions, including any potential additional charges.</p><p>3.4. The vehicle owner must provide accurate photos of the vehicle, including the current mileage, year of manufacture, make, and model.</p><p>3.5. If rental conditions change, the vehicle owner must promptly update the information in the listing.</p><p>3.6. The vehicle owner is responsible for the condition of the vehicle and its conformity to the description provided in the listing.</p><p>4. Payment Issues</p><p>4.1. The app does not process payments for rentals and does not guarantee the reliability of renters or vehicle owners.</p><p>4.2. All payment issues, including rental fees and deposits, must be resolved directly between the renter and the vehicle owner.</p><p>5. Subscription and App Usage Fees</p><p>5.1. The app offers a free trial period of 1 to 3 months for new users.</p><p>5.2. After the free trial period, a fee will be charged for using the app based on the chosen subscription plan.</p><p>5.3. The vehicle owner agrees to pay the subscription fee on time according to the chosen plan to continue using the app.</p><p>5.4. If the subscription fee is not paid, access to the app’s features may be restricted.6. Reviews and Ratings</p><p>6.1. After the rental is completed, both the renter and the vehicle owner can leave reviews and ratings for each other.</p><p>6.2. The app reserves the right to delete or modify reviews that contain inappropriate content or violate platform rules.</p><p>7. Limitation of Liability</p><p>7.1. The app provides a platform for connecting vehicle owners and renters but is not responsible for the quality, safety, or truthfulness of listings, nor for the actions of vehicle owners or renters.</p><p>7.2. The app is not liable for any losses incurred as a result of using the platform, including but not limited to loss of data, profits, or damage to vehicles.</p><p>8. Privacy</p><p>8.1. We respect your privacy and are committed to protecting your personal information in accordance with our Privacy Policy.</p><p>9. Changes to Terms</p><p>9.1. We reserve the right to modify these Terms of Service at any time. Users will be notified of any changes through the app.</p><p>9.2. Continued use of the app after changes are made signifies your acceptance of the new terms.</p><p>10. Termination of Use</p><p>10.1. We reserve the right to block or delete your account in the event of a violation of the Terms of Service or other app rules.</p><p>Privacy Policy</p><p>1. Information Collection</p><p>1.1. We collect information you provide during registration, including your name, contact details, and any other information necessary to use the app.</p><p>1.2. We also collect information about your activities in the app, including listing vehicles, interactions with users, and reviews.</p><p>2. Use of Information</p><p>2.1. We use your information to provide services, improve app performance, and deliver a personalized experience.</p><p>2.2. Your contact information may be used to send you notifications about bookings, changes to terms, and other important information.</p><p>2.3. We may anonymize your information and use it for analytical and marketing purposes.</p><p>3. Sharing Information3.1. We do not share your personal information with third parties, except when necessary to provide services (e.g., sharing data with renters) or as required by law.</p><p>3.2. In case of partnerships with third parties, your information will only be shared with your consent and in accordance with our Privacy Policy.</p><p>4. Security</p><p>4.1. We take all necessary measures to protect your personal information from unauthorized access, use, or disclosure.</p><p>4.2. Despite our efforts, we cannot guarantee absolute security of data in case of breaches or security attacks.</p><p>5. Access and Modification of Information</p><p>5.1. You have the right to access your personal information stored in the app and request its modification or deletion.</p><p>5.2. You can change your contact details and other privacy settings through the app interface.</p><p>6. Changes to Privacy Policy</p><p>6.1. We reserve the right to modify this Privacy Policy at any time. Users will be notified of any changes through the app.</p><p>6.2. Continued use of the app after changes are made signifies your acceptance of the new Privacy Policy.</p><p>7. Contact Us</p><p>7.1. If you have any questions or concerns regarding our Privacy Policy, please contact us through the feedback form in the app.</p>', '1', 1, '2024-08-02 08:04:08', '2024-12-09 16:25:10'),
(13, 'Terms and Conditions for users  in Thai', '<p>ข้อตกลงการใช ้งานส าหร ับผู้ใช ้</p><p>1. การยอมร ั บเงื่อน ไข</p><p>1.1. โดยการใช ้แอปของเรา คุณยอมรับที่จะปฏิบัติตามข ้ อก าหนดเหล่านี้ หากคุณ ไม่ยอมรับเงื่อน ไขเหล่านี้</p><p>โปรดอย่าใช ้แอป</p><p>2. การลงทะเบียนและบัญชีผู้ใช ้</p><p>2.1. ในการใช ้แอป คุณต ้ องสร ้ างบัญชีโดย ให้ข ้ อมูลที่ถูกต ้ อง</p><p>2.2. คุณมีหน้าที่รับผิดชอบ ในการรักษาความลับของข ้ อมูลการเข ้ าสู่ระบบและรหัสผ่าน</p><p>และส าหรับกิจกรรมทั้งหมดที่ด าเนินการภาย ใต ้ บัญชีของคุณ</p><p>2.3. หากคุณสงสัยว่ามีการใช ้บัญชีของคุณโดยไม่ได ้รับอนุญาต คุณต ้องแจ ้งให้แอดมินแอปทราบทันที</p><p>3. การใช ้งานแอป</p><p>3.1. ผู้ใช ้ สามารถ ใช ้ แอปเพื่อค ้ นหาและจองรถยนต ์ และรถจักรยานยนต ์ ที่เจ ้ าของยานพาหนะประกาศ ไว ้</p><p>3.2. แอปให้สิทธิ ์ การเข ้ าถึงข ้ อมูลเกี่ยวกับยานพาหนะ รวมถึงรูปถ่าย ระยะทางปัจจุบัน ปีที่ผลิต ยี่ห้อ</p><p>และรุ่นที่เจ ้ าของยานพาหนะอัปโหลด ไว ้</p><p>3.3.</p><p>ผู้ใช ้ มีหน้าที่ในการตรวจสอบข ้ อมูลทั้งหมดที่มีให้และติดต่อเจ ้าของยานพาหนะเพื่อขอรายละเอียดเพิ่มเติมก่อนการ</p><p>จอง</p><p>3.4. ผู้ใช ้ ต ้ องปฏิบัติตามข ้ อก าหนดการเช่าทั้งหมดที่ก าหนด โดยเจ ้ าของยานพาหนะ รวมถึงระยะเวลาเช่า ค่าใช ้จ่าย</p><p>และกฎการใช ้ยานพาหนะ</p><p>4. การแก้ไขปัญหาการช าระเงิน</p><p>4.1. แอปไม่รับช าระเงินส าหรับการเช่าและไม่รับประกันความน่าเชื่อถือของผู้ใช ้ หรือเจ ้ าของยานพาหนะ</p><p>4.2.</p><p>ปัญหาการช าระเงินทั้งหมดรวมถึงค่าธรรมเนียมการเช่าและเงินมัดจ าจะต ้ องแก ้ ไข โดยตรงระหว่างผู้ ใช ้ และเจ ้ าของยา</p><p>นพาหนะ</p><p>5. บทวิจารณ์และการให้คะแนน</p><p>5.1. หลังจากการเช่าเสร็จสิ้ น</p><p>ทั้งผู้ใช ้ และเจ ้ าของยานพาหนะสามารถแสดงความคิดเห็นและให้คะแนนซึ่งกันและกัน ได ้</p><p>5.2. แอปขอสงวนสิทธิ ์ ในการลบหรือแก ้ ไขความคิดเห็นที่มีเนื้อหาไม่เหมาะสมหรือฝ ่ าฝ ื นกฎของแพลตฟอร ์ ม</p><p>6. ข้อจ าก ัดความร ับผิด</p><p>6.1. แอปเป ็ นเพียงแพลตฟอร ์ มที่เชื่อมต่อระหว่างเจ ้ าของยานพาหนะและผู้ใช ้ แต่ไม่รับผิดชอบต่อคุณภาพ</p><p>ความปลอดภัย หรือความถูกต ้องของประกาศ รวมถึงการกระท าของเจ ้าของยานพาหนะหรือผู้ใช ้</p><p>6.2. แอปไม่รับผิดชอบต่อความสูญเสียใดๆ ที่เกิดขึ้ นจากการ ใช ้ แพลตฟอร ์ ม</p><p>รวมถึงแต่ไม่จ ากัดเพียงการสูญหายของข ้อมูล ก าไร หรือความเสียหายต่อยานพาหนะ</p><p>7. ความเป็ นส่วนตัว7.1.</p><p>เราเคารพความเป ็ นส่วนตัวของคุณและมุ่งมั่นที่จะปกป ้ องข ้ อมูลส่วนบุคคลของคุณตามน โยบายความเป ็ นส่วนตัวขอ</p><p>งเรา</p><p>8. การเปลี่ยนแปลงเงื่อน ไข</p><p>8.1. เราขอสงวนสิทธิ ์ ในการแก ้ ไขข ้ อก าหนดการ ใช ้ งานเหล่านี้ได ้ ตลอดเวลา ผู้ใช ้ จะได ้ รับแจ ้ งการเปลี่ยนแปลง ใด ๆ</p><p>ผ่านแอป</p><p>8.2. การ ใช ้ แอปอย่างต่อเนื่องหลังจากมีการเปลี่ยนแปลงแสดงว่าคุณยอมรับข ้ อก าหนด ใหม่</p><p>9. การยุติการใช ้งาน</p><p>9.1. เราขอสงวนสิทธิ ์ ในการบล็อกหรือยกเลิกบัญชีของคุณ ในกรณีที่มีการละเมิดข ้ อก าหนดการ ใช ้ งานหรือกฎอื่น</p><p>ๆ ของแอป</p><p>นโยบายความเป็ นส่วนตัว</p><p>1. การรวบรวมข้อมูล</p><p>1.1. เรารวบรวมข ้ อมูลที่คุณ ให้ไว ้ ระหว่างการลงทะเบียน รวมถึงชื่อของคุณ รายละเอียดการติดต่อ และข ้ อมูลอื่น ๆ</p><p>ที่จ าเป ็ นส าหรับการ ใช ้ แอป</p><p>1.2. เรายังรวบรวมข ้ อมูลเกี่ยวกับกิจกรรมของคุณ ในแอป รวมถึงการจอง การ โต ้ ตอบกับผู้ใช ้ รายอื่น</p><p>และความคิดเห็น</p><p>2. การใช ้ข้อมูล</p><p>2.1. เราใช ้ ข ้ อมูลของคุณเพื่อ ให้บริการ ปรับปรุงประสิทธิภาพของแอป และมอบประสบการณ์ที่เป ็ นส่วนตัว</p><p>2.2. ข ้ อมูลการติดต่อของคุณอาจถูก ใช ้ เพื่อส่งการแจ ้ งเตือนเกี่ยวกับการจอง การเปลี่ยนแปลงเงื่อน ไข</p><p>และข ้ อมูลส าคัญอื่นๆ</p><p>2.3. เราอาจท าให้ข ้ อมูลของคุณ ไม่ระบุตัวตนและใช ้ เพื่อวัตถุประสงค ์ ในการวิเคราะห ์ และการตลาด</p><p>3. การแบ่งปันข้อมูล</p><p>3.1. เราจะไม่แบ่งปันข ้ อมูลส่วนบุคคลของคุณกับบุคคลที่สาม ยกเว ้ นเมื่อจ าเป ็ นต ้ อง ให้บริการ (เช่น</p><p>การแบ่งปันข ้อมูลกับเจ ้าของยานพาหนะ) หรือหากกฎหมายก าหนด</p><p>3.2. ในกรณีที่มีการร่วมมือกับบุคคลที่สาม</p><p>ข ้อมูลของคุณจะถูกแบ่งปันตามความยินยอมของคุณและสอดคล ้องกับนโยบายความเป็ นส่วนตัวของเรา</p><p>4. ความปลอดภัย</p><p>4.1. เราใช ้ มาตรการที่จ าเป ็ นทั้งหมดเพื่อปกป ้ องข ้ อมูลส่วนบุคคลของคุณจากการเข ้ าถึง การใช ้</p><p>หรือการเปิดเผยโดยไม่ได ้รับอนุญาต</p><p>4.2. แม้เราจะพยายามอย่างดีที่สุด</p><p>เราไม่สามารถรับประกันความปลอดภัยของข ้ อมูลอย่างเต็มที่ในกรณีที่มีการ โจมตีหรือการละเมิดความปลอดภัย</p><p>5. การเข้าถึงและการแก้ไขข้อมูล5.1. คุณมีสิทธิ ์ เข ้ าถึงข ้ อมูลส่วนบุคคลของคุณที่เก็บ ไว ้ ในแอปและขอแก ้ ไขหรือลบข ้ อมูล ได ้</p><p>5.2. คุณสามารถเปลี่ยนแปลงรายละเอียดการติดต่อและการตั้งค่าความเป ็ นส่วนตัวอื่นๆ ผ่านอินเทอร ์เฟซของแอป</p><p>6. การเปลี่ยนแปลงน โยบายความเป ็ นส่วนตัว</p><p>6.1. เราขอสงวนสิทธิ ์ ในการแก ้ ไขน โยบายความเป ็ นส่วนตัวนี้ได ้ ตลอดเวลา ผู้ใช ้ จะได ้ รับแจ ้ งการเปลี่ยนแปลง ใด ๆ</p><p>ผ่านแอป</p><p>6.2. การ ใช ้ แอปอย่างต่อเนื่องหลังจากมีการเปลี่ยนแปลงแสดงว่าคุณยอมรับน โยบายความเป ็ นส่วนตัว ใหม่</p><p>7. ติดต่อเรา</p><p>7.1. หากคุณมีค าถามหรือข ้ อสงสัยเกี่ยวกับน โยบายความเป ็ นส่วนตัวของเรา</p><p>โปรดติดต่อเราผ่านแบบฟอร ์มข ้อเสนอแนะในแอป</p>', '1', 1, '2024-08-05 07:37:04', '2024-08-08 05:19:48'),
(14, 'Terms and Conditions for Owner in Russia', '<p>Условия использования для владельцев транспортных средств</p><p>1. Принятие условий</p><p>1.1. Используя наше приложение, вы соглашаетесь соблюдать данные Условия</p><p>использования. Если вы не согласны с этими условиями, пожалуйста, не используйте</p><p>приложение.</p><p>2. Регистрация и учетная запись</p><p>2.1. Для использования приложения вы должны создать учетную запись, предоставив</p><p>достоверную информацию.</p><p>2.2. Вы несете ответственность за сохранность конфиденциальности вашего логина и</p><p>пароля, а также за все действия, совершенные с вашего аккаунта.</p><p>2.3. В случае подозрения на несанкционированное использование вашего аккаунта, вы</p><p>должны немедленно уведомить администрацию приложения.</p><p>3. Размещение транспортных средств</p><p>3.1. Владелец транспортного средства обязуется предоставлять достоверную и</p><p>актуальную информацию о транспортных средствах, выставленных на аренду.</p><p>3.2. Владелец транспортного средства обязан загружать документ, подтверждающий</p><p>право владения транспортным средством, которое выставляется на аренду. В случае, если</p><p>владелец транспортного средства действует на основании договора аренды с</p><p>владельцем, он обязан предоставить соответствующий документ для субаренды.</p><p>3.3. Владелец транспортного средства обязан указывать точные цены и условия аренды,</p><p>включая возможные дополнительные расходы.</p><p>3.4. Владелец транспортного средства обязан предоставлять достоверные фотографии</p><p>транспортного средства, включая информацию о текущем пробеге, годе выпуска, марке и</p><p>модели.</p><p>3.5. В случае изменения условий аренды владелец транспортного средства должен</p><p>немедленно обновить информацию в объявлении.</p><p>3.6. Владелец транспортного средства несет ответственность за состояние транспортного</p><p>средства и его соответствие описанию в объявлении.</p><p>4. Вопросы оплаты</p><p>4.1. Приложение не осуществляет прием оплаты за аренду и не гарантирует</p><p>добросовестность арендаторов или владельцев транспортных средств.</p><p>4.2. Все вопросы, связанные с оплатой аренды и депозитами, решаются напрямую между</p><p>арендатором и владельцем транспортного средства.</p><p>5. Подписка и оплата за использование приложения</p><p>5.1. Приложение предоставляет бесплатный пробный период от 1 до 3 месяцев для новых</p><p>пользователей.5.2. По окончании бесплатного периода будет взиматься плата за использование</p><p>приложения на основе выбранного тарифного плана.</p><p>5.3. Владелец транспортного средства обязуется своевременно оплачивать подписку в</p><p>соответствии с выбранным тарифным планом для продолжения использования</p><p>приложения.</p><p>5.4. В случае неуплаты подписки доступ к функционалу приложения может быть</p><p>ограничен.</p><p>6. Отзывы и рейтинги</p><p>6.1. После завершения аренды арендатор и владелец транспортного средства могут</p><p>оставить отзывы и рейтинги друг о друге.</p><p>6.2. Приложение оставляет за собой право удалять или модифицировать отзывы, которые</p><p>содержат ненадлежащий контент или нарушают правила платформы.</p><p>7. Ограничение ответственности</p><p>7.1. Приложение предоставляет платформу для связи между владельцами транспортных</p><p>средств и арендаторами, но не несет ответственности за качество, безопасность или</p><p>правдивость объявлений, а также за действия владельцев транспортных средств или</p><p>арендаторов.</p><p>7.2. Приложение не несет ответственности за убытки, понесенные в результате</p><p>использования платформы, включая, но не ограничиваясь, потерями данных, прибыли</p><p>или ущерба транспортным средствам.</p><p>8. Конфиденциальность</p><p>8.1. Мы уважаем вашу конфиденциальность и обязуемся защищать вашу личную</p><p>информацию в соответствии с нашей Политикой конфиденциальности.</p><p>9. Изменения условий</p><p>9.1. Мы оставляем за собой право изменять данные Условия использования в любое</p><p>время. Обо всех изменениях пользователи будут уведомлены через приложение.</p><p>9.2. Использование приложения после внесения изменений означает ваше согласие с</p><p>новыми условиями.</p><p>10. Прекращение использования</p><p>10.1. Мы оставляем за собой право заблокировать или удалить ваш аккаунт в случае</p><p>нарушения Условий использования или других правил приложения.</p><p>Политика конфиденциальности</p><p>1. Сбор информации</p><p>1.1. Мы собираем информацию, которую вы предоставляете при регистрации, включая</p><p>ваше имя, контактные данные и любую другую информацию, необходимую для</p><p>использования приложения.1.2. Мы также собираем информацию о ваших действиях в приложении, включая</p><p>размещение транспортных средств, взаимодействия с пользователями и отзывы.</p><p>2. Использование информации</p><p>2.1. Мы используем вашу информацию для предоставления услуг, улучшения работы</p><p>приложения и предоставления персонализированного опыта.</p><p>2.2. Ваша контактная информация может использоваться для отправки вам уведомлений о</p><p>бронированиях, изменения условий использования и другой важной информации.</p><p>2.3. Мы можем анонимизировать вашу информацию и использовать ее для аналитических</p><p>и маркетинговых целей.</p><p>3. Обмен информацией</p><p>3.1. Мы не передаем вашу личную информацию третьим лицам, за исключением случаев,</p><p>когда это необходимо для предоставления услуг (например, передачи данных</p><p>арендаторам) или требуется по закону.</p><p>3.2. В случае партнерства с третьими сторонами, ваша информация будет передаваться</p><p>только с вашего согласия и в соответствии с нашей Политикой конфиденциальности.</p><p>4. Безопасность</p><p>4.1. Мы предпринимаем все необходимые меры для защиты вашей личной информации</p><p>от несанкционированного доступа, использования или раскрытия.</p><p>4.2. Несмотря на наши усилия, мы не можем гарантировать абсолютную безопасность</p><p>данных в случае атак или нарушений безопасности.</p><p>5. Доступ и изменение информации</p><p>5.1. Вы имеете право получить доступ к вашей личной информации, хранящейся в</p><p>приложении, и запросить ее изменение или удаление.</p><p>5.2. Вы можете изменить свои контактные данные и другие настройки</p><p>конфиденциальности через интерфейс приложения.</p><p>6. Изменения в Политике конфиденциальности</p><p>6.1. Мы оставляем за собой право изменять данную Политику конфиденциальности в</p><p>любое время. Обо всех изменениях пользователи будут уведомлены через приложение.</p><p>6.2. Использование приложения после внесения изменений означает ваше согласие с</p><p>новой Политикой конфиденциальности.</p><p>7. Контакты</p><p>7.1. Если у вас есть вопросы или замечания по поводу нашей Политики</p><p>конфиденциальности, пожалуйста, свяжитесь с нами через форму обратной связи в</p><p>приложении.</p>', '1', 1, '2024-08-05 07:42:15', '2024-08-05 07:42:15'),
(15, 'Terms and conditions  to become a Owner in thai', '<p>ข้อตกลงการใช้งานส าหรับเจ้าของยานพาหนะ</p><p>1. การยอมรับเงื่อน ไข</p><p>1.1. โดยการใช ้แอปของเรา คุณยอมรับที่จะปฏิบัติตามข ้ อก าหนดเหล่านี้ หากคุณ ไม่ยอมรับเงื่อน ไขเหล่านี้</p><p>โปรดอย่าใช ้แอป</p><p>2. การลงทะเบียนและบัญชีผู้ใช้</p><p>2.1. ในการใช ้แอป คุณต ้ องสร ้ างบัญชีโดย ให้ข ้ อมูลที่ถูกต ้ อง</p><p>2.2. คุณมีหน้าที่รับผิดชอบ ในการรักษาความลับของข ้ อมูลการเข ้ าสู่ระบบและรหัสผ่าน</p><p>และส าหรับกิจกรรมทั้งหมดที่ด าเนินการภาย ใต ้ บัญชีของคุณ</p><p>2.3. หากคุณสงสัยว่ามีการใช ้บัญชีของคุณโดยไม่ได ้รับอนุญาต คุณต ้องแจ ้งให้แอดมินแอปทราบทันที</p><p>3. การลงประกาศยานพาหนะ</p><p>3.1. เจ ้ าของยานพาหนะตกลงที่จะให้ข ้ อมูลที่ถูกต ้ องและเป ็ นปัจจุบันเกี่ยวกับยานพาหนะที่ประกาศ ให้เช่า</p><p>3.2. เจ ้ าของยานพาหนะต ้ องอัปโหลดเอกสารที่พิสูจน์ความเป ็ นเจ ้ าของยานพาหนะที่ประกาศ</p><p>หากเจ ้าของยานพาหนะท าสัญญาเช่ากับเจ ้าของยานพาหนะเดิม</p><p>จะต ้ อง ให้เอกสารที่เกี่ยวข ้ องส าหรับการปล่อยเช่าเพิ่มเติม</p><p>3.3. เจ ้ าของยานพาหนะต ้ องระบุราคาที่ถูกต ้ องและเงื่อน ไขการเช่า รวมถึงค่าธรรมเนียมเพิ่มเติมที่อาจมี</p><p>3.4. เจ ้ าของยานพาหนะต ้ อง ให้ ภาพถ่ายที่ถูกต ้ องของยานพาหนะ รวมถึงข ้อมูลระยะทางปัจจุบัน ปีที่ผลิต ยี่ห้อ</p><p>และรุ่น</p><p>3.5. หากเงื่อน ไขการเช่าเปลี่ยนแปลง เจ ้าของยานพาหนะต ้องอัปเดตข ้อมูลในประกาศให้ทันที</p><p>3.6. เจ ้ าของยานพาหนะรับผิดชอบต่อสภาพของยานพาหนะและความสอดคล ้ องกับค าอธิบายที่ให้ไว ้ ในประกาศ</p><p>4. การแก้ไขปัญหาการช าระเงิน</p><p>4.1. แอปไม่รับช าระเงินส าหรับการเช่าและไม่รับประกันความน่าเชื่อถือของผู้เช่าหรือเจ ้ าของยานพาหนะ</p><p>4.2.</p><p>ปัญหาการช าระเงินทั้งหมดรวมถึงค่าธรรมเนียมการเช่าและเงินมัดจ าจะต ้ องแก ้ ไข โดยตรงระหว่างผู้เช่าและเจ ้ าของย</p><p>านพาหนะ</p><p>5. ค่าบริการและค่าธรรมเนียมการใช้แอป</p><p>5.1. แอปมีระยะเวลาทดลองใช ้งานฟรี 1 ถึง 3 เดือนส าหรับผู้ใช ้ใหม่</p><p>5.2. หลังจากช่วงทดลองฟรี จะมีการเรียกเก็บค่าบริการส าหรั บการ ใช ้ แอปตามแผนการสมัครที่เลือก</p><p>5.3. เจ ้ าของยานพาหนะตกลงที่จะช าระค่าบริการสมัคร ใช ้ แอปตามแผนที่เลือกเพื่อ ใช ้ แอปต่อ ไป</p><p>5.4. หากไม่มีการช าระค่าบริการสมัคร การเข ้าถึงคุณลักษณะของแอปอาจถูกจ ากัด</p><p>6. บทวิจารณ์และการให้คะแนน</p><p>6.1. หลังจากการเช่าเสร็จสิ้ น</p><p>ทั้งผู้เช่าและเจ ้ าของยานพาหนะสามารถแสดงความคิดเห็นและให้คะแนนซึ่งกันและกัน ได ้6.2. แอปขอสงวนสิทธิ ์ ในการลบหรือแก ้ ไขความคิดเห็นที่มีเนื้อหาไม่เหมาะสมหรือฝ ่ าฝ ื นกฎของแพลตฟอร ์ ม</p><p>7. ข้อจ ากัดความรับผิด</p><p>7.1. แอปเป ็ นเพียงแพลตฟอร ์ มที่เชื่อมต่อระหว่างเจ ้ าของยานพาหนะและผู้เช่า แต่ไม่รับผิดชอบต่อคุณภาพ</p><p>ความปลอดภัย หรือความถูกต ้องของประกาศ รวมถึงการกระท าของเจ ้าของยานพาหนะหรือผู้เช่า</p><p>7.2. แอปไม่รับผิดชอบต่อความสูญเสียใดๆ ที่เกิดขึ้ นจากการ ใช ้ แพลตฟอร ์ ม</p><p>รวมถึงแต่ไม่จ ากัดเพียงการสูญหายของข ้อมูล ก าไร หรือความเสียหายต่อยานพาหนะ</p><p>8. ความเป็ นส่วนตัว</p><p>8.1.</p><p>เราเคารพความเป ็ นส่วนตัวของคุณและมุ่งมั่นที่จะปกป ้ องข ้ อมูลส่วนบุคคลของคุณตามน โยบายความเป ็ นส่วนตัวขอ</p><p>งเรา</p><p>9. การเปลี่ยนแปลงเงื่อน ไข</p><p>9.1. เราขอสงวนสิทธิ ์ ในการแก ้ ไขข ้ อก าหนดการ ใช ้ งานเหล่านี้ได ้ ตลอดเวลา ผู้ใช ้ จะได ้ รับแจ ้ งการเปลี่ยนแปลง ใด ๆ</p><p>ผ่านแอป</p><p>9.2. การ ใช ้ แอปอย่างต่อเนื่องหลังจากมีการเปลี่ยนแปลงแสดงว่าคุณยอมรับข ้ อก าหนด ใหม่</p><p>10. การยุติการใช้งาน</p><p>10.1.</p><p>เราขอสงวนสิทธิ ์ ในการบล็อกหรือยกเลิกบัญชีของคุณ ในกรณีที่มีการละเมิดข ้ อก าหนดการ ใช ้ งานหรือกฎอื่น ๆ</p><p>ของแอป</p><p>นโยบายความเป็ นส่วนตัว</p><p>1. การรวบรวมข้อมูล</p><p>1.1. เรารวบรวมข ้ อมูลที่คุณ ให้ไว ้ ระหว่างการลงทะเบียน รวมถึงชื่อของคุณ รายละเอียดการติดต่อ และข ้ อมูลอื่น ๆ</p><p>ที่จ าเป ็ นส าหรับการ ใช ้ แอป</p><p>1.2. เรายังรวบรวมข ้ อมูลเกี่ยวกับกิจกรรมของคุณ ในแอป รวมถึงการลงประกาศยานพาหนะ</p><p>การ โต ้ ตอบกับผู้ใช ้ รายอื่น และความคิดเห็น</p><p>2. การใช้ข้อมูล</p><p>2.1. เราใช ้ ข ้ อมูลของคุณเพื่อ ให้บริการ ปรับปรุงประสิทธิภาพของแอป และมอบประสบการณ์ที่เป ็ นส่วนตัว</p><p>2.2. ข ้ อมูลการติดต่อของคุณอาจถูก ใช ้ เพื่อส่งการแจ ้ งเตือนเกี่ยวกับการจอง การเปลี่ยนแปลงเงื่อน ไข</p><p>และข ้ อมูลส าคัญอื่นๆ</p><p>2.3. เราอาจท าให้ข ้ อมูลของคุณ ไม่ระบุตัวตนและใช ้ เพื่อวัตถุประสงค ์ ในการวิเคราะห ์ และการตลาด</p><p>3. การแบ่งปันข้อมูล</p><p>3.1. เราจะไม่แบ่งปันข ้ อมูลส่วนบุคคลของคุณกับบุคคลที่สาม ยกเว ้ นเมื่อจ าเป ็ นต ้ อง ให้บริการ (เช่น</p><p>การแบ่งปันข ้อมูลกับผู้เช่า) หรือหากกฎหมายก าหนด3.2. ในกรณีที่มีการร่วมมือกับบุคคลที่สาม</p><p>ข ้อมูลของคุณจะถูกแบ่งปันตามความยินยอมของคุณและสอดคล ้องกับนโยบายความเป็ นส่วนตัวของเรา</p><p>4. ความปลอดภัย</p><p>4.1. เราใช ้ มาตรการที่จ าเป ็ นทั้งหมดเพื่อปกป ้ องข ้ อมูลส่วนบุคคลของคุณจากการเข ้ าถึง การใช ้</p><p>หรือการเปิดเผยโดยไม่ได ้รับอนุญาต</p><p>4.2. แม้เราจะพยายามอย่างดีที่สุด</p><p>เราไม่สามารถรับประกันความปลอดภัยของข ้ อมูลอย่างเต็มที่ในกรณีที่มีการ โจมตีหรือการละเมิดความปลอดภัย</p><p>5. การเข้าถึงและการแก้ไขข้อมูล</p><p>5.1. คุณมีสิทธิ ์ เข ้ าถึงข ้ อมูลส่วนบุคคลของคุณที่เก็บ ไว ้ ในแอปและขอแก ้ ไขหรือลบข ้ อมูล ได ้</p><p>5.2. คุณสามารถเปลี่ยนแปลงรายละเอียดการติดต่อและการตั้งค่าความเป ็ นส่วนตัวอื่นๆ ผ่านอินเทอร ์เฟซของแอป</p><p>6. การเปลี่ยนแปลงน โยบายความเป ็ นส่วนตัว</p><p>6.1. เราขอสงวนสิทธิ ์ ในการแก ้ ไขน โยบายความเป ็ นส่วนตัวนี้ได ้ ตลอดเวลา ผู้ใช ้ จะได ้ รับแจ ้ งการเปลี่ยนแปลง ใด ๆ</p><p>ผ่านแอป</p><p>6.2. การ ใช ้ แอปอย่างต่อเนื่องหลังจากมีการเปลี่ยนแปลงแสดงว่าคุณยอมรับน โยบายความเป ็ นส่วนตัว ใหม่</p><p>7. ติดต่อเรา</p><p>7.1. หากคุณมีค าถามหรือข ้ อสงสัยเกี่ยวกับน โยบายความเป ็ นส่วนตัวของเรา</p><p>โปรดติดต่อเราผ่านแบบฟอร ์มข ้อเสนอแนะในแอป</p>', '1', 1, '2024-08-05 07:43:18', '2024-08-05 07:43:18'),
(19, 'Trems and conditions to become a user in Russia', '<p>Условия использования для пользователей</p><p>1. Принятие условий</p><p>1.1. Используя наше приложение, вы соглашаетесь соблюдать данные Условия</p><p>использования. Если вы не согласны с этими условиями, пожалуйста, не используйте</p><p>приложение.</p><p>2. Регистрация и учетная запись</p><p>2.1. Для использования приложения вы должны создать учетную запись, предоставив</p><p>достоверную информацию.</p><p>2.2. Вы несете ответственность за сохранность конфиденциальности вашего логина и</p><p>пароля, а также за все действия, совершенные с вашего аккаунта.</p><p>2.3. В случае подозрения на несанкционированное использование вашего аккаунта, вы</p><p>должны немедленно уведомить администрацию приложения.</p><p>3. Использование приложения</p><p>3.1. Пользователи могут использовать приложение для поиска и бронирования</p><p>автомобилей и мотоциклов, выставленных владельцами транспортных средств.</p><p>3.2. Приложение предоставляет доступ к информации о транспортных средствах, включая</p><p>фотографии, текущий пробег, год выпуска, марку и модель, которые загружены</p><p>владельцами транспортных средств.</p><p>3.3. Пользователи обязаны проверить всю предоставленную информацию и связаться с</p><p>владельцем транспортного средства для уточнения любых дополнительных деталей перед</p><p>бронированием.</p><p>3.4. Пользователи обязаны соблюдать все условия аренды, установленные владельцами</p><p>транспортных средств, включая сроки аренды, стоимость и правила использования</p><p>транспортного средства.</p><p>3.5. Приложение предлагает автоматическую конвертацию валют для удобства пользователей, чтобы они могли просматривать цены в удобной для них валюте. Однако, фактическая цена может отличаться из-за колебаний обменного курса. Пользователи должны учитывать, что окончательная сумма в их валюте может отличаться от суммы, указанной в приложении.</p><p>4. Вопросы оплаты</p><p>4.1. Приложение не осуществляет прием оплаты за аренду и не гарантирует</p><p>добросовестность арендаторов или владельцев транспортных средств.</p><p>4.2. Все вопросы, связанные с оплатой аренды и депозитами, решаются напрямую между</p><p>пользователем и владельцем транспортного средства.</p><p>5. Отзывы и рейтинги</p><p>5.1. После завершения аренды пользователи и владельцы транспортных средств могут</p><p>оставить отзывы и рейтинги друг о друге.</p><p>5.2. Приложение оставляет за собой право удалять или модифицировать отзывы, которые</p><p>содержат ненадлежащий контент или нарушают правила платформы.</p><p>6. Ограничение ответственности</p><p>6.1. Приложение предоставляет платформу для связи между владельцами транспортных</p><p>средств и пользователями, но не несет ответственности за качество, безопасность илиправдивость объявлений, а также за действия владельцев транспортных средств или</p><p>пользователей.</p><p>6.2. Приложение не несет ответственности за убытки, понесенные в результате</p><p>использования платформы, включая, но не ограничиваясь, потерями данных, прибыли</p><p>или ущерба транспортным средствам.</p><p>7. Конфиденциальность</p><p>7.1. Мы уважаем вашу конфиденциальность и обязуемся защищать вашу личную</p><p>информацию в соответствии с нашей Политикой конфиденциальности.</p><p>8. Изменения условий</p><p>8.1. Мы оставляем за собой право изменять данные Условия использования в любое</p><p>время. Обо всех изменениях пользователи будут уведомлены через приложение.</p><p>8.2. Использование приложения после внесения изменений означает ваше согласие с</p><p>новыми условиями.</p><p>9. Прекращение использования</p><p>9.1. Мы оставляем за собой право заблокировать или удалить ваш аккаунт в случае</p><p>нарушения Условий использования или других правил приложения</p><p>Политика конфиденциальности</p><p>1. Сбор информации</p><p>1.1. Мы собираем информацию, которую вы предоставляете при регистрации, включая</p><p>ваше имя, контактные данные и любую другую информацию, необходимую для</p><p>использования приложения.</p><p>1.2. Мы также собираем информацию о ваших действиях в приложении, включая</p><p>бронирования, взаимодействия с пользователями и отзывы.</p><p>2. Использование информации</p><p>2.1. Мы используем вашу информацию для предоставления услуг, улучшения работы</p><p>приложения и предоставления персонализированного опыта.</p><p>2.2. Ваша контактная информация может использоваться для отправки вам уведомлений о</p><p>бронированиях, изменения условий использования и другой важной информации.</p><p>2.3. Мы можем анонимизировать вашу информацию и использовать ее для аналитических</p><p>и маркетинговых целей.</p><p>3. Обмен информацией</p><p>3.1. Мы не передаем вашу личную информацию третьим лицам, за исключением случаев,</p><p>когда это необходимо для предоставления услуг (например, передачи данных владельцам</p><p>транспортных средств) или требуется по закону.</p><p>3.2. В случае партнерства с третьими сторонами, ваша информация будет передаваться</p><p>только с вашего согласия и в соответствии с нашей Политикой конфиденциальности.4. Безопасность</p><p>4.1. Мы предпринимаем все необходимые меры для защиты вашей личной информации</p><p>от несанкционированного доступа, использования или раскрытия.</p><p>4.2. Несмотря на наши усилия, мы не можем гарантировать абсолютную безопасность</p><p>данных в случае атак или нарушений безопасности.</p><p>5. Доступ и изменение информации</p><p>5.1. Вы имеете право получить доступ к вашей личной информации, хранящейся в</p><p>приложении, и запросить ее изменение или удаление.</p><p>5.2. Вы можете изменить свои контактные данные и другие настройки</p><p>конфиденциальности через интерфейс приложения.</p><p>6. Изменения в Политике конфиденциальности</p><p>6.1. Мы оставляем за собой право изменять данную Политику конфиденциальности в</p><p>любое время. Обо всех изменениях пользователи будут уведомлены через приложение.</p><p>6.2. Использование приложения после внесения изменений означает ваше согласие с</p><p>новой Политикой конфиденциальности.</p><p>7. Контакты</p><p>7.1. Если у вас есть вопросы или замечания по поводу нашей Политики</p><p>конфиденциальности, пожалуйста, свяжитесь с нами через форму обратной связи в</p><p>приложении.</p><p>&nbsp;</p>', '1', 1, '2024-09-06 11:57:46', '2024-09-06 11:57:46'),
(20, 'Terms and conditions for users in Arabic', '<h3><strong>شروط الاستخدام</strong></h3><ol><li><strong>قبول الشروط</strong></li></ol><p>1.1. باستخدام تطبيقنا، فإنك توافق على الالتزام بهذه الشروط. إذا كنت لا توافق على هذه الشروط، يرجى عدم استخدام التطبيق.</p><ol><li><strong>التسجيل والحساب</strong></li></ol><p>2.1. لاستخدام التطبيق، يجب عليك إنشاء حساب وتقديم معلومات دقيقة.</p><p>2.2. أنت مسؤول عن الحفاظ على سرية اسم المستخدم وكلمة المرور الخاصة بك، وكذلك عن جميع الأنشطة التي تتم عبر حسابك.</p><p>2.3. في حالة الاشتباه في استخدام غير مصرح به لحسابك، يجب عليك إخطار إدارة التطبيق على الفور.</p><ol><li><strong>استخدام التطبيق</strong></li></ol><p>3.1. يمكن للمستخدمين استخدام التطبيق للبحث وحجز السيارات والدراجات النارية التي يعرضها مالكو المركبات.</p><p>3.2. يوفر التطبيق الوصول إلى معلومات عن المركبات، بما في ذلك الصور، والميل الحالي، وسنة الصنع، والعلامة التجارية والطراز، التي يتم تحميلها من قبل مالكي المركبات.</p><p>3.3. يجب على المستخدمين التحقق من جميع المعلومات المقدمة والتواصل مع مالك المركبة للحصول على أي تفاصيل إضافية قبل الحجز.</p><p>3.4. يتعين على المستخدمين الالتزام بجميع شروط الإيجار التي يحددها مالكو المركبات، بما في ذلك مدة الإيجار، والتكلفة، وقواعد استخدام المركبة.</p><p>3.5. يوفر التطبيق تحويل العملة تلقائيًا لتسهيل استخدام المستخدمين، بحيث يمكنهم عرض الأسعار بالعملة التي يفضلونها. ومع ذلك، قد تختلف الأسعار الفعلية بسبب تقلبات أسعار الصرف. يجب على المستخدمين مراعاة أن المبلغ النهائي بعملتهم قد يختلف عن المبلغ المعروض في التطبيق.</p><ol><li><strong>مسائل الدفع</strong></li></ol><p>4.1. لا يتولى التطبيق قبول المدفوعات للإيجار ولا يضمن نزاهة المستأجرين أو مالكي المركبات.</p><p>4.2. يتم التعامل مع جميع الأسئلة المتعلقة بدفع الإيجار والودائع مباشرة بين المستخدم ومالك المركبة.</p><ol><li><strong>التقييمات والتعليقات</strong></li></ol><p>5.1. بعد الانتهاء من الإيجار، يمكن للمستخدمين ومالكي المركبات ترك تقييمات وتعليقات عن بعضهم البعض.</p><p>5.2. يحتفظ التطبيق بالحق في حذف أو تعديل التعليقات التي تحتوي على محتوى غير لائق أو التي تنتهك قواعد المنصة.</p><ol><li><strong>تحديد المسؤولية</strong></li></ol><p>6.1. يوفر التطبيق منصة للتواصل بين مالكي المركبات والمستخدمين، ولكنه لا يتحمل مسؤولية جودة أو أمان أو صحة الإعلانات، ولا عن تصرفات مالكي المركبات أو المستخدمين.</p><p>6.2. لا يتحمل التطبيق مسؤولية الأضرار التي تحدث نتيجة لاستخدام المنصة، بما في ذلك، على سبيل المثال لا الحصر، فقدان البيانات، أو الأرباح، أو الأضرار بالمركبات.</p><ol><li><strong>الخصوصية</strong></li></ol><p>7.1. نحن نحترم خصوصيتك ونلتزم بحماية معلوماتك الشخصية وفقًا لسياسة الخصوصية الخاصة بنا.</p><ol><li><strong>تغييرات في الشروط</strong></li></ol><p>8.1. نحتفظ بالحق في تعديل هذه الشروط في أي وقت. سيتم إشعار المستخدمين بالتعديلات عبر التطبيق.</p><p>8.2. استخدام التطبيق بعد إدخال التعديلات يعني موافقتك على الشروط الجديدة.</p><ol><li><strong>إنهاء الاستخدام</strong></li></ol><p>9.1. نحتفظ بالحق في حظر أو حذف حسابك في حالة انتهاك شروط الاستخدام أو أي قواعد أخرى للتطبيق.</p><h3><strong>سياسة الخصوصية</strong></h3><ol><li><strong>جمع المعلومات</strong></li></ol><p>1.1. نقوم بجمع المعلومات التي تقدمها عند التسجيل، بما في ذلك اسمك، وبيانات الاتصال الخاصة بك، وأي معلومات أخرى ضرورية لاستخدام التطبيق.</p><p>1.2. نقوم أيضًا بجمع المعلومات حول نشاطك في التطبيق، بما في ذلك الحجوزات، والتفاعلات مع المستخدمين، والتعليقات.</p><ol><li><strong>استخدام المعلومات</strong></li></ol><p>2.1. نستخدم معلوماتك لتقديم الخدمات، وتحسين أداء التطبيق، وتقديم تجربة مخصصة.</p><p>2.2. قد نستخدم معلومات الاتصال الخاصة بك لإرسال إشعارات عن الحجوزات، وتغييرات شروط الاستخدام، ومعلومات هامة أخرى.</p><p>2.3. يمكننا anonymize معلوماتك واستخدامها لأغراض تحليلية وتسويقية.</p><ol><li><strong>مشاركة المعلومات</strong></li></ol><p>3.1. نحن لا نشارك معلوماتك الشخصية مع أطراف ثالثة، باستثناء الحالات التي تكون ضرورية لتقديم الخدمات (مثل نقل البيانات إلى مالكي المركبات) أو المطلوبة بموجب القانون.</p><p>3.2. في حالة الشراكة مع أطراف ثالثة، سيتم نقل معلوماتك فقط بموافقتك ووفقًا لسياسة الخصوصية الخاصة بنا.</p><ol><li><strong>الأمان</strong></li></ol><p>4.1. نتخذ جميع التدابير اللازمة لحماية معلوماتك الشخصية من الوصول غير المصرح به، أو الاستخدام، أو الكشف.</p><p>4.2. على الرغم من جهودنا، لا يمكننا ضمان الأمان المطلق للبيانات في حالة حدوث هجمات أو خروقات أمنية.</p><ol><li><strong>الوصول إلى المعلومات وتعديلها</strong></li></ol><p>5.1. لديك الحق في الوصول إلى معلوماتك الشخصية المخزنة في التطبيق، وطلب تعديلها أو حذفها.</p><p>5.2. يمكنك تعديل بيانات الاتصال الخاصة بك والإعدادات الأخرى للخصوصية عبر واجهة التطبيق.</p><ol><li><strong>تغييرات في سياسة الخصوصية</strong></li></ol><p>6.1. نحتفظ بالحق في تعديل سياسة الخصوصية هذه في أي وقت. سيتم إشعار المستخدمين بالتعديلات عبر التطبيق.</p><p>6.2. استخدام التطبيق بعد إدخال التعديلات يعني موافقتك على سياسة الخصوصية الجديدة.</p><ol><li><strong>الاتصال</strong></li></ol><p>7.1. إذا كان لديك أي أسئلة أو تعليقات بشأن سياسة الخصوصية الخاصة بنا، يرجى الاتصال بنا عبر نموذج الاتصال في التطبيق.</p>', '1', 1, '2024-09-06 12:02:26', '2024-09-06 12:02:26');
INSERT INTO `static_pages` (`id`, `name`, `content`, `status`, `module`, `created_at`, `updated_at`) VALUES
(21, 'Terms and conditions to become a lend in arabic', '<h3>شروط الاستخدام لمالكي المركبات</h3><p><strong>قبول الشروط</strong></p><p>1.1. باستخدامك لتطبيقنا، فإنك تقبل الالتزام بهذه الشروط. إذا كنت لا تقبل هذه الشروط، يرجى عدم استخدام التطبيق.</p><p><strong>التسجيل وحساب المستخدم</strong></p><p>2.1. لاستخدام التطبيق، يجب عليك إنشاء حساب وتقديم معلومات صحيحة.</p><p>2.2. تتحمل مسؤولية الحفاظ على سرية معلومات تسجيل الدخول وكلمة المرور الخاصة بك، وأيضًا أي نشاط يتم تحت حسابك.</p><p>2.3. إذا كنت تشك في استخدام حسابك دون إذن، يجب عليك إبلاغ المسؤول عن التطبيق على الفور.</p><p><strong>إدراج المركبات</strong></p><p>3.1. يوافق مالك المركبة على تقديم معلومات دقيقة وحديثة عن المركبة التي يتم عرضها للإيجار.</p><p>3.2. يجب على مالك المركبة تحميل المستندات التي تثبت ملكيته للمركبة المعروضة. إذا قام مالك المركبة بإبرام عقد إيجار مع مالك المركبة الأصلي، فيجب تقديم المستندات المتعلقة بالإيجار الإضافي.</p><p>3.3. يجب على مالك المركبة تحديد السعر والشروط الصحيحة للإيجار، بما في ذلك الرسوم الإضافية المحتملة.</p><p>3.4. يجب على مالك المركبة تقديم صور دقيقة للمركبة، بما في ذلك معلومات عن المسافة الحالية، سنة الصنع، العلامة التجارية، والطراز.</p><p>3.5. إذا تغيرت شروط الإيجار، يجب على مالك المركبة تحديث المعلومات في الإعلان على الفور.</p><p>3.6. يتحمل مالك المركبة مسؤولية حالة المركبة ومدى تطابقها مع الوصف المقدم في الإعلان.</p><p><strong>حل مشاكل الدفع</strong></p><p>4.1. لا يتلقى التطبيق المدفوعات مقابل الإيجار ولا يضمن مصداقية المستأجر أو مالك المركبة.</p><p>4.2. يجب حل جميع مشاكل الدفع، بما في ذلك رسوم الإيجار ووديعة التأمين، مباشرة بين المستأجر ومالك المركبة.</p><p><strong>رسوم الخدمة ورسوم استخدام التطبيق</strong></p><p>5.1. يقدم التطبيق فترة تجريبية مجانية تتراوح بين 1 إلى 3 أشهر للمستخدمين الجدد.</p><p>5.2. بعد فترة التجربة المجانية، سيتم فرض رسوم على استخدام التطبيق وفقًا للخطة التي تم اختيارها.</p><p>5.3. يوافق مالك المركبة على دفع رسوم الاشتراك في التطبيق وفقًا للخطة التي تم اختيارها للاستمرار في استخدام التطبيق.</p><p>5.4. إذا لم يتم دفع رسوم الاشتراك، قد يتم تقييد الوصول إلى ميزات التطبيق.</p><p><strong>التعليقات والتقييمات</strong></p><p>6.1. بعد انتهاء الإيجار، يمكن لكل من المستأجر ومالك المركبة تقديم تعليقات وتقييمات لبعضهما البعض.</p><p>6.2. يحتفظ التطبيق بالحق في حذف أو تعديل التعليقات التي تحتوي على محتوى غير مناسب أو تنتهك قواعد المنصة.</p><p><strong>تحديد المسؤولية</strong></p><p>7.1. يعد التطبيق مجرد منصة تربط بين مالكي المركبات والمستأجرين، ولا يتحمل مسؤولية جودة أو سلامة أو دقة الإعلانات، بما في ذلك تصرفات مالك المركبة أو المستأجر.</p><p>7.2. لا يتحمل التطبيق مسؤولية أي خسائر تحدث نتيجة لاستخدام المنصة، بما في ذلك على سبيل المثال لا الحصر فقدان البيانات أو الأرباح أو الأضرار التي تلحق بالمركبة.</p><p><strong>الخصوصية</strong></p><p>8.1. نحن نحترم خصوصيتك وملتزمون بحماية معلوماتك الشخصية وفقًا لسياسة الخصوصية الخاصة بنا.</p><p><strong>تغيير الشروط</strong></p><p>9.1. نحتفظ بالحق في تعديل شروط الاستخدام هذه في أي وقت. سيتم إخطار المستخدمين بأي تغييرات عبر التطبيق.</p><p>9.2. استخدام التطبيق بشكل مستمر بعد التغييرات يعني أنك تقبل الشروط الجديدة.</p><p><strong>إيقاف الاستخدام</strong></p><p>10.1. نحتفظ بالحق في حظر أو إلغاء حسابك في حالة انتهاك شروط الاستخدام أو قواعد أخرى للتطبيق.</p><h3>سياسة الخصوصية</h3><p><strong>جمع المعلومات</strong></p><p>1.1. نحن نجمع المعلومات التي تقدمها أثناء التسجيل، بما في ذلك اسمك، تفاصيل الاتصال، وأي معلومات أخرى ضرورية لاستخدام التطبيق.</p><p>1.2. نحن أيضًا نجمع معلومات حول نشاطك في التطبيق، بما في ذلك إدراج المركبات، التفاعل مع مستخدمين آخرين، والتعليقات.</p><p><strong>استخدام المعلومات</strong></p><p>2.1. نستخدم معلوماتك لتقديم الخدمات، تحسين أداء التطبيق، وتقديم تجربة مخصصة.</p><p>2.2. قد يتم استخدام معلومات الاتصال الخاصة بك لإرسال إشعارات حول الحجوزات، تغييرات الشروط، ومعلومات هامة أخرى.</p><p>2.3. قد نقوم بجعل معلوماتك مجهولة الهوية واستخدامها لأغراض التحليل والتسويق.</p><p><strong>مشاركة المعلومات</strong></p><p>3.1. لن نشارك معلوماتك الشخصية مع أطراف ثالثة إلا إذا كان ذلك ضروريًا لتقديم الخدمة (مثل مشاركة المعلومات مع المستأجر) أو إذا كان ذلك مطلوبًا قانونيًا.</p><p>3.2. في حالة التعاون مع أطراف ثالثة، سيتم مشاركة معلوماتك بموافقتك ووفقًا لسياسة الخصوصية الخاصة بنا.</p><p><strong>الأمان</strong></p><p>4.1. نحن نتخذ جميع التدابير اللازمة لحماية معلوماتك الشخصية من الوصول أو الاستخدام أو الكشف غير المصرح به.</p><p>4.2. على الرغم من أننا نبذل قصارى جهدنا، لا يمكننا ضمان أمان المعلومات بشكل كامل في حالة حدوث هجمات أو انتهاكات للأمان.</p><p><strong>الوصول إلى المعلومات وتعديلها</strong></p><p>5.1. لديك الحق في الوصول إلى معلوماتك الشخصية المخزنة في التطبيق وطلب تعديلها أو حذفها.</p><p>5.2. يمكنك تعديل تفاصيل الاتصال والإعدادات الأخرى المتعلقة بالخصوصية عبر واجهة التطبيق.</p><p><strong>تعديل سياسة الخصوصية</strong></p><p>6.1. نحتفظ بالحق في تعديل سياسة الخصوصية هذه في أي وقت. سيتم إخطار المستخدمين بأي تغييرات عبر التطبيق.</p><p>6.2. استخدام التطبيق بشكل مستمر بعد التغييرات يعني أنك تقبل سياسة الخصوصية الجديدة.</p><p><strong>اتصل بنا</strong></p><p>7.1. إذا كانت لديك أي أسئلة أو استفسارات بشأن سياسة الخصوصية الخاصة بنا، يرجى الاتصال بنا عبر نموذج الاقتراحات في التطبيق.</p><p>&nbsp;</p><p>&nbsp;</p><p>4o mini</p>', '1', 1, '2024-09-06 12:06:15', '2024-11-02 12:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `thread_id` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thread_status` int NOT NULL DEFAULT '1',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` tinyint(1) NOT NULL DEFAULT '2',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_replies`
--

CREATE TABLE `support_ticket_replies` (
  `id` int NOT NULL,
  `thread_id` int NOT NULL,
  `user_id` int NOT NULL,
  `is_admin_reply` tinyint(1) NOT NULL DEFAULT '0',
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reply_status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `gateway_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `currency_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint UNSIGNED NOT NULL,
  `translatable_id` bigint UNSIGNED NOT NULL,
  `translatable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `translatable_id`, `translatable_type`, `locale`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 2850, 'App\\Models\\Modern\\Item', 'fr', 'title', 'sdf', '2025-07-09 04:59:14', '2025-07-09 04:59:14'),
(2, 2850, 'App\\Models\\Modern\\Item', 'ar', 'title', 'sdfds', '2025-07-09 04:59:14', '2025-07-09 04:59:14'),
(3, 2850, 'App\\Models\\Modern\\Item', 'fr', 'description', 'sdf', '2025-07-09 04:59:14', '2025-07-09 04:59:14'),
(4, 2850, 'App\\Models\\Modern\\Item', 'ar', 'description', 'dsf', '2025-07-09 04:59:14', '2025-07-09 04:59:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(14, 'admin', 'info@sizhitsolutions.com', NULL, '$2y$10$aKRf2KroHhUkFGW.DBd96OBctajjsLUEU9COjPIUoVTfP/wfuKvw.', 'sMkGL17UjSENYs0mXjzT9PwsXdllOvKKYd2nGLXSgxaw6jwYRnVeOBIPUrGn', '2024-09-18 18:31:00', '2025-06-28 12:43:41', NULL),
(18, 'Admin', 'admin@sizhitsolutions.com', NULL, '$2y$10$hBVelpsnTERNJZSLt2/WF.2JS30yKznQaGBwwMAw3Z0J.8Ik977lS', 'PoIb821IJT4BmvRye3b8aCHIIurTqaQVV7bRESRZGnoaY84bl9HsoqifPf61', '2024-09-20 16:45:37', '2024-10-29 15:21:01', NULL),
(19, 'Sizh Admin', 'sizhitsolutions@gmail.com', NULL, '$2y$10$j1cKPYZb34nCpv6DVpD2qORAXkFe4pqr8lfm28tQnoOPnV8KgvkJq', 'I2Cpv8aXAk4JKq4wG5CBGeeMFIP7Jy9PpaZ6jy77RZkJzcs899PU7Cpu34HY', '2024-12-18 11:11:56', '2024-12-18 12:24:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_fuel_type`
--

CREATE TABLE `vehicle_fuel_type` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `module` int DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `vehicle_fuel_type`
--

INSERT INTO `vehicle_fuel_type` (`id`, `name`, `status`, `module`, `created_at`, `updated_at`) VALUES
(1, 'Petrol', 1, 2, '2025-05-02 04:45:20', '2025-05-02 05:01:14'),
(4, 'Diesel', 1, 2, '2025-05-02 05:07:44', '2025-05-02 05:07:44'),
(5, 'Electric', 1, 2, '2025-05-02 05:07:52', '2025-05-02 05:07:52'),
(6, 'Hybrid', 1, 2, '2025-05-02 05:08:00', '2025-05-02 05:08:00'),
(7, 'sada', 0, 2, '2025-06-27 16:08:26', '2025-06-28 15:29:57');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_odometer`
--

CREATE TABLE `vehicle_odometer` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `module` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_wallets`
--

CREATE TABLE `vendor_wallets` (
  `id` bigint UNSIGNED NOT NULL,
  `vendor_id` int NOT NULL,
  `booking_id` bigint UNSIGNED DEFAULT '0',
  `payout_id` bigint UNSIGNED DEFAULT '0',
  `amount` decimal(15,2) NOT NULL,
  `type` enum('credit','debit','refund') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `type` enum('credit','debit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_coupons`
--
ALTER TABLE `add_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `all_packages`
--
ALTER TABLE `all_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_users_email_unique` (`email`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`,`phone_country`),
  ADD KEY `package_fk_8713947` (`package_id`);

--
-- Indexes for table `app_users_bank_accounts`
--
ALTER TABLE `app_users_bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_user_meta`
--
ALTER TABLE `app_user_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`);

--
-- Indexes for table `app_user_otps`
--
ALTER TABLE `app_user_otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `host_id` (`host_id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `itemid` (`itemid`),
  ADD KEY `token` (`token`),
  ADD KEY `check_in` (`check_in`),
  ADD KEY `check_out` (`check_out`);

--
-- Indexes for table `booking_cancellation_policies`
--
ALTER TABLE `booking_cancellation_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_cancellation_reasons`
--
ALTER TABLE `booking_cancellation_reasons`
  ADD PRIMARY KEY (`order_cancellation_id`);

--
-- Indexes for table `booking_extensions`
--
ALTER TABLE `booking_extensions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `booking_finance`
--
ALTER TABLE `booking_finance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `booking_meta`
--
ALTER TABLE `booking_meta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_id` (`booking_id`,`meta_key`);

--
-- Indexes for table `category_type_relation`
--
ALTER TABLE `category_type_relation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_notification_mappings`
--
ALTER TABLE `email_notification_mappings`
  ADD PRIMARY KEY (`email_type_id`,`email_sms_notification_id`,`module`),
  ADD UNIQUE KEY `email_type_id` (`email_type_id`,`email_sms_notification_id`,`module`),
  ADD KEY `email_sms_notification_id` (`email_sms_notification_id`);

--
-- Indexes for table `email_sms_notification`
--
ALTER TABLE `email_sms_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_type`
--
ALTER TABLE `email_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meta_key` (`meta_key`),
  ADD KEY `meta_key_2` (`meta_key`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendorid` (`vendorid`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD KEY `role_id_fk_8655789` (`role_id`),
  ADD KEY `permission_id_fk_8655789` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rental_items`
--
ALTER TABLE `rental_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid_fk_8656820` (`userid_id`),
  ADD KEY `property_type_fk_8657403` (`item_type_id`),
  ADD KEY `place_fk_8657368` (`place_id`),
  ADD KEY `amenities_id` (`features_id`),
  ADD KEY `property_type_id` (`item_type_id`,`subcategory_id`,`category_id`);

--
-- Indexes for table `rental_item_category`
--
ALTER TABLE `rental_item_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_item_dates`
--
ALTER TABLE `rental_item_dates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `property_id` (`item_id`,`date`);

--
-- Indexes for table `rental_item_features`
--
ALTER TABLE `rental_item_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_item_meta`
--
ALTER TABLE `rental_item_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_item_id` (`rental_item_id`);

--
-- Indexes for table `rental_item_rules`
--
ALTER TABLE `rental_item_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_item_subcategory`
--
ALTER TABLE `rental_item_subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `make_id` (`make_id`);

--
-- Indexes for table `rental_item_types`
--
ALTER TABLE `rental_item_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_item_vehicle`
--
ALTER TABLE `rental_item_vehicle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_id` (`item_id`),
  ADD KEY `item_id_2` (`item_id`),
  ADD KEY `fuel_type_id` (`fuel_type_id`),
  ADD KEY `year` (`year`);

--
-- Indexes for table `rental_item_wishlists`
--
ALTER TABLE `rental_item_wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_property_id` (`item_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `user_id_fk_8655798` (`user_id`),
  ADD KEY `role_id_fk_8655798` (`role_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `static_pages`
--
ALTER TABLE `static_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_ticket_replies`
--
ALTER TABLE `support_ticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translations_lookup` (`translatable_id`,`translatable_type`,`locale`,`key`),
  ADD KEY `locale_key_idx` (`locale`,`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicle_fuel_type`
--
ALTER TABLE `vehicle_fuel_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_odometer`
--
ALTER TABLE `vehicle_odometer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_wallets`
--
ALTER TABLE `vendor_wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `payout_id` (`payout_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_coupons`
--
ALTER TABLE `add_coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `all_packages`
--
ALTER TABLE `all_packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_users_bank_accounts`
--
ALTER TABLE `app_users_bank_accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_user_meta`
--
ALTER TABLE `app_user_meta`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_user_otps`
--
ALTER TABLE `app_user_otps`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_cancellation_policies`
--
ALTER TABLE `booking_cancellation_policies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `booking_cancellation_reasons`
--
ALTER TABLE `booking_cancellation_reasons`
  MODIFY `order_cancellation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `booking_extensions`
--
ALTER TABLE `booking_extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_finance`
--
ALTER TABLE `booking_finance`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=588;

--
-- AUTO_INCREMENT for table `booking_meta`
--
ALTER TABLE `booking_meta`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1788;

--
-- AUTO_INCREMENT for table `category_type_relation`
--
ALTER TABLE `category_type_relation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `email_sms_notification`
--
ALTER TABLE `email_sms_notification`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `email_type`
--
ALTER TABLE `email_type`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_items`
--
ALTER TABLE `rental_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_item_category`
--
ALTER TABLE `rental_item_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `rental_item_dates`
--
ALTER TABLE `rental_item_dates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_item_features`
--
ALTER TABLE `rental_item_features`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `rental_item_meta`
--
ALTER TABLE `rental_item_meta`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_item_rules`
--
ALTER TABLE `rental_item_rules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `rental_item_subcategory`
--
ALTER TABLE `rental_item_subcategory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `rental_item_types`
--
ALTER TABLE `rental_item_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `rental_item_vehicle`
--
ALTER TABLE `rental_item_vehicle`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_item_wishlists`
--
ALTER TABLE `rental_item_wishlists`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `static_pages`
--
ALTER TABLE `static_pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_ticket_replies`
--
ALTER TABLE `support_ticket_replies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `vehicle_fuel_type`
--
ALTER TABLE `vehicle_fuel_type`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicle_odometer`
--
ALTER TABLE `vehicle_odometer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `vendor_wallets`
--
ALTER TABLE `vendor_wallets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_users`
--
ALTER TABLE `app_users`
  ADD CONSTRAINT `package_fk_8713947` FOREIGN KEY (`package_id`) REFERENCES `all_packages` (`id`);

--
-- Constraints for table `booking_extensions`
--
ALTER TABLE `booking_extensions`
  ADD CONSTRAINT `booking_extensions_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_finance`
--
ALTER TABLE `booking_finance`
  ADD CONSTRAINT `booking_finance_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_meta`
--
ALTER TABLE `booking_meta`
  ADD CONSTRAINT `booking_meta_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_type_relation`
--
ALTER TABLE `category_type_relation`
  ADD CONSTRAINT `category_type_relation_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `rental_item_category` (`id`),
  ADD CONSTRAINT `category_type_relation_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `rental_item_types` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_id_fk_8655789` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_id_fk_8655789` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rental_item_meta`
--
ALTER TABLE `rental_item_meta`
  ADD CONSTRAINT `rental_item_meta_ibfk_1` FOREIGN KEY (`rental_item_id`) REFERENCES `rental_items` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `rental_item_subcategory`
--
ALTER TABLE `rental_item_subcategory`
  ADD CONSTRAINT `rental_item_subcategory_ibfk_1` FOREIGN KEY (`make_id`) REFERENCES `rental_item_category` (`id`);

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_id_fk_8655798` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_fk_8655798` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
