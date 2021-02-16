-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Фев 15 2021 г., 17:03
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `asrorztg_cms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `addons`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `addons`;
CREATE TABLE `addons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `unique_identifier` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `version` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `activated` int(1) NOT NULL DEFAULT '1',
  `image` varchar(1000) COLLATE utf32_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Дамп данных таблицы `addons`
--

INSERT INTO `addons` (`id`, `name`, `unique_identifier`, `version`, `activated`, `image`, `created_at`, `updated_at`) VALUES
(1, 'affiliate', 'affiliate_system', '1.4', 1, 'affiliate_banner.jpg', '2021-02-08 01:00:36', '2021-02-08 01:00:36'),
(2, 'club_point', 'club_point', '1.2', 1, 'club_points.png', '2021-02-08 01:01:06', '2021-02-08 01:01:06'),
(3, 'Offline Payment', 'offline_payment', '1.3', 1, 'offline_banner.jpg', '2021-02-08 01:01:11', '2021-02-08 01:01:11'),
(4, 'OTP', 'otp_system', '1.4', 1, 'otp_system.jpg', '2021-02-08 01:01:17', '2021-02-08 01:01:17'),
(5, 'Paytm', 'paytm', '1.1', 1, 'paytm.png', '2021-02-08 01:01:29', '2021-02-08 01:01:29'),
(6, 'Point of Sale', 'pos_system', '1.3', 1, 'pos_banner.jpg', '2021-02-08 01:01:48', '2021-02-08 01:01:48'),
(7, 'refund', 'refund_request', '1.1', 1, 'refund_request.png', '2021-02-08 01:01:55', '2021-02-08 01:01:55'),
(8, 'Seller Subscription System', 'seller_subscription', '1.0', 1, 'seller_subscription.jpg', '2021-02-08 01:02:01', '2021-02-08 01:02:01');

-- --------------------------------------------------------

--
-- Структура таблицы `addresses`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 09:36
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `set_default` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address`, `country`, `city`, `postal_code`, `phone`, `set_default`, `created_at`, `updated_at`) VALUES
(1, 10, 'Yunusobod distr. , Zarbuloq str. 1/32', 'Uzbekistan', 'Tashkent', '100058', '+998977808008', 0, '2021-02-12 12:24:24', '2021-02-12 12:24:24');

-- --------------------------------------------------------

--
-- Структура таблицы `affiliate_configs`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `affiliate_configs`;
CREATE TABLE `affiliate_configs` (
  `id` int(11) NOT NULL,
  `type` varchar(1000) COLLATE utf32_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf32_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Дамп данных таблицы `affiliate_configs`
--

INSERT INTO `affiliate_configs` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'verification_form', '[{\"type\":\"text\",\"label\":\"Your name\"},{\"type\":\"text\",\"label\":\"Email\"},{\"type\":\"text\",\"label\":\"Full Address\"},{\"type\":\"text\",\"label\":\"Phone Number\"},{\"type\":\"text\",\"label\":\"How will you affiliate?\"}]', '2020-03-09 09:56:21', '2020-03-09 04:30:59');

-- --------------------------------------------------------

--
-- Структура таблицы `affiliate_options`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `affiliate_options`;
CREATE TABLE `affiliate_options` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `details` longtext COLLATE utf32_unicode_ci,
  `percentage` double NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Дамп данных таблицы `affiliate_options`
--

INSERT INTO `affiliate_options` (`id`, `type`, `details`, `percentage`, `status`, `created_at`, `updated_at`) VALUES
(2, 'user_registration_first_purchase', NULL, 20, 1, '2020-03-03 05:08:37', '2020-03-05 03:56:30'),
(3, 'product_sharing', NULL, 20, 0, '2020-03-08 01:55:03', '2020-03-10 02:12:32'),
(4, 'category_wise_affiliate', NULL, 0, 0, '2020-03-08 01:55:03', '2020-03-10 02:12:32');

-- --------------------------------------------------------

--
-- Структура таблицы `affiliate_payments`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `affiliate_payments`;
CREATE TABLE `affiliate_payments` (
  `id` int(11) NOT NULL,
  `affiliate_user_id` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_details` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `affiliate_payments`
--

INSERT INTO `affiliate_payments` (`id`, `affiliate_user_id`, `amount`, `payment_method`, `payment_details`, `created_at`, `updated_at`) VALUES
(2, 1, 20.00, 'Paypal', NULL, '2020-03-10 02:04:30', '2020-03-10 02:04:30');

-- --------------------------------------------------------

--
-- Структура таблицы `affiliate_users`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `affiliate_users`;
CREATE TABLE `affiliate_users` (
  `id` int(11) NOT NULL,
  `paypal_email` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `bank_information` text COLLATE utf32_unicode_ci,
  `user_id` int(11) NOT NULL,
  `informations` text COLLATE utf32_unicode_ci,
  `balance` double(10,2) NOT NULL DEFAULT '0.00',
  `status` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Дамп данных таблицы `affiliate_users`
--

INSERT INTO `affiliate_users` (`id`, `paypal_email`, `bank_information`, `user_id`, `informations`, `balance`, `status`, `created_at`, `updated_at`) VALUES
(1, 'demo@gmail.com', '123456', 8, '[{\"type\":\"text\",\"label\":\"Your name\",\"value\":\"Nostrum dicta sint l\"},{\"type\":\"text\",\"label\":\"Email\",\"value\":\"Aut perferendis null\"},{\"type\":\"text\",\"label\":\"Full Address\",\"value\":\"Voluptatem Sit dolo\"},{\"type\":\"text\",\"label\":\"Phone Number\",\"value\":\"Ut ad beatae occaeca\"},{\"type\":\"text\",\"label\":\"How will you affiliate?\",\"value\":\"Porro sint soluta u\"}]', 30.00, 1, '2020-03-09 05:35:07', '2020-03-10 02:04:30');

-- --------------------------------------------------------

--
-- Структура таблицы `affiliate_withdraw_requests`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `affiliate_withdraw_requests`;
CREATE TABLE `affiliate_withdraw_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `app_settings`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `app_settings`;
CREATE TABLE `app_settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `currency_format` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_plus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `app_settings`
--

INSERT INTO `app_settings` (`id`, `name`, `logo`, `currency_id`, `currency_format`, `facebook`, `twitter`, `instagram`, `youtube`, `google_plus`, `created_at`, `updated_at`) VALUES
(1, 'Active eCommerce', 'uploads/logo/matggar.png', 1, 'symbol', 'https://facebook.com', 'https://twitter.com', 'https://instagram.com', 'https://youtube.com', 'https://google.com', '2019-08-04 16:39:15', '2019-08-04 16:39:18');

-- --------------------------------------------------------

--
-- Структура таблицы `attributes`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 09:26
--

DROP TABLE IF EXISTS `attributes`;
CREATE TABLE `attributes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf32_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Дамп данных таблицы `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Size', '2020-02-24 05:55:07', '2020-02-24 05:55:07'),
(2, 'Fabric', '2020-02-24 05:55:13', '2020-02-24 05:55:13'),
(3, 'Interfaces', '2021-02-11 09:23:07', '2021-02-13 09:37:28'),
(4, 'Color', '2021-02-11 10:18:19', '2021-02-13 09:36:49'),
(5, 'Storage', '2021-02-15 06:23:38', '2021-02-15 06:23:38'),
(7, 'Camera', '2021-02-15 06:26:04', '2021-02-15 06:26:04');

-- --------------------------------------------------------

--
-- Структура таблицы `attribute_translations`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 09:26
--

DROP TABLE IF EXISTS `attribute_translations`;
CREATE TABLE `attribute_translations` (
  `id` bigint(20) NOT NULL,
  `attribute_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `attribute_translations`
--

INSERT INTO `attribute_translations` (`id`, `attribute_id`, `name`, `lang`, `created_at`, `updated_at`) VALUES
(1, 3, 'Интерфейсы', 'bd', '2021-02-11 09:23:07', '2021-02-11 09:23:07'),
(2, 4, 'Цвет', 'bd', '2021-02-11 10:18:19', '2021-02-11 10:18:19'),
(20, 2, 'Материал', 'ru', '2021-02-13 09:24:43', '2021-02-13 09:24:43'),
(21, 2, 'Мaterial', 'uz', '2021-02-13 09:25:08', '2021-02-13 09:25:08'),
(22, 1, 'Размер', 'ru', '2021-02-13 09:26:04', '2021-02-13 09:26:04'),
(31, 4, 'Color', 'en', '2021-02-13 09:36:49', '2021-02-13 09:36:49'),
(32, 3, 'Interfaces', 'en', '2021-02-13 09:37:28', '2021-02-13 09:37:28'),
(35, 3, 'Interfeyslar', 'uz', '2021-02-13 09:40:38', '2021-02-13 09:40:38'),
(36, 3, 'Интерфейсы', 'ru', '2021-02-13 09:40:53', '2021-02-13 09:40:53'),
(37, 4, 'Цвет', 'ru', '2021-02-13 09:41:36', '2021-02-13 09:41:36'),
(38, 4, 'Rang', 'uz', '2021-02-13 09:41:51', '2021-02-13 09:41:51'),
(44, 1, 'Hajmi', 'uz', '2021-02-13 09:49:57', '2021-02-13 09:49:57'),
(46, 16, 'asd', 'en', '2021-02-15 06:23:38', '2021-02-15 06:23:38'),
(47, 17, 'Camera', 'en', '2021-02-15 06:26:04', '2021-02-15 06:26:04');

-- --------------------------------------------------------

--
-- Структура таблицы `banners`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '1',
  `published` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `banners`
--

INSERT INTO `banners` (`id`, `photo`, `url`, `position`, `published`, `created_at`, `updated_at`) VALUES
(4, 'uploads/banners/banner.jpg', '#', 1, 1, '2019-03-12 05:58:23', '2019-06-11 04:56:50'),
(5, 'uploads/banners/banner.jpg', '#', 1, 1, '2019-03-12 05:58:41', '2019-03-12 05:58:57'),
(6, 'uploads/banners/banner.jpg', '#', 2, 1, '2019-03-12 05:58:52', '2019-03-12 05:58:57'),
(7, 'uploads/banners/banner.jpg', '#', 2, 1, '2019-05-26 05:16:38', '2019-05-26 05:17:34'),
(8, 'uploads/banners/banner.jpg', '#', 2, 1, '2019-06-11 05:00:06', '2019-06-11 05:00:27'),
(9, 'uploads/banners/banner.jpg', '#', 1, 1, '2019-06-11 05:00:15', '2019-06-11 05:00:29'),
(10, 'uploads/banners/banner.jpg', '#', 1, 0, '2019-06-11 05:00:24', '2019-06-11 05:01:56');

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 13 2021 г., 12:20
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `top` int(1) NOT NULL DEFAULT '0',
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`id`, `name`, `logo`, `top`, `slug`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'Apple', 'uploads/brands/brand.jpg', 1, 'демо-бренд-12', 'Demo brand', NULL, '2019-03-12 06:05:56', '2021-02-13 09:20:11'),
(2, 'Android', 'uploads/brands/brand.jpg', 1, 'демо-бренд1', 'Demo brand1', NULL, '2019-03-12 06:06:13', '2021-02-13 09:19:05'),
(3, 'Смартфон Poco X3 NFC 6', '3', 0, '-Poco-X3-NFC-6-sXG2k', NULL, NULL, '2021-02-11 10:41:22', '2021-02-11 10:41:22'),
(4, 'Samsung Galaxy A51', '5', 0, 'Samsung-Galaxy-A51-xlXPa', NULL, NULL, '2021-02-11 10:57:53', '2021-02-11 10:57:53');

-- --------------------------------------------------------

--
-- Структура таблицы `brand_translations`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 13 2021 г., 12:20
--

DROP TABLE IF EXISTS `brand_translations`;
CREATE TABLE `brand_translations` (
  `id` bigint(20) NOT NULL,
  `brand_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `brand_translations`
--

INSERT INTO `brand_translations` (`id`, `brand_id`, `name`, `lang`, `created_at`, `updated_at`) VALUES
(1, 1, 'Apple', 'bd', '2021-02-11 03:12:43', '2021-02-11 03:12:43'),
(2, 2, 'Android', 'bd', '2021-02-11 03:12:52', '2021-02-11 03:12:52'),
(3, 3, 'Смартфон Poco X3 NFC 6', 'bd', '2021-02-11 10:41:22', '2021-02-11 10:41:22'),
(4, 4, 'Samsung Galaxy A51', 'bd', '2021-02-11 10:57:53', '2021-02-11 10:57:53'),
(5, 2, 'Андроид', 'ru', '2021-02-13 09:19:05', '2021-02-13 09:19:05'),
(6, 1, 'Еппл', 'ru', '2021-02-13 09:20:11', '2021-02-13 09:20:11');

-- --------------------------------------------------------

--
-- Структура таблицы `business_settings`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 13 2021 г., 10:34
--

DROP TABLE IF EXISTS `business_settings`;
CREATE TABLE `business_settings` (
  `id` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `business_settings`
--

INSERT INTO `business_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'home_default_currency', '1', '2018-10-16 01:35:52', '2019-01-28 01:26:53'),
(2, 'system_default_currency', '1', '2018-10-16 01:36:58', '2020-01-26 04:22:13'),
(3, 'currency_format', '1', '2018-10-17 03:01:59', '2018-10-17 03:01:59'),
(4, 'symbol_format', '2', '2018-10-17 03:01:59', '2021-02-13 07:34:33'),
(5, 'no_of_decimals', '3', '2018-10-17 03:01:59', '2020-03-04 00:57:16'),
(6, 'product_activation', '1', '2018-10-28 01:38:37', '2019-02-04 01:11:41'),
(7, 'vendor_system_activation', '1', '2018-10-28 07:44:16', '2019-02-04 01:11:38'),
(8, 'show_vendors', '1', '2018-10-28 07:44:47', '2019-02-04 01:11:13'),
(9, 'paypal_payment', '0', '2018-10-28 07:45:16', '2019-01-31 05:09:10'),
(10, 'stripe_payment', '0', '2018-10-28 07:45:47', '2018-11-14 01:51:51'),
(11, 'cash_payment', '1', '2018-10-28 07:46:05', '2019-01-24 03:40:18'),
(12, 'payumoney_payment', '0', '2018-10-28 07:46:27', '2019-03-05 05:41:36'),
(13, 'best_selling', '1', '2018-12-24 08:13:44', '2019-02-14 05:29:13'),
(14, 'paypal_sandbox', '0', '2019-01-16 12:44:18', '2019-01-16 12:44:18'),
(15, 'sslcommerz_sandbox', '1', '2019-01-16 12:44:18', '2019-03-14 00:07:26'),
(16, 'sslcommerz_payment', '0', '2019-01-24 09:39:07', '2019-01-29 06:13:46'),
(17, 'vendor_commission', '20', '2019-01-31 06:18:04', '2019-04-13 06:49:26'),
(18, 'verification_form', '[{\"type\":\"text\",\"label\":\"Your name\"},{\"type\":\"text\",\"label\":\"Shop name\"},{\"type\":\"text\",\"label\":\"Email\"},{\"type\":\"text\",\"label\":\"License No\"},{\"type\":\"text\",\"label\":\"Full Address\"},{\"type\":\"text\",\"label\":\"Phone Number\"},{\"type\":\"file\",\"label\":\"Tax Papers\"}]', '2019-02-03 11:36:58', '2019-02-16 06:14:42'),
(19, 'google_analytics', '0', '2019-02-06 12:22:35', '2019-02-06 12:22:35'),
(20, 'facebook_login', '0', '2019-02-07 12:51:59', '2019-02-08 19:41:15'),
(21, 'google_login', '0', '2019-02-07 12:52:10', '2019-02-08 19:41:14'),
(22, 'twitter_login', '0', '2019-02-07 12:52:20', '2019-02-08 02:32:56'),
(23, 'payumoney_payment', '1', '2019-03-05 11:38:17', '2019-03-05 11:38:17'),
(24, 'payumoney_sandbox', '1', '2019-03-05 11:38:17', '2019-03-05 05:39:18'),
(36, 'facebook_chat', '0', '2019-04-15 11:45:04', '2019-04-15 11:45:04'),
(37, 'email_verification', '0', '2019-04-30 07:30:07', '2019-04-30 07:30:07'),
(38, 'wallet_system', '0', '2019-05-19 08:05:44', '2019-05-19 02:11:57'),
(39, 'coupon_system', '0', '2019-06-11 09:46:18', '2019-06-11 09:46:18'),
(40, 'current_version', '3.9', '2019-06-11 09:46:18', '2019-06-11 09:46:18'),
(41, 'instamojo_payment', '0', '2019-07-06 09:58:03', '2019-07-06 09:58:03'),
(42, 'instamojo_sandbox', '1', '2019-07-06 09:58:43', '2019-07-06 09:58:43'),
(43, 'razorpay', '0', '2019-07-06 09:58:43', '2019-07-06 09:58:43'),
(44, 'paystack', '0', '2019-07-21 13:00:38', '2019-07-21 13:00:38'),
(45, 'pickup_point', '0', '2019-10-17 11:50:39', '2019-10-17 11:50:39'),
(46, 'maintenance_mode', '0', '2019-10-17 11:51:04', '2019-10-17 11:51:04'),
(47, 'voguepay', '0', '2019-10-17 11:51:24', '2019-10-17 11:51:24'),
(48, 'voguepay_sandbox', '0', '2019-10-17 11:51:38', '2019-10-17 11:51:38'),
(50, 'category_wise_commission', '0', '2020-01-21 07:22:47', '2020-01-21 07:22:47'),
(51, 'conversation_system', '1', '2020-01-21 07:23:21', '2020-01-21 07:23:21'),
(52, 'guest_checkout_active', '1', '2020-01-22 07:36:38', '2020-01-22 07:36:38'),
(53, 'facebook_pixel', '0', '2020-01-22 11:43:58', '2020-01-22 11:43:58'),
(55, 'classified_product', '0', '2020-05-13 13:01:05', '2020-05-13 13:01:05'),
(56, 'pos_activation_for_seller', '1', '2020-06-11 09:45:02', '2020-06-11 09:45:02'),
(57, 'shipping_type', 'product_wise_shipping', '2020-07-01 13:49:56', '2020-07-01 13:49:56'),
(58, 'flat_rate_shipping_cost', '0', '2020-07-01 13:49:56', '2020-07-01 13:49:56'),
(59, 'shipping_cost_admin', '0', '2020-07-01 13:49:56', '2020-07-01 13:49:56'),
(60, 'payhere_sandbox', '0', '2020-07-30 18:23:53', '2020-07-30 18:23:53'),
(61, 'payhere', '0', '2020-07-30 18:23:53', '2020-07-30 18:23:53'),
(62, 'google_recaptcha', '0', '2020-08-17 07:13:37', '2020-08-17 07:13:37'),
(63, 'ngenius', '0', '2020-09-22 10:58:21', '2020-09-22 10:58:21'),
(64, 'header_logo', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(65, 'show_language_switcher', 'on', '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(66, 'show_currency_switcher', 'on', '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(67, 'header_stikcy', 'on', '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(68, 'footer_logo', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(69, 'about_us_description', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(70, 'contact_address', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(71, 'contact_phone', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(72, 'contact_email', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(73, 'widget_one_labels', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(74, 'widget_one_links', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(75, 'widget_one', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(76, 'frontend_copyright_text', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(77, 'show_social_links', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(78, 'facebook_link', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(79, 'twitter_link', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(80, 'instagram_link', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(81, 'youtube_link', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(82, 'linkedin_link', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(83, 'payment_method_images', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(84, 'home_slider_images', '[null]', '2020-11-16 07:26:36', '2021-02-11 08:46:13'),
(85, 'home_slider_links', '[null]', '2020-11-16 07:26:36', '2021-02-11 08:46:13'),
(86, 'home_banner1_images', '[\"27\"]', '2020-11-16 07:26:36', '2021-02-12 11:29:40'),
(87, 'home_banner1_links', '[null]', '2020-11-16 07:26:36', '2021-02-11 08:46:17'),
(88, 'home_banner2_images', '[\"27\"]', '2020-11-16 07:26:36', '2021-02-12 11:29:55'),
(89, 'home_banner2_links', '[null]', '2020-11-16 07:26:36', '2021-02-11 08:46:22'),
(90, 'home_categories', '[\"10\"]', '2020-11-16 07:26:36', '2021-02-11 08:46:47'),
(91, 'top10_categories', '[]', '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(92, 'top10_brands', '[]', '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(93, 'website_name', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(94, 'site_motto', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(95, 'site_icon', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(96, 'base_color', '#e62e04', '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(97, 'base_hov_color', '#e62e04', '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(98, 'meta_title', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(99, 'meta_description', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(100, 'meta_keywords', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(101, 'meta_image', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(102, 'site_name', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(103, 'system_logo_white', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(104, 'system_logo_black', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(105, 'timezone', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(106, 'admin_login_background', NULL, '2020-11-16 07:26:36', '2020-11-16 07:26:36'),
(107, 'iyzico_sandbox', '1', '2020-12-30 16:45:56', '2020-12-30 16:45:56'),
(108, 'iyzico', '1', '2020-12-30 16:45:56', '2020-12-30 16:45:56'),
(109, 'decimal_separator', '2', '2020-12-30 16:45:56', '2021-02-13 07:34:33'),
(110, 'nagad', '0', '2021-01-22 10:30:03', '2021-01-22 10:30:03'),
(111, 'bkash', '0', '2021-01-22 10:30:03', '2021-01-22 10:30:03'),
(112, 'bkash_sandbox', '1', '2021-01-22 10:30:03', '2021-01-22 10:30:03'),
(113, 'club_point_convert_rate', '10', '2019-03-12 05:58:23', '2019-03-12 05:58:23'),
(114, 'refund_request_time', '3', '2019-03-12 00:58:23', '2019-03-12 00:58:23'),
(115, 'home_banner_horizontal_images', '[\"9\"]', '2021-02-11 08:46:29', '2021-02-12 11:29:29'),
(116, 'home_banner_horizontal_links', '[null]', '2021-02-11 08:46:29', '2021-02-11 08:46:29'),
(117, 'home_banner_vertical_images', '[null]', '2021-02-11 08:46:35', '2021-02-11 08:46:35'),
(118, 'home_banner_vertical_links', '[null]', '2021-02-11 08:46:35', '2021-02-11 08:46:35'),
(119, 'home_banner3_images', '[null]', '2021-02-11 08:46:54', '2021-02-11 08:46:54'),
(120, 'home_banner3_links', '[null]', '2021-02-11 08:46:54', '2021-02-11 08:46:54'),
(121, 'home_banner_square_images', '[null]', '2021-02-11 08:47:57', '2021-02-11 08:47:57'),
(122, 'home_banner_square_links', '[null]', '2021-02-11 08:47:57', '2021-02-11 08:47:57');

-- --------------------------------------------------------

--
-- Структура таблицы `carts`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `variation` text COLLATE utf8_unicode_ci,
  `price` double(20,2) DEFAULT NULL,
  `tax` double(20,2) DEFAULT NULL,
  `shipping_cost` double(20,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 14:03
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `commision_rate` double(8,2) NOT NULL DEFAULT '0.00',
  `banner` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `featured` int(1) NOT NULL DEFAULT '0',
  `top` int(1) NOT NULL DEFAULT '0',
  `digital` int(1) NOT NULL DEFAULT '0',
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `level`, `name`, `commision_rate`, `banner`, `icon`, `featured`, `top`, `digital`, `slug`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(190, 190, -302604, 'BB, CC and DD creams Facial care', 0.00, NULL, NULL, 0, 0, 0, 'bb-cc--dd--wnf9k', NULL, NULL, '2021-02-14 08:39:18', '2021-02-14 05:39:18'),
(221, 0, 0, 'Beauty and hygiene', 0.00, NULL, NULL, 0, 0, 0, 'beauty-and-hygiene-frt3l', NULL, NULL, '2021-02-15 05:18:50', '2021-02-15 02:18:50'),
(222, 221, 1, 'Perfumery', 0.00, NULL, NULL, 0, 0, 0, 'perfumery-xik29', NULL, NULL, '2021-02-15 06:25:53', '2021-02-15 03:25:53'),
(223, 222, 2, 'Women', 0.00, NULL, NULL, 0, 0, 0, 'women-8qihv', NULL, NULL, '2021-02-15 06:44:39', '2021-02-15 03:44:39'),
(224, 222, 2, 'Mens', 0.00, NULL, NULL, 0, 0, 0, 'mens-e0nwp', NULL, NULL, '2021-02-15 06:15:55', '2021-02-15 03:15:55'),
(225, 222, 2, 'Unisex', 0.00, NULL, NULL, 0, 0, 0, 'unisex-1kgic', NULL, NULL, '2021-02-15 06:47:48', '2021-02-15 03:47:48'),
(226, 222, 2, 'Niche', 0.00, NULL, NULL, 0, 0, 0, 'niche-xn3oy', NULL, NULL, '2021-02-15 06:21:28', '2021-02-15 03:21:28'),
(232, 405, 2, 'For lips', 0.00, NULL, NULL, 0, 0, 0, 'for-lips-ssv1s', NULL, NULL, '2021-02-14 08:38:26', '2021-02-14 05:38:26'),
(235, 405, 2, 'Sets', 0.00, NULL, NULL, 0, 0, 0, 'sets-6zow3', NULL, NULL, '2021-02-14 08:28:48', '2021-02-14 05:28:48'),
(236, 405, 2, 'Removing makeup', 0.00, NULL, NULL, 0, 0, 0, 'removing-makeup-qyym1', NULL, NULL, '2021-02-14 08:32:30', '2021-02-14 05:32:30'),
(238, 405, 2, 'Pharmacy cosmetics', 0.00, NULL, NULL, 0, 0, 0, 'pharmacy-cosmetics-tveoz', NULL, NULL, '2021-02-14 08:33:59', '2021-02-14 05:33:59'),
(240, 405, 2, 'Professional makeup', 0.00, NULL, NULL, 0, 0, 0, 'professional-makeup-uftfw', NULL, NULL, '2021-02-14 08:35:39', '2021-02-14 05:35:39'),
(241, 221, 1, 'Face care', 0.00, NULL, NULL, 0, 0, 0, 'face-care-gxcg4', NULL, NULL, '2021-02-15 05:49:02', '2021-02-15 02:49:02'),
(242, 241, 2, 'Cleansing and makeup removal', 0.00, NULL, NULL, 0, 0, 0, 'cleansing-and-makeup-removal-bpcma', NULL, NULL, '2021-02-15 05:26:56', '2021-02-15 02:26:56'),
(243, 241, 2, 'Toning', 0.00, NULL, NULL, 0, 0, 0, 'toning-oxslf', NULL, NULL, '2021-02-15 06:41:30', '2021-02-15 03:41:30'),
(244, 241, 2, 'Creams and serums', 0.00, NULL, NULL, 0, 0, 0, 'creams-and-serums-wd3yz', NULL, NULL, '2021-02-15 05:37:42', '2021-02-15 02:37:42'),
(245, 241, 2, 'Caring for the skin around the eyes', 0.00, NULL, NULL, 0, 0, 0, 'caring-for-the-skin-around-the-eyes-yd3gn', NULL, NULL, '2021-02-15 05:26:16', '2021-02-15 02:26:16'),
(246, 241, 2, 'Masks', 0.00, NULL, NULL, 0, 0, 0, 'masks-oqvau', NULL, NULL, '2021-02-15 06:14:52', '2021-02-15 03:14:52'),
(247, 241, 2, 'Scrubs and peels', 0.00, NULL, NULL, 0, 0, 0, 'scrubs-and-peels-bzacd', NULL, NULL, '2021-02-15 06:29:29', '2021-02-15 03:29:29'),
(250, 241, 2, 'Night care', 0.00, NULL, NULL, 0, 0, 0, 'night-care-kh7as', NULL, NULL, '2021-02-15 06:22:00', '2021-02-15 03:22:00'),
(251, 241, 2, 'Anti-aging cosmetics', 0.00, NULL, NULL, 0, 0, 0, 'anti-aging-cosmetics-niilq', NULL, NULL, '2021-02-15 05:15:15', '2021-02-15 02:15:15'),
(252, 241, 2, 'Problem skin', 0.00, NULL, NULL, 0, 0, 0, 'problem-skin-fmngy', NULL, NULL, '2021-02-15 06:27:03', '2021-02-15 03:27:03'),
(253, 241, 2, 'Sun protection', 0.00, NULL, NULL, 0, 0, 0, 'sun-protection-gcyle', NULL, NULL, '2021-02-15 06:36:15', '2021-02-15 03:36:15'),
(254, 241, 2, 'Facial care devices', 0.00, NULL, NULL, 0, 0, 0, 'facial-care-devices-igi0n', NULL, NULL, '2021-02-15 05:50:17', '2021-02-15 02:50:17'),
(256, 241, 2, 'Travel vials', 0.00, NULL, NULL, 0, 0, 0, 'travel-vials-dxgq7', NULL, NULL, '2021-02-15 06:43:27', '2021-02-15 03:43:27'),
(257, 241, 2, 'Natural cosmetic', 0.00, NULL, NULL, 0, 0, 0, 'natural-cosmetic-7uhlk', NULL, NULL, '2021-02-15 06:19:17', '2021-02-15 03:19:17'),
(386, 222, 2, 'Luxury', 0.00, NULL, NULL, 0, 0, 0, 'luxury-rxnin', NULL, NULL, '2021-02-15 06:12:35', '2021-02-15 03:12:35'),
(389, 222, 2, 'Gift sets', 0.00, NULL, NULL, 0, 0, 0, 'gift-sets-siyb0', NULL, NULL, '2021-02-15 06:03:41', '2021-02-15 03:03:41'),
(405, 221, 1, 'Makeup', 0.00, NULL, NULL, 0, 0, 0, 'makeup-2nrmb', NULL, NULL, '2021-02-15 06:13:45', '2021-02-15 03:13:45'),
(411, 405, 2, 'For face', 0.00, NULL, NULL, 0, 0, 0, 'for-face-vzotl', NULL, NULL, '2021-02-15 05:57:45', '2021-02-15 02:57:45'),
(418, 405, 2, 'For eyes', 0.00, NULL, NULL, 0, 0, 0, 'for-eyes-qexhd', NULL, NULL, '2021-02-15 05:57:09', '2021-02-15 02:57:09'),
(419, 405, 2, 'For eyebrows', 0.00, NULL, NULL, 0, 0, 0, 'for-eyebrows-vfgdb', NULL, NULL, '2021-02-15 05:56:24', '2021-02-15 02:56:24'),
(420, 405, 2, 'Accessories', 0.00, NULL, NULL, 0, 0, 0, 'accessories-nruxt', NULL, NULL, '2021-02-15 04:57:12', '2021-02-15 01:57:12'),
(421, 405, 2, 'Natural cosmetic', 0.00, NULL, NULL, 0, 0, 0, 'natural-cosmetic-5n3yy', NULL, NULL, '2021-02-15 06:19:50', '2021-02-15 03:19:50'),
(422, 241, 2, 'Lip care', 0.00, NULL, NULL, 0, 0, 0, 'lip-care-v5bp9', NULL, NULL, '2021-02-15 06:11:24', '2021-02-15 03:11:24'),
(423, 241, 2, 'BB, CC and DD creams', 0.00, NULL, NULL, 0, 0, 0, 'bb-cc-and-dd-creams-sjjo4', NULL, NULL, '2021-02-15 05:17:38', '2021-02-15 02:17:38'),
(424, 241, 2, 'Sets', 0.00, NULL, NULL, 0, 0, 0, 'sets-ij5yt', NULL, NULL, '2021-02-15 06:30:07', '2021-02-15 03:30:07'),
(425, 241, 2, 'Travel vials', 0.00, NULL, NULL, 0, 0, 0, 'travel-vials-e5ckw', NULL, NULL, '2021-02-15 06:45:52', '2021-02-15 03:45:52'),
(426, 405, 2, 'Natural cosmetic', 0.00, NULL, NULL, 0, 0, 0, 'natural-cosmetic-esfsz', NULL, NULL, '2021-02-15 06:20:23', '2021-02-15 03:20:23'),
(427, 241, 2, 'Natural cosmetic', 0.00, NULL, NULL, 0, 0, 0, 'natural-cosmetic-n43kp', NULL, NULL, '2021-02-15 06:20:46', '2021-02-15 03:20:46'),
(428, 221, 1, 'Hair care', 0.00, NULL, NULL, 0, 0, 0, 'hair-care-qvt7f', NULL, NULL, '2021-02-15 06:05:01', '2021-02-15 03:05:01'),
(429, 428, 2, 'Shampoos', 0.00, NULL, NULL, 0, 0, 0, 'shampoos-femuu', NULL, NULL, '2021-02-15 06:31:28', '2021-02-15 03:31:28'),
(430, 428, 2, 'Balms and rinses', 0.00, NULL, NULL, 0, 0, 0, 'balms-and-rinses-dctfi', NULL, NULL, '2021-02-15 05:16:25', '2021-02-15 02:16:25'),
(431, 428, 2, 'Dry shampoos', 0.00, NULL, NULL, 0, 0, 0, 'dry-shampoos-ieve8', NULL, NULL, '2021-02-15 05:42:37', '2021-02-15 02:42:37'),
(432, 428, 2, 'Masks and serums', 0.00, NULL, NULL, 0, 0, 0, 'masks-and-serums-94kdf', NULL, NULL, '2021-02-15 06:15:20', '2021-02-15 03:15:20'),
(433, 428, 2, 'Coloration', 0.00, NULL, NULL, 0, 0, 0, 'coloration-mikst', NULL, NULL, '2021-02-15 05:27:32', '2021-02-15 02:27:32'),
(434, 428, 2, 'Styling and styling', 0.00, NULL, NULL, 0, 0, 0, 'styling-and-styling-fzvm4', NULL, NULL, '2021-02-15 06:35:39', '2021-02-15 03:35:39'),
(435, 428, 2, 'Combs and brushes', 0.00, NULL, NULL, 0, 0, 0, 'combs-and-brushes-hec1i', NULL, NULL, '2021-02-15 05:28:53', '2021-02-15 02:28:53'),
(436, 428, 2, 'Cutting and styling devices', 0.00, NULL, NULL, 0, 0, 0, 'cutting-and-styling-devices-wzcgb', NULL, NULL, '2021-02-15 05:39:20', '2021-02-15 02:39:20'),
(437, 221, 1, 'Body care', 0.00, NULL, NULL, 0, 0, 0, 'body-care-e1aeb', NULL, NULL, '2021-02-15 05:23:42', '2021-02-15 02:23:42'),
(438, 437, 2, 'Creams and lotions', 0.00, NULL, NULL, 0, 0, 0, 'creams-and-lotions-rmei8', NULL, NULL, '2021-02-15 05:34:23', '2021-02-15 02:34:23'),
(439, 437, 2, 'Deodorants for women', 0.00, NULL, NULL, 0, 0, 0, 'deodorants-for-women-esstz', NULL, NULL, '2021-02-15 05:41:29', '2021-02-15 02:41:29'),
(440, 437, 2, 'Deodorants for men', 0.00, NULL, NULL, 0, 0, 0, 'deodorants-for-men-chhtg', NULL, NULL, '2021-02-15 05:40:40', '2021-02-15 02:40:40'),
(441, 437, 2, 'Depilation', 0.00, NULL, NULL, 0, 0, 0, 'depilation-nlq31', NULL, NULL, '2021-02-15 05:42:05', '2021-02-15 02:42:05'),
(442, 437, 2, 'Anti-cellulite and modeling products', 0.00, NULL, NULL, 0, 0, 0, 'anti-cellulite-and-modeling-products-5pn9j', NULL, NULL, '2021-02-15 05:15:50', '2021-02-15 02:15:50'),
(443, 437, 2, 'Skin care during pregnancy', 0.00, NULL, NULL, 0, 0, 0, 'skin-care-during-pregnancy-fueis', NULL, NULL, '2021-02-15 06:33:59', '2021-02-15 03:33:59'),
(444, 437, 2, 'Tanning and sun protection', 0.00, NULL, NULL, 0, 0, 0, 'tanning-and-sun-protection-ksu5r', NULL, NULL, '2021-02-15 06:38:03', '2021-02-15 03:38:03'),
(445, 437, 2, 'For legs', 0.00, NULL, NULL, 0, 0, 0, 'for-legs-ks1xw', NULL, NULL, '2021-02-15 06:00:48', '2021-02-15 03:00:48'),
(446, 437, 2, 'For hands', 0.00, NULL, NULL, 0, 0, 0, 'for-hands-rrnjr', NULL, NULL, '2021-02-15 06:00:11', '2021-02-15 03:00:11'),
(447, 437, 2, 'For shower', 0.00, NULL, NULL, 0, 0, 0, 'for-shower-us9dz', NULL, NULL, '2021-02-15 06:03:09', '2021-02-15 03:03:09'),
(448, 437, 2, 'Foam, salt, oil', 0.00, NULL, NULL, 0, 0, 0, 'foam-salt-oil-q0uar', NULL, NULL, '2021-02-15 05:53:31', '2021-02-15 02:53:31'),
(449, 437, 2, 'Soap', 0.00, NULL, NULL, 0, 0, 0, 'soap-gvsux', NULL, NULL, '2021-02-15 06:34:30', '2021-02-15 03:34:30'),
(450, 437, 2, 'Body care devices', 0.00, NULL, NULL, 0, 0, 0, 'body-care-devices-y37hm', NULL, NULL, '2021-02-15 05:21:11', '2021-02-15 02:21:11'),
(451, 437, 2, 'Washcloths and brushes', 0.00, NULL, NULL, 0, 0, 0, 'washcloths-and-brushes-mhmof', NULL, NULL, '2021-02-15 06:46:51', '2021-02-15 03:46:51'),
(452, 437, 2, 'Аксессуары', 0.00, NULL, NULL, 0, 0, 0, 'accessories-pgy3u', NULL, NULL, '2021-02-15 05:07:44', '2021-02-15 02:07:44'),
(453, 437, 2, 'Women\'s razors and blades', 0.00, NULL, NULL, 0, 0, 0, 'womens-razors-and-blades-nuxfl', NULL, NULL, '2021-02-15 06:44:07', '2021-02-15 03:44:07'),
(454, 437, 2, 'Essential oils and accessories', 0.00, NULL, NULL, 0, 0, 0, 'essential-oils-and-accessories-z9lk7', NULL, NULL, '2021-02-15 05:45:35', '2021-02-15 02:45:35'),
(455, 221, 1, 'Men', 0.00, NULL, NULL, 0, 0, 0, 'men-gysbc', NULL, NULL, '2021-02-14 08:58:25', '2021-02-14 05:58:25'),
(456, 455, 2, 'Razors and blades', 0.00, NULL, NULL, 0, 0, 0, 'razors-and-blades-fwkta', NULL, NULL, '2021-02-15 06:28:19', '2021-02-15 03:28:19'),
(457, 455, 2, 'Shavers', 0.00, NULL, NULL, 0, 0, 0, 'shavers-swqtt', NULL, NULL, '2021-02-15 06:32:01', '2021-02-15 03:32:01'),
(458, 455, 2, 'Shaving products', 0.00, NULL, NULL, 0, 0, 0, 'shaving-products-oc92g', NULL, NULL, '2021-02-15 06:32:52', '2021-02-15 03:32:52'),
(459, 455, 2, 'Care for beard and mustache', 0.00, NULL, NULL, 0, 0, 0, 'care-for-beard-and-mustache-emfjj', NULL, NULL, '2021-02-15 05:25:42', '2021-02-15 02:25:42'),
(460, 224, 3, 'Accessories for beard and mustache', 0.00, NULL, NULL, 0, 0, 0, 'accessories-for-beard-and-mustache-ur8xk', NULL, NULL, '2021-02-15 05:10:41', '2021-02-15 02:10:41'),
(461, 455, 2, 'Face care', 0.00, NULL, NULL, 0, 0, 0, 'face-care-8rfe6', NULL, NULL, '2021-02-15 05:48:30', '2021-02-15 02:48:30'),
(462, 455, 2, 'For hair', 0.00, NULL, NULL, 0, 0, 0, 'for-hair-d9wub', NULL, NULL, '2021-02-15 05:58:16', '2021-02-15 02:58:16'),
(463, 455, 2, 'Shower products', 0.00, NULL, NULL, 0, 0, 0, 'shower-products-y7p4s', NULL, NULL, '2021-02-15 06:33:31', '2021-02-15 03:33:31'),
(464, 455, 2, 'Deodorants', 0.00, NULL, NULL, 0, 0, 0, 'deodorants-fsvh1', NULL, NULL, '2021-02-15 05:39:51', '2021-02-15 02:39:51'),
(465, 455, 2, 'Perfumery', 0.00, NULL, NULL, 0, 0, 0, 'perfumery-ggexu', NULL, NULL, '2021-02-15 06:25:28', '2021-02-15 03:25:28'),
(466, 455, 2, 'Sets', 0.00, NULL, NULL, 0, 0, 0, 'sets-1b4cs', NULL, NULL, '2021-02-15 06:30:29', '2021-02-15 03:30:29'),
(467, 221, 1, 'Beauty Technique', 0.00, NULL, NULL, 0, 0, 0, 'beauty-technique-esmlg', NULL, NULL, '2021-02-15 05:22:22', '2021-02-15 02:22:22'),
(468, 467, 2, 'Hair dryers and hair dryers', 0.00, NULL, NULL, 0, 0, 0, 'hair-dryers-and-hair-dryers-dijmf', NULL, NULL, '2021-02-15 06:05:47', '2021-02-15 03:05:47'),
(469, 467, 2, 'Tongs, curling irons and straighteners', 0.00, NULL, NULL, 0, 0, 0, 'tongs-curling-irons-and-straighteners-ruogq', NULL, NULL, '2021-02-15 06:41:02', '2021-02-15 03:41:02'),
(470, 467, 2, 'Electric curlers', 0.00, NULL, NULL, 0, 0, 0, 'electric-curlers-ojfcc', NULL, NULL, '2021-02-15 05:43:09', '2021-02-15 02:43:09'),
(471, 467, 2, 'Epilators', 0.00, NULL, NULL, 0, 0, 0, 'epilators-dzt7e', NULL, NULL, '2021-02-15 05:44:29', '2021-02-15 02:44:29'),
(472, 467, 2, 'Shavers', 0.00, NULL, NULL, 0, 0, 0, 'shavers-5mb7i', NULL, NULL, '2021-02-15 06:32:24', '2021-02-15 03:32:24'),
(473, 467, 2, 'Oral care', 0.00, NULL, NULL, 0, 0, 0, 'oral-care-yqqcg', NULL, NULL, '2021-02-15 06:22:34', '2021-02-15 03:22:34'),
(474, 467, 2, 'Electric face brushes', 0.00, NULL, NULL, 0, 0, 0, 'electric-face-brushes-ehxxo', NULL, NULL, '2021-02-15 05:43:51', '2021-02-15 02:43:51'),
(475, 467, 2, 'Facial care devices', 0.00, NULL, NULL, 0, 0, 0, 'facial-care-devices-0wvhs', NULL, NULL, '2021-02-15 05:49:46', '2021-02-15 02:49:46'),
(476, 467, 2, 'Body care devices', 0.00, NULL, NULL, 0, 0, 0, 'body-care-devices-ng0go', NULL, NULL, '2021-02-15 05:24:20', '2021-02-15 02:24:20'),
(477, 467, 2, 'Voskoplav and paraffin baths', 0.00, NULL, NULL, 0, 0, 0, 'voskoplav-and-paraffin-baths-ritbk', NULL, NULL, '2021-02-15 06:48:54', '2021-02-15 03:48:54'),
(478, 467, 2, 'Accessories for electric shavers and epilators', 0.00, NULL, NULL, 0, 0, 0, 'accessories-for-electric-shavers-and-epilators-jmita', NULL, NULL, '2021-02-15 05:14:16', '2021-02-15 02:14:16'),
(479, 221, 1, 'Tools and accessories', 0.00, NULL, NULL, 0, 0, 0, 'tools-and-accessories-6pqdc', NULL, NULL, '2021-02-15 06:42:31', '2021-02-15 03:42:31'),
(480, 479, 2, 'Makeup brushes, sponges', 0.00, NULL, NULL, 0, 0, 0, 'makeup-brushes-sponges-ugewg', NULL, NULL, '2021-02-15 06:14:24', '2021-02-15 03:14:24'),
(481, 479, 2, 'Cosmetic mirrors', 0.00, NULL, NULL, 0, 0, 0, 'cosmetic-mirrors-pcs07', NULL, NULL, '2021-02-15 05:29:27', '2021-02-15 02:29:27'),
(482, 479, 2, 'Cosmetic tweezers', 0.00, NULL, NULL, 0, 0, 0, 'cosmetic-tweezers-odhpj', NULL, NULL, '2021-02-15 05:30:01', '2021-02-15 02:30:01'),
(483, 479, 2, 'Little things for makeup', 0.00, NULL, NULL, 0, 0, 0, 'little-things-for-makeup-jpbnp', NULL, NULL, '2021-02-15 06:11:57', '2021-02-15 03:11:57'),
(484, 479, 2, 'Eyelashes and glue', 0.00, NULL, NULL, 0, 0, 0, 'eyelashes-and-glue-hgqjj', NULL, NULL, '2021-02-15 05:47:45', '2021-02-15 02:47:45'),
(485, 479, 2, 'Eyelash Clips & Combs', 0.00, NULL, NULL, 0, 0, 0, 'eyelash-clips--combs-t3yhi', NULL, NULL, '2021-02-15 05:47:09', '2021-02-15 02:47:09'),
(486, 479, 2, 'Hair brushes and accessories', 0.00, NULL, NULL, 0, 0, 0, 'hair-brushes-and-accessories-toqiw', NULL, NULL, '2021-02-15 06:04:20', '2021-02-15 03:04:20'),
(487, 479, 2, 'Combs & Hair Accessories', 0.00, NULL, NULL, 0, 0, 0, 'combs--hair-accessories-kfbxj', NULL, NULL, '2021-02-15 05:28:02', '2021-02-15 02:28:02'),
(488, 479, 2, 'Facial Rollers', 0.00, NULL, NULL, 0, 0, 0, 'facial-rollers-4qvyt', NULL, NULL, '2021-02-15 05:50:52', '2021-02-15 02:50:52'),
(489, 479, 2, 'Body Rollers', 0.00, NULL, NULL, 0, 0, 0, 'body-rollers-mhhni', NULL, NULL, '2021-02-15 05:24:56', '2021-02-15 02:24:56'),
(490, 479, 2, 'For manicure and pedicure', 0.00, NULL, NULL, 0, 0, 0, 'for-manicure-and-pedicure-npui8', NULL, NULL, '2021-02-15 06:01:54', '2021-02-15 03:01:54'),
(491, 479, 2, 'Magnifying lamps', 0.00, NULL, NULL, 0, 0, 0, 'magnifying-lamps-4ox7a', NULL, NULL, '2021-02-15 06:13:10', '2021-02-15 03:13:10'),
(492, 479, 2, 'For hairdresser', 0.00, NULL, NULL, 0, 0, 0, 'for-hairdresser-3catb', NULL, NULL, '2021-02-15 05:58:46', '2021-02-15 02:58:46'),
(493, 479, 2, 'Curlers', 0.00, NULL, NULL, 0, 0, 0, 'curlers-tkd5y', NULL, NULL, '2021-02-15 05:38:20', '2021-02-15 02:38:20'),
(494, 479, 2, 'For cosmetologists and masseurs', 0.00, NULL, NULL, 0, 0, 0, 'for-cosmetologists-and-masseurs-b9iri', NULL, NULL, '2021-02-15 05:55:37', '2021-02-15 02:55:37'),
(495, 221, 1, 'Nail care', 0.00, NULL, NULL, 0, 0, 0, 'nail-care-plqtf', NULL, NULL, '2021-02-15 06:16:29', '2021-02-15 03:16:29'),
(496, 495, 2, 'Tools and devices for manicure and pedicure', 0.00, NULL, NULL, 0, 0, 0, 'tools-and-devices-for-manicure-and-pedicure-ovxz8', NULL, NULL, '2021-02-15 06:42:59', '2021-02-15 03:42:59'),
(497, 495, 2, 'Nail coloring', 0.00, NULL, NULL, 0, 0, 0, 'nail-coloring-0v6km', NULL, NULL, '2021-02-15 06:17:49', '2021-02-15 03:17:49'),
(498, 495, 2, 'Nail care', 0.00, NULL, NULL, 0, 0, 0, 'nail-care-bqvcp', NULL, NULL, '2021-02-15 06:17:14', '2021-02-15 03:17:14'),
(499, 495, 2, 'Hand care', 0.00, NULL, NULL, 0, 0, 0, 'hand-care-qc85b', NULL, NULL, '2021-02-15 06:06:30', '2021-02-15 03:06:30'),
(500, 495, 2, 'Feet care', 0.00, NULL, NULL, 0, 0, 0, 'feet-care-ohip5', NULL, NULL, '2021-02-15 05:51:29', '2021-02-15 02:51:29'),
(501, 495, 2, 'Extension of nails', 0.00, NULL, NULL, 0, 0, 0, 'extension-of-nails-jz1yu', NULL, NULL, '2021-02-15 05:46:13', '2021-02-15 02:46:13'),
(502, 495, 2, 'Nail design', 0.00, NULL, NULL, 0, 0, 0, 'nail-design-lwxnx', NULL, NULL, '2021-02-15 06:18:34', '2021-02-15 03:18:34'),
(503, 221, 1, 'For beauty salons', 0.00, NULL, NULL, 0, 0, 0, 'for-beauty-salons-vq1dc', NULL, NULL, '2021-02-15 05:54:12', '2021-02-15 02:54:12'),
(504, 503, 2, 'For manicure and pedicure', 0.00, NULL, NULL, 0, 0, 0, 'for-manicure-and-pedicure-9olsq', NULL, NULL, '2021-02-15 06:02:23', '2021-02-15 03:02:23'),
(505, 503, 2, 'For hairdressers and barbers', 0.00, NULL, NULL, 0, 0, 0, 'for-hairdressers-and-barbers-cts9y', NULL, NULL, '2021-02-15 05:59:31', '2021-02-15 02:59:31'),
(506, 503, 2, 'For cosmetologists', 0.00, NULL, NULL, 0, 0, 0, 'for-cosmetologists-nyw7c', NULL, NULL, '2021-02-15 05:55:03', '2021-02-15 02:55:03'),
(507, 503, 2, 'Sterilization', 0.00, NULL, NULL, 0, 0, 0, 'sterilization-kntdu', NULL, NULL, '2021-02-15 06:35:06', '2021-02-15 03:35:06'),
(508, 503, 2, 'Tattoo equipment', 0.00, NULL, NULL, 0, 0, 0, 'tattoo-equipment-xmhge', NULL, NULL, '2021-02-15 06:38:30', '2021-02-15 03:38:30'),
(509, 503, 2, 'Tattoo Supplies', 0.00, NULL, NULL, 0, 0, 0, 'tattoo-supplies-nqxvb', NULL, NULL, '2021-02-15 06:38:58', '2021-02-15 03:38:58'),
(510, 503, 2, 'Supplies and equipment for tattooing', 0.00, NULL, NULL, 0, 0, 0, 'supplies-and-equipment-for-tattooing-jzc4w', NULL, NULL, '2021-02-15 06:36:49', '2021-02-15 03:36:49'),
(511, 503, 2, 'Supplies and equipment for tattooing', 0.00, NULL, NULL, 0, 0, 0, 'supplies-and-equipment-for-tattooing-4il0w', NULL, NULL, '2021-02-15 06:37:30', '2021-02-15 03:37:30'),
(512, 503, 2, 'Henna and stencils for mehendi', 0.00, NULL, NULL, 0, 0, 0, 'henna-and-stencils-for-mehendi-gn2ys', NULL, NULL, '2021-02-15 06:07:26', '2021-02-15 03:07:26'),
(513, 503, 2, 'Beauty cases', 0.00, NULL, NULL, 0, 0, 0, 'beauty-cases-scx5l', NULL, NULL, '2021-02-15 05:19:24', '2021-02-15 02:19:24'),
(514, 221, 1, 'Toilet paper and wadding', 0.00, NULL, NULL, 0, 0, 0, 'toilet-paper-and-wadding-lv2jw', NULL, NULL, '2021-02-15 06:40:26', '2021-02-15 03:40:26'),
(515, 514, 2, 'Toilet paper and towels', 0.00, NULL, NULL, 0, 0, 0, 'toilet-paper-and-towels-mulqe', NULL, NULL, '2021-02-15 06:39:50', '2021-02-15 03:39:50'),
(516, 514, 2, 'Wet wipes', 0.00, NULL, NULL, 0, 0, 0, 'wet-wipes-sdqio', NULL, NULL, '2021-02-15 06:45:26', '2021-02-15 03:45:26'),
(517, 514, 2, 'Paper napkins', 0.00, NULL, NULL, 0, 0, 0, 'paper-napkins-n2vmj', NULL, NULL, '2021-02-15 06:24:58', '2021-02-15 03:24:58'),
(518, 514, 2, 'Cotton buds and discs', 0.00, NULL, NULL, 0, 0, 0, 'cotton-buds-and-discs-n5frx', NULL, NULL, '2021-02-15 05:30:34', '2021-02-15 02:30:34'),
(519, 221, 1, 'Feminine hygiene', 0.00, NULL, NULL, 0, 0, 0, 'feminine-hygiene-wlehp', NULL, NULL, '2021-02-15 05:52:56', '2021-02-15 02:52:56'),
(520, 519, 2, 'Pads and tampons', 0.00, NULL, NULL, 0, 0, 0, 'pads-and-tampons-mydbm', NULL, NULL, '2021-02-15 06:24:30', '2021-02-15 03:24:30'),
(521, 519, 2, 'Товары для интимной гигиены', 0.00, NULL, NULL, 0, 0, 0, 'intimate-hygiene-products-8teyt', NULL, NULL, '2021-02-15 06:07:54', '2021-02-15 03:07:54'),
(522, 519, 2, 'Urological pads', 0.00, NULL, NULL, 0, 0, 0, 'urological-pads-mkobp', NULL, NULL, '2021-02-15 06:48:16', '2021-02-15 03:48:16'),
(523, 519, 2, 'Liners for clothes', 0.00, NULL, NULL, 0, 0, 0, 'liners-for-clothes-xui8c', NULL, NULL, '2021-02-15 06:10:54', '2021-02-15 03:10:54'),
(531, 0, 0, 'Товары для дома и сада', 0.00, NULL, NULL, 0, 0, 0, '-----UH31l', NULL, NULL, '2021-02-15 04:28:49', '2021-02-15 04:28:49'),
(532, 531, 1, 'Посуда', 0.00, NULL, NULL, 0, 0, 0, '-zzD8R', NULL, NULL, '2021-02-15 04:29:44', '2021-02-15 04:29:44'),
(533, 532, 2, 'Посуда для приготовления', 0.00, NULL, NULL, 0, 0, 0, '---MgSKV', NULL, NULL, '2021-02-15 04:32:03', '2021-02-15 04:32:03'),
(534, 532, 2, 'Столовые приборы', 0.00, NULL, NULL, 0, 0, 0, '--Wk7Yn', NULL, NULL, '2021-02-15 06:36:04', '2021-02-15 06:36:04'),
(535, 532, 2, 'Детская посуда', 0.00, NULL, NULL, 0, 0, 0, '--DAC5v', NULL, NULL, '2021-02-15 06:36:52', '2021-02-15 06:36:52'),
(536, 563, 1, 'Садовая мебель', 0.00, NULL, NULL, 0, 0, 0, '--qmlwo', NULL, NULL, '2021-02-15 11:45:27', '2021-02-15 08:45:27'),
(537, 532, 2, 'Чайники и кофейники', 0.00, NULL, NULL, 0, 0, 0, '---lGBeP', NULL, NULL, '2021-02-15 06:38:29', '2021-02-15 06:38:29'),
(538, 532, 2, 'Бар', 0.00, NULL, NULL, 0, 0, 0, '-0fX6o', NULL, NULL, '2021-02-15 06:38:45', '2021-02-15 06:38:45'),
(539, 532, 2, 'Хранение продуктов', 0.00, NULL, NULL, 0, 0, 0, '--Sy48r', NULL, NULL, '2021-02-15 06:39:00', '2021-02-15 06:39:00'),
(540, 532, 2, 'Термосы и термокружки', 0.00, NULL, NULL, 0, 0, 0, '---NyXXb', NULL, NULL, '2021-02-15 06:39:18', '2021-02-15 06:39:18'),
(542, 532, 2, 'Одноразовая посуда', 0.00, NULL, NULL, 0, 0, 0, '--IE58C', NULL, NULL, '2021-02-15 06:41:39', '2021-02-15 06:41:39'),
(543, 532, 2, 'Товары для консервирования', 0.00, NULL, NULL, 0, 0, 0, '---Z7Y9W', NULL, NULL, '2021-02-15 06:42:05', '2021-02-15 06:42:05'),
(544, 532, 2, 'Ножи и разделочные доски', 0.00, NULL, NULL, 0, 0, 0, '----z9uof', NULL, NULL, '2021-02-15 06:42:20', '2021-02-15 06:42:20'),
(545, 532, 2, 'Кухонные принадлежности', 0.00, NULL, NULL, 0, 0, 0, '--1OL8q', NULL, NULL, '2021-02-15 06:42:31', '2021-02-15 06:42:31'),
(546, 532, 2, 'Кухонный текстиль', 0.00, NULL, NULL, 0, 0, 0, '--kbFOn', NULL, NULL, '2021-02-15 06:42:47', '2021-02-15 06:42:47'),
(547, 532, 2, 'Фильтры для воды', 0.00, NULL, NULL, 0, 0, 0, '---Vx59b', NULL, NULL, '2021-02-15 06:43:07', '2021-02-15 06:43:07'),
(548, 532, 2, 'Декоративная посуда', 0.00, NULL, NULL, 0, 0, 0, '--mOSMk', NULL, NULL, '2021-02-15 06:43:21', '2021-02-15 06:43:21'),
(549, 531, 1, 'Текстиль', 0.00, NULL, NULL, 0, 0, 0, '-cJTYV', NULL, NULL, '2021-02-15 06:44:12', '2021-02-15 06:44:12'),
(550, 549, 2, 'Шторы и карнизы', 0.00, NULL, NULL, 0, 0, 0, '---ugt9Q', NULL, NULL, '2021-02-15 06:45:43', '2021-02-15 06:45:43'),
(551, 549, 2, 'Постельное белье', 0.00, NULL, NULL, 0, 0, 0, '--ySWZI', NULL, NULL, '2021-02-15 06:45:56', '2021-02-15 06:45:56'),
(552, 549, 2, 'Одеяла', 0.00, NULL, NULL, 0, 0, 0, '-6V9fT', NULL, NULL, '2021-02-15 06:46:10', '2021-02-15 06:46:10'),
(553, 549, 2, 'Подушки', 0.00, NULL, NULL, 0, 0, 0, '-CIMOW', NULL, NULL, '2021-02-15 06:46:26', '2021-02-15 06:46:26'),
(554, 549, 2, 'Пледы и покрывала', 0.00, NULL, NULL, 0, 0, 0, '---ViyDt', NULL, NULL, '2021-02-15 06:46:36', '2021-02-15 06:46:36'),
(555, 549, 2, 'Полотенца', 0.00, NULL, NULL, 0, 0, 0, '-A02RW', NULL, NULL, '2021-02-15 06:46:49', '2021-02-15 06:46:49'),
(556, 549, 2, 'Кухонный текстиль', 0.00, NULL, NULL, 0, 0, 0, '--akQYv', NULL, NULL, '2021-02-15 06:47:02', '2021-02-15 06:47:02'),
(557, 549, 2, 'Наматрасники и чехлы для матрасов', 0.00, NULL, NULL, 0, 0, 0, '-----LedLa', NULL, NULL, '2021-02-15 06:47:13', '2021-02-15 06:47:13'),
(558, 549, 2, 'Текстиль с электроподогревом', 0.00, NULL, NULL, 0, 0, 0, '---wGR5a', NULL, NULL, '2021-02-15 06:47:24', '2021-02-15 06:47:24'),
(559, 549, 2, 'Чехлы для мебели', 0.00, NULL, NULL, 0, 0, 0, '---rzEmc', NULL, NULL, '2021-02-15 06:47:33', '2021-02-15 06:47:33'),
(560, 549, 2, 'Чехлы для мебели', 0.00, NULL, NULL, 0, 0, 0, '---coY1k', NULL, NULL, '2021-02-15 06:48:41', '2021-02-15 06:48:41'),
(561, 549, 2, 'Ковры и ковровые дорожки', 0.00, NULL, NULL, 0, 0, 0, '----X5rji', NULL, NULL, '2021-02-15 06:49:03', '2021-02-15 06:49:03'),
(562, 549, 2, 'Ткани', 0.00, NULL, NULL, 0, 0, 0, '-BzRv4', NULL, NULL, '2021-02-15 06:49:17', '2021-02-15 06:49:17'),
(563, 0, 0, 'Мебель и аксессуары', 0.00, NULL, NULL, 0, 0, 0, '---xEbbT', NULL, NULL, '2021-02-15 06:49:26', '2021-02-15 06:49:26'),
(564, 563, 1, 'Мягкая мебель', 0.00, NULL, NULL, 0, 0, 0, '--t2qT7', NULL, NULL, '2021-02-15 06:49:47', '2021-02-15 06:49:47'),
(565, 531, 1, 'Дача и сад', 0.00, NULL, NULL, 0, 0, 0, '---Yv6N3', NULL, NULL, '2021-02-15 06:49:53', '2021-02-15 06:49:53'),
(566, 565, 2, 'Отдых и пикник', 0.00, NULL, NULL, 0, 0, 0, '---ux6ux', NULL, NULL, '2021-02-15 06:50:11', '2021-02-15 06:50:11'),
(567, 564, 2, 'Кресла-мешки', 0.00, NULL, NULL, 0, 0, 0, '--Ai83u', NULL, NULL, '2021-02-15 06:50:11', '2021-02-15 06:50:11'),
(568, 565, 2, 'Садовый инструмент', 0.00, NULL, NULL, 0, 0, 0, '--EwnzX', NULL, NULL, '2021-02-15 06:51:06', '2021-02-15 06:51:06'),
(569, 565, 2, 'Садовая техника', 0.00, NULL, NULL, 0, 0, 0, '--G0ZdZ', NULL, NULL, '2021-02-15 06:51:19', '2021-02-15 06:51:19'),
(570, 564, 2, 'Компьютерные кресла', 0.00, NULL, NULL, 0, 0, 0, '--Tv0wl', NULL, NULL, '2021-02-15 06:51:23', '2021-02-15 06:51:23'),
(571, 565, 2, 'Насосы для дачи', 0.00, NULL, NULL, 0, 0, 0, '---idDRZ', NULL, NULL, '2021-02-15 06:51:31', '2021-02-15 06:51:31'),
(572, 565, 2, 'Садовый декор', 0.00, NULL, NULL, 0, 0, 0, '--iMmsJ', NULL, NULL, '2021-02-15 06:51:44', '2021-02-15 06:51:44'),
(573, 565, 2, 'Биотуалеты и септики', 0.00, NULL, NULL, 0, 0, 0, '---9KABu', NULL, NULL, '2021-02-15 06:51:56', '2021-02-15 06:51:56'),
(574, 564, 2, 'Кресла', 0.00, NULL, NULL, 0, 0, 0, '-4m77h', NULL, NULL, '2021-02-15 06:52:08', '2021-02-15 06:52:08'),
(575, 565, 2, 'Души и рукомойники', 0.00, NULL, NULL, 0, 0, 0, '---L0Ljc', NULL, NULL, '2021-02-15 06:52:15', '2021-02-15 06:52:15'),
(576, 564, 2, 'Пуфики и банкетки', 0.00, NULL, NULL, 0, 0, 0, '---Ww8gK', NULL, NULL, '2021-02-15 06:52:28', '2021-02-15 06:52:28'),
(577, 565, 2, 'Парники и теплицы', 0.00, NULL, NULL, 0, 0, 0, '---n7j7e', NULL, NULL, '2021-02-15 06:52:29', '2021-02-15 06:52:29'),
(578, 565, 2, 'Бассейны для дачи', 0.00, NULL, NULL, 0, 0, 0, '---OBAcW', NULL, NULL, '2021-02-15 06:52:42', '2021-02-15 06:52:42'),
(579, 564, 2, 'Кровати и матрасы', 0.00, NULL, NULL, 0, 0, 0, '---aVukC', NULL, NULL, '2021-02-15 06:52:56', '2021-02-15 06:52:56'),
(580, 565, 2, 'Водоотвод и дренаж', 0.00, NULL, NULL, 0, 0, 0, '---9jEfi', NULL, NULL, '2021-02-15 06:52:57', '2021-02-15 06:52:57'),
(581, 565, 2, 'Уборка снега', 0.00, NULL, NULL, 0, 0, 0, '--m1Viw', NULL, NULL, '2021-02-15 06:53:19', '2021-02-15 06:53:19'),
(582, 564, 2, 'Диваны', 0.00, NULL, NULL, 0, 0, 0, '-iRAmp', NULL, NULL, '2021-02-15 06:53:21', '2021-02-15 06:53:21'),
(583, 565, 2, 'Хозблоки и сараи', 0.00, NULL, NULL, 0, 0, 0, '---9VGDK', NULL, NULL, '2021-02-15 06:53:33', '2021-02-15 06:53:33'),
(584, 565, 2, 'Заборы и ограждения', 0.00, NULL, NULL, 0, 0, 0, '---1Hlwp', NULL, NULL, '2021-02-15 06:53:45', '2021-02-15 06:53:45'),
(585, 564, 2, 'Раскладушки', 0.00, NULL, NULL, 0, 0, 0, '-rjjFR', NULL, NULL, '2021-02-15 06:53:48', '2021-02-15 06:53:48'),
(586, 531, 1, 'Декор и интерьер', 0.00, NULL, NULL, 0, 0, 0, '---JbXU7', NULL, NULL, '2021-02-15 06:54:16', '2021-02-15 06:54:16'),
(587, 586, 2, 'Шторы и портьеры', 0.00, NULL, NULL, 0, 0, 0, '---ObEjd', NULL, NULL, '2021-02-15 06:54:58', '2021-02-15 06:54:58'),
(588, 564, 2, 'Комплекты мягкой мебели', 0.00, NULL, NULL, 0, 0, 0, '---gHsaq', NULL, NULL, '2021-02-15 06:55:00', '2021-02-15 06:55:00'),
(589, 586, 2, 'Фоторамки и фотоальбомы', 0.00, NULL, NULL, 0, 0, 0, '---3HfER', NULL, NULL, '2021-02-15 06:55:12', '2021-02-15 06:55:12'),
(590, 586, 2, 'Ароматы для дома', 0.00, NULL, NULL, 0, 0, 0, '---0xY2n', NULL, NULL, '2021-02-15 06:55:33', '2021-02-15 06:55:33'),
(591, 586, 2, 'Оформление интерьера', 0.00, NULL, NULL, 0, 0, 0, '--GkrqU', NULL, NULL, '2021-02-15 06:55:48', '2021-02-15 06:55:48'),
(592, 586, 2, 'Держатели, подставки и подносы', 0.00, NULL, NULL, 0, 0, 0, '----7SxWV', NULL, NULL, '2021-02-15 06:56:02', '2021-02-15 06:56:02'),
(593, 563, 1, 'Столы и стулья', 0.00, NULL, NULL, 0, 0, 0, '---1nePo', NULL, NULL, '2021-02-15 06:56:14', '2021-02-15 06:56:14'),
(594, 586, 2, 'Зеркала', 0.00, NULL, NULL, 0, 0, 0, '-ymBEX', NULL, NULL, '2021-02-15 06:56:17', '2021-02-15 06:56:17'),
(595, 586, 2, 'Иконы', 0.00, NULL, NULL, 0, 0, 0, '-D0Yqx', NULL, NULL, '2021-02-15 06:56:33', '2021-02-15 06:56:33'),
(596, 593, 2, 'Компьютерные и письменные столы', 0.00, NULL, NULL, 0, 0, 0, '----lv1Si', NULL, NULL, '2021-02-15 06:56:44', '2021-02-15 06:56:44'),
(597, 586, 2, 'Картины и панно', 0.00, NULL, NULL, 0, 0, 0, '---fbcsC', NULL, NULL, '2021-02-15 06:56:49', '2021-02-15 06:56:49'),
(598, 586, 2, 'Ковры и ковровые дорожки', 0.00, NULL, NULL, 0, 0, 0, '----Kcfo0', NULL, NULL, '2021-02-15 06:57:04', '2021-02-15 06:57:04'),
(599, 593, 2, 'Столы и столики', 0.00, NULL, NULL, 0, 0, 0, '---9Qyii', NULL, NULL, '2021-02-15 06:57:17', '2021-02-15 06:57:17'),
(600, 586, 2, 'Копилки', 0.00, NULL, NULL, 0, 0, 0, '-Lj1pw', NULL, NULL, '2021-02-15 06:57:18', '2021-02-15 06:57:18'),
(601, 586, 2, 'Свечи и подсвечники', 0.00, NULL, NULL, 0, 0, 0, '---zpvN2', NULL, NULL, '2021-02-15 06:57:30', '2021-02-15 06:57:30'),
(602, 586, 2, 'Сувениры и подарки', 0.00, NULL, NULL, 0, 0, 0, '---NMaGC', NULL, NULL, '2021-02-15 06:57:43', '2021-02-15 06:57:43'),
(603, 593, 2, 'Стулья, табуретки', 0.00, NULL, NULL, 0, 0, 0, '--YtLyP', NULL, NULL, '2021-02-15 06:57:50', '2021-02-15 06:57:50'),
(604, 586, 2, 'Таблички, номера и крючки', 0.00, NULL, NULL, 0, 0, 0, '----Hlgki', NULL, NULL, '2021-02-15 06:57:56', '2021-02-15 06:57:56'),
(605, 593, 2, 'Барные стулья', 0.00, NULL, NULL, 0, 0, 0, '--N4nNe', NULL, NULL, '2021-02-15 06:58:15', '2021-02-15 06:58:15'),
(606, 586, 2, 'Часы и метеостанции', 0.00, NULL, NULL, 0, 0, 0, '---wonIj', NULL, NULL, '2021-02-15 06:58:16', '2021-02-15 06:58:16'),
(607, 586, 2, 'Ритуальные товары', 0.00, NULL, NULL, 0, 0, 0, '--AsR1H', NULL, NULL, '2021-02-15 06:58:33', '2021-02-15 06:58:33'),
(608, 593, 2, 'Журнальные столы', 0.00, NULL, NULL, 0, 0, 0, '--wKama', NULL, NULL, '2021-02-15 06:58:38', '2021-02-15 06:58:38'),
(609, 531, 1, 'Хозяйственные товары', 0.00, NULL, NULL, 0, 0, 0, '--Ylcid', NULL, NULL, '2021-02-15 06:58:57', '2021-02-15 06:58:57'),
(610, 593, 2, 'Банкетки и скамьи', 0.00, NULL, NULL, 0, 0, 0, '---HSP7Q', NULL, NULL, '2021-02-15 06:59:14', '2021-02-15 06:59:14'),
(611, 609, 2, 'Бумажная продукция для дома', 0.00, NULL, NULL, 0, 0, 0, '----DTrgz', NULL, NULL, '2021-02-15 06:59:20', '2021-02-15 06:59:20'),
(612, 609, 2, 'Инвентарь для уборки', 0.00, NULL, NULL, 0, 0, 0, '---WPq1a', NULL, NULL, '2021-02-15 06:59:34', '2021-02-15 06:59:34'),
(613, 593, 2, 'Туалетные столики и консоли', 0.00, NULL, NULL, 0, 0, 0, '----nDsJc', NULL, NULL, '2021-02-15 06:59:39', '2021-02-15 06:59:39'),
(614, 609, 2, 'Мусорные ведра и баки', 0.00, NULL, NULL, 0, 0, 0, '----1vGwG', NULL, NULL, '2021-02-15 06:59:47', '2021-02-15 06:59:47'),
(615, 593, 2, 'Подставки под ноги', 0.00, NULL, NULL, 0, 0, 0, '---SLWqm', NULL, NULL, '2021-02-15 07:00:00', '2021-02-15 07:00:00'),
(616, 609, 2, 'Аксессуары для стирки', 0.00, NULL, NULL, 0, 0, 0, '---dofvg', NULL, NULL, '2021-02-15 07:00:00', '2021-02-15 07:00:00'),
(617, 609, 2, 'Уход за одеждой и обувью', 0.00, NULL, NULL, 0, 0, 0, '-----G0G7Z', NULL, NULL, '2021-02-15 07:00:14', '2021-02-15 07:00:14'),
(618, 593, 2, 'Надстройки', 0.00, NULL, NULL, 0, 0, 0, '-jWg8m', NULL, NULL, '2021-02-15 07:00:23', '2021-02-15 07:00:23'),
(619, 609, 2, 'Аксессуары для ванной', 0.00, NULL, NULL, 0, 0, 0, '---TiTe4', NULL, NULL, '2021-02-15 07:00:26', '2021-02-15 07:00:26'),
(620, 609, 2, 'Безмены', 0.00, NULL, NULL, 0, 0, 0, '-Al5zG', NULL, NULL, '2021-02-15 07:00:41', '2021-02-15 07:00:41'),
(621, 609, 2, 'Сумки хозяйственные', 0.00, NULL, NULL, 0, 0, 0, '--WSIQ4', NULL, NULL, '2021-02-15 07:00:55', '2021-02-15 07:00:55'),
(622, 609, 2, 'Сумки-тележки', 0.00, NULL, NULL, 0, 0, 0, '--iV7gy', NULL, NULL, '2021-02-15 07:01:19', '2021-02-15 07:01:19'),
(623, 609, 2, 'Лестницы', 0.00, NULL, NULL, 0, 0, 0, '-wiChC', NULL, NULL, '2021-02-15 07:01:37', '2021-02-15 07:01:37'),
(624, 563, 1, 'Шкафы, тумбы и комоды', 0.00, NULL, NULL, 0, 0, 0, '----uWvbm', NULL, NULL, '2021-02-15 07:01:40', '2021-02-15 07:01:40'),
(625, 609, 2, 'Упаковка и переезд', 0.00, NULL, NULL, 0, 0, 0, '---qfUB8', NULL, NULL, '2021-02-15 07:01:53', '2021-02-15 07:01:53'),
(626, 624, 2, 'Вешалки в прихожую', 0.00, NULL, NULL, 0, 0, 0, '---scxGI', NULL, NULL, '2021-02-15 07:02:17', '2021-02-15 07:02:17'),
(627, 531, 1, 'Хранение вещей', 0.00, NULL, NULL, 0, 0, 0, '--LsZPW', NULL, NULL, '2021-02-15 07:02:28', '2021-02-15 07:02:28'),
(628, 627, 2, 'Вешалки', 0.00, NULL, NULL, 0, 0, 0, '-IMbmA', NULL, NULL, '2021-02-15 07:02:50', '2021-02-15 07:02:50'),
(629, 624, 2, 'Прихожие готовый комплект', 0.00, NULL, NULL, 0, 0, 0, '---HTwMM', NULL, NULL, '2021-02-15 07:02:56', '2021-02-15 07:02:56'),
(630, 624, 2, 'Гостиные готовый комплект', 0.00, NULL, NULL, 0, 0, 0, '---iJ1l3', NULL, NULL, '2021-02-15 07:03:23', '2021-02-15 07:03:23'),
(631, 624, 2, 'Гардеробы', 0.00, NULL, NULL, 0, 0, 0, '-TrfOY', NULL, NULL, '2021-02-15 07:04:09', '2021-02-15 07:04:09'),
(632, 624, 2, 'Комоды', 0.00, NULL, NULL, 0, 0, 0, '-nRsxp', NULL, NULL, '2021-02-15 07:04:26', '2021-02-15 07:04:26'),
(633, 624, 2, 'Обувницы', 0.00, NULL, NULL, 0, 0, 0, '-AD6uu', NULL, NULL, '2021-02-15 07:05:19', '2021-02-15 07:05:19'),
(634, 627, 2, 'Вакуумные пакеты', 0.00, NULL, NULL, 0, 0, 0, '--AfqJ3', NULL, NULL, '2021-02-15 07:08:45', '2021-02-15 07:08:45'),
(635, 627, 2, 'Чехлы для одежды', 0.00, NULL, NULL, 0, 0, 0, '---WyuhA', NULL, NULL, '2021-02-15 07:10:59', '2021-02-15 07:10:59'),
(636, 627, 2, 'Чехлы для обуви', 0.00, NULL, NULL, 0, 0, 0, '---VZLbL', NULL, NULL, '2021-02-15 08:02:05', '2021-02-15 08:02:05'),
(637, 627, 2, 'Коробки и контейнеры', 0.00, NULL, NULL, 0, 0, 0, '---Qntck', NULL, NULL, '2021-02-15 08:03:29', '2021-02-15 08:03:29'),
(638, 627, 2, 'Баки для белья', 0.00, NULL, NULL, 0, 0, 0, '---t57if', NULL, NULL, '2021-02-15 08:03:59', '2021-02-15 08:03:59'),
(639, 627, 2, 'Органайзеры и разделители', 0.00, NULL, NULL, 0, 0, 0, '---cJqxB', NULL, NULL, '2021-02-15 08:04:50', '2021-02-15 08:04:50'),
(640, 627, 2, 'Подставки для зонтов', 0.00, NULL, NULL, 0, 0, 0, '---E5cPl', NULL, NULL, '2021-02-15 08:05:41', '2021-02-15 08:05:41'),
(641, 531, 1, 'Освещение', 0.00, NULL, NULL, 0, 0, 0, '-7XTyd', NULL, NULL, '2021-02-15 08:06:09', '2021-02-15 08:06:09'),
(642, 641, 2, 'Ночники', 0.00, NULL, NULL, 0, 0, 0, '-0pGXK', NULL, NULL, '2021-02-15 08:06:36', '2021-02-15 08:06:36'),
(643, 641, 2, 'Ночники', 0.00, NULL, NULL, 0, 0, 0, '-aGDjd', NULL, NULL, '2021-02-15 08:06:47', '2021-02-15 08:06:47'),
(644, 641, 2, 'Интерьерная подсветка', 0.00, NULL, NULL, 0, 0, 0, '--fUsbw', NULL, NULL, '2021-02-15 08:07:20', '2021-02-15 08:07:20'),
(645, 641, 2, 'Торшеры и напольные светильники', 0.00, NULL, NULL, 0, 0, 0, '----qrHac', NULL, NULL, '2021-02-15 08:08:03', '2021-02-15 08:08:03'),
(646, 624, 2, 'Стойки ресепшн', 0.00, NULL, NULL, 0, 0, 0, '--aEqGX', NULL, NULL, '2021-02-15 08:08:06', '2021-02-15 08:08:06'),
(647, 624, 2, 'Тумбы', 0.00, NULL, NULL, 0, 0, 0, '-dThDl', NULL, NULL, '2021-02-15 08:08:30', '2021-02-15 08:08:30'),
(648, 641, 2, 'Настенные светильники', 0.00, NULL, NULL, 0, 0, 0, '--r1N2Q', NULL, NULL, '2021-02-15 08:08:34', '2021-02-15 08:08:34'),
(649, 641, 2, 'Люстры и потолочные светильники', 0.00, NULL, NULL, 0, 0, 0, '----ay8CF', NULL, NULL, '2021-02-15 08:08:57', '2021-02-15 08:08:57'),
(650, 624, 2, 'Шкафы', 0.00, NULL, NULL, 0, 0, 0, '-hEFae', NULL, NULL, '2021-02-15 08:09:03', '2021-02-15 08:09:03'),
(651, 624, 2, 'Шкафы складные', 0.00, NULL, NULL, 0, 0, 0, '--x2LVL', NULL, NULL, '2021-02-15 08:09:30', '2021-02-15 08:09:30'),
(652, 641, 2, 'Настенно-потолочные светильники', 0.00, NULL, NULL, 0, 0, 0, '---j0Xly', NULL, NULL, '2021-02-15 08:09:33', '2021-02-15 08:09:33'),
(653, 641, 2, 'Настенные светильники', 0.00, NULL, NULL, 0, 0, 0, '--cgC4T', NULL, NULL, '2021-02-15 08:10:03', '2021-02-15 08:10:03'),
(654, 641, 2, 'Напольные и настольные светильники', 0.00, NULL, NULL, 0, 0, 0, '----0pL3q', NULL, NULL, '2021-02-15 08:10:27', '2021-02-15 08:10:27'),
(655, 641, 2, 'Лампочки', 0.00, NULL, NULL, 0, 0, 0, '-JkWcM', NULL, NULL, '2021-02-15 08:11:00', '2021-02-15 08:11:00'),
(656, 641, 2, 'Встраиваемые светильники', 0.00, NULL, NULL, 0, 0, 0, '--kYMDJ', NULL, NULL, '2021-02-15 08:11:41', '2021-02-15 08:11:41'),
(657, 563, 1, 'Полки и стеллажи', 0.00, NULL, NULL, 0, 0, 0, '---pB63y', NULL, NULL, '2021-02-15 08:11:44', '2021-02-15 08:11:44'),
(658, 657, 2, 'Полки', 0.00, NULL, NULL, 0, 0, 0, '-JM95k', NULL, NULL, '2021-02-15 08:12:25', '2021-02-15 08:12:25'),
(659, 641, 2, 'Споты и трек-системы', 0.00, NULL, NULL, 0, 0, 0, '----wC79o', NULL, NULL, '2021-02-15 08:12:30', '2021-02-15 08:12:30'),
(660, 657, 2, 'Стеллажи', 0.00, NULL, NULL, 0, 0, 0, '-hQ7Lq', NULL, NULL, '2021-02-15 08:12:58', '2021-02-15 08:12:58'),
(661, 641, 2, 'Уличное освещение и прожекторы', 0.00, NULL, NULL, 0, 0, 0, '----LmrU2', NULL, NULL, '2021-02-15 08:13:00', '2021-02-15 08:13:00'),
(662, 657, 2, 'Этажерки', 0.00, NULL, NULL, 0, 0, 0, '-cGIgU', NULL, NULL, '2021-02-15 08:13:20', '2021-02-15 08:13:20'),
(663, 641, 2, 'Управление освещением', 0.00, NULL, NULL, 0, 0, 0, '--K5ZaD', NULL, NULL, '2021-02-15 08:13:30', '2021-02-15 08:13:30'),
(664, 657, 2, 'Слингополки', 0.00, NULL, NULL, 0, 0, 0, '-3Z33C', NULL, NULL, '2021-02-15 08:13:51', '2021-02-15 08:13:51'),
(665, 641, 2, 'Технические светильники', 0.00, NULL, NULL, 0, 0, 0, '--G8RXD', NULL, NULL, '2021-02-15 08:14:02', '2021-02-15 08:14:02'),
(666, 641, 2, 'Комплектующие и аксессуары для светильников', 0.00, NULL, NULL, 0, 0, 0, '-----5rDbJ', NULL, NULL, '2021-02-15 08:34:36', '2021-02-15 08:34:36'),
(667, 641, 2, 'Розетки, выключатели и рамки', 0.00, NULL, NULL, 0, 0, 0, '----UBmsp', NULL, NULL, '2021-02-15 08:34:58', '2021-02-15 08:34:58'),
(668, 641, 2, 'Розетки, выключатели и рамки', 0.00, NULL, NULL, 0, 0, 0, '----b431E', NULL, NULL, '2021-02-15 08:35:01', '2021-02-15 08:35:01'),
(669, 641, 2, 'Споты и трековые светильники', 0.00, NULL, NULL, 0, 0, 0, '----9uJcZ', NULL, NULL, '2021-02-15 08:35:30', '2021-02-15 08:35:30'),
(670, 641, 2, 'Аксессуары для освещения', 0.00, NULL, NULL, 0, 0, 0, '---8IkAO', NULL, NULL, '2021-02-15 08:35:54', '2021-02-15 08:35:54'),
(671, 641, 2, 'Светильники для сауны', 0.00, NULL, NULL, 0, 0, 0, '---HyVt0', NULL, NULL, '2021-02-15 08:36:14', '2021-02-15 08:36:14'),
(672, 641, 2, 'Аварийные светильники', 0.00, NULL, NULL, 0, 0, 0, '--BYm1S', NULL, NULL, '2021-02-15 08:36:34', '2021-02-15 08:36:34'),
(673, 641, 2, 'Светодиодные ленты', 0.00, NULL, NULL, 0, 0, 0, '--g0E9G', NULL, NULL, '2021-02-15 08:36:56', '2021-02-15 08:36:56'),
(674, 531, 1, 'Авторские товары ручной работы', 0.00, NULL, NULL, 0, 0, 0, '----Gattw', NULL, NULL, '2021-02-15 08:37:54', '2021-02-15 08:37:54'),
(675, 674, 2, 'Статуэтки', 0.00, NULL, NULL, 0, 0, 0, '-oLBUe', NULL, NULL, '2021-02-15 08:38:37', '2021-02-15 08:38:37'),
(676, 674, 2, 'Вазы', 0.00, NULL, NULL, 0, 0, 0, '-XDRas', NULL, NULL, '2021-02-15 08:41:34', '2021-02-15 08:41:34'),
(677, 0, 0, 'Спорт и активный отдых', 0.00, NULL, NULL, 0, 0, 0, '----y8mf4', NULL, NULL, '2021-02-15 08:42:30', '2021-02-15 08:42:30'),
(678, 674, 2, 'Картины', 0.00, NULL, NULL, 0, 0, 0, '-yyz1w', NULL, NULL, '2021-02-15 08:42:36', '2021-02-15 08:42:36'),
(679, 677, 1, 'Спортивное питание', 0.00, NULL, NULL, 0, 0, 0, '--QrIlV', NULL, NULL, '2021-02-15 08:42:55', '2021-02-15 08:42:55'),
(680, 679, 2, 'Протеины', 0.00, NULL, NULL, 0, 0, 0, '-PeLvm', NULL, NULL, '2021-02-15 08:43:11', '2021-02-15 08:43:11'),
(681, 679, 2, 'Витамины и минералы', 0.00, NULL, NULL, 0, 0, 0, '---zq2Uh', NULL, NULL, '2021-02-15 08:43:28', '2021-02-15 08:43:28'),
(682, 674, 2, 'Открытки', 0.00, NULL, NULL, 0, 0, 0, '-G93xu', NULL, NULL, '2021-02-15 08:43:29', '2021-02-15 08:43:29'),
(683, 679, 2, 'Аминокислоты и BCAA', 0.00, NULL, NULL, 0, 0, 0, '--BCAA-McYYO', NULL, NULL, '2021-02-15 08:43:48', '2021-02-15 08:43:48'),
(684, 674, 2, 'Украшения', 0.00, NULL, NULL, 0, 0, 0, '-jaAlg', NULL, NULL, '2021-02-15 08:43:55', '2021-02-15 08:43:55'),
(685, 679, 2, 'Протеиновые батончики', 0.00, NULL, NULL, 0, 0, 0, '--kj7DP', NULL, NULL, '2021-02-15 08:44:04', '2021-02-15 08:44:04'),
(686, 679, 2, 'Препараты для укрепления связок и суставов', 0.00, NULL, NULL, 0, 0, 0, '------lgzTA', NULL, NULL, '2021-02-15 08:44:18', '2021-02-15 08:44:18'),
(687, 679, 2, 'Гейнеры', 0.00, NULL, NULL, 0, 0, 0, '-xSu5v', NULL, NULL, '2021-02-15 08:44:31', '2021-02-15 08:44:31'),
(688, 679, 2, 'Креатин', 0.00, NULL, NULL, 0, 0, 0, '-UBT4T', NULL, NULL, '2021-02-15 08:44:42', '2021-02-15 08:44:42'),
(689, 679, 2, 'Жиросжигатели', 0.00, NULL, NULL, 0, 0, 0, '-h5RNX', NULL, NULL, '2021-02-15 08:44:58', '2021-02-15 08:44:58'),
(690, 679, 2, 'Специальное питание для спортсменов', 0.00, NULL, NULL, 0, 0, 0, '----pQlGx', NULL, NULL, '2021-02-15 08:45:11', '2021-02-15 08:45:11'),
(691, 674, 2, 'Шкатулки', 0.00, NULL, NULL, 0, 0, 0, '-WtkQ8', NULL, NULL, '2021-02-15 08:45:14', '2021-02-15 08:45:14'),
(692, 679, 2, 'Предтренировочные комплексы', 0.00, NULL, NULL, 0, 0, 0, '--6QqSh', NULL, NULL, '2021-02-15 08:45:27', '2021-02-15 08:45:27'),
(693, 674, 2, 'Подставки под бутылку', 0.00, NULL, NULL, 0, 0, 0, '---NTYcu', NULL, NULL, '2021-02-15 08:45:47', '2021-02-15 08:45:47'),
(694, 674, 2, 'Подставки под бутылку', 0.00, NULL, NULL, 0, 0, 0, '---fBLQl', NULL, NULL, '2021-02-15 08:46:05', '2021-02-15 08:46:05'),
(695, 674, 2, 'Подставки под бутылку', 0.00, NULL, NULL, 0, 0, 0, '---p7fjg', NULL, NULL, '2021-02-15 08:48:39', '2021-02-15 08:48:39'),
(696, 674, 2, 'Панно', 0.00, NULL, NULL, 0, 0, 0, '-1GREV', NULL, NULL, '2021-02-15 08:49:20', '2021-02-15 08:49:20'),
(697, 674, 2, 'Панно', 0.00, NULL, NULL, 0, 0, 0, '-LuLtK', NULL, NULL, '2021-02-15 08:50:22', '2021-02-15 08:50:22'),
(698, 674, 2, 'Колокольчики ручной работы', 0.00, NULL, NULL, 0, 0, 0, '---258Mu', NULL, NULL, '2021-02-15 08:51:20', '2021-02-15 08:51:20'),
(699, 563, 1, 'Детская мебель', 0.00, NULL, NULL, 0, 0, 0, '--b7oow', NULL, NULL, '2021-02-15 08:51:32', '2021-02-15 08:51:32'),
(700, 674, 2, 'Авторские работы', 0.00, NULL, NULL, 0, 0, 0, '--9FGSc', NULL, NULL, '2021-02-15 08:51:41', '2021-02-15 08:51:41'),
(701, 674, 2, 'Галантерея', 0.00, NULL, NULL, 0, 0, 0, '-eBC8c', NULL, NULL, '2021-02-15 08:52:24', '2021-02-15 08:52:24'),
(702, 674, 2, 'Посуда', 0.00, NULL, NULL, 0, 0, 0, '-ufzWb', NULL, NULL, '2021-02-15 08:52:54', '2021-02-15 08:52:54'),
(703, 699, 2, 'Кресла и диваны', 0.00, NULL, NULL, 0, 0, 0, '---uQ7m5', NULL, NULL, '2021-02-15 08:53:01', '2021-02-15 08:53:01'),
(704, 699, 2, 'Колыбели', 0.00, NULL, NULL, 0, 0, 0, '-06aDg', NULL, NULL, '2021-02-15 08:54:26', '2021-02-15 08:54:26'),
(705, 674, 2, 'Игрушки', 0.00, NULL, NULL, 0, 0, 0, '-NZrhO', NULL, NULL, '2021-02-15 08:55:08', '2021-02-15 08:55:08'),
(706, 699, 2, 'Парты и столы', 0.00, NULL, NULL, 0, 0, 0, '---f5Gv8', NULL, NULL, '2021-02-15 08:55:11', '2021-02-15 08:55:11'),
(707, 699, 2, 'Кроватки', 0.00, NULL, NULL, 0, 0, 0, '-Mlehc', NULL, NULL, '2021-02-15 08:55:38', '2021-02-15 08:55:38'),
(708, 674, 2, 'Свечи', 0.00, NULL, NULL, 0, 0, 0, '-CNZTb', NULL, NULL, '2021-02-15 08:56:07', '2021-02-15 08:56:07'),
(709, 699, 2, 'Наборы детской мебели', 0.00, NULL, NULL, 0, 0, 0, '---m9gsh', NULL, NULL, '2021-02-15 08:56:13', '2021-02-15 08:56:13'),
(710, 699, 2, 'Стулья и табуреты', 0.00, NULL, NULL, 0, 0, 0, '---9n2T5', NULL, NULL, '2021-02-15 08:57:04', '2021-02-15 08:57:04'),
(711, 674, 2, 'Иконы', 0.00, NULL, NULL, 0, 0, 0, '-YBfxR', NULL, NULL, '2021-02-15 08:57:40', '2021-02-15 08:57:40'),
(712, 699, 2, 'Детские готовые комплекты', 0.00, NULL, NULL, 0, 0, 0, '---ta9Qp', NULL, NULL, '2021-02-15 08:57:51', '2021-02-15 08:57:51'),
(713, 674, 2, 'Текстиль', 0.00, NULL, NULL, 0, 0, 0, '-pH76W', NULL, NULL, '2021-02-15 08:57:54', '2021-02-15 08:57:54'),
(714, 674, 2, 'Корзины', 0.00, NULL, NULL, 0, 0, 0, '-bnyrU', NULL, NULL, '2021-02-15 08:58:22', '2021-02-15 08:58:22'),
(715, 699, 2, 'Пеленальные комоды и столики', 0.00, NULL, NULL, 0, 0, 0, '----z18Qw', NULL, NULL, '2021-02-15 08:58:28', '2021-02-15 08:58:28'),
(716, 531, 1, 'Товары для бани и сауны', 0.00, NULL, NULL, 0, 0, 0, '-----JrlW4', NULL, NULL, '2021-02-15 09:05:05', '2021-02-15 09:05:05'),
(717, 679, 2, 'Посттренировочные комплексы', 0.00, NULL, NULL, 0, 0, 0, '--QgBsP', NULL, NULL, '2021-02-15 09:05:43', '2021-02-15 09:05:43'),
(718, 716, 2, 'Веники для бань', 0.00, NULL, NULL, 0, 0, 0, '---FTZPR', NULL, NULL, '2021-02-15 09:06:02', '2021-02-15 09:06:02'),
(719, 679, 2, 'Тестостероновые бустеры', 0.00, NULL, NULL, 0, 0, 0, '--0CajO', NULL, NULL, '2021-02-15 09:06:05', '2021-02-15 09:06:05'),
(721, 679, 2, 'Шейкеры и бутылки', 0.00, NULL, NULL, 0, 0, 0, '---yuBgv', NULL, NULL, '2021-02-15 09:06:21', '2021-02-15 09:06:21'),
(722, 716, 2, 'Банный текстиль', 0.00, NULL, NULL, 0, 0, 0, '--Ubz5V', NULL, NULL, '2021-02-15 09:06:23', '2021-02-15 09:06:23'),
(723, 677, 1, 'Тренажеры и инвентарь', 0.00, NULL, NULL, 0, 0, 0, '---Rlrvg', NULL, NULL, '2021-02-15 09:06:41', '2021-02-15 09:06:41'),
(724, 723, 2, 'Собственный вес', 0.00, NULL, NULL, 0, 0, 0, '--ZZMtZ', NULL, NULL, '2021-02-15 09:07:00', '2021-02-15 09:07:00'),
(725, 723, 2, 'Кардиотренажеры', 0.00, NULL, NULL, 0, 0, 0, '-kRSEh', NULL, NULL, '2021-02-15 09:07:13', '2021-02-15 09:07:13'),
(726, 723, 2, 'Силовые тренажеры', 0.00, NULL, NULL, 0, 0, 0, '--ksY6v', NULL, NULL, '2021-02-15 09:07:34', '2021-02-15 09:07:34'),
(727, 716, 2, 'Ведра и кадки', 0.00, NULL, NULL, 0, 0, 0, '---WmICo', NULL, NULL, '2021-02-15 09:08:01', '2021-02-15 09:08:01'),
(728, 716, 2, 'Шайки и ушаты', 0.00, NULL, NULL, 0, 0, 0, '---WYirR', NULL, NULL, '2021-02-15 09:08:26', '2021-02-15 09:08:26'),
(729, 536, 2, 'Лежаки и шезлонги', 0.00, NULL, NULL, 0, 0, 0, '---Odeh0', NULL, NULL, '2021-02-15 09:08:48', '2021-02-15 09:08:48'),
(730, 716, 2, 'Ковши и черпаки', 0.00, NULL, NULL, 0, 0, 0, '---NA5MN', NULL, NULL, '2021-02-15 09:08:50', '2021-02-15 09:08:50'),
(731, 716, 2, 'Обливные устройства', 0.00, NULL, NULL, 0, 0, 0, '--ftzsh', NULL, NULL, '2021-02-15 09:09:25', '2021-02-15 09:09:25'),
(732, 536, 2, 'Качели и гамаки', 0.00, NULL, NULL, 0, 0, 0, '---pOiYi', NULL, NULL, '2021-02-15 09:09:35', '2021-02-15 09:09:35'),
(733, 716, 2, 'Запарки и ароматизаторы', 0.00, NULL, NULL, 0, 0, 0, '---dbcFI', NULL, NULL, '2021-02-15 09:09:48', '2021-02-15 09:09:48'),
(734, 716, 2, 'Полки и скамьи', 0.00, NULL, NULL, 0, 0, 0, '---I4hLi', NULL, NULL, '2021-02-15 09:10:27', '2021-02-15 09:10:27'),
(735, 716, 2, 'Предметы интерьера бани', 0.00, NULL, NULL, 0, 0, 0, '---ipype', NULL, NULL, '2021-02-15 09:10:52', '2021-02-15 09:10:52'),
(736, 723, 2, 'Свободные веса', 0.00, NULL, NULL, 0, 0, 0, '--ZyDKS', NULL, NULL, '2021-02-15 09:10:55', '2021-02-15 09:10:55'),
(737, 723, 2, 'Аксессуары', 0.00, NULL, NULL, 0, 0, 0, '-SPly8', NULL, NULL, '2021-02-15 09:11:10', '2021-02-15 09:11:10'),
(738, 723, 2, 'Виброплатформы', 0.00, NULL, NULL, 0, 0, 0, '-fzB4o', NULL, NULL, '2021-02-15 09:11:24', '2021-02-15 09:11:24'),
(739, 536, 2, 'Плетеная мебель', 0.00, NULL, NULL, 0, 0, 0, '--fkrhu', NULL, NULL, '2021-02-15 12:12:44', '2021-02-15 09:12:44'),
(740, 716, 2, 'Парогенераторы', 0.00, NULL, NULL, 0, 0, 0, '-xPGeh', NULL, NULL, '2021-02-15 09:12:15', '2021-02-15 09:12:15'),
(741, 716, 2, 'Сауны', 0.00, NULL, NULL, 0, 0, 0, '-hPrmE', NULL, NULL, '2021-02-15 09:12:31', '2021-02-15 09:12:31'),
(742, 716, 2, 'Бочки и купели', 0.00, NULL, NULL, 0, 0, 0, '---7nCHg', NULL, NULL, '2021-02-15 09:12:56', '2021-02-15 09:12:56'),
(743, 716, 2, 'Дымоходы', 0.00, NULL, NULL, 0, 0, 0, '-EF5nK', NULL, NULL, '2021-02-15 09:13:28', '2021-02-15 09:13:28'),
(744, 716, 2, 'Двери', 0.00, NULL, NULL, 0, 0, 0, '-lvSsh', NULL, NULL, '2021-02-15 09:14:06', '2021-02-15 09:14:06'),
(745, 716, 2, 'Аксессуары', 0.00, NULL, NULL, 0, 0, 0, '-Yo9nh', NULL, NULL, '2021-02-15 09:14:38', '2021-02-15 09:14:38'),
(746, 536, 2, 'Надувная мебель и насосы', 0.00, NULL, NULL, 0, 0, 0, '----tbNFE', NULL, NULL, '2021-02-15 09:14:39', '2021-02-15 09:14:39'),
(747, 716, 2, 'Камни для печей', 0.00, NULL, NULL, 0, 0, 0, '---2DG9L', NULL, NULL, '2021-02-15 09:14:54', '2021-02-15 09:14:54'),
(748, 716, 2, 'Банные печи', 0.00, NULL, NULL, 0, 0, 0, '--Gubth', NULL, NULL, '2021-02-15 09:15:24', '2021-02-15 09:15:24'),
(749, 716, 2, 'Соль для бани', 0.00, NULL, NULL, 0, 0, 0, '---08jkf', NULL, NULL, '2021-02-15 09:15:43', '2021-02-15 09:15:43'),
(750, 536, 2, 'Комплекты садовой мебели', 0.00, NULL, NULL, 0, 0, 0, '---k4cj5', NULL, NULL, '2021-02-15 09:16:51', '2021-02-15 09:16:51'),
(751, 531, 1, 'Цветы и растения', 0.00, NULL, NULL, 0, 0, 0, '---CEUm6', NULL, NULL, '2021-02-15 09:17:01', '2021-02-15 09:17:01'),
(752, 751, 2, 'Цветы, букеты, композиции', 0.00, NULL, NULL, 0, 0, 0, '---Pxwud', NULL, NULL, '2021-02-15 09:17:25', '2021-02-15 09:17:25'),
(753, 751, 2, 'Семена и саженцы', 0.00, NULL, NULL, 0, 0, 0, '---XmpAG', NULL, NULL, '2021-02-15 09:17:43', '2021-02-15 09:17:43'),
(754, 751, 2, 'Комнатные растения', 0.00, NULL, NULL, 0, 0, 0, '--mfBZS', NULL, NULL, '2021-02-15 09:18:15', '2021-02-15 09:18:15'),
(755, 751, 2, 'Горшки и кашпо', 0.00, NULL, NULL, 0, 0, 0, '---0GsVF', NULL, NULL, '2021-02-15 09:18:37', '2021-02-15 09:18:37'),
(756, 536, 2, 'Надувные диваны', 0.00, NULL, NULL, 0, 0, 0, '--KBLxt', NULL, NULL, '2021-02-15 09:18:55', '2021-02-15 09:18:55'),
(757, 751, 2, 'Лейки и опрыскиватели', 0.00, NULL, NULL, 0, 0, 0, '---MhtUL', NULL, NULL, '2021-02-15 09:18:57', '2021-02-15 09:18:57'),
(758, 536, 2, 'Подвесные кресла', 0.00, NULL, NULL, 0, 0, 0, '--avg3E', NULL, NULL, '2021-02-15 09:20:05', '2021-02-15 09:20:05'),
(759, 751, 2, 'Корзины для цветов', 0.00, NULL, NULL, 0, 0, 0, '---Sr4KK', NULL, NULL, '2021-02-15 09:20:08', '2021-02-15 09:20:08'),
(760, 751, 2, 'Подставки и крепления для растений', 0.00, NULL, NULL, 0, 0, 0, '-----t5XPT', NULL, NULL, '2021-02-15 09:20:29', '2021-02-15 09:20:29'),
(761, 751, 2, 'Грунты и удобрения', 0.00, NULL, NULL, 0, 0, 0, '---TLGKV', NULL, NULL, '2021-02-15 09:20:49', '2021-02-15 09:20:49'),
(762, 751, 2, 'Защита и уход за растениями', 0.00, NULL, NULL, 0, 0, 0, '-----4JnFc', NULL, NULL, '2021-02-15 09:21:42', '2021-02-15 09:21:42'),
(763, 531, 1, 'Товары для праздников', 0.00, NULL, NULL, 0, 0, 0, '---HeNX6', NULL, NULL, '2021-02-15 09:22:11', '2021-02-15 09:22:11');
INSERT INTO `categories` (`id`, `parent_id`, `level`, `name`, `commision_rate`, `banner`, `icon`, `featured`, `top`, `digital`, `slug`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(764, 536, 2, 'Скамейки', 0.00, NULL, NULL, 0, 0, 0, '-zUd7C', NULL, NULL, '2021-02-15 09:23:05', '2021-02-15 09:23:05'),
(765, 763, 2, 'Фейерверки', 0.00, NULL, NULL, 0, 0, 0, '-OmFqY', NULL, NULL, '2021-02-15 09:24:06', '2021-02-15 09:24:06'),
(766, 763, 2, 'Подарочная упаковка', 0.00, NULL, NULL, 0, 0, 0, '--By8O1', NULL, NULL, '2021-02-15 09:24:28', '2021-02-15 09:24:28'),
(767, 536, 2, 'Стулья и кресла', 0.00, NULL, NULL, 0, 0, 0, '---STnLa', NULL, NULL, '2021-02-15 09:24:30', '2021-02-15 09:24:30'),
(768, 763, 2, 'Воздушные шары', 0.00, NULL, NULL, 0, 0, 0, '--Iwasj', NULL, NULL, '2021-02-15 09:25:05', '2021-02-15 09:25:05'),
(769, 763, 2, 'Украшения для организации праздников', 0.00, NULL, NULL, 0, 0, 0, '----TCAwu', NULL, NULL, '2021-02-15 09:25:48', '2021-02-15 09:25:48'),
(770, 723, 2, 'Инверсионные столы', 0.00, NULL, NULL, 0, 0, 0, '--8Ar1y', NULL, NULL, '2021-02-15 09:26:04', '2021-02-15 09:26:04'),
(771, 763, 2, 'Открытки', 0.00, NULL, NULL, 0, 0, 0, '-hmIKm', NULL, NULL, '2021-02-15 09:26:07', '2021-02-15 09:26:07'),
(772, 536, 2, 'Стулья и кресла', 0.00, NULL, NULL, 0, 0, 0, '---bx5Mp', NULL, NULL, '2021-02-15 09:26:14', '2021-02-15 09:26:14'),
(773, 723, 2, 'Гаджеты для тренировок', 0.00, NULL, NULL, 0, 0, 0, '---zbE0J', NULL, NULL, '2021-02-15 09:26:20', '2021-02-15 09:26:20'),
(774, 763, 2, 'Дипломы, медали, значки', 0.00, NULL, NULL, 0, 0, 0, '---iqT79', NULL, NULL, '2021-02-15 09:26:35', '2021-02-15 09:26:35'),
(775, 723, 2, 'Беговые дорожки', 0.00, NULL, NULL, 0, 0, 0, '--1hHoX', NULL, NULL, '2021-02-15 09:26:36', '2021-02-15 09:26:36'),
(776, 723, 2, 'Велотренажеры', 0.00, NULL, NULL, 0, 0, 0, '-xGOUX', NULL, NULL, '2021-02-15 09:26:50', '2021-02-15 09:26:50'),
(777, 723, 2, 'Шведские стенки и комплексы', 0.00, NULL, NULL, 0, 0, 0, '----UCkYV', NULL, NULL, '2021-02-15 09:27:05', '2021-02-15 09:27:05'),
(778, 763, 2, 'Грим', 0.00, NULL, NULL, 0, 0, 0, '-a7pSo', NULL, NULL, '2021-02-15 09:27:05', '2021-02-15 09:27:05'),
(779, 536, 2, 'Зонты от солнца', 0.00, NULL, NULL, 0, 0, 0, '---NSIEw', NULL, NULL, '2021-02-15 09:27:15', '2021-02-15 09:27:15'),
(780, 723, 2, 'Минитренажеры', 0.00, NULL, NULL, 0, 0, 0, '-4pQzz', NULL, NULL, '2021-02-15 09:27:22', '2021-02-15 09:27:22'),
(781, 763, 2, 'Свадебные украшения', 0.00, NULL, NULL, 0, 0, 0, '--zNP32', NULL, NULL, '2021-02-15 09:27:27', '2021-02-15 09:27:27'),
(782, 723, 2, 'Гантели, гири и штанги', 0.00, NULL, NULL, 0, 0, 0, '----Cca6O', NULL, NULL, '2021-02-15 09:27:35', '2021-02-15 09:27:35'),
(783, 763, 2, 'Мыльные пузыри', 0.00, NULL, NULL, 0, 0, 0, '--ditKC', NULL, NULL, '2021-02-15 09:27:47', '2021-02-15 09:27:47'),
(784, 723, 2, 'Фитнес', 0.00, NULL, NULL, 0, 0, 0, '-BMnfO', NULL, NULL, '2021-02-15 09:27:50', '2021-02-15 09:27:50'),
(785, 723, 2, 'Коврики', 0.00, NULL, NULL, 0, 0, 0, '-HSOjp', NULL, NULL, '2021-02-15 09:28:05', '2021-02-15 09:28:05'),
(786, 763, 2, 'Одноразовая посуда', 0.00, NULL, NULL, 0, 0, 0, '--N7UYV', NULL, NULL, '2021-02-15 09:28:07', '2021-02-15 09:28:07'),
(787, 723, 2, 'Йога', 0.00, NULL, NULL, 0, 0, 0, '-W9dOD', NULL, NULL, '2021-02-15 09:28:22', '2021-02-15 09:28:22'),
(788, 763, 2, 'Подарочные наборы', 0.00, NULL, NULL, 0, 0, 0, '--NxbdL', NULL, NULL, '2021-02-15 09:28:26', '2021-02-15 09:28:26'),
(789, 723, 2, 'Аксессуары для силовых тренировок', 0.00, NULL, NULL, 0, 0, 0, '----c3Cuj', NULL, NULL, '2021-02-15 09:28:34', '2021-02-15 09:28:34'),
(790, 763, 2, 'Карнавальные костюмы для детей', 0.00, NULL, NULL, 0, 0, 0, '----IdaeN', NULL, NULL, '2021-02-15 09:28:45', '2021-02-15 09:28:45'),
(791, 723, 2, 'Бильярд', 0.00, NULL, NULL, 0, 0, 0, '-7gR53', NULL, NULL, '2021-02-15 09:28:47', '2021-02-15 09:28:47'),
(792, 536, 2, 'Комплекты садовой мебели', 0.00, NULL, NULL, 0, 0, 0, '---mEPBm', NULL, NULL, '2021-02-15 09:28:56', '2021-02-15 09:28:56'),
(793, 723, 2, 'Игровые столы', 0.00, NULL, NULL, 0, 0, 0, '--Fge6y', NULL, NULL, '2021-02-15 09:28:59', '2021-02-15 09:28:59'),
(794, 763, 2, 'Карнавальные костюмы и аксессуары', 0.00, NULL, NULL, 0, 0, 0, '----gDRSS', NULL, NULL, '2021-02-15 09:29:02', '2021-02-15 09:29:02'),
(795, 723, 2, 'Настольный теннис', 0.00, NULL, NULL, 0, 0, 0, '--2GEGV', NULL, NULL, '2021-02-15 09:29:16', '2021-02-15 09:29:16'),
(796, 763, 2, 'Новогодние товары', 0.00, NULL, NULL, 0, 0, 0, '--Co7qP', NULL, NULL, '2021-02-15 09:29:22', '2021-02-15 09:29:22'),
(797, 723, 2, 'Гаджеты для тренировок', 0.00, NULL, NULL, 0, 0, 0, '---FGSGL', NULL, NULL, '2021-02-15 09:29:31', '2021-02-15 09:29:31'),
(798, 723, 2, 'Спортивная защита', 0.00, NULL, NULL, 0, 0, 0, '--rY3ew', NULL, NULL, '2021-02-15 09:29:51', '2021-02-15 09:29:51'),
(799, 531, 1, 'Игры для компаний', 0.00, NULL, NULL, 0, 0, 0, '---Y2EmO', NULL, NULL, '2021-02-15 09:30:12', '2021-02-15 09:30:12'),
(800, 677, 1, 'Зимние виды спорта', 0.00, NULL, NULL, 0, 0, 0, '---GtOxY', NULL, NULL, '2021-02-15 09:30:18', '2021-02-15 09:30:18'),
(801, 799, 2, 'Игры в дорогу', 0.00, NULL, NULL, 0, 0, 0, '---QZ1Vg', NULL, NULL, '2021-02-15 09:30:48', '2021-02-15 09:30:48'),
(802, 799, 2, 'Семейные игры', 0.00, NULL, NULL, 0, 0, 0, '--e8E60', NULL, NULL, '2021-02-15 09:31:09', '2021-02-15 09:31:09'),
(803, 800, 2, 'Сноубординг', 0.00, NULL, NULL, 0, 0, 0, '-U2koa', NULL, NULL, '2021-02-15 09:31:28', '2021-02-15 09:31:28'),
(804, 536, 2, 'Матрасы для шезлонгов', 0.00, NULL, NULL, 0, 0, 0, '---3E3ic', NULL, NULL, '2021-02-15 09:31:34', '2021-02-15 09:31:34'),
(805, 799, 2, 'Настольные игры', 0.00, NULL, NULL, 0, 0, 0, '--Dc82h', NULL, NULL, '2021-02-15 09:31:42', '2021-02-15 09:31:42'),
(806, 800, 2, 'Горные лыжи', 0.00, NULL, NULL, 0, 0, 0, '--a3PqE', NULL, NULL, '2021-02-15 09:31:57', '2021-02-15 09:31:57'),
(807, 800, 2, 'Беговые лыжи', 0.00, NULL, NULL, 0, 0, 0, '--zCOY2', NULL, NULL, '2021-02-15 09:32:17', '2021-02-15 09:32:17'),
(808, 799, 2, 'Стратегии', 0.00, NULL, NULL, 0, 0, 0, '-uuGxD', NULL, NULL, '2021-02-15 09:32:26', '2021-02-15 09:32:26'),
(809, 799, 2, 'Карточные игры', 0.00, NULL, NULL, 0, 0, 0, '--7bleb', NULL, NULL, '2021-02-15 09:33:06', '2021-02-15 09:33:06'),
(810, 800, 2, 'Защита и экипировка', 0.00, NULL, NULL, 0, 0, 0, '---QCMKh', NULL, NULL, '2021-02-15 09:33:09', '2021-02-15 09:33:09'),
(811, 800, 2, 'Коньки и аксессуары', 0.00, NULL, NULL, 0, 0, 0, '---2NnHZ', NULL, NULL, '2021-02-15 09:33:33', '2021-02-15 09:33:33'),
(812, 799, 2, 'Варгеймы', 0.00, NULL, NULL, 0, 0, 0, '-xP3A3', NULL, NULL, '2021-02-15 09:33:35', '2021-02-15 09:33:35'),
(813, 800, 2, 'Хоккей', 0.00, NULL, NULL, 0, 0, 0, '-LyEPd', NULL, NULL, '2021-02-15 09:33:49', '2021-02-15 09:33:49'),
(814, 799, 2, 'RPG', 0.00, NULL, NULL, 0, 0, 0, 'RPG-hNRq3', NULL, NULL, '2021-02-15 09:33:53', '2021-02-15 09:33:53'),
(815, 800, 2, 'Детям', 0.00, NULL, NULL, 0, 0, 0, '-pDMGl', NULL, NULL, '2021-02-15 09:34:03', '2021-02-15 09:34:03'),
(816, 799, 2, 'Наборы для покера', 0.00, NULL, NULL, 0, 0, 0, '---Ehxdf', NULL, NULL, '2021-02-15 09:34:21', '2021-02-15 09:34:21'),
(817, 800, 2, 'Аксессуары для спортсменов', 0.00, NULL, NULL, 0, 0, 0, '---txjFT', NULL, NULL, '2021-02-15 09:34:23', '2021-02-15 09:34:23'),
(818, 800, 2, 'Аксессуары и комплектующие для снаряжения', 0.00, NULL, NULL, 0, 0, 0, '-----jblv3', NULL, NULL, '2021-02-15 09:34:36', '2021-02-15 09:34:36'),
(819, 799, 2, 'Настольный футбол, хоккей', 0.00, NULL, NULL, 0, 0, 0, '---LQtkv', NULL, NULL, '2021-02-15 09:34:48', '2021-02-15 09:34:48'),
(820, 677, 1, 'Охота и рыбалка', 0.00, NULL, NULL, 0, 0, 0, '---OXMBH', NULL, NULL, '2021-02-15 09:34:58', '2021-02-15 09:34:58'),
(821, 820, 2, 'Товары для рыбалки', 0.00, NULL, NULL, 0, 0, 0, '---toEDP', NULL, NULL, '2021-02-15 09:35:14', '2021-02-15 09:35:14'),
(822, 799, 2, 'Шахматы, шашки, нарды', 0.00, NULL, NULL, 0, 0, 0, '---jDRDF', NULL, NULL, '2021-02-15 09:35:15', '2021-02-15 09:35:15'),
(823, 820, 2, 'Товары для охоты', 0.00, NULL, NULL, 0, 0, 0, '---XHxo0', NULL, NULL, '2021-02-15 09:35:34', '2021-02-15 09:35:34'),
(824, 799, 2, 'Домино и лото', 0.00, NULL, NULL, 0, 0, 0, '---f6Tjo', NULL, NULL, '2021-02-15 09:35:35', '2021-02-15 09:35:35'),
(825, 820, 2, 'Сумки и ящики', 0.00, NULL, NULL, 0, 0, 0, '---Pqelw', NULL, NULL, '2021-02-15 09:35:49', '2021-02-15 09:35:49'),
(826, 799, 2, 'Пазлы', 0.00, NULL, NULL, 0, 0, 0, '-pEyCt', NULL, NULL, '2021-02-15 09:35:53', '2021-02-15 09:35:53'),
(827, 820, 2, 'Аксессуары', 0.00, NULL, NULL, 0, 0, 0, '-5zYqK', NULL, NULL, '2021-02-15 09:36:04', '2021-02-15 09:36:04'),
(828, 799, 2, 'Сборные модели', 0.00, NULL, NULL, 0, 0, 0, '--LIIBj', NULL, NULL, '2021-02-15 09:36:16', '2021-02-15 09:36:16'),
(829, 820, 2, 'Одежда для охоты и рыбалки', 0.00, NULL, NULL, 0, 0, 0, '-----mnA9x', NULL, NULL, '2021-02-15 09:36:19', '2021-02-15 09:36:19'),
(831, 820, 2, 'Обувь для охоты и рыбалки', 0.00, NULL, NULL, 0, 0, 0, '-----3qShY', NULL, NULL, '2021-02-15 09:36:38', '2021-02-15 09:36:38'),
(832, 536, 2, 'Матрасы для садовых качелей', 0.00, NULL, NULL, 0, 0, 0, '----zWGYc', NULL, NULL, '2021-02-15 09:36:45', '2021-02-15 09:36:45'),
(833, 820, 2, 'Охота и стрельба', 0.00, NULL, NULL, 0, 0, 0, '---izLsS', NULL, NULL, '2021-02-15 09:36:56', '2021-02-15 09:36:56'),
(834, 799, 2, 'Головоломки', 0.00, NULL, NULL, 0, 0, 0, '-UuC71', NULL, NULL, '2021-02-15 09:36:59', '2021-02-15 09:36:59'),
(835, 820, 2, 'Лодки и лодочные моторы', 0.00, NULL, NULL, 0, 0, 0, '----EE5HU', NULL, NULL, '2021-02-15 09:37:18', '2021-02-15 09:37:18'),
(836, 677, 1, 'Туризм и отдых на природе', 0.00, NULL, NULL, 0, 0, 0, '-----9ziW3', NULL, NULL, '2021-02-15 09:37:42', '2021-02-15 09:37:42'),
(837, 820, 2, 'Рюкзаки для туризма', 0.00, NULL, NULL, 0, 0, 0, '---9p4qv', NULL, NULL, '2021-02-15 12:39:29', '2021-02-15 09:39:29'),
(838, 536, 2, 'Аксессуары для шатров, зонтов', 0.00, NULL, NULL, 0, 0, 0, '----eleMJ', NULL, NULL, '2021-02-15 09:38:42', '2021-02-15 09:38:42'),
(840, 536, 2, 'Тенты и шатры', 0.00, NULL, NULL, 0, 0, 0, '---7PhEE', NULL, NULL, '2021-02-15 09:40:40', '2021-02-15 09:40:40'),
(841, 563, 1, 'Мебель для ванной', 0.00, NULL, NULL, 0, 0, 0, '---XC1Qp', NULL, NULL, '2021-02-15 09:42:44', '2021-02-15 09:42:44'),
(842, 841, 2, 'Шкафы', 0.00, NULL, NULL, 0, 0, 0, '-5pRin', NULL, NULL, '2021-02-15 09:48:39', '2021-02-15 09:48:39'),
(843, 841, 2, 'Готовые комплекты мебели', 0.00, NULL, NULL, 0, 0, 0, '---Fwb1L', NULL, NULL, '2021-02-15 09:49:40', '2021-02-15 09:49:40'),
(844, 841, 2, 'Тумбы для ванной', 0.00, NULL, NULL, 0, 0, 0, '---Ov7ls', NULL, NULL, '2021-02-15 09:50:27', '2021-02-15 09:50:27'),
(845, 841, 2, 'Зеркала', 0.00, NULL, NULL, 0, 0, 0, '-qlutz', NULL, NULL, '2021-02-15 09:51:31', '2021-02-15 09:51:31'),
(846, 841, 2, 'Держатели и крючки', 0.00, NULL, NULL, 0, 0, 0, '---KPEvA', NULL, NULL, '2021-02-15 09:52:00', '2021-02-15 09:52:00'),
(847, 841, 2, 'Коврики', 0.00, NULL, NULL, 0, 0, 0, '-QinBE', NULL, NULL, '2021-02-15 09:52:28', '2021-02-15 09:52:28'),
(848, 841, 2, 'Мыльницы, стаканы и дозаторы', 0.00, NULL, NULL, 0, 0, 0, '----S4o5P', NULL, NULL, '2021-02-15 09:53:38', '2021-02-15 09:53:38'),
(849, 841, 2, 'Полки, стойки, этажерки', 0.00, NULL, NULL, 0, 0, 0, '---4DzLV', NULL, NULL, '2021-02-15 09:54:26', '2021-02-15 09:54:26'),
(850, 841, 2, 'Шторы и карнизы', 0.00, NULL, NULL, 0, 0, 0, '---Yw5lY', NULL, NULL, '2021-02-15 09:55:33', '2021-02-15 09:55:33'),
(851, 563, 1, 'Мебель для кухни', 0.00, NULL, NULL, 0, 0, 0, '---34R0O', NULL, NULL, '2021-02-15 09:56:09', '2021-02-15 09:56:09'),
(852, 851, 2, 'Уголки и обеденные группы', 0.00, NULL, NULL, 0, 0, 0, '----K6WQE', NULL, NULL, '2021-02-15 09:56:42', '2021-02-15 09:56:42'),
(853, 851, 2, 'Кухонные гарнитуры', 0.00, NULL, NULL, 0, 0, 0, '--F8s1U', NULL, NULL, '2021-02-15 09:57:36', '2021-02-15 09:57:36'),
(854, 851, 2, 'Стулья, табуретки', 0.00, NULL, NULL, 0, 0, 0, '--MPn6C', NULL, NULL, '2021-02-15 09:58:01', '2021-02-15 09:58:01'),
(855, 851, 2, 'Столы и столики', 0.00, NULL, NULL, 0, 0, 0, '---NtpF3', NULL, NULL, '2021-02-15 09:58:22', '2021-02-15 09:58:22'),
(856, 851, 2, 'Кухонные готовые гарнитуры', 0.00, NULL, NULL, 0, 0, 0, '---hoGgs', NULL, NULL, '2021-02-15 09:59:06', '2021-02-15 09:59:06'),
(857, 563, 1, 'Мебель для спальни', 0.00, NULL, NULL, 0, 0, 0, '---kgJ01', NULL, NULL, '2021-02-15 10:02:03', '2021-02-15 10:02:03'),
(858, 857, 2, 'Спальня готовый комплект', 0.00, NULL, NULL, 0, 0, 0, '---wiXUO', NULL, NULL, '2021-02-15 10:20:18', '2021-02-15 10:20:18'),
(859, 857, 2, 'Матрасы', 0.00, NULL, NULL, 0, 0, 0, '-5700f', NULL, NULL, '2021-02-15 13:30:13', '2021-02-15 10:30:13'),
(860, 857, 2, 'Кровати', 0.00, NULL, NULL, 0, 0, 0, '-FdAhX', NULL, NULL, '2021-02-15 10:21:17', '2021-02-15 10:21:17'),
(861, 857, 2, 'Основания для матрасов', 0.00, NULL, NULL, 0, 0, 0, '---Zzw6j', NULL, NULL, '2021-02-15 10:26:33', '2021-02-15 10:26:33'),
(862, 857, 2, 'Изголовья', 0.00, NULL, NULL, 0, 0, 0, '-EsGtU', NULL, NULL, '2021-02-15 10:27:18', '2021-02-15 10:27:18'),
(863, 563, 1, 'Офисная мебель', 0.00, NULL, NULL, 0, 0, 0, '--GFoop', NULL, NULL, '2021-02-15 10:31:09', '2021-02-15 10:31:09'),
(864, 863, 2, 'Мебель для учреждений', 0.00, NULL, NULL, 0, 0, 0, '---JOXnw', NULL, NULL, '2021-02-15 10:31:32', '2021-02-15 10:31:32'),
(865, 863, 2, 'Шкафы для документов', 0.00, NULL, NULL, 0, 0, 0, '---s3l9b', NULL, NULL, '2021-02-15 13:34:15', '2021-02-15 10:34:15'),
(866, 863, 2, 'Кабинеты', 0.00, NULL, NULL, 0, 0, 0, '-xb3Fl', NULL, NULL, '2021-02-15 10:35:22', '2021-02-15 10:35:22'),
(867, 863, 2, 'Скамьи и секции', 0.00, NULL, NULL, 0, 0, 0, '---V9G5l', NULL, NULL, '2021-02-15 10:36:01', '2021-02-15 10:36:01'),
(868, 563, 1, 'Фурнитура для мебели и комплектующие', 0.00, NULL, NULL, 0, 0, 0, '-----Woc1y', NULL, NULL, '2021-02-15 10:36:46', '2021-02-15 10:36:46'),
(869, 868, 2, 'Фурнитура для мебели', 0.00, NULL, NULL, 0, 0, 0, '---euleN', NULL, NULL, '2021-02-15 10:37:54', '2021-02-15 10:37:54'),
(870, 868, 2, 'Комплектующие', 0.00, NULL, NULL, 0, 0, 0, '-miDfU', NULL, NULL, '2021-02-15 10:38:25', '2021-02-15 10:38:25'),
(871, 563, 1, 'Сейфы', 0.00, NULL, NULL, 0, 0, 0, '-6hu40', NULL, NULL, '2021-02-15 10:38:48', '2021-02-15 10:38:48'),
(872, 871, 2, 'Электронные сейфы', 0.00, NULL, NULL, 0, 0, 0, '--NU77m', NULL, NULL, '2021-02-15 10:39:11', '2021-02-15 10:39:11'),
(873, 871, 2, 'Сейфы обычные', 0.00, NULL, NULL, 0, 0, 0, '--nibra', NULL, NULL, '2021-02-15 10:39:34', '2021-02-15 10:39:34'),
(874, 871, 2, 'Шкафы железные', 0.00, NULL, NULL, 0, 0, 0, '--DcRIh', NULL, NULL, '2021-02-15 10:39:58', '2021-02-15 10:39:58'),
(875, 871, 2, 'Железные тумбы', 0.00, NULL, NULL, 0, 0, 0, '--dq9LK', NULL, NULL, '2021-02-15 10:40:26', '2021-02-15 10:40:26'),
(878, 820, 2, 'Лодки и лодочные моторы', 0.00, NULL, NULL, 0, 0, 0, '----mXPAs', NULL, NULL, '2021-02-15 10:52:08', '2021-02-15 10:52:08'),
(880, 836, 2, 'Палатки, тенты и спальники', 0.00, NULL, NULL, 0, 0, 0, '----HHfF9', NULL, NULL, '2021-02-15 10:53:58', '2021-02-15 10:53:58'),
(881, 836, 2, 'Рюкзаки для туризма', 0.00, NULL, NULL, 0, 0, 0, '---P8X8T', NULL, NULL, '2021-02-15 10:54:17', '2021-02-15 10:54:17'),
(882, 836, 2, 'Походная кухня', 0.00, NULL, NULL, 0, 0, 0, '--RT7W4', NULL, NULL, '2021-02-15 10:54:37', '2021-02-15 10:54:37'),
(883, 836, 2, 'Походная мебель', 0.00, NULL, NULL, 0, 0, 0, '--9DP12', NULL, NULL, '2021-02-15 10:55:00', '2021-02-15 10:55:00'),
(884, 836, 2, 'Аксессуары для туризма', 0.00, NULL, NULL, 0, 0, 0, '---ypv8Z', NULL, NULL, '2021-02-15 10:55:21', '2021-02-15 10:55:21'),
(885, 836, 2, 'Палки для скандинавской ходьбы и треккинга', 0.00, NULL, NULL, 0, 0, 0, '------C7ZoM', NULL, NULL, '2021-02-15 10:55:37', '2021-02-15 10:55:37'),
(886, 677, 1, 'Активные виды спорта', 0.00, NULL, NULL, 0, 0, 0, '---Y4EHq', NULL, NULL, '2021-02-15 10:57:06', '2021-02-15 10:57:06'),
(887, 886, 2, 'Велосипеды', 0.00, NULL, NULL, 0, 0, 0, '-ilGMg', NULL, NULL, '2021-02-15 10:57:41', '2021-02-15 10:57:41'),
(888, 886, 2, 'Аксессуары', 0.00, NULL, NULL, 0, 0, 0, '-hTg1F', NULL, NULL, '2021-02-15 11:00:12', '2021-02-15 11:00:12'),
(889, 886, 2, 'Запчасти', 0.00, NULL, NULL, 0, 0, 0, '-EfXnV', NULL, NULL, '2021-02-15 11:01:52', '2021-02-15 11:01:52'),
(890, 886, 2, 'Инструменты', 0.00, NULL, NULL, 0, 0, 0, '-Fn3Tz', NULL, NULL, '2021-02-15 11:02:15', '2021-02-15 11:02:15'),
(892, 886, 2, 'Самокаты', 0.00, NULL, NULL, 0, 0, 0, '-rSjdr', NULL, NULL, '2021-02-15 11:03:15', '2021-02-15 11:03:15'),
(893, 886, 2, 'Скейтборды и лонгборды', 0.00, NULL, NULL, 0, 0, 0, '---sPhyL', NULL, NULL, '2021-02-15 11:03:31', '2021-02-15 11:03:31'),
(894, 886, 2, 'Роликовые коньки', 0.00, NULL, NULL, 0, 0, 0, '--nI7xw', NULL, NULL, '2021-02-15 11:03:54', '2021-02-15 11:03:54');

-- --------------------------------------------------------

--
-- Структура таблицы `category_translations`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 14:03
--

DROP TABLE IF EXISTS `category_translations`;
CREATE TABLE `category_translations` (
  `id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `category_translations`
--

INSERT INTO `category_translations` (`id`, `category_id`, `name`, `lang`, `created_at`, `updated_at`) VALUES
(227, 221, 'Beauty and hygiene', 'en', '2021-02-13 15:56:23', '2021-02-13 15:56:23'),
(228, 222, 'Perfumery', 'en', '2021-02-13 15:57:52', '2021-02-13 15:57:52'),
(229, 223, 'Women', 'en', '2021-02-13 15:58:38', '2021-02-13 15:58:38'),
(230, 224, 'Mens', 'en', '2021-02-13 15:59:04', '2021-02-13 15:59:04'),
(231, 225, 'Unisex', 'en', '2021-02-13 15:59:28', '2021-02-13 15:59:28'),
(232, 226, 'Niche', 'en', '2021-02-13 15:59:55', '2021-02-13 15:59:55'),
(238, 232, 'For lips', 'en', '2021-02-13 16:03:11', '2021-02-13 16:03:11'),
(241, 235, 'Sets', 'en', '2021-02-13 16:04:40', '2021-02-13 16:04:40'),
(242, 236, 'Removing makeup', 'en', '2021-02-13 16:05:08', '2021-02-13 16:05:08'),
(244, 238, 'Pharmacy cosmetics', 'en', '2021-02-13 16:06:20', '2021-02-13 16:06:20'),
(246, 240, 'Professional makeup', 'en', '2021-02-13 16:07:08', '2021-02-13 16:07:08'),
(247, 241, 'Face care', 'en', '2021-02-13 16:07:56', '2021-02-13 16:07:56'),
(248, 242, 'Cleansing and makeup removal', 'en', '2021-02-13 16:08:42', '2021-02-13 16:08:42'),
(249, 243, 'Toning', 'en', '2021-02-13 16:09:03', '2021-02-13 16:09:03'),
(250, 244, 'Creams and serums', 'en', '2021-02-13 16:09:36', '2021-02-13 16:09:36'),
(251, 245, 'Caring for the skin around the eyes', 'en', '2021-02-13 16:09:56', '2021-02-13 16:09:56'),
(252, 246, 'Masks', 'en', '2021-02-13 16:10:26', '2021-02-13 16:10:26'),
(253, 247, 'Scrubs and peels', 'en', '2021-02-13 16:10:48', '2021-02-13 16:10:48'),
(256, 250, 'Night care', 'en', '2021-02-13 16:12:58', '2021-02-13 16:12:58'),
(257, 251, 'Anti-aging cosmetics', 'en', '2021-02-13 16:13:38', '2021-02-13 16:13:38'),
(258, 252, 'Problem skin', 'en', '2021-02-13 16:14:12', '2021-02-13 16:14:12'),
(259, 253, 'Sun protection', 'en', '2021-02-13 16:14:46', '2021-02-13 16:14:46'),
(260, 254, 'Facial care devices', 'en', '2021-02-13 16:15:08', '2021-02-13 16:15:08'),
(262, 256, 'Travel vials', 'en', '2021-02-13 16:16:20', '2021-02-13 16:16:20'),
(263, 257, 'Natural cosmetic', 'en', '2021-02-13 16:16:48', '2021-02-13 16:16:48'),
(392, 386, 'Luxury', 'en', '2021-02-14 05:08:41', '2021-02-14 05:08:41'),
(395, 389, 'Gift sets', 'en', '2021-02-14 05:09:19', '2021-02-14 05:09:19'),
(411, 405, 'Makeup', 'en', '2021-02-14 05:14:52', '2021-02-14 05:14:52'),
(417, 411, 'For face', 'en', '2021-02-14 05:17:44', '2021-02-14 05:17:44'),
(424, 418, 'For eyes', 'en', '2021-02-14 05:25:08', '2021-02-14 05:25:08'),
(425, 419, 'For eyebrows', 'en', '2021-02-14 05:25:58', '2021-02-14 05:25:58'),
(426, 420, 'Accessories', 'en', '2021-02-14 05:27:00', '2021-02-14 05:27:00'),
(427, 421, 'Natural cosmetic', 'en', '2021-02-14 05:34:59', '2021-02-14 05:34:59'),
(428, 422, 'Lip care', 'en', '2021-02-14 05:39:33', '2021-02-14 05:39:33'),
(429, 423, 'BB, CC and DD creams', 'en', '2021-02-14 05:40:12', '2021-02-14 05:40:12'),
(430, 424, 'Sets', 'en', '2021-02-14 05:42:02', '2021-02-14 05:42:02'),
(431, 425, 'Travel vials', 'en', '2021-02-14 05:42:35', '2021-02-14 05:42:35'),
(432, 426, 'Natural cosmetic', 'en', '2021-02-14 05:43:35', '2021-02-14 05:43:35'),
(433, 427, 'Natural cosmetic', 'en', '2021-02-14 05:46:05', '2021-02-14 05:46:05'),
(434, 428, 'Hair care', 'en', '2021-02-14 05:47:11', '2021-02-14 05:47:11'),
(435, 429, 'Shampoos', 'en', '2021-02-14 05:47:32', '2021-02-14 05:47:32'),
(436, 430, 'Balms and rinses', 'en', '2021-02-14 05:47:53', '2021-02-14 05:47:53'),
(437, 431, 'Dry shampoos', 'en', '2021-02-14 05:48:26', '2021-02-14 05:48:26'),
(438, 432, 'Masks and serums', 'en', '2021-02-14 05:49:18', '2021-02-14 05:49:18'),
(439, 433, 'Coloration', 'en', '2021-02-14 05:49:51', '2021-02-14 05:49:51'),
(440, 434, 'Styling and styling', 'en', '2021-02-14 05:50:20', '2021-02-14 05:50:20'),
(441, 435, 'Combs and brushes', 'en', '2021-02-14 05:50:53', '2021-02-14 05:50:53'),
(442, 436, 'Cutting and styling devices', 'en', '2021-02-14 05:51:53', '2021-02-14 05:51:53'),
(443, 437, 'Body care', 'en', '2021-02-14 05:52:27', '2021-02-14 05:52:27'),
(444, 438, 'Creams and lotions', 'en', '2021-02-14 05:52:54', '2021-02-14 05:52:54'),
(445, 439, 'Deodorants for women', 'en', '2021-02-14 05:53:13', '2021-02-14 05:53:13'),
(446, 440, 'Deodorants for men', 'en', '2021-02-14 05:53:29', '2021-02-14 05:53:29'),
(447, 441, 'Depilation', 'en', '2021-02-14 05:53:56', '2021-02-14 05:53:56'),
(448, 442, 'Anti-cellulite and modeling products', 'en', '2021-02-14 05:54:14', '2021-02-14 05:54:14'),
(449, 443, 'Skin care during pregnancy', 'en', '2021-02-14 05:54:35', '2021-02-14 05:54:35'),
(450, 444, 'Tanning and sun protection', 'en', '2021-02-14 05:54:50', '2021-02-14 05:54:50'),
(451, 445, 'For legs', 'en', '2021-02-14 05:55:06', '2021-02-14 05:55:06'),
(452, 446, 'For hands', 'en', '2021-02-14 05:55:18', '2021-02-14 05:55:18'),
(453, 447, 'For shower', 'en', '2021-02-14 05:55:34', '2021-02-14 05:55:34'),
(454, 448, 'Foam, salt, oil', 'en', '2021-02-14 05:55:53', '2021-02-14 05:55:53'),
(455, 449, 'Soap', 'en', '2021-02-14 05:56:12', '2021-02-14 05:56:12'),
(456, 450, 'Body care devices', 'en', '2021-02-14 05:56:30', '2021-02-14 05:56:30'),
(457, 451, 'Washcloths and brushes', 'en', '2021-02-14 05:56:50', '2021-02-14 05:56:50'),
(458, 452, 'Аксессуары', 'en', '2021-02-14 05:57:08', '2021-02-15 02:07:44'),
(459, 453, 'Women\'s razors and blades', 'en', '2021-02-14 05:57:30', '2021-02-14 05:57:30'),
(460, 454, 'Essential oils and accessories', 'en', '2021-02-14 05:57:47', '2021-02-14 05:57:47'),
(461, 455, 'Men', 'en', '2021-02-14 05:57:57', '2021-02-14 05:57:57'),
(462, 456, 'Razors and blades', 'en', '2021-02-14 05:59:13', '2021-02-14 05:59:13'),
(463, 457, 'Shavers', 'en', '2021-02-14 05:59:31', '2021-02-14 05:59:31'),
(464, 458, 'Shaving products', 'en', '2021-02-14 05:59:46', '2021-02-14 05:59:46'),
(465, 459, 'Care for beard and mustache', 'en', '2021-02-14 06:00:03', '2021-02-14 06:00:03'),
(466, 460, 'Accessories for beard and mustache', 'en', '2021-02-14 06:00:34', '2021-02-14 06:00:34'),
(467, 461, 'Face care', 'en', '2021-02-14 06:00:57', '2021-02-14 06:00:57'),
(468, 462, 'For hair', 'en', '2021-02-14 06:01:20', '2021-02-14 06:01:20'),
(469, 463, 'Shower products', 'en', '2021-02-14 06:01:40', '2021-02-14 06:01:40'),
(470, 464, 'Deodorants', 'en', '2021-02-14 06:01:59', '2021-02-14 06:01:59'),
(471, 465, 'Perfumery', 'en', '2021-02-14 06:02:15', '2021-02-14 06:02:15'),
(472, 466, 'Sets', 'en', '2021-02-14 06:02:32', '2021-02-14 06:02:32'),
(473, 467, 'Beauty Technique', 'en', '2021-02-14 06:02:51', '2021-02-14 06:02:51'),
(474, 468, 'Hair dryers and hair dryers', 'en', '2021-02-14 06:03:07', '2021-02-14 06:03:07'),
(475, 469, 'Tongs, curling irons and straighteners', 'en', '2021-02-14 06:03:22', '2021-02-14 06:03:22'),
(476, 470, 'Electric curlers', 'en', '2021-02-14 06:03:42', '2021-02-14 06:03:42'),
(477, 471, 'Epilators', 'en', '2021-02-14 06:03:59', '2021-02-14 06:03:59'),
(478, 472, 'Shavers', 'en', '2021-02-14 06:04:18', '2021-02-14 06:04:18'),
(479, 473, 'Oral care', 'en', '2021-02-14 06:04:43', '2021-02-14 06:04:43'),
(480, 474, 'Electric face brushes', 'en', '2021-02-14 06:09:17', '2021-02-14 06:09:17'),
(481, 475, 'Facial care devices', 'en', '2021-02-14 06:09:38', '2021-02-14 06:09:38'),
(482, 476, 'Body care devices', 'en', '2021-02-14 06:10:08', '2021-02-14 06:10:08'),
(483, 477, 'Voskoplav and paraffin baths', 'en', '2021-02-14 06:10:26', '2021-02-14 06:10:26'),
(484, 478, 'Accessories for electric shavers and epilators', 'en', '2021-02-14 06:10:51', '2021-02-14 06:10:51'),
(485, 479, 'Tools and accessories', 'en', '2021-02-14 06:11:47', '2021-02-14 06:11:47'),
(486, 480, 'Makeup brushes, sponges', 'en', '2021-02-14 06:12:08', '2021-02-14 06:12:08'),
(487, 481, 'Cosmetic mirrors', 'en', '2021-02-14 06:12:21', '2021-02-14 06:12:21'),
(488, 482, 'Cosmetic tweezers', 'en', '2021-02-14 06:12:36', '2021-02-14 06:12:36'),
(489, 483, 'Little things for makeup', 'en', '2021-02-14 06:12:55', '2021-02-14 06:12:55'),
(490, 484, 'Eyelashes and glue', 'en', '2021-02-14 06:13:11', '2021-02-14 06:13:11'),
(491, 485, 'Eyelash Clips & Combs', 'en', '2021-02-14 06:13:32', '2021-02-14 06:13:32'),
(492, 486, 'Hair brushes and accessories', 'en', '2021-02-14 06:13:48', '2021-02-14 06:13:48'),
(493, 487, 'Combs & Hair Accessories', 'en', '2021-02-14 06:14:04', '2021-02-14 06:14:04'),
(494, 488, 'Facial Rollers', 'en', '2021-02-14 06:14:24', '2021-02-14 06:14:24'),
(495, 489, 'Body Rollers', 'en', '2021-02-14 06:15:04', '2021-02-14 06:15:04'),
(496, 490, 'For manicure and pedicure', 'en', '2021-02-14 06:15:58', '2021-02-14 06:15:58'),
(497, 491, 'Magnifying lamps', 'en', '2021-02-14 06:16:20', '2021-02-14 06:16:20'),
(498, 492, 'For hairdresser', 'en', '2021-02-14 06:17:03', '2021-02-14 06:17:03'),
(499, 493, 'Curlers', 'en', '2021-02-14 06:17:47', '2021-02-14 06:17:47'),
(500, 494, 'For cosmetologists and masseurs', 'en', '2021-02-14 06:18:00', '2021-02-14 06:18:00'),
(501, 495, 'Nail care', 'en', '2021-02-14 06:20:39', '2021-02-14 06:20:39'),
(502, 496, 'Tools and devices for manicure and pedicure', 'en', '2021-02-14 06:21:01', '2021-02-14 06:21:01'),
(503, 497, 'Nail coloring', 'en', '2021-02-14 06:21:14', '2021-02-14 06:21:14'),
(504, 498, 'Nail care', 'en', '2021-02-14 06:21:28', '2021-02-14 06:21:28'),
(505, 499, 'Hand care', 'en', '2021-02-14 06:21:49', '2021-02-14 06:21:49'),
(506, 500, 'Feet care', 'en', '2021-02-14 06:22:08', '2021-02-14 06:22:08'),
(507, 501, 'Extension of nails', 'en', '2021-02-14 06:22:42', '2021-02-14 06:22:42'),
(508, 502, 'Nail design', 'en', '2021-02-14 06:23:04', '2021-02-14 06:23:04'),
(509, 503, 'For beauty salons', 'en', '2021-02-14 06:23:29', '2021-02-14 06:23:29'),
(510, 504, 'For manicure and pedicure', 'en', '2021-02-14 06:23:42', '2021-02-14 06:23:42'),
(511, 505, 'For hairdressers and barbers', 'en', '2021-02-14 06:23:54', '2021-02-14 06:23:54'),
(512, 506, 'For cosmetologists', 'en', '2021-02-14 06:24:13', '2021-02-14 06:24:13'),
(513, 507, 'Sterilization', 'en', '2021-02-14 06:24:36', '2021-02-14 06:24:36'),
(514, 508, 'Tattoo equipment', 'en', '2021-02-14 06:24:58', '2021-02-14 06:24:58'),
(515, 509, 'Tattoo Supplies', 'en', '2021-02-14 06:25:13', '2021-02-14 06:25:13'),
(516, 510, 'Supplies and equipment for tattooing', 'en', '2021-02-14 06:25:34', '2021-02-14 06:25:34'),
(517, 511, 'Supplies and equipment for tattooing', 'en', '2021-02-14 06:25:55', '2021-02-14 06:25:55'),
(518, 512, 'Henna and stencils for mehendi', 'en', '2021-02-14 06:26:14', '2021-02-14 06:26:14'),
(519, 513, 'Beauty cases', 'en', '2021-02-14 06:26:36', '2021-02-14 06:26:36'),
(520, 514, 'Toilet paper and wadding', 'en', '2021-02-14 06:27:02', '2021-02-14 06:27:02'),
(521, 515, 'Toilet paper and towels', 'en', '2021-02-14 06:27:13', '2021-02-14 06:27:13'),
(522, 516, 'Wet wipes', 'en', '2021-02-14 06:27:25', '2021-02-14 06:27:25'),
(523, 517, 'Paper napkins', 'en', '2021-02-14 06:27:42', '2021-02-14 06:27:42'),
(524, 518, 'Cotton buds and discs', 'en', '2021-02-14 06:27:59', '2021-02-14 06:27:59'),
(525, 519, 'Feminine hygiene', 'en', '2021-02-14 06:28:20', '2021-02-14 06:28:20'),
(526, 520, 'Pads and tampons', 'en', '2021-02-14 06:28:31', '2021-02-14 06:28:31'),
(527, 521, 'Товары для интимной гигиены', 'en', '2021-02-14 06:28:50', '2021-02-15 03:07:54'),
(528, 522, 'Urological pads', 'en', '2021-02-14 06:29:05', '2021-02-14 06:29:05'),
(529, 523, 'Liners for clothes', 'en', '2021-02-14 06:29:22', '2021-02-14 06:29:22'),
(531, 420, 'Аксессуары', 'ru', '2021-02-15 01:57:12', '2021-02-15 02:06:50'),
(538, 455, 'Мужской', 'ru', '2021-02-15 02:04:30', '2021-02-15 02:04:30'),
(539, 452, 'Аксессуары', 'ru', '2021-02-15 02:08:42', '2021-02-15 02:08:42'),
(540, 460, 'Аксессуары для бороды и усов', 'ru', '2021-02-15 02:10:41', '2021-02-15 02:10:41'),
(541, 478, 'Аксессуары для электробритв и эпиляторов', 'ru', '2021-02-15 02:14:16', '2021-02-15 02:14:16'),
(542, 251, 'Антивозрастная косметика', 'ru', '2021-02-15 02:15:15', '2021-02-15 02:15:15'),
(543, 442, 'Антицеллюлитные и модельные продукты', 'ru', '2021-02-15 02:15:50', '2021-02-15 02:15:50'),
(544, 430, 'Бальзамы и полоскания', 'ru', '2021-02-15 02:16:25', '2021-02-15 02:16:25'),
(545, 423, 'Кремы BB, CC и DD', 'ru', '2021-02-15 02:17:38', '2021-02-15 02:17:38'),
(546, 221, 'Красота и гигиена', 'ru', '2021-02-15 02:18:50', '2021-02-15 02:18:50'),
(547, 513, 'Косметички', 'ru', '2021-02-15 02:19:24', '2021-02-15 02:19:24'),
(548, 450, 'Устройства по уходу за телом', 'ru', '2021-02-15 02:21:11', '2021-02-15 02:21:11'),
(549, 467, 'Техника красоты', 'ru', '2021-02-15 02:22:22', '2021-02-15 02:22:22'),
(550, 437, 'Уход за телом', 'ru', '2021-02-15 02:23:42', '2021-02-15 02:23:42'),
(551, 476, 'Устройства по уходу за телом', 'ru', '2021-02-15 02:24:20', '2021-02-15 02:24:20'),
(552, 489, 'Ролики для тела', 'ru', '2021-02-15 02:24:56', '2021-02-15 02:24:56'),
(553, 459, 'Уход за бородой и усами', 'ru', '2021-02-15 02:25:42', '2021-02-15 02:25:42'),
(554, 245, 'Уход за кожей вокруг глаз', 'ru', '2021-02-15 02:26:16', '2021-02-15 02:26:16'),
(555, 242, 'Очищение и снятие макияжа', 'ru', '2021-02-15 02:26:56', '2021-02-15 02:26:56'),
(556, 433, 'Окраска', 'ru', '2021-02-15 02:27:32', '2021-02-15 02:27:32'),
(557, 487, 'Расчески и аксессуары для волос', 'ru', '2021-02-15 02:28:02', '2021-02-15 02:28:02'),
(558, 435, 'Расчески и щетки', 'ru', '2021-02-15 02:28:53', '2021-02-15 02:28:53'),
(559, 481, 'Косметические зеркала', 'ru', '2021-02-15 02:29:27', '2021-02-15 02:29:27'),
(560, 482, 'Пинцет косметический', 'ru', '2021-02-15 02:30:01', '2021-02-15 02:30:01'),
(561, 518, 'Ватные палочки и диски', 'ru', '2021-02-15 02:30:34', '2021-02-15 02:30:34'),
(562, 438, 'Кремы и лосьоны', 'ru', '2021-02-15 02:34:23', '2021-02-15 02:34:23'),
(563, 244, 'Кремы и сыворотки', 'ru', '2021-02-15 02:37:42', '2021-02-15 02:37:42'),
(564, 493, 'Бигуди', 'ru', '2021-02-15 02:38:20', '2021-02-15 02:38:20'),
(565, 436, 'Устройства для стрижки и укладки', 'ru', '2021-02-15 02:39:20', '2021-02-15 02:39:20'),
(566, 464, 'Дезодоранты', 'ru', '2021-02-15 02:39:51', '2021-02-15 02:39:51'),
(567, 440, 'Дезодоранты для мужчин', 'ru', '2021-02-15 02:40:40', '2021-02-15 02:40:40'),
(568, 439, 'Дезодоранты для женщин', 'ru', '2021-02-15 02:41:29', '2021-02-15 02:41:29'),
(569, 441, 'Удаление волос', 'ru', '2021-02-15 02:42:05', '2021-02-15 02:42:05'),
(570, 431, 'Сухие шампуни', 'ru', '2021-02-15 02:42:37', '2021-02-15 02:42:37'),
(571, 470, 'Бигуди электрические', 'ru', '2021-02-15 02:43:09', '2021-02-15 02:43:09'),
(572, 474, 'Электрические щетки для лица', 'ru', '2021-02-15 02:43:51', '2021-02-15 02:43:51'),
(573, 471, 'Эпиляторы', 'ru', '2021-02-15 02:44:29', '2021-02-15 02:44:29'),
(574, 454, 'Эфирные масла и аксессуары', 'ru', '2021-02-15 02:45:35', '2021-02-15 02:45:35'),
(575, 501, 'Наращивание ногтей', 'ru', '2021-02-15 02:46:13', '2021-02-15 02:46:13'),
(576, 485, 'Зажимы и расчески для ресниц', 'ru', '2021-02-15 02:47:09', '2021-02-15 02:47:09'),
(577, 484, 'Ресницы и клей', 'ru', '2021-02-15 02:47:45', '2021-02-15 02:47:45'),
(578, 461, 'Уход за лицом', 'ru', '2021-02-15 02:48:30', '2021-02-15 02:48:30'),
(579, 241, 'Уход за лицом', 'ru', '2021-02-15 02:49:02', '2021-02-15 02:49:02'),
(580, 475, 'Приборы для ухода за лицом', 'ru', '2021-02-15 02:49:46', '2021-02-15 02:49:46'),
(581, 254, 'Приборы для ухода за лицом', 'ru', '2021-02-15 02:50:17', '2021-02-15 02:50:17'),
(582, 488, 'Валики для лица', 'ru', '2021-02-15 02:50:52', '2021-02-15 02:50:52'),
(583, 500, 'Уход за ногами', 'ru', '2021-02-15 02:51:29', '2021-02-15 02:51:29'),
(584, 519, 'Женская гигиена', 'ru', '2021-02-15 02:52:56', '2021-02-15 02:52:56'),
(585, 448, 'Пена, соль, масло', 'ru', '2021-02-15 02:53:31', '2021-02-15 02:53:31'),
(586, 503, 'Для салонов красоты', 'ru', '2021-02-15 02:54:12', '2021-02-15 02:54:12'),
(587, 506, 'Для косметологов', 'ru', '2021-02-15 02:55:03', '2021-02-15 02:55:03'),
(588, 494, 'Для косметологов и массажистов', 'ru', '2021-02-15 02:55:37', '2021-02-15 02:55:37'),
(589, 419, 'Для бровей', 'ru', '2021-02-15 02:56:24', '2021-02-15 02:56:24'),
(590, 418, 'Для глаз', 'ru', '2021-02-15 02:57:09', '2021-02-15 02:57:09'),
(591, 411, 'Для лица', 'ru', '2021-02-15 02:57:45', '2021-02-15 02:57:45'),
(592, 462, 'Для волос', 'ru', '2021-02-15 02:58:16', '2021-02-15 02:58:16'),
(593, 492, 'Парикмахерам', 'ru', '2021-02-15 02:58:46', '2021-02-15 02:58:46'),
(594, 505, 'Для парикмахеров и парикмахеров', 'ru', '2021-02-15 02:59:31', '2021-02-15 02:59:31'),
(595, 446, 'Для рук', 'ru', '2021-02-15 03:00:11', '2021-02-15 03:00:11'),
(596, 445, 'Для ног', 'ru', '2021-02-15 03:00:48', '2021-02-15 03:00:48'),
(597, 232, 'Для губ', 'ru', '2021-02-15 03:01:19', '2021-02-15 03:01:19'),
(598, 490, 'Для маникюра и педикюра', 'ru', '2021-02-15 03:01:54', '2021-02-15 03:01:54'),
(599, 504, 'Для маникюра и педикюра', 'ru', '2021-02-15 03:02:23', '2021-02-15 03:02:23'),
(600, 447, 'Для душа', 'ru', '2021-02-15 03:03:09', '2021-02-15 03:03:09'),
(601, 389, 'Подарочные наборы', 'ru', '2021-02-15 03:03:41', '2021-02-15 03:03:41'),
(602, 486, 'Расчески и аксессуары для волос', 'ru', '2021-02-15 03:04:20', '2021-02-15 03:04:20'),
(603, 428, 'Уход за волосами', 'ru', '2021-02-15 03:05:01', '2021-02-15 03:05:01'),
(604, 468, 'Фены и фены', 'ru', '2021-02-15 03:05:47', '2021-02-15 03:05:47'),
(605, 499, 'Уход за руками', 'ru', '2021-02-15 03:06:30', '2021-02-15 03:06:30'),
(606, 512, 'Хна и трафареты для мехенди', 'ru', '2021-02-15 03:07:26', '2021-02-15 03:07:26'),
(607, 521, 'Товары для интимной гигиены', 'ru', '2021-02-15 03:09:47', '2021-02-15 03:09:47'),
(608, 523, 'Вкладыши для одежды', 'ru', '2021-02-15 03:10:54', '2021-02-15 03:10:54'),
(609, 422, 'Уход за губами', 'ru', '2021-02-15 03:11:24', '2021-02-15 03:11:24'),
(610, 483, 'Мелочи для макияжа', 'ru', '2021-02-15 03:11:57', '2021-02-15 03:11:57'),
(611, 386, 'Роскошь', 'ru', '2021-02-15 03:12:35', '2021-02-15 03:12:35'),
(612, 491, 'Увеличительные лампы', 'ru', '2021-02-15 03:13:10', '2021-02-15 03:13:10'),
(613, 405, 'Макияж, мириться', 'ru', '2021-02-15 03:13:45', '2021-02-15 03:13:45'),
(614, 480, 'Кисти для макияжа, спонжи', 'ru', '2021-02-15 03:14:24', '2021-02-15 03:14:24'),
(615, 246, 'Маски', 'ru', '2021-02-15 03:14:52', '2021-02-15 03:14:52'),
(616, 432, 'Маски и сыворотки', 'ru', '2021-02-15 03:15:20', '2021-02-15 03:15:20'),
(617, 224, 'Мужской', 'ru', '2021-02-15 03:15:55', '2021-02-15 03:15:55'),
(618, 495, 'Уход за ногтями', 'ru', '2021-02-15 03:16:29', '2021-02-15 03:16:29'),
(619, 498, 'Уход за ногтями', 'ru', '2021-02-15 03:17:14', '2021-02-15 03:17:14'),
(620, 497, 'Окрашивание ногтей', 'ru', '2021-02-15 03:17:49', '2021-02-15 03:17:49'),
(621, 502, 'Дизайн ногтей', 'ru', '2021-02-15 03:18:34', '2021-02-15 03:18:34'),
(622, 257, 'Натуральная косметика', 'ru', '2021-02-15 03:19:17', '2021-02-15 03:19:17'),
(623, 421, 'Натуральная косметика', 'ru', '2021-02-15 03:19:50', '2021-02-15 03:19:50'),
(624, 426, 'Натуральная косметика', 'ru', '2021-02-15 03:20:23', '2021-02-15 03:20:23'),
(625, 427, 'Натуральная косметика', 'ru', '2021-02-15 03:20:46', '2021-02-15 03:20:46'),
(626, 226, 'Ниша', 'ru', '2021-02-15 03:21:28', '2021-02-15 03:21:28'),
(627, 250, 'Ночной уход', 'ru', '2021-02-15 03:22:00', '2021-02-15 03:22:00'),
(628, 473, 'Забота о полости рта', 'ru', '2021-02-15 03:22:34', '2021-02-15 03:22:34'),
(629, 520, 'Прокладки и тампоны', 'ru', '2021-02-15 03:24:30', '2021-02-15 03:24:30'),
(630, 517, 'Бумажные салфетки', 'ru', '2021-02-15 03:24:58', '2021-02-15 03:24:58'),
(631, 465, 'Парфюмерия', 'ru', '2021-02-15 03:25:28', '2021-02-15 03:25:28'),
(632, 222, 'Парфюмерия', 'ru', '2021-02-15 03:25:53', '2021-02-15 03:25:53'),
(633, 238, 'Аптечная косметика', 'ru', '2021-02-15 03:26:28', '2021-02-15 03:26:28'),
(634, 252, 'Проблемная кожа', 'ru', '2021-02-15 03:27:03', '2021-02-15 03:27:03'),
(635, 240, 'Профессиональный макияж', 'ru', '2021-02-15 03:27:46', '2021-02-15 03:27:46'),
(636, 456, 'Бритвы и лезвия', 'ru', '2021-02-15 03:28:19', '2021-02-15 03:28:19'),
(637, 236, 'Удаление макияжа', 'ru', '2021-02-15 03:28:52', '2021-02-15 03:28:52'),
(638, 247, 'Скрабы и пилинги', 'ru', '2021-02-15 03:29:29', '2021-02-15 03:29:29'),
(639, 424, 'Наборы', 'ru', '2021-02-15 03:30:07', '2021-02-15 03:30:07'),
(640, 466, 'Наборы', 'ru', '2021-02-15 03:30:29', '2021-02-15 03:30:29'),
(641, 235, 'Наборы', 'ru', '2021-02-15 03:30:52', '2021-02-15 03:30:52'),
(642, 429, 'Шампуни', 'ru', '2021-02-15 03:31:28', '2021-02-15 03:31:28'),
(643, 457, 'Бритвы', 'ru', '2021-02-15 03:32:01', '2021-02-15 03:32:01'),
(644, 472, 'Бритвы', 'ru', '2021-02-15 03:32:24', '2021-02-15 03:32:24'),
(645, 458, 'Средства для бритья', 'ru', '2021-02-15 03:32:52', '2021-02-15 03:32:52'),
(646, 463, 'Товары для душа', 'ru', '2021-02-15 03:33:31', '2021-02-15 03:33:31'),
(647, 443, 'Уход за кожей при беременности', 'ru', '2021-02-15 03:33:59', '2021-02-15 03:33:59'),
(648, 449, 'Мыло', 'ru', '2021-02-15 03:34:30', '2021-02-15 03:34:30'),
(649, 507, 'Стерилизация', 'ru', '2021-02-15 03:35:06', '2021-02-15 03:35:06'),
(650, 434, 'Укладка и укладка', 'ru', '2021-02-15 03:35:39', '2021-02-15 03:35:39'),
(651, 253, 'защита от солнца', 'ru', '2021-02-15 03:36:15', '2021-02-15 03:36:15'),
(652, 510, 'Расходные материалы и оборудование для татуажа', 'ru', '2021-02-15 03:36:49', '2021-02-15 03:36:49'),
(653, 511, 'Расходные материалы и оборудование для татуажа', 'ru', '2021-02-15 03:37:30', '2021-02-15 03:37:30'),
(654, 444, 'Загар и защита от солнца', 'ru', '2021-02-15 03:38:03', '2021-02-15 03:38:03'),
(655, 508, 'Тату-оборудование', 'ru', '2021-02-15 03:38:30', '2021-02-15 03:38:30'),
(656, 509, 'Татуировки', 'ru', '2021-02-15 03:38:58', '2021-02-15 03:39:21'),
(657, 515, 'Туалетная бумага и полотенца', 'ru', '2021-02-15 03:39:50', '2021-02-15 03:39:50'),
(658, 514, 'Туалетная бумага и вата', 'ru', '2021-02-15 03:40:26', '2021-02-15 03:40:26'),
(659, 469, 'Щипцы, щипцы для завивки и выпрямители', 'ru', '2021-02-15 03:41:02', '2021-02-15 03:41:02'),
(660, 243, 'Тонировка', 'ru', '2021-02-15 03:41:30', '2021-02-15 03:41:30'),
(661, 479, 'Инструменты и аксессуары', 'ru', '2021-02-15 03:42:31', '2021-02-15 03:42:31'),
(662, 496, 'Инструменты и приспособления для маникюра и педикю', 'ru', '2021-02-15 03:42:59', '2021-02-15 03:42:59'),
(663, 256, 'Дорожные флаконы', 'ru', '2021-02-15 03:43:27', '2021-02-15 03:43:27'),
(664, 453, 'Бритвы и лезвия для женщин', 'ru', '2021-02-15 03:44:07', '2021-02-15 03:44:07'),
(665, 223, 'Женщины', 'ru', '2021-02-15 03:44:39', '2021-02-15 03:44:39'),
(666, 516, 'Влажные салфетки', 'ru', '2021-02-15 03:45:26', '2021-02-15 03:45:26'),
(667, 425, 'Дорожные флаконы', 'ru', '2021-02-15 03:45:52', '2021-02-15 03:45:52'),
(668, 451, 'Мочалки и щетки', 'ru', '2021-02-15 03:46:51', '2021-02-15 03:46:51'),
(669, 225, 'Унисекс', 'ru', '2021-02-15 03:47:48', '2021-02-15 03:47:48'),
(670, 522, 'Прокладки урологические', 'ru', '2021-02-15 03:48:16', '2021-02-15 03:48:16'),
(671, 477, 'Воскоплав и парафиновые ванны', 'ru', '2021-02-15 03:48:54', '2021-02-15 03:48:54'),
(672, 531, 'Товары для дома и сада', 'en', '2021-02-15 04:28:49', '2021-02-15 04:28:49'),
(673, 532, 'Посуда', 'en', '2021-02-15 04:29:44', '2021-02-15 04:29:44'),
(674, 533, 'Посуда для приготовления', 'en', '2021-02-15 04:32:03', '2021-02-15 04:32:03'),
(675, 534, 'Столовые приборы', 'en', '2021-02-15 06:36:04', '2021-02-15 06:36:04'),
(676, 535, 'Детская посуда', 'en', '2021-02-15 06:36:52', '2021-02-15 06:36:52'),
(677, 536, 'Садовая мебель', 'en', '2021-02-15 06:38:08', '2021-02-15 06:38:08'),
(678, 537, 'Чайники и кофейники', 'en', '2021-02-15 06:38:29', '2021-02-15 06:38:29'),
(679, 538, 'Бар', 'en', '2021-02-15 06:38:45', '2021-02-15 06:38:45'),
(680, 539, 'Хранение продуктов', 'en', '2021-02-15 06:39:00', '2021-02-15 06:39:00'),
(681, 540, 'Термосы и термокружки', 'en', '2021-02-15 06:39:18', '2021-02-15 06:39:18'),
(683, 542, 'Одноразовая посуда', 'en', '2021-02-15 06:41:39', '2021-02-15 06:41:39'),
(684, 543, 'Товары для консервирования', 'en', '2021-02-15 06:42:05', '2021-02-15 06:42:05'),
(685, 544, 'Ножи и разделочные доски', 'en', '2021-02-15 06:42:20', '2021-02-15 06:42:20'),
(686, 545, 'Кухонные принадлежности', 'en', '2021-02-15 06:42:31', '2021-02-15 06:42:31'),
(687, 546, 'Кухонный текстиль', 'en', '2021-02-15 06:42:47', '2021-02-15 06:42:47'),
(688, 547, 'Фильтры для воды', 'en', '2021-02-15 06:43:07', '2021-02-15 06:43:07'),
(689, 548, 'Декоративная посуда', 'en', '2021-02-15 06:43:21', '2021-02-15 06:43:21'),
(690, 549, 'Текстиль', 'en', '2021-02-15 06:44:12', '2021-02-15 06:44:12'),
(691, 550, 'Шторы и карнизы', 'en', '2021-02-15 06:45:43', '2021-02-15 06:45:43'),
(692, 551, 'Постельное белье', 'en', '2021-02-15 06:45:56', '2021-02-15 06:45:56'),
(693, 552, 'Одеяла', 'en', '2021-02-15 06:46:10', '2021-02-15 06:46:10'),
(694, 553, 'Подушки', 'en', '2021-02-15 06:46:26', '2021-02-15 06:46:26'),
(695, 554, 'Пледы и покрывала', 'en', '2021-02-15 06:46:36', '2021-02-15 06:46:36'),
(696, 555, 'Полотенца', 'en', '2021-02-15 06:46:49', '2021-02-15 06:46:49'),
(697, 556, 'Кухонный текстиль', 'en', '2021-02-15 06:47:02', '2021-02-15 06:47:02'),
(698, 557, 'Наматрасники и чехлы для матрасов', 'en', '2021-02-15 06:47:13', '2021-02-15 06:47:13'),
(699, 558, 'Текстиль с электроподогревом', 'en', '2021-02-15 06:47:24', '2021-02-15 06:47:24'),
(700, 559, 'Чехлы для мебели', 'en', '2021-02-15 06:47:33', '2021-02-15 06:47:33'),
(701, 560, 'Чехлы для мебели', 'en', '2021-02-15 06:48:41', '2021-02-15 06:48:41'),
(702, 561, 'Ковры и ковровые дорожки', 'en', '2021-02-15 06:49:03', '2021-02-15 06:49:03'),
(703, 562, 'Ткани', 'en', '2021-02-15 06:49:17', '2021-02-15 06:49:17'),
(704, 563, 'Мебель и аксессуары', 'en', '2021-02-15 06:49:26', '2021-02-15 06:49:26'),
(705, 564, 'Мягкая мебель', 'en', '2021-02-15 06:49:47', '2021-02-15 06:49:47'),
(706, 565, 'Дача и сад', 'en', '2021-02-15 06:49:53', '2021-02-15 06:49:53'),
(707, 566, 'Отдых и пикник', 'en', '2021-02-15 06:50:11', '2021-02-15 06:50:11'),
(708, 567, 'Кресла-мешки', 'en', '2021-02-15 06:50:11', '2021-02-15 06:50:11'),
(709, 568, 'Садовый инструмент', 'en', '2021-02-15 06:51:06', '2021-02-15 06:51:06'),
(710, 569, 'Садовая техника', 'en', '2021-02-15 06:51:19', '2021-02-15 06:51:19'),
(711, 570, 'Компьютерные кресла', 'en', '2021-02-15 06:51:23', '2021-02-15 06:51:23'),
(712, 571, 'Насосы для дачи', 'en', '2021-02-15 06:51:31', '2021-02-15 06:51:31'),
(713, 572, 'Садовый декор', 'en', '2021-02-15 06:51:44', '2021-02-15 06:51:44'),
(714, 573, 'Биотуалеты и септики', 'en', '2021-02-15 06:51:56', '2021-02-15 06:51:56'),
(715, 574, 'Кресла', 'en', '2021-02-15 06:52:08', '2021-02-15 06:52:08'),
(716, 575, 'Души и рукомойники', 'en', '2021-02-15 06:52:15', '2021-02-15 06:52:15'),
(717, 576, 'Пуфики и банкетки', 'en', '2021-02-15 06:52:28', '2021-02-15 06:52:28'),
(718, 577, 'Парники и теплицы', 'en', '2021-02-15 06:52:29', '2021-02-15 06:52:29'),
(719, 578, 'Бассейны для дачи', 'en', '2021-02-15 06:52:42', '2021-02-15 06:52:42'),
(720, 579, 'Кровати и матрасы', 'en', '2021-02-15 06:52:56', '2021-02-15 06:52:56'),
(721, 580, 'Водоотвод и дренаж', 'en', '2021-02-15 06:52:57', '2021-02-15 06:52:57'),
(722, 581, 'Уборка снега', 'en', '2021-02-15 06:53:19', '2021-02-15 06:53:19'),
(723, 582, 'Диваны', 'en', '2021-02-15 06:53:21', '2021-02-15 06:53:21'),
(724, 583, 'Хозблоки и сараи', 'en', '2021-02-15 06:53:33', '2021-02-15 06:53:33'),
(725, 584, 'Заборы и ограждения', 'en', '2021-02-15 06:53:45', '2021-02-15 06:53:45'),
(726, 585, 'Раскладушки', 'en', '2021-02-15 06:53:48', '2021-02-15 06:53:48'),
(727, 586, 'Декор и интерьер', 'en', '2021-02-15 06:54:16', '2021-02-15 06:54:16'),
(728, 587, 'Шторы и портьеры', 'en', '2021-02-15 06:54:58', '2021-02-15 06:54:58'),
(729, 588, 'Комплекты мягкой мебели', 'en', '2021-02-15 06:55:00', '2021-02-15 06:55:00'),
(730, 589, 'Фоторамки и фотоальбомы', 'en', '2021-02-15 06:55:12', '2021-02-15 06:55:12'),
(731, 590, 'Ароматы для дома', 'en', '2021-02-15 06:55:33', '2021-02-15 06:55:33'),
(732, 591, 'Оформление интерьера', 'en', '2021-02-15 06:55:48', '2021-02-15 06:55:48'),
(733, 592, 'Держатели, подставки и подносы', 'en', '2021-02-15 06:56:02', '2021-02-15 06:56:02'),
(734, 593, 'Столы и стулья', 'en', '2021-02-15 06:56:14', '2021-02-15 06:56:14'),
(735, 594, 'Зеркала', 'en', '2021-02-15 06:56:17', '2021-02-15 06:56:17'),
(736, 595, 'Иконы', 'en', '2021-02-15 06:56:33', '2021-02-15 06:56:33'),
(737, 596, 'Компьютерные и письменные столы', 'en', '2021-02-15 06:56:44', '2021-02-15 06:56:44'),
(738, 597, 'Картины и панно', 'en', '2021-02-15 06:56:49', '2021-02-15 06:56:49'),
(739, 598, 'Ковры и ковровые дорожки', 'en', '2021-02-15 06:57:04', '2021-02-15 06:57:04'),
(740, 599, 'Столы и столики', 'en', '2021-02-15 06:57:17', '2021-02-15 06:57:17'),
(741, 600, 'Копилки', 'en', '2021-02-15 06:57:18', '2021-02-15 06:57:18'),
(742, 601, 'Свечи и подсвечники', 'en', '2021-02-15 06:57:30', '2021-02-15 06:57:30'),
(743, 602, 'Сувениры и подарки', 'en', '2021-02-15 06:57:43', '2021-02-15 06:57:43'),
(744, 603, 'Стулья, табуретки', 'en', '2021-02-15 06:57:50', '2021-02-15 06:57:50'),
(745, 604, 'Таблички, номера и крючки', 'en', '2021-02-15 06:57:56', '2021-02-15 06:57:56'),
(746, 605, 'Барные стулья', 'en', '2021-02-15 06:58:15', '2021-02-15 06:58:15'),
(747, 606, 'Часы и метеостанции', 'en', '2021-02-15 06:58:16', '2021-02-15 06:58:16'),
(748, 607, 'Ритуальные товары', 'en', '2021-02-15 06:58:33', '2021-02-15 06:58:33'),
(749, 608, 'Журнальные столы', 'en', '2021-02-15 06:58:38', '2021-02-15 06:58:38'),
(750, 609, 'Хозяйственные товары', 'en', '2021-02-15 06:58:57', '2021-02-15 06:58:57'),
(751, 610, 'Банкетки и скамьи', 'en', '2021-02-15 06:59:14', '2021-02-15 06:59:14'),
(752, 611, 'Бумажная продукция для дома', 'en', '2021-02-15 06:59:20', '2021-02-15 06:59:20'),
(753, 612, 'Инвентарь для уборки', 'en', '2021-02-15 06:59:34', '2021-02-15 06:59:34'),
(754, 613, 'Туалетные столики и консоли', 'en', '2021-02-15 06:59:39', '2021-02-15 06:59:39'),
(755, 614, 'Мусорные ведра и баки', 'en', '2021-02-15 06:59:47', '2021-02-15 06:59:47'),
(756, 615, 'Подставки под ноги', 'en', '2021-02-15 07:00:00', '2021-02-15 07:00:00'),
(757, 616, 'Аксессуары для стирки', 'en', '2021-02-15 07:00:00', '2021-02-15 07:00:00'),
(758, 617, 'Уход за одеждой и обувью', 'en', '2021-02-15 07:00:14', '2021-02-15 07:00:14'),
(759, 618, 'Надстройки', 'en', '2021-02-15 07:00:23', '2021-02-15 07:00:23'),
(760, 619, 'Аксессуары для ванной', 'en', '2021-02-15 07:00:26', '2021-02-15 07:00:26'),
(761, 620, 'Безмены', 'en', '2021-02-15 07:00:41', '2021-02-15 07:00:41'),
(762, 621, 'Сумки хозяйственные', 'en', '2021-02-15 07:00:55', '2021-02-15 07:00:55'),
(763, 622, 'Сумки-тележки', 'en', '2021-02-15 07:01:19', '2021-02-15 07:01:19'),
(764, 623, 'Лестницы', 'en', '2021-02-15 07:01:37', '2021-02-15 07:01:37'),
(765, 624, 'Шкафы, тумбы и комоды', 'en', '2021-02-15 07:01:40', '2021-02-15 07:01:40'),
(766, 625, 'Упаковка и переезд', 'en', '2021-02-15 07:01:53', '2021-02-15 07:01:53'),
(767, 626, 'Вешалки в прихожую', 'en', '2021-02-15 07:02:17', '2021-02-15 07:02:17'),
(768, 627, 'Хранение вещей', 'en', '2021-02-15 07:02:28', '2021-02-15 07:02:28'),
(769, 628, 'Вешалки', 'en', '2021-02-15 07:02:50', '2021-02-15 07:02:50'),
(770, 629, 'Прихожие готовый комплект', 'en', '2021-02-15 07:02:56', '2021-02-15 07:02:56'),
(771, 630, 'Гостиные готовый комплект', 'en', '2021-02-15 07:03:23', '2021-02-15 07:03:23'),
(772, 631, 'Гардеробы', 'en', '2021-02-15 07:04:09', '2021-02-15 07:04:09'),
(773, 632, 'Комоды', 'en', '2021-02-15 07:04:26', '2021-02-15 07:04:26'),
(774, 633, 'Обувницы', 'en', '2021-02-15 07:05:19', '2021-02-15 07:05:19'),
(775, 634, 'Вакуумные пакеты', 'en', '2021-02-15 07:08:45', '2021-02-15 07:08:45'),
(776, 635, 'Чехлы для одежды', 'en', '2021-02-15 07:10:59', '2021-02-15 07:10:59'),
(777, 636, 'Чехлы для обуви', 'en', '2021-02-15 08:02:05', '2021-02-15 08:02:05'),
(778, 637, 'Коробки и контейнеры', 'en', '2021-02-15 08:03:29', '2021-02-15 08:03:29'),
(779, 638, 'Баки для белья', 'en', '2021-02-15 08:03:59', '2021-02-15 08:03:59'),
(780, 639, 'Органайзеры и разделители', 'en', '2021-02-15 08:04:50', '2021-02-15 08:04:50'),
(781, 640, 'Подставки для зонтов', 'en', '2021-02-15 08:05:41', '2021-02-15 08:05:41'),
(782, 641, 'Освещение', 'en', '2021-02-15 08:06:09', '2021-02-15 08:06:09'),
(783, 642, 'Ночники', 'en', '2021-02-15 08:06:36', '2021-02-15 08:06:36'),
(784, 643, 'Ночники', 'en', '2021-02-15 08:06:47', '2021-02-15 08:06:47'),
(785, 644, 'Интерьерная подсветка', 'en', '2021-02-15 08:07:20', '2021-02-15 08:07:20'),
(786, 645, 'Торшеры и напольные светильники', 'en', '2021-02-15 08:08:03', '2021-02-15 08:08:03'),
(787, 646, 'Стойки ресепшн', 'en', '2021-02-15 08:08:06', '2021-02-15 08:08:06'),
(788, 647, 'Тумбы', 'en', '2021-02-15 08:08:30', '2021-02-15 08:08:30'),
(789, 648, 'Настенные светильники', 'en', '2021-02-15 08:08:34', '2021-02-15 08:08:34'),
(790, 649, 'Люстры и потолочные светильники', 'en', '2021-02-15 08:08:57', '2021-02-15 08:08:57'),
(791, 650, 'Шкафы', 'en', '2021-02-15 08:09:03', '2021-02-15 08:09:03'),
(792, 651, 'Шкафы складные', 'en', '2021-02-15 08:09:30', '2021-02-15 08:09:30'),
(793, 652, 'Настенно-потолочные светильники', 'en', '2021-02-15 08:09:33', '2021-02-15 08:09:33'),
(794, 653, 'Настенные светильники', 'en', '2021-02-15 08:10:03', '2021-02-15 08:10:03'),
(795, 654, 'Напольные и настольные светильники', 'en', '2021-02-15 08:10:27', '2021-02-15 08:10:27'),
(796, 655, 'Лампочки', 'en', '2021-02-15 08:11:00', '2021-02-15 08:11:00'),
(797, 656, 'Встраиваемые светильники', 'en', '2021-02-15 08:11:41', '2021-02-15 08:11:41'),
(798, 657, 'Полки и стеллажи', 'en', '2021-02-15 08:11:44', '2021-02-15 08:11:44'),
(799, 658, 'Полки', 'en', '2021-02-15 08:12:25', '2021-02-15 08:12:25'),
(800, 659, 'Споты и трек-системы', 'en', '2021-02-15 08:12:30', '2021-02-15 08:12:30'),
(801, 660, 'Стеллажи', 'en', '2021-02-15 08:12:58', '2021-02-15 08:12:58'),
(802, 661, 'Уличное освещение и прожекторы', 'en', '2021-02-15 08:13:00', '2021-02-15 08:13:00'),
(803, 662, 'Этажерки', 'en', '2021-02-15 08:13:20', '2021-02-15 08:13:20'),
(804, 663, 'Управление освещением', 'en', '2021-02-15 08:13:30', '2021-02-15 08:13:30'),
(805, 664, 'Слингополки', 'en', '2021-02-15 08:13:51', '2021-02-15 08:13:51'),
(806, 665, 'Технические светильники', 'en', '2021-02-15 08:14:02', '2021-02-15 08:14:02'),
(807, 666, 'Комплектующие и аксессуары для светильников', 'en', '2021-02-15 08:34:36', '2021-02-15 08:34:36'),
(808, 667, 'Розетки, выключатели и рамки', 'en', '2021-02-15 08:34:58', '2021-02-15 08:34:58'),
(809, 668, 'Розетки, выключатели и рамки', 'en', '2021-02-15 08:35:01', '2021-02-15 08:35:01'),
(810, 669, 'Споты и трековые светильники', 'en', '2021-02-15 08:35:30', '2021-02-15 08:35:30'),
(811, 670, 'Аксессуары для освещения', 'en', '2021-02-15 08:35:54', '2021-02-15 08:35:54'),
(812, 671, 'Светильники для сауны', 'en', '2021-02-15 08:36:14', '2021-02-15 08:36:14'),
(813, 672, 'Аварийные светильники', 'en', '2021-02-15 08:36:34', '2021-02-15 08:36:34'),
(814, 673, 'Светодиодные ленты', 'en', '2021-02-15 08:36:56', '2021-02-15 08:36:56'),
(815, 674, 'Авторские товары ручной работы', 'en', '2021-02-15 08:37:54', '2021-02-15 08:37:54'),
(816, 675, 'Статуэтки', 'en', '2021-02-15 08:38:37', '2021-02-15 08:38:37'),
(817, 676, 'Вазы', 'en', '2021-02-15 08:41:34', '2021-02-15 08:41:34'),
(818, 677, 'Спорт и активный отдых', 'en', '2021-02-15 08:42:30', '2021-02-15 08:42:30'),
(819, 678, 'Картины', 'en', '2021-02-15 08:42:36', '2021-02-15 08:42:36'),
(820, 679, 'Спортивное питание', 'en', '2021-02-15 08:42:55', '2021-02-15 08:42:55'),
(821, 680, 'Протеины', 'en', '2021-02-15 08:43:11', '2021-02-15 08:43:11'),
(822, 681, 'Витамины и минералы', 'en', '2021-02-15 08:43:28', '2021-02-15 08:43:28'),
(823, 682, 'Открытки', 'en', '2021-02-15 08:43:29', '2021-02-15 08:43:29'),
(824, 683, 'Аминокислоты и BCAA', 'en', '2021-02-15 08:43:48', '2021-02-15 08:43:48'),
(825, 684, 'Украшения', 'en', '2021-02-15 08:43:55', '2021-02-15 08:43:55'),
(826, 685, 'Протеиновые батончики', 'en', '2021-02-15 08:44:04', '2021-02-15 08:44:04'),
(827, 686, 'Препараты для укрепления связок и суставов', 'en', '2021-02-15 08:44:18', '2021-02-15 08:44:18'),
(828, 687, 'Гейнеры', 'en', '2021-02-15 08:44:31', '2021-02-15 08:44:31'),
(829, 688, 'Креатин', 'en', '2021-02-15 08:44:42', '2021-02-15 08:44:42'),
(830, 689, 'Жиросжигатели', 'en', '2021-02-15 08:44:58', '2021-02-15 08:44:58'),
(831, 690, 'Специальное питание для спортсменов', 'en', '2021-02-15 08:45:11', '2021-02-15 08:45:11'),
(832, 691, 'Шкатулки', 'en', '2021-02-15 08:45:14', '2021-02-15 08:45:14'),
(833, 692, 'Предтренировочные комплексы', 'en', '2021-02-15 08:45:27', '2021-02-15 08:45:27'),
(834, 693, 'Подставки под бутылку', 'en', '2021-02-15 08:45:47', '2021-02-15 08:45:47'),
(835, 694, 'Подставки под бутылку', 'en', '2021-02-15 08:46:05', '2021-02-15 08:46:05'),
(836, 695, 'Подставки под бутылку', 'en', '2021-02-15 08:48:39', '2021-02-15 08:48:39'),
(837, 696, 'Панно', 'en', '2021-02-15 08:49:20', '2021-02-15 08:49:20'),
(838, 697, 'Панно', 'en', '2021-02-15 08:50:22', '2021-02-15 08:50:22'),
(839, 698, 'Колокольчики ручной работы', 'en', '2021-02-15 08:51:20', '2021-02-15 08:51:20'),
(840, 699, 'Детская мебель', 'en', '2021-02-15 08:51:32', '2021-02-15 08:51:32'),
(841, 700, 'Авторские работы', 'en', '2021-02-15 08:51:41', '2021-02-15 08:51:41'),
(842, 701, 'Галантерея', 'en', '2021-02-15 08:52:24', '2021-02-15 08:52:24'),
(843, 702, 'Посуда', 'en', '2021-02-15 08:52:54', '2021-02-15 08:52:54'),
(844, 703, 'Кресла и диваны', 'en', '2021-02-15 08:53:01', '2021-02-15 08:53:01'),
(845, 704, 'Колыбели', 'en', '2021-02-15 08:54:26', '2021-02-15 08:54:26'),
(846, 705, 'Игрушки', 'en', '2021-02-15 08:55:08', '2021-02-15 08:55:08'),
(847, 706, 'Парты и столы', 'en', '2021-02-15 08:55:11', '2021-02-15 08:55:11'),
(848, 707, 'Кроватки', 'en', '2021-02-15 08:55:38', '2021-02-15 08:55:38'),
(849, 708, 'Свечи', 'en', '2021-02-15 08:56:07', '2021-02-15 08:56:07'),
(850, 709, 'Наборы детской мебели', 'en', '2021-02-15 08:56:13', '2021-02-15 08:56:13'),
(851, 710, 'Стулья и табуреты', 'en', '2021-02-15 08:57:04', '2021-02-15 08:57:04'),
(852, 711, 'Иконы', 'en', '2021-02-15 08:57:40', '2021-02-15 08:57:40'),
(853, 712, 'Детские готовые комплекты', 'en', '2021-02-15 08:57:51', '2021-02-15 08:57:51'),
(854, 713, 'Текстиль', 'en', '2021-02-15 08:57:54', '2021-02-15 08:57:54'),
(855, 714, 'Корзины', 'en', '2021-02-15 08:58:22', '2021-02-15 08:58:22'),
(856, 715, 'Пеленальные комоды и столики', 'en', '2021-02-15 08:58:28', '2021-02-15 08:58:28'),
(857, 716, 'Товары для бани и сауны', 'en', '2021-02-15 09:05:05', '2021-02-15 09:05:05'),
(858, 717, 'Посттренировочные комплексы', 'en', '2021-02-15 09:05:43', '2021-02-15 09:05:43'),
(859, 718, 'Веники для бань', 'en', '2021-02-15 09:06:02', '2021-02-15 09:06:02'),
(860, 719, 'Тестостероновые бустеры', 'en', '2021-02-15 09:06:05', '2021-02-15 09:06:05'),
(862, 721, 'Шейкеры и бутылки', 'en', '2021-02-15 09:06:21', '2021-02-15 09:06:21'),
(863, 722, 'Банный текстиль', 'en', '2021-02-15 09:06:23', '2021-02-15 09:06:23'),
(864, 723, 'Тренажеры и инвентарь', 'en', '2021-02-15 09:06:41', '2021-02-15 09:06:41'),
(865, 724, 'Собственный вес', 'en', '2021-02-15 09:07:00', '2021-02-15 09:07:00'),
(866, 725, 'Кардиотренажеры', 'en', '2021-02-15 09:07:13', '2021-02-15 09:07:13'),
(867, 726, 'Силовые тренажеры', 'en', '2021-02-15 09:07:34', '2021-02-15 09:07:34'),
(868, 727, 'Ведра и кадки', 'en', '2021-02-15 09:08:01', '2021-02-15 09:08:01'),
(869, 728, 'Шайки и ушаты', 'en', '2021-02-15 09:08:26', '2021-02-15 09:08:26'),
(870, 729, 'Лежаки и шезлонги', 'en', '2021-02-15 09:08:48', '2021-02-15 09:08:48'),
(871, 730, 'Ковши и черпаки', 'en', '2021-02-15 09:08:50', '2021-02-15 09:08:50'),
(872, 731, 'Обливные устройства', 'en', '2021-02-15 09:09:25', '2021-02-15 09:09:25'),
(873, 732, 'Качели и гамаки', 'en', '2021-02-15 09:09:35', '2021-02-15 09:09:35'),
(874, 733, 'Запарки и ароматизаторы', 'en', '2021-02-15 09:09:48', '2021-02-15 09:09:48'),
(875, 734, 'Полки и скамьи', 'en', '2021-02-15 09:10:27', '2021-02-15 09:10:27'),
(876, 735, 'Предметы интерьера бани', 'en', '2021-02-15 09:10:52', '2021-02-15 09:10:52'),
(877, 736, 'Свободные веса', 'en', '2021-02-15 09:10:55', '2021-02-15 09:10:55'),
(878, 737, 'Аксессуары', 'en', '2021-02-15 09:11:10', '2021-02-15 09:11:10'),
(879, 738, 'Виброплатформы', 'en', '2021-02-15 09:11:24', '2021-02-15 09:11:24'),
(880, 739, 'Плетеная мебель', 'en', '2021-02-15 09:11:27', '2021-02-15 09:11:27'),
(881, 740, 'Парогенераторы', 'en', '2021-02-15 09:12:15', '2021-02-15 09:12:15'),
(882, 741, 'Сауны', 'en', '2021-02-15 09:12:31', '2021-02-15 09:12:31'),
(883, 739, 'Плетеная мебель', 'ru', '2021-02-15 09:12:44', '2021-02-15 09:12:44'),
(884, 742, 'Бочки и купели', 'en', '2021-02-15 09:12:56', '2021-02-15 09:12:56'),
(885, 743, 'Дымоходы', 'en', '2021-02-15 09:13:28', '2021-02-15 09:13:28'),
(886, 744, 'Двери', 'en', '2021-02-15 09:14:06', '2021-02-15 09:14:06'),
(887, 745, 'Аксессуары', 'en', '2021-02-15 09:14:38', '2021-02-15 09:14:38'),
(888, 746, 'Надувная мебель и насосы', 'en', '2021-02-15 09:14:39', '2021-02-15 09:14:39'),
(889, 747, 'Камни для печей', 'en', '2021-02-15 09:14:54', '2021-02-15 09:14:54'),
(890, 748, 'Банные печи', 'en', '2021-02-15 09:15:24', '2021-02-15 09:15:24'),
(891, 749, 'Соль для бани', 'en', '2021-02-15 09:15:43', '2021-02-15 09:15:43'),
(892, 750, 'Комплекты садовой мебели', 'en', '2021-02-15 09:16:51', '2021-02-15 09:16:51'),
(893, 751, 'Цветы и растения', 'en', '2021-02-15 09:17:01', '2021-02-15 09:17:01'),
(894, 752, 'Цветы, букеты, композиции', 'en', '2021-02-15 09:17:25', '2021-02-15 09:17:25'),
(895, 753, 'Семена и саженцы', 'en', '2021-02-15 09:17:43', '2021-02-15 09:17:43'),
(896, 754, 'Комнатные растения', 'en', '2021-02-15 09:18:15', '2021-02-15 09:18:15'),
(897, 755, 'Горшки и кашпо', 'en', '2021-02-15 09:18:37', '2021-02-15 09:18:37'),
(898, 756, 'Надувные диваны', 'en', '2021-02-15 09:18:55', '2021-02-15 09:18:55'),
(899, 757, 'Лейки и опрыскиватели', 'en', '2021-02-15 09:18:57', '2021-02-15 09:18:57'),
(900, 758, 'Подвесные кресла', 'en', '2021-02-15 09:20:05', '2021-02-15 09:20:05'),
(901, 759, 'Корзины для цветов', 'en', '2021-02-15 09:20:08', '2021-02-15 09:20:08'),
(902, 760, 'Подставки и крепления для растений', 'en', '2021-02-15 09:20:29', '2021-02-15 09:20:29'),
(903, 761, 'Грунты и удобрения', 'en', '2021-02-15 09:20:49', '2021-02-15 09:20:49'),
(904, 762, 'Защита и уход за растениями', 'en', '2021-02-15 09:21:42', '2021-02-15 09:21:42'),
(905, 763, 'Товары для праздников', 'en', '2021-02-15 09:22:11', '2021-02-15 09:22:11'),
(906, 764, 'Скамейки', 'en', '2021-02-15 09:23:05', '2021-02-15 09:23:05'),
(907, 765, 'Фейерверки', 'en', '2021-02-15 09:24:06', '2021-02-15 09:24:06'),
(908, 766, 'Подарочная упаковка', 'en', '2021-02-15 09:24:28', '2021-02-15 09:24:28'),
(909, 767, 'Стулья и кресла', 'en', '2021-02-15 09:24:30', '2021-02-15 09:24:30'),
(910, 768, 'Воздушные шары', 'en', '2021-02-15 09:25:05', '2021-02-15 09:25:05'),
(911, 769, 'Украшения для организации праздников', 'en', '2021-02-15 09:25:48', '2021-02-15 09:25:48'),
(912, 770, 'Инверсионные столы', 'en', '2021-02-15 09:26:04', '2021-02-15 09:26:04'),
(913, 771, 'Открытки', 'en', '2021-02-15 09:26:07', '2021-02-15 09:26:07'),
(914, 772, 'Стулья и кресла', 'en', '2021-02-15 09:26:14', '2021-02-15 09:26:14'),
(915, 773, 'Гаджеты для тренировок', 'en', '2021-02-15 09:26:20', '2021-02-15 09:26:20'),
(916, 774, 'Дипломы, медали, значки', 'en', '2021-02-15 09:26:35', '2021-02-15 09:26:35'),
(917, 775, 'Беговые дорожки', 'en', '2021-02-15 09:26:36', '2021-02-15 09:26:36'),
(918, 776, 'Велотренажеры', 'en', '2021-02-15 09:26:50', '2021-02-15 09:26:50'),
(919, 777, 'Шведские стенки и комплексы', 'en', '2021-02-15 09:27:05', '2021-02-15 09:27:05'),
(920, 778, 'Грим', 'en', '2021-02-15 09:27:05', '2021-02-15 09:27:05'),
(921, 779, 'Зонты от солнца', 'en', '2021-02-15 09:27:15', '2021-02-15 09:27:15'),
(922, 780, 'Минитренажеры', 'en', '2021-02-15 09:27:22', '2021-02-15 09:27:22'),
(923, 781, 'Свадебные украшения', 'en', '2021-02-15 09:27:27', '2021-02-15 09:27:27'),
(924, 782, 'Гантели, гири и штанги', 'en', '2021-02-15 09:27:35', '2021-02-15 09:27:35'),
(925, 783, 'Мыльные пузыри', 'en', '2021-02-15 09:27:47', '2021-02-15 09:27:47'),
(926, 784, 'Фитнес', 'en', '2021-02-15 09:27:50', '2021-02-15 09:27:50'),
(927, 785, 'Коврики', 'en', '2021-02-15 09:28:05', '2021-02-15 09:28:05'),
(928, 786, 'Одноразовая посуда', 'en', '2021-02-15 09:28:07', '2021-02-15 09:28:07'),
(929, 787, 'Йога', 'en', '2021-02-15 09:28:22', '2021-02-15 09:28:22'),
(930, 788, 'Подарочные наборы', 'en', '2021-02-15 09:28:26', '2021-02-15 09:28:26'),
(931, 789, 'Аксессуары для силовых тренировок', 'en', '2021-02-15 09:28:34', '2021-02-15 09:28:34'),
(932, 790, 'Карнавальные костюмы для детей', 'en', '2021-02-15 09:28:45', '2021-02-15 09:28:45'),
(933, 791, 'Бильярд', 'en', '2021-02-15 09:28:47', '2021-02-15 09:28:47'),
(934, 792, 'Комплекты садовой мебели', 'en', '2021-02-15 09:28:56', '2021-02-15 09:28:56'),
(935, 793, 'Игровые столы', 'en', '2021-02-15 09:28:59', '2021-02-15 09:28:59'),
(936, 794, 'Карнавальные костюмы и аксессуары', 'en', '2021-02-15 09:29:02', '2021-02-15 09:29:02'),
(937, 795, 'Настольный теннис', 'en', '2021-02-15 09:29:16', '2021-02-15 09:29:16'),
(938, 796, 'Новогодние товары', 'en', '2021-02-15 09:29:22', '2021-02-15 09:29:22'),
(939, 797, 'Гаджеты для тренировок', 'en', '2021-02-15 09:29:31', '2021-02-15 09:29:31'),
(940, 798, 'Спортивная защита', 'en', '2021-02-15 09:29:51', '2021-02-15 09:29:51'),
(941, 799, 'Игры для компаний', 'en', '2021-02-15 09:30:12', '2021-02-15 09:30:12'),
(942, 800, 'Зимние виды спорта', 'en', '2021-02-15 09:30:18', '2021-02-15 09:30:18'),
(943, 801, 'Игры в дорогу', 'en', '2021-02-15 09:30:48', '2021-02-15 09:30:48'),
(944, 802, 'Семейные игры', 'en', '2021-02-15 09:31:09', '2021-02-15 09:31:09'),
(945, 803, 'Сноубординг', 'en', '2021-02-15 09:31:28', '2021-02-15 09:31:28'),
(946, 804, 'Матрасы для шезлонгов', 'en', '2021-02-15 09:31:34', '2021-02-15 09:31:34'),
(947, 805, 'Настольные игры', 'en', '2021-02-15 09:31:42', '2021-02-15 09:31:42'),
(948, 806, 'Горные лыжи', 'en', '2021-02-15 09:31:57', '2021-02-15 09:31:57'),
(949, 807, 'Беговые лыжи', 'en', '2021-02-15 09:32:17', '2021-02-15 09:32:17'),
(950, 808, 'Стратегии', 'en', '2021-02-15 09:32:26', '2021-02-15 09:32:26'),
(951, 809, 'Карточные игры', 'en', '2021-02-15 09:33:06', '2021-02-15 09:33:06'),
(952, 810, 'Защита и экипировка', 'en', '2021-02-15 09:33:09', '2021-02-15 09:33:09'),
(953, 811, 'Коньки и аксессуары', 'en', '2021-02-15 09:33:33', '2021-02-15 09:33:33'),
(954, 812, 'Варгеймы', 'en', '2021-02-15 09:33:35', '2021-02-15 09:33:35'),
(955, 813, 'Хоккей', 'en', '2021-02-15 09:33:49', '2021-02-15 09:33:49'),
(956, 814, 'RPG', 'en', '2021-02-15 09:33:53', '2021-02-15 09:33:53'),
(957, 815, 'Детям', 'en', '2021-02-15 09:34:03', '2021-02-15 09:34:03'),
(958, 816, 'Наборы для покера', 'en', '2021-02-15 09:34:21', '2021-02-15 09:34:21'),
(959, 817, 'Аксессуары для спортсменов', 'en', '2021-02-15 09:34:23', '2021-02-15 09:34:23'),
(960, 818, 'Аксессуары и комплектующие для снаряжения', 'en', '2021-02-15 09:34:36', '2021-02-15 09:34:36'),
(961, 819, 'Настольный футбол, хоккей', 'en', '2021-02-15 09:34:48', '2021-02-15 09:34:48'),
(962, 820, 'Охота и рыбалка', 'en', '2021-02-15 09:34:58', '2021-02-15 09:34:58'),
(963, 821, 'Товары для рыбалки', 'en', '2021-02-15 09:35:14', '2021-02-15 09:35:14'),
(964, 822, 'Шахматы, шашки, нарды', 'en', '2021-02-15 09:35:15', '2021-02-15 09:35:15'),
(965, 823, 'Товары для охоты', 'en', '2021-02-15 09:35:34', '2021-02-15 09:35:34'),
(966, 824, 'Домино и лото', 'en', '2021-02-15 09:35:35', '2021-02-15 09:35:35'),
(967, 825, 'Сумки и ящики', 'en', '2021-02-15 09:35:49', '2021-02-15 09:35:49'),
(968, 826, 'Пазлы', 'en', '2021-02-15 09:35:53', '2021-02-15 09:35:53'),
(969, 827, 'Аксессуары', 'en', '2021-02-15 09:36:04', '2021-02-15 09:36:04'),
(970, 828, 'Сборные модели', 'en', '2021-02-15 09:36:16', '2021-02-15 09:36:16'),
(971, 829, 'Одежда для охоты и рыбалки', 'en', '2021-02-15 09:36:19', '2021-02-15 09:36:19'),
(973, 831, 'Обувь для охоты и рыбалки', 'en', '2021-02-15 09:36:38', '2021-02-15 09:36:38'),
(974, 832, 'Матрасы для садовых качелей', 'en', '2021-02-15 09:36:45', '2021-02-15 09:36:45'),
(975, 833, 'Охота и стрельба', 'en', '2021-02-15 09:36:56', '2021-02-15 09:36:56'),
(976, 834, 'Головоломки', 'en', '2021-02-15 09:36:59', '2021-02-15 09:36:59'),
(977, 835, 'Лодки и лодочные моторы', 'en', '2021-02-15 09:37:18', '2021-02-15 09:37:18'),
(978, 836, 'Туризм и отдых на природе', 'en', '2021-02-15 09:37:42', '2021-02-15 09:37:42'),
(979, 837, 'Рюкзаки для туризма', 'en', '2021-02-15 09:38:27', '2021-02-15 09:38:27'),
(980, 838, 'Аксессуары для шатров, зонтов', 'en', '2021-02-15 09:38:42', '2021-02-15 09:38:42'),
(982, 840, 'Тенты и шатры', 'en', '2021-02-15 09:40:40', '2021-02-15 09:40:40'),
(983, 841, 'Мебель для ванной', 'en', '2021-02-15 09:42:44', '2021-02-15 09:42:44'),
(984, 842, 'Шкафы', 'en', '2021-02-15 09:48:39', '2021-02-15 09:48:39'),
(985, 843, 'Готовые комплекты мебели', 'en', '2021-02-15 09:49:40', '2021-02-15 09:49:40'),
(986, 844, 'Тумбы для ванной', 'en', '2021-02-15 09:50:27', '2021-02-15 09:50:27'),
(987, 845, 'Зеркала', 'en', '2021-02-15 09:51:31', '2021-02-15 09:51:31'),
(988, 846, 'Держатели и крючки', 'en', '2021-02-15 09:52:00', '2021-02-15 09:52:00'),
(989, 847, 'Коврики', 'en', '2021-02-15 09:52:28', '2021-02-15 09:52:28'),
(990, 848, 'Мыльницы, стаканы и дозаторы', 'en', '2021-02-15 09:53:38', '2021-02-15 09:53:38'),
(991, 849, 'Полки, стойки, этажерки', 'en', '2021-02-15 09:54:26', '2021-02-15 09:54:26'),
(992, 850, 'Шторы и карнизы', 'en', '2021-02-15 09:55:33', '2021-02-15 09:55:33'),
(993, 851, 'Мебель для кухни', 'en', '2021-02-15 09:56:09', '2021-02-15 09:56:09'),
(994, 852, 'Уголки и обеденные группы', 'en', '2021-02-15 09:56:42', '2021-02-15 09:56:42'),
(995, 853, 'Кухонные гарнитуры', 'en', '2021-02-15 09:57:36', '2021-02-15 09:57:36'),
(996, 854, 'Стулья, табуретки', 'en', '2021-02-15 09:58:01', '2021-02-15 09:58:01'),
(997, 855, 'Столы и столики', 'en', '2021-02-15 09:58:22', '2021-02-15 09:58:22'),
(998, 856, 'Кухонные готовые гарнитуры', 'en', '2021-02-15 09:59:06', '2021-02-15 09:59:06'),
(999, 857, 'Мебель для спальни', 'en', '2021-02-15 10:02:03', '2021-02-15 10:02:03'),
(1000, 858, 'Спальня готовый комплект', 'en', '2021-02-15 10:20:18', '2021-02-15 10:20:18'),
(1001, 859, 'Матрасы', 'en', '2021-02-15 10:20:46', '2021-02-15 10:20:46'),
(1002, 860, 'Кровати', 'en', '2021-02-15 10:21:17', '2021-02-15 10:21:17'),
(1003, 861, 'Основания для матрасов', 'en', '2021-02-15 10:26:33', '2021-02-15 10:26:33'),
(1004, 862, 'Изголовья', 'en', '2021-02-15 10:27:18', '2021-02-15 10:27:18'),
(1005, 863, 'Офисная мебель', 'en', '2021-02-15 10:31:09', '2021-02-15 10:31:09'),
(1006, 864, 'Мебель для учреждений', 'en', '2021-02-15 10:31:32', '2021-02-15 10:31:32');
INSERT INTO `category_translations` (`id`, `category_id`, `name`, `lang`, `created_at`, `updated_at`) VALUES
(1007, 865, 'Шкафы для документов', 'en', '2021-02-15 10:31:57', '2021-02-15 10:31:57'),
(1008, 866, 'Кабинеты', 'en', '2021-02-15 10:35:22', '2021-02-15 10:35:22'),
(1009, 867, 'Скамьи и секции', 'en', '2021-02-15 10:36:01', '2021-02-15 10:36:01'),
(1010, 868, 'Фурнитура для мебели и комплектующие', 'en', '2021-02-15 10:36:46', '2021-02-15 10:36:46'),
(1011, 869, 'Фурнитура для мебели', 'en', '2021-02-15 10:37:54', '2021-02-15 10:37:54'),
(1012, 870, 'Комплектующие', 'en', '2021-02-15 10:38:25', '2021-02-15 10:38:25'),
(1013, 871, 'Сейфы', 'en', '2021-02-15 10:38:48', '2021-02-15 10:38:48'),
(1014, 872, 'Электронные сейфы', 'en', '2021-02-15 10:39:11', '2021-02-15 10:39:11'),
(1015, 873, 'Сейфы обычные', 'en', '2021-02-15 10:39:34', '2021-02-15 10:39:34'),
(1016, 874, 'Шкафы железные', 'en', '2021-02-15 10:39:58', '2021-02-15 10:39:58'),
(1017, 875, 'Железные тумбы', 'en', '2021-02-15 10:40:26', '2021-02-15 10:40:26'),
(1020, 878, 'Лодки и лодочные моторы', 'en', '2021-02-15 10:52:08', '2021-02-15 10:52:08'),
(1022, 880, 'Палатки, тенты и спальники', 'en', '2021-02-15 10:53:58', '2021-02-15 10:53:58'),
(1023, 881, 'Рюкзаки для туризма', 'en', '2021-02-15 10:54:17', '2021-02-15 10:54:17'),
(1024, 882, 'Походная кухня', 'en', '2021-02-15 10:54:37', '2021-02-15 10:54:37'),
(1025, 883, 'Походная мебель', 'en', '2021-02-15 10:55:00', '2021-02-15 10:55:00'),
(1026, 884, 'Аксессуары для туризма', 'en', '2021-02-15 10:55:21', '2021-02-15 10:55:21'),
(1027, 885, 'Палки для скандинавской ходьбы и треккинга', 'en', '2021-02-15 10:55:37', '2021-02-15 10:55:37'),
(1028, 886, 'Активные виды спорта', 'en', '2021-02-15 10:57:06', '2021-02-15 10:57:06'),
(1029, 887, 'Велосипеды', 'en', '2021-02-15 10:57:41', '2021-02-15 10:57:41'),
(1030, 888, 'Аксессуары', 'en', '2021-02-15 11:00:12', '2021-02-15 11:00:12'),
(1031, 889, 'Запчасти', 'en', '2021-02-15 11:01:52', '2021-02-15 11:01:52'),
(1032, 890, 'Инструменты', 'en', '2021-02-15 11:02:15', '2021-02-15 11:02:15'),
(1034, 892, 'Самокаты', 'en', '2021-02-15 11:03:15', '2021-02-15 11:03:15'),
(1035, 893, 'Скейтборды и лонгборды', 'en', '2021-02-15 11:03:31', '2021-02-15 11:03:31'),
(1036, 894, 'Роликовые коньки', 'en', '2021-02-15 11:03:54', '2021-02-15 11:03:54');

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cost` double(20,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `city_translations`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `city_translations`;
CREATE TABLE `city_translations` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `club_points`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 06:15
--

DROP TABLE IF EXISTS `club_points`;
CREATE TABLE `club_points` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `points` double(18,2) NOT NULL,
  `convert_status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `club_points`
--

INSERT INTO `club_points` (`id`, `user_id`, `points`, `convert_status`, `created_at`, `updated_at`) VALUES
(1, 10, 0.00, 0, '2021-02-15 03:15:15', '2021-02-15 03:15:15');

-- --------------------------------------------------------

--
-- Структура таблицы `club_point_details`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 06:15
--

DROP TABLE IF EXISTS `club_point_details`;
CREATE TABLE `club_point_details` (
  `id` int(11) NOT NULL,
  `club_point_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `point` double(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `club_point_details`
--

INSERT INTO `club_point_details` (`id`, `club_point_id`, `product_id`, `product_qty`, `point`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 0, 0.00, '2021-02-15 03:15:15', '2021-02-15 03:15:15');

-- --------------------------------------------------------

--
-- Структура таблицы `colors`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `colors`;
CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `colors`
--

INSERT INTO `colors` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'IndianRed', '#CD5C5C', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(2, 'LightCoral', '#F08080', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(3, 'Salmon', '#FA8072', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(4, 'DarkSalmon', '#E9967A', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(5, 'LightSalmon', '#FFA07A', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(6, 'Crimson', '#DC143C', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(7, 'Red', '#FF0000', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(8, 'FireBrick', '#B22222', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(9, 'DarkRed', '#8B0000', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(10, 'Pink', '#FFC0CB', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(11, 'LightPink', '#FFB6C1', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(12, 'HotPink', '#FF69B4', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(13, 'DeepPink', '#FF1493', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(14, 'MediumVioletRed', '#C71585', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(15, 'PaleVioletRed', '#DB7093', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(16, 'LightSalmon', '#FFA07A', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(17, 'Coral', '#FF7F50', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(18, 'Tomato', '#FF6347', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(19, 'OrangeRed', '#FF4500', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(20, 'DarkOrange', '#FF8C00', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(21, 'Orange', '#FFA500', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(22, 'Gold', '#FFD700', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(23, 'Yellow', '#FFFF00', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(24, 'LightYellow', '#FFFFE0', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(25, 'LemonChiffon', '#FFFACD', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(26, 'LightGoldenrodYellow', '#FAFAD2', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(27, 'PapayaWhip', '#FFEFD5', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(28, 'Moccasin', '#FFE4B5', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(29, 'PeachPuff', '#FFDAB9', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(30, 'PaleGoldenrod', '#EEE8AA', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(31, 'Khaki', '#F0E68C', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(32, 'DarkKhaki', '#BDB76B', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(33, 'Lavender', '#E6E6FA', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(34, 'Thistle', '#D8BFD8', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(35, 'Plum', '#DDA0DD', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(36, 'Violet', '#EE82EE', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(37, 'Orchid', '#DA70D6', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(38, 'Fuchsia', '#FF00FF', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(39, 'Magenta', '#FF00FF', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(40, 'MediumOrchid', '#BA55D3', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(41, 'MediumPurple', '#9370DB', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(42, 'Amethyst', '#9966CC', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(43, 'BlueViolet', '#8A2BE2', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(44, 'DarkViolet', '#9400D3', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(45, 'DarkOrchid', '#9932CC', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(46, 'DarkMagenta', '#8B008B', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(47, 'Purple', '#800080', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(48, 'Indigo', '#4B0082', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(49, 'SlateBlue', '#6A5ACD', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(50, 'DarkSlateBlue', '#483D8B', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(51, 'MediumSlateBlue', '#7B68EE', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(52, 'GreenYellow', '#ADFF2F', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(53, 'Chartreuse', '#7FFF00', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(54, 'LawnGreen', '#7CFC00', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(55, 'Lime', '#00FF00', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(56, 'LimeGreen', '#32CD32', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(57, 'PaleGreen', '#98FB98', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(58, 'LightGreen', '#90EE90', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(59, 'MediumSpringGreen', '#00FA9A', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(60, 'SpringGreen', '#00FF7F', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(61, 'MediumSeaGreen', '#3CB371', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(62, 'SeaGreen', '#2E8B57', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(63, 'ForestGreen', '#228B22', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(64, 'Green', '#008000', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(65, 'DarkGreen', '#006400', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(66, 'YellowGreen', '#9ACD32', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(67, 'OliveDrab', '#6B8E23', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(68, 'Olive', '#808000', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(69, 'DarkOliveGreen', '#556B2F', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(70, 'MediumAquamarine', '#66CDAA', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(71, 'DarkSeaGreen', '#8FBC8F', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(72, 'LightSeaGreen', '#20B2AA', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(73, 'DarkCyan', '#008B8B', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(74, 'Teal', '#008080', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(75, 'Aqua', '#00FFFF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(76, 'Cyan', '#00FFFF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(77, 'LightCyan', '#E0FFFF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(78, 'PaleTurquoise', '#AFEEEE', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(79, 'Aquamarine', '#7FFFD4', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(80, 'Turquoise', '#40E0D0', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(81, 'MediumTurquoise', '#48D1CC', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(82, 'DarkTurquoise', '#00CED1', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(83, 'CadetBlue', '#5F9EA0', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(84, 'SteelBlue', '#4682B4', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(85, 'LightSteelBlue', '#B0C4DE', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(86, 'PowderBlue', '#B0E0E6', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(87, 'LightBlue', '#ADD8E6', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(88, 'SkyBlue', '#87CEEB', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(89, 'LightSkyBlue', '#87CEFA', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(90, 'DeepSkyBlue', '#00BFFF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(91, 'DodgerBlue', '#1E90FF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(92, 'CornflowerBlue', '#6495ED', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(93, 'MediumSlateBlue', '#7B68EE', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(94, 'RoyalBlue', '#4169E1', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(95, 'Blue', '#0000FF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(96, 'MediumBlue', '#0000CD', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(97, 'DarkBlue', '#00008B', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(98, 'Navy', '#000080', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(99, 'MidnightBlue', '#191970', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(100, 'Cornsilk', '#FFF8DC', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(101, 'BlanchedAlmond', '#FFEBCD', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(102, 'Bisque', '#FFE4C4', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(103, 'NavajoWhite', '#FFDEAD', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(104, 'Wheat', '#F5DEB3', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(105, 'BurlyWood', '#DEB887', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(106, 'Tan', '#D2B48C', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(107, 'RosyBrown', '#BC8F8F', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(108, 'SandyBrown', '#F4A460', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(109, 'Goldenrod', '#DAA520', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(110, 'DarkGoldenrod', '#B8860B', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(111, 'Peru', '#CD853F', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(112, 'Chocolate', '#D2691E', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(113, 'SaddleBrown', '#8B4513', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(114, 'Sienna', '#A0522D', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(115, 'Brown', '#A52A2A', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(116, 'Maroon', '#800000', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(117, 'White', '#FFFFFF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(118, 'Snow', '#FFFAFA', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(119, 'Honeydew', '#F0FFF0', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(120, 'MintCream', '#F5FFFA', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(121, 'Azure', '#F0FFFF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(122, 'AliceBlue', '#F0F8FF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(123, 'GhostWhite', '#F8F8FF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(124, 'WhiteSmoke', '#F5F5F5', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(125, 'Seashell', '#FFF5EE', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(126, 'Beige', '#F5F5DC', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(127, 'OldLace', '#FDF5E6', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(128, 'FloralWhite', '#FFFAF0', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(129, 'Ivory', '#FFFFF0', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(130, 'AntiqueWhite', '#FAEBD7', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(131, 'Linen', '#FAF0E6', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(132, 'LavenderBlush', '#FFF0F5', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(133, 'MistyRose', '#FFE4E1', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(134, 'Gainsboro', '#DCDCDC', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(135, 'LightGrey', '#D3D3D3', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(136, 'Silver', '#C0C0C0', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(137, 'DarkGray', '#A9A9A9', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(138, 'Gray', '#808080', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(139, 'DimGray', '#696969', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(140, 'LightSlateGray', '#778899', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(141, 'SlateGray', '#708090', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(142, 'DarkSlateGray', '#2F4F4F', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(143, 'Black', '#000000', '2018-11-05 02:12:30', '2018-11-05 02:12:30');

-- --------------------------------------------------------

--
-- Структура таблицы `conversations`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `conversations`;
CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `title` varchar(1000) COLLATE utf32_unicode_ci DEFAULT NULL,
  `sender_viewed` int(1) NOT NULL DEFAULT '1',
  `receiver_viewed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AF', 'Afghanistan', 1, NULL, NULL),
(2, 'AL', 'Albania', 1, NULL, NULL),
(3, 'DZ', 'Algeria', 1, NULL, NULL),
(4, 'DS', 'American Samoa', 1, NULL, NULL),
(5, 'AD', 'Andorra', 1, NULL, NULL),
(6, 'AO', 'Angola', 1, NULL, NULL),
(7, 'AI', 'Anguilla', 1, NULL, NULL),
(8, 'AQ', 'Antarctica', 1, NULL, NULL),
(9, 'AG', 'Antigua and Barbuda', 1, NULL, NULL),
(10, 'AR', 'Argentina', 1, NULL, NULL),
(11, 'AM', 'Armenia', 1, NULL, NULL),
(12, 'AW', 'Aruba', 1, NULL, NULL),
(13, 'AU', 'Australia', 1, NULL, NULL),
(14, 'AT', 'Austria', 1, NULL, NULL),
(15, 'AZ', 'Azerbaijan', 1, NULL, NULL),
(16, 'BS', 'Bahamas', 1, NULL, NULL),
(17, 'BH', 'Bahrain', 1, NULL, NULL),
(18, 'BD', 'Bangladesh', 1, NULL, NULL),
(19, 'BB', 'Barbados', 1, NULL, NULL),
(20, 'BY', 'Belarus', 1, NULL, NULL),
(21, 'BE', 'Belgium', 1, NULL, NULL),
(22, 'BZ', 'Belize', 1, NULL, NULL),
(23, 'BJ', 'Benin', 1, NULL, NULL),
(24, 'BM', 'Bermuda', 1, NULL, NULL),
(25, 'BT', 'Bhutan', 1, NULL, NULL),
(26, 'BO', 'Bolivia', 1, NULL, NULL),
(27, 'BA', 'Bosnia and Herzegovina', 1, NULL, NULL),
(28, 'BW', 'Botswana', 1, NULL, NULL),
(29, 'BV', 'Bouvet Island', 1, NULL, NULL),
(30, 'BR', 'Brazil', 1, NULL, NULL),
(31, 'IO', 'British Indian Ocean Territory', 1, NULL, NULL),
(32, 'BN', 'Brunei Darussalam', 1, NULL, NULL),
(33, 'BG', 'Bulgaria', 1, NULL, NULL),
(34, 'BF', 'Burkina Faso', 1, NULL, NULL),
(35, 'BI', 'Burundi', 1, NULL, NULL),
(36, 'KH', 'Cambodia', 1, NULL, NULL),
(37, 'CM', 'Cameroon', 1, NULL, NULL),
(38, 'CA', 'Canada', 1, NULL, NULL),
(39, 'CV', 'Cape Verde', 1, NULL, NULL),
(40, 'KY', 'Cayman Islands', 1, NULL, NULL),
(41, 'CF', 'Central African Republic', 1, NULL, NULL),
(42, 'TD', 'Chad', 1, NULL, NULL),
(43, 'CL', 'Chile', 1, NULL, NULL),
(44, 'CN', 'China', 1, NULL, NULL),
(45, 'CX', 'Christmas Island', 1, NULL, NULL),
(46, 'CC', 'Cocos (Keeling) Islands', 1, NULL, NULL),
(47, 'CO', 'Colombia', 1, NULL, NULL),
(48, 'KM', 'Comoros', 1, NULL, NULL),
(49, 'CG', 'Congo', 1, NULL, NULL),
(50, 'CK', 'Cook Islands', 1, NULL, NULL),
(51, 'CR', 'Costa Rica', 1, NULL, NULL),
(52, 'HR', 'Croatia (Hrvatska)', 1, NULL, NULL),
(53, 'CU', 'Cuba', 1, NULL, NULL),
(54, 'CY', 'Cyprus', 1, NULL, NULL),
(55, 'CZ', 'Czech Republic', 1, NULL, NULL),
(56, 'DK', 'Denmark', 1, NULL, NULL),
(57, 'DJ', 'Djibouti', 1, NULL, NULL),
(58, 'DM', 'Dominica', 1, NULL, NULL),
(59, 'DO', 'Dominican Republic', 1, NULL, NULL),
(60, 'TP', 'East Timor', 1, NULL, NULL),
(61, 'EC', 'Ecuador', 1, NULL, NULL),
(62, 'EG', 'Egypt', 1, NULL, NULL),
(63, 'SV', 'El Salvador', 1, NULL, NULL),
(64, 'GQ', 'Equatorial Guinea', 1, NULL, NULL),
(65, 'ER', 'Eritrea', 1, NULL, NULL),
(66, 'EE', 'Estonia', 1, NULL, NULL),
(67, 'ET', 'Ethiopia', 1, NULL, NULL),
(68, 'FK', 'Falkland Islands (Malvinas)', 1, NULL, NULL),
(69, 'FO', 'Faroe Islands', 1, NULL, NULL),
(70, 'FJ', 'Fiji', 1, NULL, NULL),
(71, 'FI', 'Finland', 1, NULL, NULL),
(72, 'FR', 'France', 1, NULL, NULL),
(73, 'FX', 'France, Metropolitan', 1, NULL, NULL),
(74, 'GF', 'French Guiana', 1, NULL, NULL),
(75, 'PF', 'French Polynesia', 1, NULL, NULL),
(76, 'TF', 'French Southern Territories', 1, NULL, NULL),
(77, 'GA', 'Gabon', 1, NULL, NULL),
(78, 'GM', 'Gambia', 1, NULL, NULL),
(79, 'GE', 'Georgia', 1, NULL, NULL),
(80, 'DE', 'Germany', 1, NULL, NULL),
(81, 'GH', 'Ghana', 1, NULL, NULL),
(82, 'GI', 'Gibraltar', 1, NULL, NULL),
(83, 'GK', 'Guernsey', 1, NULL, NULL),
(84, 'GR', 'Greece', 1, NULL, NULL),
(85, 'GL', 'Greenland', 1, NULL, NULL),
(86, 'GD', 'Grenada', 1, NULL, NULL),
(87, 'GP', 'Guadeloupe', 1, NULL, NULL),
(88, 'GU', 'Guam', 1, NULL, NULL),
(89, 'GT', 'Guatemala', 1, NULL, NULL),
(90, 'GN', 'Guinea', 1, NULL, NULL),
(91, 'GW', 'Guinea-Bissau', 1, NULL, NULL),
(92, 'GY', 'Guyana', 1, NULL, NULL),
(93, 'HT', 'Haiti', 1, NULL, NULL),
(94, 'HM', 'Heard and Mc Donald Islands', 1, NULL, NULL),
(95, 'HN', 'Honduras', 1, NULL, NULL),
(96, 'HK', 'Hong Kong', 1, NULL, NULL),
(97, 'HU', 'Hungary', 1, NULL, NULL),
(98, 'IS', 'Iceland', 1, NULL, NULL),
(99, 'IN', 'India', 1, NULL, NULL),
(100, 'IM', 'Isle of Man', 1, NULL, NULL),
(101, 'ID', 'Indonesia', 1, NULL, NULL),
(102, 'IR', 'Iran (Islamic Republic of)', 1, NULL, NULL),
(103, 'IQ', 'Iraq', 1, NULL, NULL),
(104, 'IE', 'Ireland', 1, NULL, NULL),
(105, 'IL', 'Israel', 1, NULL, NULL),
(106, 'IT', 'Italy', 1, NULL, NULL),
(107, 'CI', 'Ivory Coast', 1, NULL, NULL),
(108, 'JE', 'Jersey', 1, NULL, NULL),
(109, 'JM', 'Jamaica', 1, NULL, NULL),
(110, 'JP', 'Japan', 1, NULL, NULL),
(111, 'JO', 'Jordan', 1, NULL, NULL),
(112, 'KZ', 'Kazakhstan', 1, NULL, NULL),
(113, 'KE', 'Kenya', 1, NULL, NULL),
(114, 'KI', 'Kiribati', 1, NULL, NULL),
(115, 'KP', 'Korea, Democratic People\'s Republic of', 1, NULL, NULL),
(116, 'KR', 'Korea, Republic of', 1, NULL, NULL),
(117, 'XK', 'Kosovo', 1, NULL, NULL),
(118, 'KW', 'Kuwait', 1, NULL, NULL),
(119, 'KG', 'Kyrgyzstan', 1, NULL, NULL),
(120, 'LA', 'Lao People\'s Democratic Republic', 1, NULL, NULL),
(121, 'LV', 'Latvia', 1, NULL, NULL),
(122, 'LB', 'Lebanon', 1, NULL, NULL),
(123, 'LS', 'Lesotho', 1, NULL, NULL),
(124, 'LR', 'Liberia', 1, NULL, NULL),
(125, 'LY', 'Libyan Arab Jamahiriya', 1, NULL, NULL),
(126, 'LI', 'Liechtenstein', 1, NULL, NULL),
(127, 'LT', 'Lithuania', 1, NULL, NULL),
(128, 'LU', 'Luxembourg', 1, NULL, NULL),
(129, 'MO', 'Macau', 1, NULL, NULL),
(130, 'MK', 'Macedonia', 1, NULL, NULL),
(131, 'MG', 'Madagascar', 1, NULL, NULL),
(132, 'MW', 'Malawi', 1, NULL, NULL),
(133, 'MY', 'Malaysia', 1, NULL, NULL),
(134, 'MV', 'Maldives', 1, NULL, NULL),
(135, 'ML', 'Mali', 1, NULL, NULL),
(136, 'MT', 'Malta', 1, NULL, NULL),
(137, 'MH', 'Marshall Islands', 1, NULL, NULL),
(138, 'MQ', 'Martinique', 1, NULL, NULL),
(139, 'MR', 'Mauritania', 1, NULL, NULL),
(140, 'MU', 'Mauritius', 1, NULL, NULL),
(141, 'TY', 'Mayotte', 1, NULL, NULL),
(142, 'MX', 'Mexico', 1, NULL, NULL),
(143, 'FM', 'Micronesia, Federated States of', 1, NULL, NULL),
(144, 'MD', 'Moldova, Republic of', 1, NULL, NULL),
(145, 'MC', 'Monaco', 1, NULL, NULL),
(146, 'MN', 'Mongolia', 1, NULL, NULL),
(147, 'ME', 'Montenegro', 1, NULL, NULL),
(148, 'MS', 'Montserrat', 1, NULL, NULL),
(149, 'MA', 'Morocco', 1, NULL, NULL),
(150, 'MZ', 'Mozambique', 1, NULL, NULL),
(151, 'MM', 'Myanmar', 1, NULL, NULL),
(152, 'NA', 'Namibia', 1, NULL, NULL),
(153, 'NR', 'Nauru', 1, NULL, NULL),
(154, 'NP', 'Nepal', 1, NULL, NULL),
(155, 'NL', 'Netherlands', 1, NULL, NULL),
(156, 'AN', 'Netherlands Antilles', 1, NULL, NULL),
(157, 'NC', 'New Caledonia', 1, NULL, NULL),
(158, 'NZ', 'New Zealand', 1, NULL, NULL),
(159, 'NI', 'Nicaragua', 1, NULL, NULL),
(160, 'NE', 'Niger', 1, NULL, NULL),
(161, 'NG', 'Nigeria', 1, NULL, NULL),
(162, 'NU', 'Niue', 1, NULL, NULL),
(163, 'NF', 'Norfolk Island', 1, NULL, NULL),
(164, 'MP', 'Northern Mariana Islands', 1, NULL, NULL),
(165, 'NO', 'Norway', 1, NULL, NULL),
(166, 'OM', 'Oman', 1, NULL, NULL),
(167, 'PK', 'Pakistan', 1, NULL, NULL),
(168, 'PW', 'Palau', 1, NULL, NULL),
(169, 'PS', 'Palestine', 1, NULL, NULL),
(170, 'PA', 'Panama', 1, NULL, NULL),
(171, 'PG', 'Papua New Guinea', 1, NULL, NULL),
(172, 'PY', 'Paraguay', 1, NULL, NULL),
(173, 'PE', 'Peru', 1, NULL, NULL),
(174, 'PH', 'Philippines', 1, NULL, NULL),
(175, 'PN', 'Pitcairn', 1, NULL, NULL),
(176, 'PL', 'Poland', 1, NULL, NULL),
(177, 'PT', 'Portugal', 1, NULL, NULL),
(178, 'PR', 'Puerto Rico', 1, NULL, NULL),
(179, 'QA', 'Qatar', 1, NULL, NULL),
(180, 'RE', 'Reunion', 1, NULL, NULL),
(181, 'RO', 'Romania', 1, NULL, NULL),
(182, 'RU', 'Russian Federation', 1, NULL, NULL),
(183, 'RW', 'Rwanda', 1, NULL, NULL),
(184, 'KN', 'Saint Kitts and Nevis', 1, NULL, NULL),
(185, 'LC', 'Saint Lucia', 1, NULL, NULL),
(186, 'VC', 'Saint Vincent and the Grenadines', 1, NULL, NULL),
(187, 'WS', 'Samoa', 1, NULL, NULL),
(188, 'SM', 'San Marino', 1, NULL, NULL),
(189, 'ST', 'Sao Tome and Principe', 1, NULL, NULL),
(190, 'SA', 'Saudi Arabia', 1, NULL, NULL),
(191, 'SN', 'Senegal', 1, NULL, NULL),
(192, 'RS', 'Serbia', 1, NULL, NULL),
(193, 'SC', 'Seychelles', 1, NULL, NULL),
(194, 'SL', 'Sierra Leone', 1, NULL, NULL),
(195, 'SG', 'Singapore', 1, NULL, NULL),
(196, 'SK', 'Slovakia', 1, NULL, NULL),
(197, 'SI', 'Slovenia', 1, NULL, NULL),
(198, 'SB', 'Solomon Islands', 1, NULL, NULL),
(199, 'SO', 'Somalia', 1, NULL, NULL),
(200, 'ZA', 'South Africa', 1, NULL, NULL),
(201, 'GS', 'South Georgia South Sandwich Islands', 1, NULL, NULL),
(202, 'SS', 'South Sudan', 1, NULL, NULL),
(203, 'ES', 'Spain', 1, NULL, NULL),
(204, 'LK', 'Sri Lanka', 1, NULL, NULL),
(205, 'SH', 'St. Helena', 1, NULL, NULL),
(206, 'PM', 'St. Pierre and Miquelon', 1, NULL, NULL),
(207, 'SD', 'Sudan', 1, NULL, NULL),
(208, 'SR', 'Suriname', 1, NULL, NULL),
(209, 'SJ', 'Svalbard and Jan Mayen Islands', 1, NULL, NULL),
(210, 'SZ', 'Swaziland', 1, NULL, NULL),
(211, 'SE', 'Sweden', 1, NULL, NULL),
(212, 'CH', 'Switzerland', 1, NULL, NULL),
(213, 'SY', 'Syrian Arab Republic', 1, NULL, NULL),
(214, 'TW', 'Taiwan', 1, NULL, NULL),
(215, 'TJ', 'Tajikistan', 1, NULL, NULL),
(216, 'TZ', 'Tanzania, United Republic of', 1, NULL, NULL),
(217, 'TH', 'Thailand', 1, NULL, NULL),
(218, 'TG', 'Togo', 1, NULL, NULL),
(219, 'TK', 'Tokelau', 1, NULL, NULL),
(220, 'TO', 'Tonga', 1, NULL, NULL),
(221, 'TT', 'Trinidad and Tobago', 1, NULL, NULL),
(222, 'TN', 'Tunisia', 1, NULL, NULL),
(223, 'TR', 'Turkey', 1, NULL, NULL),
(224, 'TM', 'Turkmenistan', 1, NULL, NULL),
(225, 'TC', 'Turks and Caicos Islands', 1, NULL, NULL),
(226, 'TV', 'Tuvalu', 1, NULL, NULL),
(227, 'UG', 'Uganda', 1, NULL, NULL),
(228, 'UA', 'Ukraine', 1, NULL, NULL),
(229, 'AE', 'United Arab Emirates', 1, NULL, NULL),
(230, 'GB', 'United Kingdom', 1, NULL, NULL),
(231, 'US', 'United States', 1, NULL, NULL),
(232, 'UM', 'United States minor outlying islands', 1, NULL, NULL),
(233, 'UY', 'Uruguay', 1, NULL, NULL),
(234, 'UZ', 'Uzbekistan', 1, NULL, NULL),
(235, 'VU', 'Vanuatu', 1, NULL, NULL),
(236, 'VA', 'Vatican City State', 1, NULL, NULL),
(237, 'VE', 'Venezuela', 1, NULL, NULL),
(238, 'VN', 'Vietnam', 1, NULL, NULL),
(239, 'VG', 'Virgin Islands (British)', 1, NULL, NULL),
(240, 'VI', 'Virgin Islands (U.S.)', 1, NULL, NULL),
(241, 'WF', 'Wallis and Futuna Islands', 1, NULL, NULL),
(242, 'EH', 'Western Sahara', 1, NULL, NULL),
(243, 'YE', 'Yemen', 1, NULL, NULL),
(244, 'ZR', 'Zaire', 1, NULL, NULL),
(245, 'ZM', 'Zambia', 1, NULL, NULL),
(246, 'ZW', 'Zimbabwe', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `coupons`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci NOT NULL,
  `discount` double(20,2) NOT NULL,
  `discount_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` int(15) NOT NULL,
  `end_date` int(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `coupon_usages`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `coupon_usages`;
CREATE TABLE `coupon_usages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `currencies`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 13 2021 г., 10:51
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `exchange_rate` double(10,5) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `exchange_rate`, `status`, `code`, `created_at`, `updated_at`) VALUES
(1, 'U.S. Dollar', '$', 1.00000, 1, 'USD', '2018-10-09 11:35:08', '2018-10-17 05:50:52'),
(2, 'Australian Dollar', '$', 1.28000, 0, 'AUD', '2018-10-09 11:35:08', '2021-02-13 07:35:06'),
(5, 'Brazilian Real', 'R$', 3.25000, 0, 'BRL', '2018-10-09 11:35:08', '2021-02-13 07:35:07'),
(6, 'Canadian Dollar', '$', 1.27000, 0, 'CAD', '2018-10-09 11:35:08', '2021-02-13 07:35:09'),
(7, 'Czech Koruna', 'Kč', 20.65000, 0, 'CZK', '2018-10-09 11:35:08', '2021-02-13 07:35:09'),
(8, 'Danish Krone', 'kr', 6.05000, 0, 'DKK', '2018-10-09 11:35:08', '2021-02-13 07:35:11'),
(9, 'Euro', '€', 0.85000, 1, 'EUR', '2018-10-09 11:35:08', '2021-02-13 07:41:40'),
(10, 'Hong Kong Dollar', '$', 7.83000, 0, 'HKD', '2018-10-09 11:35:08', '2021-02-13 07:35:14'),
(11, 'Hungarian Forint', 'Ft', 255.24000, 0, 'HUF', '2018-10-09 11:35:08', '2021-02-13 07:40:34'),
(12, 'Israeli New Sheqel', '₪', 3.48000, 0, 'ILS', '2018-10-09 11:35:08', '2021-02-13 07:35:23'),
(13, 'Japanese Yen', '¥', 107.12000, 0, 'JPY', '2018-10-09 11:35:08', '2021-02-13 07:35:23'),
(14, 'Malaysian Ringgit', 'RM', 3.91000, 0, 'MYR', '2018-10-09 11:35:08', '2021-02-13 07:40:42'),
(15, 'Mexican Peso', '$', 18.72000, 0, 'MXN', '2018-10-09 11:35:08', '2021-02-13 07:40:42'),
(16, 'Norwegian Krone', 'kr', 7.83000, 0, 'NOK', '2018-10-09 11:35:08', '2021-02-13 07:40:44'),
(17, 'New Zealand Dollar', '$', 1.38000, 0, 'NZD', '2018-10-09 11:35:08', '2021-02-13 07:40:46'),
(18, 'Philippine Peso', '₱', 52.26000, 0, 'PHP', '2018-10-09 11:35:08', '2021-02-13 07:40:47'),
(19, 'Polish Zloty', 'zł', 3.39000, 0, 'PLN', '2018-10-09 11:35:08', '2021-02-13 07:40:48'),
(20, 'Pound Sterling', '£', 0.72000, 0, 'GBP', '2018-10-09 11:35:08', '2021-02-13 07:40:50'),
(21, 'Russian Ruble', 'руб', 55.93000, 1, 'RUB', '2018-10-09 11:35:08', '2021-02-13 07:40:51'),
(22, 'Singapore Dollar', '$', 1.32000, 0, 'SGD', '2018-10-09 11:35:08', '2021-02-13 07:41:01'),
(23, 'Swedish Krona', 'kr', 8.19000, 0, 'SEK', '2018-10-09 11:35:08', '2021-02-13 07:41:01'),
(24, 'Swiss Franc', 'CHF', 0.94000, 0, 'CHF', '2018-10-09 11:35:08', '2021-02-13 07:41:02'),
(26, 'Thai Baht', '฿', 31.39000, 0, 'THB', '2018-10-09 11:35:08', '2021-02-13 07:41:03'),
(27, 'Taka', '৳', 84.00000, 0, 'BDT', '2018-10-09 11:35:08', '2021-02-13 07:41:04'),
(28, 'Indian Rupee', 'Rs', 68.45000, 0, 'Rupee', '2019-07-07 10:33:46', '2021-02-13 07:01:42'),
(29, 'Uzbek', 'Sum', 10.00000, 1, 'UZB', '2021-02-13 07:45:35', '2021-02-13 07:45:47'),
(30, 'Funt', '£', 11000.00000, 1, 'GBP', '2021-02-13 07:48:29', '2021-02-13 07:51:28'),
(31, 'GBP', 'Funt', 11000.00000, 0, 'Funt', '2021-02-13 07:48:32', '2021-02-13 07:48:32');

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 12 2021 г., 14:50
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 8, '2019-08-01 10:35:09', '2019-08-01 10:35:09'),
(5, 10, '2021-02-12 11:50:09', '2021-02-12 11:50:09');

-- --------------------------------------------------------

--
-- Структура таблицы `customer_packages`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `customer_packages`;
CREATE TABLE `customer_packages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` double(20,2) DEFAULT NULL,
  `product_upload` int(11) DEFAULT NULL,
  `logo` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `customer_package_payments`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `customer_package_payments`;
CREATE TABLE `customer_package_payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_package_id` int(11) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_details` longtext COLLATE utf8_unicode_ci NOT NULL,
  `approval` int(1) NOT NULL,
  `offline_payment` int(1) NOT NULL COMMENT '1=offline payment\r\n2=online paymnet',
  `reciept` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `customer_package_translations`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `customer_package_translations`;
CREATE TABLE `customer_package_translations` (
  `id` bigint(20) NOT NULL,
  `customer_package_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `customer_products`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `customer_products`;
CREATE TABLE `customer_products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `added_by` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `subsubcategory_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `photos` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail_img` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conditon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` text COLLATE utf8_unicode_ci,
  `video_provider` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_link` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `unit_price` double(20,2) DEFAULT '0.00',
  `meta_title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_img` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pdf` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `customer_product_translations`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `customer_product_translations`;
CREATE TABLE `customer_product_translations` (
  `id` bigint(20) NOT NULL,
  `customer_product_id` bigint(20) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `flash_deals`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `flash_deals`;
CREATE TABLE `flash_deals` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` int(20) DEFAULT NULL,
  `end_date` int(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `featured` int(1) NOT NULL DEFAULT '0',
  `background_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `flash_deal_products`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `flash_deal_products`;
CREATE TABLE `flash_deal_products` (
  `id` int(11) NOT NULL,
  `flash_deal_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `discount` double(20,2) DEFAULT '0.00',
  `discount_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `flash_deal_translations`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `flash_deal_translations`;
CREATE TABLE `flash_deal_translations` (
  `id` bigint(20) NOT NULL,
  `flash_deal_id` bigint(20) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `general_settings`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `general_settings`;
CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `frontend_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `footer_logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_login_background` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_login_sidebar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `site_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_plus` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `general_settings`
--

INSERT INTO `general_settings` (`id`, `frontend_color`, `logo`, `footer_logo`, `admin_logo`, `admin_login_background`, `admin_login_sidebar`, `favicon`, `site_name`, `address`, `description`, `phone`, `email`, `facebook`, `instagram`, `twitter`, `youtube`, `google_plus`, `created_at`, `updated_at`) VALUES
(1, 'default', 'uploads/logo/pfdIuiMeXGkDAIpPEUrvUCbQrOHu484nbGfz77zB.png', NULL, 'uploads/admin_logo/wCgHrz0Q5QoL1yu4vdrNnQIr4uGuNL48CXfcxOuS.png', NULL, NULL, 'uploads/favicon/uHdGidSaRVzvPgDj6JFtntMqzJkwDk9659233jrb.png', 'Active Ecommerce CMS', 'Demo Address', 'Active eCommerce CMS is a Multi vendor system is such a platform to build a border less marketplace.', '1234567890', 'admin@example.com', 'https://www.facebook.com', 'https://www.instagram.com', 'https://www.twitter.com', 'https://www.youtube.com', 'https://www.googleplus.com', '2019-03-13 08:01:06', '2019-03-13 02:01:06');

-- --------------------------------------------------------

--
-- Структура таблицы `home_categories`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `home_categories`;
CREATE TABLE `home_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subsubcategories` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `home_categories`
--

INSERT INTO `home_categories` (`id`, `category_id`, `subsubcategories`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '[\"1\"]', 1, '2019-03-12 06:38:23', '2019-03-12 06:38:23'),
(2, 2, '[\"10\"]', 1, '2019-03-12 06:44:54', '2019-03-12 06:44:54');

-- --------------------------------------------------------

--
-- Структура таблицы `languages`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 13 2021 г., 07:24
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rtl` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `rtl`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 0, '2019-01-20 12:13:20', '2021-02-13 04:15:10'),
(6, 'Russian', 'ru', 0, '2021-02-13 04:00:07', '2021-02-13 04:17:34'),
(7, 'Uzbek', 'uz', 0, '2021-02-13 04:00:36', '2021-02-13 04:17:36');

-- --------------------------------------------------------

--
-- Структура таблицы `links`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `links`;
CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `manual_payment_methods`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `manual_payment_methods`;
CREATE TABLE `manual_payment_methods` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `heading` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `bank_info` text COLLATE utf8_unicode_ci,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text COLLATE utf32_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 12 2021 г., 15:20
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2021_02_01_130909_add_attrs_to_users_table', 2),
(4, '2021_02_05_045138_add_users_table_attrs', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_access_tokens`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 12:50
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('125ce8289850f80d9fea100325bf892fbd0deba1f87dbfc2ab81fb43d57377ec24ed65f7dc560e46', 1, 1, 'Personal Access Token', '[]', 0, '2019-07-30 04:51:13', '2019-07-30 04:51:13', '2020-07-30 10:51:13'),
('293d2bb534220c070c4e90d25b5509965d23d3ddbc05b1e29fb4899ae09420ff112dbccab1c6f504', 1, 1, 'Personal Access Token', '[]', 1, '2019-08-04 06:00:04', '2019-08-04 06:00:04', '2020-08-04 12:00:04'),
('32f45946d067f3cda6f268950555fba5b0ba0b5019ac3d22b0d31f765e1fd610f5f6296153704396', 10, 5, 'Personal Access Token', '[]', 0, '2021-02-12 12:49:45', '2021-02-12 12:49:45', '2023-01-13 15:49:45'),
('5262a0c97dceb3ddbfc12fd04a77e6c4ba4cc27703837b47d6287225201d0a6d47bdab4e996a0dd8', 10, 5, NULL, '[]', 0, '2021-02-12 12:10:40', '2021-02-12 12:10:40', '2022-02-12 15:10:40'),
('5363e91c7892acdd6417aa9c7d4987d83568e229befbd75be64282dbe8a88147c6c705e06c1fb2bf', 1, 1, 'Personal Access Token', '[]', 0, '2019-07-13 06:44:28', '2019-07-13 06:44:28', '2020-07-13 12:44:28'),
('67e1d3da94d4f27e18736647fa0a98c0f4c17a37af96586971d65ebaa9d19c8e56ef1b6aec8ac3e9', 10, 5, 'Personal Access Token', '[]', 0, '2021-02-12 12:49:32', '2021-02-12 12:49:32', '2023-01-13 15:49:32'),
('681b4a4099fac5e12517307b4027b54df94cbaf0cbf6b4bf496534c94f0ccd8a79dd6af9742d076b', 1, 1, 'Personal Access Token', '[]', 1, '2019-08-04 07:23:06', '2019-08-04 07:23:06', '2020-08-04 13:23:06'),
('6d229e3559e568df086c706a1056f760abc1370abe74033c773490581a042442154afa1260c4b6f0', 1, 1, 'Personal Access Token', '[]', 1, '2019-08-04 07:32:12', '2019-08-04 07:32:12', '2020-08-04 13:32:12'),
('6efc0f1fc3843027ea1ea7cd35acf9c74282f0271c31d45a164e7b27025a315d31022efe7bb94aaa', 1, 1, 'Personal Access Token', '[]', 0, '2019-08-08 02:35:26', '2019-08-08 02:35:26', '2020-08-08 08:35:26'),
('7003b32086e6255a446d3523a675dfddb985670ca02323631c9dc3b763430ccd085fdadecf7e316b', 10, 5, NULL, '[]', 0, '2021-02-12 11:50:12', '2021-02-12 11:50:12', '2022-02-12 14:50:12'),
('7745b763da15a06eaded371330072361b0524c41651cf48bf76fc1b521a475ece78703646e06d3b0', 1, 1, 'Personal Access Token', '[]', 1, '2019-08-04 07:29:44', '2019-08-04 07:29:44', '2020-08-04 13:29:44'),
('815b625e239934be293cd34479b0f766bbc1da7cc10d464a2944ddce3a0142e943ae48be018ccbd0', 1, 1, 'Personal Access Token', '[]', 1, '2019-07-22 02:07:47', '2019-07-22 02:07:47', '2020-07-22 08:07:47'),
('84f89fe7f4ea539314b9871c737ef854e65e0bd15cfd577e19e6ac25277336d9cc6905c8eb6a6802', 10, 5, 'Personal Access Token', '[]', 0, '2021-02-12 12:17:32', '2021-02-12 12:17:32', '2023-01-13 15:17:32'),
('8921a4c96a6d674ac002e216f98855c69de2568003f9b4136f6e66f4cb9545442fb3e37e91a27cad', 1, 1, 'Personal Access Token', '[]', 1, '2019-08-04 06:05:05', '2019-08-04 06:05:05', '2020-08-04 12:05:05'),
('8d8b85720304e2f161a66564cec0ecd50d70e611cc0efbf04e409330086e6009f72a39ce2191f33a', 1, 1, 'Personal Access Token', '[]', 1, '2019-08-04 06:44:35', '2019-08-04 06:44:35', '2020-08-04 12:44:35'),
('932e2e3475ab9207094d0e0b553e3de39b31b15a88042c7f13335b4a33bbc392065a6bd48f2ba43b', 10, 5, NULL, '[]', 0, '2021-02-12 12:10:47', '2021-02-12 12:10:47', '2022-02-12 15:10:47'),
('ae21fb55a15c210ba898cc0d848ec3686a37e8ed09dea62372346486c5847053b6ef61f7d6c8e69c', 10, 5, 'Personal Access Token', '[]', 0, '2021-02-12 12:15:19', '2021-02-12 12:15:19', '2023-01-13 15:15:19'),
('b00aa5f682c4bf818c05d901e38ed708d398d810302b2313271ce159d9331e153a860ef15909bc04', 10, 5, 'Personal Access Token', '[]', 0, '2021-02-12 12:30:28', '2021-02-12 12:30:28', '2023-01-13 15:30:28'),
('bcaaebdead4c0ef15f3ea6d196fd80749d309e6db8603b235e818cb626a5cea034ff2a55b66e3e1a', 1, 1, 'Personal Access Token', '[]', 1, '2019-08-04 07:14:32', '2019-08-04 07:14:32', '2020-08-04 13:14:32'),
('c25417a5c728073ca8ba57058ded43d496a9d2619b434d2a004dd490a64478c08bc3e06ffc1be65d', 1, 1, 'Personal Access Token', '[]', 1, '2019-07-30 01:45:31', '2019-07-30 01:45:31', '2020-07-30 07:45:31'),
('c4c5e48a052106daa5519c21ef59f9709c98868fbe61fd31f222be58edf81b8ae3fa3a3267564b9a', 10, 5, 'Personal Access Token', '[]', 0, '2021-02-15 09:38:24', '2021-02-15 09:38:24', '2023-01-16 12:38:24'),
('c7423d85b2b5bdc5027cb283be57fa22f5943cae43f60b0ed27e6dd198e46f25e3501b3081ed0777', 1, 1, 'Personal Access Token', '[]', 1, '2019-08-05 05:02:59', '2019-08-05 05:02:59', '2020-08-05 11:02:59'),
('cb8e1c8ad8158592ebbdc65319e9aaab1c3b8762b315a8e7e3c34a99076d3ba8c57c638405288e83', 9, 5, 'Personal Access Token', '[]', 0, '2021-02-15 09:49:06', '2021-02-15 09:49:06', '2023-01-16 12:49:06'),
('cfb55e41927ef087851c4c9772921f7d61e1cd42d435d17ec2e2399699fcf0766beee2cef5b4b387', 9, 5, 'Personal Access Token', '[]', 0, '2021-02-15 03:05:49', '2021-02-15 03:05:49', '2023-01-16 06:05:49'),
('d1e9d23e21bb05cce30d28e2ccf2051c9bdcd0df417248a8857dddbac172d69a0cb8baf2d01d7f8c', 10, 5, 'Personal Access Token', '[]', 0, '2021-02-15 02:00:27', '2021-02-15 02:00:27', '2023-01-16 05:00:27'),
('d8db0b5e31de08f41db7426048f58dd170400215de72af5ed89dc98255df97d34c515fc3ca8ebf3f', 10, 5, 'Personal Access Token', '[]', 0, '2021-02-15 09:50:16', '2021-02-15 09:50:16', '2023-01-16 12:50:16'),
('e0bbf679d41df7a6aa6f847308674d0acd7f65f14d0f601f52e94b31f74f28470bb01eb86001a58c', 10, 5, 'Personal Access Token', '[]', 0, '2021-02-15 06:35:14', '2021-02-15 06:35:14', '2023-01-16 09:35:14'),
('e76f19dbd5c2c4060719fb1006ac56116fd86f7838b4bf74e2c0a0ac9696e724df1e517dbdb357f4', 1, 1, 'Personal Access Token', '[]', 1, '2019-07-15 02:53:40', '2019-07-15 02:53:40', '2020-07-15 08:53:40'),
('ed7c269dd6f9a97750a982f62e0de54749be6950e323cdfef892a1ec93f8ddbacf9fe26e6a42180e', 1, 1, 'Personal Access Token', '[]', 1, '2019-07-13 06:36:45', '2019-07-13 06:36:45', '2020-07-13 12:36:45'),
('eed9a4ba8f24b03c1bdbf675f1ff8488161b60bc6ef7cf13c7d987053b967c6bafb9f8d53766e6e8', 10, 5, 'Personal Access Token', '[]', 0, '2021-02-15 02:51:30', '2021-02-15 02:51:30', '2023-01-16 05:51:30'),
('f62cfb069ea1f99fa470c642b192a15097d61037201ef148b8f9d2667231cf6c7ae6ee8128209e1d', 10, 5, 'Personal Access Token', '[]', 0, '2021-02-15 09:42:01', '2021-02-15 09:42:01', '2023-01-16 12:42:01'),
('f6d1475bc17a27e389000d3df4da5c5004ce7610158b0dd414226700c0f6db48914637b4c76e1948', 1, 1, 'Personal Access Token', '[]', 1, '2019-08-04 07:22:01', '2019-08-04 07:22:01', '2020-08-04 13:22:01'),
('f85e4e444fc954430170c41779a4238f84cd6fed905f682795cd4d7b6a291ec5204a10ac0480eb30', 1, 1, 'Personal Access Token', '[]', 1, '2019-07-30 06:38:49', '2019-07-30 06:38:49', '2020-07-30 12:38:49'),
('f8bf983a42c543b99128296e4bc7c2d17a52b5b9ef69670c629b93a653c6a4af27be452e0c331f79', 1, 1, 'Personal Access Token', '[]', 1, '2019-08-04 07:28:55', '2019-08-04 07:28:55', '2020-08-04 13:28:55');

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_auth_codes`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_clients`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 12 2021 г., 12:46
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'eR2y7WUuem28ugHKppFpmss7jPyOHZsMkQwBo1Jj', 'http://localhost', 1, 0, 0, '2019-07-13 06:17:34', '2019-07-13 06:17:34'),
(2, NULL, 'Laravel Password Grant Client', 'WLW2Ol0GozbaXEnx1NtXoweYPuKEbjWdviaUgw77', 'http://localhost', 0, 1, 0, '2019-07-13 06:17:34', '2019-07-13 06:17:34'),
(3, NULL, 'Test Personal Access Client', 'LH7jyypHj1uDWQLOIbFKunEzgxGSZjXf2n8a3w2i', 'http://localhost', 1, 0, 0, '2021-02-10 02:19:58', '2021-02-10 02:19:58'),
(4, NULL, 'Test Password Grant Client', 'aq7EAZriHO5kYqWKCUyGgteKKtm9sT7XW7pzxRhz', 'http://localhost', 0, 1, 0, '2021-02-10 02:19:58', '2021-02-10 02:19:58'),
(5, NULL, 'MarketPlace Personal Access Client', 'nBGgoiGOSqcSNYnSmsg4z9Npr7YrbvdkyTVqKOxE', 'http://localhost', 1, 0, 0, '2021-02-12 09:46:11', '2021-02-12 09:46:11'),
(6, NULL, 'MarketPlace Password Grant Client', '5I2q8kg0Dw39Zi2XW0bUcsd6oOEjkhbMilIzOtr8', 'http://localhost', 0, 1, 0, '2021-02-12 09:46:11', '2021-02-12 09:46:11');

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_personal_access_clients`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 12 2021 г., 12:46
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-07-13 06:17:34', '2019-07-13 06:17:34'),
(2, 3, '2021-02-10 02:19:58', '2021-02-10 02:19:58'),
(3, 5, '2021-02-12 09:46:11', '2021-02-12 09:46:11');

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_refresh_tokens`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 12:38
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `shipping_address` longtext COLLATE utf8_unicode_ci,
  `payment_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manual_payment` int(1) NOT NULL DEFAULT '0',
  `manual_payment_data` text COLLATE utf8_unicode_ci,
  `payment_status` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'unpaid',
  `payment_details` longtext COLLATE utf8_unicode_ci,
  `grand_total` double(20,2) DEFAULT NULL,
  `coupon_discount` double(20,2) NOT NULL DEFAULT '0.00',
  `code` mediumtext COLLATE utf8_unicode_ci,
  `date` int(20) NOT NULL,
  `viewed` int(1) NOT NULL DEFAULT '0',
  `delivery_viewed` int(1) NOT NULL DEFAULT '1',
  `payment_status_viewed` int(1) DEFAULT '1',
  `commission_calculated` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `guest_id`, `shipping_address`, `payment_type`, `manual_payment`, `manual_payment_data`, `payment_status`, `payment_details`, `grand_total`, `coupon_discount`, `code`, `date`, `viewed`, `delivery_viewed`, `payment_status_viewed`, `commission_calculated`, `created_at`, `updated_at`) VALUES
(4, 10, NULL, '{\"name\":\"Akhrarov Asadbek Rovshanovich\",\"email\":\"asad.lion.0607@mail.ru\",\"address\":\"Yunusobod distr. , Zarbuloq str. 1\\/32\",\"country\":\"Uzbekistan\",\"city\":\"Tashkent\",\"postal_code\":\"100058\",\"phone\":\"+998977808008\",\"checkout_type\":null}', 'cash_on_delivery', 0, NULL, 'paid', NULL, 6254098.39, 0.00, '20210212-033721', 1613144241, 1, 0, 0, 1, '2021-02-12 12:37:21', '2021-02-15 03:15:15'),
(5, NULL, 216468, '{\"name\":null,\"email\":null,\"address\":null,\"country\":\"Afghanistan\",\"city\":null,\"postal_code\":null,\"phone\":null}', 'cash', 0, NULL, 'paid', 'cash', 22670.55, 0.00, '20210214-06212435', 1613283684, 0, 0, 0, 0, '2021-02-14 03:21:24', '2021-02-14 03:21:24'),
(6, NULL, 624843, '{\"name\":null,\"email\":null,\"address\":null,\"country\":\"Afghanistan\",\"city\":null,\"postal_code\":null,\"phone\":null}', 'cash', 0, NULL, 'paid', 'cash', 22670.55, 0.00, '20210214-06212726', 1613283687, 0, 0, 0, 0, '2021-02-14 03:21:27', '2021-02-14 03:21:27'),
(7, NULL, 552292, '{\"name\":null,\"email\":null,\"address\":null,\"country\":\"Afghanistan\",\"city\":null,\"postal_code\":null,\"phone\":null}', 'cash', 0, NULL, 'paid', 'cash', 22670.55, 0.00, '20210214-06213173', 1613283691, 0, 0, 0, 0, '2021-02-14 03:21:31', '2021-02-14 03:21:31'),
(8, NULL, 347257, '{\"name\":\"Asad\",\"email\":\"admin@admin.uz\",\"address\":null,\"country\":\"Afghanistan\",\"city\":\"Test\",\"postal_code\":\"12312213\",\"phone\":\"1231231231231\"}', 'cash', 0, NULL, 'paid', 'cash', 22670.55, 0.00, '20210214-06224619', 1613283766, 0, 0, 0, 0, '2021-02-14 03:22:46', '2021-02-14 03:22:46'),
(9, NULL, 107856, '{\"name\":null,\"email\":null,\"address\":null,\"country\":\"Afghanistan\",\"city\":null,\"postal_code\":null,\"phone\":null}', 'cash', 0, NULL, 'paid', 'cash', 22670.55, 0.00, '20210215-06465791', 1613371617, 0, 0, 0, 0, '2021-02-15 03:46:57', '2021-02-15 03:46:57'),
(10, NULL, 193282, '{\"name\":null,\"email\":null,\"address\":null,\"country\":\"Afghanistan\",\"city\":null,\"postal_code\":null,\"phone\":null}', 'cash', 0, NULL, 'paid', 'cash', 22670.55, 0.00, '20210215-06470079', 1613371620, 0, 0, 0, 0, '2021-02-15 03:47:00', '2021-02-15 03:47:00'),
(11, NULL, 954557, '{\"name\":null,\"email\":null,\"address\":null,\"country\":\"Afghanistan\",\"city\":null,\"postal_code\":null,\"phone\":null}', 'cash', 0, NULL, 'paid', 'cash', 22670.55, 0.00, '20210215-06470890', 1613371628, 0, 0, 0, 0, '2021-02-15 03:47:08', '2021-02-15 03:47:08'),
(12, NULL, 880972, '{\"name\":null,\"email\":null,\"address\":null,\"country\":\"Afghanistan\",\"city\":null,\"postal_code\":null,\"phone\":null}', 'cash', 0, NULL, 'paid', 'cash', 22670.55, 0.00, '20210215-06494020', 1613371780, 0, 0, 0, 0, '2021-02-15 03:49:40', '2021-02-15 03:49:40'),
(13, NULL, 288406, '{\"name\":null,\"email\":null,\"address\":null,\"country\":\"Afghanistan\",\"city\":null,\"postal_code\":null,\"phone\":null}', 'cash', 0, NULL, 'paid', 'cash', 22670.55, 0.00, '20210215-06510595', 1613371865, 0, 0, 0, 1, '2021-02-15 03:51:05', '2021-02-15 03:51:05'),
(14, NULL, 860143, '{\"name\":\"Test\",\"email\":\"admin@admin.uz\",\"address\":null,\"country\":\"Afghanistan\",\"city\":\"asdsad\",\"postal_code\":\"123123\",\"phone\":\"123123\"}', 'cash', 0, NULL, 'paid', 'cash', 4371831.90, 0.00, '20210215-06515980', 1613371919, 0, 0, 0, 1, '2021-02-15 03:51:59', '2021-02-15 03:51:59'),
(15, NULL, 396884, '{\"name\":null,\"email\":null,\"address\":null,\"country\":\"Afghanistan\",\"city\":null,\"postal_code\":null,\"phone\":null}', 'cash', 0, NULL, 'paid', 'cash', 3537.41, 0.00, '20210215-06522873', 1613371948, 0, 0, 0, 1, '2021-02-15 03:52:28', '2021-02-15 03:52:28'),
(16, 10, NULL, '{\"name\":\"Akhrarov Asadbek Rovshanovich\",\"email\":\"asad.lion.0607@mail.ru\",\"address\":\"Yunusobod distr. , Zarbuloq str. 1\\/32\",\"country\":\"Uzbekistan\",\"city\":\"Tashkent\",\"postal_code\":\"100058\",\"phone\":\"+998977808008\",\"checkout_type\":null}', 'cash_on_delivery', 0, NULL, 'unpaid', NULL, 2672.00, 0.00, '20210215-094112', 1613382072, 0, 1, 1, 0, '2021-02-15 06:41:12', '2021-02-15 06:41:12'),
(17, 10, NULL, '{\"name\":\"Akhrarov Asadbek Rovshanovich\",\"email\":\"asad.lion.0607@mail.ru\",\"address\":\"Yunusobod distr. , Zarbuloq str. 1\\/32\",\"country\":\"Uzbekistan\",\"city\":\"Tashkent\",\"postal_code\":\"100058\",\"phone\":\"+998977808008\",\"checkout_type\":null}', 'cash_on_delivery', 0, NULL, 'unpaid', NULL, 10627430.29, 0.00, '20210215-123847', 1613392727, 0, 1, 1, 0, '2021-02-15 09:38:47', '2021-02-15 09:38:47');

-- --------------------------------------------------------

--
-- Структура таблицы `order_details`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 12:38
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `variation` longtext COLLATE utf8_unicode_ci,
  `price` double(20,2) DEFAULT NULL,
  `tax` double(20,2) NOT NULL DEFAULT '0.00',
  `shipping_cost` double(20,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) DEFAULT NULL,
  `payment_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unpaid',
  `delivery_status` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'pending',
  `shipping_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pickup_point_id` int(11) DEFAULT NULL,
  `product_referral_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `seller_id`, `product_id`, `variation`, `price`, `tax`, `shipping_cost`, `quantity`, `payment_status`, `delivery_status`, `shipping_type`, `pickup_point_id`, `product_referral_code`, `created_at`, `updated_at`) VALUES
(5, 4, 9, 5, 'Aquamarine-64/128Gb', 6254098.39, 0.00, 100.00, 1, 'paid', 'delivered', NULL, NULL, NULL, '2021-02-12 12:37:21', '2021-02-15 03:15:15'),
(6, 5, 9, 3, 'Aqua-1GB', 21591.00, 1079.55, 0.00, 1, 'paid', 'pending', NULL, NULL, NULL, '2021-02-14 03:21:24', '2021-02-14 03:21:24'),
(7, 6, 9, 3, 'Aqua-1GB', 21591.00, 1079.55, 0.00, 1, 'paid', 'pending', NULL, NULL, NULL, '2021-02-14 03:21:27', '2021-02-14 03:21:27'),
(8, 7, 9, 3, 'Aqua-1GB', 21591.00, 1079.55, 0.00, 1, 'paid', 'pending', NULL, NULL, NULL, '2021-02-14 03:21:31', '2021-02-14 03:21:31'),
(9, 8, 9, 3, 'Aqua-1GB', 21591.00, 1079.55, 0.00, 1, 'paid', 'pending', NULL, NULL, NULL, '2021-02-14 03:22:46', '2021-02-14 03:22:46'),
(10, 9, 9, 3, 'DarkGray-1GB', 21591.00, 1079.55, 0.00, 1, 'paid', 'pending', NULL, NULL, NULL, '2021-02-15 03:46:57', '2021-02-15 03:46:57'),
(11, 10, 9, 3, 'DarkGray-1GB', 21591.00, 1079.55, 0.00, 1, 'paid', 'pending', NULL, NULL, NULL, '2021-02-15 03:47:00', '2021-02-15 03:47:00'),
(12, 11, 9, 3, 'DarkGray-1GB', 21591.00, 1079.55, 0.00, 1, 'paid', 'pending', NULL, NULL, NULL, '2021-02-15 03:47:08', '2021-02-15 03:47:08'),
(13, 12, 9, 3, 'DarkGray-1GB', 21591.00, 1079.55, 0.00, 1, 'paid', 'pending', NULL, NULL, NULL, '2021-02-15 03:49:40', '2021-02-15 03:49:40'),
(14, 13, 9, 3, 'DarkGray-1GB', 21591.00, 1079.55, 0.00, 1, 'paid', 'pending', NULL, NULL, NULL, '2021-02-15 03:51:05', '2021-02-15 03:51:05'),
(15, 14, 9, 4, 'Bisque-128GB', 19791.00, 4352040.90, 0.00, 1, 'paid', 'pending', NULL, NULL, NULL, '2021-02-15 03:51:59', '2021-02-15 03:51:59'),
(16, 15, 9, 17, 'Black', 3158.40, 379.01, 0.00, 1, 'paid', 'pending', NULL, NULL, NULL, '2021-02-15 03:52:28', '2021-02-15 03:52:28'),
(17, 16, 9, 20, 'AliceBlue-256-8', 1000.00, 0.00, 0.00, 1, 'unpaid', 'pending', NULL, NULL, NULL, '2021-02-15 06:41:12', '2021-02-15 06:41:12'),
(18, 16, 9, 10, 'YellowGreen-32GB', 224.00, 0.00, 100.00, 1, 'unpaid', 'pending', NULL, NULL, NULL, '2021-02-15 06:41:12', '2021-02-15 06:41:12'),
(19, 16, 9, 20, 'AliceBlue-64-8', 1000.00, 0.00, 0.00, 1, 'unpaid', 'pending', NULL, NULL, NULL, '2021-02-15 06:41:12', '2021-02-15 06:41:12'),
(20, 16, 9, 10, 'Black-32GB', 224.00, 0.00, 100.00, 1, 'unpaid', 'pending', NULL, NULL, NULL, '2021-02-15 06:41:12', '2021-02-15 06:41:12'),
(21, 16, 9, 10, 'AliceBlue-32GB', 224.00, 0.00, 100.00, 1, 'unpaid', 'pending', NULL, NULL, NULL, '2021-02-15 06:41:12', '2021-02-15 06:41:12'),
(22, 17, 9, 5, 'AntiqueWhite-64/128Gb', 6254098.39, 0.00, 100.00, 1, 'unpaid', 'pending', NULL, NULL, NULL, '2021-02-15 09:38:47', '2021-02-15 09:38:47'),
(23, 17, 9, 20, 'AliceBlue-64-8', 1500.00, 0.00, 0.00, 1, 'unpaid', 'pending', NULL, NULL, NULL, '2021-02-15 09:38:47', '2021-02-15 09:38:47'),
(24, 17, 9, 4, 'Azure-128GB', 4371831.90, 0.00, 100.00, 1, 'unpaid', 'pending', NULL, NULL, NULL, '2021-02-15 09:38:47', '2021-02-15 09:38:47');

-- --------------------------------------------------------

--
-- Структура таблицы `otp_configurations`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `otp_configurations`;
CREATE TABLE `otp_configurations` (
  `id` int(11) NOT NULL,
  `type` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `otp_configurations`
--

INSERT INTO `otp_configurations` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'nexmo', '1', '2020-03-22 09:19:07', '2020-03-22 09:19:07'),
(2, 'otp_for_order', '1', '2020-03-22 09:19:07', '2020-03-22 09:19:07'),
(3, 'otp_for_delivery_status', '1', '2020-03-22 09:19:37', '2020-03-22 09:19:37'),
(4, 'otp_for_paid_status', '0', '2020-03-22 09:19:37', '2020-03-22 09:19:37'),
(5, 'twillo', '0', '2020-03-22 09:54:03', '2020-03-22 03:54:20'),
(6, 'ssl_wireless', '0', '2020-03-22 09:54:03', '2020-03-22 03:54:20'),
(7, 'fast2sms', '0', '2020-03-22 09:54:03', '2020-03-22 03:54:20'),
(8, 'mimo', '0', '2020-12-27 09:54:03', '2020-12-28 03:54:20');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `meta_title` text COLLATE utf8_unicode_ci,
  `meta_description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `type`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `keywords`, `meta_image`, `created_at`, `updated_at`) VALUES
(1, 'home_page', 'Home Page', 'home', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:13:20', '2020-11-04 10:13:20'),
(2, 'seller_policy_page', 'Seller Policy Pages', 'sellerpolicy', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:14:41', '2020-11-04 12:19:30'),
(3, 'return_policy_page', 'Return Policy Page', 'returnpolicy', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:14:41', '2020-11-04 10:14:41'),
(4, 'support_policy_page', 'Support Policy Page', 'supportpolicy', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:14:59', '2020-11-04 10:14:59'),
(5, 'terms_conditions_page', 'Term Conditions Page', 'terms', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:15:29', '2020-11-04 10:15:29'),
(6, 'privacy_policy_page', 'Privacy Policy Page', 'privacypolicy', NULL, NULL, NULL, NULL, NULL, '2020-11-04 10:15:55', '2020-11-04 10:15:55');

-- --------------------------------------------------------

--
-- Структура таблицы `page_translations`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `page_translations`;
CREATE TABLE `page_translations` (
  `id` bigint(20) NOT NULL,
  `page_id` bigint(20) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 13 2021 г., 18:17
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL DEFAULT '0.00',
  `payment_details` longtext COLLATE utf8_unicode_ci,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `txn_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`id`, `seller_id`, `amount`, `payment_details`, `payment_method`, `txn_code`, `created_at`, `updated_at`) VALUES
(1, 1, 78.40, NULL, 'cash', NULL, '2021-02-13 15:17:24', '2021-02-13 15:17:24');

-- --------------------------------------------------------

--
-- Структура таблицы `pickup_points`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `pickup_points`;
CREATE TABLE `pickup_points` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `pick_up_status` int(1) DEFAULT NULL,
  `cash_on_pickup_status` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `pickup_point_translations`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `pickup_point_translations`;
CREATE TABLE `pickup_point_translations` (
  `id` bigint(20) NOT NULL,
  `pickup_point_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `policies`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `policies`;
CREATE TABLE `policies` (
  `id` int(11) NOT NULL,
  `name` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `policies`
--

INSERT INTO `policies` (`id`, `name`, `content`, `created_at`, `updated_at`) VALUES
(1, 'support_policy', NULL, '2019-10-29 12:54:45', '2019-01-22 05:13:15'),
(2, 'return_policy', NULL, '2019-10-29 12:54:47', '2019-01-24 05:40:11'),
(4, 'seller_policy', NULL, '2019-10-29 12:54:49', '2019-02-04 17:50:15'),
(5, 'terms', NULL, '2019-10-29 12:54:51', '2019-10-28 18:00:00'),
(6, 'privacy_policy', NULL, '2019-10-29 12:54:54', '2019-10-28 18:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 12:43
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `added_by` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'admin',
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `subsubcategory_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `photos` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_provider` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_link` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `unit_price` double(20,2) NOT NULL,
  `purchase_price` double(20,2) NOT NULL,
  `variant_product` int(1) NOT NULL DEFAULT '0',
  `attributes` varchar(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[]',
  `choice_options` mediumtext COLLATE utf8_unicode_ci,
  `colors` mediumtext COLLATE utf8_unicode_ci,
  `variations` text COLLATE utf8_unicode_ci,
  `todays_deal` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '1',
  `featured` int(11) NOT NULL DEFAULT '0',
  `seller_featured` int(11) NOT NULL DEFAULT '0',
  `current_stock` int(10) NOT NULL DEFAULT '0',
  `unit` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `min_qty` int(11) NOT NULL DEFAULT '1',
  `discount` double(20,2) DEFAULT NULL,
  `discount_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax` double(20,2) DEFAULT NULL,
  `tax_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_type` varchar(20) CHARACTER SET latin1 DEFAULT 'flat_rate',
  `shipping_cost` double(20,2) DEFAULT '0.00',
  `num_of_sale` int(11) NOT NULL DEFAULT '0',
  `meta_title` mediumtext COLLATE utf8_unicode_ci,
  `meta_description` longtext COLLATE utf8_unicode_ci,
  `meta_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `refundable` int(1) NOT NULL DEFAULT '0',
  `earn_point` double(8,2) NOT NULL DEFAULT '0.00',
  `rating` double(8,2) NOT NULL DEFAULT '0.00',
  `barcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `digital` int(1) NOT NULL DEFAULT '0',
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `added_by`, `user_id`, `category_id`, `subcategory_id`, `subsubcategory_id`, `brand_id`, `photos`, `thumbnail_img`, `video_provider`, `video_link`, `tags`, `description`, `unit_price`, `purchase_price`, `variant_product`, `attributes`, `choice_options`, `colors`, `variations`, `todays_deal`, `published`, `featured`, `seller_featured`, `current_stock`, `unit`, `min_qty`, `discount`, `discount_type`, `tax`, `tax_type`, `shipping_type`, `shipping_cost`, `num_of_sale`, `meta_title`, `meta_description`, `meta_img`, `pdf`, `slug`, `refundable`, `earn_point`, `rating`, `barcode`, `digital`, `file_name`, `file_path`, `created_at`, `updated_at`) VALUES
(2, 'Xiaomi Redmi Note 9 Pro', 'admin', 9, 0, NULL, NULL, 1, '2', '2', 'youtube', NULL, 'xiaomi', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Смартфон с большим безрамочным экраном. 6,67-дюймовый дисплей, разрешение которого составляет 2400х1080 пикселей. Основная камера состоит из четырех модулей. Главный модуль на 64 Мп. Она делает сверхчеткие снимки, записывает видео в формате 4K, а также предоставляет множество других творческих возможностей.</div></div></div></div></div></div>', 23990.00, 23990.00, 0, '[]', '[]', '[]', NULL, 0, 1, 1, 0, -1, 'KG', 1, 10.00, 'percent', 23990.00, 'percent', 'free', 0.00, 1, 'Xiaomi Redmi Note 9 Pro', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Смартфон с большим безрамочным экраном. 6,67-дюймовый дисплей, разрешение которого составляет 2400х1080 пикселей. Основная камера состоит из четырех модулей. Главный модуль на 64 Мп. Она делает сверхчеткие снимки, записывает видео в формате 4K, а также предоставляет множество других творческих возможностей.</div></div></div></div></div></div>', NULL, NULL, 'Xiaomi-Redmi-Note-9-Pro-Pgt2z', 1, 0.00, 0.00, NULL, 0, NULL, NULL, '2021-02-11 10:30:43', '2021-02-15 09:43:43'),
(3, 'Смарт-часы Xiaomi Haylou Solar LS05', 'admin', 9, 0, NULL, NULL, 2, '17', '16', 'youtube', NULL, 'smart-watch', '<p></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div><p></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Xiaomi Haylou Solar LS05&nbsp;— умные часы черного цвета с&nbsp;лучшими функциями на&nbsp;каждый день<br>Новинка бренда создана для тех, кто ведет активный образ жизни и&nbsp;хочет быть с&nbsp;инновациями повсюду. Модель сочетает в&nbsp;себе расширенный функционал, четкий дисплей-циферблат, емкий аккумулятор и&nbsp;производительную платформу&nbsp;— все&nbsp;то, что будет нужно каждый день.<br>Часы получили в&nbsp;расположение TFT-дисплей диагональю 1.28&nbsp;дюйма. Его высокое разрешение и&nbsp;большой запас яркости позволяют четко отображать текущие данные, обеспечивая максимальную информативность. Защищает дисплей закаленное стекло, стойкое к&nbsp;царапинам и&nbsp;другим мелким повреждениям.<br>Умные часы Xiaomi оборудованы энергоемким аккумулятором высокой плотности. Его главное преимущество&nbsp;— распределение энергии под контролем алгоритмов искусственного интеллекта. Они точно оптимизируют работу устройства, адаптируют аппаратную конфигурацию под реальные задачи и&nbsp;выполняют другие операции по&nbsp;повышению эффективности. Благодаря этому, часы способны проработать до&nbsp;30&nbsp;дней всего на&nbsp;одном заряде.<br>Умный девайс Сяоми оборудован большим количеством точных датчиков и&nbsp;сенсоров, позволяющих ему безошибочно распознавать 12&nbsp;видов спортивных активностей владельца. Благодаря поддержке такого количества режимов, девайс может точно анализировать затраченные калории, оценивать достигнутые результаты и&nbsp;своевременно информировать о&nbsp;необходимости отдыха.<br>Умные часы черного цвета не&nbsp;боятся экстремальных условий и&nbsp;могут оставаться на&nbsp;запястье владельца в&nbsp;абсолютно любой ситуации. Этому способствует надежность литого корпуса и&nbsp;комплексная герметизация в&nbsp;соответствии с&nbsp;классом IP68&nbsp;— пыль и&nbsp;вода ему не&nbsp;страшны.<br>В&nbsp;модели реализована функция контроля сна, которая может отслеживать фазы ночного отдыха, высчитывать оптимальное время пробуждения и&nbsp;даже давать рекомендации относительно улучшения сна. Точность анализа гарантирована датчиком сердечного ритма, задействованным системой. Смарт-вотч новой модели имеют целый арсенал интеллектуальных функций на&nbsp;каждый день. Они способны напоминать о&nbsp;запланированных событиях, уведомлять о&nbsp;входящих звонках и&nbsp;сообщениях, отображать прогноз погоды, управлять камерой подключенного смартфона, помогать в&nbsp;поиске телефона и&nbsp;многое другое. А&nbsp;регулярное обновление дополнительного софта и&nbsp;вовсе делает возможности девайса безграничными.<br>Специально для новой модели часов разработано мобильное приложение, позволяющее быстро настраивать их&nbsp;работу, выполнять синхронизацию, просматривать результаты собственных спортивных достижений и&nbsp;многое другое. При этом, софт доступен для устройств на&nbsp;базе Android и&nbsp;iOS, поэтому с&nbsp;совместимостью проблем не&nbsp;возникнет.<br></div></div></div></div></div></div>', 2.00, 2788.00, 1, '[\"5\"]', '[{\"attribute_id\":\"5\",\"values\":[\"1 GB\"]}]', '[\"#00FFFF\",\"#008B8B\",\"#A9A9A9\"]', NULL, 0, 1, 1, 0, -1, 'KG', 1, 10.00, 'percent', 5.00, 'percent', 'free', 0.00, 10, 'Xiaomi Redmi Note 9 Pro', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Смартфон с большим безрамочным экраном. 6,67-дюймовый дисплей, разрешение которого составляет 2400х1080 пикселей. Основная камера состоит из четырех модулей. Главный модуль на 64 Мп. Она делает сверхчеткие снимки, записывает видео в формате 4K, а также предоставляет множество других творческих возможностей.</div></div></div></div></div></div>', NULL, NULL, 'xiaomi-redmi-note-9-pro-sflmv', 1, 0.00, 0.00, NULL, 0, NULL, NULL, '2021-02-11 10:32:08', '2021-02-15 09:43:41'),
(4, 'Смартфон Poco X3 NFC 6', 'admin', 9, 0, NULL, NULL, 3, '3', '4', 'youtube', NULL, 'Poco x3 nfc 6', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Диагональ дисплея в POCO X3 составляет 6,67 дюймов при разрешении 2400х1080 пикселей. Соотношение сторон DotDisplay-экрана равняется 20:9. Частота обновления сенсора – 120 Гц, а уровень чувствительности прикосновений – 240 Гц при времени отклика 4,16 мс. Реализована защита зрительной системы от синего света с сертификатом TÜV Rheinland Low Blue Light certification.<br>Средний уровень производительности обеспечивается за счет работы процессора Qualcomm Snapdragon 732G. Он изготовлен по 8 нм техпроцессу, состоит из 8 ядер Kryo 470, максимальная ядерная частота которых достигает 2,3 ГГц. Графика обрабатывается видеоускорителем Adreno 618. Установлена внутренняя память типа LPDDR4X и встроенная UFS2.1.<br>Разрешение основного сенсора равняется 64 мегапикселям, широкоугольного модуля – 13 МР. Макроснимки и размытие фона на портретов обеспечиваются за счет двух 2-мегапиксельных датчиков. Реализована поддержка съемки видео в 4К при 30fps.<br>Фронтальная камера представлена матрицей на 20 мегапикселей с поддержкой технологии искусственного интеллекта.<br>Особенность POCO X3 заключается в установке вибромоторов 4D, что обеспечивает высокий уровень комфорта во время игры. Беспроводные технологии Bluetooth 5.1 и Wi-Fi 2x2 MIMO позволяют быстро передавать данные на расстоянии.<br>Бесконтактная оплата товаров и услуг осуществляется через чип NFC. В телефоне установлены ИК-датчик, гироскоп, акселерометр и 3,5 мм аудиоразъем.<br>Емкость полимерной литий-ионной встроенной батареи равняется 5160 мАч. Для зарядки используется кабель USB Type-C, который поставляется в комплекте с зарядным устройством мощностью 33 Вт. Поддерживается технология быстрой зарядки.</div></div></div></div></div></div>', 21990.00, 21990.00, 1, '[\"5\"]', '[{\"attribute_id\":\"5\",\"values\":[\"128 GB\"]}]', '[\"#F0FFFF\",\"#FFE4C4\"]', NULL, 0, 1, 1, 0, -1, 'Kg', 1, 10.00, 'percent', 21990.00, 'percent', 'flat_rate', 100.00, 3, 'Смартфон Poco X3 NFC 6', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Диагональ дисплея в POCO X3 составляет 6,67 дюймов при разрешении 2400х1080 пикселей. Соотношение сторон DotDisplay-экрана равняется 20:9. Частота обновления сенсора – 120 Гц, а уровень чувствительности прикосновений – 240 Гц при времени отклика 4,16 мс. Реализована защита зрительной системы от синего света с сертификатом TÜV Rheinland Low Blue Light certification.<br>Средний уровень производительности обеспечивается за счет работы процессора Qualcomm Snapdragon 732G. Он изготовлен по 8 нм техпроцессу, состоит из 8 ядер Kryo 470, максимальная ядерная частота которых достигает 2,3 ГГц. Графика обрабатывается видеоускорителем Adreno 618. Установлена внутренняя память типа LPDDR4X и встроенная UFS2.1.<br>Разрешение основного сенсора равняется 64 мегапикселям, широкоугольного модуля – 13 МР. Макроснимки и размытие фона на портретов обеспечиваются за счет двух 2-мегапиксельных датчиков. Реализована поддержка съемки видео в 4К при 30fps.<br>Фронтальная камера представлена матрицей на 20 мегапикселей с поддержкой технологии искусственного интеллекта.<br>Особенность POCO X3 заключается в установке вибромоторов 4D, что обеспечивает высокий уровень комфорта во время игры. Беспроводные технологии Bluetooth 5.1 и Wi-Fi 2x2 MIMO позволяют быстро передавать данные на расстоянии.<br>Бесконтактная оплата товаров и услуг осуществляется через чип NFC. В телефоне установлены ИК-датчик, гироскоп, акселерометр и 3,5 мм аудиоразъем.<br>Емкость полимерной литий-ионной встроенной батареи равняется 5160 мАч. Для зарядки используется кабель USB Type-C, который поставляется в комплекте с зарядным устройством мощностью 33 Вт. Поддерживается технология быстрой зарядки.</div></div></div></div></div></div>', NULL, NULL, '-poco-x3-nfc-6-p3xy2', 1, 0.00, 0.00, NULL, 0, NULL, NULL, '2021-02-11 10:51:21', '2021-02-15 09:43:38'),
(5, 'Samsung Galaxy A51', 'admin', 9, 0, NULL, NULL, 4, '5', '5', 'youtube', NULL, 'SAMSUNG GALAXY A51', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Модель сертификации EAC/ бывший Ростест, один год официальной гарантии от производителя Samsung, гарантийное обслуживание во всех автоматизированных центрах.<br>Безграничный экран Galaxy A51 оптимизирует визуальную симметрию. Теперь ты можешь играть, смотреть фильмы, бродить по сети и работать в многозадачном режиме без перерыва на ярком 6.5-дюймовом sAMOLED экране с FHD+ разрешением. Погрузись в контент с головой благодаря тонкой рамке дисплея и максимальной площади полезного пространства. Ростест</div></div></div></div></div></div>', 26311.00, 26311.00, 1, '[\"5\"]', '[{\"attribute_id\":\"5\",\"values\":[\"64\\/128Gb\"]}]', '[\"#FAEBD7\",\"#7FFFD4\",\"#FFE4C4\"]', NULL, 0, 1, 1, 0, -1, 'KG', 1, 10.00, 'percent', 26311.00, 'percent', 'flat_rate', 100.00, 3, 'Samsung Galaxy A51', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Модель сертификации EAC/ бывший Ростест, один год официальной гарантии от производителя Samsung, гарантийное обслуживание во всех автоматизированных центрах.<br>Безграничный экран Galaxy A51 оптимизирует визуальную симметрию. Теперь ты можешь играть, смотреть фильмы, бродить по сети и работать в многозадачном режиме без перерыва на ярком 6.5-дюймовом sAMOLED экране с FHD+ разрешением. Погрузись в контент с головой благодаря тонкой рамке дисплея и максимальной площади полезного пространства. Ростест</div></div></div></div></div></div>', NULL, NULL, 'Samsung-Galaxy-A51-IuLzz', 1, 0.00, 0.00, NULL, 0, NULL, NULL, '2021-02-11 11:01:39', '2021-02-15 09:43:33'),
(7, 'HD Телевизор Starwind SW-LED32SA303 32', 'admin', 9, 0, NULL, NULL, 3, '7', '8', 'youtube', NULL, 'Starwind SW-LED32SA303 32', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Телевизор LED Starwind SW-LED32SA303, чья потребляемая мощность не превышает 56 Вт, обладает размерами 732x434x74.8 мм (ширина, высота и толщина соответственно без учета подставки). Модель с 32-дюймовой (81 см) диагональю порадует требовательного телезрителя достойным качеством изображения, демонстрируемого в разрешении 1366x768 пикселей (формат HD). Благодаря лаконичной черной расцветке корпуса и подставки устройство впишется в любой интерьер. Функционал данной модели также хорош, как и качество картинки, транслируемой на экране в формате 16:9.<br>За счет подсветки Direct LED в сочетании с хорошими показателями яркости (200 Кд/м²) и контрастности (3000) телевизор Starwind SW-LED32SA303 гарантирует естественную цветопередачу изображения. Частота обновления экрана, равная 60 Гц, обеспечивает возможность просмотра динамичных фильмов без риска увидеть шлейфы, остающиеся за движущимися объектами. Модель функционирует на базе операционной системы Android TV и имеет поддержку Smart TV. Мощность звука встроенной акустической системы равняется 6 Вт.</div></div></div></div></div></div>', 8890.00, 8890.00, 1, '[\"9\",\"10\"]', '[{\"attribute_id\":\"9\",\"values\":[\"32\"]},{\"attribute_id\":\"10\",\"values\":[\"81\"]}]', '[\"#00FFFF\",\"#5F9EA0\",\"#DC143C\",\"#00FFFF\"]', NULL, 0, 1, 1, 0, 10, 'Kg', 1, 10.00, 'percent', 5.00, 'percent', 'flat_rate', 100.00, 0, 'HD Телевизор Starwind SW-LED32SA303 32', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Телевизор LED Starwind SW-LED32SA303, чья потребляемая мощность не превышает 56 Вт, обладает размерами 732x434x74.8 мм (ширина, высота и толщина соответственно без учета подставки). Модель с 32-дюймовой (81 см) диагональю порадует требовательного телезрителя достойным качеством изображения, демонстрируемого в разрешении 1366x768 пикселей (формат HD). Благодаря лаконичной черной расцветке корпуса и подставки устройство впишется в любой интерьер. Функционал данной модели также хорош, как и качество картинки, транслируемой на экране в формате 16:9.<br>За счет подсветки Direct LED в сочетании с хорошими показателями яркости (200 Кд/м²) и контрастности (3000) телевизор Starwind SW-LED32SA303 гарантирует естественную цветопередачу изображения. Частота обновления экрана, равная 60 Гц, обеспечивает возможность просмотра динамичных фильмов без риска увидеть шлейфы, остающиеся за движущимися объектами. Модель функционирует на базе операционной системы Android TV и имеет поддержку Smart TV. Мощность звука встроенной акустической системы равняется 6 Вт.</div></div></div></div></div></div>', NULL, NULL, 'hd--starwind-sw-led32sa303-32-sklp6', 1, 0.00, 0.00, NULL, 0, NULL, NULL, '2021-02-11 11:07:26', '2021-02-15 09:43:34'),
(8, 'HD Телевизор BBK 32LEX-7270/TS2C 32', 'admin', 9, 0, NULL, NULL, 2, '9', '10', 'youtube', NULL, 'HD Телевизор BBK 32LEX', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Телевизор LED BBK 32\" 32LEX-7270/TS2C Smart черный/HD READY/50Hz/DVB-T2/DVB-C/DVB-S2/USB/WiFi (RUS)</div></div></div></div></div></div>', 9990.00, 9990.00, 1, '[\"9\",\"10\"]', '[{\"attribute_id\":\"9\",\"values\":[\"32\"]},{\"attribute_id\":\"10\",\"values\":[\"80\"]}]', '[\"#BDB76B\",\"#FF8C00\",\"#9400D3\"]', NULL, 0, 1, 1, 0, 0, 'KG', 1, 10.00, 'percent', 5.00, 'percent', 'flat_rate', 100.00, 0, 'HD Телевизор BBK 32LEX-7270/TS2C 32', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Телевизор LED BBK 32\" 32LEX-7270/TS2C Smart черный/HD READY/50Hz/DVB-T2/DVB-C/DVB-S2/USB/WiFi (RUS)</div></div></div></div></div></div>', NULL, NULL, 'HD--BBK-32LEX-7270TS2C-32-ew8pv', 1, 0.00, 0.00, NULL, 0, NULL, NULL, '2021-02-11 11:16:24', '2021-02-15 09:43:31'),
(9, '13.3\" Ноутбук Apple MacBook Air (MQD32RU/A)', 'admin', 9, 0, NULL, NULL, 1, '12', '11', 'youtube', NULL, 'Mackbook Air', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Ноутбук Apple MacBook Air (MQD32RU/A) является компактным (1.7x22.7x32.5 см) и небольшим по весу (1.35 кг) устройством, которое позволит вам в дороге или в путешествии пользоваться привычными приложениями и даже полноценно работать. Кроме того, корпус этого серебристого ноутбука является металлическим, за счет чего имеет особую прочность и износоустойчивость. Клавиатура модели имеет подсветку, что позволяет работать даже в темноте. TN+film-экран модели обладает диагональю 13.3 дюйма, разрешением 1440x900 и плотностью пикселей 127.7 PPI.Двухъядерный процессор Core i5 5350U от Intel способен работать в частотном диапазоне 1.8–2.9 ГГц. Объем интегрированной оперативной памяти устройства типа LPDDR3 составляет 8 ГБ. Объем твердотельных SSD-накопителей составляет 128 ГБ. Встроенная память и микрофон в сочетании с Wi-Fi-модулем устройства позволяют поддерживать видеосвязь на высоком уровне. Литиево-полимерный аккумулятор ноутбука Apple MacBook Air (MQD32RU/A) обеспечивает время работы устройства до 12 часов без подзарядки.</div></div></div></div></div></div>', 79063.00, 79063.00, 1, '[\"11\"]', '[{\"attribute_id\":\"11\",\"values\":[\"Intel Core-i5\"]}]', '[\"#A9A9A9\",\"#FFFFFF\"]', NULL, 0, 1, 1, 0, 0, 'KG', 1, 10.00, 'percent', 5.00, 'percent', 'flat_rate', 100.00, 0, '13.3\" Ноутбук Apple MacBook Air (MQD32RU/A)', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Ноутбук Apple MacBook Air (MQD32RU/A) является компактным (1.7x22.7x32.5 см) и небольшим по весу (1.35 кг) устройством, которое позволит вам в дороге или в путешествии пользоваться привычными приложениями и даже полноценно работать. Кроме того, корпус этого серебристого ноутбука является металлическим, за счет чего имеет особую прочность и износоустойчивость. Клавиатура модели имеет подсветку, что позволяет работать даже в темноте. TN+film-экран модели обладает диагональю 13.3 дюйма, разрешением 1440x900 и плотностью пикселей 127.7 PPI.Двухъядерный процессор Core i5 5350U от Intel способен работать в частотном диапазоне 1.8–2.9 ГГц. Объем интегрированной оперативной памяти устройства типа LPDDR3 составляет 8 ГБ. Объем твердотельных SSD-накопителей составляет 128 ГБ. Встроенная память и микрофон в сочетании с Wi-Fi-модулем устройства позволяют поддерживать видеосвязь на высоком уровне. Литиево-полимерный аккумулятор ноутбука Apple MacBook Air (MQD32RU/A) обеспечивает время работы устройства до 12 часов без подзарядки.</div></div></div></div></div></div>', NULL, NULL, '133--Apple-MacBook-Air-MQD32RUA-vRu1r', 1, 0.00, 0.00, NULL, 0, NULL, NULL, '2021-02-11 11:23:05', '2021-02-15 09:43:29');
INSERT INTO `products` (`id`, `name`, `added_by`, `user_id`, `category_id`, `subcategory_id`, `subsubcategory_id`, `brand_id`, `photos`, `thumbnail_img`, `video_provider`, `video_link`, `tags`, `description`, `unit_price`, `purchase_price`, `variant_product`, `attributes`, `choice_options`, `colors`, `variations`, `todays_deal`, `published`, `featured`, `seller_featured`, `current_stock`, `unit`, `min_qty`, `discount`, `discount_type`, `tax`, `tax_type`, `shipping_type`, `shipping_cost`, `num_of_sale`, `meta_title`, `meta_description`, `meta_img`, `pdf`, `slug`, `refundable`, `earn_point`, `rating`, `barcode`, `digital`, `file_name`, `file_path`, `created_at`, `updated_at`) VALUES
(10, 'USB Флеш-накопитель SmartBuy Glossy', 'admin', 9, 0, NULL, NULL, 2, '13', '13', 'youtube', NULL, 'USB Флеш-накопитель SmartBuy Glossy', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webCharacteristics\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-characteristics\" class=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Корпус USB-накопителя SmartBuy Glossy Series 32GB сделан из прозрачного пластика с белой полоской, проходящей между корпусом и колпачком. Glossy оборудован специальной системой для крепления колпачка - с помощью скобки он фиксируется между двумя выступающими пластинками на устройстве. Это очень удобно и минимизирует вероятность потери защитного колпачка. За эту же скобку устройство можно прикрепить к шнурку, чтобы накопитель всегда был под рукой.<br><br>Пропускная способность интерфейса: 480 Мбит/сек<br>Совместим с: Windows 7, Windows 8, Windows Vista, Windows XP, Windows 2000, Linux, MAC OS X<br></div></div></div></div></div></div>', 229.00, 229.00, 1, '[\"12\"]', '[{\"attribute_id\":\"12\",\"values\":[\"32 GB\"]}]', '[\"#F0F8FF\",\"#9966CC\",\"#000000\",\"#9ACD32\"]', NULL, 0, 1, 1, 0, 0, 'KG', 1, 10.00, 'amount', 5.00, 'amount', 'flat_rate', 100.00, 3, 'USB Флеш-накопитель SmartBuy Glossy', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webCharacteristics\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-characteristics\" class=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Корпус USB-накопителя SmartBuy Glossy Series 32GB сделан из прозрачного пластика с белой полоской, проходящей между корпусом и колпачком. Glossy оборудован специальной системой для крепления колпачка - с помощью скобки он фиксируется между двумя выступающими пластинками на устройстве. Это очень удобно и минимизирует вероятность потери защитного колпачка. За эту же скобку устройство можно прикрепить к шнурку, чтобы накопитель всегда был под рукой.<br><br>Пропускная способность интерфейса: 480 Мбит/сек<br>Совместим с: Windows 7, Windows 8, Windows Vista, Windows XP, Windows 2000, Linux, MAC OS X<br></div></div></div></div></div></div>', NULL, NULL, 'USB---SmartBuy-Glossy-4RntE', 1, 0.00, 0.00, NULL, 0, NULL, NULL, '2021-02-11 11:28:48', '2021-02-15 09:43:26'),
(11, 'Беспроводные наушники Accesstyle Denim TWS Black', 'admin', 9, 0, NULL, NULL, 2, '14', '15', 'youtube', NULL, 'Accesstyle Denim TWS Black', '<p></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webCharacteristics\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-characteristics\" class=\"\" style=\"padding: 0px; margin: 0px;\"></div></div><p></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">True Wireless Accesstyle – миниатюрная полностью беспроводная гарнитура для прослушивания музыки и телефонных разговоров. Встроенная батарея ёмкостью 280 мАч позволяет ей работать до 4 часов без подзарядки.<br><br>ДЛЯ ЛЮБОГО ЖАНРА<br>Наушники воспроизводят звук в частотном диапазоне от 20 до 20000 Гц. При проигрывании отлично различимы все низкие, средние и высокие ноты. минимальное искажение звука достигается за счёт небольшого сопротивления (10 Ом).<br><br>ПРОСТОЕ УПРАВЛЕНИЕ<br>Сенсорная панель расположена на одном из наушников. С её помощью можно одним касанием переключать треки, изменять громкость и отвечать на звонки.<br><br>ВСЁ, ЧТО НУЖНО<br>В комплекте с гарнитурой поставляются силиконовые амбушюры и футляр-зарядная станция.<br></div></div></div></div></div></div>', 990.00, 990.00, 1, '[\"13\"]', '[{\"attribute_id\":\"13\",\"values\":[\"102\"]}]', '[\"#F0F8FF\",\"#9966CC\",\"#000000\",\"#9ACD32\"]', NULL, 0, 1, 1, 0, 0, 'KG', 1, 10.00, 'percent', 5.00, 'percent', 'flat_rate', 100.00, 0, 'USB Флеш-накопитель SmartBuy Glossy', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webCharacteristics\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-characteristics\" class=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Корпус USB-накопителя SmartBuy Glossy Series 32GB сделан из прозрачного пластика с белой полоской, проходящей между корпусом и колпачком. Glossy оборудован специальной системой для крепления колпачка - с помощью скобки он фиксируется между двумя выступающими пластинками на устройстве. Это очень удобно и минимизирует вероятность потери защитного колпачка. За эту же скобку устройство можно прикрепить к шнурку, чтобы накопитель всегда был под рукой.<br><br>Пропускная способность интерфейса: 480 Мбит/сек<br>Совместим с: Windows 7, Windows 8, Windows Vista, Windows XP, Windows 2000, Linux, MAC OS X<br></div></div></div></div></div></div>', NULL, NULL, 'usb---smartbuy-glossy-hulls', 1, 0.00, 0.00, NULL, 0, NULL, NULL, '2021-02-11 11:28:55', '2021-02-15 09:43:25'),
(17, 'Фитнес-трекер Xiaomi Mi Band 5, черный', 'admin', 9, 0, NULL, NULL, NULL, '22', '23', 'youtube', NULL, 'Fitness tracker,Mi Band', NULL, 3290.00, 2490.00, 1, '[]', '[]', '[\"#000000\"]', NULL, 0, 1, 1, 0, 0, 'KG', 6, 4.00, 'percent', 12.00, 'percent', 'flat_rate', 0.00, 1, 'Фитнес-трекер Xiaomi Mi Band 5, черный', 'Xiaomi Mi Band 5 черного цвета - фитнес-трекер нового поколения, с которым пользователь получает больше возможностей и функций. Все это, благодаря большому AMOLED-дисплею, интеллектуальным алгоритмам, емкому аккумулятору, а также новым функциям и спортивным режимам.Красочный и информативный\r\nЛицевую панель капсулы занимает сенсорный AMOLED-дисплей с диагональю 1.1 дюйм. Он имеет увеличенное рабочее поле, что обеспечивает максимальную информативность.', NULL, NULL, '--Xiaomi-Mi-Band-5--mzaon', 1, 0.00, 0.00, NULL, 0, NULL, NULL, '2021-02-11 12:21:08', '2021-02-15 09:43:24'),
(18, 'Смарт-часы Xiaomi Haylou Solar LS05 ( Русский интерфейс)', 'admin', 9, 0, NULL, NULL, NULL, '24', '25', 'youtube', NULL, 'Smart-watch,Xiaomi', '<p><span style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\">Xiaomi Haylou Solar LS05&nbsp;— умные часы черного цвета с&nbsp;лучшими функциями на&nbsp;каждый день</span><br style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\"><span style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\">Новинка бренда создана для тех, кто ведет активный образ жизни и&nbsp;хочет быть с&nbsp;инновациями повсюду. Модель сочетает в&nbsp;себе расширенный функционал, четкий дисплей-циферблат, емкий аккумулятор и&nbsp;производительную платформу&nbsp;— все&nbsp;то, что будет нужно каждый день.</span><br style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\"><span style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\">Часы получили в&nbsp;расположение TFT-дисплей диагональю 1.28&nbsp;дюйма. Его высокое разрешение и&nbsp;большой запас яркости позволяют четко отображать текущие данные, обеспечивая максимальную информативность. Защищает дисплей закаленное стекло, стойкое к&nbsp;царапинам и&nbsp;другим мелким повреждениям.</span><br></p>', 12.00, 5.00, 1, '[\"10\"]', '[{\"attribute_id\":\"10\",\"values\":[\"240x240\"]}]', '[\"#000000\"]', NULL, 0, 1, 1, 0, 0, 'KG', 1, 2.40, 'percent', 1.00, 'percent', 'free', 0.00, 0, 'Смарт-часы Xiaomi Haylou Solar LS05 ( Русский интерфейс)', 'Умные часы Xiaomi оборудованы энергоемким аккумулятором высокой плотности. Его главное преимущество — распределение энергии под контролем алгоритмов искусственного интеллекта. Они точно оптимизируют работу устройства, адаптируют аппаратную конфигурацию под реальные задачи и выполняют другие операции по повышению эффективности. Благодаря этому, часы способны проработать до 30 дней всего на одном заряде.', NULL, NULL, '--xiaomi-haylou-solar-ls05----krblg', 1, 0.00, 0.00, NULL, 0, NULL, NULL, '2021-02-11 12:26:02', '2021-02-15 09:43:20');

-- --------------------------------------------------------

--
-- Структура таблицы `product_stocks`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 12:38
--

DROP TABLE IF EXISTS `product_stocks`;
CREATE TABLE `product_stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` double(20,2) NOT NULL DEFAULT '0.00',
  `qty` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `product_stocks`
--

INSERT INTO `product_stocks` (`id`, `product_id`, `variant`, `sku`, `price`, `qty`, `created_at`, `updated_at`) VALUES
(20, 1, 'AliceBlue', 'AliceBlue', 0.00, 10, '2021-02-11 09:52:28', '2021-02-11 09:52:28'),
(21, 1, 'Amethyst', 'Amethyst', 0.00, 10, '2021-02-11 09:52:28', '2021-02-11 09:52:28'),
(22, 1, 'AntiqueWhite', 'AntiqueWhite', 0.00, 10, '2021-02-11 09:52:28', '2021-02-11 09:52:28'),
(23, 1, 'Aquamarine', 'Aquamarine', 0.00, 10, '2021-02-11 09:52:28', '2021-02-11 09:52:28'),
(24, 2, NULL, NULL, 23990.00, 0, '2021-02-11 10:30:43', '2021-02-11 10:30:43'),
(27, 4, 'Azure-128GB', NULL, 21990.00, 9, '2021-02-11 10:55:34', '2021-02-15 09:38:47'),
(28, 4, 'Bisque-128GB', NULL, 21990.00, 9, '2021-02-11 10:55:34', '2021-02-15 03:51:59'),
(29, 5, 'AntiqueWhite-64/128Gb', NULL, 26311.00, 9, '2021-02-11 11:01:39', '2021-02-15 09:38:47'),
(30, 5, 'Aquamarine-64/128Gb', NULL, 26311.00, 9, '2021-02-11 11:01:39', '2021-02-12 12:37:21'),
(31, 5, 'Bisque-64/128Gb', NULL, 26311.00, 10, '2021-02-11 11:01:39', '2021-02-11 11:01:39'),
(32, 6, 'Black-15.6-128', NULL, 41090.00, 5, '2021-02-11 11:05:36', '2021-02-11 11:05:36'),
(33, 6, 'DarkGray-15.6-128', NULL, 41090.00, 10, '2021-02-11 11:05:36', '2021-02-11 11:05:36'),
(37, 7, 'Aqua-32-81', 'Aqua-32-81', 8890.00, 10, '2021-02-11 11:12:03', '2021-02-11 11:12:03'),
(38, 7, 'CadetBlue-32-81', 'CadetBlue-32-81', 8890.00, 10, '2021-02-11 11:12:03', '2021-02-11 11:12:03'),
(39, 7, 'Crimson-32-81', 'Crimson-32-81', 8890.00, 10, '2021-02-11 11:12:03', '2021-02-11 11:12:03'),
(40, 8, 'DarkKhaki-32-80', NULL, 9990.00, 10, '2021-02-11 11:16:24', '2021-02-11 11:16:24'),
(41, 8, 'DarkOrange-32-80', NULL, 9990.00, 10, '2021-02-11 11:16:24', '2021-02-11 11:16:24'),
(42, 8, 'DarkViolet-32-80', NULL, 9990.00, 10, '2021-02-11 11:16:24', '2021-02-11 11:16:24'),
(43, 9, 'DarkGray-IntelCore-i5', NULL, 79063.00, 10, '2021-02-11 11:23:05', '2021-02-11 11:23:05'),
(44, 9, 'White-IntelCore-i5', NULL, 79063.00, 10, '2021-02-11 11:23:05', '2021-02-11 11:23:05'),
(45, 10, 'AliceBlue-32GB', NULL, 229.00, 9, '2021-02-11 11:28:48', '2021-02-15 06:41:12'),
(46, 10, 'Amethyst-32GB', NULL, 229.00, 10, '2021-02-11 11:28:48', '2021-02-11 11:28:48'),
(47, 10, 'Black-32GB', NULL, 229.00, 9, '2021-02-11 11:28:48', '2021-02-15 06:41:12'),
(48, 10, 'YellowGreen-32GB', NULL, 229.00, 9, '2021-02-11 11:28:48', '2021-02-15 06:41:12'),
(53, 11, 'AliceBlue-102', 'AliceBlue-102', 229.00, 10, '2021-02-11 11:41:50', '2021-02-11 11:41:50'),
(54, 11, 'Amethyst-102', 'Amethyst-102', 229.00, 10, '2021-02-11 11:41:50', '2021-02-11 11:41:50'),
(55, 11, 'Black-102', 'Black-102', 229.00, 10, '2021-02-11 11:41:50', '2021-02-11 11:41:50'),
(56, 11, 'YellowGreen-102', 'YellowGreen-102', 229.00, 10, '2021-02-11 11:41:50', '2021-02-11 11:41:50'),
(57, 3, 'Aqua-1GB', 'Aqua-1GB', 23990.00, 6, '2021-02-11 11:48:09', '2021-02-14 03:22:46'),
(58, 3, 'DarkCyan-1GB', 'DarkCyan-1GB', 23990.00, 10, '2021-02-11 11:48:09', '2021-02-11 11:48:09'),
(59, 3, 'DarkGray-1GB', 'DarkGray-1GB', 23990.00, 5, '2021-02-11 11:48:09', '2021-02-15 03:51:05'),
(60, 12, 'Black', NULL, 1794.00, 10, '2021-02-11 11:55:05', '2021-02-11 11:55:05'),
(61, 13, 'Black-New', NULL, 10999.00, 15, '2021-02-11 11:59:36', '2021-02-11 11:59:36'),
(62, 14, 'Black-black', NULL, 899.00, 10, '2021-02-11 12:04:17', '2021-02-11 12:04:17'),
(63, 14, 'Black-red', NULL, 899.00, 10, '2021-02-11 12:04:17', '2021-02-11 12:04:17'),
(64, 14, 'OrangeRed-black', NULL, 899.00, 10, '2021-02-11 12:04:17', '2021-02-11 12:04:17'),
(65, 14, 'OrangeRed-red', NULL, 899.00, 10, '2021-02-11 12:04:17', '2021-02-11 12:04:17'),
(66, 15, 'Black-Black', NULL, 449.00, 10, '2021-02-11 12:15:51', '2021-02-11 12:15:51'),
(67, 16, 'Black', NULL, 3290.00, 6, '2021-02-11 12:20:56', '2021-02-11 12:20:56'),
(68, 17, 'Black', 'Black', 3290.00, 9, '2021-02-11 12:22:31', '2021-02-15 03:52:28'),
(73, 18, 'Black-240x240', NULL, 20.00, 1, '2021-02-11 12:29:57', '2021-02-11 12:29:57'),
(74, 19, 'Black-IpCamera-2.1', NULL, 2090.00, 1, '2021-02-11 12:36:32', '2021-02-11 12:36:32'),
(75, 19, 'White-IpCamera-2.1', NULL, 2090.00, 1, '2021-02-11 12:36:32', '2021-02-11 12:36:32'),
(76, 20, 'AliceBlue-64-8', NULL, 1000.00, 8, '2021-02-12 11:42:23', '2021-02-15 09:38:47'),
(77, 20, 'AliceBlue-64-16', NULL, 1100.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(78, 20, 'AliceBlue-64-32', NULL, 1200.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(79, 20, 'AliceBlue-128-8', NULL, 1300.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(80, 20, 'AliceBlue-128-16', NULL, 1400.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(81, 20, 'AliceBlue-128-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(82, 20, 'AliceBlue-256-8', NULL, 1300.00, 9, '2021-02-12 11:42:23', '2021-02-15 06:41:12'),
(83, 20, 'AliceBlue-256-16', NULL, 1400.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(84, 20, 'AliceBlue-256-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(85, 20, 'Amethyst-64-8', NULL, 1000.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(86, 20, 'Amethyst-64-16', NULL, 1100.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(87, 20, 'Amethyst-64-32', NULL, 1200.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(88, 20, 'Amethyst-128-8', NULL, 1300.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(89, 20, 'Amethyst-128-16', NULL, 1400.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(90, 20, 'Amethyst-128-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(91, 20, 'Amethyst-256-8', NULL, 1300.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(92, 20, 'Amethyst-256-16', NULL, 1400.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(93, 20, 'Amethyst-256-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(94, 20, 'AntiqueWhite-64-8', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(95, 20, 'AntiqueWhite-64-16', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(96, 20, 'AntiqueWhite-64-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(97, 20, 'AntiqueWhite-128-8', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(98, 20, 'AntiqueWhite-128-16', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(99, 20, 'AntiqueWhite-128-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(100, 20, 'AntiqueWhite-256-8', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(101, 20, 'AntiqueWhite-256-16', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(102, 20, 'AntiqueWhite-256-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(103, 20, 'Aqua-64-8', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(104, 20, 'Aqua-64-16', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(105, 20, 'Aqua-64-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(106, 20, 'Aqua-128-8', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(107, 20, 'Aqua-128-16', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(108, 20, 'Aqua-128-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(109, 20, 'Aqua-256-8', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(110, 20, 'Aqua-256-16', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(111, 20, 'Aqua-256-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(112, 20, 'Aquamarine-64-8', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(113, 20, 'Aquamarine-64-16', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(114, 20, 'Aquamarine-64-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(115, 20, 'Aquamarine-128-8', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(116, 20, 'Aquamarine-128-16', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(117, 20, 'Aquamarine-128-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(118, 20, 'Aquamarine-256-8', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(119, 20, 'Aquamarine-256-16', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23'),
(120, 20, 'Aquamarine-256-32', NULL, 1500.00, 10, '2021-02-12 11:42:23', '2021-02-12 11:42:23');

-- --------------------------------------------------------

--
-- Структура таблицы `product_translations`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 12:41
--

DROP TABLE IF EXISTS `product_translations`;
CREATE TABLE `product_translations` (
  `id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `product_translations`
--

INSERT INTO `product_translations` (`id`, `product_id`, `name`, `unit`, `description`, `lang`, `created_at`, `updated_at`) VALUES
(2, 2, 'Xiaomi Redmi Note 9 Pro', 'KG', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Смартфон с большим безрамочным экраном. 6,67-дюймовый дисплей, разрешение которого составляет 2400х1080 пикселей. Основная камера состоит из четырех модулей. Главный модуль на 64 Мп. Она делает сверхчеткие снимки, записывает видео в формате 4K, а также предоставляет множество других творческих возможностей.</div></div></div></div></div></div>', 'bd', '2021-02-11 10:30:43', '2021-02-11 10:30:43'),
(3, 4, 'Смартфон Poco X3 NFC 6', 'Kg', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Диагональ дисплея в POCO X3 составляет 6,67 дюймов при разрешении 2400х1080 пикселей. Соотношение сторон DotDisplay-экрана равняется 20:9. Частота обновления сенсора – 120 Гц, а уровень чувствительности прикосновений – 240 Гц при времени отклика 4,16 мс. Реализована защита зрительной системы от синего света с сертификатом TÜV Rheinland Low Blue Light certification.<br>Средний уровень производительности обеспечивается за счет работы процессора Qualcomm Snapdragon 732G. Он изготовлен по 8 нм техпроцессу, состоит из 8 ядер Kryo 470, максимальная ядерная частота которых достигает 2,3 ГГц. Графика обрабатывается видеоускорителем Adreno 618. Установлена внутренняя память типа LPDDR4X и встроенная UFS2.1.<br>Разрешение основного сенсора равняется 64 мегапикселям, широкоугольного модуля – 13 МР. Макроснимки и размытие фона на портретов обеспечиваются за счет двух 2-мегапиксельных датчиков. Реализована поддержка съемки видео в 4К при 30fps.<br>Фронтальная камера представлена матрицей на 20 мегапикселей с поддержкой технологии искусственного интеллекта.<br>Особенность POCO X3 заключается в установке вибромоторов 4D, что обеспечивает высокий уровень комфорта во время игры. Беспроводные технологии Bluetooth 5.1 и Wi-Fi 2x2 MIMO позволяют быстро передавать данные на расстоянии.<br>Бесконтактная оплата товаров и услуг осуществляется через чип NFC. В телефоне установлены ИК-датчик, гироскоп, акселерометр и 3,5 мм аудиоразъем.<br>Емкость полимерной литий-ионной встроенной батареи равняется 5160 мАч. Для зарядки используется кабель USB Type-C, который поставляется в комплекте с зарядным устройством мощностью 33 Вт. Поддерживается технология быстрой зарядки.</div></div></div></div></div></div>', 'bd', '2021-02-11 10:51:21', '2021-02-11 10:51:21'),
(4, 5, 'Samsung Galaxy A51', 'KG', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Модель сертификации EAC/ бывший Ростест, один год официальной гарантии от производителя Samsung, гарантийное обслуживание во всех автоматизированных центрах.<br>Безграничный экран Galaxy A51 оптимизирует визуальную симметрию. Теперь ты можешь играть, смотреть фильмы, бродить по сети и работать в многозадачном режиме без перерыва на ярком 6.5-дюймовом sAMOLED экране с FHD+ разрешением. Погрузись в контент с головой благодаря тонкой рамке дисплея и максимальной площади полезного пространства. Ростест</div></div></div></div></div></div>', 'bd', '2021-02-11 11:01:39', '2021-02-11 11:01:39'),
(6, 7, 'HD Телевизор Starwind SW-LED32SA303 32', 'Kg', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Телевизор LED Starwind SW-LED32SA303, чья потребляемая мощность не превышает 56 Вт, обладает размерами 732x434x74.8 мм (ширина, высота и толщина соответственно без учета подставки). Модель с 32-дюймовой (81 см) диагональю порадует требовательного телезрителя достойным качеством изображения, демонстрируемого в разрешении 1366x768 пикселей (формат HD). Благодаря лаконичной черной расцветке корпуса и подставки устройство впишется в любой интерьер. Функционал данной модели также хорош, как и качество картинки, транслируемой на экране в формате 16:9.<br>За счет подсветки Direct LED в сочетании с хорошими показателями яркости (200 Кд/м²) и контрастности (3000) телевизор Starwind SW-LED32SA303 гарантирует естественную цветопередачу изображения. Частота обновления экрана, равная 60 Гц, обеспечивает возможность просмотра динамичных фильмов без риска увидеть шлейфы, остающиеся за движущимися объектами. Модель функционирует на базе операционной системы Android TV и имеет поддержку Smart TV. Мощность звука встроенной акустической системы равняется 6 Вт.</div></div></div></div></div></div>', 'bd', '2021-02-11 11:07:26', '2021-02-11 11:07:26'),
(7, 8, 'HD Телевизор BBK 32LEX-7270/TS2C 32', 'KG', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Телевизор LED BBK 32\" 32LEX-7270/TS2C Smart черный/HD READY/50Hz/DVB-T2/DVB-C/DVB-S2/USB/WiFi (RUS)</div></div></div></div></div></div>', 'bd', '2021-02-11 11:16:24', '2021-02-11 11:16:24'),
(8, 9, '13.3\" Ноутбук Apple MacBook Air (MQD32RU/A)', 'KG', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Ноутбук Apple MacBook Air (MQD32RU/A) является компактным (1.7x22.7x32.5 см) и небольшим по весу (1.35 кг) устройством, которое позволит вам в дороге или в путешествии пользоваться привычными приложениями и даже полноценно работать. Кроме того, корпус этого серебристого ноутбука является металлическим, за счет чего имеет особую прочность и износоустойчивость. Клавиатура модели имеет подсветку, что позволяет работать даже в темноте. TN+film-экран модели обладает диагональю 13.3 дюйма, разрешением 1440x900 и плотностью пикселей 127.7 PPI.Двухъядерный процессор Core i5 5350U от Intel способен работать в частотном диапазоне 1.8–2.9 ГГц. Объем интегрированной оперативной памяти устройства типа LPDDR3 составляет 8 ГБ. Объем твердотельных SSD-накопителей составляет 128 ГБ. Встроенная память и микрофон в сочетании с Wi-Fi-модулем устройства позволяют поддерживать видеосвязь на высоком уровне. Литиево-полимерный аккумулятор ноутбука Apple MacBook Air (MQD32RU/A) обеспечивает время работы устройства до 12 часов без подзарядки.</div></div></div></div></div></div>', 'bd', '2021-02-11 11:23:05', '2021-02-11 11:23:05'),
(9, 10, 'USB Флеш-накопитель SmartBuy Glossy', 'KG', '<p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webCharacteristics\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-characteristics\" class=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Корпус USB-накопителя SmartBuy Glossy Series 32GB сделан из прозрачного пластика с белой полоской, проходящей между корпусом и колпачком. Glossy оборудован специальной системой для крепления колпачка - с помощью скобки он фиксируется между двумя выступающими пластинками на устройстве. Это очень удобно и минимизирует вероятность потери защитного колпачка. За эту же скобку устройство можно прикрепить к шнурку, чтобы накопитель всегда был под рукой.<br><br>Пропускная способность интерфейса: 480 Мбит/сек<br>Совместим с: Windows 7, Windows 8, Windows Vista, Windows XP, Windows 2000, Linux, MAC OS X<br></div></div></div></div></div></div>', 'bd', '2021-02-11 11:28:48', '2021-02-11 11:28:48'),
(10, 11, 'Беспроводные наушники Accesstyle Denim TWS Black', 'KG', '<p></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webCharacteristics\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-characteristics\" class=\"\" style=\"padding: 0px; margin: 0px;\"></div></div><p></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">True Wireless Accesstyle – миниатюрная полностью беспроводная гарнитура для прослушивания музыки и телефонных разговоров. Встроенная батарея ёмкостью 280 мАч позволяет ей работать до 4 часов без подзарядки.<br><br>ДЛЯ ЛЮБОГО ЖАНРА<br>Наушники воспроизводят звук в частотном диапазоне от 20 до 20000 Гц. При проигрывании отлично различимы все низкие, средние и высокие ноты. минимальное искажение звука достигается за счёт небольшого сопротивления (10 Ом).<br><br>ПРОСТОЕ УПРАВЛЕНИЕ<br>Сенсорная панель расположена на одном из наушников. С её помощью можно одним касанием переключать треки, изменять громкость и отвечать на звонки.<br><br>ВСЁ, ЧТО НУЖНО<br>В комплекте с гарнитурой поставляются силиконовые амбушюры и футляр-зарядная станция.<br></div></div></div></div></div></div>', 'bd', '2021-02-11 11:28:55', '2021-02-11 11:41:50'),
(11, 3, 'Смарт-часы Xiaomi Haylou Solar LS05', 'KG', '<p></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"></div></div></div></div></div><p></p><div data-v-414055a2=\"\" class=\"bq3\" data-widget=\"webDescription\" style=\"padding: 0px; margin: 0px 0px 40px; display: block; color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><div data-v-414055a2=\"\" id=\"section-description\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\"><div data-v-414055a2=\"\" class=\"b0v1\" style=\"padding: 0px; margin: 0px; font-size: 16px; line-height: 1.38; hyphens: auto;\"><div data-v-414055a2=\"\" class=\"b0v2\" style=\"padding: 0px; margin: 0px; overflow: hidden; position: relative; max-height: 99999px; transition: max-height 0.2s ease 0s;\"><div data-v-414055a2=\"\" style=\"padding: 0px; margin: 0px;\">Xiaomi Haylou Solar LS05&nbsp;— умные часы черного цвета с&nbsp;лучшими функциями на&nbsp;каждый день<br>Новинка бренда создана для тех, кто ведет активный образ жизни и&nbsp;хочет быть с&nbsp;инновациями повсюду. Модель сочетает в&nbsp;себе расширенный функционал, четкий дисплей-циферблат, емкий аккумулятор и&nbsp;производительную платформу&nbsp;— все&nbsp;то, что будет нужно каждый день.<br>Часы получили в&nbsp;расположение TFT-дисплей диагональю 1.28&nbsp;дюйма. Его высокое разрешение и&nbsp;большой запас яркости позволяют четко отображать текущие данные, обеспечивая максимальную информативность. Защищает дисплей закаленное стекло, стойкое к&nbsp;царапинам и&nbsp;другим мелким повреждениям.<br>Умные часы Xiaomi оборудованы энергоемким аккумулятором высокой плотности. Его главное преимущество&nbsp;— распределение энергии под контролем алгоритмов искусственного интеллекта. Они точно оптимизируют работу устройства, адаптируют аппаратную конфигурацию под реальные задачи и&nbsp;выполняют другие операции по&nbsp;повышению эффективности. Благодаря этому, часы способны проработать до&nbsp;30&nbsp;дней всего на&nbsp;одном заряде.<br>Умный девайс Сяоми оборудован большим количеством точных датчиков и&nbsp;сенсоров, позволяющих ему безошибочно распознавать 12&nbsp;видов спортивных активностей владельца. Благодаря поддержке такого количества режимов, девайс может точно анализировать затраченные калории, оценивать достигнутые результаты и&nbsp;своевременно информировать о&nbsp;необходимости отдыха.<br>Умные часы черного цвета не&nbsp;боятся экстремальных условий и&nbsp;могут оставаться на&nbsp;запястье владельца в&nbsp;абсолютно любой ситуации. Этому способствует надежность литого корпуса и&nbsp;комплексная герметизация в&nbsp;соответствии с&nbsp;классом IP68&nbsp;— пыль и&nbsp;вода ему не&nbsp;страшны.<br>В&nbsp;модели реализована функция контроля сна, которая может отслеживать фазы ночного отдыха, высчитывать оптимальное время пробуждения и&nbsp;даже давать рекомендации относительно улучшения сна. Точность анализа гарантирована датчиком сердечного ритма, задействованным системой. Смарт-вотч новой модели имеют целый арсенал интеллектуальных функций на&nbsp;каждый день. Они способны напоминать о&nbsp;запланированных событиях, уведомлять о&nbsp;входящих звонках и&nbsp;сообщениях, отображать прогноз погоды, управлять камерой подключенного смартфона, помогать в&nbsp;поиске телефона и&nbsp;многое другое. А&nbsp;регулярное обновление дополнительного софта и&nbsp;вовсе делает возможности девайса безграничными.<br>Специально для новой модели часов разработано мобильное приложение, позволяющее быстро настраивать их&nbsp;работу, выполнять синхронизацию, просматривать результаты собственных спортивных достижений и&nbsp;многое другое. При этом, софт доступен для устройств на&nbsp;базе Android и&nbsp;iOS, поэтому с&nbsp;совместимостью проблем не&nbsp;возникнет.<br></div></div></div></div></div></div>', 'bd', '2021-02-11 11:48:09', '2021-02-11 11:48:09'),
(17, 17, 'Фитнес-трекер Xiaomi Mi Band 5, черный', 'KG', NULL, 'en', '2021-02-11 12:22:31', '2021-02-11 12:22:31'),
(18, 18, 'Смарт-часы Xiaomi Haylou Solar LS05 ( Русский интерфейс)', 'KG', '<p><span style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\">Xiaomi Haylou Solar LS05&nbsp;— умные часы черного цвета с&nbsp;лучшими функциями на&nbsp;каждый день</span><br style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\"><span style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\">Новинка бренда создана для тех, кто ведет активный образ жизни и&nbsp;хочет быть с&nbsp;инновациями повсюду. Модель сочетает в&nbsp;себе расширенный функционал, четкий дисплей-циферблат, емкий аккумулятор и&nbsp;производительную платформу&nbsp;— все&nbsp;то, что будет нужно каждый день.</span><br style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\"><span style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\">Часы получили в&nbsp;расположение TFT-дисплей диагональю 1.28&nbsp;дюйма. Его высокое разрешение и&nbsp;большой запас яркости позволяют четко отображать текущие данные, обеспечивая максимальную информативность. Защищает дисплей закаленное стекло, стойкое к&nbsp;царапинам и&nbsp;другим мелким повреждениям.</span><br></p>', 'bd', '2021-02-11 12:26:02', '2021-02-11 12:26:02'),
(19, 18, 'Смарт-часы Xiaomi Haylou Solar LS05 ( Русский интерфейс)', 'KG', '<p><span style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\">Xiaomi Haylou Solar LS05&nbsp;— умные часы черного цвета с&nbsp;лучшими функциями на&nbsp;каждый день</span><br style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\"><span style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\">Новинка бренда создана для тех, кто ведет активный образ жизни и&nbsp;хочет быть с&nbsp;инновациями повсюду. Модель сочетает в&nbsp;себе расширенный функционал, четкий дисплей-циферблат, емкий аккумулятор и&nbsp;производительную платформу&nbsp;— все&nbsp;то, что будет нужно каждый день.</span><br style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\"><span style=\"color: rgb(0, 26, 52); font-family: GTEestiPro, arial, sans-serif; font-size: 16px;\">Часы получили в&nbsp;расположение TFT-дисплей диагональю 1.28&nbsp;дюйма. Его высокое разрешение и&nbsp;большой запас яркости позволяют четко отображать текущие данные, обеспечивая максимальную информативность. Защищает дисплей закаленное стекло, стойкое к&nbsp;царапинам и&nbsp;другим мелким повреждениям.</span><br></p>', 'en', '2021-02-11 12:27:10', '2021-02-11 12:27:10');

-- --------------------------------------------------------

--
-- Структура таблицы `refund_requests`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `refund_requests`;
CREATE TABLE `refund_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_detail_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `seller_approval` int(1) NOT NULL DEFAULT '0',
  `admin_approval` int(1) NOT NULL DEFAULT '0',
  `refund_amount` double(8,2) NOT NULL DEFAULT '0.00',
  `reason` longtext COLLATE utf8_unicode_ci,
  `admin_seen` int(11) NOT NULL,
  `refund_status` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `comment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `viewed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'Manager', '[\"1\",\"2\",\"4\"]', '2018-10-10 04:39:47', '2018-10-10 04:51:37'),
(2, 'Accountant', '[\"2\",\"3\"]', '2018-10-10 04:52:09', '2018-10-10 04:52:09');

-- --------------------------------------------------------

--
-- Структура таблицы `role_translations`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `role_translations`;
CREATE TABLE `role_translations` (
  `id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `searches`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 13:54
--

DROP TABLE IF EXISTS `searches`;
CREATE TABLE `searches` (
  `id` int(11) NOT NULL,
  `query` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `searches`
--

INSERT INTO `searches` (`id`, `query`, `count`, `created_at`, `updated_at`) VALUES
(2, 'dcs', 1, '2020-03-08 00:29:09', '2020-03-08 00:29:09'),
(3, 'das', 3, '2020-03-08 00:29:15', '2020-03-08 00:29:50'),
(4, 'sdsds', 2, '2021-02-13 08:38:12', '2021-02-13 08:38:15'),
(5, 'dfs', 9, '2021-02-13 08:38:20', '2021-02-13 09:09:31'),
(6, 'smart-watch', 1, '2021-02-15 01:43:44', '2021-02-15 01:43:44'),
(7, 'xgdssg', 1, '2021-02-15 10:54:58', '2021-02-15 10:54:58');

-- --------------------------------------------------------

--
-- Структура таблицы `sellers`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 13 2021 г., 18:25
--

DROP TABLE IF EXISTS `sellers`;
CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seller_package_id` int(11) DEFAULT NULL,
  `remaining_uploads` int(11) NOT NULL DEFAULT '0',
  `remaining_digital_uploads` int(11) NOT NULL DEFAULT '0',
  `invalid_at` date DEFAULT NULL,
  `verification_status` int(1) NOT NULL DEFAULT '0',
  `verification_info` longtext COLLATE utf8_unicode_ci,
  `cash_on_delivery_status` int(1) NOT NULL DEFAULT '0',
  `admin_to_pay` double(20,2) NOT NULL DEFAULT '0.00',
  `bank_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_acc_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_acc_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_routing_no` int(50) DEFAULT NULL,
  `bank_payment_status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `sellers`
--

INSERT INTO `sellers` (`id`, `user_id`, `seller_package_id`, `remaining_uploads`, `remaining_digital_uploads`, `invalid_at`, `verification_status`, `verification_info`, `cash_on_delivery_status`, `admin_to_pay`, `bank_name`, `bank_acc_name`, `bank_acc_no`, `bank_routing_no`, `bank_payment_status`, `created_at`, `updated_at`) VALUES
(1, 3, NULL, 0, 0, NULL, 1, '[{\"type\":\"text\",\"label\":\"Name\",\"value\":\"Mr. Seller\"},{\"type\":\"select\",\"label\":\"Marital Status\",\"value\":\"Married\"},{\"type\":\"multi_select\",\"label\":\"Company\",\"value\":\"[\\\"Company\\\"]\"},{\"type\":\"select\",\"label\":\"Gender\",\"value\":\"Male\"},{\"type\":\"file\",\"label\":\"Image\",\"value\":\"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png\"}]', 1, 0.00, NULL, NULL, NULL, NULL, 0, '2018-10-07 04:42:57', '2021-02-13 15:17:24'),
(3, 12, NULL, 0, 0, NULL, 1, NULL, 0, 0.00, NULL, NULL, NULL, NULL, 0, '2021-02-13 15:24:16', '2021-02-13 15:25:50');

-- --------------------------------------------------------

--
-- Структура таблицы `seller_packages`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `seller_packages`;
CREATE TABLE `seller_packages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` double(11,2) NOT NULL DEFAULT '0.00',
  `product_upload` int(11) NOT NULL DEFAULT '0',
  `digital_product_upload` int(11) NOT NULL DEFAULT '0',
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `seller_withdraw_requests`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `seller_withdraw_requests`;
CREATE TABLE `seller_withdraw_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` double(20,2) DEFAULT NULL,
  `message` longtext,
  `status` int(1) DEFAULT NULL,
  `viewed` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `seo_settings`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `seo_settings`;
CREATE TABLE `seo_settings` (
  `id` int(11) NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `revisit` int(11) NOT NULL,
  `sitemap_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `seo_settings`
--

INSERT INTO `seo_settings` (`id`, `keyword`, `author`, `revisit`, `sitemap_link`, `description`, `created_at`, `updated_at`) VALUES
(1, 'bootstrap,responsive,template,developer', 'Active IT Zone', 11, 'https://www.activeitzone.com', 'Active E-commerce CMS Multi vendor system is such a platform to build a border less marketplace both for physical and digital goods.', '2019-08-08 08:56:11', '2019-08-08 02:56:11');

-- --------------------------------------------------------

--
-- Структура таблицы `shops`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 13 2021 г., 18:25
--

DROP TABLE IF EXISTS `shops`;
CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sliders` longtext COLLATE utf8_unicode_ci,
  `address` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `pick_up_point_id` text COLLATE utf8_unicode_ci,
  `shipping_cost` double(20,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `shops`
--

INSERT INTO `shops` (`id`, `user_id`, `name`, `logo`, `sliders`, `address`, `facebook`, `google`, `twitter`, `youtube`, `slug`, `meta_title`, `meta_description`, `pick_up_point_id`, `shipping_cost`, `created_at`, `updated_at`) VALUES
(1, 3, 'Demo Seller Shop', NULL, NULL, 'House : Demo, Road : Demo, Section : Demo', 'www.facebook.com', 'www.google.com', 'www.twitter.com', 'www.youtube.com', 'Demo-Seller-Shop-1', 'Demo Seller Shop Title', 'Demo description', NULL, 0.00, '2018-11-27 10:23:13', '2019-08-06 06:43:16'),
(3, 12, 'Test', NULL, NULL, 'test', NULL, NULL, NULL, NULL, 'Test-', NULL, NULL, NULL, 0.00, '2021-02-13 15:24:16', '2021-02-13 15:24:16');

-- --------------------------------------------------------

--
-- Структура таблицы `sliders`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `sliders`;
CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `sliders`
--

INSERT INTO `sliders` (`id`, `photo`, `published`, `link`, `created_at`, `updated_at`) VALUES
(7, 'uploads/sliders/slider-image.jpg', 1, NULL, '2019-03-12 05:58:05', '2019-03-12 05:58:05'),
(8, 'uploads/sliders/slider-image.jpg', 1, NULL, '2019-03-12 05:58:12', '2019-03-12 05:58:12');

-- --------------------------------------------------------

--
-- Структура таблицы `staff`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `subscribers`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `subscribers`;
CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `code` int(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci,
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `viewed` int(1) NOT NULL DEFAULT '0',
  `client_viewed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ticket_replies`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `ticket_replies`;
CREATE TABLE `ticket_replies` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply` longtext COLLATE utf8_unicode_ci NOT NULL,
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `translations`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 09:41
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE `translations` (
  `id` int(11) NOT NULL,
  `lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang_key` text COLLATE utf8_unicode_ci,
  `lang_value` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `translations`
--

INSERT INTO `translations` (`id`, `lang`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(3, 'en', 'All Category', 'All Category', '2020-11-02 07:40:38', '2020-11-02 07:40:38'),
(4, 'en', 'All', 'All', '2020-11-02 07:40:38', '2020-11-02 07:40:38'),
(5, 'en', 'Flash Sale', 'Flash Sale', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(6, 'en', 'View More', 'View More', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(7, 'en', 'Add to wishlist', 'Add to wishlist', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(8, 'en', 'Add to compare', 'Add to compare', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(9, 'en', 'Add to cart', 'Add to cart', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(10, 'en', 'Club Point', 'Club Point', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(11, 'en', 'Classified Ads', 'Classified Ads', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(13, 'en', 'Used', 'Used', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(14, 'en', 'Top 10 Categories', 'Top 10 Categories', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(15, 'en', 'View All Categories', 'View All Categories', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(16, 'en', 'Top 10 Brands', 'Top 10 Brands', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(17, 'en', 'View All Brands', 'View All Brands', '2020-11-02 07:40:40', '2020-11-02 07:40:40'),
(43, 'en', 'Terms & conditions', 'Terms & conditions', '2020-11-02 07:40:41', '2020-11-02 07:40:41'),
(51, 'en', 'Best Selling', 'Best Selling', '2020-11-02 07:40:42', '2020-11-02 07:40:42'),
(53, 'en', 'Top 20', 'Top 20', '2020-11-02 07:40:42', '2020-11-02 07:40:42'),
(55, 'en', 'Featured Products', 'Featured Products', '2020-11-02 07:40:42', '2020-11-02 07:40:42'),
(56, 'en', 'Best Sellers', 'Best Sellers', '2020-11-02 07:40:43', '2020-11-02 07:40:43'),
(57, 'en', 'Visit Store', 'Visit Store', '2020-11-02 07:40:43', '2020-11-02 07:40:43'),
(58, 'en', 'Popular Suggestions', 'Popular Suggestions', '2020-11-02 07:46:59', '2020-11-02 07:46:59'),
(59, 'en', 'Category Suggestions', 'Category Suggestions', '2020-11-02 07:46:59', '2020-11-02 07:46:59'),
(62, 'en', 'Automobile & Motorcycle', 'Automobile & Motorcycle', '2020-11-02 07:47:01', '2020-11-02 07:47:01'),
(63, 'en', 'Price range', 'Price range', '2020-11-02 07:47:01', '2020-11-02 07:47:01'),
(64, 'en', 'Filter by color', 'Filter by color', '2020-11-02 07:47:02', '2020-11-02 07:47:02'),
(65, 'en', 'Home', 'Home', '2020-11-02 07:47:02', '2020-11-02 07:47:02'),
(67, 'en', 'Newest', 'Newest', '2020-11-02 07:47:02', '2020-11-02 07:47:02'),
(68, 'en', 'Oldest', 'Oldest', '2020-11-02 07:47:02', '2020-11-02 07:47:02'),
(69, 'en', 'Price low to high', 'Price low to high', '2020-11-02 07:47:02', '2020-11-02 07:47:02'),
(70, 'en', 'Price high to low', 'Price high to low', '2020-11-02 07:47:02', '2020-11-02 07:47:02'),
(71, 'en', 'Brands', 'Brands', '2020-11-02 07:47:02', '2020-11-02 07:47:02'),
(72, 'en', 'All Brands', 'All Brands', '2020-11-02 07:47:02', '2020-11-02 07:47:02'),
(74, 'en', 'All Sellers', 'All Sellers', '2020-11-02 07:47:02', '2020-11-02 07:47:02'),
(78, 'en', 'Inhouse product', 'Inhouse product', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(79, 'en', 'Message Seller', 'Message Seller', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(80, 'en', 'Price', 'Price', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(81, 'en', 'Discount Price', 'Discount Price', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(82, 'en', 'Color', 'Color', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(83, 'en', 'Quantity', 'Quantity', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(84, 'en', 'available', 'available', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(85, 'en', 'Total Price', 'Total Price', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(86, 'en', 'Out of Stock', 'Out of Stock', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(87, 'en', 'Refund', 'Refund', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(88, 'en', 'Share', 'Share', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(89, 'en', 'Sold By', 'Sold By', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(90, 'en', 'customer reviews', 'customer reviews', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(91, 'en', 'Top Selling Products', 'Top Selling Products', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(92, 'en', 'Description', 'Description', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(93, 'en', 'Video', 'Video', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(94, 'en', 'Reviews', 'Reviews', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(95, 'en', 'Download', 'Download', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(96, 'en', 'There have been no reviews for this product yet.', 'There have been no reviews for this product yet.', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(97, 'en', 'Related products', 'Related products', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(98, 'en', 'Any query about this product', 'Any query about this product', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(99, 'en', 'Product Name', 'Product Name', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(100, 'en', 'Your Question', 'Your Question', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(101, 'en', 'Send', 'Send', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(103, 'en', 'Use country code before number', 'Use country code before number', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(105, 'en', 'Remember Me', 'Remember Me', '2020-11-02 08:18:03', '2020-11-02 08:18:03'),
(107, 'en', 'Dont have an account?', 'Dont have an account?', '2020-11-02 08:18:04', '2020-11-02 08:18:04'),
(108, 'en', 'Register Now', 'Register Now', '2020-11-02 08:18:04', '2020-11-02 08:18:04'),
(109, 'en', 'Or Login With', 'Or Login With', '2020-11-02 08:18:04', '2020-11-02 08:18:04'),
(110, 'en', 'oops..', 'oops..', '2020-11-02 10:29:04', '2020-11-02 10:29:04'),
(111, 'en', 'This item is out of stock!', 'This item is out of stock!', '2020-11-02 10:29:04', '2020-11-02 10:29:04'),
(112, 'en', 'Back to shopping', 'Back to shopping', '2020-11-02 10:29:04', '2020-11-02 10:29:04'),
(113, 'en', 'Login to your account.', 'Login to your account.', '2020-11-02 11:27:41', '2020-11-02 11:27:41'),
(115, 'en', 'Purchase History', 'Purchase History', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(116, 'en', 'New', 'New', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(117, 'en', 'Downloads', 'Downloads', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(118, 'en', 'Sent Refund Request', 'Sent Refund Request', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(119, 'en', 'Product Bulk Upload', 'Product Bulk Upload', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(123, 'en', 'Orders', 'Orders', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(124, 'en', 'Recieved Refund Request', 'Recieved Refund Request', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(126, 'en', 'Shop Setting', 'Shop Setting', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(127, 'en', 'Payment History', 'Payment History', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(128, 'en', 'Money Withdraw', 'Money Withdraw', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(129, 'en', 'Conversations', 'Conversations', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(130, 'en', 'My Wallet', 'My Wallet', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(131, 'en', 'Earning Points', 'Earning Points', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(132, 'en', 'Support Ticket', 'Support Ticket', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(133, 'en', 'Manage Profile', 'Manage Profile', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(134, 'en', 'Sold Amount', 'Sold Amount', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(135, 'en', 'Your sold amount (current month)', 'Your sold amount (current month)', '2020-11-02 11:27:53', '2020-11-02 11:27:53'),
(136, 'en', 'Total Sold', 'Total Sold', '2020-11-02 11:27:54', '2020-11-02 11:27:54'),
(137, 'en', 'Last Month Sold', 'Last Month Sold', '2020-11-02 11:27:54', '2020-11-02 11:27:54'),
(138, 'en', 'Total sale', 'Total sale', '2020-11-02 11:27:54', '2020-11-02 11:27:54'),
(139, 'en', 'Total earnings', 'Total earnings', '2020-11-02 11:27:54', '2020-11-02 11:27:54'),
(140, 'en', 'Successful orders', 'Successful orders', '2020-11-02 11:27:54', '2020-11-02 11:27:54'),
(141, 'en', 'Total orders', 'Total orders', '2020-11-02 11:27:54', '2020-11-02 11:27:54'),
(142, 'en', 'Pending orders', 'Pending orders', '2020-11-02 11:27:54', '2020-11-02 11:27:54'),
(143, 'en', 'Cancelled orders', 'Cancelled orders', '2020-11-02 11:27:54', '2020-11-02 11:27:54'),
(145, 'en', 'Product', 'Product', '2020-11-02 11:27:55', '2020-11-02 11:27:55'),
(147, 'en', 'Purchased Package', 'Purchased Package', '2020-11-02 11:27:55', '2020-11-02 11:27:55'),
(148, 'en', 'Package Not Found', 'Package Not Found', '2020-11-02 11:27:55', '2020-11-02 11:27:55'),
(149, 'en', 'Upgrade Package', 'Upgrade Package', '2020-11-02 11:27:55', '2020-11-02 11:27:55'),
(150, 'en', 'Shop', 'Shop', '2020-11-02 11:27:55', '2020-11-02 11:27:55'),
(151, 'en', 'Manage & organize your shop', 'Manage & organize your shop', '2020-11-02 11:27:55', '2020-11-02 11:27:55'),
(152, 'en', 'Go to setting', 'Go to setting', '2020-11-02 11:27:55', '2020-11-02 11:27:55'),
(153, 'en', 'Payment', 'Payment', '2020-11-02 11:27:55', '2020-11-02 11:27:55'),
(154, 'en', 'Configure your payment method', 'Configure your payment method', '2020-11-02 11:27:55', '2020-11-02 11:27:55'),
(156, 'en', 'My Panel', 'My Panel', '2020-11-02 11:27:55', '2020-11-02 11:27:55'),
(158, 'en', 'Item has been added to wishlist', 'Item has been added to wishlist', '2020-11-02 11:27:55', '2020-11-02 11:27:55'),
(159, 'en', 'My Points', 'My Points', '2020-11-02 11:28:15', '2020-11-02 11:28:15'),
(160, 'en', ' Points', 'Points', '2020-11-02 11:28:15', '2021-02-13 06:53:54'),
(161, 'en', 'Wallet Money', 'Wallet Money', '2020-11-02 11:28:16', '2020-11-02 11:28:16'),
(162, 'en', 'Exchange Rate', 'Exchange Rate', '2020-11-02 11:28:16', '2020-11-02 11:28:16'),
(163, 'en', 'Point Earning history', 'Point Earning history', '2020-11-02 11:28:16', '2020-11-02 11:28:16'),
(164, 'en', 'Date', 'Date', '2020-11-02 11:28:16', '2020-11-02 11:28:16'),
(165, 'en', 'Points', 'Points', '2020-11-02 11:28:16', '2020-11-02 11:28:16'),
(166, 'en', 'Converted', 'Converted', '2020-11-02 11:28:16', '2020-11-02 11:28:16'),
(167, 'en', 'Action', 'Action', '2020-11-02 11:28:16', '2020-11-02 11:28:16'),
(168, 'en', 'No history found.', 'No history found.', '2020-11-02 11:28:16', '2020-11-02 11:28:16'),
(169, 'en', 'Convert has been done successfully Check your Wallets', 'Convert has been done successfully Check your Wallets', '2020-11-02 11:28:16', '2020-11-02 11:28:16'),
(170, 'en', 'Something went wrong', 'Something went wrong', '2020-11-02 11:28:16', '2020-11-02 11:28:16'),
(171, 'en', 'Remaining Uploads', 'Remaining Uploads', '2020-11-02 11:37:13', '2020-11-02 11:37:13'),
(172, 'en', 'No Package Found', 'No Package Found', '2020-11-02 11:37:13', '2020-11-02 11:37:13'),
(173, 'en', 'Search product', 'Search product', '2020-11-02 11:37:13', '2020-11-02 11:37:13'),
(174, 'en', 'Name', 'Name', '2020-11-02 11:37:13', '2020-11-02 11:37:13'),
(176, 'en', 'Current Qty', 'Current Qty', '2020-11-02 11:37:13', '2020-11-02 11:37:13'),
(177, 'en', 'Base Price', 'Base Price', '2020-11-02 11:37:13', '2020-11-02 11:37:13'),
(178, 'en', 'Published', 'Published', '2020-11-02 11:37:13', '2020-11-02 11:37:13'),
(179, 'en', 'Featured', 'Featured', '2020-11-02 11:37:13', '2020-11-02 11:37:13'),
(180, 'en', 'Options', 'Options', '2020-11-02 11:37:13', '2020-11-02 11:37:13'),
(181, 'en', 'Edit', 'Edit', '2020-11-02 11:37:13', '2020-11-02 11:37:13'),
(182, 'en', 'Duplicate', 'Duplicate', '2020-11-02 11:37:13', '2020-11-02 11:37:13'),
(184, 'en', '1. Download the skeleton file and fill it with data.', '1. Download the skeleton file and fill it with data.', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(185, 'en', '2. You can download the example file to understand how the data must be filled.', '2. You can download the example file to understand how the data must be filled.', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(186, 'en', '3. Once you have downloaded and filled the skeleton file, upload it in the form below and submit.', '3. Once you have downloaded and filled the skeleton file, upload it in the form below and submit.', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(187, 'en', '4. After uploading products you need to edit them and set products images and choices.', '4. After uploading products you need to edit them and set products images and choices.', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(188, 'en', 'Download CSV', 'Download CSV', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(189, 'en', '1. Category,Sub category,Sub Sub category and Brand should be in numerical ids.', '1. Category,Sub category,Sub Sub category and Brand should be in numerical ids.', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(190, 'en', '2. You can download the pdf to get Category,Sub category,Sub Sub category and Brand id.', '2. You can download the pdf to get Category,Sub category,Sub Sub category and Brand id.', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(191, 'en', 'Download Category', 'Download Category', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(192, 'en', 'Download Sub category', 'Download Sub category', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(193, 'en', 'Download Sub Sub category', 'Download Sub Sub category', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(194, 'en', 'Download Brand', 'Download Brand', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(195, 'en', 'Upload CSV File', 'Upload CSV File', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(196, 'en', 'CSV', 'CSV', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(197, 'en', 'Choose CSV File', 'Choose CSV File', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(198, 'en', 'Upload', 'Upload', '2020-11-02 11:37:20', '2020-11-02 11:37:20'),
(199, 'en', 'Add New Digital Product', 'Add New Digital Product', '2020-11-02 11:37:25', '2020-11-02 11:37:25'),
(200, 'en', 'Available Status', 'Available Status', '2020-11-02 11:37:29', '2020-11-02 11:37:29'),
(201, 'en', 'Admin Status', 'Admin Status', '2020-11-02 11:37:29', '2020-11-02 11:37:29'),
(202, 'en', 'Pending Balance', 'Pending Balance', '2020-11-02 11:38:07', '2020-11-02 11:38:07'),
(203, 'en', 'Send Withdraw Request', 'Send Withdraw Request', '2020-11-02 11:38:07', '2020-11-02 11:38:07'),
(204, 'en', 'Withdraw Request history', 'Withdraw Request history', '2020-11-02 11:38:07', '2020-11-02 11:38:07'),
(205, 'en', 'Amount', 'Amount', '2020-11-02 11:38:07', '2020-11-02 11:38:07'),
(206, 'en', 'Status', 'Status', '2020-11-02 11:38:07', '2020-11-02 11:38:07'),
(207, 'en', 'Message', 'Message', '2020-11-02 11:38:07', '2020-11-02 11:38:07'),
(208, 'en', 'Send A Withdraw Request', 'Send A Withdraw Request', '2020-11-02 11:38:07', '2020-11-02 11:38:07'),
(209, 'en', 'Basic Info', 'Basic Info', '2020-11-02 11:38:13', '2020-11-02 11:38:13'),
(211, 'en', 'Your Phone', 'Your Phone', '2020-11-02 11:38:13', '2020-11-02 11:38:13'),
(212, 'en', 'Photo', 'Photo', '2020-11-02 11:38:13', '2020-11-02 11:38:13'),
(213, 'en', 'Browse', 'Browse', '2020-11-02 11:38:13', '2020-11-02 11:38:13'),
(215, 'en', 'Your Password', 'Your Password', '2020-11-02 11:38:13', '2020-11-02 11:38:13'),
(216, 'en', 'New Password', 'New Password', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(217, 'en', 'Confirm Password', 'Confirm Password', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(218, 'en', 'Add New Address', 'Add New Address', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(219, 'en', 'Payment Setting', 'Payment Setting', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(220, 'en', 'Cash Payment', 'Cash Payment', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(221, 'en', 'Bank Payment', 'Bank Payment', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(222, 'en', 'Bank Name', 'Bank Name', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(223, 'en', 'Bank Account Name', 'Bank Account Name', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(224, 'en', 'Bank Account Number', 'Bank Account Number', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(225, 'en', 'Bank Routing Number', 'Bank Routing Number', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(226, 'en', 'Update Profile', 'Update Profile', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(227, 'en', 'Change your email', 'Change your email', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(228, 'en', 'Your Email', 'Your Email', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(229, 'en', 'Sending Email...', 'Sending Email...', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(230, 'en', 'Verify', 'Verify', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(231, 'en', 'Update Email', 'Update Email', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(232, 'en', 'New Address', 'New Address', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(233, 'en', 'Your Address', 'Your Address', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(234, 'en', 'Country', 'Country', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(235, 'en', 'Select your country', 'Select your country', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(236, 'en', 'City', 'City', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(237, 'en', 'Your City', 'Your City', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(239, 'en', 'Your Postal Code', 'Your Postal Code', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(240, 'en', '+880', '+880', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(241, 'en', 'Save', 'Save', '2020-11-02 11:38:14', '2020-11-02 11:38:14'),
(242, 'en', 'Received Refund Request', 'Received Refund Request', '2020-11-02 11:56:20', '2020-11-02 11:56:20'),
(244, 'en', 'Delete Confirmation', 'Delete Confirmation', '2020-11-02 11:56:20', '2020-11-02 11:56:20'),
(245, 'en', 'Are you sure to delete this?', 'Are you sure to delete this?', '2020-11-02 11:56:21', '2020-11-02 11:56:21'),
(246, 'en', 'Premium Packages for Sellers', 'Premium Packages for Sellers', '2020-11-02 11:57:36', '2020-11-02 11:57:36'),
(247, 'en', 'Product Upload', 'Product Upload', '2020-11-02 11:57:36', '2020-11-02 11:57:36'),
(248, 'en', 'Digital Product Upload', 'Digital Product Upload', '2020-11-02 11:57:36', '2020-11-02 11:57:36'),
(250, 'en', 'Purchase Package', 'Purchase Package', '2020-11-02 11:57:36', '2020-11-02 11:57:36'),
(251, 'en', 'Select Payment Type', 'Select Payment Type', '2020-11-02 11:57:36', '2020-11-02 11:57:36'),
(252, 'en', 'Payment Type', 'Payment Type', '2020-11-02 11:57:36', '2020-11-02 11:57:36'),
(253, 'en', 'Select One', 'Select One', '2020-11-02 11:57:36', '2020-11-02 11:57:36'),
(254, 'en', 'Online payment', 'Online payment', '2020-11-02 11:57:37', '2020-11-02 11:57:37'),
(255, 'en', 'Offline payment', 'Offline payment', '2020-11-02 11:57:37', '2020-11-02 11:57:37'),
(256, 'en', 'Purchase Your Package', 'Purchase Your Package', '2020-11-02 11:57:37', '2020-11-02 11:57:37'),
(258, 'en', 'Paypal', 'Paypal', '2020-11-02 11:57:37', '2020-11-02 11:57:37'),
(259, 'en', 'Stripe', 'Stripe', '2020-11-02 11:57:37', '2020-11-02 11:57:37'),
(260, 'en', 'sslcommerz', 'sslcommerz', '2020-11-02 11:57:37', '2020-11-02 11:57:37'),
(265, 'en', 'Confirm', 'Confirm', '2020-11-02 11:57:37', '2020-11-02 11:57:37'),
(266, 'en', 'Offline Package Payment', 'Offline Package Payment', '2020-11-02 11:57:37', '2020-11-02 11:57:37'),
(267, 'en', 'Transaction ID', 'Transaction ID', '2020-11-02 12:30:12', '2020-11-02 12:30:12'),
(268, 'en', 'Choose image', 'Choose image', '2020-11-02 12:30:12', '2020-11-02 12:30:12'),
(269, 'en', 'Code', 'Code', '2020-11-02 12:42:00', '2020-11-02 12:42:00'),
(270, 'en', 'Delivery Status', 'Delivery Status', '2020-11-02 12:42:00', '2020-11-02 12:42:00'),
(271, 'en', 'Payment Status', 'Payment Status', '2020-11-02 12:42:00', '2020-11-02 12:42:00'),
(272, 'en', 'Paid', 'Paid', '2020-11-02 12:42:00', '2020-11-02 12:42:00'),
(273, 'en', 'Order Details', 'Order Details', '2020-11-02 12:42:00', '2020-11-02 12:42:00'),
(274, 'en', 'Download Invoice', 'Download Invoice', '2020-11-02 12:42:00', '2020-11-02 12:42:00'),
(275, 'en', 'Unpaid', 'Unpaid', '2020-11-02 12:42:00', '2020-11-02 12:42:00'),
(277, 'en', 'Order placed', 'Order placed', '2020-11-02 12:43:59', '2020-11-02 12:43:59'),
(278, 'en', 'Confirmed', 'Confirmed', '2020-11-02 12:43:59', '2020-11-02 12:43:59'),
(279, 'en', 'On delivery', 'On delivery', '2020-11-02 12:43:59', '2020-11-02 12:43:59'),
(280, 'en', 'Delivered', 'Delivered', '2020-11-02 12:43:59', '2020-11-02 12:43:59'),
(281, 'en', 'Order Summary', 'Order Summary', '2020-11-02 12:43:59', '2020-11-02 12:43:59'),
(282, 'en', 'Order Code', 'Order Code', '2020-11-02 12:43:59', '2020-11-02 12:43:59'),
(283, 'en', 'Customer', 'Customer', '2020-11-02 12:43:59', '2020-11-02 12:43:59'),
(287, 'en', 'Total order amount', 'Total order amount', '2020-11-02 12:43:59', '2020-11-02 12:43:59'),
(288, 'en', 'Shipping metdod', 'Shipping metdod', '2020-11-02 12:43:59', '2020-11-02 12:43:59'),
(289, 'en', 'Flat shipping rate', 'Flat shipping rate', '2020-11-02 12:44:00', '2020-11-02 12:44:00'),
(290, 'en', 'Payment metdod', 'Payment metdod', '2020-11-02 12:44:00', '2020-11-02 12:44:00'),
(291, 'en', 'Variation', 'Variation', '2020-11-02 12:44:00', '2020-11-02 12:44:00'),
(292, 'en', 'Delivery Type', 'Delivery Type', '2020-11-02 12:44:00', '2020-11-02 12:44:00'),
(293, 'en', 'Home Delivery', 'Home Delivery', '2020-11-02 12:44:00', '2020-11-02 12:44:00'),
(294, 'en', 'Order Ammount', 'Order Ammount', '2020-11-02 12:44:00', '2020-11-02 12:44:00'),
(295, 'en', 'Subtotal', 'Subtotal', '2020-11-02 12:44:00', '2020-11-02 12:44:00'),
(296, 'en', 'Shipping', 'Shipping', '2020-11-02 12:44:00', '2020-11-02 12:44:00'),
(298, 'en', 'Coupon Discount', 'Coupon Discount', '2020-11-02 12:44:00', '2020-11-02 12:44:00'),
(300, 'en', 'N/A', 'N/A', '2020-11-02 12:44:20', '2020-11-02 12:44:20'),
(301, 'en', 'In stock', 'In stock', '2020-11-02 12:54:52', '2020-11-02 12:54:52'),
(302, 'en', 'Buy Now', 'Buy Now', '2020-11-02 12:54:52', '2020-11-02 12:54:52'),
(303, 'en', 'Item added to your cart!', 'Item added to your cart!', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(304, 'en', 'Proceed to Checkout', 'Proceed to Checkout', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(305, 'en', 'Cart Items', 'Cart Items', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(306, 'en', '1. My Cart', '1. My Cart', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(307, 'en', 'View cart', 'View cart', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(308, 'en', '2. Shipping info', '2. Shipping info', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(309, 'en', 'Checkout', 'Checkout', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(310, 'en', '3. Delivery info', '3. Delivery info', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(311, 'en', '4. Payment', '4. Payment', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(312, 'en', '5. Confirmation', '5. Confirmation', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(313, 'en', 'Remove', 'Remove', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(314, 'en', 'Return to shop', 'Return to shop', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(315, 'en', 'Continue to Shipping', 'Continue to Shipping', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(316, 'en', 'Or', 'Or', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(317, 'en', 'Guest Checkout', 'Guest Checkout', '2020-11-02 12:56:46', '2020-11-02 12:56:46'),
(318, 'en', 'Continue to Delivery Info', 'Continue to Delivery Info', '2020-11-02 12:57:44', '2020-11-02 12:57:44'),
(319, 'en', 'Postal Code', 'Postal Code', '2020-11-02 13:01:01', '2020-11-02 13:01:01'),
(320, 'en', 'Choose Delivery Type', 'Choose Delivery Type', '2020-11-02 13:01:04', '2020-11-02 13:01:04'),
(321, 'en', 'Local Pickup', 'Local Pickup', '2020-11-02 13:01:04', '2020-11-02 13:01:04'),
(322, 'en', 'Select your nearest pickup point', 'Select your nearest pickup point', '2020-11-02 13:01:04', '2020-11-02 13:01:04'),
(323, 'en', 'Continue to Payment', 'Continue to Payment', '2020-11-02 13:01:04', '2020-11-02 13:01:04'),
(324, 'en', 'Select a payment option', 'Select a payment option', '2020-11-02 13:01:13', '2020-11-02 13:01:13'),
(325, 'en', 'Razorpay', 'Razorpay', '2020-11-02 13:01:13', '2020-11-02 13:01:13'),
(326, 'en', 'Paystack', 'Paystack', '2020-11-02 13:01:13', '2020-11-02 13:01:13'),
(327, 'en', 'VoguePay', 'VoguePay', '2020-11-02 13:01:13', '2020-11-02 13:01:13'),
(328, 'en', 'payhere', 'payhere', '2020-11-02 13:01:13', '2020-11-02 13:01:13'),
(329, 'en', 'ngenius', 'ngenius', '2020-11-02 13:01:13', '2020-11-02 13:01:13'),
(330, 'en', 'Paytm', 'Paytm', '2020-11-02 13:01:13', '2020-11-02 13:01:13'),
(331, 'en', 'Cash on Delivery', 'Cash on Delivery', '2020-11-02 13:01:13', '2020-11-02 13:01:13'),
(332, 'en', 'Your wallet balance :', 'Your wallet balance :', '2020-11-02 13:01:13', '2020-11-02 13:01:13'),
(333, 'en', 'Insufficient balance', 'Insufficient balance', '2020-11-02 13:01:13', '2020-11-02 13:01:13'),
(334, 'en', 'I agree to the', 'I agree to the', '2020-11-02 13:01:14', '2020-11-02 13:01:14'),
(338, 'en', 'Complete Order', 'Complete Order', '2020-11-02 13:01:14', '2020-11-02 13:01:14'),
(339, 'en', 'Summary', 'Summary', '2020-11-02 13:01:14', '2020-11-02 13:01:14'),
(340, 'en', 'Items', 'Items', '2020-11-02 13:01:14', '2020-11-02 13:01:14'),
(341, 'en', 'Total Club point', 'Total Club point', '2020-11-02 13:01:14', '2020-11-02 13:01:14'),
(342, 'en', 'Total Shipping', 'Total Shipping', '2020-11-02 13:01:14', '2020-11-02 13:01:14'),
(343, 'en', 'Have coupon code? Enter here', 'Have coupon code? Enter here', '2020-11-02 13:01:14', '2020-11-02 13:01:14'),
(344, 'en', 'Apply', 'Apply', '2020-11-02 13:01:14', '2020-11-02 13:01:14'),
(345, 'en', 'You need to agree with our policies', 'You need to agree with our policies', '2020-11-02 13:01:14', '2020-11-02 13:01:14'),
(346, 'en', 'Forgot password', 'Forgot password', '2020-11-02 13:01:25', '2020-11-02 13:01:25'),
(469, 'en', 'SEO Setting', 'SEO Setting', '2020-11-02 13:01:33', '2020-11-02 13:01:33'),
(474, 'en', 'System Update', 'System Update', '2020-11-02 13:01:34', '2020-11-02 13:01:34'),
(480, 'en', 'Add New Payment Method', 'Add New Payment Method', '2020-11-02 13:01:38', '2020-11-02 13:01:38'),
(481, 'en', 'Manual Payment Method', 'Manual Payment Method', '2020-11-02 13:01:38', '2020-11-02 13:01:38'),
(482, 'en', 'Heading', 'Heading', '2020-11-02 13:01:38', '2020-11-02 13:01:38'),
(483, 'en', 'Logo', 'Logo', '2020-11-02 13:01:38', '2020-11-02 13:01:38'),
(484, 'en', 'Manual Payment Information', 'Manual Payment Information', '2020-11-02 13:01:42', '2020-11-02 13:01:42'),
(485, 'en', 'Type', 'Type', '2020-11-02 13:01:42', '2020-11-02 13:01:42'),
(486, 'en', 'Custom Payment', 'Custom Payment', '2020-11-02 13:01:42', '2020-11-02 13:01:42'),
(487, 'en', 'Check Payment', 'Check Payment', '2020-11-02 13:01:42', '2020-11-02 13:01:42'),
(488, 'en', 'Checkout Thumbnail', 'Checkout Thumbnail', '2020-11-02 13:01:42', '2020-11-02 13:01:42'),
(489, 'en', 'Payment Instruction', 'Payment Instruction', '2020-11-02 13:01:42', '2020-11-02 13:01:42'),
(490, 'en', 'Bank Information', 'Bank Information', '2020-11-02 13:01:42', '2020-11-02 13:01:42'),
(491, 'en', 'Select File', 'Select File', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(492, 'en', 'Upload New', 'Upload New', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(493, 'en', 'Sort by newest', 'Sort by newest', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(494, 'en', 'Sort by oldest', 'Sort by oldest', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(495, 'en', 'Sort by smallest', 'Sort by smallest', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(496, 'en', 'Sort by largest', 'Sort by largest', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(497, 'en', 'Selected Only', 'Selected Only', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(498, 'en', 'No files found', 'No files found', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(499, 'en', '0 File selected', '0 File selected', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(500, 'en', 'Clear', 'Clear', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(501, 'en', 'Prev', 'Prev', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(502, 'en', 'Next', 'Next', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(503, 'en', 'Add Files', 'Add Files', '2020-11-02 13:01:53', '2020-11-02 13:01:53'),
(504, 'en', 'Method has been inserted successfully', 'Method has been inserted successfully', '2020-11-02 13:02:03', '2020-11-02 13:02:03'),
(506, 'en', 'Order Date', 'Order Date', '2020-11-02 13:02:42', '2020-11-02 13:02:42'),
(507, 'en', 'Bill to', 'Bill to', '2020-11-02 13:02:42', '2020-11-02 13:02:42'),
(510, 'en', 'Sub Total', 'Sub Total', '2020-11-02 13:02:42', '2020-11-02 13:02:42'),
(512, 'en', 'Total Tax', 'Total Tax', '2020-11-02 13:02:42', '2020-11-02 13:02:42'),
(513, 'en', 'Grand Total', 'Grand Total', '2020-11-02 13:02:42', '2020-11-02 13:02:42'),
(514, 'en', 'Your order has been placed successfully. Please submit payment information from purchase history', 'Your order has been placed successfully. Please submit payment information from purchase history', '2020-11-02 13:02:47', '2020-11-02 13:02:47'),
(515, 'en', 'Thank You for Your Order!', 'Thank You for Your Order!', '2020-11-02 13:02:48', '2020-11-02 13:02:48'),
(516, 'en', 'Order Code:', 'Order Code:', '2020-11-02 13:02:48', '2020-11-02 13:02:48'),
(517, 'en', 'A copy or your order summary has been sent to', 'A copy or your order summary has been sent to', '2020-11-02 13:02:48', '2020-11-02 13:02:48'),
(518, 'en', 'Make Payment', 'Make Payment', '2020-11-02 13:03:26', '2020-11-02 13:03:26'),
(519, 'en', 'Payment screenshot', 'Payment screenshot', '2020-11-02 13:03:29', '2020-11-02 13:03:29'),
(520, 'en', 'Paypal Credential', 'Paypal Credential', '2020-11-02 13:12:20', '2020-11-02 13:12:20'),
(522, 'en', 'Paypal Client ID', 'Paypal Client ID', '2020-11-02 13:12:20', '2020-11-02 13:12:20'),
(523, 'en', 'Paypal Client Secret', 'Paypal Client Secret', '2020-11-02 13:12:20', '2020-11-02 13:12:20'),
(524, 'en', 'Paypal Sandbox Mode', 'Paypal Sandbox Mode', '2020-11-02 13:12:20', '2020-11-02 13:12:20'),
(525, 'en', 'Sslcommerz Credential', 'Sslcommerz Credential', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(526, 'en', 'Sslcz Store Id', 'Sslcz Store Id', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(527, 'en', 'Sslcz store password', 'Sslcz store password', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(528, 'en', 'Sslcommerz Sandbox Mode', 'Sslcommerz Sandbox Mode', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(529, 'en', 'Stripe Credential', 'Stripe Credential', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(531, 'en', 'STRIPE KEY', 'STRIPE KEY', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(533, 'en', 'STRIPE SECRET', 'STRIPE SECRET', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(534, 'en', 'RazorPay Credential', 'RazorPay Credential', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(535, 'en', 'RAZOR KEY', 'RAZOR KEY', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(536, 'en', 'RAZOR SECRET', 'RAZOR SECRET', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(537, 'en', 'Instamojo Credential', 'Instamojo Credential', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(538, 'en', 'API KEY', 'API KEY', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(539, 'en', 'IM API KEY', 'IM API KEY', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(540, 'en', 'AUTH TOKEN', 'AUTH TOKEN', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(541, 'en', 'IM AUTH TOKEN', 'IM AUTH TOKEN', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(542, 'en', 'Instamojo Sandbox Mode', 'Instamojo Sandbox Mode', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(543, 'en', 'PayStack Credential', 'PayStack Credential', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(544, 'en', 'PUBLIC KEY', 'PUBLIC KEY', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(545, 'en', 'SECRET KEY', 'SECRET KEY', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(546, 'en', 'MERCHANT EMAIL', 'MERCHANT EMAIL', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(547, 'en', 'VoguePay Credential', 'VoguePay Credential', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(548, 'en', 'MERCHANT ID', 'MERCHANT ID', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(549, 'en', 'Sandbox Mode', 'Sandbox Mode', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(550, 'en', 'Payhere Credential', 'Payhere Credential', '2020-11-02 13:12:21', '2020-11-02 13:12:21'),
(551, 'en', 'PAYHERE MERCHANT ID', 'PAYHERE MERCHANT ID', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(552, 'en', 'PAYHERE SECRET', 'PAYHERE SECRET', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(553, 'en', 'PAYHERE CURRENCY', 'PAYHERE CURRENCY', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(554, 'en', 'Payhere Sandbox Mode', 'Payhere Sandbox Mode', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(555, 'en', 'Ngenius Credential', 'Ngenius Credential', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(556, 'en', 'NGENIUS OUTLET ID', 'NGENIUS OUTLET ID', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(557, 'en', 'NGENIUS API KEY', 'NGENIUS API KEY', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(558, 'en', 'NGENIUS CURRENCY', 'NGENIUS CURRENCY', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(559, 'en', 'Mpesa Credential', 'Mpesa Credential', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(560, 'en', 'MPESA CONSUMER KEY', 'MPESA CONSUMER KEY', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(561, 'en', 'MPESA_CONSUMER_KEY', 'MPESA_CONSUMER_KEY', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(562, 'en', 'MPESA CONSUMER SECRET', 'MPESA CONSUMER SECRET', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(563, 'en', 'MPESA_CONSUMER_SECRET', 'MPESA_CONSUMER_SECRET', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(564, 'en', 'MPESA SHORT CODE', 'MPESA SHORT CODE', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(565, 'en', 'MPESA_SHORT_CODE', 'MPESA_SHORT_CODE', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(566, 'en', 'MPESA SANDBOX ACTIVATION', 'MPESA SANDBOX ACTIVATION', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(567, 'en', 'Flutterwave Credential', 'Flutterwave Credential', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(568, 'en', 'RAVE_PUBLIC_KEY', 'RAVE_PUBLIC_KEY', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(569, 'en', 'RAVE_SECRET_KEY', 'RAVE_SECRET_KEY', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(570, 'en', 'RAVE_TITLE', 'RAVE_TITLE', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(571, 'en', 'STAGIN ACTIVATION', 'STAGIN ACTIVATION', '2020-11-02 13:12:22', '2020-11-02 13:12:22'),
(573, 'en', 'All Product', 'All Product', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(574, 'en', 'Sort By', 'Sort By', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(575, 'en', 'Rating (High > Low)', 'Rating (High > Low)', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(576, 'en', 'Rating (Low > High)', 'Rating (Low > High)', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(577, 'en', 'Num of Sale (High > Low)', 'Num of Sale (High > Low)', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(578, 'en', 'Num of Sale (Low > High)', 'Num of Sale (Low > High)', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(579, 'en', 'Base Price (High > Low)', 'Base Price (High > Low)', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(580, 'en', 'Base Price (Low > High)', 'Base Price (Low > High)', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(581, 'en', 'Type & Enter', 'Type & Enter', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(582, 'en', 'Added By', 'Added By', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(583, 'en', 'Num of Sale', 'Num of Sale', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(584, 'en', 'Total Stock', 'Total Stock', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(585, 'en', 'Todays Deal', 'Todays Deal', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(586, 'en', 'Rating', 'Rating', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(587, 'en', 'times', 'times', '2020-11-02 13:15:01', '2020-11-02 13:15:01'),
(588, 'en', 'Add Nerw Product', 'Add Nerw Product', '2020-11-02 13:15:02', '2020-11-02 13:15:02'),
(589, 'en', 'Product Information', 'Product Information', '2020-11-02 13:15:02', '2020-11-02 13:15:02'),
(590, 'en', 'Unit', 'Unit', '2020-11-02 13:15:02', '2020-11-02 13:15:02'),
(591, 'en', 'Unit (e.g. KG, Pc etc)', 'Unit (e.g. KG, Pc etc)', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(592, 'en', 'Minimum Qty', 'Minimum Qty', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(593, 'en', 'Tags', 'Tags', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(594, 'en', 'Type and hit enter to add a tag', 'Type and hit enter to add a tag', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(595, 'en', 'Barcode', 'Barcode', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(596, 'en', 'Refundable', 'Refundable', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(597, 'en', 'Product Images', 'Product Images', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(598, 'en', 'Gallery Images', 'Gallery Images', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(599, 'en', 'Todays Deal updated successfully', 'Todays Deal updated successfully', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(600, 'en', 'Published products updated successfully', 'Published products updated successfully', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(601, 'en', 'Thumbnail Image', 'Thumbnail Image', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(602, 'en', 'Featured products updated successfully', 'Featured products updated successfully', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(603, 'en', 'Product Videos', 'Product Videos', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(604, 'en', 'Video Provider', 'Video Provider', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(605, 'en', 'Youtube', 'Youtube', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(606, 'en', 'Dailymotion', 'Dailymotion', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(607, 'en', 'Vimeo', 'Vimeo', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(608, 'en', 'Video Link', 'Video Link', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(609, 'en', 'Product Variation', 'Product Variation', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(610, 'en', 'Colors', 'Colors', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(611, 'en', 'Attributes', 'Attributes', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(612, 'en', 'Choose Attributes', 'Choose Attributes', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(613, 'en', 'Choose the attributes of this product and then input values of each attribute', 'Choose the attributes of this product and then input values of each attribute', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(614, 'en', 'Product price + stock', 'Product price + stock', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(616, 'en', 'Unit price', 'Unit price', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(617, 'en', 'Purchase price', 'Purchase price', '2020-11-02 13:15:03', '2020-11-02 13:15:03'),
(618, 'en', 'Flat', 'Flat', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(619, 'en', 'Percent', 'Percent', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(620, 'en', 'Discount', 'Discount', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(621, 'en', 'Product Description', 'Product Description', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(622, 'en', 'Product Shipping Cost', 'Product Shipping Cost', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(623, 'en', 'Free Shipping', 'Free Shipping', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(624, 'en', 'Flat Rate', 'Flat Rate', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(625, 'en', 'Shipping cost', 'Shipping cost', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(626, 'en', 'PDF Specification', 'PDF Specification', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(627, 'en', 'SEO Meta Tags', 'SEO Meta Tags', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(628, 'en', 'Meta Title', 'Meta Title', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(629, 'en', 'Meta Image', 'Meta Image', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(630, 'en', 'Choice Title', 'Choice Title', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(631, 'en', 'Enter choice values', 'Enter choice values', '2020-11-02 13:15:04', '2020-11-02 13:15:04'),
(632, 'en', 'All categories', 'All categories', '2020-11-03 07:12:19', '2020-11-03 07:12:19'),
(633, 'en', 'Add New category', 'Add New category', '2020-11-03 07:12:19', '2020-11-03 07:12:19'),
(634, 'en', 'Type name & Enter', 'Type name & Enter', '2020-11-03 07:12:19', '2020-11-03 07:12:19'),
(635, 'en', 'Banner', 'Banner', '2020-11-03 07:12:19', '2020-11-03 07:12:19'),
(637, 'en', 'Commission', 'Commission', '2020-11-03 07:12:19', '2020-11-03 07:12:19'),
(638, 'en', 'icon', 'icon', '2020-11-03 07:12:19', '2020-11-03 07:12:19'),
(639, 'en', 'Featured categories updated successfully', 'Featured categories updated successfully', '2020-11-03 07:12:20', '2020-11-03 07:12:20'),
(640, 'en', 'Hot', 'Hot', '2020-11-03 07:13:12', '2020-11-03 07:13:12'),
(641, 'en', 'Filter by Payment Status', 'Filter by Payment Status', '2020-11-03 07:15:15', '2020-11-03 07:15:15'),
(642, 'en', 'Un-Paid', 'Un-Paid', '2020-11-03 07:15:15', '2020-11-03 07:15:15'),
(643, 'en', 'Filter by Deliver Status', 'Filter by Deliver Status', '2020-11-03 07:15:15', '2020-11-03 07:15:15'),
(644, 'en', 'Pending', 'Pending', '2020-11-03 07:15:15', '2020-11-03 07:15:15'),
(645, 'en', 'Type Order code & hit Enter', 'Type Order code & hit Enter', '2020-11-03 07:15:15', '2020-11-03 07:15:15'),
(646, 'en', 'Num. of Products', 'Num. of Products', '2020-11-03 07:15:15', '2020-11-03 07:15:15'),
(647, 'en', 'Walk In Customer', 'Walk In Customer', '2020-11-03 10:03:20', '2020-11-03 10:03:20'),
(648, 'en', 'QTY', 'QTY', '2020-11-03 10:03:20', '2020-11-03 10:03:20'),
(649, 'en', 'Without Shipping Charge', 'Without Shipping Charge', '2020-11-03 10:03:20', '2020-11-03 10:03:20'),
(650, 'en', 'With Shipping Charge', 'With Shipping Charge', '2020-11-03 10:03:20', '2020-11-03 10:03:20'),
(651, 'en', 'Pay With Cash', 'Pay With Cash', '2020-11-03 10:03:20', '2020-11-03 10:03:20'),
(652, 'en', 'Shipping Address', 'Shipping Address', '2020-11-03 10:03:20', '2020-11-03 10:03:20'),
(653, 'en', 'Close', 'Close', '2020-11-03 10:03:20', '2020-11-03 10:03:20'),
(654, 'en', 'Select country', 'Select country', '2020-11-03 10:03:21', '2020-11-03 10:03:21'),
(655, 'en', 'Order Confirmation', 'Order Confirmation', '2020-11-03 10:03:21', '2020-11-03 10:03:21'),
(656, 'en', 'Are you sure to confirm this order?', 'Are you sure to confirm this order?', '2020-11-03 10:03:21', '2020-11-03 10:03:21'),
(657, 'en', 'Comfirm Order', 'Comfirm Order', '2020-11-03 10:03:21', '2020-11-03 10:03:21'),
(659, 'en', 'Personal Info', 'Personal Info', '2020-11-03 11:38:15', '2020-11-03 11:38:15'),
(660, 'en', 'Repeat Password', 'Repeat Password', '2020-11-03 11:38:15', '2020-11-03 11:38:15'),
(661, 'en', 'Shop Name', 'Shop Name', '2020-11-03 11:38:15', '2020-11-03 11:38:15'),
(662, 'en', 'Register Your Shop', 'Register Your Shop', '2020-11-03 11:38:15', '2020-11-03 11:38:15'),
(663, 'en', 'Affiliate Informations', 'Affiliate Informations', '2020-11-03 11:39:06', '2020-11-03 11:39:06'),
(664, 'en', 'Affiliate', 'Affiliate', '2020-11-03 11:39:06', '2020-11-03 11:39:06'),
(665, 'en', 'User Info', 'User Info', '2020-11-03 11:39:06', '2020-11-03 11:39:06'),
(667, 'en', 'Installed Addon', 'Installed Addon', '2020-11-03 11:48:13', '2020-11-03 11:48:13'),
(668, 'en', 'Available Addon', 'Available Addon', '2020-11-03 11:48:13', '2020-11-03 11:48:13'),
(669, 'en', 'Install New Addon', 'Install New Addon', '2020-11-03 11:48:13', '2020-11-03 11:48:13'),
(670, 'en', 'Version', 'Version', '2020-11-03 11:48:13', '2020-11-03 11:48:13'),
(671, 'en', 'Activated', 'Activated', '2020-11-03 11:48:13', '2020-11-03 11:48:13'),
(672, 'en', 'Deactivated', 'Deactivated', '2020-11-03 11:48:13', '2020-11-03 11:48:13'),
(673, 'en', 'Activate OTP', 'Activate OTP', '2020-11-03 11:48:20', '2020-11-03 11:48:20'),
(674, 'en', 'OTP will be Used For', 'OTP will be Used For', '2020-11-03 11:48:20', '2020-11-03 11:48:20'),
(675, 'en', 'Settings updated successfully', 'Settings updated successfully', '2020-11-03 11:48:20', '2020-11-03 11:48:20'),
(676, 'en', 'Product Owner', 'Product Owner', '2020-11-03 11:48:46', '2020-11-03 11:48:46'),
(677, 'en', 'Point', 'Point', '2020-11-03 11:48:46', '2020-11-03 11:48:46'),
(678, 'en', 'Set Point for Product Within a Range', 'Set Point for Product Within a Range', '2020-11-03 11:48:47', '2020-11-03 11:48:47'),
(679, 'en', 'Set Point for multiple products', 'Set Point for multiple products', '2020-11-03 11:48:47', '2020-11-03 11:48:47'),
(680, 'en', 'Min Price', 'Min Price', '2020-11-03 11:48:47', '2020-11-03 11:48:47'),
(681, 'en', 'Max Price', 'Max Price', '2020-11-03 11:48:47', '2020-11-03 11:48:47'),
(682, 'en', 'Set Point for all Products', 'Set Point for all Products', '2020-11-03 11:48:47', '2020-11-03 11:48:47'),
(683, 'en', 'Set Point For ', 'Set Point For ', '2020-11-03 11:48:47', '2020-11-03 11:48:47'),
(684, 'en', 'Convert Status', 'Convert Status', '2020-11-03 11:48:58', '2020-11-03 11:48:58'),
(685, 'en', 'Earned At', 'Earned At', '2020-11-03 11:48:59', '2020-11-03 11:48:59'),
(686, 'en', 'Seller Based Selling Report', 'Seller Based Selling Report', '2020-11-03 11:49:35', '2020-11-03 11:49:35'),
(687, 'en', 'Sort by verificarion status', 'Sort by verificarion status', '2020-11-03 11:49:35', '2020-11-03 11:49:35'),
(688, 'en', 'Approved', 'Approved', '2020-11-03 11:49:35', '2020-11-03 11:49:35'),
(689, 'en', 'Non Approved', 'Non Approved', '2020-11-03 11:49:35', '2020-11-03 11:49:35'),
(690, 'en', 'Filter', 'Filter', '2020-11-03 11:49:35', '2020-11-03 11:49:35'),
(691, 'en', 'Seller Name', 'Seller Name', '2020-11-03 11:49:35', '2020-11-03 11:49:35'),
(692, 'en', 'Number of Product Sale', 'Number of Product Sale', '2020-11-03 11:49:36', '2020-11-03 11:49:36'),
(693, 'en', 'Order Amount', 'Order Amount', '2020-11-03 11:49:36', '2020-11-03 11:49:36'),
(694, 'en', 'Facebook Chat Setting', 'Facebook Chat Setting', '2020-11-03 11:51:14', '2020-11-03 11:51:14'),
(695, 'en', 'Facebook Page ID', 'Facebook Page ID', '2020-11-03 11:51:14', '2020-11-03 11:51:14'),
(696, 'en', 'Please be carefull when you are configuring Facebook chat. For incorrect configuration you will not get messenger icon on your user-end site.', 'Please be carefull when you are configuring Facebook chat. For incorrect configuration you will not get messenger icon on your user-end site.', '2020-11-03 11:51:14', '2020-11-03 11:51:14'),
(697, 'en', 'Login into your facebook page', 'Login into your facebook page', '2020-11-03 11:51:14', '2020-11-03 11:51:14'),
(698, 'en', 'Find the About option of your facebook page', 'Find the About option of your facebook page', '2020-11-03 11:51:14', '2020-11-03 11:51:14'),
(699, 'en', 'At the very bottom, you can find the \\“Facebook Page ID\\”', 'At the very bottom, you can find the \\“Facebook Page ID\\”', '2020-11-03 11:51:14', '2020-11-03 11:51:14'),
(700, 'en', 'Go to Settings of your page and find the option of \\\"Advance Messaging\\\"', 'Go to Settings of your page and find the option of \\\"Advance Messaging\\\"', '2020-11-03 11:51:14', '2020-11-03 11:51:14'),
(701, 'en', 'Scroll down that page and you will get \\\"white listed domain\\\"', 'Scroll down that page and you will get \\\"white listed domain\\\"', '2020-11-03 11:51:14', '2020-11-03 11:51:14'),
(702, 'en', 'Set your website domain name', 'Set your website domain name', '2020-11-03 11:51:14', '2020-11-03 11:51:14'),
(703, 'en', 'Google reCAPTCHA Setting', 'Google reCAPTCHA Setting', '2020-11-03 11:51:25', '2020-11-03 11:51:25'),
(704, 'en', 'Site KEY', 'Site KEY', '2020-11-03 11:51:25', '2020-11-03 11:51:25'),
(705, 'en', 'Select Shipping Method', 'Select Shipping Method', '2020-11-03 11:51:32', '2020-11-03 11:51:32'),
(706, 'en', 'Product Wise Shipping Cost', 'Product Wise Shipping Cost', '2020-11-03 11:51:32', '2020-11-03 11:51:32'),
(707, 'en', 'Flat Rate Shipping Cost', 'Flat Rate Shipping Cost', '2020-11-03 11:51:32', '2020-11-03 11:51:32'),
(708, 'en', 'Seller Wise Flat Shipping Cost', 'Seller Wise Flat Shipping Cost', '2020-11-03 11:51:32', '2020-11-03 11:51:32'),
(709, 'en', 'Note', 'Note', '2020-11-03 11:51:32', '2020-11-03 11:51:32'),
(710, 'en', 'Product Wise Shipping Cost calulation: Shipping cost is calculate by addition of each product shipping cost', 'Product Wise Shipping Cost calulation: Shipping cost is calculate by addition of each product shipping cost', '2020-11-03 11:51:32', '2020-11-03 11:51:32'),
(711, 'en', 'Flat Rate Shipping Cost calulation: How many products a customer purchase, doesn\'t matter. Shipping cost is fixed', 'Flat Rate Shipping Cost calulation: How many products a customer purchase, doesn\'t matter. Shipping cost is fixed', '2020-11-03 11:51:32', '2020-11-03 11:51:32'),
(712, 'en', 'Seller Wise Flat Shipping Cost calulation: Fixed rate for each seller. If a customer purchase 2 product from two seller shipping cost is calculate by addition of each seller flat shipping cost', 'Seller Wise Flat Shipping Cost calulation: Fixed rate for each seller. If a customer purchase 2 product from two seller shipping cost is calculate by addition of each seller flat shipping cost', '2020-11-03 11:51:32', '2020-11-03 11:51:32'),
(713, 'en', 'Flat Rate Cost', 'Flat Rate Cost', '2020-11-03 11:51:32', '2020-11-03 11:51:32'),
(714, 'en', 'Shipping Cost for Admin Products', 'Shipping Cost for Admin Products', '2020-11-03 11:51:32', '2020-11-03 11:51:32'),
(715, 'en', 'Countries', 'Countries', '2020-11-03 11:52:02', '2020-11-03 11:52:02'),
(716, 'en', 'Show/Hide', 'Show/Hide', '2020-11-03 11:52:02', '2020-11-03 11:52:02'),
(717, 'en', 'Country status updated successfully', 'Country status updated successfully', '2020-11-03 11:52:02', '2020-11-03 11:52:02'),
(718, 'en', 'All Subcategories', 'All Subcategories', '2020-11-03 12:27:55', '2020-11-03 12:27:55'),
(719, 'en', 'Add New Subcategory', 'Add New Subcategory', '2020-11-03 12:27:55', '2020-11-03 12:27:55'),
(720, 'en', 'Sub-Categories', 'Sub-Categories', '2020-11-03 12:27:55', '2020-11-03 12:27:55'),
(721, 'en', 'Sub Category Information', 'Sub Category Information', '2020-11-03 12:28:07', '2020-11-03 12:28:07'),
(723, 'en', 'Slug', 'Slug', '2020-11-03 12:28:07', '2020-11-03 12:28:07'),
(724, 'en', 'All Sub Subcategories', 'All Sub Subcategories', '2020-11-03 12:29:12', '2020-11-03 12:29:12'),
(725, 'en', 'Add New Sub Subcategory', 'Add New Sub Subcategory', '2020-11-03 12:29:12', '2020-11-03 12:29:12'),
(726, 'en', 'Sub-Sub-categories', 'Sub-Sub-categories', '2020-11-03 12:29:12', '2020-11-03 12:29:12'),
(727, 'en', 'Make This Default', 'Make This Default', '2020-11-04 08:24:24', '2020-11-04 08:24:24');
INSERT INTO `translations` (`id`, `lang`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(728, 'en', 'Shops', 'Shops', '2020-11-04 11:17:10', '2020-11-04 11:17:10'),
(729, 'en', 'Women Clothing & Fashion', 'Women Clothing & Fashion', '2020-11-04 11:23:12', '2020-11-04 11:23:12'),
(730, 'en', 'Cellphones & Tabs', 'Cellphones & Tabs', '2020-11-04 12:10:41', '2020-11-04 12:10:41'),
(731, 'en', 'Welcome to', 'Welcome to', '2020-11-07 07:14:43', '2020-11-07 07:14:43'),
(732, 'en', 'Create a New Account', 'Create a New Account', '2020-11-07 07:32:15', '2020-11-07 07:32:15'),
(733, 'en', 'Full Name', 'Full Name', '2020-11-07 07:32:15', '2020-11-07 07:32:15'),
(734, 'en', 'password', 'password', '2020-11-07 07:32:15', '2020-11-07 07:32:15'),
(735, 'en', 'Confrim Password', 'Confrim Password', '2020-11-07 07:32:15', '2020-11-07 07:32:15'),
(736, 'en', 'I agree with the', 'I agree with the', '2020-11-07 07:32:15', '2020-11-07 07:32:15'),
(737, 'en', 'Terms and Conditions', 'Terms and Conditions', '2020-11-07 07:32:15', '2020-11-07 07:32:15'),
(738, 'en', 'Register', 'Register', '2020-11-07 07:32:15', '2020-11-07 07:32:15'),
(739, 'en', 'Already have an account', 'Already have an account', '2020-11-07 07:32:16', '2020-11-07 07:32:16'),
(741, 'en', 'Sign Up with', 'Sign Up with', '2020-11-07 07:32:16', '2020-11-07 07:32:16'),
(742, 'en', 'I agree with the Terms and Conditions', 'I agree with the Terms and Conditions', '2020-11-07 07:34:49', '2020-11-07 07:34:49'),
(745, 'en', 'All Role', 'All Role', '2020-11-07 07:44:28', '2020-11-07 07:44:28'),
(746, 'en', 'Add New Role', 'Add New Role', '2020-11-07 07:44:28', '2020-11-07 07:44:28'),
(747, 'en', 'Roles', 'Roles', '2020-11-07 07:44:28', '2020-11-07 07:44:28'),
(749, 'en', 'Add New Staffs', 'Add New Staffs', '2020-11-07 07:44:36', '2020-11-07 07:44:36'),
(750, 'en', 'Role', 'Role', '2020-11-07 07:44:36', '2020-11-07 07:44:36'),
(751, 'en', 'Frontend Website Name', 'Frontend Website Name', '2020-11-07 07:44:59', '2020-11-07 07:44:59'),
(752, 'en', 'Website Name', 'Website Name', '2020-11-07 07:44:59', '2020-11-07 07:44:59'),
(753, 'en', 'Site Motto', 'Site Motto', '2020-11-07 07:44:59', '2020-11-07 07:44:59'),
(754, 'en', 'Best eCommerce Website', 'Best eCommerce Website', '2020-11-07 07:44:59', '2020-11-07 07:44:59'),
(755, 'en', 'Site Icon', 'Site Icon', '2020-11-07 07:44:59', '2020-11-07 07:44:59'),
(756, 'en', 'Website favicon. 32x32 .png', 'Website favicon. 32x32 .png', '2020-11-07 07:44:59', '2020-11-07 07:44:59'),
(757, 'en', 'Website Base Color', 'Website Base Color', '2020-11-07 07:44:59', '2020-11-07 07:44:59'),
(758, 'en', 'Hex Color Code', 'Hex Color Code', '2020-11-07 07:44:59', '2020-11-07 07:44:59'),
(759, 'en', 'Website Base Hover Color', 'Website Base Hover Color', '2020-11-07 07:44:59', '2020-11-07 07:44:59'),
(760, 'en', 'Update', 'Update', '2020-11-07 07:45:00', '2020-11-07 07:45:00'),
(761, 'en', 'Global Seo', 'Global Seo', '2020-11-07 07:45:00', '2020-11-07 07:45:00'),
(762, 'en', 'Meta description', 'Meta description', '2020-11-07 07:45:00', '2020-11-07 07:45:00'),
(763, 'en', 'Keywords', 'Keywords', '2020-11-07 07:45:00', '2020-11-07 07:45:00'),
(764, 'en', 'Separate with coma', 'Separate with coma', '2020-11-07 07:45:00', '2020-11-07 07:45:00'),
(765, 'en', 'Website Pages', 'Website Pages', '2020-11-07 07:49:04', '2020-11-07 07:49:04'),
(766, 'en', 'All Pages', 'All Pages', '2020-11-07 07:49:04', '2020-11-07 07:49:04'),
(767, 'en', 'Add New Page', 'Add New Page', '2020-11-07 07:49:04', '2020-11-07 07:49:04'),
(768, 'en', 'URL', 'URL', '2020-11-07 07:49:04', '2020-11-07 07:49:04'),
(769, 'en', 'Actions', 'Actions', '2020-11-07 07:49:04', '2020-11-07 07:49:04'),
(770, 'en', 'Edit Page Information', 'Edit Page Information', '2020-11-07 07:49:22', '2020-11-07 07:49:22'),
(771, 'en', 'Page Content', 'Page Content', '2020-11-07 07:49:22', '2020-11-07 07:49:22'),
(772, 'en', 'Title', 'Title', '2020-11-07 07:49:22', '2020-11-07 07:49:22'),
(773, 'en', 'Link', 'Link', '2020-11-07 07:49:22', '2020-11-07 07:49:22'),
(774, 'en', 'Use character, number, hypen only', 'Use character, number, hypen only', '2020-11-07 07:49:22', '2020-11-07 07:49:22'),
(775, 'en', 'Add Content', 'Add Content', '2020-11-07 07:49:22', '2020-11-07 07:49:22'),
(776, 'en', 'Seo Fields', 'Seo Fields', '2020-11-07 07:49:22', '2020-11-07 07:49:22'),
(777, 'en', 'Update Page', 'Update Page', '2020-11-07 07:49:22', '2020-11-07 07:49:22'),
(778, 'en', 'Default Language', 'Default Language', '2020-11-07 07:50:09', '2020-11-07 07:50:09'),
(779, 'en', 'Add New Language', 'Add New Language', '2020-11-07 07:50:09', '2020-11-07 07:50:09'),
(780, 'en', 'RTL', 'RTL', '2020-11-07 07:50:09', '2020-11-07 07:50:09'),
(781, 'en', 'Translation', 'Translation', '2020-11-07 07:50:09', '2020-11-07 07:50:09'),
(782, 'en', 'Language Information', 'Language Information', '2020-11-07 07:50:23', '2020-11-07 07:50:23'),
(783, 'en', 'Save Page', 'Save Page', '2020-11-07 07:51:27', '2020-11-07 07:51:27'),
(784, 'en', 'Home Page Settings', 'Home Page Settings', '2020-11-07 07:51:35', '2020-11-07 07:51:35'),
(785, 'en', 'Home Slider', 'Home Slider', '2020-11-07 07:51:35', '2020-11-07 07:51:35'),
(786, 'en', 'Photos & Links', 'Photos & Links', '2020-11-07 07:51:35', '2020-11-07 07:51:35'),
(787, 'en', 'Add New', 'Add New', '2020-11-07 07:51:35', '2020-11-07 07:51:35'),
(788, 'en', 'Home Categories', 'Home Categories', '2020-11-07 07:51:35', '2020-11-07 07:51:35'),
(789, 'en', 'Home Banner 1 (Max 3)', 'Home Banner 1 (Max 3)', '2020-11-07 07:51:35', '2020-11-07 07:51:35'),
(790, 'en', 'Banner & Links', 'Banner & Links', '2020-11-07 07:51:35', '2020-11-07 07:51:35'),
(791, 'en', 'Home Banner 2 (Max 3)', 'Home Banner 2 (Max 3)', '2020-11-07 07:51:36', '2020-11-07 07:51:36'),
(792, 'en', 'Top 10', 'Top 10', '2020-11-07 07:51:36', '2020-11-07 07:51:36'),
(793, 'en', 'Top Categories (Max 10)', 'Top Categories (Max 10)', '2020-11-07 07:51:36', '2020-11-07 07:51:36'),
(794, 'en', 'Top Brands (Max 10)', 'Top Brands (Max 10)', '2020-11-07 07:51:36', '2020-11-07 07:51:36'),
(795, 'en', 'System Name', 'System Name', '2020-11-07 07:54:22', '2020-11-07 07:54:22'),
(796, 'en', 'System Logo - White', 'System Logo - White', '2020-11-07 07:54:22', '2020-11-07 07:54:22'),
(797, 'en', 'Choose Files', 'Choose Files', '2020-11-07 07:54:22', '2020-11-07 07:54:22'),
(798, 'en', 'Will be used in admin panel side menu', 'Will be used in admin panel side menu', '2020-11-07 07:54:23', '2020-11-07 07:54:23'),
(799, 'en', 'System Logo - Black', 'System Logo - Black', '2020-11-07 07:54:23', '2020-11-07 07:54:23'),
(800, 'en', 'Will be used in admin panel topbar in mobile + Admin login page', 'Will be used in admin panel topbar in mobile + Admin login page', '2020-11-07 07:54:23', '2020-11-07 07:54:23'),
(801, 'en', 'System Timezone', 'System Timezone', '2020-11-07 07:54:23', '2020-11-07 07:54:23'),
(802, 'en', 'Admin login page background', 'Admin login page background', '2020-11-07 07:54:23', '2020-11-07 07:54:23'),
(803, 'en', 'Website Header', 'Website Header', '2020-11-07 08:21:36', '2020-11-07 08:21:36'),
(804, 'en', 'Header Setting', 'Header Setting', '2020-11-07 08:21:36', '2020-11-07 08:21:36'),
(805, 'en', 'Header Logo', 'Header Logo', '2020-11-07 08:21:36', '2020-11-07 08:21:36'),
(806, 'en', 'Show Language Switcher?', 'Show Language Switcher?', '2020-11-07 08:21:36', '2020-11-07 08:21:36'),
(807, 'en', 'Show Currency Switcher?', 'Show Currency Switcher?', '2020-11-07 08:21:36', '2020-11-07 08:21:36'),
(808, 'en', 'Enable stikcy header?', 'Enable stikcy header?', '2020-11-07 08:21:36', '2020-11-07 08:21:36'),
(809, 'en', 'Website Footer', 'Website Footer', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(810, 'en', 'Footer Widget', 'Footer Widget', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(811, 'en', 'About Widget', 'About Widget', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(812, 'en', 'Footer Logo', 'Footer Logo', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(813, 'en', 'About description', 'About description', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(814, 'en', 'Contact Info Widget', 'Contact Info Widget', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(815, 'en', 'Footer contact address', 'Footer contact address', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(816, 'en', 'Footer contact phone', 'Footer contact phone', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(817, 'en', 'Footer contact email', 'Footer contact email', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(818, 'en', 'Link Widget One', 'Link Widget One', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(819, 'en', 'Links', 'Links', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(820, 'en', 'Footer Bottom', 'Footer Bottom', '2020-11-07 08:21:56', '2020-11-07 08:21:56'),
(821, 'en', 'Copyright Widget ', 'Copyright Widget ', '2020-11-07 08:21:57', '2020-11-07 08:21:57'),
(822, 'en', 'Copyright Text', 'Copyright Text', '2020-11-07 08:21:57', '2020-11-07 08:21:57'),
(823, 'en', 'Social Link Widget ', 'Social Link Widget ', '2020-11-07 08:21:57', '2020-11-07 08:21:57'),
(824, 'en', 'Show Social Links?', 'Show Social Links?', '2020-11-07 08:21:57', '2020-11-07 08:21:57'),
(825, 'en', 'Social Links', 'Social Links', '2020-11-07 08:21:57', '2020-11-07 08:21:57'),
(826, 'en', 'Payment Methods Widget ', 'Payment Methods Widget ', '2020-11-07 08:21:57', '2020-11-07 08:21:57'),
(827, 'en', 'RTL status updated successfully', 'RTL status updated successfully', '2020-11-07 08:36:11', '2020-11-07 08:36:11'),
(828, 'en', 'Language changed to ', 'Language changed to ', '2020-11-07 08:36:27', '2020-11-07 08:36:27'),
(829, 'en', 'Inhouse Product sale report', 'Inhouse Product sale report', '2020-11-07 09:30:25', '2020-11-07 09:30:25'),
(830, 'en', 'Sort by Category', 'Sort by Category', '2020-11-07 09:30:25', '2020-11-07 09:30:25'),
(831, 'en', 'Product wise stock report', 'Product wise stock report', '2020-11-07 09:31:02', '2020-11-07 09:31:02'),
(832, 'en', 'Currency changed to ', 'Currency changed to ', '2020-11-07 12:36:28', '2020-11-07 12:36:28'),
(833, 'en', 'Avatar', 'Avatar', '2020-11-08 09:32:35', '2020-11-08 09:32:35'),
(834, 'en', 'Copy', 'Copy', '2020-11-08 10:03:42', '2020-11-08 10:03:42'),
(835, 'en', 'Variant', 'Variant', '2020-11-08 10:43:02', '2020-11-08 10:43:02'),
(836, 'en', 'Variant Price', 'Variant Price', '2020-11-08 10:43:03', '2020-11-08 10:43:03'),
(837, 'en', 'SKU', 'SKU', '2020-11-08 10:43:03', '2020-11-08 10:43:03'),
(838, 'en', 'Key', 'Key', '2020-11-08 12:35:09', '2020-11-08 12:35:09'),
(839, 'en', 'Value', 'Value', '2020-11-08 12:35:09', '2020-11-08 12:35:09'),
(840, 'en', 'Copy Translations', 'Copy Translations', '2020-11-08 12:35:10', '2020-11-08 12:35:10'),
(841, 'en', 'All Pick-up Points', 'All Pick-up Points', '2020-11-08 12:35:43', '2020-11-08 12:35:43'),
(842, 'en', 'Add New Pick-up Point', 'Add New Pick-up Point', '2020-11-08 12:35:43', '2020-11-08 12:35:43'),
(843, 'en', 'Manager', 'Manager', '2020-11-08 12:35:43', '2020-11-08 12:35:43'),
(844, 'en', 'Location', 'Location', '2020-11-08 12:35:43', '2020-11-08 12:35:43'),
(845, 'en', 'Pickup Station Contact', 'Pickup Station Contact', '2020-11-08 12:35:43', '2020-11-08 12:35:43'),
(846, 'en', 'Open', 'Open', '2020-11-08 12:35:43', '2020-11-08 12:35:43'),
(847, 'en', 'POS Activation for Seller', 'POS Activation for Seller', '2020-11-08 12:35:55', '2020-11-08 12:35:55'),
(848, 'en', 'Order Completed Successfully.', 'Order Completed Successfully.', '2020-11-08 12:36:02', '2020-11-08 12:36:02'),
(849, 'en', 'Text Input', 'Text Input', '2020-11-08 12:38:40', '2020-11-08 12:38:40'),
(850, 'en', 'Select', 'Select', '2020-11-08 12:38:40', '2020-11-08 12:38:40'),
(851, 'en', 'Multiple Select', 'Multiple Select', '2020-11-08 12:38:40', '2020-11-08 12:38:40'),
(852, 'en', 'Radio', 'Radio', '2020-11-08 12:38:40', '2020-11-08 12:38:40'),
(853, 'en', 'File', 'File', '2020-11-08 12:38:40', '2020-11-08 12:38:40'),
(854, 'en', 'Email Address', 'Email Address', '2020-11-08 12:39:32', '2020-11-08 12:39:32'),
(855, 'en', 'Verification Info', 'Verification Info', '2020-11-08 12:39:32', '2020-11-08 12:39:32'),
(856, 'en', 'Approval', 'Approval', '2020-11-08 12:39:32', '2020-11-08 12:39:32'),
(857, 'en', 'Due Amount', 'Due Amount', '2020-11-08 12:39:32', '2020-11-08 12:39:32'),
(858, 'en', 'Show', 'Show', '2020-11-08 12:39:32', '2020-11-08 12:39:32'),
(859, 'en', 'Pay Now', 'Pay Now', '2020-11-08 12:39:32', '2020-11-08 12:39:32'),
(860, 'en', 'Affiliate User Verification', 'Affiliate User Verification', '2020-11-08 12:40:01', '2020-11-08 12:40:01'),
(861, 'en', 'Reject', 'Reject', '2020-11-08 12:40:01', '2020-11-08 12:40:01'),
(862, 'en', 'Accept', 'Accept', '2020-11-08 12:40:01', '2020-11-08 12:40:01'),
(863, 'en', 'Beauty, Health & Hair', 'Beauty, Health & Hair', '2020-11-08 12:54:17', '2020-11-08 12:54:17'),
(864, 'en', 'Comparison', 'Comparison', '2020-11-08 12:54:33', '2020-11-08 12:54:33'),
(865, 'en', 'Reset Compare List', 'Reset Compare List', '2020-11-08 12:54:33', '2020-11-08 12:54:33'),
(866, 'en', 'Your comparison list is empty', 'Your comparison list is empty', '2020-11-08 12:54:33', '2020-11-08 12:54:33'),
(867, 'en', 'Convert Point To Wallet', 'Convert Point To Wallet', '2020-11-08 13:04:42', '2020-11-08 13:04:42'),
(868, 'en', 'Note: You need to activate wallet option first before using club point addon.', 'Note: You need to activate wallet option first before using club point addon.', '2020-11-08 13:04:43', '2020-11-08 13:04:43'),
(869, 'en', 'Create an account.', 'Create an account.', '2020-11-09 06:17:11', '2020-11-09 06:17:11'),
(870, 'en', 'Use Email Instead', 'Use Email Instead', '2020-11-09 06:17:11', '2020-11-09 06:17:11'),
(871, 'en', 'By signing up you agree to our terms and conditions.', 'By signing up you agree to our terms and conditions.', '2020-11-09 06:17:11', '2020-11-09 06:17:11'),
(872, 'en', 'Create Account', 'Create Account', '2020-11-09 06:17:11', '2020-11-09 06:17:11'),
(873, 'en', 'Or Join With', 'Or Join With', '2020-11-09 06:17:11', '2020-11-09 06:17:11'),
(874, 'en', 'Already have an account?', 'Already have an account?', '2020-11-09 06:17:11', '2020-11-09 06:17:11'),
(875, 'en', 'Log In', 'Log In', '2020-11-09 06:17:11', '2020-11-09 06:17:11'),
(876, 'en', 'Computer & Accessories', 'Computer & Accessories', '2020-11-09 07:52:05', '2020-11-09 07:52:05'),
(878, 'en', 'Product(s)', 'Product(s)', '2020-11-09 07:52:23', '2020-11-09 07:52:23'),
(879, 'en', 'in your cart', 'in your cart', '2020-11-09 07:52:23', '2020-11-09 07:52:23'),
(880, 'en', 'in your wishlist', 'in your wishlist', '2020-11-09 07:52:23', '2020-11-09 07:52:23'),
(881, 'en', 'you ordered', 'you ordered', '2020-11-09 07:52:24', '2020-11-09 07:52:24'),
(882, 'en', 'Default Shipping Address', 'Default Shipping Address', '2020-11-09 07:52:24', '2020-11-09 07:52:24'),
(883, 'en', 'Sports & outdoor', 'Sports & outdoor', '2020-11-09 07:53:32', '2020-11-09 07:53:32'),
(884, 'en', 'Copied', 'Copied', '2020-11-09 07:54:19', '2020-11-09 07:54:19'),
(885, 'en', 'Copy the Promote Link', 'Copy the Promote Link', '2020-11-09 07:54:19', '2020-11-09 07:54:19'),
(886, 'en', 'Write a review', 'Write a review', '2020-11-09 07:54:20', '2020-11-09 07:54:20'),
(887, 'en', 'Your name', 'Your name', '2020-11-09 07:54:20', '2020-11-09 07:54:20'),
(888, 'en', 'Comment', 'Comment', '2020-11-09 07:54:20', '2020-11-09 07:54:20'),
(889, 'en', 'Your review', 'Your review', '2020-11-09 07:54:20', '2020-11-09 07:54:20'),
(890, 'en', 'Submit review', 'Submit review', '2020-11-09 07:54:20', '2020-11-09 07:54:20'),
(891, 'en', 'Claire Willis', 'Claire Willis', '2020-11-09 08:05:00', '2020-11-09 08:05:00'),
(892, 'en', 'Germaine Greene', 'Germaine Greene', '2020-11-09 08:05:00', '2020-11-09 08:05:00'),
(893, 'en', 'Product File', 'Product File', '2020-11-09 08:07:08', '2020-11-09 08:07:08'),
(894, 'en', 'Choose file', 'Choose file', '2020-11-09 08:07:08', '2020-11-09 08:07:08'),
(895, 'en', 'Type to add a tag', 'Type to add a tag', '2020-11-09 08:07:08', '2020-11-09 08:07:08'),
(896, 'en', 'Images', 'Images', '2020-11-09 08:07:08', '2020-11-09 08:07:08'),
(897, 'en', 'Main Images', 'Main Images', '2020-11-09 08:07:08', '2020-11-09 08:07:08'),
(898, 'en', 'Meta Tags', 'Meta Tags', '2020-11-09 08:07:08', '2020-11-09 08:07:08'),
(899, 'en', 'Digital Product has been inserted successfully', 'Digital Product has been inserted successfully', '2020-11-09 08:14:25', '2020-11-09 08:14:25'),
(900, 'en', 'Edit Digital Product', 'Edit Digital Product', '2020-11-09 08:14:34', '2020-11-09 08:14:34'),
(901, 'en', 'Select an option', 'Select an option', '2020-11-09 08:14:34', '2020-11-09 08:14:34'),
(902, 'en', 'tax', 'tax', '2020-11-09 08:14:35', '2020-11-09 08:14:35'),
(903, 'en', 'Any question about this product?', 'Any question about this product?', '2020-11-09 08:15:11', '2020-11-09 08:15:11'),
(904, 'en', 'Sign in', 'Sign in', '2020-11-09 08:15:11', '2020-11-09 08:15:11'),
(905, 'en', 'Login with Google', 'Login with Google', '2020-11-09 08:15:11', '2020-11-09 08:15:11'),
(906, 'en', 'Login with Facebook', 'Login with Facebook', '2020-11-09 08:15:11', '2020-11-09 08:15:11'),
(907, 'en', 'Login with Twitter', 'Login with Twitter', '2020-11-09 08:15:11', '2020-11-09 08:15:11'),
(908, 'en', 'Click to show phone number', 'Click to show phone number', '2020-11-09 08:15:51', '2020-11-09 08:15:51'),
(909, 'en', 'Other Ads of', 'Other Ads of', '2020-11-09 08:15:52', '2020-11-09 08:15:52'),
(910, 'en', 'Store Home', 'Store Home', '2020-11-09 08:54:23', '2020-11-09 08:54:23'),
(911, 'en', 'Top Selling', 'Top Selling', '2020-11-09 08:54:23', '2020-11-09 08:54:23'),
(912, 'en', 'Shop Settings', 'Shop Settings', '2020-11-09 08:55:38', '2020-11-09 08:55:38'),
(913, 'en', 'Visit Shop', 'Visit Shop', '2020-11-09 08:55:38', '2020-11-09 08:55:38'),
(914, 'en', 'Pickup Points', 'Pickup Points', '2020-11-09 08:55:38', '2020-11-09 08:55:38'),
(915, 'en', 'Select Pickup Point', 'Select Pickup Point', '2020-11-09 08:55:38', '2020-11-09 08:55:38'),
(916, 'en', 'Slider Settings', 'Slider Settings', '2020-11-09 08:55:39', '2020-11-09 08:55:39'),
(917, 'en', 'Social Media Link', 'Social Media Link', '2020-11-09 08:55:39', '2020-11-09 08:55:39'),
(918, 'en', 'Facebook', 'Facebook', '2020-11-09 08:55:39', '2020-11-09 08:55:39'),
(919, 'en', 'Twitter', 'Twitter', '2020-11-09 08:55:39', '2020-11-09 08:55:39'),
(920, 'en', 'Google', 'Google', '2020-11-09 08:55:39', '2020-11-09 08:55:39'),
(921, 'en', 'New Arrival Products', 'New Arrival Products', '2020-11-09 08:56:26', '2020-11-09 08:56:26'),
(922, 'en', 'Check Your Order Status', 'Check Your Order Status', '2020-11-09 09:23:32', '2020-11-09 09:23:32'),
(923, 'en', 'Shipping method', 'Shipping method', '2020-11-09 09:27:40', '2020-11-09 09:27:40'),
(924, 'en', 'Shipped By', 'Shipped By', '2020-11-09 09:27:41', '2020-11-09 09:27:41'),
(925, 'en', 'Image', 'Image', '2020-11-09 09:29:37', '2020-11-09 09:29:37'),
(926, 'en', 'Sub Sub Category', 'Sub Sub Category', '2020-11-09 09:29:37', '2020-11-09 09:29:37'),
(927, 'en', 'Inhouse Products', 'Inhouse Products', '2020-11-09 10:22:32', '2020-11-09 10:22:32'),
(928, 'en', 'Forgot Password?', 'Forgot Password?', '2020-11-09 10:33:21', '2020-11-09 10:33:21'),
(929, 'en', 'Enter your email address to recover your password.', 'Enter your email address to recover your password.', '2020-11-09 10:33:21', '2020-11-09 10:33:21'),
(930, 'en', 'Email or Phone', 'Email or Phone', '2020-11-09 10:33:21', '2020-11-09 10:33:21'),
(931, 'en', 'Send Password Reset Link', 'Send Password Reset Link', '2020-11-09 10:33:21', '2020-11-09 10:33:21'),
(932, 'en', 'Back to Login', 'Back to Login', '2020-11-09 10:33:21', '2020-11-09 10:33:21'),
(933, 'en', 'index', 'index', '2020-11-09 10:35:29', '2020-11-09 10:35:29'),
(934, 'en', 'Download Your Product', 'Download Your Product', '2020-11-09 10:35:30', '2020-11-09 10:35:30'),
(935, 'en', 'Option', 'Option', '2020-11-09 10:35:30', '2020-11-09 10:35:30'),
(936, 'en', 'Applied Refund Request', 'Applied Refund Request', '2020-11-09 10:35:39', '2020-11-09 10:35:39'),
(937, 'en', 'Item has been renoved from wishlist', 'Item has been renoved from wishlist', '2020-11-09 10:36:04', '2020-11-09 10:36:04'),
(938, 'en', 'Bulk Products Upload', 'Bulk Products Upload', '2020-11-09 10:39:24', '2020-11-09 10:39:24'),
(939, 'en', 'Upload CSV', 'Upload CSV', '2020-11-09 10:39:25', '2020-11-09 10:39:25'),
(940, 'en', 'Create a Ticket', 'Create a Ticket', '2020-11-09 10:40:25', '2020-11-09 10:40:25'),
(941, 'en', 'Tickets', 'Tickets', '2020-11-09 10:40:25', '2020-11-09 10:40:25'),
(942, 'en', 'Ticket ID', 'Ticket ID', '2020-11-09 10:40:25', '2020-11-09 10:40:25'),
(943, 'en', 'Sending Date', 'Sending Date', '2020-11-09 10:40:25', '2020-11-09 10:40:25'),
(944, 'en', 'Subject', 'Subject', '2020-11-09 10:40:25', '2020-11-09 10:40:25'),
(945, 'en', 'View Details', 'View Details', '2020-11-09 10:40:25', '2020-11-09 10:40:25'),
(946, 'en', 'Provide a detailed description', 'Provide a detailed description', '2020-11-09 10:40:26', '2020-11-09 10:40:26'),
(947, 'en', 'Type your reply', 'Type your reply', '2020-11-09 10:40:26', '2020-11-09 10:40:26'),
(948, 'en', 'Send Ticket', 'Send Ticket', '2020-11-09 10:40:26', '2020-11-09 10:40:26'),
(949, 'en', 'Load More', 'Load More', '2020-11-09 10:40:57', '2020-11-09 10:40:57'),
(950, 'en', 'Jewelry & Watches', 'Jewelry & Watches', '2020-11-09 10:47:38', '2020-11-09 10:47:38'),
(951, 'en', 'Filters', 'Filters', '2020-11-09 10:53:54', '2020-11-09 10:53:54'),
(952, 'en', 'Contact address', 'Contact address', '2020-11-09 10:58:46', '2020-11-09 10:58:46'),
(953, 'en', 'Contact phone', 'Contact phone', '2020-11-09 10:58:47', '2020-11-09 10:58:47'),
(954, 'en', 'Contact email', 'Contact email', '2020-11-09 10:58:47', '2020-11-09 10:58:47'),
(955, 'en', 'Filter by', 'Filter by', '2020-11-09 11:00:03', '2020-11-09 11:00:03'),
(956, 'en', 'Condition', 'Condition', '2020-11-09 11:56:13', '2020-11-09 11:56:13'),
(957, 'en', 'All Type', 'All Type', '2020-11-09 11:56:13', '2020-11-09 11:56:13'),
(960, 'en', 'Pay with wallet', 'Pay with wallet', '2020-11-09 12:56:34', '2020-11-09 12:56:34'),
(961, 'en', 'Select variation', 'Select variation', '2020-11-10 07:54:29', '2020-11-10 07:54:29'),
(962, 'en', 'No Product Added', 'No Product Added', '2020-11-10 08:07:53', '2020-11-10 08:07:53'),
(963, 'en', 'Status has been updated successfully', 'Status has been updated successfully', '2020-11-10 08:41:23', '2020-11-10 08:41:23'),
(964, 'en', 'All Seller Packages', 'All Seller Packages', '2020-11-10 09:14:10', '2020-11-10 09:14:10'),
(965, 'en', 'Add New Package', 'Add New Package', '2020-11-10 09:14:10', '2020-11-10 09:14:10'),
(966, 'en', 'Package Logo', 'Package Logo', '2020-11-10 09:14:10', '2020-11-10 09:14:10'),
(967, 'en', 'days', 'days', '2020-11-10 09:14:10', '2020-11-10 09:14:10'),
(968, 'en', 'Create New Seller Package', 'Create New Seller Package', '2020-11-10 09:14:31', '2020-11-10 09:14:31'),
(969, 'en', 'Package Name', 'Package Name', '2020-11-10 09:14:31', '2020-11-10 09:14:31'),
(970, 'en', 'Duration', 'Duration', '2020-11-10 09:14:31', '2020-11-10 09:14:31'),
(971, 'en', 'Validity in number of days', 'Validity in number of days', '2020-11-10 09:14:31', '2020-11-10 09:14:31'),
(972, 'en', 'Update Package Information', 'Update Package Information', '2020-11-10 09:14:59', '2020-11-10 09:14:59'),
(973, 'en', 'Package has been inserted successfully', 'Package has been inserted successfully', '2020-11-10 09:15:14', '2020-11-10 09:15:14'),
(974, 'en', 'Refund Request', 'Refund Request', '2020-11-10 09:17:25', '2020-11-10 09:17:25'),
(975, 'en', 'Reason', 'Reason', '2020-11-10 09:17:25', '2020-11-10 09:17:25'),
(976, 'en', 'Label', 'Label', '2020-11-10 09:20:13', '2020-11-10 09:20:13'),
(977, 'en', 'Select Label', 'Select Label', '2020-11-10 09:20:13', '2020-11-10 09:20:13'),
(978, 'en', 'Multiple Select Label', 'Multiple Select Label', '2020-11-10 09:20:13', '2020-11-10 09:20:13'),
(979, 'en', 'Radio Label', 'Radio Label', '2020-11-10 09:20:13', '2020-11-10 09:20:13'),
(980, 'en', 'Pickup Point Orders', 'Pickup Point Orders', '2020-11-10 09:25:40', '2020-11-10 09:25:40'),
(981, 'en', 'View', 'View', '2020-11-10 09:25:40', '2020-11-10 09:25:40'),
(982, 'en', 'Order #', 'Order #', '2020-11-10 09:25:48', '2020-11-10 09:25:48'),
(983, 'en', 'Order Status', 'Order Status', '2020-11-10 09:25:48', '2020-11-10 09:25:48'),
(984, 'en', 'Total amount', 'Total amount', '2020-11-10 09:25:48', '2020-11-10 09:25:48'),
(986, 'en', 'TOTAL', 'TOTAL', '2020-11-10 09:25:49', '2020-11-10 09:25:49'),
(987, 'en', 'Delivery status has been updated', 'Delivery status has been updated', '2020-11-10 09:25:49', '2020-11-10 09:25:49'),
(988, 'en', 'Payment status has been updated', 'Payment status has been updated', '2020-11-10 09:25:49', '2020-11-10 09:25:49'),
(989, 'en', 'INVOICE', 'INVOICE', '2020-11-10 09:25:58', '2020-11-10 09:25:58'),
(990, 'en', 'Set Refund Time', 'Set Refund Time', '2020-11-10 09:34:04', '2020-11-10 09:34:04'),
(991, 'en', 'Set Time for sending Refund Request', 'Set Time for sending Refund Request', '2020-11-10 09:34:04', '2020-11-10 09:34:04'),
(992, 'en', 'Set Refund Sticker', 'Set Refund Sticker', '2020-11-10 09:34:05', '2020-11-10 09:34:05'),
(993, 'en', 'Sticker', 'Sticker', '2020-11-10 09:34:05', '2020-11-10 09:34:05'),
(994, 'en', 'Refund Request All', 'Refund Request All', '2020-11-10 09:34:12', '2020-11-10 09:34:12'),
(995, 'en', 'Order Id', 'Order Id', '2020-11-10 09:34:12', '2020-11-10 09:34:12'),
(996, 'en', 'Seller Approval', 'Seller Approval', '2020-11-10 09:34:12', '2020-11-10 09:34:12'),
(997, 'en', 'Admin Approval', 'Admin Approval', '2020-11-10 09:34:12', '2020-11-10 09:34:12'),
(998, 'en', 'Refund Status', 'Refund Status', '2020-11-10 09:34:12', '2020-11-10 09:34:12'),
(1000, 'en', 'No Refund', 'No Refund', '2020-11-10 09:35:27', '2020-11-10 09:35:27'),
(1001, 'en', 'Status updated successfully', 'Status updated successfully', '2020-11-10 09:54:20', '2020-11-10 09:54:20'),
(1002, 'en', 'User Search Report', 'User Search Report', '2020-11-11 06:43:24', '2020-11-11 06:43:24'),
(1003, 'en', 'Search By', 'Search By', '2020-11-11 06:43:24', '2020-11-11 06:43:24'),
(1004, 'en', 'Number searches', 'Number searches', '2020-11-11 06:43:24', '2020-11-11 06:43:24'),
(1005, 'en', 'Sender', 'Sender', '2020-11-11 06:51:49', '2020-11-11 06:51:49'),
(1006, 'en', 'Receiver', 'Receiver', '2020-11-11 06:51:49', '2020-11-11 06:51:49'),
(1007, 'en', 'Verification form updated successfully', 'Verification form updated successfully', '2020-11-11 06:53:29', '2020-11-11 06:53:29'),
(1008, 'en', 'Invalid email or password', 'Invalid email or password', '2020-11-11 07:07:49', '2020-11-11 07:07:49'),
(1009, 'en', 'All Coupons', 'All Coupons', '2020-11-11 07:14:04', '2020-11-11 07:14:04'),
(1010, 'en', 'Add New Coupon', 'Add New Coupon', '2020-11-11 07:14:04', '2020-11-11 07:14:04'),
(1011, 'en', 'Coupon Information', 'Coupon Information', '2020-11-11 07:14:04', '2020-11-11 07:14:04'),
(1012, 'en', 'Start Date', 'Start Date', '2020-11-11 07:14:04', '2020-11-11 07:14:04'),
(1013, 'en', 'End Date', 'End Date', '2020-11-11 07:14:05', '2020-11-11 07:14:05'),
(1014, 'en', 'Product Base', 'Product Base', '2020-11-11 07:14:05', '2020-11-11 07:14:05'),
(1015, 'en', 'Send Newsletter', 'Send Newsletter', '2020-11-11 07:14:10', '2020-11-11 07:14:10'),
(1016, 'en', 'Mobile Users', 'Mobile Users', '2020-11-11 07:14:10', '2020-11-11 07:14:10'),
(1017, 'en', 'SMS subject', 'SMS subject', '2020-11-11 07:14:10', '2020-11-11 07:14:10'),
(1018, 'en', 'SMS content', 'SMS content', '2020-11-11 07:14:10', '2020-11-11 07:14:10'),
(1019, 'en', 'All Flash Delas', 'All Flash Delas', '2020-11-11 07:16:06', '2020-11-11 07:16:06'),
(1020, 'en', 'Create New Flash Dela', 'Create New Flash Dela', '2020-11-11 07:16:06', '2020-11-11 07:16:06'),
(1022, 'en', 'Page Link', 'Page Link', '2020-11-11 07:16:06', '2020-11-11 07:16:06'),
(1023, 'en', 'Flash Deal Information', 'Flash Deal Information', '2020-11-11 07:16:14', '2020-11-11 07:16:14'),
(1024, 'en', 'Background Color', 'Background Color', '2020-11-11 07:16:14', '2020-11-11 07:16:14'),
(1025, 'en', '#0000ff', '#0000ff', '2020-11-11 07:16:14', '2020-11-11 07:16:14'),
(1026, 'en', 'Text Color', 'Text Color', '2020-11-11 07:16:14', '2020-11-11 07:16:14'),
(1027, 'en', 'White', 'White', '2020-11-11 07:16:14', '2020-11-11 07:16:14'),
(1028, 'en', 'Dark', 'Dark', '2020-11-11 07:16:15', '2020-11-11 07:16:15'),
(1029, 'en', 'Choose Products', 'Choose Products', '2020-11-11 07:16:15', '2020-11-11 07:16:15'),
(1030, 'en', 'Discounts', 'Discounts', '2020-11-11 07:16:20', '2020-11-11 07:16:20'),
(1031, 'en', 'Discount Type', 'Discount Type', '2020-11-11 07:16:20', '2020-11-11 07:16:20'),
(1032, 'en', 'Twillo Credential', 'Twillo Credential', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1033, 'en', 'TWILIO SID', 'TWILIO SID', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1034, 'en', 'TWILIO AUTH TOKEN', 'TWILIO AUTH TOKEN', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1035, 'en', 'TWILIO VERIFY SID', 'TWILIO VERIFY SID', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1036, 'en', 'VALID TWILLO NUMBER', 'VALID TWILLO NUMBER', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1037, 'en', 'Nexmo Credential', 'Nexmo Credential', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1038, 'en', 'NEXMO KEY', 'NEXMO KEY', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1039, 'en', 'NEXMO SECRET', 'NEXMO SECRET', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1040, 'en', 'SSL Wireless Credential', 'SSL Wireless Credential', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1041, 'en', 'SSL SMS API TOKEN', 'SSL SMS API TOKEN', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1042, 'en', 'SSL SMS SID', 'SSL SMS SID', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1043, 'en', 'SSL SMS URL', 'SSL SMS URL', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1044, 'en', 'Fast2SMS Credential', 'Fast2SMS Credential', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1045, 'en', 'AUTH KEY', 'AUTH KEY', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1046, 'en', 'ROUTE', 'ROUTE', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1047, 'en', 'Promotional Use', 'Promotional Use', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1048, 'en', 'Transactional Use', 'Transactional Use', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1050, 'en', 'SENDER ID', 'SENDER ID', '2020-11-11 07:17:35', '2020-11-11 07:17:35'),
(1051, 'en', 'Nexmo OTP', 'Nexmo OTP', '2020-11-11 07:17:42', '2020-11-11 07:17:42'),
(1052, 'en', 'Twillo OTP', 'Twillo OTP', '2020-11-11 07:17:43', '2020-11-11 07:17:43'),
(1053, 'en', 'SSL Wireless OTP', 'SSL Wireless OTP', '2020-11-11 07:17:43', '2020-11-11 07:17:43'),
(1054, 'en', 'Fast2SMS OTP', 'Fast2SMS OTP', '2020-11-11 07:17:43', '2020-11-11 07:17:43'),
(1055, 'en', 'Order Placement', 'Order Placement', '2020-11-11 07:17:43', '2020-11-11 07:17:43'),
(1056, 'en', 'Delivery Status Changing Time', 'Delivery Status Changing Time', '2020-11-11 07:17:43', '2020-11-11 07:17:43'),
(1057, 'en', 'Paid Status Changing Time', 'Paid Status Changing Time', '2020-11-11 07:17:43', '2020-11-11 07:17:43'),
(1058, 'en', 'Send Bulk SMS', 'Send Bulk SMS', '2020-11-11 07:19:14', '2020-11-11 07:19:14'),
(1059, 'en', 'All Subscribers', 'All Subscribers', '2020-11-11 07:21:51', '2020-11-11 07:21:51'),
(1060, 'en', 'Coupon Information Adding', 'Coupon Information Adding', '2020-11-11 07:22:25', '2020-11-11 07:22:25'),
(1061, 'en', 'Coupon Type', 'Coupon Type', '2020-11-11 07:22:25', '2020-11-11 07:22:25'),
(1062, 'en', 'For Products', 'For Products', '2020-11-11 07:22:25', '2020-11-11 07:22:25'),
(1063, 'en', 'For Total Orders', 'For Total Orders', '2020-11-11 07:22:25', '2020-11-11 07:22:25'),
(1064, 'en', 'Add Your Product Base Coupon', 'Add Your Product Base Coupon', '2020-11-11 07:22:42', '2020-11-11 07:22:42'),
(1065, 'en', 'Coupon code', 'Coupon code', '2020-11-11 07:22:42', '2020-11-11 07:22:42'),
(1066, 'en', 'Sub Category', 'Sub Category', '2020-11-11 07:22:42', '2020-11-11 07:22:42'),
(1067, 'en', 'Add More', 'Add More', '2020-11-11 07:22:43', '2020-11-11 07:22:43'),
(1068, 'en', 'Add Your Cart Base Coupon', 'Add Your Cart Base Coupon', '2020-11-11 07:29:40', '2020-11-11 07:29:40'),
(1069, 'en', 'Minimum Shopping', 'Minimum Shopping', '2020-11-11 07:29:40', '2020-11-11 07:29:40'),
(1070, 'en', 'Maximum Discount Amount', 'Maximum Discount Amount', '2020-11-11 07:29:41', '2020-11-11 07:29:41'),
(1071, 'en', 'Coupon Information Update', 'Coupon Information Update', '2020-11-11 08:18:34', '2020-11-11 08:18:34'),
(1073, 'en', 'Please Configure SMTP Setting to work all email sending funtionality', 'Please Configure SMTP Setting to work all email sending funtionality', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1074, 'en', 'Configure Now', 'Configure Now', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1076, 'en', 'Total published products', 'Total published products', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1077, 'en', 'Total sellers products', 'Total sellers products', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1078, 'en', 'Total admin products', 'Total admin products', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1079, 'en', 'Manage Products', 'Manage Products', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1080, 'en', 'Total product category', 'Total product category', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1081, 'en', 'Create Category', 'Create Category', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1082, 'en', 'Total product sub sub category', 'Total product sub sub category', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1083, 'en', 'Create Sub Sub Category', 'Create Sub Sub Category', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1084, 'en', 'Total product sub category', 'Total product sub category', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1085, 'en', 'Create Sub Category', 'Create Sub Category', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1086, 'en', 'Total product brand', 'Total product brand', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1087, 'en', 'Create Brand', 'Create Brand', '2020-11-11 13:10:18', '2020-11-11 13:10:18'),
(1089, 'en', 'Total sellers', 'Total sellers', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1091, 'en', 'Total approved sellers', 'Total approved sellers', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1093, 'en', 'Total pending sellers', 'Total pending sellers', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1094, 'en', 'Manage Sellers', 'Manage Sellers', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1095, 'en', 'Category wise product sale', 'Category wise product sale', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1097, 'en', 'Sale', 'Sale', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1098, 'en', 'Category wise product stock', 'Category wise product stock', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1099, 'en', 'Category Name', 'Category Name', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1100, 'en', 'Stock', 'Stock', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1101, 'en', 'Frontend', 'Frontend', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1103, 'en', 'Home page', 'Home page', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1104, 'en', 'setting', 'setting', '2020-11-11 13:10:19', '2020-11-11 13:10:19'),
(1106, 'en', 'Policy page', 'Policy page', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1107, 'en', 'setting', 'setting', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1109, 'en', 'General', 'General', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1110, 'en', 'setting', 'setting', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1111, 'en', 'Click Here', 'Click Here', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1112, 'en', 'Useful link', 'Useful link', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1113, 'en', 'setting', 'setting', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1114, 'en', 'Click Here', 'Click Here', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1115, 'en', 'Activation', 'Activation', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1116, 'en', 'setting', 'setting', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1117, 'en', 'Click Here', 'Click Here', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1118, 'en', 'SMTP', 'SMTP', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1119, 'en', 'setting', 'setting', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1120, 'en', 'Click Here', 'Click Here', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1121, 'en', 'Payment method', 'Payment method', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1122, 'en', 'setting', 'setting', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1123, 'en', 'Click Here', 'Click Here', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1124, 'en', 'Social media', 'Social media', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1125, 'en', 'setting', 'setting', '2020-11-11 13:10:20', '2020-11-11 13:10:20'),
(1126, 'en', 'Click Here', 'Click Here', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1127, 'en', 'Business', 'Business', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1128, 'en', 'setting', 'setting', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1130, 'en', 'setting', 'setting', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1131, 'en', 'Click Here', 'Click Here', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1132, 'en', 'Seller verification', 'Seller verification', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1133, 'en', 'form setting', 'form setting', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1134, 'en', 'Click Here', 'Click Here', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1135, 'en', 'Language', 'Language', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1136, 'en', 'setting', 'setting', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1137, 'en', 'Click Here', 'Click Here', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1139, 'en', 'setting', 'setting', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1140, 'en', 'Click Here', 'Click Here', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1141, 'en', 'Dashboard', 'Dashboard', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1142, 'en', 'POS System', 'POS System', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1143, 'en', 'POS Manager', 'POS Manager', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1144, 'en', 'POS Configuration', 'POS Configuration', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1145, 'en', 'Products', 'Products', '2020-11-11 13:10:21', '2020-11-11 13:10:21'),
(1146, 'en', 'Add New product', 'Add New product', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1147, 'en', 'All Products', 'All Products', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1148, 'en', 'In House Products', 'In House Products', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1149, 'en', 'Seller Products', 'Seller Products', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1150, 'en', 'Digital Products', 'Digital Products', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1151, 'en', 'Bulk Import', 'Bulk Import', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1152, 'en', 'Bulk Export', 'Bulk Export', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1153, 'en', 'Category', 'Category', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1154, 'en', 'Subcategory', 'Subcategory', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1155, 'en', 'Sub Subcategory', 'Sub Subcategory', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1156, 'en', 'Brand', 'Brand', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1157, 'en', 'Attribute', 'Attribute', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1158, 'en', 'Product Reviews', 'Product Reviews', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1159, 'en', 'Sales', 'Sales', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1160, 'en', 'All Orders', 'All Orders', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1161, 'en', 'Inhouse orders', 'Inhouse orders', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1162, 'en', 'Seller Orders', 'Seller Orders', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1163, 'en', 'Pick-up Point Order', 'Pick-up Point Order', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1164, 'en', 'Refunds', 'Refunds', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1165, 'en', 'Refund Requests', 'Refund Requests', '2020-11-11 13:10:22', '2020-11-11 13:10:22'),
(1166, 'en', 'Approved Refund', 'Approved Refund', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1167, 'en', 'Refund Configuration', 'Refund Configuration', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1168, 'en', 'Customers', 'Customers', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1169, 'en', 'Customer list', 'Customer list', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1170, 'en', 'Classified Products', 'Classified Products', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1171, 'en', 'Classified Packages', 'Classified Packages', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1172, 'en', 'Sellers', 'Sellers', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1173, 'en', 'All Seller', 'All Seller', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1174, 'en', 'Payouts', 'Payouts', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1175, 'en', 'Payout Requests', 'Payout Requests', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1176, 'en', 'Seller Commission', 'Seller Commission', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1177, 'en', 'Seller Packages', 'Seller Packages', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1178, 'en', 'Seller Verification Form', 'Seller Verification Form', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1179, 'en', 'Reports', 'Reports', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1180, 'en', 'In House Product Sale', 'In House Product Sale', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1181, 'en', 'Seller Products Sale', 'Seller Products Sale', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1182, 'en', 'Products Stock', 'Products Stock', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1183, 'en', 'Products wishlist', 'Products wishlist', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1184, 'en', 'User Searches', 'User Searches', '2020-11-11 13:10:23', '2020-11-11 13:10:23'),
(1185, 'en', 'Marketing', 'Marketing', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1186, 'en', 'Flash deals', 'Flash deals', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1187, 'en', 'Newsletters', 'Newsletters', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1188, 'en', 'Bulk SMS', 'Bulk SMS', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1189, 'en', 'Subscribers', 'Subscribers', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1190, 'en', 'Coupon', 'Coupon', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1191, 'en', 'Support', 'Support', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1192, 'en', 'Ticket', 'Ticket', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1193, 'en', 'Product Queries', 'Product Queries', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1194, 'en', 'Website Setup', 'Website Setup', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1195, 'en', 'Header', 'Header', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1196, 'en', 'Footer', 'Footer', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1197, 'en', 'Pages', 'Pages', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1198, 'en', 'Appearance', 'Appearance', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1199, 'en', 'Setup & Configurations', 'Setup & Configurations', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1200, 'en', 'General Settings', 'General Settings', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1201, 'en', 'Features activation', 'Features activation', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1202, 'en', 'Languages', 'Languages', '2020-11-11 13:10:24', '2020-11-11 13:10:24'),
(1203, 'en', 'Currency', 'Currency', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1204, 'en', 'Pickup point', 'Pickup point', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1205, 'en', 'SMTP Settings', 'SMTP Settings', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1206, 'en', 'Payment Methods', 'Payment Methods', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1207, 'en', 'File System Configuration', 'File System Configuration', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1208, 'en', 'Social media Logins', 'Social media Logins', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1209, 'en', 'Analytics Tools', 'Analytics Tools', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1210, 'en', 'Facebook Chat', 'Facebook Chat', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1211, 'en', 'Google reCAPTCHA', 'Google reCAPTCHA', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1212, 'en', 'Shipping Configuration', 'Shipping Configuration', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1213, 'en', 'Shipping Countries', 'Shipping Countries', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1214, 'en', 'Affiliate System', 'Affiliate System', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1215, 'en', 'Affiliate Registration Form', 'Affiliate Registration Form', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1216, 'en', 'Affiliate Configurations', 'Affiliate Configurations', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1217, 'en', 'Affiliate Users', 'Affiliate Users', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1218, 'en', 'Referral Users', 'Referral Users', '2020-11-11 13:10:25', '2020-11-11 13:10:25'),
(1219, 'en', 'Affiliate Withdraw Requests', 'Affiliate Withdraw Requests', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1220, 'en', 'Offline Payment System', 'Offline Payment System', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1221, 'en', 'Manual Payment Methods', 'Manual Payment Methods', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1222, 'en', 'Offline Wallet Recharge', 'Offline Wallet Recharge', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1223, 'en', 'Offline Customer Package Payments', 'Offline Customer Package Payments', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1224, 'en', 'Offline Seller Package Payments', 'Offline Seller Package Payments', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1225, 'en', 'Paytm Payment Gateway', 'Paytm Payment Gateway', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1226, 'en', 'Set Paytm Credentials', 'Set Paytm Credentials', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1227, 'en', 'Club Point System', 'Club Point System', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1228, 'en', 'Club Point Configurations', 'Club Point Configurations', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1229, 'en', 'Set Product Point', 'Set Product Point', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1230, 'en', 'User Points', 'User Points', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1231, 'en', 'OTP System', 'OTP System', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1232, 'en', 'OTP Configurations', 'OTP Configurations', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1233, 'en', 'Set OTP Credentials', 'Set OTP Credentials', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1234, 'en', 'Staffs', 'Staffs', '2020-11-11 13:10:26', '2020-11-11 13:10:26'),
(1235, 'en', 'All staffs', 'All staffs', '2020-11-11 13:10:27', '2020-11-11 13:10:27'),
(1236, 'en', 'Staff permissions', 'Staff permissions', '2020-11-11 13:10:27', '2020-11-11 13:10:27'),
(1237, 'en', 'Addon Manager', 'Addon Manager', '2020-11-11 13:10:27', '2020-11-11 13:10:27'),
(1238, 'en', 'Browse Website', 'Browse Website', '2020-11-11 13:10:27', '2020-11-11 13:10:27'),
(1239, 'en', 'POS', 'POS', '2020-11-11 13:10:27', '2020-11-11 13:10:27'),
(1240, 'en', 'Notifications', 'Notifications', '2020-11-11 13:10:27', '2020-11-11 13:10:27'),
(1241, 'en', 'new orders', 'new orders', '2020-11-11 13:10:27', '2020-11-11 13:10:27'),
(1242, 'en', 'user-image', 'user-image', '2020-11-11 13:10:27', '2020-11-11 13:10:27'),
(1243, 'en', 'Profile', 'Profile', '2020-11-11 13:10:27', '2020-11-11 13:10:27'),
(1244, 'en', 'Logout', 'Logout', '2020-11-11 13:10:27', '2020-11-11 13:10:27'),
(1247, 'en', 'Page Not Found!', 'Page Not Found!', '2020-11-11 13:10:28', '2020-11-11 13:10:28'),
(1249, 'en', 'The page you are looking for has not been found on our server.', 'The page you are looking for has not been found on our server.', '2020-11-11 13:10:28', '2020-11-11 13:10:28'),
(1253, 'en', 'Registration', 'Registration', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1255, 'en', 'I am shopping for...', 'I am shopping for...', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1257, 'en', 'Compare', 'Compare', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1259, 'en', 'Wishlist', 'Wishlist', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1261, 'en', 'Cart', 'Cart', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1263, 'en', 'Your Cart is empty', 'Your Cart is empty', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1265, 'en', 'Categories', 'Categories', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1267, 'en', 'See All', 'See All', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1269, 'en', 'Seller Policy', 'Seller Policy', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1271, 'en', 'Return Policy', 'Return Policy', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1273, 'en', 'Support Policy', 'Support Policy', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1275, 'en', 'Privacy Policy', 'Privacy Policy', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1277, 'en', 'Your Email Address', 'Your Email Address', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1279, 'en', 'Subscribe', 'Subscribe', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1281, 'en', 'Contact Info', 'Contact Info', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1283, 'en', 'Address', 'Address', '2020-11-11 13:10:29', '2020-11-11 13:10:29'),
(1285, 'en', 'Phone', 'Phone', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1287, 'en', 'Email', 'Email', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1288, 'en', 'Login', 'Login', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1289, 'en', 'My Account', 'My Account', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1291, 'en', 'Login', 'Login', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1293, 'en', 'Order History', 'Order History', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1295, 'en', 'My Wishlist', 'My Wishlist', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1297, 'en', 'Track Order', 'Track Order', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1299, 'en', 'Be an affiliate partner', 'Be an affiliate partner', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1301, 'en', 'Be a Seller', 'Be a Seller', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1303, 'en', 'Apply Now', 'Apply Now', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1305, 'en', 'Confirmation', 'Confirmation', '2020-11-11 13:10:30', '2020-11-11 13:10:30');
INSERT INTO `translations` (`id`, `lang`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(1307, 'en', 'Delete confirmation message', 'Delete confirmation message', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1309, 'en', 'Cancel', 'Cancel', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1312, 'en', 'Delete', 'Delete', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1313, 'en', 'Item has been added to compare list', 'Item has been added to compare list', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1314, 'en', 'Please login first', 'Please login first', '2020-11-11 13:10:30', '2020-11-11 13:10:30'),
(1315, 'en', 'Total Earnings From', 'Total Earnings From', '2020-11-12 08:01:11', '2020-11-12 08:01:11'),
(1316, 'en', 'Client Subscription', 'Client Subscription', '2020-11-12 08:01:12', '2020-11-12 08:01:12'),
(1317, 'en', 'Product category', 'Product category', '2020-11-12 08:03:46', '2020-11-12 08:03:46'),
(1318, 'en', 'Product sub sub category', 'Product sub sub category', '2020-11-12 08:03:46', '2020-11-12 08:03:46'),
(1319, 'en', 'Product sub category', 'Product sub category', '2020-11-12 08:03:46', '2020-11-12 08:03:46'),
(1320, 'en', 'Product brand', 'Product brand', '2020-11-12 08:03:46', '2020-11-12 08:03:46'),
(1321, 'en', 'Top Client Packages', 'Top Client Packages', '2020-11-12 08:05:21', '2020-11-12 08:05:21'),
(1322, 'en', 'Top Freelancer Packages', 'Top Freelancer Packages', '2020-11-12 08:05:21', '2020-11-12 08:05:21'),
(1323, 'en', 'Number of sale', 'Number of sale', '2020-11-12 09:13:09', '2020-11-12 09:13:09'),
(1324, 'en', 'Number of Stock', 'Number of Stock', '2020-11-12 09:16:02', '2020-11-12 09:16:02'),
(1325, 'en', 'Top 10 Products', 'Top 10 Products', '2020-11-12 10:02:29', '2020-11-12 10:02:29'),
(1326, 'en', 'Top 12 Products', 'Top 12 Products', '2020-11-12 10:02:39', '2020-11-12 10:02:39'),
(1327, 'en', 'Admin can not be a seller', 'Admin can not be a seller', '2020-11-12 11:30:19', '2020-11-12 11:30:19'),
(1328, 'en', 'Filter by Rating', 'Filter by Rating', '2020-11-15 08:01:15', '2020-11-15 08:01:15'),
(1329, 'en', 'Published reviews updated successfully', 'Published reviews updated successfully', '2020-11-15 08:01:15', '2020-11-15 08:01:15'),
(1330, 'en', 'Refund Sticker has been updated successfully', 'Refund Sticker has been updated successfully', '2020-11-15 08:17:12', '2020-11-15 08:17:12'),
(1331, 'en', 'Edit Product', 'Edit Product', '2020-11-15 10:31:54', '2020-11-15 10:31:54'),
(1332, 'en', 'Meta Images', 'Meta Images', '2020-11-15 10:32:12', '2020-11-15 10:32:12'),
(1333, 'en', 'Update Product', 'Update Product', '2020-11-15 10:32:12', '2020-11-15 10:32:12'),
(1334, 'en', 'Product has been deleted successfully', 'Product has been deleted successfully', '2020-11-15 10:32:57', '2020-11-15 10:32:57'),
(1335, 'en', 'Your Profile has been updated successfully!', 'Your Profile has been updated successfully!', '2020-11-15 11:10:42', '2020-11-15 11:10:42'),
(1336, 'en', 'Upload limit has been reached. Please upgrade your package.', 'Upload limit has been reached. Please upgrade your package.', '2020-11-15 11:13:45', '2020-11-15 11:13:45'),
(1337, 'en', 'Add Your Product', 'Add Your Product', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1338, 'en', 'Select a category', 'Select a category', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1339, 'en', 'Select a brand', 'Select a brand', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1340, 'en', 'Product Unit', 'Product Unit', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1341, 'en', 'Minimum Qty.', 'Minimum Qty.', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1342, 'en', 'Product Tag', 'Product Tag', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1343, 'en', 'Type & hit enter', 'Type & hit enter', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1344, 'en', 'Videos', 'Videos', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1345, 'en', 'Video From', 'Video From', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1346, 'en', 'Video URL', 'Video URL', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1347, 'en', 'Customer Choice', 'Customer Choice', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1348, 'en', 'PDF', 'PDF', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1349, 'en', 'Choose PDF', 'Choose PDF', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1350, 'en', 'Select Category', 'Select Category', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1351, 'en', 'Target Category', 'Target Category', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1352, 'en', 'subsubcategory', 'subsubcategory', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1353, 'en', 'Search Category', 'Search Category', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1354, 'en', 'Search SubCategory', 'Search SubCategory', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1355, 'en', 'Search SubSubCategory', 'Search SubSubCategory', '2020-11-15 11:17:56', '2020-11-15 11:17:56'),
(1356, 'en', 'Update your product', 'Update your product', '2020-11-15 11:39:14', '2020-11-15 11:39:14'),
(1357, 'en', 'Product has been updated successfully', 'Product has been updated successfully', '2020-11-15 11:51:36', '2020-11-15 11:51:36'),
(1358, 'en', 'Add Your Digital Product', 'Add Your Digital Product', '2020-11-15 12:24:21', '2020-11-15 12:24:21'),
(1359, 'en', 'Active eCommerce CMS Update Process', 'Active eCommerce CMS Update Process', '2020-11-16 07:53:31', '2020-11-16 07:53:31'),
(1361, 'en', 'Codecanyon purchase code', 'Codecanyon purchase code', '2020-11-16 07:53:31', '2020-11-16 07:53:31'),
(1362, 'en', 'Database Name', 'Database Name', '2020-11-16 07:53:31', '2020-11-16 07:53:31'),
(1363, 'en', 'Database Username', 'Database Username', '2020-11-16 07:53:31', '2020-11-16 07:53:31'),
(1364, 'en', 'Database Password', 'Database Password', '2020-11-16 07:53:31', '2020-11-16 07:53:31'),
(1365, 'en', 'Database Hostname', 'Database Hostname', '2020-11-16 07:53:31', '2020-11-16 07:53:31'),
(1366, 'en', 'Update Now', 'Update Now', '2020-11-16 07:53:31', '2020-11-16 07:53:31'),
(1368, 'en', 'Congratulations', 'Congratulations', '2020-11-16 07:55:14', '2020-11-16 07:55:14'),
(1369, 'en', 'You have successfully completed the updating process. Please Login to continue', 'You have successfully completed the updating process. Please Login to continue', '2020-11-16 07:55:14', '2020-11-16 07:55:14'),
(1370, 'en', 'Go to Home', 'Go to Home', '2020-11-16 07:55:14', '2020-11-16 07:55:14'),
(1371, 'en', 'Login to Admin panel', 'Login to Admin panel', '2020-11-16 07:55:14', '2020-11-16 07:55:14'),
(1372, 'en', 'S3 File System Credentials', 'S3 File System Credentials', '2020-11-16 12:59:57', '2020-11-16 12:59:57'),
(1373, 'en', 'AWS_ACCESS_KEY_ID', 'AWS_ACCESS_KEY_ID', '2020-11-16 12:59:57', '2020-11-16 12:59:57'),
(1374, 'en', 'AWS_SECRET_ACCESS_KEY', 'AWS_SECRET_ACCESS_KEY', '2020-11-16 12:59:57', '2020-11-16 12:59:57'),
(1375, 'en', 'AWS_DEFAULT_REGION', 'AWS_DEFAULT_REGION', '2020-11-16 12:59:57', '2020-11-16 12:59:57'),
(1376, 'en', 'AWS_BUCKET', 'AWS_BUCKET', '2020-11-16 12:59:57', '2020-11-16 12:59:57'),
(1377, 'en', 'AWS_URL', 'AWS_URL', '2020-11-16 12:59:57', '2020-11-16 12:59:57'),
(1378, 'en', 'S3 File System Activation', 'S3 File System Activation', '2020-11-16 12:59:57', '2020-11-16 12:59:57'),
(1379, 'en', 'Your phone number', 'Your phone number', '2020-11-17 05:50:10', '2020-11-17 05:50:10'),
(1380, 'en', 'Zip File', 'Zip File', '2020-11-17 06:58:45', '2020-11-17 06:58:45'),
(1381, 'en', 'Install', 'Install', '2020-11-17 06:58:45', '2020-11-17 06:58:45'),
(1382, 'en', 'This version is not capable of installing Addons, Please update.', 'This version is not capable of installing Addons, Please update.', '2020-11-17 06:59:11', '2020-11-17 06:59:11'),
(1383, 'bd', 'Page Not Found!', 'Page Not Found!', '2021-02-08 00:16:58', '2021-02-08 00:16:58'),
(1384, 'bd', 'The page you are looking for has not been found on our server.', 'The page you are looking for has not been found on our server.', '2021-02-08 00:16:58', '2021-02-08 00:16:58'),
(1385, 'bd', 'Something went wrong!', 'Something went wrong!', '2021-02-08 00:16:58', '2021-02-08 00:16:58'),
(1386, 'bd', 'Sorry for the inconvenience, but we\'re working on it.', 'Sorry for the inconvenience, but we\'re working on it.', '2021-02-08 00:16:58', '2021-02-08 00:16:58'),
(1387, 'bd', 'Error code', 'Error code', '2021-02-08 00:16:58', '2021-02-08 00:16:58'),
(1388, 'bd', 'Login', 'Login', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1389, 'bd', 'Registration', 'Registration', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1390, 'bd', 'I am shopping for...', 'I am shopping for...', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1391, 'bd', 'Compare', 'Compare', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1392, 'bd', 'Wishlist', 'Wishlist', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1393, 'bd', 'Cart', 'Cart', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1394, 'bd', 'Your Cart is empty', 'Your Cart is empty', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1395, 'bd', 'Categories', 'Categories', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1396, 'bd', 'See All', 'See All', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1397, 'bd', 'Terms & conditions', 'Terms & conditions', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1398, 'bd', 'Return Policy', 'Return Policy', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1399, 'bd', 'Support Policy', 'Support Policy', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1400, 'bd', 'Privacy Policy', 'Privacy Policy', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1401, 'bd', 'Your Email Address', 'Your Email Address', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1402, 'bd', 'Subscribe', 'Subscribe', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1403, 'bd', 'Contact Info', 'Contact Info', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1404, 'bd', 'Address', 'Address', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1405, 'bd', 'Phone', 'Phone', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1406, 'bd', 'Email', 'Email', '2021-02-08 00:17:26', '2021-02-08 00:17:26'),
(1407, 'bd', 'My Account', 'My Account', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1408, 'bd', 'Order History', 'Order History', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1409, 'bd', 'My Wishlist', 'My Wishlist', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1410, 'bd', 'Track Order', 'Track Order', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1411, 'bd', 'Be a Seller', 'Be a Seller', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1412, 'bd', 'Apply Now', 'Apply Now', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1413, 'bd', 'Confirmation', 'Confirmation', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1414, 'bd', 'Delete confirmation message', 'Delete confirmation message', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1415, 'bd', 'Cancel', 'Cancel', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1416, 'bd', 'Delete', 'Delete', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1417, 'bd', 'Item has been added to compare list', 'Item has been added to compare list', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1418, 'bd', 'Please login first', 'Please login first', '2021-02-08 00:17:27', '2021-02-08 00:17:27'),
(1419, 'bd', 'Welcome to', 'Welcome to', '2021-02-08 00:17:29', '2021-02-08 00:17:29'),
(1420, 'bd', 'Login to your account.', 'Login to your account.', '2021-02-08 00:17:29', '2021-02-08 00:17:29'),
(1421, 'bd', 'Password', 'Password', '2021-02-08 00:17:29', '2021-02-08 00:17:29'),
(1422, 'bd', 'Remember Me', 'Remember Me', '2021-02-08 00:17:29', '2021-02-08 00:17:29'),
(1423, 'bd', 'Top 10 Categories', 'Top 10 Categories', '2021-02-08 00:18:05', '2021-02-08 00:18:05'),
(1424, 'bd', 'View All Categories', 'View All Categories', '2021-02-08 00:18:05', '2021-02-08 00:18:05'),
(1425, 'bd', 'Top 10 Brands', 'Top 10 Brands', '2021-02-08 00:18:05', '2021-02-08 00:18:05'),
(1426, 'bd', 'View All Brands', 'View All Brands', '2021-02-08 00:18:05', '2021-02-08 00:18:05'),
(1427, 'bd', 'Featured Products', 'Featured Products', '2021-02-08 00:18:06', '2021-02-08 00:18:06'),
(1428, 'bd', 'Best Selling', 'Best Selling', '2021-02-08 00:18:06', '2021-02-08 00:18:06'),
(1429, 'bd', 'Top 20', 'Top 20', '2021-02-08 00:18:06', '2021-02-08 00:18:06'),
(1430, 'bd', 'Best Sellers', 'Best Sellers', '2021-02-08 00:18:06', '2021-02-08 00:18:06'),
(1431, 'bd', 'Visit Store', 'Visit Store', '2021-02-08 00:18:06', '2021-02-08 00:18:06'),
(1432, 'bd', 'Please Configure SMTP Setting to work all email sending functionality', 'Please Configure SMTP Setting to work all email sending functionality', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1433, 'bd', 'Configure Now', 'Configure Now', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1434, 'bd', 'Total', 'Total', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1435, 'bd', 'Customer', 'Customer', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1436, 'bd', 'Order', 'Order', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1437, 'bd', 'Product category', 'Product category', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1438, 'bd', 'Product brand', 'Product brand', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1439, 'bd', 'Products', 'Products', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1440, 'bd', 'Sellers', 'Sellers', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1441, 'bd', 'Category wise product sale', 'Category wise product sale', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1442, 'bd', 'Category wise product stock', 'Category wise product stock', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1443, 'bd', 'Top 12 Products', 'Top 12 Products', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1444, 'bd', 'Total published products', 'Total published products', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1445, 'bd', 'Total sellers products', 'Total sellers products', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1446, 'bd', 'Total admin products', 'Total admin products', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1447, 'bd', 'Total sellers', 'Total sellers', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1448, 'bd', 'Total approved sellers', 'Total approved sellers', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1449, 'bd', 'Total pending sellers', 'Total pending sellers', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1450, 'bd', 'Number of sale', 'Number of sale', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1451, 'bd', 'Number of Stock', 'Number of Stock', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1452, 'bd', 'Search in menu', 'Search in menu', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1453, 'bd', 'Dashboard', 'Dashboard', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1454, 'bd', 'Add New product', 'Add New product', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1455, 'bd', 'All Products', 'All Products', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1456, 'bd', 'In House Products', 'In House Products', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1457, 'bd', 'Seller Products', 'Seller Products', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1458, 'bd', 'Digital Products', 'Digital Products', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1459, 'bd', 'Bulk Import', 'Bulk Import', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1460, 'bd', 'Bulk Export', 'Bulk Export', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1461, 'bd', 'Category', 'Category', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1462, 'bd', 'Brand', 'Brand', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1463, 'bd', 'Attribute', 'Attribute', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1464, 'bd', 'Product Reviews', 'Product Reviews', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1465, 'bd', 'Sales', 'Sales', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1466, 'bd', 'All Orders', 'All Orders', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1467, 'bd', 'Inhouse orders', 'Inhouse orders', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1468, 'bd', 'Seller Orders', 'Seller Orders', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1469, 'bd', 'Pick-up Point Order', 'Pick-up Point Order', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1470, 'bd', 'Customers', 'Customers', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1471, 'bd', 'Customer list', 'Customer list', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1472, 'bd', 'All Seller', 'All Seller', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1473, 'bd', 'Payouts', 'Payouts', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1474, 'bd', 'Payout Requests', 'Payout Requests', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1475, 'bd', 'Seller Commission', 'Seller Commission', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1476, 'bd', 'Seller Verification Form', 'Seller Verification Form', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1477, 'bd', 'Uploaded Files', 'Uploaded Files', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1478, 'bd', 'Reports', 'Reports', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1479, 'bd', 'In House Product Sale', 'In House Product Sale', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1480, 'bd', 'Seller Products Sale', 'Seller Products Sale', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1481, 'bd', 'Products Stock', 'Products Stock', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1482, 'bd', 'Products wishlist', 'Products wishlist', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1483, 'bd', 'User Searches', 'User Searches', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1484, 'bd', 'Marketing', 'Marketing', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1485, 'bd', 'Flash deals', 'Flash deals', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1486, 'bd', 'Newsletters', 'Newsletters', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1487, 'bd', 'Subscribers', 'Subscribers', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1488, 'bd', 'Coupon', 'Coupon', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1489, 'bd', 'Support', 'Support', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1490, 'bd', 'Ticket', 'Ticket', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1491, 'bd', 'Product Queries', 'Product Queries', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1492, 'bd', 'Website Setup', 'Website Setup', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1493, 'bd', 'Header', 'Header', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1494, 'bd', 'Footer', 'Footer', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1495, 'bd', 'Pages', 'Pages', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1496, 'bd', 'Appearance', 'Appearance', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1497, 'bd', 'Setup & Configurations', 'Setup & Configurations', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1498, 'bd', 'General Settings', 'General Settings', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1499, 'bd', 'Features activation', 'Features activation', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1500, 'bd', 'Languages', 'Languages', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1501, 'bd', 'Currency', 'Currency', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1502, 'bd', 'Pickup point', 'Pickup point', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1503, 'bd', 'SMTP Settings', 'SMTP Settings', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1504, 'bd', 'Payment Methods', 'Payment Methods', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1505, 'bd', 'File System Configuration', 'File System Configuration', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1506, 'bd', 'Social media Logins', 'Social media Logins', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1507, 'bd', 'Analytics Tools', 'Analytics Tools', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1508, 'bd', 'Facebook Chat', 'Facebook Chat', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1509, 'bd', 'Google reCAPTCHA', 'Google reCAPTCHA', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1510, 'bd', 'Shipping Configuration', 'Shipping Configuration', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1511, 'bd', 'Shipping Countries', 'Shipping Countries', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1512, 'bd', 'Shipping Cities', 'Shipping Cities', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1513, 'bd', 'Staffs', 'Staffs', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1514, 'bd', 'All staffs', 'All staffs', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1515, 'bd', 'Staff permissions', 'Staff permissions', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1516, 'bd', 'System', 'System', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1517, 'bd', 'Update', 'Update', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1518, 'bd', 'Server status', 'Server status', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1519, 'bd', 'Addon Manager', 'Addon Manager', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1520, 'bd', 'Browse Website', 'Browse Website', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1521, 'bd', 'Notifications', 'Notifications', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1522, 'bd', 'Profile', 'Profile', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1523, 'bd', 'Logout', 'Logout', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1524, 'bd', 'Nothing Found', 'Nothing Found', '2021-02-08 00:18:14', '2021-02-08 00:18:14'),
(1525, 'bd', 'All Sellers', 'All Sellers', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1526, 'bd', 'Add New Seller', 'Add New Seller', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1527, 'bd', 'Filter by Approval', 'Filter by Approval', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1528, 'bd', 'Approved', 'Approved', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1529, 'bd', 'Non-Approved', 'Non-Approved', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1530, 'bd', 'Type name or email & Enter', 'Type name or email & Enter', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1531, 'bd', 'Name', 'Name', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1532, 'bd', 'Email Address', 'Email Address', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1533, 'bd', 'Verification Info', 'Verification Info', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1534, 'bd', 'Approval', 'Approval', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1535, 'bd', 'Num. of Products', 'Num. of Products', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1536, 'bd', 'Due to seller', 'Due to seller', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1537, 'bd', 'Options', 'Options', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1538, 'bd', 'Show', 'Show', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1539, 'bd', 'Actions', 'Actions', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1540, 'bd', 'Log in as this Seller', 'Log in as this Seller', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1541, 'bd', 'Go to Payment', 'Go to Payment', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1542, 'bd', 'Payment History', 'Payment History', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1543, 'bd', 'Edit', 'Edit', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1544, 'bd', 'Ban this seller', 'Ban this seller', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1545, 'bd', 'Delete Confirmation', 'Delete Confirmation', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1546, 'bd', 'Are you sure to delete this?', 'Are you sure to delete this?', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1547, 'bd', 'Do you really want to ban this seller?', 'Do you really want to ban this seller?', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1548, 'bd', 'Proceed!', 'Proceed!', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1549, 'bd', 'Approved sellers updated successfully', 'Approved sellers updated successfully', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1550, 'bd', 'Something went wrong', 'Something went wrong', '2021-02-08 00:18:37', '2021-02-08 00:18:37'),
(1551, 'bd', 'Save', 'Save', '2021-02-08 00:18:38', '2021-02-08 00:18:38'),
(1552, 'bd', 'Note', 'Note', '2021-02-08 00:18:38', '2021-02-08 00:18:38'),
(1553, 'bd', 'of seller product price will be deducted from seller earnings', 'of seller product price will be deducted from seller earnings', '2021-02-08 00:18:38', '2021-02-08 00:18:38'),
(1554, 'bd', 'This commission only works when Category Based Commission is turned off from Business Settings', 'This commission only works when Category Based Commission is turned off from Business Settings', '2021-02-08 00:18:38', '2021-02-08 00:18:38'),
(1555, 'bd', 'Commission doesn\'t work if seller package system add-on is activated', 'Commission doesn\'t work if seller package system add-on is activated', '2021-02-08 00:18:38', '2021-02-08 00:18:38'),
(1556, 'bd', 'Seller Withdraw Request', 'Seller Withdraw Request', '2021-02-08 00:18:39', '2021-02-08 00:18:39'),
(1557, 'bd', 'Date', 'Date', '2021-02-08 00:18:39', '2021-02-08 00:18:39'),
(1558, 'bd', 'Seller', 'Seller', '2021-02-08 00:18:39', '2021-02-08 00:18:39'),
(1559, 'bd', 'Total Amount to Pay', 'Total Amount to Pay', '2021-02-08 00:18:39', '2021-02-08 00:18:39'),
(1560, 'bd', 'Requested Amount', 'Requested Amount', '2021-02-08 00:18:39', '2021-02-08 00:18:39'),
(1561, 'bd', 'Message', 'Message', '2021-02-08 00:18:39', '2021-02-08 00:18:39'),
(1562, 'bd', 'Status', 'Status', '2021-02-08 00:18:39', '2021-02-08 00:18:39'),
(1563, 'bd', 'Label', 'Label', '2021-02-08 00:18:40', '2021-02-08 00:18:40'),
(1564, 'bd', 'Text Input', 'Text Input', '2021-02-08 00:18:40', '2021-02-08 00:18:40'),
(1565, 'bd', 'Select', 'Select', '2021-02-08 00:18:40', '2021-02-08 00:18:40'),
(1566, 'bd', 'Multiple Select', 'Multiple Select', '2021-02-08 00:18:40', '2021-02-08 00:18:40'),
(1567, 'bd', 'Radio', 'Radio', '2021-02-08 00:18:40', '2021-02-08 00:18:40'),
(1568, 'bd', 'File', 'File', '2021-02-08 00:18:40', '2021-02-08 00:18:40'),
(1569, 'bd', 'Select Label', 'Select Label', '2021-02-08 00:18:40', '2021-02-08 00:18:40'),
(1570, 'bd', 'Multiple Select Label', 'Multiple Select Label', '2021-02-08 00:18:41', '2021-02-08 00:18:41'),
(1571, 'bd', 'Radio Label', 'Radio Label', '2021-02-08 00:18:41', '2021-02-08 00:18:41'),
(1572, 'bd', 'Seller Payments', 'Seller Payments', '2021-02-08 00:18:42', '2021-02-08 00:18:42'),
(1573, 'bd', 'Amount', 'Amount', '2021-02-08 00:18:42', '2021-02-08 00:18:42'),
(1574, 'bd', 'Payment Details', 'Payment Details', '2021-02-08 00:18:42', '2021-02-08 00:18:42'),
(1575, 'bd', 'My Panel', 'My Panel', '2021-02-08 00:28:45', '2021-02-08 00:28:45'),
(1576, 'bd', 'Installed Addon', 'Installed Addon', '2021-02-08 00:41:17', '2021-02-08 00:41:17'),
(1577, 'bd', 'Available Addon', 'Available Addon', '2021-02-08 00:41:17', '2021-02-08 00:41:17'),
(1578, 'bd', 'Install/Update Addon', 'Install/Update Addon', '2021-02-08 00:41:17', '2021-02-08 00:41:17'),
(1579, 'bd', 'No Addon Installed', 'No Addon Installed', '2021-02-08 00:41:17', '2021-02-08 00:41:17'),
(1580, 'bd', 'Status updated successfully', 'Status updated successfully', '2021-02-08 00:41:17', '2021-02-08 00:41:17'),
(1581, 'en', 'Install/Update Addon', 'Install/Update Addon', '2021-02-08 00:41:18', '2021-02-08 00:41:18'),
(1582, 'en', 'No Addon Installed', 'No Addon Installed', '2021-02-08 00:41:18', '2021-02-08 00:41:18'),
(1583, 'en', 'Search in menu', 'Search in menu', '2021-02-08 00:41:18', '2021-02-08 00:41:18'),
(1584, 'en', 'Uploaded Files', 'Uploaded Files', '2021-02-08 00:41:18', '2021-02-08 00:41:18'),
(1585, 'en', 'Shipping Cities', 'Shipping Cities', '2021-02-08 00:41:18', '2021-02-08 00:41:18'),
(1586, 'en', 'System', 'System', '2021-02-08 00:41:18', '2021-02-08 00:41:18'),
(1587, 'en', 'Server status', 'Server status', '2021-02-08 00:41:18', '2021-02-08 00:41:18'),
(1588, 'en', 'Nothing Found', 'Nothing Found', '2021-02-08 00:41:18', '2021-02-08 00:41:18'),
(1589, 'bd', 'Zip File', 'Zip File', '2021-02-08 00:41:20', '2021-02-08 00:41:20'),
(1590, 'bd', 'Choose file', 'Choose file', '2021-02-08 00:41:20', '2021-02-08 00:41:20'),
(1591, 'bd', 'Install/Update', 'Install/Update', '2021-02-08 00:41:20', '2021-02-08 00:41:20'),
(1592, 'bd', 'Forgot password?', 'Forgot password?', '2021-02-08 00:58:08', '2021-02-08 00:58:08'),
(1593, 'bd', 'Dont have an account?', 'Dont have an account?', '2021-02-08 00:58:08', '2021-02-08 00:58:08'),
(1594, 'bd', 'Register Now', 'Register Now', '2021-02-08 00:58:08', '2021-02-08 00:58:08'),
(1595, 'bd', 'Inhouse Product sale report', 'Inhouse Product sale report', '2021-02-08 00:59:23', '2021-02-08 00:59:23'),
(1596, 'bd', 'Sort by Category', 'Sort by Category', '2021-02-08 00:59:23', '2021-02-08 00:59:23'),
(1597, 'bd', 'Filter', 'Filter', '2021-02-08 00:59:23', '2021-02-08 00:59:23'),
(1598, 'bd', 'Product Name', 'Product Name', '2021-02-08 00:59:23', '2021-02-08 00:59:23'),
(1599, 'bd', 'Num of Sale', 'Num of Sale', '2021-02-08 00:59:23', '2021-02-08 00:59:23'),
(1600, 'bd', 'Seller Based Selling Report', 'Seller Based Selling Report', '2021-02-08 00:59:25', '2021-02-08 00:59:25'),
(1601, 'bd', 'Sort by verificarion status', 'Sort by verificarion status', '2021-02-08 00:59:25', '2021-02-08 00:59:25'),
(1602, 'bd', 'Non Approved', 'Non Approved', '2021-02-08 00:59:25', '2021-02-08 00:59:25'),
(1603, 'bd', 'Seller Name', 'Seller Name', '2021-02-08 00:59:25', '2021-02-08 00:59:25'),
(1604, 'bd', 'Shop Name', 'Shop Name', '2021-02-08 00:59:25', '2021-02-08 00:59:25'),
(1605, 'bd', 'Number of Product Sale', 'Number of Product Sale', '2021-02-08 00:59:25', '2021-02-08 00:59:25'),
(1606, 'bd', 'Order Amount', 'Order Amount', '2021-02-08 00:59:25', '2021-02-08 00:59:25'),
(1607, 'bd', 'Product wise stock report', 'Product wise stock report', '2021-02-08 00:59:26', '2021-02-08 00:59:26'),
(1608, 'bd', 'Stock', 'Stock', '2021-02-08 00:59:26', '2021-02-08 00:59:26'),
(1609, 'bd', 'Product Wish Report', 'Product Wish Report', '2021-02-08 00:59:27', '2021-02-08 00:59:27'),
(1610, 'bd', 'Number of Wish', 'Number of Wish', '2021-02-08 00:59:27', '2021-02-08 00:59:27'),
(1611, 'bd', 'User Search Report', 'User Search Report', '2021-02-08 00:59:28', '2021-02-08 00:59:28'),
(1612, 'bd', 'Search By', 'Search By', '2021-02-08 00:59:28', '2021-02-08 00:59:28'),
(1613, 'bd', 'Number searches', 'Number searches', '2021-02-08 00:59:28', '2021-02-08 00:59:28'),
(1614, 'bd', 'Conversations', 'Conversations', '2021-02-08 00:59:31', '2021-02-08 00:59:31'),
(1615, 'bd', 'Title', 'Title', '2021-02-08 00:59:31', '2021-02-08 00:59:31'),
(1616, 'bd', 'Sender', 'Sender', '2021-02-08 00:59:31', '2021-02-08 00:59:31'),
(1617, 'bd', 'Receiver', 'Receiver', '2021-02-08 00:59:31', '2021-02-08 00:59:31'),
(1618, 'bd', 'Support Desk', 'Support Desk', '2021-02-08 00:59:32', '2021-02-08 00:59:32'),
(1619, 'bd', 'Type ticket code & Enter', 'Type ticket code & Enter', '2021-02-08 00:59:32', '2021-02-08 00:59:32'),
(1620, 'bd', 'Ticket ID', 'Ticket ID', '2021-02-08 00:59:32', '2021-02-08 00:59:32'),
(1621, 'bd', 'Sending Date', 'Sending Date', '2021-02-08 00:59:32', '2021-02-08 00:59:32'),
(1622, 'bd', 'Subject', 'Subject', '2021-02-08 00:59:32', '2021-02-08 00:59:32'),
(1623, 'bd', 'User', 'User', '2021-02-08 00:59:32', '2021-02-08 00:59:32'),
(1624, 'bd', 'Last reply', 'Last reply', '2021-02-08 00:59:32', '2021-02-08 00:59:32'),
(1626, 'bd', 'Version', 'Version', '2021-02-08 01:00:37', '2021-02-08 01:00:37'),
(1627, 'bd', 'Affiliate System', 'Affiliate System', '2021-02-08 01:00:37', '2021-02-08 01:00:37'),
(1628, 'bd', 'Affiliate Registration Form', 'Affiliate Registration Form', '2021-02-08 01:00:37', '2021-02-08 01:00:37'),
(1629, 'bd', 'Affiliate Configurations', 'Affiliate Configurations', '2021-02-08 01:00:37', '2021-02-08 01:00:37'),
(1630, 'bd', 'Affiliate Users', 'Affiliate Users', '2021-02-08 01:00:37', '2021-02-08 01:00:37'),
(1631, 'bd', 'Referral Users', 'Referral Users', '2021-02-08 01:00:37', '2021-02-08 01:00:37'),
(1632, 'bd', 'Affiliate Withdraw Requests', 'Affiliate Withdraw Requests', '2021-02-08 01:00:37', '2021-02-08 01:00:37'),
(1633, 'bd', 'Basic Affiliate', 'Basic Affiliate', '2021-02-08 01:00:50', '2021-02-08 01:00:50'),
(1634, 'bd', 'User Registration & First Purchase', 'User Registration & First Purchase', '2021-02-08 01:00:50', '2021-02-08 01:00:50'),
(1635, 'bd', 'Product Sharing Affiliate', 'Product Sharing Affiliate', '2021-02-08 01:00:50', '2021-02-08 01:00:50'),
(1636, 'bd', 'Product Sharing and Purchasing', 'Product Sharing and Purchasing', '2021-02-08 01:00:50', '2021-02-08 01:00:50'),
(1637, 'bd', 'Product Sharing Affiliate (Category Wise)', 'Product Sharing Affiliate (Category Wise)', '2021-02-08 01:00:50', '2021-02-08 01:00:50'),
(1638, 'bd', 'Due Amount', 'Due Amount', '2021-02-08 01:00:51', '2021-02-08 01:00:51'),
(1639, 'bd', 'Pay Now', 'Pay Now', '2021-02-08 01:00:51', '2021-02-08 01:00:51'),
(1640, 'bd', 'Refferal Users', 'Refferal Users', '2021-02-08 01:00:54', '2021-02-08 01:00:54'),
(1641, 'bd', 'Reffered By', 'Reffered By', '2021-02-08 01:00:54', '2021-02-08 01:00:54'),
(1642, 'bd', 'Affiliate Withdraw Request', 'Affiliate Withdraw Request', '2021-02-08 01:00:55', '2021-02-08 01:00:55'),
(1643, 'bd', 'Affiliate Withdraw Request Reject', 'Affiliate Withdraw Request Reject', '2021-02-08 01:00:55', '2021-02-08 01:00:55'),
(1644, 'bd', 'Are you sure, You want to reject this?', 'Are you sure, You want to reject this?', '2021-02-08 01:00:55', '2021-02-08 01:00:55'),
(1645, 'bd', 'Reject', 'Reject', '2021-02-08 01:00:55', '2021-02-08 01:00:55'),
(1647, 'bd', 'Club Point System', 'Club Point System', '2021-02-08 01:01:06', '2021-02-08 01:01:06'),
(1648, 'bd', 'Club Point Configurations', 'Club Point Configurations', '2021-02-08 01:01:06', '2021-02-08 01:01:06'),
(1649, 'bd', 'Set Product Point', 'Set Product Point', '2021-02-08 01:01:06', '2021-02-08 01:01:06'),
(1650, 'bd', 'User Points', 'User Points', '2021-02-08 01:01:06', '2021-02-08 01:01:06'),
(1652, 'bd', 'Offline Payment System', 'Offline Payment System', '2021-02-08 01:01:12', '2021-02-08 01:01:12'),
(1653, 'bd', 'Manual Payment Methods', 'Manual Payment Methods', '2021-02-08 01:01:12', '2021-02-08 01:01:12'),
(1654, 'bd', 'Offline Wallet Recharge', 'Offline Wallet Recharge', '2021-02-08 01:01:12', '2021-02-08 01:01:12'),
(1656, 'bd', 'Bulk SMS', 'Bulk SMS', '2021-02-08 01:01:17', '2021-02-08 01:01:17'),
(1657, 'bd', 'OTP System', 'OTP System', '2021-02-08 01:01:18', '2021-02-08 01:01:18'),
(1658, 'bd', 'OTP Configurations', 'OTP Configurations', '2021-02-08 01:01:18', '2021-02-08 01:01:18'),
(1659, 'bd', 'Set OTP Credentials', 'Set OTP Credentials', '2021-02-08 01:01:18', '2021-02-08 01:01:18'),
(1660, 'bd', 'Addon nstalled successfully', 'Addon nstalled successfully', '2021-02-08 01:01:29', '2021-02-08 01:01:29'),
(1661, 'bd', 'Paytm Payment Gateway', 'Paytm Payment Gateway', '2021-02-08 01:01:29', '2021-02-08 01:01:29'),
(1662, 'bd', 'Set Paytm Credentials', 'Set Paytm Credentials', '2021-02-08 01:01:29', '2021-02-08 01:01:29'),
(1663, 'bd', 'Activate OTP', 'Activate OTP', '2021-02-08 01:01:32', '2021-02-08 01:01:32'),
(1664, 'bd', 'Nexmo OTP', 'Nexmo OTP', '2021-02-08 01:01:32', '2021-02-08 01:01:32'),
(1665, 'bd', 'Twillo OTP', 'Twillo OTP', '2021-02-08 01:01:32', '2021-02-08 01:01:32'),
(1666, 'bd', 'SSL Wireless OTP', 'SSL Wireless OTP', '2021-02-08 01:01:32', '2021-02-08 01:01:32'),
(1667, 'bd', 'Fast2SMS OTP', 'Fast2SMS OTP', '2021-02-08 01:01:32', '2021-02-08 01:01:32'),
(1668, 'bd', 'MIMO OTP', 'MIMO OTP', '2021-02-08 01:01:32', '2021-02-08 01:01:32'),
(1669, 'bd', 'OTP will be Used For', 'OTP will be Used For', '2021-02-08 01:01:32', '2021-02-08 01:01:32'),
(1670, 'bd', 'Order Placement', 'Order Placement', '2021-02-08 01:01:32', '2021-02-08 01:01:32'),
(1671, 'bd', 'Delivery Status Changing Time', 'Delivery Status Changing Time', '2021-02-08 01:01:32', '2021-02-08 01:01:32'),
(1672, 'bd', 'Paid Status Changing Time', 'Paid Status Changing Time', '2021-02-08 01:01:32', '2021-02-08 01:01:32'),
(1673, 'bd', 'Settings updated successfully', 'Settings updated successfully', '2021-02-08 01:01:32', '2021-02-08 01:01:32'),
(1674, 'bd', 'Twillo Credential', 'Twillo Credential', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1675, 'bd', 'TWILIO SID', 'TWILIO SID', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1676, 'bd', 'TWILIO AUTH TOKEN', 'TWILIO AUTH TOKEN', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1677, 'bd', 'TWILIO VERIFY SID', 'TWILIO VERIFY SID', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1678, 'bd', 'VALID TWILLO NUMBER', 'VALID TWILLO NUMBER', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1679, 'bd', 'Nexmo Credential', 'Nexmo Credential', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1680, 'bd', 'NEXMO KEY', 'NEXMO KEY', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1681, 'bd', 'NEXMO SECRET', 'NEXMO SECRET', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1682, 'bd', 'SSL Wireless Credential', 'SSL Wireless Credential', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1683, 'bd', 'SSL SMS API TOKEN', 'SSL SMS API TOKEN', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1684, 'bd', 'SSL SMS SID', 'SSL SMS SID', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1685, 'bd', 'SSL SMS URL', 'SSL SMS URL', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1686, 'bd', 'Fast2SMS Credential', 'Fast2SMS Credential', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1687, 'bd', 'AUTH KEY', 'AUTH KEY', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1688, 'bd', 'ROUTE', 'ROUTE', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1689, 'bd', 'Promotional Use', 'Promotional Use', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1690, 'bd', 'Transactional Use', 'Transactional Use', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1691, 'bd', 'LANGUAGE', 'LANGUAGE', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1692, 'bd', 'SENDER ID', 'SENDER ID', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1693, 'bd', 'MIMO Credential', 'MIMO Credential', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1694, 'bd', 'MIMO_USERNAME', 'MIMO_USERNAME', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1695, 'bd', 'MIMO_PASSWORD', 'MIMO_PASSWORD', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1696, 'bd', 'MIMO_SENDER_ID', 'MIMO_SENDER_ID', '2021-02-08 01:01:40', '2021-02-08 01:01:40'),
(1697, 'bd', 'POS System', 'POS System', '2021-02-08 01:01:48', '2021-02-08 01:01:48'),
(1698, 'bd', 'POS Manager', 'POS Manager', '2021-02-08 01:01:48', '2021-02-08 01:01:48'),
(1699, 'bd', 'POS Configuration', 'POS Configuration', '2021-02-08 01:01:48', '2021-02-08 01:01:48'),
(1700, 'bd', 'POS', 'POS', '2021-02-08 01:01:49', '2021-02-08 01:01:49'),
(1701, 'bd', 'Refunds', 'Refunds', '2021-02-08 01:01:55', '2021-02-08 01:01:55'),
(1702, 'bd', 'Refund Requests', 'Refund Requests', '2021-02-08 01:01:55', '2021-02-08 01:01:55'),
(1703, 'bd', 'Approved Refund', 'Approved Refund', '2021-02-08 01:01:55', '2021-02-08 01:01:55'),
(1704, 'bd', 'Refund Configuration', 'Refund Configuration', '2021-02-08 01:01:55', '2021-02-08 01:01:55'),
(1705, 'bd', 'Seller Packages', 'Seller Packages', '2021-02-08 01:02:02', '2021-02-08 01:02:02'),
(1706, 'bd', 'Offline Seller Package Payments', 'Offline Seller Package Payments', '2021-02-08 01:02:02', '2021-02-08 01:02:02'),
(1707, 'bd', 'Convert Point To Wallet', 'Convert Point To Wallet', '2021-02-08 01:02:19', '2021-02-08 01:02:19'),
(1708, 'bd', 'Set Point For ', 'Set Point For ', '2021-02-08 01:02:19', '2021-02-08 01:02:19'),
(1709, 'bd', 'Points', 'Points', '2021-02-08 01:02:19', '2021-02-08 01:02:19'),
(1710, 'bd', 'Note: You need to activate wallet option first before using club point addon.', 'Note: You need to activate wallet option first before using club point addon.', '2021-02-08 01:02:19', '2021-02-08 01:02:19'),
(1711, 'bd', 'Product Owner', 'Product Owner', '2021-02-08 01:02:25', '2021-02-08 01:02:25'),
(1712, 'bd', 'Base Price', 'Base Price', '2021-02-08 01:02:25', '2021-02-08 01:02:25'),
(1713, 'bd', 'Rating', 'Rating', '2021-02-08 01:02:25', '2021-02-08 01:02:25'),
(1714, 'bd', 'Point', 'Point', '2021-02-08 01:02:25', '2021-02-08 01:02:25'),
(1715, 'bd', 'Set Point for Product Within a Range', 'Set Point for Product Within a Range', '2021-02-08 01:02:25', '2021-02-08 01:02:25'),
(1716, 'bd', 'Set Point for multiple products', 'Set Point for multiple products', '2021-02-08 01:02:25', '2021-02-08 01:02:25'),
(1717, 'bd', 'Min Price', 'Min Price', '2021-02-08 01:02:25', '2021-02-08 01:02:25'),
(1718, 'bd', 'Max Price', 'Max Price', '2021-02-08 01:02:25', '2021-02-08 01:02:25'),
(1719, 'bd', 'Set Point for all Products', 'Set Point for all Products', '2021-02-08 01:02:25', '2021-02-08 01:02:25'),
(1720, 'bd', 'Convert Status', 'Convert Status', '2021-02-08 01:02:28', '2021-02-08 01:02:28'),
(1721, 'bd', 'Earned At', 'Earned At', '2021-02-08 01:02:28', '2021-02-08 01:02:28'),
(1722, 'bd', 'Paytm Credential', 'Paytm Credential', '2021-02-08 01:02:31', '2021-02-08 01:02:31'),
(1723, 'bd', 'PAYTM ENVIRONMENT', 'PAYTM ENVIRONMENT', '2021-02-08 01:02:31', '2021-02-08 01:02:31'),
(1724, 'bd', 'PAYTM MERCHANT ID', 'PAYTM MERCHANT ID', '2021-02-08 01:02:31', '2021-02-08 01:02:31'),
(1725, 'bd', 'PAYTM MERCHANT KEY', 'PAYTM MERCHANT KEY', '2021-02-08 01:02:31', '2021-02-08 01:02:31'),
(1726, 'bd', 'PAYTM MERCHANT WEBSITE', 'PAYTM MERCHANT WEBSITE', '2021-02-08 01:02:31', '2021-02-08 01:02:31'),
(1727, 'bd', 'PAYTM CHANNEL', 'PAYTM CHANNEL', '2021-02-08 01:02:31', '2021-02-08 01:02:31'),
(1728, 'bd', 'PAYTM INDUSTRY TYPE', 'PAYTM INDUSTRY TYPE', '2021-02-08 01:02:31', '2021-02-08 01:02:31'),
(1729, 'bd', 'Add New Payment Method', 'Add New Payment Method', '2021-02-08 01:02:42', '2021-02-08 01:02:42'),
(1730, 'bd', 'Manual Payment Method', 'Manual Payment Method', '2021-02-08 01:02:42', '2021-02-08 01:02:42'),
(1731, 'bd', 'Heading', 'Heading', '2021-02-08 01:02:42', '2021-02-08 01:02:42'),
(1732, 'bd', 'Logo', 'Logo', '2021-02-08 01:02:42', '2021-02-08 01:02:42'),
(1733, 'bd', 'Offline Wallet Recharge Requests', 'Offline Wallet Recharge Requests', '2021-02-08 01:02:44', '2021-02-08 01:02:44'),
(1734, 'bd', 'Method', 'Method', '2021-02-08 01:02:44', '2021-02-08 01:02:44'),
(1735, 'bd', 'TXN ID', 'TXN ID', '2021-02-08 01:02:44', '2021-02-08 01:02:44'),
(1736, 'bd', 'Photo', 'Photo', '2021-02-08 01:02:44', '2021-02-08 01:02:44'),
(1737, 'bd', 'Money has been added successfully', 'Money has been added successfully', '2021-02-08 01:02:44', '2021-02-08 01:02:44'),
(1738, 'bd', 'Be an affiliate partner', 'Be an affiliate partner', '2021-02-08 01:02:47', '2021-02-08 01:02:47'),
(1739, 'en', 'Something went wrong!', 'Something went wrong!', '2021-02-08 01:02:47', '2021-02-08 01:02:47'),
(1740, 'en', 'Sorry for the inconvenience, but we\'re working on it.', 'Sorry for the inconvenience, but we\'re working on it.', '2021-02-08 01:02:47', '2021-02-08 01:02:47'),
(1741, 'en', 'Error code', 'Error code', '2021-02-08 01:02:47', '2021-02-08 01:02:47'),
(1742, 'bd', 'Manual Payment Information', 'Manual Payment Information', '2021-02-08 01:04:12', '2021-02-08 01:04:12'),
(1743, 'bd', 'Type', 'Type', '2021-02-08 01:04:12', '2021-02-08 01:04:12'),
(1744, 'bd', 'Custom Payment', 'Custom Payment', '2021-02-08 01:04:12', '2021-02-08 01:04:12'),
(1745, 'bd', 'Bank Payment', 'Bank Payment', '2021-02-08 01:04:12', '2021-02-08 01:04:12'),
(1746, 'bd', 'Check Payment', 'Check Payment', '2021-02-08 01:04:12', '2021-02-08 01:04:12'),
(1747, 'bd', 'Checkout Thumbnail', 'Checkout Thumbnail', '2021-02-08 01:04:12', '2021-02-08 01:04:12'),
(1748, 'bd', 'Browse', 'Browse', '2021-02-08 01:04:12', '2021-02-08 01:04:12'),
(1749, 'bd', 'Payment Instruction', 'Payment Instruction', '2021-02-08 01:04:12', '2021-02-08 01:04:12'),
(1750, 'bd', 'Bank Information', 'Bank Information', '2021-02-08 01:04:12', '2021-02-08 01:04:12'),
(1751, 'bd', 'Remove', 'Remove', '2021-02-08 01:04:12', '2021-02-08 01:04:12'),
(1752, 'bd', 'POS Activation for Seller', 'POS Activation for Seller', '2021-02-08 01:05:05', '2021-02-08 01:05:05'),
(1753, 'bd', 'Email Or Phone', 'Email Or Phone', '2021-02-08 01:11:18', '2021-02-08 01:11:18'),
(1754, 'bd', 'Use country code before number', 'Use country code before number', '2021-02-08 01:11:18', '2021-02-08 01:11:18'),
(1755, 'bd', 'Language changed to ', 'Language changed to ', '2021-02-08 01:13:58', '2021-02-08 01:13:58'),
(1756, 'bd', 'General', 'General', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1757, 'bd', 'Frontend Website Name', 'Frontend Website Name', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1758, 'bd', 'Website Name', 'Website Name', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1759, 'bd', 'Site Motto', 'Site Motto', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1760, 'bd', 'Best eCommerce Website', 'Best eCommerce Website', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1761, 'bd', 'Site Icon', 'Site Icon', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1762, 'bd', 'Website favicon. 32x32 .png', 'Website favicon. 32x32 .png', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1763, 'bd', 'Website Base Color', 'Website Base Color', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1764, 'bd', 'Hex Color Code', 'Hex Color Code', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1765, 'bd', 'Website Base Hover Color', 'Website Base Hover Color', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1766, 'bd', 'Global SEO', 'Global SEO', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1767, 'bd', 'Meta Title', 'Meta Title', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1768, 'bd', 'Meta description', 'Meta description', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1769, 'bd', 'Keywords', 'Keywords', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1770, 'bd', 'Separate with coma', 'Separate with coma', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1771, 'bd', 'Meta Image', 'Meta Image', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1772, 'bd', 'Cookies Agreement', 'Cookies Agreement', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1773, 'bd', 'Cookies Agreement Text', 'Cookies Agreement Text', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1774, 'bd', 'Show Cookies Agreement?', 'Show Cookies Agreement?', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1775, 'bd', 'Custom Script', 'Custom Script', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1776, 'bd', 'Header custom script - before </head>', 'Header custom script - before </head>', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1777, 'bd', 'Write script with <script> tag', 'Write script with <script> tag', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1778, 'bd', 'Footer custom script - before </body>', 'Footer custom script - before </body>', '2021-02-08 01:14:49', '2021-02-08 01:14:49'),
(1779, 'bd', 'Walk In Customer', 'Walk In Customer', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1780, 'bd', 'Product', 'Product', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1781, 'bd', 'QTY', 'QTY', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1782, 'bd', 'Price', 'Price', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1783, 'bd', 'Subtotal', 'Subtotal', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1784, 'bd', 'Sub Total', 'Sub Total', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1785, 'bd', 'Total Tax', 'Total Tax', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1786, 'bd', 'Total Shipping', 'Total Shipping', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1787, 'bd', 'Discount', 'Discount', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1788, 'bd', 'Shipping', 'Shipping', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1789, 'bd', 'Without Shipping Charge', 'Without Shipping Charge', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1790, 'bd', 'With Shipping Charge', 'With Shipping Charge', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1791, 'bd', 'Flat', 'Flat', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1792, 'bd', 'Pay With Cash', 'Pay With Cash', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1793, 'bd', 'Shipping Address', 'Shipping Address', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1794, 'bd', 'Close', 'Close', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1795, 'bd', 'Confirm', 'Confirm', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1796, 'bd', 'Country', 'Country', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1797, 'bd', 'Select country', 'Select country', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1798, 'bd', 'City', 'City', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1799, 'bd', 'Postal code', 'Postal code', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1800, 'bd', 'Order Confirmation', 'Order Confirmation', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1801, 'bd', 'Are you sure to confirm this order?', 'Are you sure to confirm this order?', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1802, 'bd', 'Comfirm Order', 'Comfirm Order', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1803, 'bd', 'Order Completed Successfully.', 'Order Completed Successfully.', '2021-02-08 02:11:07', '2021-02-08 02:11:07'),
(1804, 'bd', 'Offline Customer Package Payment Requests', 'Offline Customer Package Payment Requests', '2021-02-08 02:14:31', '2021-02-08 02:14:31'),
(1805, 'bd', 'Package', 'Package', '2021-02-08 02:14:31', '2021-02-08 02:14:31'),
(1806, 'bd', 'Reciept', 'Reciept', '2021-02-08 02:14:31', '2021-02-08 02:14:31'),
(1807, 'bd', 'Offline Customer Package Payment approved successfully', 'Offline Customer Package Payment approved successfully', '2021-02-08 02:14:31', '2021-02-08 02:14:31'),
(1808, 'bd', 'Affiliate Payment', 'Affiliate Payment', '2021-02-08 02:15:51', '2021-02-08 02:15:51'),
(1809, 'bd', 'Paypal Email', 'Paypal Email', '2021-02-08 02:15:51', '2021-02-08 02:15:51'),
(1810, 'bd', 'Payment Method', 'Payment Method', '2021-02-08 02:15:51', '2021-02-08 02:15:51'),
(1811, 'bd', 'Select Payment Method', 'Select Payment Method', '2021-02-08 02:15:51', '2021-02-08 02:15:51'),
(1812, 'bd', 'Paypal', 'Paypal', '2021-02-08 02:15:51', '2021-02-08 02:15:51'),
(1813, 'bd', 'Bank', 'Bank', '2021-02-08 02:15:51', '2021-02-08 02:15:51'),
(1814, 'bd', 'Pay', 'Pay', '2021-02-08 02:15:51', '2021-02-08 02:15:51'),
(1815, 'bd', 'Product Information', 'Product Information', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1816, 'bd', 'Unit', 'Unit', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1817, 'bd', 'Unit (e.g. KG, Pc etc)', 'Unit (e.g. KG, Pc etc)', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1818, 'bd', 'Minimum Qty', 'Minimum Qty', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1819, 'bd', 'Tags', 'Tags', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1820, 'bd', 'Type and hit enter to add a tag', 'Type and hit enter to add a tag', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1821, 'bd', 'This is used for search. Input those words by which cutomer can find this product.', 'This is used for search. Input those words by which cutomer can find this product.', '2021-02-08 09:24:51', '2021-02-08 09:24:51');
INSERT INTO `translations` (`id`, `lang`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(1822, 'bd', 'Barcode', 'Barcode', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1823, 'bd', 'Refundable', 'Refundable', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1824, 'bd', 'Product Images', 'Product Images', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1825, 'bd', 'Gallery Images', 'Gallery Images', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1826, 'bd', 'These images are visible in product details page gallery. Use 600x600 sizes images.', 'These images are visible in product details page gallery. Use 600x600 sizes images.', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1827, 'bd', 'Thumbnail Image', 'Thumbnail Image', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1828, 'bd', 'This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.', 'This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1829, 'bd', 'Product Videos', 'Product Videos', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1830, 'bd', 'Video Provider', 'Video Provider', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1831, 'bd', 'Youtube', 'Youtube', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1832, 'bd', 'Dailymotion', 'Dailymotion', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1833, 'bd', 'Vimeo', 'Vimeo', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1834, 'bd', 'Video Link', 'Video Link', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1835, 'bd', 'Use proper link without extra parameter. Don\'t use short share link/embeded iframe code.', 'Use proper link without extra parameter. Don\'t use short share link/embeded iframe code.', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1836, 'bd', 'Product Variation', 'Product Variation', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1837, 'bd', 'Colors', 'Colors', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1838, 'bd', 'Attributes', 'Attributes', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1839, 'bd', 'Choose Attributes', 'Choose Attributes', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1840, 'bd', 'Choose the attributes of this product and then input values of each attribute', 'Choose the attributes of this product and then input values of each attribute', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1841, 'bd', 'Product price + stock', 'Product price + stock', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1842, 'bd', 'Unit price', 'Unit price', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1843, 'bd', 'Purchase price', 'Purchase price', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1844, 'bd', 'Tax', 'Tax', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1845, 'bd', 'Percent', 'Percent', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1846, 'bd', 'Quantity', 'Quantity', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1847, 'bd', 'Product Description', 'Product Description', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1848, 'bd', 'Description', 'Description', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1849, 'bd', 'Product Shipping Cost', 'Product Shipping Cost', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1850, 'bd', 'Free Shipping', 'Free Shipping', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1851, 'bd', 'Flat Rate', 'Flat Rate', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1852, 'bd', 'Shipping cost', 'Shipping cost', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1853, 'bd', 'PDF Specification', 'PDF Specification', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1854, 'bd', 'SEO Meta Tags', 'SEO Meta Tags', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1855, 'bd', 'Save Product', 'Save Product', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1856, 'bd', 'Choice Title', 'Choice Title', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1857, 'bd', 'Enter choice values', 'Enter choice values', '2021-02-08 09:24:51', '2021-02-08 09:24:51'),
(1858, 'bd', 'All Product', 'All Product', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1859, 'bd', 'Sort By', 'Sort By', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1860, 'bd', 'Rating (High > Low)', 'Rating (High > Low)', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1861, 'bd', 'Rating (Low > High)', 'Rating (Low > High)', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1862, 'bd', 'Num of Sale (High > Low)', 'Num of Sale (High > Low)', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1863, 'bd', 'Num of Sale (Low > High)', 'Num of Sale (Low > High)', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1864, 'bd', 'Base Price (High > Low)', 'Base Price (High > Low)', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1865, 'bd', 'Base Price (Low > High)', 'Base Price (Low > High)', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1866, 'bd', 'Type & Enter', 'Type & Enter', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1867, 'bd', 'Added By', 'Added By', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1868, 'bd', 'Total Stock', 'Total Stock', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1869, 'bd', 'Todays Deal', 'Todays Deal', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1870, 'bd', 'Published', 'Published', '2021-02-08 09:24:53', '2021-02-08 09:24:53'),
(1871, 'bd', 'Featured', 'Featured', '2021-02-08 09:24:54', '2021-02-08 09:24:54'),
(1872, 'bd', 'Todays Deal updated successfully', 'Todays Deal updated successfully', '2021-02-08 09:24:54', '2021-02-08 09:24:54'),
(1873, 'bd', 'Published products updated successfully', 'Published products updated successfully', '2021-02-08 09:24:54', '2021-02-08 09:24:54'),
(1874, 'bd', 'Featured products updated successfully', 'Featured products updated successfully', '2021-02-08 09:24:54', '2021-02-08 09:24:54'),
(1875, 'bd', 'Add New Digital Product', 'Add New Digital Product', '2021-02-08 09:25:12', '2021-02-08 09:25:12'),
(1876, 'bd', 'Type name & Enter', 'Type name & Enter', '2021-02-08 09:25:12', '2021-02-08 09:25:12'),
(1877, 'bd', 'Update your system', 'Update your system', '2021-02-08 23:59:59', '2021-02-08 23:59:59'),
(1878, 'bd', 'Current verion', 'Current verion', '2021-02-08 23:59:59', '2021-02-08 23:59:59'),
(1879, 'bd', 'Make sure your server has matched with all requirements.', 'Make sure your server has matched with all requirements.', '2021-02-08 23:59:59', '2021-02-08 23:59:59'),
(1880, 'bd', 'Check Here', 'Check Here', '2021-02-08 23:59:59', '2021-02-08 23:59:59'),
(1881, 'bd', 'Download latest version from codecanyon.', 'Download latest version from codecanyon.', '2021-02-08 23:59:59', '2021-02-08 23:59:59'),
(1882, 'bd', 'Extract downloaded zip. You will find updates.zip file in those extraced files.', 'Extract downloaded zip. You will find updates.zip file in those extraced files.', '2021-02-08 23:59:59', '2021-02-08 23:59:59'),
(1883, 'bd', 'Upload that zip file here and click update now.', 'Upload that zip file here and click update now.', '2021-02-08 23:59:59', '2021-02-08 23:59:59'),
(1884, 'bd', 'If you are using any addon make sure to update those addons after updating.', 'If you are using any addon make sure to update those addons after updating.', '2021-02-08 23:59:59', '2021-02-08 23:59:59'),
(1885, 'bd', 'Update Now', 'Update Now', '2021-02-08 23:59:59', '2021-02-08 23:59:59'),
(1886, 'bd', 'Server information', 'Server information', '2021-02-09 00:00:07', '2021-02-09 00:00:07'),
(1887, 'bd', 'Current Version', 'Current Version', '2021-02-09 00:00:07', '2021-02-09 00:00:07'),
(1888, 'bd', 'Required Version', 'Required Version', '2021-02-09 00:00:07', '2021-02-09 00:00:07'),
(1889, 'bd', 'php.ini Config', 'php.ini Config', '2021-02-09 00:00:07', '2021-02-09 00:00:07'),
(1890, 'bd', 'Config Name', 'Config Name', '2021-02-09 00:00:07', '2021-02-09 00:00:07'),
(1891, 'bd', 'Current', 'Current', '2021-02-09 00:00:07', '2021-02-09 00:00:07'),
(1892, 'bd', 'Recommended', 'Recommended', '2021-02-09 00:00:07', '2021-02-09 00:00:07'),
(1893, 'bd', 'Extensions information', 'Extensions information', '2021-02-09 00:00:07', '2021-02-09 00:00:07'),
(1894, 'bd', 'Extension Name', 'Extension Name', '2021-02-09 00:00:07', '2021-02-09 00:00:07'),
(1895, 'bd', 'Filesystem Permissions', 'Filesystem Permissions', '2021-02-09 00:00:07', '2021-02-09 00:00:07'),
(1896, 'bd', 'File or Folder', 'File or Folder', '2021-02-09 00:00:07', '2021-02-09 00:00:07'),
(1897, 'bd', 'Add New Staffs', 'Add New Staffs', '2021-02-09 00:01:17', '2021-02-09 00:01:17'),
(1898, 'bd', 'Role', 'Role', '2021-02-09 00:01:17', '2021-02-09 00:01:17'),
(1899, 'bd', 'All Role', 'All Role', '2021-02-09 00:01:20', '2021-02-09 00:01:20'),
(1900, 'bd', 'Add New Role', 'Add New Role', '2021-02-09 00:01:20', '2021-02-09 00:01:20'),
(1901, 'bd', 'Roles', 'Roles', '2021-02-09 00:01:20', '2021-02-09 00:01:20'),
(1902, 'bd', 'Filters', 'Filters', '2021-02-10 07:36:59', '2021-02-10 07:36:59'),
(1903, 'bd', 'All Categories', 'All Categories', '2021-02-10 07:36:59', '2021-02-10 07:36:59'),
(1904, 'bd', 'Price range', 'Price range', '2021-02-10 07:36:59', '2021-02-10 07:36:59'),
(1905, 'bd', 'Filter by color', 'Filter by color', '2021-02-10 07:36:59', '2021-02-10 07:36:59'),
(1906, 'bd', 'Home', 'Home', '2021-02-10 07:36:59', '2021-02-10 07:36:59'),
(1907, 'bd', 'Brands', 'Brands', '2021-02-10 07:36:59', '2021-02-10 07:36:59'),
(1908, 'bd', 'All Brands', 'All Brands', '2021-02-10 07:36:59', '2021-02-10 07:36:59'),
(1909, 'bd', 'Newest', 'Newest', '2021-02-10 07:36:59', '2021-02-10 07:36:59'),
(1910, 'bd', 'Oldest', 'Oldest', '2021-02-10 07:36:59', '2021-02-10 07:36:59'),
(1911, 'bd', 'Price low to high', 'Price low to high', '2021-02-10 07:36:59', '2021-02-10 07:36:59'),
(1912, 'bd', 'Price high to low', 'Price high to low', '2021-02-10 07:36:59', '2021-02-10 07:36:59'),
(1913, 'bd', 'Add New category', 'Add New category', '2021-02-11 03:05:45', '2021-02-11 03:05:45'),
(1914, 'bd', 'Parent Category', 'Parent Category', '2021-02-11 03:05:45', '2021-02-11 03:05:45'),
(1915, 'bd', 'Level', 'Level', '2021-02-11 03:05:45', '2021-02-11 03:05:45'),
(1916, 'bd', 'Banner', 'Banner', '2021-02-11 03:05:45', '2021-02-11 03:05:45'),
(1917, 'bd', 'Icon', 'Icon', '2021-02-11 03:05:45', '2021-02-11 03:05:45'),
(1918, 'bd', 'Commission', 'Commission', '2021-02-11 03:05:45', '2021-02-11 03:05:45'),
(1919, 'bd', 'Featured categories updated successfully', 'Featured categories updated successfully', '2021-02-11 03:05:45', '2021-02-11 03:05:45'),
(1920, 'bd', 'Category Information', 'Category Information', '2021-02-11 03:09:54', '2021-02-11 03:09:54'),
(1921, 'bd', 'Translatable', 'Translatable', '2021-02-11 03:09:54', '2021-02-11 03:09:54'),
(1922, 'bd', 'No Parent', 'No Parent', '2021-02-11 03:09:54', '2021-02-11 03:09:54'),
(1923, 'bd', 'Physical', 'Physical', '2021-02-11 03:09:54', '2021-02-11 03:09:54'),
(1924, 'bd', 'Digital', 'Digital', '2021-02-11 03:09:54', '2021-02-11 03:09:54'),
(1925, 'bd', '200x200', '200x200', '2021-02-11 03:09:54', '2021-02-11 03:09:54'),
(1926, 'bd', '32x32', '32x32', '2021-02-11 03:09:54', '2021-02-11 03:09:54'),
(1927, 'bd', 'Slug', 'Slug', '2021-02-11 03:09:54', '2021-02-11 03:09:54'),
(1928, 'bd', 'Category has been updated successfully', 'Category has been updated successfully', '2021-02-11 03:10:00', '2021-02-11 03:10:00'),
(1929, 'bd', 'Category has been inserted successfully', 'Category has been inserted successfully', '2021-02-11 03:10:57', '2021-02-11 03:10:57'),
(1930, 'bd', 'Add New Brand', 'Add New Brand', '2021-02-11 03:12:30', '2021-02-11 03:12:30'),
(1931, 'bd', '120x80', '120x80', '2021-02-11 03:12:30', '2021-02-11 03:12:30'),
(1932, 'bd', 'Brand Information', 'Brand Information', '2021-02-11 03:12:33', '2021-02-11 03:12:33'),
(1933, 'bd', 'Brand has been updated successfully', 'Brand has been updated successfully', '2021-02-11 03:12:43', '2021-02-11 03:12:43'),
(1934, 'bd', 'Product has been inserted successfully', 'Product has been inserted successfully', '2021-02-11 03:16:38', '2021-02-11 03:16:38'),
(1935, 'bd', 'times', 'times', '2021-02-11 03:16:39', '2021-02-11 03:16:39'),
(1936, 'bd', 'Duplicate', 'Duplicate', '2021-02-11 03:16:39', '2021-02-11 03:16:39'),
(1937, 'bd', 'Edit Product', 'Edit Product', '2021-02-11 03:17:17', '2021-02-11 03:17:17'),
(1938, 'bd', 'Type to add a tag', 'Type to add a tag', '2021-02-11 03:17:18', '2021-02-11 03:17:18'),
(1939, 'bd', 'Meta Images', 'Meta Images', '2021-02-11 03:17:18', '2021-02-11 03:17:18'),
(1940, 'bd', 'Update Product', 'Update Product', '2021-02-11 03:17:18', '2021-02-11 03:17:18'),
(1941, 'bd', 'Select File', 'Select File', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1942, 'bd', 'Upload New', 'Upload New', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1943, 'bd', 'Sort by newest', 'Sort by newest', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1944, 'bd', 'Sort by oldest', 'Sort by oldest', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1945, 'bd', 'Sort by smallest', 'Sort by smallest', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1946, 'bd', 'Sort by largest', 'Sort by largest', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1947, 'bd', 'Selected Only', 'Selected Only', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1948, 'bd', 'Search your files', 'Search your files', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1949, 'bd', 'No files found', 'No files found', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1950, 'bd', '0 File selected', '0 File selected', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1951, 'bd', 'Clear', 'Clear', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1952, 'bd', 'Prev', 'Prev', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1953, 'bd', 'Next', 'Next', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1954, 'bd', 'Add Files', 'Add Files', '2021-02-11 03:17:27', '2021-02-11 03:17:27'),
(1955, 'bd', 'Product has been updated successfully', 'Product has been updated successfully', '2021-02-11 03:17:52', '2021-02-11 03:17:52'),
(1956, 'bd', 'Copy', 'Copy', '2021-02-11 04:12:49', '2021-02-11 04:12:49'),
(1957, 'bd', 'Add to wishlist', 'Add to wishlist', '2021-02-11 06:14:48', '2021-02-11 06:14:48'),
(1958, 'bd', 'Add to compare', 'Add to compare', '2021-02-11 06:14:48', '2021-02-11 06:14:48'),
(1959, 'bd', 'Add to cart', 'Add to cart', '2021-02-11 06:14:48', '2021-02-11 06:14:48'),
(1960, 'bd', 'Club Point', 'Club Point', '2021-02-11 06:14:48', '2021-02-11 06:14:48'),
(1961, 'bd', 'Store Home', 'Store Home', '2021-02-11 06:36:18', '2021-02-11 06:36:18'),
(1962, 'bd', 'Top Selling', 'Top Selling', '2021-02-11 06:36:18', '2021-02-11 06:36:18'),
(1963, 'bd', 'New Arrival Products', 'New Arrival Products', '2021-02-11 06:36:18', '2021-02-11 06:36:18'),
(1964, 'bd', 'Seller Account', 'Seller Account', '2021-02-11 06:47:22', '2021-02-11 06:47:22'),
(1965, 'bd', 'Copy credentials', 'Copy credentials', '2021-02-11 06:47:22', '2021-02-11 06:47:22'),
(1966, 'bd', 'Customer Account', 'Customer Account', '2021-02-11 06:47:22', '2021-02-11 06:47:22'),
(1967, 'bd', 'Purchase History', 'Purchase History', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1968, 'bd', 'Downloads', 'Downloads', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1969, 'bd', 'Sent Refund Request', 'Sent Refund Request', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1970, 'bd', 'Product Bulk Upload', 'Product Bulk Upload', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1971, 'bd', 'Orders', 'Orders', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1972, 'bd', 'Received Refund Request', 'Received Refund Request', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1973, 'bd', 'Shop Setting', 'Shop Setting', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1974, 'bd', 'Money Withdraw', 'Money Withdraw', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1975, 'bd', 'Earning Points', 'Earning Points', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1976, 'bd', 'Support Ticket', 'Support Ticket', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1977, 'bd', 'Manage Profile', 'Manage Profile', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1978, 'bd', 'Sold Amount', 'Sold Amount', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1979, 'bd', 'Your sold amount (current month)', 'Your sold amount (current month)', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1980, 'bd', 'Total Sold', 'Total Sold', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1981, 'bd', 'Last Month Sold', 'Last Month Sold', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1982, 'bd', 'Total sale', 'Total sale', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1983, 'bd', 'Total earnings', 'Total earnings', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1984, 'bd', 'Successful orders', 'Successful orders', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1985, 'bd', 'Total orders', 'Total orders', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1986, 'bd', 'Pending orders', 'Pending orders', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1987, 'bd', 'Cancelled orders', 'Cancelled orders', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1988, 'bd', 'Purchased Package', 'Purchased Package', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1989, 'bd', 'Package Not Found', 'Package Not Found', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1990, 'bd', 'Upgrade Package', 'Upgrade Package', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1991, 'bd', 'Shop', 'Shop', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1992, 'bd', 'Manage & organize your shop', 'Manage & organize your shop', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1993, 'bd', 'Go to setting', 'Go to setting', '2021-02-11 06:47:29', '2021-02-11 06:47:29'),
(1994, 'bd', 'Payment', 'Payment', '2021-02-11 06:47:30', '2021-02-11 06:47:30'),
(1995, 'bd', 'Configure your payment method', 'Configure your payment method', '2021-02-11 06:47:30', '2021-02-11 06:47:30'),
(1996, 'bd', 'Item has been added to wishlist', 'Item has been added to wishlist', '2021-02-11 06:47:30', '2021-02-11 06:47:30'),
(1997, 'bd', 'Remaining Uploads', 'Remaining Uploads', '2021-02-11 06:48:02', '2021-02-11 06:48:02'),
(1998, 'bd', 'No Package Found', 'No Package Found', '2021-02-11 06:48:02', '2021-02-11 06:48:02'),
(1999, 'bd', 'Search product', 'Search product', '2021-02-11 06:48:02', '2021-02-11 06:48:02'),
(2000, 'bd', 'Current Qty', 'Current Qty', '2021-02-11 06:48:02', '2021-02-11 06:48:02'),
(2001, 'bd', 'Upload limit has been reached. Please upgrade your package.', 'Upload limit has been reached. Please upgrade your package.', '2021-02-11 06:48:06', '2021-02-11 06:48:06'),
(2002, 'bd', 'index', 'index', '2021-02-11 06:48:40', '2021-02-11 06:48:40'),
(2003, 'bd', 'Download Your Product', 'Download Your Product', '2021-02-11 06:48:40', '2021-02-11 06:48:40'),
(2004, 'bd', 'Option', 'Option', '2021-02-11 06:48:40', '2021-02-11 06:48:40'),
(2005, 'bd', 'Shop Settings', 'Shop Settings', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2006, 'bd', 'Visit Shop', 'Visit Shop', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2007, 'bd', 'Basic Info', 'Basic Info', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2008, 'bd', 'Shop Logo', 'Shop Logo', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2009, 'bd', 'Shop Address', 'Shop Address', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2010, 'bd', 'Banner Settings', 'Banner Settings', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2011, 'bd', 'Banners', 'Banners', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2012, 'bd', 'We had to limit height to maintian consistancy. In some device both side of the banner might be cropped for height limitation.', 'We had to limit height to maintian consistancy. In some device both side of the banner might be cropped for height limitation.', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2013, 'bd', 'Social Media Link', 'Social Media Link', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2014, 'bd', 'Facebook', 'Facebook', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2015, 'bd', 'Insert link with https ', 'Insert link with https ', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2016, 'bd', 'Twitter', 'Twitter', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2017, 'bd', 'Google', 'Google', '2021-02-11 06:49:17', '2021-02-11 06:49:17'),
(2018, 'bd', 'Create an account.', 'Create an account.', '2021-02-11 07:31:09', '2021-02-11 07:31:09'),
(2019, 'bd', 'Full Name', 'Full Name', '2021-02-11 07:31:09', '2021-02-11 07:31:09'),
(2020, 'bd', 'Use Email Instead', 'Use Email Instead', '2021-02-11 07:31:09', '2021-02-11 07:31:09'),
(2021, 'bd', 'Confirm Password', 'Confirm Password', '2021-02-11 07:31:09', '2021-02-11 07:31:09'),
(2022, 'bd', 'By signing up you agree to our terms and conditions.', 'By signing up you agree to our terms and conditions.', '2021-02-11 07:31:09', '2021-02-11 07:31:09'),
(2023, 'bd', 'Create Account', 'Create Account', '2021-02-11 07:31:09', '2021-02-11 07:31:09'),
(2024, 'bd', 'Already have an account?', 'Already have an account?', '2021-02-11 07:31:09', '2021-02-11 07:31:09'),
(2025, 'bd', 'Log In', 'Log In', '2021-02-11 07:31:09', '2021-02-11 07:31:09'),
(2026, 'bd', 'Use Phone Instead', 'Use Phone Instead', '2021-02-11 07:31:09', '2021-02-11 07:31:09'),
(2027, 'bd', 'Category has been deleted successfully', 'Category has been deleted successfully', '2021-02-11 07:43:15', '2021-02-11 07:43:15'),
(2028, 'bd', 'Website Pages', 'Website Pages', '2021-02-11 08:45:19', '2021-02-11 08:45:19'),
(2029, 'bd', 'All Pages', 'All Pages', '2021-02-11 08:45:19', '2021-02-11 08:45:19'),
(2030, 'bd', 'Add New Page', 'Add New Page', '2021-02-11 08:45:19', '2021-02-11 08:45:19'),
(2031, 'bd', 'URL', 'URL', '2021-02-11 08:45:19', '2021-02-11 08:45:19'),
(2032, 'bd', 'Home Page Settings', 'Home Page Settings', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2033, 'bd', 'Home Slider', 'Home Slider', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2034, 'bd', 'We have limited banner height to maintain UI. We had to crop from both left & right side in view for different devices to make it responsive. Before designing banner keep these points in mind.', 'We have limited banner height to maintain UI. We had to crop from both left & right side in view for different devices to make it responsive. Before designing banner keep these points in mind.', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2035, 'bd', 'Photos & Links', 'Photos & Links', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2036, 'bd', 'Add New', 'Add New', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2037, 'bd', 'Home Banner 1 (Max 3)', 'Home Banner 1 (Max 3)', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2038, 'bd', 'Banner & Links', 'Banner & Links', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2039, 'bd', 'Home Banner 2 (Max 3)', 'Home Banner 2 (Max 3)', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2040, 'bd', 'Home Banner horizontal', 'Home Banner horizontal', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2041, 'bd', 'Home Banner vertical', 'Home Banner vertical', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2042, 'bd', 'Home Banner square', 'Home Banner square', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2043, 'bd', 'Home Categories', 'Home Categories', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2044, 'bd', 'Home Banner 3 (Max 3)', 'Home Banner 3 (Max 3)', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2045, 'bd', 'Top 10', 'Top 10', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2046, 'bd', 'Top Categories (Max 10)', 'Top Categories (Max 10)', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2047, 'bd', 'Top Brands (Max 10)', 'Top Brands (Max 10)', '2021-02-11 08:46:08', '2021-02-11 08:46:08'),
(2048, 'bd', 'View More', 'View More', '2021-02-11 08:53:28', '2021-02-11 08:53:28'),
(2049, 'bd', 'reviews', 'reviews', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2050, 'bd', 'Out of stock', 'Out of stock', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2051, 'bd', 'Sold by', 'Sold by', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2052, 'bd', 'Inhouse product', 'Inhouse product', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2053, 'bd', 'Message Seller', 'Message Seller', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2054, 'bd', 'available', 'available', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2055, 'bd', 'Total Price', 'Total Price', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2056, 'bd', 'Refund', 'Refund', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2057, 'bd', 'Share', 'Share', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2058, 'bd', 'customer reviews', 'customer reviews', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2059, 'bd', 'Top Selling Products', 'Top Selling Products', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2060, 'bd', 'Download', 'Download', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2061, 'bd', 'There have been no reviews for this product yet.', 'There have been no reviews for this product yet.', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2062, 'bd', 'Related products', 'Related products', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2063, 'bd', 'Any query about this product', 'Any query about this product', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2064, 'bd', 'Your Question', 'Your Question', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2065, 'bd', 'Send', 'Send', '2021-02-11 08:53:50', '2021-02-11 08:53:50'),
(2066, 'bd', 'Variant', 'Variant', '2021-02-11 08:54:04', '2021-02-11 08:54:04'),
(2067, 'bd', 'Variant Price', 'Variant Price', '2021-02-11 08:54:04', '2021-02-11 08:54:04'),
(2068, 'bd', 'SKU', 'SKU', '2021-02-11 08:54:04', '2021-02-11 08:54:04'),
(2069, 'bd', 'In stock', 'In stock', '2021-02-11 08:54:14', '2021-02-11 08:54:14'),
(2070, 'bd', 'Color', 'Color', '2021-02-11 08:54:14', '2021-02-11 08:54:14'),
(2071, 'bd', 'Buy Now', 'Buy Now', '2021-02-11 08:54:15', '2021-02-11 08:54:15'),
(2072, 'bd', 'Your Name', 'Your Name', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2073, 'bd', 'Your Phone', 'Your Phone', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2074, 'bd', 'Your Password', 'Your Password', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2075, 'bd', 'New Password', 'New Password', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2076, 'bd', 'Add New Address', 'Add New Address', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2077, 'bd', 'Payment Setting', 'Payment Setting', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2078, 'bd', 'Cash Payment', 'Cash Payment', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2079, 'bd', 'Bank Name', 'Bank Name', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2080, 'bd', 'Bank Account Name', 'Bank Account Name', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2081, 'bd', 'Bank Account Number', 'Bank Account Number', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2082, 'bd', 'Bank Routing Number', 'Bank Routing Number', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2083, 'bd', 'Update Profile', 'Update Profile', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2084, 'bd', 'Change your email', 'Change your email', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2085, 'bd', 'Your Email', 'Your Email', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2086, 'bd', 'Sending Email...', 'Sending Email...', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2087, 'bd', 'Verify', 'Verify', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2088, 'bd', 'Update Email', 'Update Email', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2089, 'bd', 'New Address', 'New Address', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2090, 'bd', 'Your Address', 'Your Address', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2091, 'bd', 'Select your country', 'Select your country', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2092, 'bd', 'Your City', 'Your City', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2093, 'bd', 'Your Postal Code', 'Your Postal Code', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2094, 'bd', '+880', '+880', '2021-02-11 09:17:57', '2021-02-11 09:17:57'),
(2095, 'bd', 'All Attributes', 'All Attributes', '2021-02-11 09:20:00', '2021-02-11 09:20:00'),
(2096, 'bd', 'Add New Attribute', 'Add New Attribute', '2021-02-11 09:20:01', '2021-02-11 09:20:01'),
(2097, 'bd', 'Attribute Information', 'Attribute Information', '2021-02-11 09:20:09', '2021-02-11 09:20:09'),
(2098, 'bd', 'Attribute has been inserted successfully', 'Attribute has been inserted successfully', '2021-02-11 09:23:07', '2021-02-11 09:23:07'),
(2099, 'bd', 'Product has been deleted successfully', 'Product has been deleted successfully', '2021-02-11 10:30:56', '2021-02-11 10:30:56'),
(2100, 'bd', 'Product has been duplicated successfully', 'Product has been duplicated successfully', '2021-02-11 10:32:08', '2021-02-11 10:32:08'),
(2101, 'bd', 'Brand has been inserted successfully', 'Brand has been inserted successfully', '2021-02-11 10:41:22', '2021-02-11 10:41:22'),
(2102, 'bd', 'Attribute has been deleted successfully', 'Attribute has been deleted successfully', '2021-02-11 10:57:17', '2021-02-11 10:57:17'),
(2103, 'bd', 'Invalid email or password', 'Invalid email or password', '2021-02-11 10:58:46', '2021-02-11 10:58:46'),
(2104, 'bd', 'Discount Price', 'Discount Price', '2021-02-11 11:05:46', '2021-02-11 11:05:46'),
(2105, 'bd', 'Item added to your cart!', 'Item added to your cart!', '2021-02-11 11:23:52', '2021-02-11 11:23:52'),
(2106, 'bd', 'Back to shopping', 'Back to shopping', '2021-02-11 11:23:52', '2021-02-11 11:23:52'),
(2107, 'bd', 'Proceed to Checkout', 'Proceed to Checkout', '2021-02-11 11:23:52', '2021-02-11 11:23:52'),
(2108, 'bd', 'Cart Items', 'Cart Items', '2021-02-11 11:23:52', '2021-02-11 11:23:52'),
(2109, 'bd', 'View cart', 'View cart', '2021-02-11 11:23:52', '2021-02-11 11:23:52'),
(2110, 'bd', 'Checkout', 'Checkout', '2021-02-11 11:23:52', '2021-02-11 11:23:52'),
(2111, 'bd', 'Comparison', 'Comparison', '2021-02-11 12:37:11', '2021-02-11 12:37:11'),
(2112, 'bd', 'Reset Compare List', 'Reset Compare List', '2021-02-11 12:37:11', '2021-02-11 12:37:11'),
(2113, 'bd', 'Your comparison list is empty', 'Your comparison list is empty', '2021-02-11 12:37:11', '2021-02-11 12:37:11'),
(2114, 'bd', 'in your cart', 'in your cart', '2021-02-11 13:21:21', '2021-02-11 13:21:21'),
(2115, 'bd', 'Product(s)', 'Product(s)', '2021-02-11 13:21:21', '2021-02-11 13:21:21'),
(2116, 'bd', 'in your wishlist', 'in your wishlist', '2021-02-11 13:21:21', '2021-02-11 13:21:21'),
(2117, 'bd', 'you ordered', 'you ordered', '2021-02-11 13:21:21', '2021-02-11 13:21:21'),
(2118, 'bd', 'Default Shipping Address', 'Default Shipping Address', '2021-02-11 13:21:21', '2021-02-11 13:21:21'),
(2119, 'bd', 'Applied Refund Request', 'Applied Refund Request', '2021-02-11 13:21:49', '2021-02-11 13:21:49'),
(2120, 'bd', 'Order id', 'Order id', '2021-02-11 13:21:49', '2021-02-11 13:21:49'),
(2121, 'bd', 'Affiliate', 'Affiliate', '2021-02-11 13:22:05', '2021-02-11 13:22:05'),
(2122, 'bd', 'Affiliate Balance', 'Affiliate Balance', '2021-02-11 13:22:05', '2021-02-11 13:22:05'),
(2123, 'bd', 'Configure Payout', 'Configure Payout', '2021-02-11 13:22:05', '2021-02-11 13:22:05'),
(2124, 'bd', 'Copied', 'Copied', '2021-02-11 13:22:05', '2021-02-11 13:22:05'),
(2125, 'bd', 'Copy Url', 'Copy Url', '2021-02-11 13:22:05', '2021-02-11 13:22:05'),
(2126, 'bd', 'Affiliate payment history', 'Affiliate payment history', '2021-02-11 13:22:05', '2021-02-11 13:22:05'),
(2127, 'bd', 'Affiliate withdraw request history', 'Affiliate withdraw request history', '2021-02-11 13:22:05', '2021-02-11 13:22:05'),
(2128, 'bd', 'Filter by', 'Filter by', '2021-02-11 13:25:26', '2021-02-11 13:25:26'),
(2129, 'bd', 'Select variation', 'Select variation', '2021-02-11 15:43:17', '2021-02-11 15:43:17'),
(2130, 'bd', 'Step 1', 'Step 1', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2131, 'bd', 'Download the skeleton file and fill it with proper data', 'Download the skeleton file and fill it with proper data', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2132, 'bd', 'You can download the example file to understand how the data must be filled', 'You can download the example file to understand how the data must be filled', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2133, 'bd', 'Once you have downloaded and filled the skeleton file, upload it in the form below and submit', 'Once you have downloaded and filled the skeleton file, upload it in the form below and submit', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2134, 'bd', 'After uploading products you need to edit them and set product\'s images and choices', 'After uploading products you need to edit them and set product\'s images and choices', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2135, 'bd', 'Download CSV', 'Download CSV', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2136, 'bd', 'Step 2', 'Step 2', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2137, 'bd', 'Category and Brand should be in numerical id', 'Category and Brand should be in numerical id', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2138, 'bd', 'You can download the pdf to get Category and Brand id', 'You can download the pdf to get Category and Brand id', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2139, 'bd', 'Download Category', 'Download Category', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2140, 'bd', 'Download Brand', 'Download Brand', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2141, 'bd', 'Upload Product File', 'Upload Product File', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2142, 'bd', 'Upload CSV', 'Upload CSV', '2021-02-11 15:44:13', '2021-02-11 15:44:13'),
(2143, 'bd', 'Filter by Rating', 'Filter by Rating', '2021-02-11 15:45:14', '2021-02-11 15:45:14'),
(2144, 'bd', 'Comment', 'Comment', '2021-02-11 15:45:14', '2021-02-11 15:45:14'),
(2145, 'bd', 'Published reviews updated successfully', 'Published reviews updated successfully', '2021-02-11 15:45:14', '2021-02-11 15:45:14'),
(2146, 'bd', 'System Name', 'System Name', '2021-02-11 15:45:55', '2021-02-11 15:45:55'),
(2147, 'bd', 'System Logo - White', 'System Logo - White', '2021-02-11 15:45:55', '2021-02-11 15:45:55'),
(2148, 'bd', 'Choose Files', 'Choose Files', '2021-02-11 15:45:55', '2021-02-11 15:45:55'),
(2149, 'bd', 'Will be used in admin panel side menu', 'Will be used in admin panel side menu', '2021-02-11 15:45:55', '2021-02-11 15:45:55'),
(2150, 'bd', 'System Logo - Black', 'System Logo - Black', '2021-02-11 15:45:55', '2021-02-11 15:45:55'),
(2151, 'bd', 'Will be used in admin panel topbar in mobile + Admin login page', 'Will be used in admin panel topbar in mobile + Admin login page', '2021-02-11 15:45:55', '2021-02-11 15:45:55'),
(2152, 'bd', 'System Timezone', 'System Timezone', '2021-02-11 15:45:55', '2021-02-11 15:45:55'),
(2153, 'bd', 'Admin login page background', 'Admin login page background', '2021-02-11 15:45:55', '2021-02-11 15:45:55'),
(2154, 'bd', 'Website Header', 'Website Header', '2021-02-11 15:46:17', '2021-02-11 15:46:17'),
(2155, 'bd', 'Header Setting', 'Header Setting', '2021-02-11 15:46:17', '2021-02-11 15:46:17'),
(2156, 'bd', 'Header Logo', 'Header Logo', '2021-02-11 15:46:17', '2021-02-11 15:46:17'),
(2157, 'bd', 'Show Language Switcher?', 'Show Language Switcher?', '2021-02-11 15:46:18', '2021-02-11 15:46:18'),
(2158, 'bd', 'Show Currency Switcher?', 'Show Currency Switcher?', '2021-02-11 15:46:18', '2021-02-11 15:46:18'),
(2159, 'bd', 'Enable stikcy header?', 'Enable stikcy header?', '2021-02-11 15:46:18', '2021-02-11 15:46:18'),
(2160, 'bd', 'Website Footer', 'Website Footer', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2161, 'bd', 'Footer Widget', 'Footer Widget', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2162, 'bd', 'About Widget', 'About Widget', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2163, 'bd', 'Footer Logo', 'Footer Logo', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2164, 'bd', 'About description', 'About description', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2165, 'bd', 'Contact Info Widget', 'Contact Info Widget', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2166, 'bd', 'Contact address', 'Contact address', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2167, 'bd', 'Contact phone', 'Contact phone', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2168, 'bd', 'Contact email', 'Contact email', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2169, 'bd', 'Link Widget One', 'Link Widget One', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2170, 'bd', 'Links', 'Links', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2171, 'bd', 'Footer Bottom', 'Footer Bottom', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2172, 'bd', 'Copyright Widget ', 'Copyright Widget ', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2173, 'bd', 'Copyright Text', 'Copyright Text', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2174, 'bd', 'Social Link Widget ', 'Social Link Widget ', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2175, 'bd', 'Show Social Links?', 'Show Social Links?', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2176, 'bd', 'Social Links', 'Social Links', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2177, 'bd', 'Payment Methods Widget ', 'Payment Methods Widget ', '2021-02-11 15:46:25', '2021-02-11 15:46:25'),
(2178, 'bd', 'Select Shipping Method', 'Select Shipping Method', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2179, 'bd', 'Product Wise Shipping Cost', 'Product Wise Shipping Cost', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2180, 'bd', 'Flat Rate Shipping Cost', 'Flat Rate Shipping Cost', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2181, 'bd', 'Seller Wise Flat Shipping Cost', 'Seller Wise Flat Shipping Cost', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2182, 'bd', 'Area Wise Flat Shipping Cost', 'Area Wise Flat Shipping Cost', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2183, 'bd', 'Product Wise Shipping Cost calulation: Shipping cost is calculate by addition of each product shipping cost', 'Product Wise Shipping Cost calulation: Shipping cost is calculate by addition of each product shipping cost', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2184, 'bd', 'Flat Rate Shipping Cost calulation: How many products a customer purchase, doesn\'t matter. Shipping cost is fixed', 'Flat Rate Shipping Cost calulation: How many products a customer purchase, doesn\'t matter. Shipping cost is fixed', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2185, 'bd', 'Seller Wise Flat Shipping Cost calulation: Fixed rate for each seller. If customers purchase 2 product from two seller shipping cost is calculated by addition of each seller flat shipping cost', 'Seller Wise Flat Shipping Cost calulation: Fixed rate for each seller. If customers purchase 2 product from two seller shipping cost is calculated by addition of each seller flat shipping cost', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2186, 'bd', 'Area Wise Flat Shipping Cost calulation: Fixed rate for each area. If customers purchase multiple products from one seller shipping cost is calculated by the customer shipping area. To configure area wise shipping cost go to ', 'Area Wise Flat Shipping Cost calulation: Fixed rate for each area. If customers purchase multiple products from one seller shipping cost is calculated by the customer shipping area. To configure area wise shipping cost go to ', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2187, 'bd', 'Flat Rate Cost', 'Flat Rate Cost', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2188, 'bd', '1. Flat rate shipping cost is applicable if Flat rate shipping is enabled.', '1. Flat rate shipping cost is applicable if Flat rate shipping is enabled.', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2189, 'bd', 'Shipping Cost for Admin Products', 'Shipping Cost for Admin Products', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2190, 'bd', '1. Shipping cost for admin is applicable if Seller wise shipping cost is enabled.', '1. Shipping cost for admin is applicable if Seller wise shipping cost is enabled.', '2021-02-11 15:46:51', '2021-02-11 15:46:51'),
(2191, 'bd', 'All Flash Deals', 'All Flash Deals', '2021-02-11 15:47:57', '2021-02-11 15:47:57'),
(2192, 'bd', 'Create New Flash Deal', 'Create New Flash Deal', '2021-02-11 15:47:57', '2021-02-11 15:47:57'),
(2193, 'bd', 'Start Date', 'Start Date', '2021-02-11 15:47:57', '2021-02-11 15:47:57'),
(2194, 'bd', 'End Date', 'End Date', '2021-02-11 15:47:57', '2021-02-11 15:47:57'),
(2195, 'bd', 'Page Link', 'Page Link', '2021-02-11 15:47:57', '2021-02-11 15:47:57'),
(2196, 'bd', 'All Customers', 'All Customers', '2021-02-11 15:48:37', '2021-02-11 15:48:37'),
(2197, 'bd', 'Type email or name & Enter', 'Type email or name & Enter', '2021-02-11 15:48:37', '2021-02-11 15:48:37'),
(2198, 'bd', 'Wallet Balance', 'Wallet Balance', '2021-02-11 15:48:37', '2021-02-11 15:48:37'),
(2199, 'bd', 'Log in as this Customer', 'Log in as this Customer', '2021-02-11 15:48:37', '2021-02-11 15:48:37'),
(2200, 'bd', 'Ban this Customer', 'Ban this Customer', '2021-02-11 15:48:37', '2021-02-11 15:48:37'),
(2201, 'bd', 'Do you really want to ban this Customer?', 'Do you really want to ban this Customer?', '2021-02-11 15:48:37', '2021-02-11 15:48:37'),
(2202, 'bd', 'Do you really want to unban this Customer?', 'Do you really want to unban this Customer?', '2021-02-11 15:48:37', '2021-02-11 15:48:37'),
(2203, 'bd', 'All uploaded files', 'All uploaded files', '2021-02-11 15:48:45', '2021-02-11 15:48:45'),
(2204, 'bd', 'Upload New File', 'Upload New File', '2021-02-11 15:48:45', '2021-02-11 15:48:45'),
(2205, 'bd', 'All files', 'All files', '2021-02-11 15:48:45', '2021-02-11 15:48:45'),
(2206, 'bd', 'Search', 'Search', '2021-02-11 15:48:45', '2021-02-11 15:48:45'),
(2207, 'bd', 'Details Info', 'Details Info', '2021-02-11 15:48:45', '2021-02-11 15:48:45'),
(2208, 'bd', 'Copy Link', 'Copy Link', '2021-02-11 15:48:45', '2021-02-11 15:48:45'),
(2209, 'bd', 'Are you sure to delete this file?', 'Are you sure to delete this file?', '2021-02-11 15:48:46', '2021-02-11 15:48:46'),
(2210, 'bd', 'File Info', 'File Info', '2021-02-11 15:48:46', '2021-02-11 15:48:46'),
(2211, 'bd', 'Link copied to clipboard', 'Link copied to clipboard', '2021-02-11 15:48:46', '2021-02-11 15:48:46'),
(2212, 'bd', 'Oops, unable to copy', 'Oops, unable to copy', '2021-02-11 15:48:46', '2021-02-11 15:48:46'),
(2213, 'bd', 'Your order has been placed successfully', 'Your order has been placed successfully', '2021-02-12 12:28:21', '2021-02-12 12:28:21'),
(2214, 'bd', 'new orders', 'new orders', '2021-02-12 12:34:20', '2021-02-12 12:34:20'),
(2215, 'bd', 'Filter by date', 'Filter by date', '2021-02-12 12:34:25', '2021-02-12 12:34:25'),
(2216, 'bd', 'Type Order code & hit Enter', 'Type Order code & hit Enter', '2021-02-12 12:34:25', '2021-02-12 12:34:25'),
(2217, 'bd', 'Order Code', 'Order Code', '2021-02-12 12:34:25', '2021-02-12 12:34:25'),
(2218, 'bd', 'Delivery Status', 'Delivery Status', '2021-02-12 12:34:25', '2021-02-12 12:34:25'),
(2219, 'bd', 'Payment Status', 'Payment Status', '2021-02-12 12:34:25', '2021-02-12 12:34:25'),
(2220, 'bd', 'Pending', 'Pending', '2021-02-12 12:34:25', '2021-02-12 12:34:25'),
(2221, 'bd', 'Unpaid', 'Unpaid', '2021-02-12 12:34:25', '2021-02-12 12:34:25'),
(2222, 'bd', 'No Refund', 'No Refund', '2021-02-12 12:34:25', '2021-02-12 12:34:25'),
(2223, 'bd', 'View', 'View', '2021-02-12 12:34:25', '2021-02-12 12:34:25'),
(2224, 'bd', 'Download Invoice', 'Download Invoice', '2021-02-12 12:34:25', '2021-02-12 12:34:25'),
(2225, 'bd', 'Delivered', 'Delivered', '2021-02-12 12:34:25', '2021-02-12 12:34:25'),
(2226, 'bd', 'Order Details', 'Order Details', '2021-02-12 12:34:32', '2021-02-12 12:34:32'),
(2227, 'bd', 'Paid', 'Paid', '2021-02-12 12:34:32', '2021-02-12 12:34:32'),
(2228, 'bd', 'Confirmed', 'Confirmed', '2021-02-12 12:34:32', '2021-02-12 12:34:32'),
(2229, 'bd', 'On delivery', 'On delivery', '2021-02-12 12:34:32', '2021-02-12 12:34:32'),
(2230, 'bd', 'Order #', 'Order #', '2021-02-12 12:34:32', '2021-02-12 12:34:32'),
(2231, 'bd', 'Order Status', 'Order Status', '2021-02-12 12:34:32', '2021-02-12 12:34:32'),
(2232, 'bd', 'Order Date', 'Order Date', '2021-02-12 12:34:32', '2021-02-12 12:34:32'),
(2233, 'bd', 'Total amount', 'Total amount', '2021-02-12 12:34:32', '2021-02-12 12:34:32'),
(2234, 'bd', 'Delivery Type', 'Delivery Type', '2021-02-12 12:34:32', '2021-02-12 12:34:32'),
(2235, 'bd', 'Delivery status has been updated', 'Delivery status has been updated', '2021-02-12 12:34:32', '2021-02-12 12:34:32'),
(2236, 'bd', 'Payment status has been updated', 'Payment status has been updated', '2021-02-12 12:34:32', '2021-02-12 12:34:32'),
(2237, 'bd', 'Currency changed to ', 'Currency changed to ', '2021-02-12 16:37:45', '2021-02-12 16:37:45'),
(2238, 'bd', '1. My Cart', '1. My Cart', '2021-02-12 16:38:15', '2021-02-12 16:38:15'),
(2239, 'bd', '2. Shipping info', '2. Shipping info', '2021-02-12 16:38:15', '2021-02-12 16:38:15'),
(2240, 'bd', '3. Delivery info', '3. Delivery info', '2021-02-12 16:38:15', '2021-02-12 16:38:15'),
(2241, 'bd', '4. Payment', '4. Payment', '2021-02-12 16:38:15', '2021-02-12 16:38:15'),
(2242, 'bd', '5. Confirmation', '5. Confirmation', '2021-02-12 16:38:15', '2021-02-12 16:38:15'),
(2243, 'bd', 'Return to shop', 'Return to shop', '2021-02-12 16:38:15', '2021-02-12 16:38:15'),
(2244, 'bd', 'Continue to Shipping', 'Continue to Shipping', '2021-02-12 16:38:15', '2021-02-12 16:38:15'),
(2245, 'bd', 'Or', 'Or', '2021-02-12 16:38:15', '2021-02-12 16:38:15'),
(2246, 'bd', 'Guest Checkout', 'Guest Checkout', '2021-02-12 16:38:15', '2021-02-12 16:38:15'),
(2247, 'bd', 'Default Language', 'Default Language', '2021-02-13 03:55:32', '2021-02-13 03:55:32'),
(2248, 'bd', 'Add New Language', 'Add New Language', '2021-02-13 03:55:32', '2021-02-13 03:55:32'),
(2249, 'bd', 'Code', 'Code', '2021-02-13 03:55:32', '2021-02-13 03:55:32'),
(2250, 'bd', 'RTL', 'RTL', '2021-02-13 03:55:32', '2021-02-13 03:55:32'),
(2251, 'bd', 'Translation', 'Translation', '2021-02-13 03:55:32', '2021-02-13 03:55:32'),
(2252, 'bd', 'Language Information', 'Language Information', '2021-02-13 03:55:50', '2021-02-13 03:55:50'),
(2253, 'bd', 'Language has been inserted successfully', 'Language has been inserted successfully', '2021-02-13 03:56:22', '2021-02-13 03:56:22'),
(2254, 'bd', 'Type key & Enter', 'Type key & Enter', '2021-02-13 03:56:38', '2021-02-13 03:56:38'),
(2255, 'bd', 'Key', 'Key', '2021-02-13 03:56:38', '2021-02-13 03:56:38'),
(2256, 'bd', 'Value', 'Value', '2021-02-13 03:56:38', '2021-02-13 03:56:38'),
(2257, 'bd', 'Copy Translations', 'Copy Translations', '2021-02-13 03:56:38', '2021-02-13 03:56:38'),
(2258, 'bd', 'Default language can not be deleted', 'Default language can not be deleted', '2021-02-13 03:58:14', '2021-02-13 03:58:14'),
(2259, 'bd', 'Language has been deleted successfully', 'Language has been deleted successfully', '2021-02-13 03:58:31', '2021-02-13 03:58:31'),
(2260, 'bd', 'RTL status updated successfully', 'RTL status updated successfully', '2021-02-13 03:58:59', '2021-02-13 03:58:59'),
(2261, 'bd', 'System Default Currency', 'System Default Currency', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2262, 'bd', 'Set Currency Formats', 'Set Currency Formats', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2263, 'bd', 'Symbol Format', 'Symbol Format', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2264, 'bd', 'Decimal Separator', 'Decimal Separator', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2265, 'bd', 'No of decimals', 'No of decimals', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2266, 'bd', 'All Currencies', 'All Currencies', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2267, 'bd', 'Add New Currency', 'Add New Currency', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2268, 'bd', 'Currency name', 'Currency name', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2269, 'bd', 'Currency symbol', 'Currency symbol', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2270, 'bd', 'Currency code', 'Currency code', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2271, 'bd', 'Exchange rate', 'Exchange rate', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2272, 'bd', 'Currency Status updated successfully', 'Currency Status updated successfully', '2021-02-13 04:03:32', '2021-02-13 04:03:32'),
(2273, 'bd', 'Update Currency', 'Update Currency', '2021-02-13 04:03:46', '2021-02-13 04:03:46'),
(2274, 'bd', 'Symbol', 'Symbol', '2021-02-13 04:03:46', '2021-02-13 04:03:46'),
(2275, 'ru', 'Page Not Found!', 'Страница не найдена!', '2021-02-13 04:18:58', '2021-02-13 04:21:06'),
(2276, 'ru', 'The page you are looking for has not been found on our server.', 'Страница, которую вы ищете, не найдена на нашем сервере.', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2277, 'ru', 'Something went wrong!', 'Что-то пошло не так!', '2021-02-13 04:18:58', '2021-02-13 04:40:49'),
(2278, 'ru', 'Sorry for the inconvenience, but we\'re working on it.', 'Приносим извинения за неудобства, но мы над этим работаем.', '2021-02-13 04:18:58', '2021-02-13 04:40:49'),
(2279, 'ru', 'Error code', 'Код ошибки', '2021-02-13 04:18:58', '2021-02-13 04:40:49'),
(2280, 'ru', 'Login', 'Авторизоваться', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2281, 'ru', 'Registration', 'Постановка на учет', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2282, 'ru', 'I am shopping for...', 'Я покупаю ...', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2283, 'ru', 'Compare', 'Сравнивать', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2284, 'ru', 'Wishlist', 'Список желаний', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2285, 'ru', 'Cart', 'Корзина', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2286, 'ru', 'Your Cart is empty', 'Ваша корзина пуста', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2287, 'ru', 'Categories', 'Категории', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2288, 'ru', 'See All', 'Увидеть все', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2289, 'ru', 'Terms & conditions', 'Условия и положения', '2021-02-13 04:18:58', '2021-02-13 04:32:52'),
(2290, 'ru', 'Return Policy', 'Политика возврата', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2291, 'ru', 'Support Policy', 'Политика поддержки', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2292, 'ru', 'Privacy Policy', 'Политика конфиденциальности', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2293, 'ru', 'Your Email Address', 'Ваш адрес электронной почты', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2294, 'ru', 'Subscribe', 'Подписаться', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2295, 'ru', 'Contact Info', 'Контактная информация', '2021-02-13 04:18:58', '2021-02-13 04:40:19');
INSERT INTO `translations` (`id`, `lang`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(2296, 'ru', 'Address', 'Адрес', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2297, 'ru', 'Phone', 'Телефон', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2298, 'ru', 'Email', 'Электронное письмо', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2299, 'ru', 'My Account', 'Мой счет', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2300, 'ru', 'Order History', 'История заказов', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2301, 'ru', 'My Wishlist', 'мой список желаний', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2302, 'ru', 'Track Order', 'Отследить заказ', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2303, 'ru', 'Be a Seller', 'Быть продавцом', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2304, 'ru', 'Apply Now', 'Применить сейчас', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2305, 'ru', 'Confirmation', 'Подтверждение', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2306, 'ru', 'Delete confirmation message', 'Удалить подтверждающее сообщение', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2307, 'ru', 'Cancel', 'Отмена', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2308, 'ru', 'Delete', 'Удалить', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2309, 'ru', 'Item has been added to compare list', 'Товар добавлен в список сравнения', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2310, 'ru', 'Please login first', 'Пожалуйста, войдите сначала', '2021-02-13 04:18:58', '2021-02-13 04:40:19'),
(2311, 'ru', 'Welcome to', NULL, '2021-02-13 04:18:58', '2021-02-13 04:18:58'),
(2312, 'ru', 'Login to your account.', 'Вход в свой аккаунт.', '2021-02-13 04:18:58', '2021-02-13 04:33:14'),
(2313, 'ru', 'Password', NULL, '2021-02-13 04:18:58', '2021-02-13 04:18:58'),
(2314, 'ru', 'Remember Me', 'Запомните меня', '2021-02-13 04:18:58', '2021-02-13 04:33:14'),
(2315, 'ru', 'Top 10 Categories', '10 самых популярных категорий', '2021-02-13 04:18:58', '2021-02-13 04:32:52'),
(2316, 'ru', 'View All Categories', 'Просмотреть все категории', '2021-02-13 04:18:58', '2021-02-13 04:32:52'),
(2317, 'ru', 'Top 10 Brands', '10 лучших брендов', '2021-02-13 04:18:58', '2021-02-13 04:32:52'),
(2318, 'ru', 'View All Brands', 'Просмотреть все бренды', '2021-02-13 04:18:58', '2021-02-13 04:32:52'),
(2319, 'ru', 'Featured Products', 'Рекомендуемые товары', '2021-02-13 04:18:58', '2021-02-13 04:32:52'),
(2320, 'ru', 'Best Selling', 'Лучшие продажи', '2021-02-13 04:18:58', '2021-02-13 04:32:52'),
(2321, 'ru', 'Top 20', '20 лучших', '2021-02-13 04:18:58', '2021-02-13 04:32:52'),
(2322, 'ru', 'Best Sellers', 'Бестселлеры', '2021-02-13 04:18:58', '2021-02-13 04:32:52'),
(2323, 'ru', 'Visit Store', 'Посетить магазин', '2021-02-13 04:18:58', '2021-02-13 04:32:52'),
(2324, 'ru', 'Please Configure SMTP Setting to work all email sending functionality', 'Настройте параметры SMTP для работы всех функций отправки электронной почты', '2021-02-13 04:18:58', '2021-02-13 04:40:49'),
(2325, 'bd', 'Translations updated for ', 'Translations updated for ', '2021-02-13 04:18:58', '2021-02-13 04:18:58'),
(2326, 'en', 'Language has been deleted successfully', 'Language has been deleted successfully', '2021-02-13 04:24:33', '2021-02-13 04:24:33'),
(2327, 'en', 'Please Configure SMTP Setting to work all email sending functionality', 'Please Configure SMTP Setting to work all email sending functionality', '2021-02-13 04:24:43', '2021-02-13 04:24:43'),
(2328, 'en', 'Order', 'Order', '2021-02-13 04:24:43', '2021-02-13 04:24:43'),
(2329, 'en', 'update Language Info', 'update Language Info', '2021-02-13 04:32:11', '2021-02-13 04:32:11'),
(2330, 'en', 'Type key & Enter', 'Type key & Enter', '2021-02-13 04:32:21', '2021-02-13 04:32:21'),
(2331, 'ru', 'All Category', 'Все категории', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2332, 'ru', 'All', 'Все', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2333, 'ru', 'Flash Sale', 'Флэш-распродажа', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2334, 'ru', 'View More', 'Посмотреть больше', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2335, 'ru', 'Add to wishlist', 'Добавить в список желаний', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2336, 'ru', 'Add to compare', 'Добавить к сравнению', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2337, 'ru', 'Add to cart', 'Добавить в корзину', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2338, 'ru', 'Club Point', 'Club Point', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2339, 'ru', 'Classified Ads', 'Доска объявлений', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2340, 'ru', 'Used', 'Использовал', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2341, 'ru', 'Popular Suggestions', 'Популярные предложения', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2342, 'ru', 'Category Suggestions', 'Предложения по категориям', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2343, 'ru', 'Automobile & Motorcycle', 'Автомобиль и мотоцикл', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2344, 'ru', 'Price range', 'Ценовой диапазон', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2345, 'ru', 'Filter by color', 'Фильтр по цвету', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2346, 'ru', 'Home', 'Дома', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2347, 'ru', 'Newest', 'Новейшие', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2348, 'ru', 'Oldest', 'Самый старый', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2349, 'ru', 'Price low to high', 'Цена от низкой к высокой', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2350, 'ru', 'Price high to low', 'Цена по убыванию', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2351, 'ru', 'Brands', 'Бренды', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2352, 'ru', 'All Brands', 'Все бренды', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2353, 'ru', 'All Sellers', 'Все продавцы', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2354, 'ru', 'Inhouse product', 'Собственный продукт', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2355, 'ru', 'Message Seller', 'Сообщение Продавцу', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2356, 'ru', 'Price', 'Цена', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2357, 'ru', 'Discount Price', 'Цена со скидкой', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2358, 'ru', 'Color', 'Цвет', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2359, 'ru', 'Quantity', 'Количество', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2360, 'ru', 'available', 'имеется в наличии', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2361, 'ru', 'Total Price', 'Итоговая цена', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2362, 'ru', 'Out of Stock', 'Распродано', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2363, 'ru', 'Refund', 'Возврат', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2364, 'ru', 'Share', 'доля', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2365, 'ru', 'Sold By', 'Продан', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2366, 'ru', 'customer reviews', 'Отзывы клиентов', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2367, 'ru', 'Top Selling Products', 'Самые продаваемые товары', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2368, 'ru', 'Description', 'Описание', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2369, 'ru', 'Video', 'Video', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2370, 'ru', 'Reviews', 'Отзывы', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2371, 'en', 'Translations updated for ', 'Translations updated for ', '2021-02-13 04:32:52', '2021-02-13 04:32:52'),
(2372, 'ru', 'Download', 'Скачать', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2373, 'ru', 'There have been no reviews for this product yet.', 'Еще нет отзывов об этом продукте.', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2374, 'ru', 'Related products', 'Сопутствующие товары', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2375, 'ru', 'Any query about this product', 'Любой запрос об этом продукте', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2376, 'ru', 'Product Name', 'наименование товара', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2377, 'ru', 'Your Question', 'Ваш вопрос', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2378, 'ru', 'Send', 'послать', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2379, 'ru', 'Use country code before number', 'Используйте код страны перед номером', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2380, 'ru', 'Dont have an account?', 'Нет учетной записи?', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2381, 'ru', 'Register Now', 'Зарегистрируйтесь сейчас', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2382, 'ru', 'Or Login With', 'Или войдите с помощью', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2383, 'ru', 'oops..', 'ой ..', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2384, 'ru', 'This item is out of stock!', 'Этого товара нет в наличии!', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2385, 'ru', 'Back to shopping', 'Вернуться к покупкам', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2386, 'ru', 'Purchase History', 'История покупки', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2387, 'ru', 'New', 'Новый', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2388, 'ru', 'Downloads', 'Загрузки', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2389, 'ru', 'Sent Refund Request', 'Отправлен запрос на возврат', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2390, 'ru', 'Product Bulk Upload', 'Массовая загрузка продукта', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2391, 'ru', 'Orders', 'Заказы', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2392, 'ru', 'Recieved Refund Request', 'Получен запрос на возврат', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2393, 'ru', 'Shop Setting', 'Настройка магазина', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2394, 'ru', 'Payment History', 'История платежей', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2395, 'ru', 'Money Withdraw', 'Вывод денег', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2396, 'ru', 'Conversations', 'Разговоры', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2397, 'ru', 'My Wallet', 'Мой бумажник', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2398, 'ru', 'Earning Points', 'Заработок баллов', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2399, 'ru', 'Support Ticket', 'Билет в службу поддержки', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2400, 'ru', 'Manage Profile', 'Управление профилем', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2401, 'ru', 'Sold Amount', 'Проданная сумма', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2402, 'ru', 'Your sold amount (current month)', 'Ваша проданная сумма (текущий месяц)', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2403, 'ru', 'Total Sold', 'Всего продано', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2404, 'ru', 'Last Month Sold', 'Продано за последний месяц', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2405, 'ru', 'Total sale', 'Всего распродажа', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2406, 'ru', 'Total earnings', 'Общий доход', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2407, 'ru', 'Successful orders', 'Успешные заказы', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2408, 'ru', 'Total orders', 'Всего заказов', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2409, 'ru', 'Pending orders', 'Заказы в ожидании', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2410, 'ru', 'Cancelled orders', 'Отмененные заказы', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2411, 'ru', 'Product', 'Товар', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2412, 'ru', 'Purchased Package', 'Купленный пакет', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2413, 'ru', 'Package Not Found', 'Пакет не найден', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2414, 'ru', 'Upgrade Package', 'Пакет обновления', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2415, 'ru', 'Shop', 'Магазин', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2416, 'ru', 'Manage & organize your shop', 'Управляйте и организуйте свой магазин', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2417, 'ru', 'Go to setting', 'Перейти к настройке', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2418, 'ru', 'Payment', 'Оплата', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2419, 'ru', 'Configure your payment method', 'Настройте способ оплаты', '2021-02-13 04:33:14', '2021-02-13 04:33:14'),
(2420, 'ru', 'My Panel', 'Моя панель', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2421, 'ru', 'Item has been added to wishlist', 'Товар был добавлен в список желаний', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2422, 'ru', 'My Points', 'Мои очки', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2423, 'ru', ' Points', 'Точки', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2424, 'ru', 'Wallet Money', 'Кошелек Деньги', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2425, 'ru', 'Exchange Rate', 'Курс обмена', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2426, 'ru', 'Point Earning history', 'История накопления баллов', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2427, 'ru', 'Date', 'Дата', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2428, 'ru', 'Points', 'Точки', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2429, 'ru', 'Converted', 'Преобразованный', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2430, 'ru', 'Action', 'Действие', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2431, 'ru', 'No history found.', 'История не найдена.', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2432, 'ru', 'Convert has been done successfully Check your Wallets', 'Конвертация выполнена успешно Проверьте свои кошельки', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2433, 'ru', 'Something went wrong', 'Что-то пошло не так', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2434, 'ru', 'Remaining Uploads', 'Оставшиеся загрузки', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2435, 'ru', 'No Package Found', 'Пакет не найден', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2436, 'ru', 'Search product', 'Искать продукт', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2437, 'ru', 'Name', 'Имя', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2438, 'ru', 'Current Qty', 'Текущее количество', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2439, 'ru', 'Base Price', 'Базисная цена', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2440, 'ru', 'Published', 'Опубликовано', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2441, 'ru', 'Featured', 'Рекомендуемые', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2442, 'ru', 'Options', 'Опции', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2443, 'ru', 'Edit', 'Редактировать', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2444, 'ru', 'Duplicate', 'Дубликат', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2445, 'ru', '1. Download the skeleton file and fill it with data.', '1. Загрузите файл скелета и заполните его данными.', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2446, 'ru', '2. You can download the example file to understand how the data must be filled.', '2. Вы можете скачать файл примера, чтобы понять, как должны заполняться данные.', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2447, 'ru', '3. Once you have downloaded and filled the skeleton file, upload it in the form below and submit.', '3. После того, как вы загрузили и заполнили файл скелета, загрузите его в форму ниже и отправьте.', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2448, 'ru', '4. After uploading products you need to edit them and set products images and choices.', '4. После загрузки продуктов вам необходимо отредактировать их и установить изображения продуктов и варианты выбора.', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2449, 'ru', 'Download CSV', 'Скачать CSV', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2450, 'ru', '1. Category,Sub category,Sub Sub category and Brand should be in numerical ids.', '1. Категория, подкатегория, подкатегория и бренд должны быть в числовых идентификаторах.', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2451, 'ru', '2. You can download the pdf to get Category,Sub category,Sub Sub category and Brand id.', '2. Вы можете скачать PDF-файл, чтобы получить категорию, подкатегорию, подкатегорию и идентификатор бренда.', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2452, 'ru', 'Download Category', 'Категория загрузки', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2453, 'ru', 'Download Sub category', 'Скачать подкатегорию', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2454, 'ru', 'Download Sub Sub category', 'Скачать подкатегорию', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2455, 'ru', 'Download Brand', 'Скачать бренд', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2456, 'ru', 'Upload CSV File', 'Загрузить файл CSV', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2457, 'ru', 'CSV', 'CSV', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2458, 'ru', 'Choose CSV File', 'Выберите файл CSV', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2459, 'ru', 'Upload', 'Загрузить', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2460, 'ru', 'Add New Digital Product', 'Добавить новый цифровой продукт', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2461, 'ru', 'Available Status', 'Доступный статус', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2462, 'ru', 'Admin Status', 'Статус администратора', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2463, 'ru', 'Pending Balance', 'Незавершенный баланс', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2464, 'ru', 'Send Withdraw Request', 'Отправить запрос на вывод', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2465, 'ru', 'Withdraw Request history', 'История запросов на снятие средств', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2466, 'ru', 'Amount', 'Количество', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2467, 'ru', 'Status', 'Status', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2468, 'ru', 'Message', 'Сообщение', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2469, 'ru', 'Send A Withdraw Request', 'Отправить запрос на вывод средств', '2021-02-13 04:33:34', '2021-02-13 04:33:34'),
(2470, 'ru', 'Basic Info', 'Основная информация', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2471, 'ru', 'Your Phone', 'Ваш телефон', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2472, 'ru', 'Photo', 'Фото', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2473, 'ru', 'Browse', 'Просматривать', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2474, 'ru', 'Your Password', 'Твой пароль', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2475, 'ru', 'New Password', 'Новый пароль', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2476, 'ru', 'Confirm Password', 'Подтвердить Пароль', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2477, 'ru', 'Add New Address', 'Добавить новый адрес', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2478, 'ru', 'Payment Setting', 'Настройка оплаты', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2479, 'ru', 'Cash Payment', 'Оплата наличными', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2480, 'ru', 'Bank Payment', 'Банковский платеж', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2481, 'ru', 'Bank Name', 'Название банка', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2482, 'ru', 'Bank Account Name', 'Имя банковского счета', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2483, 'ru', 'Bank Account Number', 'Номер банковского счета', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2484, 'ru', 'Bank Routing Number', 'Номер банковского маршрута', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2485, 'ru', 'Update Profile', 'Обновить профиль', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2486, 'ru', 'Change your email', 'Изменить свой адрес электронной почты', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2487, 'ru', 'Your Email', 'Ваш адрес электронной почты', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2488, 'ru', 'Sending Email...', 'Отправка электронной почты ...', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2489, 'ru', 'Verify', 'Проверять', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2490, 'ru', 'Update Email', 'Обновить электронную почту', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2491, 'ru', 'New Address', 'Новый адрес', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2492, 'ru', 'Your Address', 'Ваш адрес', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2493, 'ru', 'Country', 'Страна', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2494, 'ru', 'Select your country', 'Выберите свою страну', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2495, 'ru', 'City', 'Город', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2496, 'ru', 'Your City', 'Ваш город', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2497, 'ru', 'Your Postal Code', 'Ваш почтовый индекс', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2498, 'ru', '+880', '+880', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2499, 'ru', 'Save', 'Сохранять', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2500, 'ru', 'Received Refund Request', 'Получен запрос на возврат', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2501, 'ru', 'Delete Confirmation', 'Удалить подтверждение', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2502, 'ru', 'Are you sure to delete this?', 'Вы уверены, что удалите это?', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2503, 'ru', 'Premium Packages for Sellers', 'Премиальные пакеты для продавцов', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2504, 'ru', 'Product Upload', 'Загрузить продукт', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2505, 'ru', 'Digital Product Upload', 'Загрузка цифрового продукта', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2506, 'ru', 'Purchase Package', 'Купить пакет', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2507, 'ru', 'Select Payment Type', 'Выберите способ оплаты', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2508, 'ru', 'Payment Type', 'Способ оплаты', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2509, 'ru', 'Select One', 'Выбери один', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2510, 'ru', 'Online payment', 'Онлайн платеж', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2511, 'ru', 'Offline payment', 'Офлайн-оплата', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2512, 'ru', 'Purchase Your Package', 'Купите свой пакет', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2513, 'ru', 'Paypal', 'Paypal', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2514, 'ru', 'Stripe', 'Полоса', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2515, 'ru', 'sslcommerz', 'sslcommerz', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2516, 'ru', 'Confirm', 'Подтверждать', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2517, 'ru', 'Offline Package Payment', 'Офлайн-пакетная оплата', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2518, 'ru', 'Transaction ID', 'ID транзакции', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2519, 'ru', 'Choose image', 'Выбрать изображение', '2021-02-13 04:34:10', '2021-02-13 04:34:10'),
(2520, 'ru', 'Code', 'Код', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2521, 'ru', 'Delivery Status', 'Статус доставки', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2522, 'ru', 'Payment Status', 'Статус платежа', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2523, 'ru', 'Paid', 'Оплаченный', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2524, 'ru', 'Order Details', 'Информация для заказа', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2525, 'ru', 'Download Invoice', 'Скачать счет-фактуру', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2526, 'ru', 'Unpaid', 'Неоплаченный', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2527, 'ru', 'Order placed', 'Заказ размещен', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2528, 'ru', 'Confirmed', 'Подтвержденный', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2529, 'ru', 'On delivery', 'В процессе доставки', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2530, 'ru', 'Delivered', 'Доставленный', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2531, 'ru', 'Order Summary', 'итог заказа', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2532, 'ru', 'Order Code', 'Код заказа', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2533, 'ru', 'Customer', 'Покупатель', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2534, 'ru', 'Total order amount', 'Общая сумма заказа', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2535, 'ru', 'Shipping metdod', 'Способ доставки', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2536, 'ru', 'Flat shipping rate', 'Фиксированная стоимость доставки', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2537, 'ru', 'Payment metdod', 'Способ оплаты', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2538, 'ru', 'Variation', 'Вариация', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2539, 'ru', 'Delivery Type', 'Тип доставки', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2540, 'ru', 'Home Delivery', 'Доставка на дом', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2541, 'ru', 'Order Ammount', 'Сумма заказа', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2542, 'ru', 'Subtotal', 'Промежуточный итог', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2543, 'ru', 'Shipping', 'Перевозки', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2544, 'ru', 'Coupon Discount', 'Купонная скидка', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2545, 'ru', 'N/A', 'Нет данных', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2546, 'ru', 'In stock', 'В наличии', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2547, 'ru', 'Buy Now', 'купить сейчас', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2548, 'ru', 'Item added to your cart!', 'Товар добавлен в Вашу корзину!', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2549, 'ru', 'Proceed to Checkout', 'Перейти к оформлению заказа', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2550, 'ru', 'Cart Items', 'Товары в корзине', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2551, 'ru', '1. My Cart', '1. Моя корзина', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2552, 'ru', 'View cart', 'Посмотреть корзину', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2553, 'ru', '2. Shipping info', '2. Информация о доставке', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2554, 'ru', 'Checkout', 'Проверить', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2555, 'ru', '3. Delivery info', '3. Информация о доставке', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2556, 'ru', '4. Payment', '4. Оплата', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2557, 'ru', '5. Confirmation', '5. Подтверждение', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2558, 'ru', 'Remove', 'Удалять', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2559, 'ru', 'Return to shop', 'Вернуться в магазин', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2560, 'ru', 'Continue to Shipping', 'Продолжить доставку', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2561, 'ru', 'Or', 'Или же', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2562, 'ru', 'Guest Checkout', 'Гостевой заказ', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2563, 'ru', 'Continue to Delivery Info', 'Перейти к информации о доставке', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2564, 'ru', 'Postal Code', 'Почтовый индекс', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2565, 'ru', 'Choose Delivery Type', 'Выберите тип доставки', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2566, 'ru', 'Local Pickup', 'Местный пикап', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2567, 'ru', 'Select your nearest pickup point', 'Выберите ближайший пункт выдачи', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2568, 'ru', 'Continue to Payment', 'Продолжить оплату', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2569, 'ru', 'Select a payment option', 'Выберите вариант оплаты', '2021-02-13 04:34:28', '2021-02-13 04:34:28'),
(2570, 'ru', 'Razorpay', 'Razorpay', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2571, 'ru', 'Paystack', 'Paystack', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2572, 'ru', 'VoguePay', 'VoguePay', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2573, 'ru', 'payhere', 'Оплатите здесь', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2574, 'ru', 'ngenius', 'нгений', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2575, 'ru', 'Paytm', 'Paytm', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2576, 'ru', 'Cash on Delivery', 'Оплата при доставке', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2577, 'ru', 'Your wallet balance :', 'Баланс вашего кошелька:', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2578, 'ru', 'Insufficient balance', 'Недостаточный баланс', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2579, 'ru', 'I agree to the', 'я согласен', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2580, 'ru', 'Complete Order', 'Завершить заказ', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2581, 'ru', 'Summary', 'Резюме', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2582, 'ru', 'Items', 'Предметы', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2583, 'ru', 'Total Club point', 'Всего клубных баллов', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2584, 'ru', 'Total Shipping', 'Всего Доставка', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2585, 'ru', 'Have coupon code? Enter here', 'Есть код купона? Вход здесь', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2586, 'ru', 'Apply', 'Подать заявление', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2587, 'ru', 'You need to agree with our policies', 'Вам необходимо согласиться с нашей политикой', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2588, 'ru', 'Forgot password', 'Забыл пароль', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2589, 'ru', 'SEO Setting', 'Настройка SEO', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2590, 'ru', 'System Update', 'Обновление системы', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2591, 'ru', 'Add New Payment Method', 'Добавить новый способ оплаты', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2592, 'ru', 'Manual Payment Method', 'Ручной способ оплаты', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2593, 'ru', 'Heading', 'Заголовок', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2594, 'ru', 'Logo', 'Логотип', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2595, 'ru', 'Manual Payment Information', 'Информация об оплате вручную', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2596, 'ru', 'Type', 'Тип', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2597, 'ru', 'Custom Payment', 'Индивидуальный платеж', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2598, 'ru', 'Check Payment', 'Проверить оплату', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2599, 'ru', 'Checkout Thumbnail', 'Эскиз оформления заказа', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2600, 'ru', 'Payment Instruction', 'Инструкция по оплате', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2601, 'ru', 'Bank Information', 'Банковская информация', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2602, 'ru', 'Select File', 'Выбрать файл', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2603, 'ru', 'Upload New', 'Загрузить новый', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2604, 'ru', 'Sort by newest', 'Сортировать по самым новым', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2605, 'ru', 'Sort by oldest', 'Сортировать по самому старому', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2606, 'ru', 'Sort by smallest', 'Сортировать по наименьшему', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2607, 'ru', 'Sort by largest', 'Сортировать по наибольшему', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2608, 'ru', 'Selected Only', 'Только выбрано', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2609, 'ru', 'No files found', 'Файлов не найдено', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2610, 'ru', '0 File selected', '0 Файл выбран', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2611, 'ru', 'Clear', 'Прозрачный', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2612, 'ru', 'Prev', 'Предыдущая', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2613, 'ru', 'Next', 'Следующий', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2614, 'ru', 'Add Files', 'Добавить файлы', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2615, 'ru', 'Method has been inserted successfully', 'Метод успешно вставлен', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2616, 'ru', 'Order Date', 'Дата заказа', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2617, 'ru', 'Bill to', 'Плательщик', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2618, 'ru', 'Sub Total', 'Промежуточный итог', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2619, 'ru', 'Total Tax', 'Общий налог', '2021-02-13 04:34:51', '2021-02-13 04:34:51'),
(2620, 'ru', 'Grand Total', 'Общая сумма', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2621, 'ru', 'Your order has been placed successfully. Please submit payment information from purchase history', 'Ваш заказ был успешно размещен. Отправьте платежную информацию из истории покупок', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2622, 'ru', 'Thank You for Your Order!', 'Спасибо за ваш заказ!', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2623, 'ru', 'Order Code:', 'Код заказа:', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2624, 'ru', 'A copy or your order summary has been sent to', 'Копия или сводка вашего заказа отправлены на адрес', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2625, 'ru', 'Make Payment', 'Совершать платеж', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2626, 'ru', 'Payment screenshot', 'Скриншот платежа', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2627, 'ru', 'Paypal Credential', 'Учетные данные Paypal', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2628, 'ru', 'Paypal Client ID', 'Идентификатор клиента Paypal', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2629, 'ru', 'Paypal Client Secret', 'Секрет клиента Paypal', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2630, 'ru', 'Paypal Sandbox Mode', 'Режим песочницы Paypal', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2631, 'ru', 'Sslcommerz Credential', 'Учетные данные sslcommerz', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2632, 'ru', 'Sslcz Store Id', 'Идентификатор магазина sslcz', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2633, 'ru', 'Sslcz store password', 'Пароль хранилища sslcz', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2634, 'ru', 'Sslcommerz Sandbox Mode', 'Режим песочницы sslcommerz', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2635, 'ru', 'Stripe Credential', 'Stripe Credential', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2636, 'ru', 'STRIPE KEY', 'ПОЛОСНЫЙ КЛЮЧ', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2637, 'ru', 'STRIPE SECRET', 'ПОЛОСКА СЕКРЕТНО', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2638, 'ru', 'RazorPay Credential', 'Учетные данные RazorPay', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2639, 'ru', 'RAZOR KEY', 'КЛЮЧ ОТ БРИТВЫ', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2640, 'ru', 'RAZOR SECRET', 'БРИТВЫЙ СЕКРЕТ', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2641, 'ru', 'Instamojo Credential', 'Учетные данные Instamojo', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2642, 'ru', 'API KEY', 'КЛЮЧ API', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2643, 'ru', 'IM API KEY', 'КЛЮЧ IM API', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2644, 'ru', 'AUTH TOKEN', 'AUTH TOKEN', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2645, 'ru', 'IM AUTH TOKEN', 'IM AUTH TOKEN', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2646, 'ru', 'Instamojo Sandbox Mode', 'Режим песочницы Instamojo', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2647, 'ru', 'PayStack Credential', 'Учетные данные PayStack', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2648, 'ru', 'PUBLIC KEY', 'ПУБЛИЧНЫЙ КЛЮЧ', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2649, 'ru', 'SECRET KEY', 'СЕКРЕТНЫЙ КЛЮЧ', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2650, 'ru', 'MERCHANT EMAIL', 'ЭЛЕКТРОННАЯ ПОЧТА ПРОДАВЦА', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2651, 'ru', 'VoguePay Credential', 'VoguePay Credential', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2652, 'ru', 'MERCHANT ID', 'ИДЕНТИФИКАТОР ПРОДАВЦА', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2653, 'ru', 'Sandbox Mode', 'Режим песочницы', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2654, 'ru', 'Payhere Credential', 'Учетные данные Payhere', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2655, 'ru', 'PAYHERE MERCHANT ID', 'PAYHERE MERCHANT ID', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2656, 'ru', 'PAYHERE SECRET', 'PAYHERE SECRET', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2657, 'ru', 'PAYHERE CURRENCY', 'ЗДЕСЬ ВАЛЮТА', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2658, 'ru', 'Payhere Sandbox Mode', 'Режим песочницы Payhere', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2659, 'ru', 'Ngenius Credential', 'Ngenius Credential', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2660, 'ru', 'NGENIUS OUTLET ID', 'NGENIUS OUTLET ID', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2661, 'ru', 'NGENIUS API KEY', 'КЛЮЧ API NGENIUS', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2662, 'ru', 'NGENIUS CURRENCY', 'ВАЛЮТА NGENIUS', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2663, 'ru', 'Mpesa Credential', 'Credential Grapes', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2664, 'ru', 'MPESA CONSUMER KEY', 'КЛЮЧ ПОТРЕБИТЕЛЯ MPESA', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2665, 'ru', 'MPESA_CONSUMER_KEY', 'MPESA_CONSUMER_KEY', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2666, 'ru', 'MPESA CONSUMER SECRET', 'ПОТРЕБИТЕЛЬСКАЯ ТАЙНА MPESA', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2667, 'ru', 'MPESA_CONSUMER_SECRET', 'MPESA_CONSUMER_SECRET', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2668, 'ru', 'MPESA SHORT CODE', 'КОРОТКИЙ КОД MPESA', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2669, 'ru', 'MPESA_SHORT_CODE', 'MPESA_SHORT_CODE', '2021-02-13 04:35:11', '2021-02-13 04:35:11'),
(2670, 'ru', 'MPESA SANDBOX ACTIVATION', 'АКТИВАЦИЯ ПЕСОЧНОГО ЯЩИКА MPESA', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2671, 'ru', 'Flutterwave Credential', 'Учетные данные Flutterwave', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2672, 'ru', 'RAVE_PUBLIC_KEY', 'RAVE_PUBLIC_KEY', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2673, 'ru', 'RAVE_SECRET_KEY', 'RAVE_SECRET_KEY', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2674, 'ru', 'RAVE_TITLE', 'RAVE_TITLE', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2675, 'ru', 'STAGIN ACTIVATION', 'АКТИВАЦИЯ СТАГИНА', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2676, 'ru', 'All Product', 'Все продукты', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2677, 'ru', 'Sort By', 'Сортировать по', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2678, 'ru', 'Rating (High > Low)', 'Рейтинг (высокий> низкий)', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2679, 'ru', 'Rating (Low > High)', 'Рейтинг (Низкий> Высокий)', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2680, 'ru', 'Num of Sale (High > Low)', 'Количество продаж (высокое> низкое)', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2681, 'ru', 'Num of Sale (Low > High)', 'Количество продаж (низкое> высокое)', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2682, 'ru', 'Base Price (High > Low)', 'Базовая цена (высокая> низкая)', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2683, 'ru', 'Base Price (Low > High)', 'Базовая цена (низкая> высокая)', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2684, 'ru', 'Type & Enter', 'Введите и введите', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2685, 'ru', 'Added By', 'Добавлено', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2686, 'ru', 'Num of Sale', 'Количество продаж', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2687, 'ru', 'Total Stock', 'Общий запас', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2688, 'ru', 'Todays Deal', 'Сегодняшняя сделка', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2689, 'ru', 'Rating', 'Рейтинг', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2690, 'ru', 'times', 'раз', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2691, 'ru', 'Add Nerw Product', 'Добавить продукт Nerw', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2692, 'ru', 'Product Information', 'Информация о товаре', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2693, 'ru', 'Unit', 'Единица измерения', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2694, 'ru', 'Unit (e.g. KG, Pc etc)', 'Единица (например, кг, ПК и т. Д.)', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2695, 'ru', 'Minimum Qty', 'Минимальное количество', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2696, 'ru', 'Tags', 'Теги', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2697, 'ru', 'Type and hit enter to add a tag', 'Введите и нажмите Enter, чтобы добавить тег', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2698, 'ru', 'Barcode', 'Штрих-код', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2699, 'ru', 'Refundable', 'Возвратный', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2700, 'ru', 'Product Images', 'Изображения продуктов', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2701, 'ru', 'Gallery Images', 'Галерея изображений', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2702, 'ru', 'Todays Deal updated successfully', 'Сегодняшняя сделка успешно обновлена', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2703, 'ru', 'Published products updated successfully', 'Опубликованные продукты успешно обновлены', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2704, 'ru', 'Thumbnail Image', 'Миниатюрное изображение', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2705, 'ru', 'Featured products updated successfully', 'Рекомендуемые продукты успешно обновлены', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2706, 'ru', 'Product Videos', 'Видео о продуктах', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2707, 'ru', 'Video Provider', 'Провайдер видео', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2708, 'ru', 'Youtube', 'YouTube', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2709, 'ru', 'Dailymotion', 'Dailymotion', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2710, 'ru', 'Vimeo', 'Vimeo', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2711, 'ru', 'Video Link', 'Ссылка на видео', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2712, 'ru', 'Product Variation', 'Вариант продукта', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2713, 'ru', 'Colors', 'Цвета', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2714, 'ru', 'Attributes', 'Атрибуты', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2715, 'ru', 'Choose Attributes', 'Выберите атрибуты', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2716, 'ru', 'Choose the attributes of this product and then input values of each attribute', 'Выберите атрибуты этого продукта, а затем введите значения каждого атрибута', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2717, 'ru', 'Product price + stock', 'Цена товара + наличие на складе', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2718, 'ru', 'Unit price', 'Цена за единицу', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2719, 'ru', 'Purchase price', 'Цена', '2021-02-13 04:35:25', '2021-02-13 04:35:25'),
(2720, 'ru', 'Activated', 'Активирован', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2721, 'ru', 'Deactivated', 'Деактивировано', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2722, 'ru', 'Activate OTP', 'Активировать OTP', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2723, 'ru', 'OTP will be Used For', 'OTP будет использоваться для', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2724, 'ru', 'Settings updated successfully', 'Настройки успешно обновлены', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2725, 'ru', 'Product Owner', 'Владелец продукта', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2726, 'ru', 'Point', 'Точка', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2727, 'ru', 'Set Point for Product Within a Range', 'Уставка для продукта в пределах диапазона', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2728, 'ru', 'Set Point for multiple products', 'Заданное значение для нескольких продуктов', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2729, 'ru', 'Min Price', 'Минимальная цена', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2730, 'ru', 'Max Price', 'Макс Цена', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2731, 'ru', 'Set Point for all Products', 'Заданное значение для всех продуктов', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2732, 'ru', 'Set Point For ', 'Заданное значение для', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2733, 'ru', 'Convert Status', 'Преобразовать статус', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2734, 'ru', 'Earned At', 'Заработано в', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2735, 'ru', 'Seller Based Selling Report', 'Отчет о продажах на основе продавца', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2736, 'ru', 'Sort by verificarion status', 'Сортировать по статусу верификации', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2737, 'ru', 'Approved', 'Одобренный', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2738, 'ru', 'Non Approved', 'Не утверждено', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2739, 'ru', 'Filter', 'Фильтр', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2740, 'ru', 'Seller Name', 'Имя продавца', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2741, 'ru', 'Number of Product Sale', 'Количество продаж продукта', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2742, 'ru', 'Order Amount', 'Сумма заказа', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2743, 'ru', 'Facebook Chat Setting', 'Настройка чата Facebook', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2744, 'ru', 'Facebook Page ID', 'Идентификатор страницы Facebook', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2745, 'ru', 'Please be carefull when you are configuring Facebook chat. For incorrect configuration you will not get messenger icon on your user-end site.', 'Будьте осторожны при настройке чата Facebook. В случае неправильной настройки значок мессенджера не появится на вашем пользовательском сайте.', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2746, 'ru', 'Login into your facebook page', 'Войдите на свою страницу facebook', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2747, 'ru', 'Find the About option of your facebook page', 'Найдите опцию «О нас» на своей странице в Facebook.', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2748, 'ru', 'At the very bottom, you can find the \\“Facebook Page ID\\”', 'В самом низу вы можете найти \\ \"Идентификатор страницы Facebook \\\".', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2749, 'ru', 'Go to Settings of your page and find the option of \\\"Advance Messaging\\\"', 'Зайдите в настройки своей страницы и найдите опцию \\ \"Расширенный обмен сообщениями \\\"', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2750, 'ru', 'Scroll down that page and you will get \\\"white listed domain\\\"', 'Прокрутите страницу вниз, и вы увидите \\ \"домен в белом списке \\\"', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2751, 'ru', 'Set your website domain name', 'Установите доменное имя вашего сайта', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2752, 'ru', 'Google reCAPTCHA Setting', 'Настройка Google reCAPTCHA', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2753, 'ru', 'Site KEY', 'КЛЮЧ от сайта', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2754, 'ru', 'Select Shipping Method', 'Выберите способ доставки', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2755, 'ru', 'Product Wise Shipping Cost', 'Стоимость доставки товара', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2756, 'ru', 'Flat Rate Shipping Cost', 'Стоимость доставки по фиксированной ставке', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2757, 'ru', 'Seller Wise Flat Shipping Cost', 'Фиксированная стоимость доставки, установленная продавцом', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2758, 'ru', 'Note', 'Примечание', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2759, 'ru', 'Product Wise Shipping Cost calulation: Shipping cost is calculate by addition of each product shipping cost', 'Расчет стоимости доставки товара: стоимость доставки рассчитывается путем сложения стоимости доставки каждого товара.', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2760, 'ru', 'Flat Rate Shipping Cost calulation: How many products a customer purchase, doesn\'t matter. Shipping cost is fixed', 'Расчет фиксированной стоимости доставки: сколько товаров покупает клиент, не имеет значения. Стоимость доставки фиксированная', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2761, 'ru', 'Seller Wise Flat Shipping Cost calulation: Fixed rate for each seller. If a customer purchase 2 product from two seller shipping cost is calculate by addition of each seller flat shipping cost', 'Расчет фиксированной стоимости доставки продавцом Wise: фиксированная ставка для каждого продавца. Если клиент покупает 2 продукта у двух продавцов, стоимость доставки рассчитывается путем сложения фиксированной стоимости доставки каждого продавца.', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2762, 'ru', 'Flat Rate Cost', 'Фиксированная стоимость', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2763, 'ru', 'Shipping Cost for Admin Products', 'Стоимость доставки для продуктов для администраторов', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2764, 'ru', 'Countries', 'Страны', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2765, 'ru', 'Show/Hide', 'Показать спрятать', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2766, 'ru', 'Country status updated successfully', 'Статус страны успешно обновлен', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2767, 'ru', 'All Subcategories', 'Все подкатегории', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2768, 'ru', 'Add New Subcategory', 'Добавить новую подкатегорию', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2769, 'ru', 'Sub-Categories', 'Подкатегории', '2021-02-13 04:36:20', '2021-02-13 04:36:20'),
(2770, 'ru', 'Flat', 'Плоский', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2771, 'ru', 'Percent', 'Процентов', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2772, 'ru', 'Discount', 'Скидка', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2773, 'ru', 'Product Description', 'Описание товара', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2774, 'ru', 'Product Shipping Cost', 'Стоимость доставки товара', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2775, 'ru', 'Free Shipping', 'Бесплатная доставка', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2776, 'ru', 'Flat Rate', 'Единая ставка', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2777, 'ru', 'Shipping cost', 'Стоимость доставки', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2778, 'ru', 'PDF Specification', 'PDF Спецификация', '2021-02-13 04:36:47', '2021-02-13 04:36:47');
INSERT INTO `translations` (`id`, `lang`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(2779, 'ru', 'SEO Meta Tags', 'SEO мета-теги', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2780, 'ru', 'Meta Title', 'Мета-заголовок', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2781, 'ru', 'Meta Image', 'Мета-изображение', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2782, 'ru', 'Choice Title', 'Выбор названия', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2783, 'ru', 'Enter choice values', 'Введите значения выбора', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2784, 'ru', 'All categories', 'Все категории', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2785, 'ru', 'Add New category', 'Добавить новую категорию', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2786, 'ru', 'Type name & Enter', 'Введите имя и введите', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2787, 'ru', 'Banner', 'Баннер', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2788, 'ru', 'Commission', 'Комиссия', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2789, 'ru', 'icon', 'значок', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2790, 'ru', 'Featured categories updated successfully', 'Избранные категории успешно обновлены', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2791, 'ru', 'Hot', 'Горячей', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2792, 'ru', 'Filter by Payment Status', 'Фильтр по статусу платежа', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2793, 'ru', 'Un-Paid', 'Неоплаченный', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2794, 'ru', 'Filter by Deliver Status', 'Фильтр по статусу доставки', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2795, 'ru', 'Pending', 'В ожидании', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2796, 'ru', 'Type Order code & hit Enter', 'Введите код заказа и нажмите Enter.', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2797, 'ru', 'Num. of Products', 'Num. продуктов', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2798, 'ru', 'Walk In Customer', 'Прогулка к клиенту', '2021-02-13 04:36:47', '2021-02-13 04:36:47'),
(2799, 'ru', 'QTY', 'КОЛ-ВО', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2800, 'ru', 'Without Shipping Charge', 'Без оплаты доставки', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2801, 'ru', 'With Shipping Charge', 'С оплатой доставки', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2802, 'ru', 'Pay With Cash', 'Оплата наличными', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2803, 'ru', 'Shipping Address', 'адреса доставки', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2804, 'ru', 'Close', 'Закрывать', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2805, 'ru', 'Select country', 'Выберите страну', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2806, 'ru', 'Order Confirmation', 'Подтверждение заказа', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2807, 'ru', 'Are you sure to confirm this order?', 'Вы уверены, что подтвердите этот заказ?', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2808, 'ru', 'Comfirm Order', 'Подтвердить заказ', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2809, 'ru', 'Personal Info', 'Личная информация', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2810, 'ru', 'Repeat Password', 'Повторите пароль', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2811, 'ru', 'Shop Name', 'Название магазина', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2812, 'ru', 'Register Your Shop', 'Зарегистрируйте свой магазин', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2813, 'ru', 'Affiliate Informations', 'Партнерская информация', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2814, 'ru', 'Affiliate', 'Партнер', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2815, 'ru', 'User Info', 'Информация о пользователе', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2816, 'ru', 'Installed Addon', 'Установленный аддон', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2817, 'ru', 'Available Addon', 'Доступный аддон', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2818, 'ru', 'Install New Addon', 'Установить новый аддон', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2819, 'ru', 'Version', 'Версия', '2021-02-13 04:36:48', '2021-02-13 04:36:48'),
(2820, 'ru', 'Seo Fields', 'Seo Fields', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2821, 'ru', 'Update Page', 'Обновить страницу', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2822, 'ru', 'Default Language', 'Язык по умолчанию', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2823, 'ru', 'Add New Language', 'Добавить новый язык', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2824, 'ru', 'RTL', 'RTL', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2825, 'ru', 'Translation', 'Перевод', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2826, 'ru', 'Language Information', 'Информация о языке', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2827, 'ru', 'Save Page', 'Сохранить страницу', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2828, 'ru', 'Home Page Settings', 'Настройки домашней страницы', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2829, 'ru', 'Home Slider', 'Домашний слайдер', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2830, 'ru', 'Photos & Links', 'Фотографии и ссылки', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2831, 'ru', 'Add New', 'Добавить новое', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2832, 'ru', 'Home Categories', 'Главная Категории', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2833, 'ru', 'Home Banner 1 (Max 3)', 'Домашний баннер 1 (максимум 3)', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2834, 'ru', 'Banner & Links', 'Баннер и ссылки', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2835, 'ru', 'Home Banner 2 (Max 3)', 'Домашний баннер 2 (максимум 3)', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2836, 'ru', 'Top 10', 'Топ 10', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2837, 'ru', 'Top Categories (Max 10)', 'Лучшие категории (максимум 10)', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2838, 'ru', 'Top Brands (Max 10)', 'Лучшие бренды (максимум 10)', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2839, 'ru', 'System Name', 'Имя системы', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2840, 'ru', 'System Logo - White', 'Системный логотип - белый', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2841, 'ru', 'Choose Files', 'Выбрать файлы', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2842, 'ru', 'Will be used in admin panel side menu', 'Будет использоваться в боковом меню панели администратора', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2843, 'ru', 'System Logo - Black', 'Системный логотип - черный', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2844, 'ru', 'Will be used in admin panel topbar in mobile + Admin login page', 'Будет использоваться в верхней панели админ-панели на мобильном устройстве + странице входа администратора', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2845, 'ru', 'System Timezone', 'Системный часовой пояс', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2846, 'ru', 'Admin login page background', 'Фон страницы входа администратора', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2847, 'ru', 'Website Header', 'Заголовок веб-сайта', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2848, 'ru', 'Header Setting', 'Настройка заголовка', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2849, 'ru', 'Header Logo', 'Логотип заголовка', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2850, 'ru', 'Show Language Switcher?', 'Показать переключатель языков?', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2851, 'ru', 'Show Currency Switcher?', 'Показать переключатель валют?', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2852, 'ru', 'Enable stikcy header?', 'Включить стиксы в шапку?', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2853, 'ru', 'Website Footer', 'Нижний колонтитул веб-сайта', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2854, 'ru', 'Footer Widget', 'Виджет нижнего колонтитула', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2855, 'ru', 'About Widget', 'О виджете', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2856, 'ru', 'Footer Logo', 'Логотип нижнего колонтитула', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2857, 'ru', 'About description', 'О описании', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2858, 'ru', 'Contact Info Widget', 'Виджет контактной информации', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2859, 'ru', 'Footer contact address', 'Контактный адрес нижнего колонтитула', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2860, 'ru', 'Footer contact phone', 'Контактный телефон нижнего колонтитула', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2861, 'ru', 'Footer contact email', 'Контактный адрес электронной почты нижнего колонтитула', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2862, 'ru', 'Link Widget One', 'Ссылка на первый виджет', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2863, 'ru', 'Links', 'Ссылки', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2864, 'ru', 'Footer Bottom', 'Нижний колонтитул', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2865, 'ru', 'Copyright Widget ', 'Виджет авторских прав', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2866, 'ru', 'Copyright Text', 'Текст авторского права', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2867, 'ru', 'Social Link Widget ', 'Виджет социальных ссылок', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2868, 'ru', 'Show Social Links?', 'Показать социальные ссылки?', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2869, 'ru', 'Social Links', 'Социальные ссылки', '2021-02-13 04:37:24', '2021-02-13 04:37:24'),
(2870, 'ru', 'Payment Methods Widget ', 'Виджет способов оплаты', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2871, 'ru', 'RTL status updated successfully', 'Статус RTL успешно обновлен', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2872, 'ru', 'Language changed to ', 'Язык изменен на', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2873, 'ru', 'Inhouse Product sale report', 'Отчет о продажах внутри компании', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2874, 'ru', 'Sort by Category', 'Сортировать по категории', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2875, 'ru', 'Product wise stock report', 'Отчет о товарных запасах', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2876, 'ru', 'Currency changed to ', 'Валюта изменена на', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2877, 'ru', 'Avatar', 'Avatar', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2878, 'ru', 'Copy', 'Копировать', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2879, 'ru', 'Variant', 'Variant', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2880, 'ru', 'Variant Price', 'Вариант Цена', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2881, 'ru', 'SKU', 'SKU', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2882, 'ru', 'Key', 'Ключ', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2883, 'ru', 'Value', 'Ценить', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2884, 'ru', 'Copy Translations', 'Копировать переводы', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2885, 'ru', 'All Pick-up Points', 'Все пункты выдачи', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2886, 'ru', 'Add New Pick-up Point', 'Добавить новую точку получения', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2887, 'ru', 'Manager', 'Управляющий делами', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2888, 'ru', 'Location', 'Место расположения', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2889, 'ru', 'Pickup Station Contact', 'Контакты станции самовывоза', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2890, 'ru', 'Open', 'Открыть', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2891, 'ru', 'POS Activation for Seller', 'Активация POS для продавца', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2892, 'ru', 'Order Completed Successfully.', 'Заказ успешно выполнен.', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2893, 'ru', 'Text Input', 'Ввод текста', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2894, 'ru', 'Select', 'Выбирать', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2895, 'ru', 'Multiple Select', 'Множественный выбор', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2896, 'ru', 'Radio', 'Радио', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2897, 'ru', 'File', 'Файл', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2898, 'ru', 'Email Address', 'Адрес электронной почты', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2899, 'ru', 'Verification Info', 'Информация для проверки', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2900, 'ru', 'Approval', 'Одобрение', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2901, 'ru', 'Due Amount', 'Надлежащей суммы', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2902, 'ru', 'Show', 'Показать', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2903, 'ru', 'Pay Now', 'Заплатить сейчас', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2904, 'ru', 'Affiliate User Verification', 'Подтверждение аффилированного пользователя', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2905, 'ru', 'Reject', 'Отклонять', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2906, 'ru', 'Accept', 'Принимать', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2907, 'ru', 'Beauty, Health & Hair', 'Красота, здоровье и волосы', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2908, 'ru', 'Comparison', 'Сравнение', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2909, 'ru', 'Reset Compare List', 'Сбросить список сравнения', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2910, 'ru', 'Your comparison list is empty', 'Ваш список сравнения пуст', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2911, 'ru', 'Convert Point To Wallet', 'Конвертировать Point в кошелек', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2912, 'ru', 'Note: You need to activate wallet option first before using club point addon.', 'Примечание: вам необходимо активировать опцию кошелька перед использованием надстройки Club Point.', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2913, 'ru', 'Create an account.', 'Завести аккаунт.', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2914, 'ru', 'Use Email Instead', 'Используйте электронную почту вместо', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2915, 'ru', 'By signing up you agree to our terms and conditions.', 'Регистрируясь, вы соглашаетесь с нашими условиями.', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2916, 'ru', 'Create Account', 'Зарегистрироваться', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2917, 'ru', 'Or Join With', 'Или присоединиться к', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2918, 'ru', 'Already have an account?', 'Уже есть аккаунт?', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2919, 'ru', 'Log In', 'Авторизоваться', '2021-02-13 04:37:37', '2021-02-13 04:37:37'),
(2920, 'ru', 'Computer & Accessories', 'Компьютерные аксессуары', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2921, 'ru', 'Product(s)', 'Product(s)', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2922, 'ru', 'in your cart', 'в твоей тележке', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2923, 'ru', 'in your wishlist', 'в вашем списке желаний', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2924, 'ru', 'you ordered', 'вы заказали', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2925, 'ru', 'Default Shipping Address', 'основной адрес для пересылки', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2926, 'ru', 'Sports & outdoor', 'Спорт и отдых', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2927, 'ru', 'Copied', 'Скопировано', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2928, 'ru', 'Copy the Promote Link', 'Скопируйте ссылку для продвижения', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2929, 'ru', 'Write a review', 'Написать рецензию', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2930, 'ru', 'Your name', 'Ваше имя', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2931, 'ru', 'Comment', 'Комментарий', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2932, 'ru', 'Your review', 'Ваш обзор', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2933, 'ru', 'Submit review', 'Добавить отзыв', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2934, 'ru', 'Claire Willis', 'Клэр Уиллис', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2935, 'ru', 'Germaine Greene', 'Жермен Грин', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2936, 'ru', 'Product File', 'Файл продукта', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2937, 'ru', 'Choose file', 'Выбрать файл', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2938, 'ru', 'Type to add a tag', 'Введите, чтобы добавить тег', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2939, 'ru', 'Images', 'Изображений', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2940, 'ru', 'Main Images', 'Основные изображения', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2941, 'ru', 'Meta Tags', 'Мета-теги', '2021-02-13 04:37:53', '2021-02-13 04:37:53'),
(2942, 'ru', 'Digital Product has been inserted successfully', 'Цифровой продукт успешно вставлен', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2943, 'ru', 'Edit Digital Product', 'Редактировать цифровой продукт', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2944, 'ru', 'Select an option', 'Выберите вариант', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2945, 'ru', 'tax', 'налог', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2946, 'ru', 'Any question about this product?', 'Есть вопросы об этом продукте?', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2947, 'ru', 'Sign in', 'Войти', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2948, 'ru', 'Login with Google', 'Войти через Google', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2949, 'ru', 'Login with Facebook', 'Войти с Facebook', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2950, 'ru', 'Login with Twitter', 'Войти через Twitter', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2951, 'ru', 'Click to show phone number', 'Нажмите, чтобы показать номер телефона', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2952, 'ru', 'Other Ads of', 'Другие объявления', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2953, 'ru', 'Store Home', 'Магазин Дом', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2954, 'ru', 'Top Selling', 'Самые продаваемые', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2955, 'ru', 'Shop Settings', 'Настройки магазина', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2956, 'ru', 'Visit Shop', 'Посетить магазин', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2957, 'ru', 'Pickup Points', 'Пункты выдачи', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2958, 'ru', 'Select Pickup Point', 'Выберите пункт выдачи', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2959, 'ru', 'Slider Settings', 'Настройки слайдера', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2960, 'ru', 'Social Media Link', 'Ссылка на социальные сети', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2961, 'ru', 'Facebook', 'Facebook', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2962, 'ru', 'Twitter', 'Twitter', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2963, 'ru', 'Google', 'Google', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2964, 'ru', 'New Arrival Products', 'Новые поступления товаров', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2965, 'ru', 'Check Your Order Status', 'Проверьте статус вашего заказа', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2966, 'ru', 'Shipping method', 'Способ доставки', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2967, 'ru', 'Shipped By', 'Отправлено', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2968, 'ru', 'Image', 'Изображение', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2969, 'ru', 'Sub Sub Category', 'Подкатегория', '2021-02-13 04:37:54', '2021-02-13 04:37:54'),
(2970, 'ru', 'Inhouse Products', 'Внутренние продукты', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2971, 'ru', 'Forgot Password?', 'Забыл пароль?', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2972, 'ru', 'Enter your email address to recover your password.', 'Введите свой адрес электронной почты, чтобы восстановить пароль.', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2973, 'ru', 'Email or Phone', 'По электронной почте или телефону', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2974, 'ru', 'Send Password Reset Link', 'Отправить ссылку для сброса пароля', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2975, 'ru', 'Back to Login', 'Вернуться на страницу входа', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2976, 'ru', 'index', 'индекс', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2977, 'ru', 'Download Your Product', 'Загрузите ваш продукт', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2978, 'ru', 'Option', 'Вариант', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2979, 'ru', 'Applied Refund Request', 'Примененный запрос на возврат', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2980, 'ru', 'Item has been renoved from wishlist', 'Товар был изменен из списка желаний', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2981, 'ru', 'Bulk Products Upload', 'Массовая загрузка товаров', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2982, 'ru', 'Upload CSV', 'Загрузить CSV', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2983, 'ru', 'Create a Ticket', 'Создать билет', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2984, 'ru', 'Tickets', 'Билеты', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2985, 'ru', 'Ticket ID', 'ID билета', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2986, 'ru', 'Sending Date', 'Дата отправки', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2987, 'ru', 'Subject', 'Предмет', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2988, 'ru', 'View Details', 'Посмотреть детали', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2989, 'ru', 'Provide a detailed description', 'Предоставьте подробное описание', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2990, 'ru', 'Type your reply', 'Напишите свой ответ', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2991, 'ru', 'Send Ticket', 'Отправить билет', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2992, 'ru', 'Load More', 'Загрузи больше', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2993, 'ru', 'Jewelry & Watches', 'Ювелирные изделия и часы', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2994, 'ru', 'Filters', 'Фильтры', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2995, 'ru', 'Contact address', 'Контактный адрес', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2996, 'ru', 'Contact phone', 'Контактный телефон', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2997, 'ru', 'Contact email', 'Почта для связи', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2998, 'ru', 'Filter by', 'Сортировать по', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(2999, 'ru', 'Condition', 'Условие', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3000, 'ru', 'All Type', 'Все Типы', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3001, 'ru', 'Pay with wallet', 'Плати кошельком', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3002, 'ru', 'Select variation', 'Выберите вариант', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3003, 'ru', 'No Product Added', 'Продукт не добавлен', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3004, 'ru', 'Status has been updated successfully', 'Статус успешно обновлен', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3005, 'ru', 'All Seller Packages', 'Все пакеты продавца', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3006, 'ru', 'Add New Package', 'Добавить новый пакет', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3007, 'ru', 'Package Logo', 'Логотип Пакета', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3008, 'ru', 'days', 'дней', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3009, 'ru', 'Create New Seller Package', 'Создать новый пакет продавца', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3010, 'ru', 'Package Name', 'Имя пакета', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3011, 'ru', 'Duration', 'Продолжительность', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3012, 'ru', 'Validity in number of days', 'Срок действия в днях', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3013, 'ru', 'Update Package Information', 'Обновить информацию о пакете', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3014, 'ru', 'Package has been inserted successfully', 'Пакет успешно вставлен', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3015, 'ru', 'Refund Request', 'Запрос на возврат денег', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3016, 'ru', 'Reason', 'Причина', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3017, 'ru', 'Label', 'Этикетка', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3018, 'ru', 'Select Label', 'Выберите ярлык', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3019, 'ru', 'Multiple Select Label', 'Ярлык с множественным выбором', '2021-02-13 04:38:11', '2021-02-13 04:38:11'),
(3020, 'ru', 'Radio Label', 'Radio Label', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3021, 'ru', 'Pickup Point Orders', 'Заказы в пунктах самовывоза', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3022, 'ru', 'View', 'Вид', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3023, 'ru', 'Order #', 'Заказ #', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3024, 'ru', 'Order Status', 'Статус заказа', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3025, 'ru', 'Total amount', 'Общая сумма', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3026, 'ru', 'TOTAL', 'ОБЩИЙ', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3027, 'ru', 'Delivery status has been updated', 'Статус доставки обновлен', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3028, 'ru', 'Payment status has been updated', 'Статус платежа обновлен', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3029, 'ru', 'INVOICE', 'ВЫСТАВЛЕННЫЙ СЧЕТ', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3030, 'ru', 'Set Refund Time', 'Установить время возврата', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3031, 'ru', 'Set Time for sending Refund Request', 'Установить время для отправки запроса на возврат', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3032, 'ru', 'Set Refund Sticker', 'Установить стикер возврата', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3033, 'ru', 'Sticker', 'Наклейка', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3034, 'ru', 'Refund Request All', 'Запрос на возврат Все', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3035, 'ru', 'Order Id', 'Номер заказа', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3036, 'ru', 'Seller Approval', 'Одобрение продавца', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3037, 'ru', 'Admin Approval', 'Утверждение администратора', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3038, 'ru', 'Refund Status', 'Статус возврата', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3039, 'ru', 'No Refund', 'Отсутствие возврата', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3040, 'ru', 'Status updated successfully', 'Статус успешно обновлен', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3041, 'ru', 'User Search Report', 'Отчет о поиске пользователей', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3042, 'ru', 'Search By', 'Искать по', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3043, 'ru', 'Number searches', 'Числовые поиски', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3044, 'ru', 'Sender', 'Отправитель', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3045, 'ru', 'Receiver', 'Приемник', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3046, 'ru', 'Verification form updated successfully', 'Форма подтверждения успешно обновлена', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3047, 'ru', 'Invalid email or password', 'Неправильный адрес электронной почты или пароль', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3048, 'ru', 'All Coupons', 'Все купоны', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3049, 'ru', 'Add New Coupon', 'Добавить новый купон', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3050, 'ru', 'Coupon Information', 'Информация о купоне', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3051, 'ru', 'Start Date', 'Дата начала', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3052, 'ru', 'End Date', 'Дата окончания', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3053, 'ru', 'Product Base', 'База продуктов', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3054, 'ru', 'Send Newsletter', 'Отправить информационный бюллетень', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3055, 'ru', 'Mobile Users', 'Мобильные пользователи', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3056, 'ru', 'SMS subject', 'Тема сообщения SMS', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3057, 'ru', 'SMS content', 'Содержание SMS', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3058, 'ru', 'All Flash Delas', 'All Flash Delas', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3059, 'ru', 'Create New Flash Dela', 'Создать новую Flash Dela', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3060, 'ru', 'Page Link', 'Ссылка на страницу', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3061, 'ru', 'Flash Deal Information', 'Информация о Горящих предложениях', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3062, 'ru', 'Background Color', 'Фоновый цвет', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3063, 'ru', '#0000ff', '# 0000ff', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3064, 'ru', 'Text Color', 'Цвет текста', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3065, 'ru', 'White', 'белый', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3066, 'ru', 'Dark', 'Тьма', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3067, 'ru', 'Choose Products', 'Выберите продукты', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3068, 'ru', 'Discounts', 'Скидки', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3069, 'ru', 'Discount Type', 'Тип скидки', '2021-02-13 04:38:26', '2021-02-13 04:38:26'),
(3070, 'ru', 'Twillo Credential', 'Twillo Credential', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3071, 'ru', 'TWILIO SID', 'TWILIO SID', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3072, 'ru', 'TWILIO AUTH TOKEN', 'ЖЕТОН TWILIO AUTH', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3073, 'ru', 'TWILIO VERIFY SID', 'TWILIO VERIFY SID', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3074, 'ru', 'VALID TWILLO NUMBER', 'ДЕЙСТВИТЕЛЬНЫЙ НОМЕР TWILLO', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3075, 'ru', 'Nexmo Credential', 'Учетные данные Nexmo', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3076, 'ru', 'NEXMO KEY', 'КЛЮЧ NEXMO', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3077, 'ru', 'NEXMO SECRET', 'NEXMO SECRET', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3078, 'ru', 'SSL Wireless Credential', 'Учетные данные беспроводной связи SSL', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3079, 'ru', 'SSL SMS API TOKEN', 'SSL SMS API ТОКЕН', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3080, 'ru', 'SSL SMS SID', 'SSL SMS SID', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3081, 'ru', 'SSL SMS URL', 'SSL SMS URL', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3082, 'ru', 'Fast2SMS Credential', 'Учетные данные Fast2SMS', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3083, 'ru', 'AUTH KEY', 'КЛЮЧ AUTH', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3084, 'ru', 'ROUTE', 'МАРШРУТ', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3085, 'ru', 'Promotional Use', 'Рекламное использование', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3086, 'ru', 'Transactional Use', 'Транзакционное использование', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3087, 'ru', 'SENDER ID', 'УДОСТОВЕРЕНИЕ ЛИЧНОСТИ ОТПРАВИТЕЛЯ', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3088, 'ru', 'Nexmo OTP', 'Nexmo OTP', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3089, 'ru', 'Twillo OTP', 'Twillo OTP', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3090, 'ru', 'SSL Wireless OTP', 'SSL беспроводной OTP', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3091, 'ru', 'Fast2SMS OTP', 'Fast2SMS OTP', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3092, 'ru', 'Order Placement', 'Размещение заказа', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3093, 'ru', 'Delivery Status Changing Time', 'Время изменения статуса доставки', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3094, 'ru', 'Paid Status Changing Time', 'Время изменения платного статуса', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3095, 'ru', 'Send Bulk SMS', 'Отправка массовых SMS', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3096, 'ru', 'All Subscribers', 'Все подписчики', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3097, 'ru', 'Coupon Information Adding', 'Добавление информации о купоне', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3098, 'ru', 'Coupon Type', 'Тип купона', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3099, 'ru', 'For Products', 'Для продуктов', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3100, 'ru', 'For Total Orders', 'Для общих заказов', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3101, 'ru', 'Add Your Product Base Coupon', 'Добавьте купон на товарную базу', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3102, 'ru', 'Coupon code', 'Код купона', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3103, 'ru', 'Sub Category', 'Подкатегория', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3104, 'ru', 'Add More', 'Добавить больше', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3105, 'ru', 'Add Your Cart Base Coupon', 'Добавьте базовый купон в корзину', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3106, 'ru', 'Minimum Shopping', 'Минимум покупок', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3107, 'ru', 'Maximum Discount Amount', 'Максимальная сумма скидки', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3108, 'ru', 'Coupon Information Update', 'Обновление информации о купонах', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3109, 'ru', 'Please Configure SMTP Setting to work all email sending funtionality', 'Настройте параметры SMTP для работы всех функций отправки электронной почты', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3110, 'ru', 'Configure Now', 'Настроить сейчас', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3111, 'ru', 'Total published products', 'Всего опубликованных продуктов', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3112, 'ru', 'Total sellers products', 'Всего продавцов товаров', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3113, 'ru', 'Total admin products', 'Всего продуктов для администрирования', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3114, 'ru', 'Manage Products', 'Управлять продуктами', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3115, 'ru', 'Total product category', 'Общая категория продукта', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3116, 'ru', 'Create Category', 'Создать категорию', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3117, 'ru', 'Total product sub sub category', 'Общая подкатегория продукта', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3118, 'ru', 'Create Sub Sub Category', 'Создать подкатегорию', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3119, 'ru', 'Total product sub category', 'Итого подкатегория продуктов', '2021-02-13 04:38:40', '2021-02-13 04:38:40'),
(3120, 'ru', 'Create Sub Category', 'Создать подкатегорию', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3121, 'ru', 'Total product brand', 'Общий товарный бренд', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3122, 'ru', 'Create Brand', 'Создать бренд', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3123, 'ru', 'Total sellers', 'Всего продавцов', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3124, 'ru', 'Total approved sellers', 'Всего одобренных продавцов', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3125, 'ru', 'Total pending sellers', 'Всего ожидающих продавцов', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3126, 'ru', 'Manage Sellers', 'Управляйте продавцами', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3127, 'ru', 'Category wise product sale', 'Продажа товаров по категориям', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3128, 'ru', 'Sale', 'распродажа', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3129, 'ru', 'Category wise product stock', 'Товарный запас по категориям', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3130, 'ru', 'Category Name', 'Название категории', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3131, 'ru', 'Stock', 'Акции', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3132, 'ru', 'Frontend', 'Внешний интерфейс', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3133, 'ru', 'Home page', 'Домашняя страница', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3134, 'ru', 'setting', 'параметр', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3135, 'ru', 'Policy page', 'Страница политики', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3136, 'ru', 'General', 'Общий', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3137, 'ru', 'Click Here', 'Кликните сюда', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3138, 'ru', 'Useful link', 'Полезная ссылка', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3139, 'ru', 'Activation', 'Активация', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3140, 'ru', 'SMTP', 'SMTP', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3141, 'ru', 'Payment method', 'Метод оплаты', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3142, 'ru', 'Social media', 'Социальные медиа', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3143, 'ru', 'Business', 'Бизнес', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3144, 'ru', 'Seller verification', 'Проверка продавца', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3145, 'ru', 'form setting', 'настройка формы', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3146, 'ru', 'Language', 'Язык', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3147, 'ru', 'Dashboard', 'Приборная панель', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3148, 'ru', 'POS System', 'POS-система', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3149, 'ru', 'POS Manager', 'POS менеджер', '2021-02-13 04:38:52', '2021-02-13 04:38:52'),
(3150, 'ru', 'POS Configuration', 'Конфигурация POS', '2021-02-13 04:39:09', '2021-02-13 04:39:09'),
(3151, 'ru', 'Products', 'Товары', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3152, 'ru', 'Add New product', 'Добавить новый продукт', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3153, 'ru', 'All Products', 'Все продукты', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3154, 'ru', 'In House Products', 'Внутри дома продукты', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3155, 'ru', 'Seller Products', 'Товары продавца', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3156, 'ru', 'Digital Products', 'Цифровые продукты', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3157, 'ru', 'Bulk Import', 'Массовый импорт', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3158, 'ru', 'Bulk Export', 'Массовый экспорт', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3159, 'ru', 'Category', 'Категория', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3160, 'ru', 'Subcategory', 'Подкатегория', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3161, 'ru', 'Sub Subcategory', 'Подкатегория', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3162, 'ru', 'Brand', 'Марка', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3163, 'ru', 'Attribute', 'Атрибут', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3164, 'ru', 'Product Reviews', 'Обзоры продуктов', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3165, 'ru', 'Sales', 'Продажи', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3166, 'ru', 'All Orders', 'Все заказы', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3167, 'ru', 'Inhouse orders', 'Внутренние заказы', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3168, 'ru', 'Seller Orders', 'Заказы продавца', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3169, 'ru', 'Pick-up Point Order', 'Заказ пункта выдачи', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3170, 'ru', 'Refunds', 'Возврат', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3171, 'ru', 'Refund Requests', 'Запросы на возврат', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3172, 'ru', 'Approved Refund', 'Утвержденный возврат', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3173, 'ru', 'Refund Configuration', 'Конфигурация возврата', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3174, 'ru', 'Customers', 'Клиенты', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3175, 'ru', 'Customer list', 'Список клиентов', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3176, 'ru', 'Classified Products', 'Классифицированные продукты', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3177, 'ru', 'Classified Packages', 'Секретные пакеты', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3178, 'ru', 'Sellers', 'Продавцы', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3179, 'ru', 'All Seller', 'Все продавцы', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3180, 'ru', 'Payouts', 'Выплаты', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3181, 'ru', 'Payout Requests', 'Запросы на выплату', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3182, 'ru', 'Seller Commission', 'Комиссия продавца', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3183, 'ru', 'Seller Packages', 'Пакеты продавца', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3184, 'ru', 'Seller Verification Form', 'Форма подтверждения продавца', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3185, 'ru', 'Reports', 'Отчеты', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3186, 'ru', 'In House Product Sale', 'Продажа товаров внутри дома', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3187, 'ru', 'Seller Products Sale', 'Продажа товаров продавца', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3188, 'ru', 'Products Stock', 'Товары на складе', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3189, 'ru', 'Products wishlist', 'Список желаний продуктов', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3190, 'ru', 'User Searches', 'Пользовательские поиски', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3191, 'ru', 'Marketing', 'Маркетинг', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3192, 'ru', 'Flash deals', 'Флэш-предложения', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3193, 'ru', 'Newsletters', 'Информационные бюллетени', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3194, 'ru', 'Bulk SMS', 'Массовые SMS', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3195, 'ru', 'Subscribers', 'Подписчики', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3196, 'ru', 'Coupon', 'Купон', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3197, 'ru', 'Support', 'Поддерживать', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3198, 'ru', 'Ticket', 'Проездной билет', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3199, 'ru', 'Product Queries', 'Запросы по продукту', '2021-02-13 04:39:10', '2021-02-13 04:39:10'),
(3200, 'ru', 'Website Setup', 'Настройка веб-сайта', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3201, 'ru', 'Header', 'Заголовок', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3202, 'ru', 'Footer', 'Нижний колонтитул', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3203, 'ru', 'Pages', 'Страницы', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3204, 'ru', 'Appearance', 'Внешность', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3205, 'ru', 'Setup & Configurations', 'Настройка и конфигурации', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3206, 'ru', 'General Settings', 'общие настройки', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3207, 'ru', 'Features activation', 'Активация функций', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3208, 'ru', 'Languages', 'Языки', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3209, 'ru', 'Currency', 'Валюта', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3210, 'ru', 'Pickup point', 'Место сбора', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3211, 'ru', 'SMTP Settings', 'Настройки SMTP', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3212, 'ru', 'Payment Methods', 'Способы оплаты', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3213, 'ru', 'File System Configuration', 'Конфигурация файловой системы', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3214, 'ru', 'Social media Logins', 'Вход в социальные сети', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3215, 'ru', 'Analytics Tools', 'Инструменты Аналитики', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3216, 'ru', 'Facebook Chat', 'Facebook чат', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3217, 'ru', 'Google reCAPTCHA', 'Google reCAPTCHA', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3218, 'ru', 'Shipping Configuration', 'Конфигурация доставки', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3219, 'ru', 'Shipping Countries', 'Страны доставки', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3220, 'ru', 'Affiliate System', 'Партнерская система', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3221, 'ru', 'Affiliate Registration Form', 'Форма регистрации партнера', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3222, 'ru', 'Affiliate Configurations', 'Партнерские конфигурации', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3223, 'ru', 'Affiliate Users', 'Аффилированные пользователи', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3224, 'ru', 'Referral Users', 'Реферальные пользователи', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3225, 'ru', 'Affiliate Withdraw Requests', 'Партнерские запросы на вывод средств', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3226, 'ru', 'Offline Payment System', 'Оффлайн платежная система', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3227, 'ru', 'Manual Payment Methods', 'Способы оплаты вручную', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3228, 'ru', 'Offline Wallet Recharge', 'Пополнение кошелька офлайн', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3229, 'ru', 'Offline Customer Package Payments', 'Платежи в офлайн-режиме для клиентов', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3230, 'ru', 'Offline Seller Package Payments', 'Платежи за пакеты офлайн продавца', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3231, 'ru', 'Paytm Payment Gateway', 'Платежный шлюз Paytm', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3232, 'ru', 'Set Paytm Credentials', 'Установить учетные данные Paytm', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3233, 'ru', 'Club Point System', 'Система клубных баллов', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3234, 'ru', 'Club Point Configurations', 'Конфигурации Club Point', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3235, 'ru', 'Set Product Point', 'Установить точку продукта', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3236, 'ru', 'User Points', 'Пользовательские баллы', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3237, 'ru', 'OTP System', 'Система OTP', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3238, 'ru', 'OTP Configurations', 'Конфигурации OTP', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3239, 'ru', 'Set OTP Credentials', 'Установить учетные данные OTP', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3240, 'ru', 'Staffs', 'Штабы', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3241, 'ru', 'All staffs', 'Все сотрудники', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3242, 'ru', 'Staff permissions', 'Разрешения персонала', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3243, 'ru', 'Addon Manager', 'Менеджер аддонов', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3244, 'ru', 'Browse Website', 'Обзор веб-сайта', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3245, 'ru', 'POS', 'ПОЧТОВЫЙ', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3246, 'ru', 'Notifications', 'Уведомления', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3247, 'ru', 'new orders', 'новые заказы', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3248, 'ru', 'user-image', 'изображение пользователя', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3249, 'ru', 'Profile', 'Профиль', '2021-02-13 04:39:28', '2021-02-13 04:39:28'),
(3250, 'ru', 'Logout', 'Выйти', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3251, 'ru', 'Seller Policy', 'Политика продавца', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3252, 'ru', 'Be an affiliate partner', 'Будьте аффилированным партнером', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3253, 'ru', 'Total Earnings From', 'Общий доход от', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3254, 'ru', 'Client Subscription', 'Подписка клиента', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3255, 'ru', 'Product category', 'Категория продукта', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3256, 'ru', 'Product sub sub category', 'Подкатегория продукта', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3257, 'ru', 'Product sub category', 'Подкатегория продукта', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3258, 'ru', 'Product brand', 'Марка продукта', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3259, 'ru', 'Top Client Packages', 'Лучшие клиентские пакеты', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3260, 'ru', 'Top Freelancer Packages', 'Лучшие пакеты для фрилансеров', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3261, 'ru', 'Number of sale', 'Количество продаж', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3262, 'ru', 'Number of Stock', 'Количество акций', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3263, 'ru', 'Top 10 Products', '10 лучших продуктов', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3264, 'ru', 'Top 12 Products', 'Топ 12 продуктов', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3265, 'ru', 'Admin can not be a seller', 'Админ не может быть продавцом', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3266, 'ru', 'Filter by Rating', 'Фильтр по рейтингу', '2021-02-13 04:40:19', '2021-02-13 04:40:19'),
(3267, 'ru', 'Published reviews updated successfully', 'Опубликованные отзывы успешно обновлены', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3268, 'ru', 'Refund Sticker has been updated successfully', 'Стикер возврата успешно обновлен', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3269, 'ru', 'Edit Product', 'Редактировать продукт', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3270, 'ru', 'Meta Images', 'Мета-изображения', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3271, 'ru', 'Update Product', 'Обновить продукт', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3272, 'ru', 'Product has been deleted successfully', 'Товар был успешно удален', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3273, 'ru', 'Your Profile has been updated successfully!', 'Ваш профиль был успешно обновлен!', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3274, 'ru', 'Upload limit has been reached. Please upgrade your package.', 'Достигнут предел загрузки. Пожалуйста, обновите свой пакет.', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3275, 'ru', 'Add Your Product', 'Добавьте свой продукт', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3276, 'ru', 'Select a category', 'Выбрать категорию', '2021-02-13 04:40:34', '2021-02-13 04:40:34');
INSERT INTO `translations` (`id`, `lang`, `lang_key`, `lang_value`, `created_at`, `updated_at`) VALUES
(3277, 'ru', 'Select a brand', 'Выберите марку', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3278, 'ru', 'Product Unit', 'Единица продукта', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3279, 'ru', 'Minimum Qty.', 'Минимальное кол-во.', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3280, 'ru', 'Product Tag', 'Тег продукта', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3281, 'ru', 'Type & hit enter', 'Введите и нажмите Enter', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3282, 'ru', 'Videos', 'Ролики', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3283, 'ru', 'Video From', 'Видео от', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3284, 'ru', 'Video URL', 'Video URL', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3285, 'ru', 'Customer Choice', 'Выбор клиента', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3286, 'ru', 'PDF', 'PDF', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3287, 'ru', 'Choose PDF', 'Выбрать PDF', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3288, 'ru', 'Select Category', 'выберите категорию', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3289, 'ru', 'Target Category', 'Целевая категория', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3290, 'ru', 'subsubcategory', 'подкатегория', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3291, 'ru', 'Search Category', 'Категория поиска', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3292, 'ru', 'Search SubCategory', 'Подкатегория поиска', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3293, 'ru', 'Search SubSubCategory', 'Искать в подподкатегории', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3294, 'ru', 'Update your product', 'Обновите свой продукт', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3295, 'ru', 'Product has been updated successfully', 'Продукт успешно обновлен', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3296, 'ru', 'Add Your Digital Product', 'Добавьте свой цифровой продукт', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3297, 'ru', 'Active eCommerce CMS Update Process', 'Процесс обновления Active eCommerce CMS', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3298, 'ru', 'Codecanyon purchase code', 'Код покупки Codecanyon', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3299, 'ru', 'Database Name', 'Имя базы данных', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3300, 'ru', 'Database Username', 'Имя пользователя базы данных', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3301, 'ru', 'Database Password', 'Пароль базы данных', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3302, 'ru', 'Database Hostname', 'Имя хоста базы данных', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3303, 'ru', 'Update Now', 'Обновить сейчас', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3304, 'ru', 'Congratulations', 'Поздравления', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3305, 'ru', 'You have successfully completed the updating process. Please Login to continue', 'Вы успешно завершили процесс обновления. Пожалуйста, залогиньтесь для продолжения', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3306, 'ru', 'Go to Home', 'Идти домой', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3307, 'ru', 'Login to Admin panel', 'Войдите в админ панель', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3308, 'ru', 'S3 File System Credentials', 'Учетные данные файловой системы S3', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3309, 'ru', 'AWS_ACCESS_KEY_ID', 'AWS_ACCESS_KEY_ID', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3310, 'ru', 'AWS_SECRET_ACCESS_KEY', 'AWS_SECRET_ACCESS_KEY', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3311, 'ru', 'AWS_DEFAULT_REGION', 'AWS_DEFAULT_REGION', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3312, 'ru', 'AWS_BUCKET', 'AWS_BUCKET', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3313, 'ru', 'AWS_URL', 'AWS_URL', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3314, 'ru', 'S3 File System Activation', 'S3 File System Activation', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3315, 'ru', 'Your phone number', 'Твой номер телефона', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3316, 'ru', 'Zip File', 'ZIP-файл', '2021-02-13 04:40:34', '2021-02-13 04:40:34'),
(3317, 'ru', 'Install', 'Установить', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3318, 'ru', 'This version is not capable of installing Addons, Please update.', 'Эта версия не поддерживает установку дополнений, пожалуйста, обновите.', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3319, 'ru', 'Install/Update Addon', 'Установить / обновить аддон', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3320, 'ru', 'No Addon Installed', 'Аддон не установлен', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3321, 'ru', 'Search in menu', 'Искать в меню', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3322, 'ru', 'Uploaded Files', 'Загруженные файлы', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3323, 'ru', 'Shipping Cities', 'Города доставки', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3324, 'ru', 'System', 'Система', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3325, 'ru', 'Server status', 'Статус сервера', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3326, 'ru', 'Nothing Found', 'Ничего не найдено', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3327, 'ru', 'Language has been deleted successfully', 'Язык был успешно удален', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3328, 'ru', 'Order', 'Заказ', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3329, 'ru', 'update Language Info', 'обновить информацию о языке', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3330, 'ru', 'Type key & Enter', 'Введите ключ и введите', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3331, 'ru', 'Translations updated for ', 'Обновлены переводы для', '2021-02-13 04:40:49', '2021-02-13 04:40:49'),
(3332, 'uz', 'All Category', 'Barcha toifalar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3333, 'uz', 'All', 'Barcha', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3334, 'uz', 'Flash Sale', 'Flash sotuvi', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3335, 'uz', 'View More', 'Ko\'proq korish', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3336, 'uz', 'Add to wishlist', 'Istaklar ro\'yxatiga qo\'shish', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3337, 'uz', 'Add to compare', 'Taqqoslash uchun qo\'shing', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3338, 'uz', 'Add to cart', 'Savatchaga qo\'shish', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3339, 'uz', 'Club Point', 'Club Point', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3340, 'uz', 'Classified Ads', 'Tasniflangan e\'lonlar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3341, 'uz', 'Used', 'Ishlatilgan', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3342, 'uz', 'Top 10 Categories', 'Top 10 toifalar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3343, 'uz', 'View All Categories', 'Barcha toifalarni ko\'rish', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3344, 'uz', 'Top 10 Brands', 'Eng yaxshi 10 ta brend', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3345, 'uz', 'View All Brands', 'Barcha tovarlarni ko\'rish', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3346, 'uz', 'Terms & conditions', 'Shartlar va shartlar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3347, 'uz', 'Best Selling', 'Eng ko\'p sotiladigan', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3348, 'uz', 'Top 20', 'Top 20 toifalar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3349, 'uz', 'Featured Products', 'Tanlangan mahsulotlar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3350, 'uz', 'Best Sellers', 'Eng yaxshi sotuvchilar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3351, 'uz', 'Visit Store', 'Do\'konga tashrif buyuring', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3352, 'uz', 'Popular Suggestions', 'Ommabop takliflar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3353, 'uz', 'Category Suggestions', 'Toifadagi takliflar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3354, 'uz', 'Automobile & Motorcycle', 'Avtomobil va mototsikl', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3355, 'uz', 'Price range', 'Narxlar oralig\'i', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3356, 'uz', 'Filter by color', 'Rang bo\'yicha filtrlang', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3357, 'uz', 'Home', 'Uy', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3358, 'uz', 'Newest', 'Eng Yangilari', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3359, 'uz', 'Oldest', 'Eng eskilari', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3360, 'uz', 'Price low to high', 'Narxlari pastdan yuqorigacha', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3361, 'uz', 'Price high to low', 'Narxlari yuqoridan  pastgacha', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3362, 'uz', 'Brands', 'Tovar Belf', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3363, 'uz', 'All Brands', 'Barcha tovar belgisi', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3364, 'uz', 'All Sellers', 'Barcha Sotuvchilar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3365, 'uz', 'Inhouse product', 'Uy ichidagi mahsulot', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3366, 'uz', 'Message Seller', 'Xabar sotuvchisi', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3367, 'uz', 'Price', 'Narx', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3368, 'uz', 'Discount Price', 'Chegirma', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3369, 'uz', 'Color', 'Rang', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3370, 'uz', 'Quantity', 'Miqdor', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3371, 'uz', 'available', 'Mavjud', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3372, 'uz', 'Total Price', 'Umumiy narx', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3373, 'uz', 'Out of Stock', 'Sotuvda yo\'q', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3374, 'uz', 'Refund', 'Pulni qaytarish', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3375, 'uz', 'Share', 'Baham ko\'ring', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3376, 'uz', 'Sold By', 'Sotilgan', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3377, 'uz', 'customer reviews', 'mijozlarning sharhlari', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3378, 'uz', 'Top Selling Products', 'Eng ko\'p sotiladigan mahsulotlar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3379, 'uz', 'Description', 'Tavsif', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3380, 'uz', 'Video', 'Video', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3381, 'uz', 'Reviews', 'Sharhlar', '2021-02-13 06:30:33', '2021-02-13 06:30:33'),
(3382, 'uz', 'Download', 'Yuklab olish', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3383, 'uz', 'There have been no reviews for this product yet.', 'Ushbu mahsulot uchun hali sharhlar mavjud emas.', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3384, 'uz', 'Related products', 'Tegishli mahsulotlar', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3385, 'uz', 'Any query about this product', 'Ushbu mahsulot haqida har qanday so\'rov', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3386, 'uz', 'Product Name', 'Mahsulot nomi', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3387, 'uz', 'Your Question', 'Sizning savolingiz', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3388, 'uz', 'Send', 'Jonatish', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3389, 'uz', 'Use country code before number', 'Raqamdan oldin mamlakat kodidan foydalaning', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3390, 'uz', 'Remember Me', 'Meni eslaysizmi', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3391, 'uz', 'Dont have an account?', 'Hisobingiz yo\'qmi?', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3392, 'uz', 'Register Now', 'Hozir ro\'yxatdan o\'ting', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3393, 'uz', 'Or Login With', 'Yoki tizimga kiring', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3394, 'uz', 'oops..', 'Xato', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3395, 'uz', 'This item is out of stock!', 'Ushbu buyum mavjud emas!', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3396, 'uz', 'Back to shopping', 'Do\'konga qaytish', '2021-02-13 06:43:51', '2021-02-13 06:43:51'),
(3397, 'uz', 'Login to your account.', 'Hisobingizga kiring.', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3398, 'uz', 'Purchase History', 'Xaridlar tarixi', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3399, 'uz', 'New', 'Yangi', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3400, 'uz', 'Downloads', 'Yuklab olish', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3401, 'uz', 'Sent Refund Request', 'Pulni qaytarib berish so\'rovi yuborildi', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3402, 'uz', 'Product Bulk Upload', 'Mahsulotni ommaviy yuklash', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3403, 'uz', 'Orders', 'Buyurtmalar', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3404, 'uz', 'Recieved Refund Request', 'Pulni qaytarib berish to\'g\'risida so\'rov qabul qilindi', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3405, 'uz', 'Shop Setting', 'Do\'kon sozlamalari', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3406, 'uz', 'Payment History', 'To\'lov tarixi', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3407, 'uz', 'Money Withdraw', 'Pulni qaytarib olish', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3408, 'uz', 'Conversations', 'Suhbatlar', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3409, 'uz', 'My Wallet', 'Mening hamyonim', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3410, 'uz', 'Earning Points', 'Ishlash ballari', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3411, 'uz', 'Support Ticket', 'Yordam chiptasi', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3412, 'uz', 'Manage Profile', 'Profilni boshqarish', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3413, 'uz', 'Sold Amount', 'Sotilgan summa', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3414, 'uz', 'Your sold amount (current month)', 'Siz sotgan summa (joriy oy)', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3415, 'uz', 'Total Sold', 'Jami sotilgan', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3416, 'uz', 'Last Month Sold', 'O\'tgan oy sotildi', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3417, 'uz', 'Total sale', 'Jami sotish', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3418, 'uz', 'Total earnings', 'Jami daromad', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3419, 'uz', 'Successful orders', 'Muvaffaqiyatli buyurtmalar', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3420, 'uz', 'Total orders', 'Jami buyurtmalar', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3421, 'uz', 'Pending orders', 'Buyurtmalar kutilmoqda', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3422, 'uz', 'Cancelled orders', 'Buyurtmalar bekor qilindi', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3423, 'uz', 'Product', 'Mahsulot', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3424, 'uz', 'Purchased Package', 'Xarid qilingan paket', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3425, 'uz', 'Package Not Found', 'Paket topilmadi', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3426, 'uz', 'Upgrade Package', 'Paketni yangilang', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3427, 'uz', 'Shop', 'Do\'kon', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3428, 'uz', 'Manage & organize your shop', 'O\'zingizning do\'koningizni boshqaring va tartibga soling', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3429, 'uz', 'Go to setting', 'Sozlamalarga o\'ting', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3430, 'uz', 'Payment', 'To\'lov', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3431, 'uz', 'Configure your payment method', 'To\'lov usulini sozlang', '2021-02-13 06:43:52', '2021-02-13 06:43:52'),
(3432, 'en', 'Parent Category', 'Parent Category', '2021-02-13 06:46:43', '2021-02-13 06:46:43'),
(3433, 'en', 'Level', 'Level', '2021-02-13 06:46:43', '2021-02-13 06:46:43'),
(3434, 'en', 'Category Information', 'Category Information', '2021-02-13 06:46:48', '2021-02-13 06:46:48'),
(3435, 'en', 'Translatable', 'Translatable', '2021-02-13 06:46:48', '2021-02-13 06:46:48'),
(3436, 'en', 'No Parent', 'No Parent', '2021-02-13 06:46:49', '2021-02-13 06:46:49'),
(3437, 'en', 'Physical', 'Physical', '2021-02-13 06:46:49', '2021-02-13 06:46:49'),
(3438, 'en', 'Digital', 'Digital', '2021-02-13 06:46:49', '2021-02-13 06:46:49'),
(3439, 'en', '200x200', '200x200', '2021-02-13 06:46:49', '2021-02-13 06:46:49'),
(3440, 'en', '32x32', '32x32', '2021-02-13 06:46:49', '2021-02-13 06:46:49'),
(3441, 'en', 'System Default Currency', 'System Default Currency', '2021-02-13 06:50:07', '2021-02-13 06:50:07'),
(3442, 'en', 'Set Currency Formats', 'Set Currency Formats', '2021-02-13 06:50:07', '2021-02-13 06:50:07'),
(3443, 'en', 'Symbol Format', 'Symbol Format', '2021-02-13 06:50:07', '2021-02-13 06:50:07'),
(3444, 'en', 'Decimal Separator', 'Decimal Separator', '2021-02-13 06:50:07', '2021-02-13 06:50:07'),
(3445, 'en', 'No of decimals', 'No of decimals', '2021-02-13 06:50:07', '2021-02-13 06:50:07'),
(3446, 'en', 'All Currencies', 'All Currencies', '2021-02-13 06:50:07', '2021-02-13 06:50:07'),
(3447, 'en', 'Add New Currency', 'Add New Currency', '2021-02-13 06:50:07', '2021-02-13 06:50:07'),
(3448, 'en', 'Currency name', 'Currency name', '2021-02-13 06:50:07', '2021-02-13 06:50:07'),
(3449, 'en', 'Currency symbol', 'Currency symbol', '2021-02-13 06:50:07', '2021-02-13 06:50:07'),
(3450, 'en', 'Currency code', 'Currency code', '2021-02-13 06:50:07', '2021-02-13 06:50:07'),
(3451, 'en', 'Currency Status updated successfully', 'Currency Status updated successfully', '2021-02-13 06:50:07', '2021-02-13 06:50:07'),
(3452, 'en', 'Update Currency', 'Update Currency', '2021-02-13 06:50:18', '2021-02-13 06:50:18'),
(3453, 'en', 'Symbol', 'Symbol', '2021-02-13 06:50:18', '2021-02-13 06:50:18'),
(3454, 'en', 'Language has been updated successfully', 'Language has been updated successfully', '2021-02-13 06:52:22', '2021-02-13 06:52:22'),
(3455, 'en', 'Add New Brand', 'Add New Brand', '2021-02-13 07:12:19', '2021-02-13 07:12:19'),
(3456, 'en', '120x80', '120x80', '2021-02-13 07:12:19', '2021-02-13 07:12:19'),
(3457, 'en', 'Category has been updated successfully', 'Category has been updated successfully', '2021-02-13 07:14:03', '2021-02-13 07:14:03'),
(3458, 'en', 'This is used for search. Input those words by which cutomer can find this product.', 'This is used for search. Input those words by which cutomer can find this product.', '2021-02-13 07:30:18', '2021-02-13 07:30:18'),
(3459, 'en', 'These images are visible in product details page gallery. Use 600x600 sizes images.', 'These images are visible in product details page gallery. Use 600x600 sizes images.', '2021-02-13 07:30:18', '2021-02-13 07:30:18'),
(3460, 'en', 'This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.', 'This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.', '2021-02-13 07:30:19', '2021-02-13 07:30:19'),
(3461, 'en', 'Use proper link without extra parameter. Don\'t use short share link/embeded iframe code.', 'Use proper link without extra parameter. Don\'t use short share link/embeded iframe code.', '2021-02-13 07:30:19', '2021-02-13 07:30:19'),
(3462, 'en', 'Save Product', 'Save Product', '2021-02-13 07:30:19', '2021-02-13 07:30:19'),
(3463, 'en', 'Search your files', 'Search your files', '2021-02-13 07:36:56', '2021-02-13 07:36:56'),
(3464, 'en', 'Currency updated successfully', 'Currency updated successfully', '2021-02-13 07:45:35', '2021-02-13 07:45:35'),
(3465, 'en', 'Search result for ', 'Search result for ', '2021-02-13 08:38:12', '2021-02-13 08:38:12'),
(3466, 'en', 'All Attributes', 'All Attributes', '2021-02-13 08:39:03', '2021-02-13 08:39:03'),
(3467, 'en', 'Add New Attribute', 'Add New Attribute', '2021-02-13 08:39:04', '2021-02-13 08:39:04'),
(3468, 'en', 'Attribute Information', 'Attribute Information', '2021-02-13 08:39:24', '2021-02-13 08:39:24'),
(3469, 'en', 'Attribute has been updated successfully', 'Attribute has been updated successfully', '2021-02-13 08:39:59', '2021-02-13 08:39:59'),
(3470, 'en', 'Filter by date', 'Filter by date', '2021-02-13 08:41:42', '2021-02-13 08:41:42'),
(3471, 'en', 'Step 1', 'Step 1', '2021-02-13 08:45:44', '2021-02-13 08:45:44'),
(3472, 'en', 'Download the skeleton file and fill it with proper data', 'Download the skeleton file and fill it with proper data', '2021-02-13 08:45:44', '2021-02-13 08:45:44'),
(3473, 'en', 'You can download the example file to understand how the data must be filled', 'You can download the example file to understand how the data must be filled', '2021-02-13 08:45:44', '2021-02-13 08:45:44'),
(3474, 'en', 'Once you have downloaded and filled the skeleton file, upload it in the form below and submit', 'Once you have downloaded and filled the skeleton file, upload it in the form below and submit', '2021-02-13 08:45:44', '2021-02-13 08:45:44'),
(3475, 'en', 'After uploading products you need to edit them and set product\'s images and choices', 'After uploading products you need to edit them and set product\'s images and choices', '2021-02-13 08:45:44', '2021-02-13 08:45:44'),
(3476, 'en', 'Step 2', 'Step 2', '2021-02-13 08:45:44', '2021-02-13 08:45:44'),
(3477, 'en', 'Category and Brand should be in numerical id', 'Category and Brand should be in numerical id', '2021-02-13 08:45:44', '2021-02-13 08:45:44'),
(3478, 'en', 'You can download the pdf to get Category and Brand id', 'You can download the pdf to get Category and Brand id', '2021-02-13 08:45:44', '2021-02-13 08:45:44'),
(3479, 'en', 'Upload Product File', 'Upload Product File', '2021-02-13 08:45:44', '2021-02-13 08:45:44'),
(3480, 'en', 'Brand Information', 'Brand Information', '2021-02-13 09:18:19', '2021-02-13 09:18:19'),
(3481, 'en', 'Brand has been updated successfully', 'Brand has been updated successfully', '2021-02-13 09:19:05', '2021-02-13 09:19:05'),
(3482, 'en', 'Attribute has been deleted successfully', 'Attribute has been deleted successfully', '2021-02-13 09:33:01', '2021-02-13 09:33:01'),
(3483, 'en', 'All Customers', 'All Customers', '2021-02-13 09:54:33', '2021-02-13 09:54:33'),
(3484, 'en', 'Type email or name & Enter', 'Type email or name & Enter', '2021-02-13 09:54:33', '2021-02-13 09:54:33'),
(3485, 'en', 'Package', 'Package', '2021-02-13 09:54:33', '2021-02-13 09:54:33'),
(3486, 'en', 'Wallet Balance', 'Wallet Balance', '2021-02-13 09:54:33', '2021-02-13 09:54:33'),
(3487, 'en', 'Log in as this Customer', 'Log in as this Customer', '2021-02-13 09:54:33', '2021-02-13 09:54:33'),
(3488, 'en', 'Ban this Customer', 'Ban this Customer', '2021-02-13 09:54:33', '2021-02-13 09:54:33'),
(3489, 'en', 'Do you really want to ban this Customer?', 'Do you really want to ban this Customer?', '2021-02-13 09:54:33', '2021-02-13 09:54:33'),
(3490, 'en', 'Proceed!', 'Proceed!', '2021-02-13 09:54:33', '2021-02-13 09:54:33'),
(3491, 'en', 'Do you really want to unban this Customer?', 'Do you really want to unban this Customer?', '2021-02-13 09:54:33', '2021-02-13 09:54:33'),
(3492, 'en', 'Add New Seller', 'Add New Seller', '2021-02-13 09:54:43', '2021-02-13 09:54:43'),
(3493, 'en', 'Filter by Approval', 'Filter by Approval', '2021-02-13 09:54:43', '2021-02-13 09:54:43'),
(3494, 'en', 'Non-Approved', 'Non-Approved', '2021-02-13 09:54:43', '2021-02-13 09:54:43'),
(3495, 'en', 'Type name or email & Enter', 'Type name or email & Enter', '2021-02-13 09:54:43', '2021-02-13 09:54:43'),
(3496, 'en', 'Due to seller', 'Due to seller', '2021-02-13 09:54:43', '2021-02-13 09:54:43'),
(3497, 'en', 'Log in as this Seller', 'Log in as this Seller', '2021-02-13 09:54:43', '2021-02-13 09:54:43'),
(3498, 'en', 'Go to Payment', 'Go to Payment', '2021-02-13 09:54:43', '2021-02-13 09:54:43'),
(3499, 'en', 'Ban this seller', 'Ban this seller', '2021-02-13 09:54:43', '2021-02-13 09:54:43'),
(3500, 'en', 'Do you really want to ban this seller?', 'Do you really want to ban this seller?', '2021-02-13 09:54:44', '2021-02-13 09:54:44'),
(3501, 'en', 'Approved sellers updated successfully', 'Approved sellers updated successfully', '2021-02-13 09:54:44', '2021-02-13 09:54:44'),
(3502, 'en', 'Seller Payments', 'Seller Payments', '2021-02-13 09:54:50', '2021-02-13 09:54:50'),
(3503, 'en', 'Seller', 'Seller', '2021-02-13 09:54:50', '2021-02-13 09:54:50'),
(3504, 'en', 'Payment Details', 'Payment Details', '2021-02-13 09:54:50', '2021-02-13 09:54:50'),
(3505, 'en', 'Category has been inserted successfully', 'Category has been inserted successfully', '2021-02-13 10:35:16', '2021-02-13 10:35:16'),
(3506, 'en', 'Category has been deleted successfully', 'Category has been deleted successfully', '2021-02-13 10:38:54', '2021-02-13 10:38:54'),
(3507, 'en', 'Use Phone Instead', 'Use Phone Instead', '2021-02-13 14:42:51', '2021-02-13 14:42:51'),
(3508, 'en', 'Seller Account', 'Seller Account', '2021-02-13 15:08:56', '2021-02-13 15:08:56'),
(3509, 'en', 'Copy credentials', 'Copy credentials', '2021-02-13 15:08:56', '2021-02-13 15:08:56'),
(3510, 'en', 'Customer Account', 'Customer Account', '2021-02-13 15:08:56', '2021-02-13 15:08:56'),
(3511, 'en', 'Shop Logo', 'Shop Logo', '2021-02-13 15:09:20', '2021-02-13 15:09:20'),
(3512, 'en', 'Shop Address', 'Shop Address', '2021-02-13 15:09:20', '2021-02-13 15:09:20'),
(3513, 'en', 'Banner Settings', 'Banner Settings', '2021-02-13 15:09:20', '2021-02-13 15:09:20'),
(3514, 'en', 'Banners', 'Banners', '2021-02-13 15:09:20', '2021-02-13 15:09:20'),
(3515, 'en', 'We had to limit height to maintian consistancy. In some device both side of the banner might be cropped for height limitation.', 'We had to limit height to maintian consistancy. In some device both side of the banner might be cropped for height limitation.', '2021-02-13 15:09:20', '2021-02-13 15:09:20'),
(3516, 'en', 'Insert link with https ', 'Insert link with https ', '2021-02-13 15:09:20', '2021-02-13 15:09:20'),
(3517, 'en', 'About', 'About', '2021-02-13 15:16:49', '2021-02-13 15:16:49'),
(3518, 'en', 'Payout Info', 'Payout Info', '2021-02-13 15:16:49', '2021-02-13 15:16:49'),
(3519, 'en', 'Bank Acc Name', 'Bank Acc Name', '2021-02-13 15:16:49', '2021-02-13 15:16:49'),
(3520, 'en', 'Bank Acc Number', 'Bank Acc Number', '2021-02-13 15:16:49', '2021-02-13 15:16:49'),
(3521, 'en', 'Total Products', 'Total Products', '2021-02-13 15:16:49', '2021-02-13 15:16:49'),
(3522, 'en', 'Total Sold Amount', 'Total Sold Amount', '2021-02-13 15:16:49', '2021-02-13 15:16:49'),
(3523, 'en', 'Shop Info', 'Shop Info', '2021-02-13 15:17:00', '2021-02-13 15:17:00'),
(3524, 'en', 'Pay to seller', 'Pay to seller', '2021-02-13 15:17:14', '2021-02-13 15:17:14'),
(3525, 'en', 'Select Payment Method', 'Select Payment Method', '2021-02-13 15:17:15', '2021-02-13 15:17:15'),
(3526, 'en', 'Cash', 'Cash', '2021-02-13 15:17:15', '2021-02-13 15:17:15'),
(3527, 'en', 'Txn Code', 'Txn Code', '2021-02-13 15:17:15', '2021-02-13 15:17:15'),
(3528, 'en', 'Pay', 'Pay', '2021-02-13 15:17:15', '2021-02-13 15:17:15'),
(3529, 'en', 'Payment completed', 'Payment completed', '2021-02-13 15:17:24', '2021-02-13 15:17:24'),
(3530, 'en', 'Edit Seller Information', 'Edit Seller Information', '2021-02-13 15:17:35', '2021-02-13 15:17:35'),
(3531, 'en', 'Seller Information', 'Seller Information', '2021-02-13 15:17:35', '2021-02-13 15:17:35'),
(3532, 'en', 'of seller product price will be deducted from seller earnings', 'of seller product price will be deducted from seller earnings', '2021-02-13 15:19:24', '2021-02-13 15:19:24'),
(3533, 'en', 'This commission only works when Category Based Commission is turned off from Business Settings', 'This commission only works when Category Based Commission is turned off from Business Settings', '2021-02-13 15:19:24', '2021-02-13 15:19:24'),
(3534, 'en', 'Commission doesn\'t work if seller package system add-on is activated', 'Commission doesn\'t work if seller package system add-on is activated', '2021-02-13 15:19:24', '2021-02-13 15:19:24'),
(3535, 'en', 'Seller has been inserted successfully', 'Seller has been inserted successfully', '2021-02-13 15:22:01', '2021-02-13 15:22:01'),
(3536, 'en', 'All uploaded files', 'All uploaded files', '2021-02-13 15:22:57', '2021-02-13 15:22:57'),
(3537, 'en', 'Upload New File', 'Upload New File', '2021-02-13 15:22:57', '2021-02-13 15:22:57'),
(3538, 'en', 'All files', 'All files', '2021-02-13 15:22:57', '2021-02-13 15:22:57'),
(3539, 'en', 'Search', 'Search', '2021-02-13 15:22:57', '2021-02-13 15:22:57'),
(3540, 'en', 'Details Info', 'Details Info', '2021-02-13 15:22:57', '2021-02-13 15:22:57'),
(3541, 'en', 'Copy Link', 'Copy Link', '2021-02-13 15:22:57', '2021-02-13 15:22:57'),
(3542, 'en', 'Are you sure to delete this file?', 'Are you sure to delete this file?', '2021-02-13 15:22:58', '2021-02-13 15:22:58'),
(3543, 'en', 'File Info', 'File Info', '2021-02-13 15:22:58', '2021-02-13 15:22:58'),
(3544, 'en', 'Link copied to clipboard', 'Link copied to clipboard', '2021-02-13 15:22:58', '2021-02-13 15:22:58'),
(3545, 'en', 'Oops, unable to copy', 'Oops, unable to copy', '2021-02-13 15:22:58', '2021-02-13 15:22:58'),
(3546, 'en', 'Seller has been updated successfully', 'Seller has been updated successfully', '2021-02-13 15:23:22', '2021-02-13 15:23:22'),
(3547, 'en', 'HTTPS Activation', 'HTTPS Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3548, 'en', 'Maintenance Mode', 'Maintenance Mode', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3549, 'en', 'Maintenance Mode Activation', 'Maintenance Mode Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3550, 'en', 'Classified Product Activate', 'Classified Product Activate', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3551, 'en', 'Classified Product', 'Classified Product', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3552, 'en', 'Business Related', 'Business Related', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3553, 'en', 'Vendor System Activation', 'Vendor System Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3554, 'en', 'Wallet System Activation', 'Wallet System Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3555, 'en', 'Coupon System Activation', 'Coupon System Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3556, 'en', 'Pickup Point Activation', 'Pickup Point Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3557, 'en', 'Conversation Activation', 'Conversation Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3558, 'en', 'Guest Checkout Activation', 'Guest Checkout Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3559, 'en', 'Category-based Commission', 'Category-based Commission', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3560, 'en', 'After activate this option Seller commision will be disabled and You need to set commission on each category otherwise Admin will not get any commision', 'After activate this option Seller commision will be disabled and You need to set commission on each category otherwise Admin will not get any commision', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3561, 'en', 'Set Commisssion Now', 'Set Commisssion Now', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3562, 'en', 'Email Verification', 'Email Verification', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3563, 'en', 'Payment Related', 'Payment Related', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3564, 'en', 'Paypal Payment Activation', 'Paypal Payment Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3565, 'en', 'You need to configure Paypal correctly to enable this feature', 'You need to configure Paypal correctly to enable this feature', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3566, 'en', 'Stripe Payment Activation', 'Stripe Payment Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3567, 'en', 'SSlCommerz Activation', 'SSlCommerz Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3568, 'en', 'Instamojo Payment Activation', 'Instamojo Payment Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3569, 'en', 'You need to configure Instamojo Payment correctly to enable this feature', 'You need to configure Instamojo Payment correctly to enable this feature', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3570, 'en', 'Razor Pay Activation', 'Razor Pay Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3571, 'en', 'You need to configure Razor correctly to enable this feature', 'You need to configure Razor correctly to enable this feature', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3572, 'en', 'PayStack Activation', 'PayStack Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3573, 'en', 'You need to configure PayStack correctly to enable this feature', 'You need to configure PayStack correctly to enable this feature', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3574, 'en', 'VoguePay Activation', 'VoguePay Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3575, 'en', 'You need to configure VoguePay correctly to enable this feature', 'You need to configure VoguePay correctly to enable this feature', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3576, 'en', 'Payhere Activation', 'Payhere Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3577, 'en', 'Ngenius Activation', 'Ngenius Activation', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3578, 'en', 'You need to configure Ngenius correctly to enable this feature', 'You need to configure Ngenius correctly to enable this feature', '2021-02-13 15:23:49', '2021-02-13 15:23:49'),
(3579, 'en', 'Iyzico Activation', 'Iyzico Activation', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3580, 'en', 'You need to configure iyzico correctly to enable this feature', 'You need to configure iyzico correctly to enable this feature', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3581, 'en', 'Bkash Activation', 'Bkash Activation', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3582, 'en', 'You need to configure bkash correctly to enable this feature', 'You need to configure bkash correctly to enable this feature', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3583, 'en', 'Nagad Activation', 'Nagad Activation', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3584, 'en', 'You need to configure nagad correctly to enable this feature', 'You need to configure nagad correctly to enable this feature', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3585, 'en', 'Cash Payment Activation', 'Cash Payment Activation', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3586, 'en', 'Social Media Login', 'Social Media Login', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3587, 'en', 'Facebook login', 'Facebook login', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3588, 'en', 'You need to configure Facebook Client correctly to enable this feature', 'You need to configure Facebook Client correctly to enable this feature', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3589, 'en', 'Google login', 'Google login', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3590, 'en', 'You need to configure Google Client correctly to enable this feature', 'You need to configure Google Client correctly to enable this feature', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3591, 'en', 'Twitter login', 'Twitter login', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3592, 'en', 'You need to configure Twitter Client correctly to enable this feature', 'You need to configure Twitter Client correctly to enable this feature', '2021-02-13 15:23:50', '2021-02-13 15:23:50'),
(3593, 'en', 'Your Shop has been created successfully!', 'Your Shop has been created successfully!', '2021-02-13 15:24:16', '2021-02-13 15:24:16'),
(3594, 'en', 'Seller has been deleted successfully', 'Seller has been deleted successfully', '2021-02-13 15:25:46', '2021-02-13 15:25:46'),
(3595, 'en', '1. Category and Brand should be in numerical id.', '1. Category and Brand should be in numerical id.', '2021-02-13 15:27:02', '2021-02-13 15:27:02'),
(3596, 'en', '2. You can download the pdf to get Category and Brand id.', '2. You can download the pdf to get Category and Brand id.', '2021-02-13 15:27:02', '2021-02-13 15:27:02'),
(3597, 'en', 'Type and hit enter', 'Type and hit enter', '2021-02-13 15:29:28', '2021-02-13 15:29:28'),
(3598, 'en', 'You do not have enough balance to send withdraw request', 'You do not have enough balance to send withdraw request', '2021-02-13 15:29:56', '2021-02-13 15:29:56'),
(3599, 'en', 'Sendmail', 'Sendmail', '2021-02-14 04:47:38', '2021-02-14 04:47:38'),
(3600, 'en', 'Mailgun', 'Mailgun', '2021-02-14 04:47:38', '2021-02-14 04:47:38'),
(3601, 'en', 'MAIL HOST', 'MAIL HOST', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3602, 'en', 'MAIL PORT', 'MAIL PORT', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3603, 'en', 'MAIL USERNAME', 'MAIL USERNAME', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3604, 'en', 'MAIL PASSWORD', 'MAIL PASSWORD', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3605, 'en', 'MAIL ENCRYPTION', 'MAIL ENCRYPTION', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3606, 'en', 'MAIL FROM ADDRESS', 'MAIL FROM ADDRESS', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3607, 'en', 'MAIL FROM NAME', 'MAIL FROM NAME', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3608, 'en', 'MAILGUN DOMAIN', 'MAILGUN DOMAIN', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3609, 'en', 'MAILGUN SECRET', 'MAILGUN SECRET', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3610, 'en', 'Save Configuration', 'Save Configuration', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3611, 'en', 'Test SMTP configuration', 'Test SMTP configuration', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3612, 'en', 'Enter your email address', 'Enter your email address', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3613, 'en', 'Send test email', 'Send test email', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3614, 'en', 'Instruction', 'Instruction', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3615, 'en', 'Please be carefull when you are configuring SMTP. For incorrect configuration you will get error at the time of order place, new registration, sending newsletter.', 'Please be carefull when you are configuring SMTP. For incorrect configuration you will get error at the time of order place, new registration, sending newsletter.', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3616, 'en', 'For Non-SSL', 'For Non-SSL', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3617, 'en', 'Select sendmail for Mail Driver if you face any issue after configuring smtp as Mail Driver ', 'Select sendmail for Mail Driver if you face any issue after configuring smtp as Mail Driver ', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3618, 'en', 'Set Mail Host according to your server Mail Client Manual Settings', 'Set Mail Host according to your server Mail Client Manual Settings', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3619, 'en', 'Set Mail port as 587', 'Set Mail port as 587', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3620, 'en', 'Set Mail Encryption as ssl if you face issue with tls', 'Set Mail Encryption as ssl if you face issue with tls', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3621, 'en', 'For SSL', 'For SSL', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3622, 'en', 'Set Mail port as 465', 'Set Mail port as 465', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3623, 'en', 'Set Mail Encryption as ssl', 'Set Mail Encryption as ssl', '2021-02-14 04:47:39', '2021-02-14 04:47:39'),
(3624, 'en', 'Clear due', 'Clear due', '2021-02-15 03:16:03', '2021-02-15 03:16:03'),
(3625, 'en', 'Attribute has been inserted successfully', 'Attribute has been inserted successfully', '2021-02-15 06:23:38', '2021-02-15 06:23:38'),
(3626, 'en', 'Your order has been placed successfully', 'Your order has been placed successfully', '2021-02-15 06:41:12', '2021-02-15 06:41:12');

-- --------------------------------------------------------

--
-- Структура таблицы `uploads`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 11 2021 г., 15:33
--

DROP TABLE IF EXISTS `uploads`;
CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `file_original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `extension` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `uploads`
--

INSERT INTO `uploads` (`id`, `file_original_name`, `file_name`, `user_id`, `file_size`, `extension`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'phone', 'uploads/all/h2rd4ANauzdbJDbTuqPdo0LJI0c5v63wE8sMkZ88.jpg', 9, 36702, 'jpg', 'image', '2021-02-11 03:17:44', '2021-02-11 03:17:44', NULL),
(2, '6017196603', 'uploads/all/r27j5sHo6QfeaSrw9H11lsxIeVg3Jdygu5uIB3Cp.webp', 9, 142998, 'webp', 'image', '2021-02-11 10:21:26', '2021-02-11 10:21:26', NULL),
(3, 'poco', 'uploads/all/cNXzlxgqxNQsQLg0keOvFFJpicxIFbURSL8Sh8WS.webp', 9, 45406, 'webp', 'image', '2021-02-11 10:40:17', '2021-02-11 10:40:17', NULL),
(4, 'photo_2021-02-11_18-38-19', 'uploads/all/cZhpMkJASQEFLJ3PJHo0EjHqt4iiGqgH2iTrovbW.jpg', 9, 42983, 'jpg', 'image', '2021-02-11 10:43:37', '2021-02-11 10:43:37', NULL),
(5, 'photo_2021-02-11_18-54-52', 'uploads/all/z5GtrIhlYTBJLlkdrNwkr2s55x2NfCRXGDBAM8LL.jpg', 9, 78023, 'jpg', 'image', '2021-02-11 10:57:38', '2021-02-11 10:57:38', NULL),
(6, 'zxczxczxzxc', 'uploads/all/Zq8KOZJzzGiQJvLP3pyXI3nn0DcSrZJLnBmOr4Pa.jpg', 9, 26592, 'jpeg', 'image', '2021-02-11 11:01:27', '2021-02-11 11:01:27', NULL),
(7, 'photo_2021-02-11_19-00-48', 'uploads/all/xIc2KCht98voFKmPkHVLIR8ukGHiISozlKqOmCj2.jpg', 9, 134943, 'jpg', 'image', '2021-02-11 11:03:38', '2021-02-11 11:03:38', NULL),
(8, 'photo_2021-02-11_19-00-54', 'uploads/all/xDzW0L75u3AddPPtDfhmoLTRueDp4F9CretOopke.jpg', 9, 115616, 'jpg', 'image', '2021-02-11 11:03:57', '2021-02-11 11:03:57', NULL),
(9, 'photo_2021-02-11_19-11-18', 'uploads/all/9Q2LsuaV6q68sEIh1i7BnfDqxghamwzxuDJLDfBh.jpg', 9, 55845, 'jpg', 'image', '2021-02-11 11:13:57', '2021-02-11 11:13:57', NULL),
(10, 'photo_2021-02-11_19-11-24', 'uploads/all/2zLOpxSlUt7z51OiBu1twx5lhEHEdWvPUwYTxyK9.jpg', 9, 61677, 'jpg', 'image', '2021-02-11 11:13:57', '2021-02-11 11:13:57', NULL),
(11, 'photo_2021-02-11_19-15-46', 'uploads/all/yGJVAnjq5DZFZyNG5NFR0TcSCRkpInUxCHWJHpLp.jpg', 9, 27779, 'jpg', 'image', '2021-02-11 11:18:47', '2021-02-11 11:18:47', NULL),
(12, 'photo_2021-02-11_19-15-39', 'uploads/all/yTNOpy26iRqCOteIzu7SvCj6uih1AW9Rp7XK1D9B.jpg', 9, 88770, 'jpg', 'image', '2021-02-11 11:18:49', '2021-02-11 11:18:49', NULL),
(13, 'photo_2021-02-11_19-23-16', 'uploads/all/qSzC3m7uAlTL7LuLG3bcNnTTrFfHITb6RN0d1GMF.jpg', 9, 26486, 'jpg', 'image', '2021-02-11 11:26:06', '2021-02-11 11:26:06', NULL),
(14, 'image', 'uploads/all/aP0p3bGYxVobIM3NQMhNzfp1A8dd4A03Ms6Ndefk.png', 9, 1061805, 'png', 'image', '2021-02-11 11:34:15', '2021-02-11 11:34:15', NULL),
(15, 'Без названия', 'uploads/all/zTJCPq5yyCRQOJt3VoInkcmSzDCooOWVr3MF68FY.jpg', 9, 5689, 'jpeg', 'image', '2021-02-11 11:40:14', '2021-02-11 11:40:14', NULL),
(16, 'Без названия (1)', 'uploads/all/2LC1yp0PTj0GRtaTc7vQUREwE3GEnP9qsML0OC1m.jpg', 9, 5791, 'jpeg', 'image', '2021-02-11 11:45:55', '2021-02-11 11:45:55', NULL),
(17, 'Без названия (2)', 'uploads/all/rGTPtUR3p5x3rrV913L7hIvW6FAZbePir67XbPQs.jpg', 9, 5347, 'jpeg', 'image', '2021-02-11 11:45:56', '2021-02-11 11:45:56', NULL),
(18, 'zxc', 'uploads/all/lnU6UdZyk8KQslw2wg43ef5XGUgpfBVsM5CR2GAM.webp', 9, 238110, 'webp', 'image', '2021-02-11 11:53:34', '2021-02-11 11:53:34', NULL),
(19, 'image', 'uploads/all/wI2zUAlr9fiTLN7J8DLTt7lkB6xDjXqQJaMEOVo8.png', 9, 866316, 'png', 'image', '2021-02-11 11:57:03', '2021-02-11 11:57:03', NULL),
(20, 'image', 'uploads/all/MD1FlibkM9ja0aKVHsflg5ipuP2pDWEw2ihUqxwk.png', 9, 148876, 'png', 'image', '2021-02-11 12:02:31', '2021-02-11 12:02:31', NULL),
(21, 'image', 'uploads/all/RlqcH8yqfO6vZtNhcHCqr0EiOl6wOBhumIo5LEn1.png', 9, 967861, 'png', 'image', '2021-02-11 12:14:17', '2021-02-11 12:14:17', NULL),
(22, 'image', 'uploads/all/6nzuw1tUtHAMwv5Ucod6z79yWKepYsxtuIboknRa.png', 9, 113984, 'png', 'image', '2021-02-11 12:18:56', '2021-02-11 12:18:56', NULL),
(23, 'image', 'uploads/all/rmldlox2S0Da56gtyAJJ2WTnuN6Ql9zSkntvRu34.png', 9, 86606, 'png', 'image', '2021-02-11 12:19:12', '2021-02-11 12:19:12', NULL),
(24, 'image', 'uploads/all/I6aAkT5UphFcH8FQGDpoKwmGPouMqByQzOSzTZqQ.png', 9, 502641, 'png', 'image', '2021-02-11 12:24:17', '2021-02-11 12:24:17', NULL),
(25, 'image', 'uploads/all/rK6xw25VRplKfsYBpTPD2XdlhD9Ax6Jc2bJRIoAM.png', 9, 1438687, 'png', 'image', '2021-02-11 12:24:21', '2021-02-11 12:24:21', NULL),
(26, 'image', 'uploads/all/2230jHYQrApROQ5UvIYusRNZQQVwx0g1jbCDVyI7.png', 9, 120808, 'png', 'image', '2021-02-11 12:32:52', '2021-02-11 12:32:52', NULL),
(27, 'image', 'uploads/all/c36E1Sqk9jj3tXVDLK4FVLOPR6JjcXGQ689E5lJM.png', 9, 1659423, 'png', 'image', '2021-02-11 12:33:11', '2021-02-11 12:33:11', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
-- Создание: Фев 12 2021 г., 15:20
-- Последнее обновление: Фев 15 2021 г., 12:55
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `referred_by` int(11) DEFAULT NULL,
  `provider_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'customer',
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `verification_code` text COLLATE utf8_unicode_ci,
  `new_email_verificiation_code` text COLLATE utf8_unicode_ci,
  `password` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_original` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `balance` double(20,2) NOT NULL DEFAULT '0.00',
  `banned` tinyint(4) NOT NULL DEFAULT '0',
  `referral_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_package_id` int(11) DEFAULT NULL,
  `remaining_uploads` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_address` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `referred_by`, `provider_id`, `user_type`, `name`, `email`, `email_verified_at`, `verification_code`, `new_email_verificiation_code`, `password`, `remember_token`, `avatar`, `avatar_original`, `address`, `country`, `city`, `postal_code`, `phone`, `balance`, `banned`, `referral_code`, `customer_package_id`, `remaining_uploads`, `created_at`, `updated_at`, `profile_image`, `full_name`, `date_of_birth`, `gender`, `full_address`) VALUES
(3, NULL, NULL, 'seller', 'Mr. Seller', 'seller@example.com', '2018-12-11 18:00:00', NULL, NULL, '$2y$10$eUKRlkmm2TAug75cfGQ4i.WoUbcJ2uVPqUlVkox.cv4CCyGEIMQEm', '4fmZw1fPJPR7L1gOljDsG4S6zg8ra3u7TaWWOoHjVDME8TtolQbnUYKgTXMu', 'https://lh3.googleusercontent.com/-7OnRtLyua5Q/AAAAAAAAAAI/AAAAAAAADRk/VqWKMl4f8CI/photo.jpg?sz=50', NULL, 'Demo address', 'US', 'Demo city', '1234', NULL, 0.00, 0, '3dLUoHsR1l', NULL, NULL, '2018-10-07 04:42:57', '2020-03-05 01:33:22', NULL, NULL, NULL, NULL, NULL),
(8, NULL, NULL, 'customer', 'Mr. Customer', 'customer@example.com', '2018-12-11 18:00:00', NULL, NULL, '$2y$10$eUKRlkmm2TAug75cfGQ4i.WoUbcJ2uVPqUlVkox.cv4CCyGEIMQEm', 'Rk9sR2oB9EGX1yANKVJv0GJrdxDVOetIIkrJZrhHZqtv8RGM4lNoriTkdZbC', 'https://lh3.googleusercontent.com/-7OnRtLyua5Q/AAAAAAAAAAI/AAAAAAAADRk/VqWKMl4f8CI/photo.jpg?sz=50', NULL, 'Demo address', 'US', 'Demo city', '1234', NULL, 0.00, 0, '8zJTyXTlTT', NULL, NULL, '2018-10-07 04:42:57', '2020-03-03 04:26:11', NULL, NULL, NULL, NULL, NULL),
(9, NULL, NULL, 'admin', 'Admin', 'admin@admin.uz', '2021-02-08 00:02:26', NULL, NULL, '$2y$10$mE4ubJN0sVHElxiO5Lj.SOLd43ghnzDmltMddUPFm0iGZLdz1ms.O', '7n1mHjHYUf9hfYswQc9Vf4aRl3oonloBxJmGkckG6cSQsf60HIaZnFjYOB3U', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, NULL, NULL, 0, '2021-02-08 00:17:26', '2021-02-08 00:17:26', NULL, NULL, NULL, NULL, NULL),
(10, NULL, NULL, 'customer', 'Asadbek', 'asad.lion.0607@mail.ru', '2021-02-12 11:02:09', NULL, NULL, '$2y$10$BwtdShYL4ZvhW5tr7bjE3u3ElrbLSj98EydGpnR4C/i3w.Rspdt1i', NULL, 'public/images/avatar/avatar-1613145131.png', NULL, NULL, NULL, NULL, NULL, '998977808008', 0.00, 0, NULL, NULL, 0, '2021-02-12 11:50:09', '2021-02-15 09:50:41', NULL, 'Asadbek Akhrarov Rovshanovich', '2001-10-16 00:00:00', '1', NULL),
(12, NULL, NULL, 'seller', 'Test', 'test@test.uz', '2021-02-13 15:02:16', NULL, NULL, '$2y$10$EhUAJT0KSOmzBXaItV8pPOK.tf080D2roJj/cMzXw8Mg5U6xbwNv.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0, NULL, NULL, 0, '2021-02-13 15:24:16', '2021-02-13 15:24:16', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `wallets`
--
-- Создание: Фев 11 2021 г., 05:56
--

DROP TABLE IF EXISTS `wallets`;
CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_details` longtext COLLATE utf8_unicode_ci,
  `approval` int(1) NOT NULL DEFAULT '0',
  `offline_payment` int(1) NOT NULL DEFAULT '0',
  `reciept` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `wishlists`
--
-- Создание: Фев 11 2021 г., 05:56
-- Последнее обновление: Фев 15 2021 г., 09:45
--

DROP TABLE IF EXISTS `wishlists`;
CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(10, 10, 5, '2021-02-12 12:26:59', '2021-02-12 12:26:59'),
(16, 10, 4, '2021-02-15 06:45:02', '2021-02-15 06:45:02'),
(17, 10, 10, '2021-02-15 06:45:03', '2021-02-15 06:45:03');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `affiliate_configs`
--
ALTER TABLE `affiliate_configs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `affiliate_options`
--
ALTER TABLE `affiliate_options`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `affiliate_payments`
--
ALTER TABLE `affiliate_payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `affiliate_users`
--
ALTER TABLE `affiliate_users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `affiliate_withdraw_requests`
--
ALTER TABLE `affiliate_withdraw_requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `attribute_translations`
--
ALTER TABLE `attribute_translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `brand_translations`
--
ALTER TABLE `brand_translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `business_settings`
--
ALTER TABLE `business_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slug` (`slug`);

--
-- Индексы таблицы `category_translations`
--
ALTER TABLE `category_translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `city_translations`
--
ALTER TABLE `city_translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `club_points`
--
ALTER TABLE `club_points`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `club_point_details`
--
ALTER TABLE `club_point_details`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `customer_packages`
--
ALTER TABLE `customer_packages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `customer_package_payments`
--
ALTER TABLE `customer_package_payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `customer_package_translations`
--
ALTER TABLE `customer_package_translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `customer_products`
--
ALTER TABLE `customer_products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `customer_product_translations`
--
ALTER TABLE `customer_product_translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_deals`
--
ALTER TABLE `flash_deals`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flash_deal_translations`
--
ALTER TABLE `flash_deal_translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `home_categories`
--
ALTER TABLE `home_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `manual_payment_methods`
--
ALTER TABLE `manual_payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Индексы таблицы `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Индексы таблицы `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Индексы таблицы `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `otp_configurations`
--
ALTER TABLE `otp_configurations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `page_translations`
--
ALTER TABLE `page_translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pickup_points`
--
ALTER TABLE `pickup_points`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pickup_point_translations`
--
ALTER TABLE `pickup_point_translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `tags` (`tags`(255));

--
-- Индексы таблицы `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_translations`
--
ALTER TABLE `product_translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role_translations`
--
ALTER TABLE `role_translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `searches`
--
ALTER TABLE `searches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Индексы таблицы `seller_packages`
--
ALTER TABLE `seller_packages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `seller_withdraw_requests`
--
ALTER TABLE `seller_withdraw_requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `seo_settings`
--
ALTER TABLE `seo_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `addons`
--
ALTER TABLE `addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `affiliate_configs`
--
ALTER TABLE `affiliate_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `affiliate_options`
--
ALTER TABLE `affiliate_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `affiliate_payments`
--
ALTER TABLE `affiliate_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `affiliate_users`
--
ALTER TABLE `affiliate_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `affiliate_withdraw_requests`
--
ALTER TABLE `affiliate_withdraw_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `attribute_translations`
--
ALTER TABLE `attribute_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `brand_translations`
--
ALTER TABLE `brand_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `business_settings`
--
ALTER TABLE `business_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT для таблицы `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=895;

--
-- AUTO_INCREMENT для таблицы `category_translations`
--
ALTER TABLE `category_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1037;

--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `city_translations`
--
ALTER TABLE `city_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `club_points`
--
ALTER TABLE `club_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `club_point_details`
--
ALTER TABLE `club_point_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT для таблицы `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT для таблицы `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `customer_packages`
--
ALTER TABLE `customer_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `customer_package_payments`
--
ALTER TABLE `customer_package_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `customer_package_translations`
--
ALTER TABLE `customer_package_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `customer_products`
--
ALTER TABLE `customer_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `customer_product_translations`
--
ALTER TABLE `customer_product_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `flash_deals`
--
ALTER TABLE `flash_deals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `flash_deal_translations`
--
ALTER TABLE `flash_deal_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `home_categories`
--
ALTER TABLE `home_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `manual_payment_methods`
--
ALTER TABLE `manual_payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `otp_configurations`
--
ALTER TABLE `otp_configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `page_translations`
--
ALTER TABLE `page_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `pickup_points`
--
ALTER TABLE `pickup_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `pickup_point_translations`
--
ALTER TABLE `pickup_point_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `policies`
--
ALTER TABLE `policies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT для таблицы `product_translations`
--
ALTER TABLE `product_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `refund_requests`
--
ALTER TABLE `refund_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `role_translations`
--
ALTER TABLE `role_translations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `searches`
--
ALTER TABLE `searches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `seller_packages`
--
ALTER TABLE `seller_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `seller_withdraw_requests`
--
ALTER TABLE `seller_withdraw_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `seo_settings`
--
ALTER TABLE `seo_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3627;

--
-- AUTO_INCREMENT для таблицы `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
