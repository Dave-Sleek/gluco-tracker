-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2025 at 11:34 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_sugar`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `expiration` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('glucotracker_cache_356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1752872362),
('glucotracker_cache_356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1752872361;', 1752872361),
('glucotracker_cache_ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'i:1;', 1753248992),
('glucotracker_cache_ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4:timer', 'i:1753248992;', 1753248992),
('glucotracker_cache_ip_location_127.0.0.1', 's:20:\"Location unavailable\";', 1753650031);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Town Hall Gist', 'townhallgist@gmail.com', 'Thank you for this wonderful app you created...', '2025-07-21 23:53:46', '2025-07-21 23:53:46'),
(2, 'Town Hall Gist', 'townhallgist@gmail.com', 'I love this software...', '2025-07-23 06:57:29', '2025-07-23 06:57:29');

-- --------------------------------------------------------

--
-- Table structure for table `conversions`
--

CREATE TABLE `conversions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `original_value` float NOT NULL,
  `original_unit` enum('mg/dL','mmol/L') NOT NULL,
  `converted_value` float NOT NULL,
  `converted_unit` enum('mg/dL','mmol/L') NOT NULL,
  `converted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `favorite` tinyint(1) DEFAULT 0,
  `label` varchar(255) DEFAULT NULL,
  `type` enum('fasting','after_meal','calendar','all_values') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversions`
--

INSERT INTO `conversions` (`id`, `user_id`, `original_value`, `original_unit`, `converted_value`, `converted_unit`, `converted_at`, `favorite`, `label`, `type`) VALUES
(1, 1, 128, 'mg/dL', 7.1, 'mmol/L', '2025-05-25 21:44:47', 0, '', 'fasting'),
(2, 1, 128, 'mg/dL', 7.1, 'mmol/L', '2025-05-27 11:58:00', 0, NULL, 'fasting'),
(3, 1, 150, 'mg/dL', 8.32, 'mmol/L', '2025-05-27 11:58:17', 0, NULL, 'fasting'),
(4, 1, 5.3, 'mmol/L', 95.5, 'mg/dL', '2025-05-27 11:58:33', 0, NULL, 'fasting'),
(5, 1, 2.8, 'mmol/L', 50.45, 'mg/dL', '2025-05-27 11:58:55', 0, NULL, 'fasting'),
(6, 1, 2, 'mmol/L', 36.04, 'mg/dL', '2025-05-27 11:58:59', 0, NULL, 'fasting'),
(7, 1, 80.1, 'mmol/L', 4.45, 'mg/dL', '2025-05-27 11:59:04', 0, 'Feeling Dizzy', 'fasting'),
(8, 1, 105, 'mg/dL', 5.83, 'mmol/L', '2025-05-29 16:11:31', 0, NULL, 'after_meal'),
(9, 1, 115, 'mg/dL', 6.38, 'mmol/L', '2025-05-29 16:13:15', 0, NULL, 'after_meal'),
(10, 1, 150, 'mg/dL', 8.32, 'mmol/L', '2025-05-29 16:14:14', 0, NULL, 'after_meal'),
(11, 1, 140, 'mg/dL', 7.77, 'mmol/L', '2025-05-29 16:14:43', 0, NULL, 'after_meal'),
(12, 1, 118, 'mg/dL', 6.55, 'mmol/L', '2025-05-29 16:16:32', 0, NULL, 'fasting'),
(13, 1, 125, 'mg/dL', 6.94, 'mmol/L', '2025-05-29 16:27:23', 0, NULL, 'after_meal'),
(14, 1, 95, 'mg/dL', 5.27, 'mmol/L', '2025-05-29 16:30:42', 0, NULL, 'fasting'),
(15, 1, 240, 'mg/dL', 13.32, 'mmol/L', '2025-05-29 16:44:51', 0, NULL, 'after_meal'),
(16, 5, 150, 'mg/dL', 8.32, 'mmol/L', '2025-06-02 00:02:32', 0, NULL, 'after_meal'),
(17, 5, 140, 'mg/dL', 7.77, 'mmol/L', '2025-06-02 00:05:02', 0, NULL, 'after_meal'),
(18, 1, 138, 'mg/dL', 7.66, 'mmol/L', '2025-06-02 17:10:17', 0, NULL, 'after_meal'),
(19, 1, 90, 'mg/dL', 4.99, 'mmol/L', '2025-06-06 23:13:00', 0, NULL, 'fasting'),
(20, 2, 99, 'mg/dL', 5.49, 'mmol/L', '2025-06-07 16:12:06', 0, NULL, 'fasting'),
(21, 1, 88, 'mg/dL', 4.88, 'mmol/L', '2025-06-07 18:27:15', 0, NULL, 'fasting'),
(22, 1, 75, 'mg/dL', 4.16, 'mmol/L', '2025-06-07 22:33:14', 0, NULL, 'fasting'),
(23, 1, 85, 'mg/dL', 4.72, 'mmol/L', '2025-06-07 22:38:54', 0, NULL, 'fasting'),
(24, 1, 90, 'mg/dL', 4.99, 'mmol/L', '2025-06-07 23:00:31', 0, NULL, 'fasting'),
(25, 1, 94, 'mg/dL', 5.22, 'mmol/L', '2025-06-07 23:15:03', 0, NULL, 'fasting'),
(26, 1, 90, 'mg/dL', 4.99, 'mmol/L', '2025-06-07 23:18:41', 0, NULL, 'fasting'),
(27, 1, 88, 'mg/dL', 4.88, 'mmol/L', '2025-06-07 23:20:18', 0, NULL, 'fasting'),
(28, 1, 79, 'mg/dL', 4.38, 'mmol/L', '2025-06-07 23:30:47', 0, NULL, 'fasting'),
(29, 1, 92, 'mg/dL', 5.11, 'mmol/L', '2025-06-07 23:51:18', 0, NULL, 'fasting'),
(30, 1, 70, 'mg/dL', 3.88, 'mmol/L', '2025-06-08 00:00:12', 0, NULL, 'fasting'),
(31, 1, 77, 'mg/dL', 4.27, 'mmol/L', '2025-06-08 00:07:29', 0, NULL, 'fasting'),
(32, 1, 76, 'mg/dL', 4.22, 'mmol/L', '2025-06-08 00:17:00', 0, NULL, 'fasting'),
(33, 1, 81, 'mg/dL', 4.5, 'mmol/L', '2025-06-08 00:27:32', 0, NULL, 'fasting'),
(34, 1, 75, 'mg/dL', 4.16, 'mmol/L', '2025-06-08 00:28:51', 0, NULL, 'fasting'),
(35, 1, 79, 'mg/dL', 4.38, 'mmol/L', '2025-06-08 00:33:33', 0, NULL, 'fasting'),
(36, 1, 87, 'mg/dL', 4.83, 'mmol/L', '2025-06-08 00:35:01', 0, NULL, 'fasting'),
(37, 1, 100, 'mg/dL', 5.55, 'mmol/L', '2025-06-08 00:35:18', 0, NULL, 'after_meal'),
(38, 1, 92, 'mg/dL', 5.11, 'mmol/L', '2025-06-08 00:36:32', 0, NULL, 'fasting'),
(39, 1, 83, 'mg/dL', 4.61, 'mmol/L', '2025-06-08 00:39:51', 0, NULL, 'fasting'),
(40, 1, 81, 'mg/dL', 4.5, 'mmol/L', '2025-06-08 00:41:22', 0, NULL, 'fasting'),
(41, 1, 84, 'mg/dL', 4.66, 'mmol/L', '2025-06-08 00:47:04', 0, NULL, 'fasting'),
(42, 1, 93, 'mg/dL', 5.16, 'mmol/L', '2025-06-08 00:48:22', 0, NULL, 'fasting'),
(43, 1, 80, 'mg/dL', 4.44, 'mmol/L', '2025-06-08 00:50:47', 0, NULL, 'fasting'),
(44, 1, 95, 'mg/dL', 5.27, 'mmol/L', '2025-06-08 00:52:13', 0, NULL, 'fasting'),
(45, 5, 88, 'mg/dL', 4.88, 'mmol/L', '2025-06-08 01:37:38', 0, NULL, 'fasting'),
(46, 5, 250, 'mg/dL', 13.87, 'mmol/L', '2025-06-08 12:48:24', 0, NULL, 'after_meal'),
(47, 1, 150, 'mg/dL', 8.32, 'mmol/L', '2025-06-08 16:44:39', 0, NULL, 'after_meal'),
(48, 3, 160, 'mg/dL', 8.88, 'mmol/L', '2025-06-08 16:45:20', 0, NULL, 'after_meal'),
(49, 3, 260, 'mg/dL', 14.43, 'mmol/L', '2025-06-08 16:46:32', 0, NULL, 'after_meal'),
(50, 3, 90, 'mg/dL', 4.99, 'mmol/L', '2025-06-08 16:48:45', 0, NULL, 'fasting'),
(51, 3, 190, 'mg/dL', 10.54, 'mmol/L', '2025-06-08 16:54:03', 0, NULL, 'after_meal'),
(52, 3, 108, 'mg/dL', 5.99, 'mmol/L', '2025-06-08 17:00:50', 0, NULL, 'fasting'),
(53, 3, 100, 'mg/dL', 5.55, 'mmol/L', '2025-06-08 17:01:29', 0, NULL, 'fasting'),
(54, 3, 150, 'mg/dL', 8.32, 'mmol/L', '2025-06-08 17:08:12', 0, NULL, 'after_meal'),
(55, 1, 250, 'mg/dL', 13.87, 'mmol/L', '2025-06-08 17:14:27', 0, NULL, 'after_meal'),
(56, 1, 100, 'mg/dL', 5.55, 'mmol/L', '2025-06-16 10:07:07', 0, NULL, 'fasting'),
(57, 1, 85, 'mg/dL', 4.72, 'mmol/L', '2025-06-16 10:23:27', 0, NULL, 'fasting'),
(58, 5, 125, 'mg/dL', 6.94, 'mmol/L', '2025-06-16 15:39:20', 0, NULL, 'after_meal'),
(59, 5, 135, 'mg/dL', 7.49, 'mmol/L', '2025-06-29 20:37:54', 0, NULL, 'after_meal'),
(60, 1, 180, 'mg/dL', 9.99, 'mmol/L', '2025-07-02 19:27:31', 0, NULL, 'after_meal'),
(61, 1, 172, 'mg/dL', 9.6, 'mmol/L', '2025-07-05 13:15:08', 0, NULL, 'after_meal'),
(62, 1, 90, 'mg/dL', 5, 'mmol/L', '2025-07-05 13:23:24', 0, NULL, 'fasting'),
(63, 1, 140, 'mg/dL', 7.8, 'mmol/L', '2025-07-05 13:27:45', 0, NULL, 'after_meal'),
(64, 1, 100, 'mg/dL', 5.6, 'mmol/L', '2025-07-05 13:37:14', 0, 'Before Bed', 'fasting'),
(65, 1, 181, 'mg/dL', 10.1, 'mmol/L', '2025-07-05 14:31:41', 0, 'Afternoon', 'after_meal'),
(66, 1, 150, 'mg/dL', 8.3, 'mmol/L', '2025-07-05 14:49:30', 0, 'Afternoon', 'after_meal'),
(67, 1, 90, 'mg/dL', 5, 'mmol/L', '2025-07-05 15:07:36', 0, 'Morning', 'fasting'),
(68, 1, 99, 'mg/dL', 5.5, 'mmol/L', '2025-07-05 15:10:11', 0, 'Morning', 'fasting'),
(69, 1, 180, 'mg/dL', 10, 'mmol/L', '2025-07-05 15:46:05', 0, 'Afternoon', 'after_meal'),
(70, 1, 190, 'mg/dL', 10.6, 'mmol/L', '2025-07-05 15:47:06', 0, 'Evening', 'after_meal'),
(71, 1, 80, 'mg/dL', 4.4, 'mmol/L', '2025-07-05 15:55:37', 0, 'Morning', 'fasting'),
(72, 1, 5.5, 'mmol/L', 99, 'mg/dL', '2025-07-05 15:57:20', 0, 'Morning', 'fasting'),
(73, 1, 99, 'mg/dL', 5.5, 'mmol/L', '2025-07-05 16:11:02', 0, 'Morning', 'fasting'),
(74, 1, 135, 'mg/dL', 7.5, 'mmol/L', '2025-07-05 16:11:35', 0, 'Afternoon', 'after_meal'),
(75, 1, 300, 'mg/dL', 16.7, 'mmol/L', '2025-07-05 16:12:44', 0, 'Afternoon', 'after_meal'),
(76, 1, 140, 'mg/dL', 7.8, 'mmol/L', '2025-07-05 16:29:08', 0, 'Evening', 'after_meal'),
(77, 1, 100, 'mg/dL', 5.6, 'mmol/L', '2025-07-05 17:05:45', 0, 'Morning', 'fasting'),
(78, 1, 99, 'mg/dL', 5.5, 'mmol/L', '2025-07-05 17:10:46', 0, 'Morning', 'fasting'),
(79, 1, 100, 'mg/dL', 5.6, 'mmol/L', '2025-07-05 17:15:01', 0, 'Morning', 'fasting'),
(80, 1, 139, 'mg/dL', 7.7, 'mmol/L', '2025-07-05 17:16:59', 0, 'Morning', 'after_meal'),
(81, 1, 139, 'mg/dL', 7.7, 'mmol/L', '2025-07-05 17:26:42', 0, 'Afternoon', 'after_meal'),
(82, 1, 190, 'mg/dL', 10.6, 'mmol/L', '2025-07-05 17:38:38', 0, 'Afternoon', 'after_meal'),
(83, 1, 180, 'mg/dL', 10, 'mmol/L', '2025-07-05 17:39:27', 0, 'Morning', 'fasting'),
(84, 1, 80, 'mg/dL', 4.4, 'mmol/L', '2025-07-05 17:40:12', 0, 'Morning', 'fasting'),
(85, 1, 40, 'mg/dL', 2.2, 'mmol/L', '2025-07-05 17:41:40', 0, 'Morning', 'fasting'),
(86, 1, 125, 'mg/dL', 6.9, 'mmol/L', '2025-07-06 14:08:47', 0, 'Morning', 'after_meal'),
(87, 1, 110, 'mg/dL', 6.1, 'mmol/L', '2025-07-07 11:58:19', 0, 'Afternoon', 'after_meal'),
(88, 1, 110, 'mg/dL', 6.1, 'mmol/L', '2025-07-07 12:07:12', 0, 'Morning', 'fasting'),
(89, 1, 110, 'mg/dL', 6.1, 'mmol/L', '2025-07-07 12:07:13', 0, 'Morning', 'fasting'),
(90, 1, 11.33, 'mmol/L', 204, 'mg/dL', '2025-07-09 14:48:53', 0, 'Morning', 'fasting'),
(91, 1, 100, 'mg/dL', 5.6, 'mmol/L', '2025-07-10 01:52:49', 0, 'Morning', 'fasting'),
(92, 11, 80, 'mg/dL', 4.4, 'mmol/L', '2025-07-10 01:55:26', 0, 'Morning', 'fasting'),
(93, 1, 87, 'mg/dL', 4.8, 'mmol/L', '2025-07-10 02:30:50', 0, 'Morning', 'fasting'),
(94, 11, 95, 'mg/dL', 5.3, 'mmol/L', '2025-07-10 02:31:58', 0, 'Morning', 'fasting'),
(95, 1, 136, 'mg/dL', 7.6, 'mmol/L', '2025-07-10 17:36:58', 0, 'Evening', 'after_meal'),
(96, 11, 125, 'mg/dL', 6.9, 'mmol/L', '2025-07-10 20:38:34', 0, 'Before Bed', 'after_meal'),
(97, 11, 145, 'mg/dL', 8.1, 'mmol/L', '2025-07-10 20:58:08', 0, 'Afternoon', 'after_meal'),
(98, 1, 145, 'mg/dL', 8.1, 'mmol/L', '2025-07-10 20:59:56', 0, 'Before Bed', 'after_meal'),
(99, 11, 160, 'mg/dL', 8.9, 'mmol/L', '2025-07-10 22:17:46', 0, 'Morning', 'after_meal'),
(100, 11, 150, 'mg/dL', 8.3, 'mmol/L', '2025-07-11 17:48:49', 0, 'Evening', 'after_meal'),
(101, 11, 181, 'mg/dL', 10.1, 'mmol/L', '2025-07-11 20:09:04', 0, 'Before Bed', 'after_meal'),
(102, 11, 165, 'mg/dL', 9.2, 'mmol/L', '2025-07-11 20:11:52', 0, 'Before Bed', 'after_meal'),
(103, 1, 160, 'mg/dL', 8.9, 'mmol/L', '2025-07-11 23:07:51', 0, 'Before Bed', 'after_meal'),
(104, 1, 180, 'mg/dL', 10, 'mmol/L', '2025-07-11 23:26:51', 0, 'Evening', 'after_meal'),
(105, 1, 150, 'mg/dL', 8.3, 'mmol/L', '2025-07-11 23:36:28', 0, 'Before Bed', 'after_meal'),
(106, 11, 155, 'mg/dL', 8.6, 'mmol/L', '2025-07-12 07:51:46', 0, 'Morning', 'fasting'),
(107, 11, 175, 'mg/dL', 9.7, 'mmol/L', '2025-07-12 08:29:16', 0, 'Morning', 'after_meal'),
(108, 11, 161, 'mg/dL', 8.9, 'mmol/L', '2025-07-12 09:54:18', 0, 'Morning', 'fasting'),
(109, 13, 125, 'mg/dL', 6.9, 'mmol/L', '2025-07-12 21:40:40', 0, 'Evening', 'after_meal'),
(110, 13, 125, 'mg/dL', 6.9, 'mmol/L', '2025-07-12 21:40:43', 0, 'Evening', 'after_meal'),
(111, 11, 145, 'mg/dL', 8.1, 'mmol/L', '2025-07-13 19:04:21', 0, 'Before Bed', 'after_meal'),
(112, 11, 160, 'mg/dL', 8.9, 'mmol/L', '2025-07-13 22:59:31', 0, 'Evening', 'after_meal'),
(113, 1, 149, 'mg/dL', 8.3, 'mmol/L', '2025-07-13 23:04:49', 0, 'Evening', 'after_meal'),
(114, 1, 140, 'mg/dL', 7.8, 'mmol/L', '2025-07-13 23:09:38', 0, 'Before Bed', 'after_meal'),
(115, 11, 181, 'mg/dL', 10.1, 'mmol/L', '2025-07-13 23:22:12', 0, 'Before Bed', 'after_meal'),
(116, 1, 168, 'mg/dL', 9.3, 'mmol/L', '2025-07-13 23:25:11', 0, 'Evening', 'after_meal'),
(117, 1, 156, 'mg/dL', 8.7, 'mmol/L', '2025-07-13 23:32:12', 0, 'Before Bed', 'after_meal'),
(118, 11, 161, 'mg/dL', 8.9, 'mmol/L', '2025-07-13 23:35:35', 0, 'Before Bed', 'after_meal'),
(119, 1, 163, 'mg/dL', 9.1, 'mmol/L', '2025-07-14 00:24:40', 0, 'Before Bed', 'after_meal'),
(120, 11, 150, 'mg/dL', 8.3, 'mmol/L', '2025-07-14 00:36:06', 0, 'Evening', 'after_meal'),
(121, 11, 158, 'mg/dL', 8.8, 'mmol/L', '2025-07-14 02:06:35', 0, 'Evening', 'after_meal'),
(122, 11, 161, 'mg/dL', 8.9, 'mmol/L', '2025-07-14 02:13:56', 0, 'Evening', 'after_meal'),
(123, 11, 140, 'mg/dL', 7.8, 'mmol/L', '2025-07-14 02:14:22', 0, 'Evening', 'after_meal'),
(124, 1, 155, 'mg/dL', 8.6, 'mmol/L', '2025-07-14 02:25:56', 0, 'Evening', 'after_meal'),
(125, 1, 170, 'mg/dL', 9.4, 'mmol/L', '2025-07-14 02:39:11', 0, 'Evening', 'after_meal'),
(126, 11, 150, 'mg/dL', 8.3, 'mmol/L', '2025-07-14 02:49:29', 0, 'Evening', 'after_meal'),
(127, 1, 167, 'mg/dL', 9.3, 'mmol/L', '2025-07-14 02:56:39', 0, 'Evening', 'after_meal'),
(128, 1, 154, 'mg/dL', 8.6, 'mmol/L', '2025-07-14 02:59:20', 0, 'Evening', 'after_meal'),
(129, 1, 160, 'mg/dL', 8.9, 'mmol/L', '2025-07-14 03:02:53', 0, 'Afternoon', 'after_meal'),
(130, 1, 150, 'mg/dL', 8.3, 'mmol/L', '2025-07-14 03:04:28', 0, 'Evening', 'after_meal'),
(131, 1, 155, 'mg/dL', 8.6, 'mmol/L', '2025-07-14 03:06:01', 0, 'Evening', 'after_meal'),
(132, 1, 147, 'mg/dL', 8.2, 'mmol/L', '2025-07-14 03:08:27', 0, 'Evening', 'after_meal'),
(133, 11, 181, 'mg/dL', 10.1, 'mmol/L', '2025-07-14 03:12:18', 0, 'Before Bed', 'after_meal'),
(134, 1, 155, 'mg/dL', 8.6, 'mmol/L', '2025-07-14 22:29:41', 0, 'Before Bed', 'after_meal'),
(135, 1, 160, 'mg/dL', 8.9, 'mmol/L', '2025-07-14 22:33:39', 0, 'Before Bed', 'after_meal'),
(136, 1, 160, 'mg/dL', 8.9, 'mmol/L', '2025-07-14 22:36:45', 0, 'Evening', 'after_meal'),
(137, 1, 148, 'mg/dL', 8.2, 'mmol/L', '2025-07-14 23:01:13', 0, 'Before Bed', 'after_meal'),
(138, 1, 130, 'mg/dL', 7.2, 'mmol/L', '2025-07-14 23:01:59', 0, 'Evening', 'after_meal'),
(139, 1, 148, 'mg/dL', 8.2, 'mmol/L', '2025-07-14 23:10:36', 0, 'Before Bed', 'after_meal'),
(140, 1, 99, 'mg/dL', 5.5, 'mmol/L', '2025-07-18 02:36:27', 0, 'Morning', 'fasting'),
(141, 1, 125, 'mg/dL', 6.9, 'mmol/L', '2025-07-19 17:36:59', 0, 'Evening', 'after_meal'),
(142, 1, 136, 'mg/dL', 7.6, 'mmol/L', '2025-07-20 21:51:54', 0, 'Before Bed', 'after_meal'),
(143, 1, 99, 'mg/dL', 5.5, 'mmol/L', '2025-07-21 22:45:42', 0, 'Morning', 'fasting');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('feedback','bug','dispute') NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `type`, `message`, `created_at`) VALUES
(1, 1, 'feedback', 'Nice service you\'re rendering here..', '2025-05-30 14:48:57'),
(2, 1, 'feedback', 'Great work..', '2025-05-30 15:01:06'),
(3, 10, 'feedback', 'fdfd', '2025-06-15 13:12:32'),
(4, 10, 'dispute', 'wahala dey  boss', '2025-06-15 13:12:53'),
(5, 1, 'feedback', 'nice', '2025-07-14 23:16:32'),
(6, 1, 'bug', 'not working', '2025-07-14 23:17:09'),
(7, 1, 'feedback', 'hi', '2025-07-18 02:38:28');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_replies`
--

CREATE TABLE `feedback_replies` (
  `id` int(11) NOT NULL,
  `feedback_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `reply` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback_replies`
--

INSERT INTO `feedback_replies` (`id`, `feedback_id`, `admin_id`, `reply`, `created_at`) VALUES
(1, 1, 3, 'nice', '2025-05-30 20:26:19'),
(2, 2, 3, 'Thank you so much...', '2025-05-30 22:09:52'),
(3, 1, 3, 'God bless you..', '2025-05-30 22:11:46'),
(4, 2, 5, 'Thank you', '2025-07-01 23:44:50'),
(5, 1, 5, 'Good to hear that', '2025-07-01 23:51:00'),
(6, 3, 5, 'What do you mean', '2025-07-01 23:51:38'),
(7, 1, 5, 'Great you are happy', '2025-07-09 20:18:04'),
(8, 6, 5, 'Now working', '2025-07-15 00:37:40'),
(9, 1, 5, 'Thank you', '2025-07-15 00:50:40');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `issued_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `user_id`, `reference`, `plan`, `amount`, `issued_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'T060403309934345', 'monthly', 3000.00, '2025-07-15 22:18:02', '2025-07-15 22:18:02', '2025-07-15 22:18:02');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `nutrients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`nutrients`)),
  `image_url` varchar(255) DEFAULT NULL,
  `is_generic` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `name`, `description`, `category`, `nutrients`, `image_url`, `is_generic`, `created_at`, `updated_at`) VALUES
(1, 'Grilled salmon & quinoa', 'Rich in protein and omega-3, great for stable glucose.', 'low_glycemic', '{\"carbs\":20,\"fiber\":0,\"protein\":30}', 'meals/salmon-quinoa.jpg', 1, '2025-07-19 14:41:28', '2025-07-23 04:24:39'),
(2, 'Unripe Plantain Porridge', 'A fiber-rich dish that helps regulate blood sugar and supports digestion.', 'low_glycemic', '{\"carbs\": 35, \"fiber\": 8, \"protein\": 5}', 'meals/unripe-plantain-porridge.jpg', 1, '2025-07-19 14:44:06', '2025-07-21 06:33:45'),
(3, 'Moi Moi (Steamed Bean Cake)', 'High in protein and iron, great for sustained energy and muscle recovery.', 'energy_boost', '{\"carbs\": 20, \"protein\": 12, \"iron\": 3}', 'meals/moi-moi.jpg', 1, '2025-07-19 14:44:06', '2025-07-21 06:33:51'),
(4, 'Okra Soup with Leafy Greens', 'Packed with antioxidants and fiber, supports blood sugar control and gut health.', 'low_glycemic', '{\"fiber\": 6, \"vitamin_c\": 40, \"protein\": 10}', 'meals/okra-soup.jpg', 1, '2025-07-19 14:44:06', '2025-07-21 06:33:56'),
(5, 'Ofada Rice with Vegetable Sauce', 'Whole-grain rice with fiber-rich sauce, ideal for glucose stability and heart health.', 'balanced', '{\"carbs\": 45, \"fiber\": 5, \"protein\": 8}', 'meals/ofada-rice.jpg', 1, '2025-07-19 14:44:06', '2025-07-21 05:25:52'),
(6, 'Akara (Bean Fritters)', 'Protein-packed snack made from black-eyed peas, great for breakfast or post-workout.', 'energy_boost', '{\"protein\": 10, \"fiber\": 4, \"fat\": 8}', 'meals/akara.jpg', 1, '2025-07-19 14:44:06', '2025-07-21 06:34:00'),
(7, 'Jollof Rice with Chicken', 'Classic tomato-based rice served with spiced grilled chicken.', 'balanced', '{\"carbs\": 55, \"fiber\": 4, \"protein\": 25}', 'meals/jollof-rice.jpg', 1, '2025-07-19 18:08:52', '2025-07-21 05:25:52'),
(8, 'Egusi Soup with Pounded Yam', 'Melon seed soup with rich greens, served with pounded yam.', 'energy_boost', '{\"carbs\": 60, \"fiber\": 5, \"protein\": 20}', 'meals/egusi-pounded-yam.jpg', 1, '2025-07-19 18:08:52', '2025-07-21 06:34:18'),
(9, 'Okro Soup with Amala', 'Slimy okra delight served with yam flour swallow.', 'low_glycemic', '{\"carbs\": 40, \"fiber\": 6, \"protein\": 15}', 'meals/okro-amala.jpg', 1, '2025-07-19 18:08:52', '2025-07-21 06:34:23'),
(10, 'Moi Moi with Pap', 'Steamed bean pudding paired with fermented corn gruel.', 'balanced', '{\"carbs\": 50, \"fiber\": 8, \"protein\": 10}', 'meals/moi-moi-pap.jpg', 1, '2025-07-19 18:08:52', '2025-07-21 05:25:52'),
(11, 'Suya with Vegetable Garnish', 'Grilled spicy beef skewers served with onions and cucumbers.', 'energy_boost', '{\"carbs\":10,\"fiber\":2,\"protein\":30}', 'meals/suya.jpg', 1, '2025-07-19 18:08:52', '2025-07-22 16:38:51');

-- --------------------------------------------------------

--
-- Table structure for table `meal_logs`
--

CREATE TABLE `meal_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meal_description` text NOT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `logged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal_logs`
--

INSERT INTO `meal_logs` (`id`, `user_id`, `meal_description`, `tags`, `logged_at`, `created_at`, `updated_at`) VALUES
(2, 1, 'Rice', '[\"High-Carb\"]', '2025-07-13 20:06:33', '2025-07-13 20:06:33', '2025-07-13 20:06:33'),
(3, 11, 'Rice', '[\"High-Carb\"]', '2025-07-13 20:20:50', '2025-07-13 20:20:50', '2025-07-13 20:20:50'),
(4, 11, 'chicken', '[\"Protein-Packed\"]', '2025-07-13 20:40:12', '2025-07-13 20:40:12', '2025-07-13 20:40:12'),
(5, 11, 'Potato', '[\"High-Carb\"]', '2025-07-13 23:03:10', '2025-07-13 23:03:10', '2025-07-13 23:03:10'),
(6, 1, 'Bread', '[\"High-Carb\"]', '2025-07-13 23:10:52', '2025-07-13 23:10:52', '2025-07-13 23:10:52'),
(7, 1, 'Beans', '[\"Fiber-Rich\"]', '2025-07-18 02:47:18', '2025-07-18 02:47:18', '2025-07-18 02:47:18'),
(8, 1, 'potato', '[\"High-Carb\"]', '2025-07-19 17:36:08', '2025-07-19 17:36:08', '2025-07-19 17:36:08');

-- --------------------------------------------------------

--
-- Table structure for table `meal_plans`
--

CREATE TABLE `meal_plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  `scheduled_for` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal_plans`
--

INSERT INTO `meal_plans` (`id`, `user_id`, `meal_id`, `scheduled_for`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2025-07-19 17:20:28', '2025-07-19 16:20:28', '2025-07-19 16:20:28'),
(2, 1, 4, '2025-07-21 11:48:43', '2025-07-21 10:48:43', '2025-07-21 10:48:43'),
(3, 1, 2, '2025-07-21 11:48:47', '2025-07-21 10:48:47', '2025-07-21 10:48:47'),
(4, 1, 9, '2025-07-21 11:48:50', '2025-07-21 10:48:50', '2025-07-21 10:48:50'),
(5, 1, 7, '2025-07-21 23:41:33', '2025-07-21 22:41:33', '2025-07-21 22:41:33'),
(6, 1, 10, '2025-07-21 23:42:15', '2025-07-21 22:42:15', '2025-07-21 22:42:15'),
(7, 1, 5, '2025-07-21 23:43:39', '2025-07-21 22:43:39', '2025-07-21 22:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('sms','push','email','subscribe','glucose','symptom') NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `triggered_value` decimal(8,2) DEFAULT NULL,
  `status` enum('pending','sent','failed') DEFAULT 'pending',
  `sent_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `dismissed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `triggered_value`, `status`, `sent_at`, `created_at`, `dismissed`) VALUES
(1, 4, 'email', NULL, 'We will be having a system upgrade tomorrow...', NULL, 'sent', NULL, '2025-05-30 22:56:50', 0),
(2, 1, 'email', NULL, 'We will be having a system upgrade tomorrow...', NULL, 'sent', NULL, '2025-05-30 22:56:50', 0),
(3, 3, 'email', NULL, 'We will be having a system upgrade tomorrow...', NULL, 'sent', NULL, '2025-05-30 22:56:50', 0),
(4, 2, 'email', NULL, 'We will be having a system upgrade tomorrow...', NULL, 'sent', '2025-06-02 01:23:25', '2025-05-30 22:56:50', 0),
(8, 5, 'email', 'Welcome!', '🎉 Your account has been successfully created. Let\'s start tracking your health!', NULL, 'sent', '2025-07-15 01:43:04', '2025-05-30 23:08:58', 0),
(9, 1, 'email', NULL, 'Logged in with Google', NULL, 'sent', '2025-06-02 01:24:54', '2025-06-02 01:18:47', 0),
(10, 1, 'email', 'Google Login', 'Logged in with Google', NULL, 'sent', '2025-06-02 03:09:10', '2025-06-02 02:09:10', 0),
(11, 1, 'email', 'Google Login', 'Logged in with Google', NULL, 'sent', '2025-06-02 19:04:23', '2025-06-02 18:04:23', 0),
(12, 6, 'email', NULL, '🎉 Welcome Sam Joe! Your account has been created successfully. Let\\\'s start tracking your health!', NULL, 'sent', NULL, '2025-06-09 23:50:19', 0),
(13, 6, 'email', NULL, 'Welcome Sam Joe..', NULL, 'sent', NULL, '2025-06-10 00:43:47', 0),
(14, 6, 'email', NULL, 'Testing', NULL, 'sent', NULL, '2025-06-10 00:45:26', 0),
(16, 6, 'email', NULL, 'Testing again', NULL, 'sent', NULL, '2025-06-10 09:49:30', 0),
(18, 5, 'email', 'Subscription Activated', 'Your monthly subscription has been successfully activated.', NULL, 'sent', '2025-07-15 01:50:53', '2025-06-16 15:32:05', 0),
(19, 1, 'email', NULL, 'Hello How are you doing', NULL, 'sent', NULL, '2025-07-09 19:35:08', 0),
(20, 1, 'email', 'New Contact Message', 'Hahajsshshsh', NULL, 'sent', '2025-07-10 00:22:57', '2025-07-09 23:22:57', 0),
(21, 1, 'email', 'New Contact Message', 'Hello', NULL, 'sent', '2025-07-10 18:57:20', '2025-07-10 17:57:20', 0),
(22, 11, 'email', 'Subscription Activated', 'Your monthly subscription has been successfully activated.', NULL, 'sent', '2025-07-15 01:50:57', '2025-07-14 02:17:03', 0),
(23, 1, 'glucose', '🩺 Blood Sugar Alert', 'Reading reached 160 mg/dL', NULL, 'sent', '2025-07-14 23:36:45', '2025-07-14 22:36:45', 0),
(24, 1, 'glucose', '🩺 Blood Sugar Alert', 'Reading reached 148 mg/dL', NULL, 'sent', '2025-07-15 00:01:15', '2025-07-14 23:01:15', 0),
(25, 1, 'glucose', '🩺 Blood Sugar Alert', 'Reading reached 148 mg/dL', NULL, 'sent', '2025-07-15 00:10:36', '2025-07-14 23:10:36', 0),
(26, 1, 'email', 'New Contact Message', 'Thank you for reaching out to us', NULL, 'sent', '2025-07-15 00:24:53', '2025-07-14 23:24:53', 0),
(27, 1, 'email', 'New Contact Message', 'Okay', NULL, 'sent', '2025-07-15 00:25:52', '2025-07-14 23:25:52', 0),
(28, 1, 'email', 'System Message', 'Well done', NULL, 'sent', '2025-07-15 01:43:00', '2025-07-14 23:51:33', 0),
(31, 16, 'email', '🎉 Welcome, Town Hall Gist!', 'Thank you for signing up. Start tracking your readings and stay on top of your health.', NULL, 'sent', '2025-07-15 03:06:43', '2025-07-15 02:06:43', 0),
(32, 1, 'email', 'Subscription Activated', 'Your monthly subscription has been successfully activated.', NULL, 'pending', '2025-07-15 23:18:02', '2025-07-15 22:18:02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remindars`
--

CREATE TABLE `remindars` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `recurrence` enum('none','daily','weekly') DEFAULT 'none',
  `scheduled_time` datetime DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `time_of_day` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sent` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remindars`
--

INSERT INTO `remindars` (`id`, `user_id`, `subject`, `body`, `recurrence`, `scheduled_time`, `day_of_week`, `time_of_day`, `created_at`, `updated_at`, `sent`) VALUES
(1, 1, 'Sugar Test', 'I will running a sugar test one time', 'none', '0000-00-00 00:00:00', NULL, NULL, '2025-05-29 20:27:22', '2025-06-16 14:49:03', 1),
(2, 1, 'Sugar Test For A Friend', 'I will running a sugar test.', 'none', '0000-00-00 00:00:00', NULL, NULL, '2025-05-29 22:26:42', '2025-06-16 14:49:03', 1),
(3, 1, 'Sugar Test For A Friend', 'Testing', 'weekly', NULL, 'Monday', '08:00:00', '2025-05-29 22:46:40', '2025-06-16 14:49:03', 0),
(4, 1, 'Sugar Testing', 'Asap', 'none', '2025-05-30 08:00:00', NULL, NULL, '2025-05-29 22:42:08', '2025-06-16 14:49:03', 1),
(5, 1, 'Sugar Test For A Mom', 'jksksdjksdsddkjsdkdjskdjsdkjs', 'none', '0000-00-00 00:00:00', NULL, NULL, '2025-05-29 22:49:34', '2025-06-16 14:49:03', 1),
(6, 1, 'A Reminder for Blood Sugar Test', 'I will be having a blood sugar test tomorrow, hopefuly.', 'none', '0000-00-00 00:00:00', NULL, NULL, '2025-05-29 23:22:40', '2025-06-16 14:49:03', 1),
(7, 1, 'Sugar Test For A Friend', 'I will run a sugar test for a Friend', 'none', '2025-05-30 01:03:00', NULL, NULL, '2025-05-30 00:02:33', '2025-06-16 14:49:03', 1),
(8, 5, 'Morning test', 'Going to the hospital ', 'none', '2025-06-12 09:00:00', NULL, NULL, '2025-06-08 12:58:30', '2025-06-16 14:49:03', 1),
(9, 3, 'Test', 'Remind me', 'none', '2025-06-19 17:55:00', NULL, NULL, '2025-06-08 16:55:21', '2025-06-16 14:49:03', 1),
(10, 6, 'Sugar Test For A Friend', 'dsdsd', 'none', '2025-07-20 08:00:00', NULL, NULL, '2025-06-16 13:49:09', '2025-06-16 13:49:09', 0),
(11, 1, 'Check your sugar level', 'It’s 12:47 AM a perfect time to step away, stretch a little, and drink some water. Your well-being fuels your brilliance, so don’t skip it!', 'none', '2025-06-19 00:47:00', NULL, NULL, '2025-06-18 22:45:43', '2025-06-18 22:45:43', 1),
(12, 1, 'Testing', 'Test', 'none', '2025-06-19 00:15:00', NULL, NULL, '2025-06-19 21:37:43', '2025-06-19 21:37:43', 1),
(13, 1, 'Yes', 'Yeah', 'daily', NULL, NULL, '00:17:00', '2025-06-19 22:16:57', '2025-06-19 22:16:57', 0),
(14, 1, 'skslsalk', 'jssksk', 'daily', NULL, NULL, '00:45:00', '2025-06-19 22:41:06', '2025-06-19 22:41:06', 0),
(15, 1, 'A Visit to the Museum', 'ndkdjksdjksd', 'none', '2025-07-15 01:28:00', NULL, NULL, '2025-07-15 00:27:15', '2025-07-15 00:27:15', 1),
(16, 1, 'Sugar Test For A Friend', 'Sugar Test For A Friend\r\nSugar Test For A Friend', 'none', '2025-07-15 04:10:00', NULL, NULL, '2025-07-15 03:08:55', '2025-07-15 03:08:55', 1),
(17, 1, 'Sugar Test', 'Soon', 'none', NULL, NULL, NULL, '2025-07-15 03:25:28', '2025-07-15 03:25:28', 0),
(18, 1, 'Sugar Test Reminder', 'Okay', 'none', '2025-07-15 04:29:00', NULL, NULL, '2025-07-15 03:28:31', '2025-07-15 03:28:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `schedule_time` datetime NOT NULL,
  `sent` tinyint(1) DEFAULT 0,
  `phone` varchar(20) DEFAULT NULL,
  `telegram_chat_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `user_id`, `message`, `schedule_time`, `sent`, `phone`, `telegram_chat_id`, `created_at`) VALUES
(1, 1, 'Morning', '2025-05-28 08:00:00', 0, '08138809708', '765985357', '2025-05-28 02:44:06'),
(2, 1, 'Sugar test', '2025-05-30 08:30:00', 0, '08138809708', '765985357', '2025-05-28 02:51:58'),
(3, 1, 'Remind me', '2025-05-29 19:18:00', 1, '08138809708', '765985357', '2025-05-29 18:16:59');

-- --------------------------------------------------------

--
-- Table structure for table `report_links`
--

CREATE TABLE `report_links` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report_links`
--

INSERT INTO `report_links` (`id`, `user_id`, `token`, `password_hash`, `created_at`, `expires_at`) VALUES
(1, 1, 'a1c263181bc480955dd1a2c8e3438819', '$2y$10$NdrIm2EbKCIwA5XBZFO.1eaHX41.3GGBvWXRcTQP6wYP/cNZDL/CW', '2025-05-28 12:31:32', NULL),
(2, 1, 'fgXiVtr3qPpTj7mRa2VRPSDMz7ePayZA', '$2y$12$QzKIjjQhfMCYNPywkdXrre8ZAdaE4DdxkjL2JLZMtOLmez7pvpXJO', '2025-06-14 23:47:51', NULL),
(3, 1, 'eGuhDYSESWFNWEyoT2RVSw4xIJvNwj0Z', '$2y$12$6XKJp1I6u2CNMedVWYs7K.TXRCoeeAWOoZ9wn9bpKqh3iIB4aOAD2', '2025-06-14 23:50:29', NULL),
(4, 1, 'O2li9RRAo6F7ewDahQ1xQfSZmmutrReG', '$2y$12$lJwQW9Re9H6A6.MCBAnO2ONClwpwijVaOU.uUt8ToGCmXy11IFdBq', '2025-06-14 23:55:23', NULL),
(5, 1, 'HtLqkJOI8w94T85Gw3zUZShtZIKeEYVu', '$2y$12$zT1cqiwdsjFTf.IiR1HH/uORLgqSlZ3Ej/kcsf0.R7AJocAHwVn1i', '2025-06-14 23:58:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_emails`
--

CREATE TABLE `scheduled_emails` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `scheduled_at` datetime NOT NULL,
  `sent` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scheduled_emails`
--

INSERT INTO `scheduled_emails` (`id`, `user_id`, `subject`, `message`, `scheduled_at`, `sent`, `created_at`) VALUES
(1, 1, 'enyidavid87@gmail.com', 'remind', '2025-05-29 19:06:00', 1, '2025-05-29 18:04:19'),
(2, 1, 'enyidavid87@gmail.com', 'remind', '2025-05-29 19:06:00', 1, '2025-05-29 18:07:03');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5WbxTV9Vt3huwbZ2HJ6iuhYScwTjDoDk15wyO15w', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMnc0bEoxMkVJWFR4VFZFYk1zbEJ3bUs5MzExZTI1RFZTN29YcGdLZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjZjZDM1NmJjNmMubmdyb2stZnJlZS5hcHAiO319', 1753255686),
('I0hzl1oM8y0q5Tn4YZQ7sHV9e8Kobh7O2qCtLPkc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic3IxSWRuWWhFV0oxMFl4QkdEN0Rtd3MySTYzbkR0M3E5V3A0Njg3ZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NToic3RhdGUiO3M6NDA6ImVicTN4RWJUM09NZkhpTkViZzlhVGozRVpNdjd0T1FjZkZNS3B1VjQiO30=', 1753255617),
('lnzNVo1DJmr5OOaW6mmWqlZWgSYO7XiM6ZQqJxu7', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiQkFuRHZLQUNPVGUybFJkMlBwRWpoYlh3MTR4U0RjN2lCUHdtOGdXbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHA6Ly8xMjZjZDM1NmJjNmMubmdyb2stZnJlZS5hcHAvbm90aWZpY2F0aW9ucy91bnJlYWQtY291bnQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NzoidXNlcl9pZCI7aToxO3M6OToiZnVsbF9uYW1lIjtzOjk6IkRhdmUgRW55aSI7czo1OiJlbWFpbCI7czoyMToiZW55aWRhdmlkODdAZ21haWwuY29tIjt9', 1753258613);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan` enum('monthly','annual','lifetime') DEFAULT 'monthly',
  `amount_paid` int(11) NOT NULL,
  `currency` varchar(10) DEFAULT 'NGN',
  `status` enum('active','expired','cancelled') DEFAULT 'active',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_reference` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `plan`, `amount_paid`, `currency`, `status`, `start_date`, `end_date`, `created_at`, `updated_at`, `payment_reference`) VALUES
(2, 5, 'monthly', 3000, 'NGN', 'active', '2025-06-16 00:00:00', '2025-09-16 00:00:00', '2025-06-16 15:19:33', '2025-06-16 15:32:05', 'T457521926974783'),
(3, 11, 'monthly', 3000, 'NGN', 'active', '2025-07-14 00:00:00', '2025-08-14 00:00:00', '2025-07-14 02:17:03', '2025-07-14 02:17:03', 'T916465987074475'),
(4, 1, 'monthly', 3000, 'NGN', 'active', '2025-07-15 00:00:00', '2025-08-15 00:00:00', '2025-07-15 22:18:02', '2025-07-15 22:18:02', 'T060403309934345');

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_messages`
--

INSERT INTO `support_messages` (`id`, `user_id`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 10, 'Complaint', 'hdsjssjdjd', '2025-06-15 13:18:14', '2025-06-15 13:18:14'),
(2, 1, NULL, 'Hidhdh', '2025-07-01 23:46:03', '2025-07-01 23:46:03'),
(3, 1, NULL, 'Happy Sunday', '2025-07-06 14:22:30', '2025-07-06 14:22:30'),
(4, 1, NULL, 'Hi Mr. Dave Good...', '2025-07-09 14:47:00', '2025-07-09 14:47:00'),
(5, 1, 'Sugar Test', 'hiiii', '2025-07-14 23:17:32', '2025-07-14 23:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `symptom_logs`
--

CREATE TABLE `symptom_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL,
  `logged_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `symptom` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `glucose_log_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `symptom_logs`
--

INSERT INTO `symptom_logs` (`id`, `user_id`, `logged_at`, `symptom`, `notes`, `glucose_log_id`) VALUES
(1, 1, '2025-07-13 02:28:13', 'Stress', 'I\'m so stressed out', NULL),
(3, 11, '2025-07-13 02:49:48', 'Stress', 'Feel so stressed ', NULL),
(4, 1, '2025-07-13 03:44:45', 'Fatigue', 'Feel like crying', NULL),
(5, 11, '2025-07-13 19:03:07', 'Dizziness', 'Feeling so sleepy', NULL),
(6, 11, '2025-07-13 23:01:18', 'Fatigue', 'So tired', NULL),
(7, 1, '2025-07-14 02:40:48', 'Stress', 'So tired', NULL),
(8, 1, '2025-07-18 02:46:48', 'Mood Drop', 'Mood Swing', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `device_token` text DEFAULT NULL,
  `profile_image` varchar(255) NOT NULL DEFAULT 'default.png',
  `telegram_chat_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `dob` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `is_banned` tinyint(1) DEFAULT 0,
  `payment_status` enum('pending','paid') DEFAULT 'pending',
  `is_subscribed` tinyint(1) NOT NULL DEFAULT 0,
  `subscribed_at` datetime DEFAULT NULL,
  `trial_start_date` date DEFAULT NULL,
  `trial_expired` tinyint(4) DEFAULT 0,
  `has_paid` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `notifications_enabled` tinyint(1) DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `meal_preference` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `device_token`, `profile_image`, `telegram_chat_id`, `password`, `created_at`, `dob`, `phone`, `is_admin`, `is_banned`, `payment_status`, `is_subscribed`, `subscribed_at`, `trial_start_date`, `trial_expired`, `has_paid`, `updated_at`, `notifications_enabled`, `email_verified_at`, `meal_preference`) VALUES
(1, 'Dave Enyi', 'enyidavid87@gmail.com', 'd4d87Mk6II1HHHX0w4Ze6w:APA91bHTH0AbDZUtn8ZKCHVdZDbWSDSaCSBdnOkmWDaPFWkH2useFYsF1WGqutyLzzNKHbr64AHmBo2H58IxAVH4NdTQuPxOCQtTaO0zohypkx0Ooc8OmGo', 'uploads/profile_images/68370fab180e9_profileasas.png', '2147483647', '$2y$12$6vx1SVcx00uEyzKouWqWsei5.ifbWYRCig4Ex8aEcY8m2W7KM/T/2', '2025-05-25 21:04:52', '1996-10-20', '08138809708', 0, 0, 'paid', 0, NULL, '2025-06-09', 0, 1, '2025-07-21 13:26:38', 1, '2025-07-18 20:58:40', 'balanced'),
(2, 'John Doe', 'john@email.com', NULL, '', '0', '$2y$10$O17JSrm8XzELA9oJMwGJR.ZgFJ9nrJBp9cNzaMJY4bgcgL3.Kt21u', '2025-05-26 02:23:05', NULL, NULL, 0, 0, 'pending', 0, NULL, NULL, 0, 0, '2025-06-12 03:13:26', 1, NULL, NULL),
(3, 'Jessica', 'jessy@email.com', NULL, 'uploads/profile_images/6845bfaa9981f_IMG_9663.jpeg', '0', '$2y$12$mUearikv6SIlKYmHfpkeRu56in//Pw02z4Weg6M3.NmD0PlCA6TaO', '2025-05-28 19:34:42', '0000-00-00', '', 1, 0, 'pending', 0, NULL, NULL, 0, 0, '2025-06-29 21:42:33', 1, NULL, NULL),
(4, 'Emma', 'emma@email.com', NULL, '', '0', '$2y$10$70xgbZND8uxWZ6dJ5iax4uS.JfwqrawrNehznN25RjxEw2n0newdm', '2025-05-28 21:00:51', NULL, NULL, 1, 0, 'pending', 0, NULL, NULL, 0, 0, '2025-06-12 03:13:26', 1, NULL, NULL),
(5, 'Jorry Jorry', 'jorry@email.com', NULL, 'uploads/profile_images/683a3b37b7138_woman holding perf.jpg', '0', '$2y$12$M02lQ6RMCv2enZY3EXN0N.lHU5zceTgYQmDBahR/BgpUgpW2SI2pu', '2025-05-30 23:08:57', '1997-12-25', '07045574400', 1, 0, 'pending', 0, NULL, NULL, 0, 1, '2025-06-29 21:43:03', 1, NULL, NULL),
(6, 'Sam Joe', 'sam@email.com', NULL, '', '0', '$2y$12$aj9vxblqEZ6JFYbg0.1WQeg65Ar3qGXZTU8pxX.p/JWK4kwEYokX6', '2025-06-09 23:50:19', NULL, NULL, NULL, 0, 'pending', 0, NULL, '2025-06-10', 0, 0, '2025-06-16 13:41:47', 1, NULL, NULL),
(8, 'Gina', 'gina@email.com', NULL, 'default.png', NULL, '$2y$12$.OCpHdZvsyGOVeJn5ga2..Y7Rj//R.qnMrD8DXZYL4GMA93K.6ZDO', '2025-06-12 07:26:51', NULL, NULL, NULL, 0, 'pending', 0, NULL, NULL, 0, 0, '2025-06-12 07:26:51', 1, NULL, NULL),
(10, 'Jane', 'jane@email.com', NULL, 'default.png', NULL, '$2y$12$Q3kn.xSut7c43pF//150uuqNGJKQSMZMYIMLmFNuBxChx1H1ifYdW', '2025-06-15 12:42:57', NULL, NULL, NULL, 0, 'pending', 0, NULL, '2025-06-15', 0, 0, '2025-06-15 12:42:57', 1, NULL, NULL),
(11, 'Edet Monday', 'edet@email.com', 'd4d87Mk6II1HHHX0w4Ze6w:APA91bHTH0AbDZUtn8ZKCHVdZDbWSDSaCSBdnOkmWDaPFWkH2useFYsF1WGqutyLzzNKHbr64AHmBo2H58IxAVH4NdTQuPxOCQtTaO0zohypkx0Ooc8OmGo', 'profile_images/5W2aKqeTFgcoyI2vKbHBXhkn5QUYNEEiMGHtsrU3.jpg', NULL, '$2y$12$KINmB8xdyMG0icZBjIctzePPiJ52ILTD4SRcTCs4QCqcnpEXGd4O.', '2025-07-09 19:06:56', '1987-06-25', '08065467865', NULL, 0, 'pending', 0, NULL, '2025-07-09', 0, 1, '2025-07-19 17:45:34', 1, '2025-07-18 20:58:40', NULL),
(12, 'Blessing James', 'blessing@email.com', NULL, 'default.png', NULL, '$2y$12$Vmcyl6CFSa8mz3qgYtR/1.IQTeMbPDV6VxQlEoZ9.nY1rhuuGTFJa', '2025-07-12 21:30:24', NULL, NULL, NULL, 0, 'pending', 0, NULL, '2025-07-12', 0, 0, '2025-07-12 21:30:24', 1, NULL, NULL),
(13, 'Deborah Otene', 'debby@gmail.com', NULL, 'default.png', NULL, '$2y$12$atJ090J.d60U7kzVUeVyx.t7wQXgD06FbcEYrG19Dz1IYC7ol2TFS', '2025-07-12 21:32:06', NULL, NULL, NULL, 0, 'pending', 0, NULL, '2025-07-12', 0, 0, '2025-07-12 21:32:06', 1, NULL, NULL),
(16, 'Town Hall Gist', 'townhallgist@gmail.com', NULL, 'default.png', NULL, '$2y$12$Mm3qmQu/h.u/gaGZGFLOX./eX3QHgSW4v6sla6hBv0fIGPwsMyAl2', '2025-07-15 02:06:34', NULL, NULL, NULL, 0, 'pending', 0, NULL, '2025-07-15', 0, 0, '2025-07-21 09:26:54', 1, NULL, 'energy_boost');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_agent` text DEFAULT NULL,
  `location` varchar(250) DEFAULT NULL,
  `payload` text DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`id`, `user_id`, `action`, `ip_address`, `timestamp`, `user_agent`, `location`, `payload`, `last_activity`) VALUES
(1, 1, 'Login', '127.0.0.1', '2025-07-20 20:50:10', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Location unavailable', '[]', '2025-07-20 21:50:10'),
(2, 11, 'Login', '127.0.0.1', '2025-07-20 20:51:49', 'Browser: Chrome Dev 138.0.7204.156; OS: iOS 18.5.0; Device: Apple iPhone', 'Location unavailable', '[]', '2025-07-20 21:51:49'),
(3, 1, 'Login', '127.0.0.1', '2025-07-20 21:00:34', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Location unavailable', '[]', '2025-07-20 22:00:34'),
(4, 11, 'Login', '127.0.0.1', '2025-07-20 21:11:48', 'Browser: Chrome Dev 138.0.7204.156; OS: iOS 18.5.0; Device: Apple iPhone', 'Location unavailable', '[]', '2025-07-20 22:11:48'),
(5, 11, 'Login', '127.0.0.1', '2025-07-20 21:13:27', 'Browser: Safari; OS: iOS 18.5; Device: Apple iPhone', 'Location unavailable', '[]', '2025-07-20 22:13:27'),
(6, 11, 'Login', '127.0.0.1', '2025-07-20 21:14:51', 'Browser: Safari; OS: iOS 18.5; Device: Apple iPhone', 'Location unavailable', '[]', '2025-07-20 22:14:51'),
(7, 1, 'Login', '127.0.0.1', '2025-07-20 21:21:07', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Location unavailable', '[]', '2025-07-20 22:21:07'),
(8, 11, 'Login', '127.0.0.1', '2025-07-20 21:23:54', 'Browser: Safari; OS: iOS 18.5; Device: Apple iPhone', 'Location unavailable', '[]', '2025-07-20 22:23:54'),
(9, 1, 'Login', '127.0.0.1', '2025-07-20 21:30:13', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-20 22:30:13'),
(10, 16, 'Login', '127.0.0.1', '2025-07-20 21:32:23', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-20 22:32:23'),
(11, 1, 'Login', '127.0.0.1', '2025-07-20 21:50:49', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-20 22:50:49'),
(12, 1, 'Login', '127.0.0.1', '2025-07-21 04:52:59', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-21 05:52:59'),
(13, 1, 'Login', '127.0.0.1', '2025-07-21 04:59:49', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-21 05:59:49'),
(14, 16, 'Login', '127.0.0.1', '2025-07-21 05:00:22', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-21 06:00:22'),
(15, 16, 'Login', '127.0.0.1', '2025-07-21 07:15:20', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-21 08:15:20'),
(16, 16, 'Login', '127.0.0.1', '2025-07-21 09:17:03', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-21 10:17:03'),
(17, 1, 'Login', '127.0.0.1', '2025-07-21 09:35:26', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-21 10:35:26'),
(18, 11, 'Login', '127.0.0.1', '2025-07-21 10:21:15', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-21 11:21:15'),
(19, 1, 'Login', '127.0.0.1', '2025-07-21 10:48:28', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-21 11:48:28'),
(20, 1, 'Login', '127.0.0.1', '2025-07-21 22:30:59', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-21 23:30:59'),
(21, 5, 'Login', '127.0.0.1', '2025-07-21 22:55:15', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-21 23:55:15'),
(22, 1, 'Login', '127.0.0.1', '2025-07-21 23:37:33', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-22 00:37:33'),
(23, 1, 'Login', '127.0.0.1', '2025-07-22 08:56:06', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-22 09:56:06'),
(24, 5, 'Login', '127.0.0.1', '2025-07-22 09:15:41', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-22 10:15:41'),
(25, 5, 'Login', '127.0.0.1', '2025-07-22 09:43:30', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-22 10:43:30'),
(26, 5, 'Login', '127.0.0.1', '2025-07-22 15:18:05', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-22 16:18:05'),
(27, 5, 'Login', '127.0.0.1', '2025-07-23 03:58:44', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-23 04:58:44'),
(28, 1, 'Login', '127.0.0.1', '2025-07-23 07:18:44', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-23 08:18:44'),
(29, 1, 'Login', '127.0.0.1', '2025-07-23 07:27:38', 'Browser: Chrome 138; OS: Windows 10; Device: ', 'Abuja, Nigeria', '[]', '2025-07-23 08:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `webauthn_keys`
--

CREATE TABLE `webauthn_keys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `credential_id` text NOT NULL,
  `public_key` text NOT NULL,
  `counter` bigint(20) UNSIGNED DEFAULT 0,
  `transports` text DEFAULT NULL,
  `attestation_type` varchar(255) DEFAULT NULL,
  `trust_path` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversions`
--
ALTER TABLE `conversions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_conv` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback_replies`
--
ALTER TABLE `feedback_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_id` (`feedback_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meal_logs`
--
ALTER TABLE `meal_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `meal_plans`
--
ALTER TABLE `meal_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meal_id` (`meal_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_ibfk_1` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remindars`
--
ALTER TABLE `remindars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_links`
--
ALTER TABLE `report_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_token` (`token`),
  ADD KEY `report_links_ibfk_1` (`user_id`);

--
-- Indexes for table `scheduled_emails`
--
ALTER TABLE `scheduled_emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scheduled_emails_ibfk_1` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_ibfk_1` (`user_id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_messages_ibfk_1` (`user_id`);

--
-- Indexes for table `symptom_logs`
--
ALTER TABLE `symptom_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_users_id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_logs` (`user_id`);

--
-- Indexes for table `webauthn_keys`
--
ALTER TABLE `webauthn_keys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `webauthn_keys_user_id_index` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `conversions`
--
ALTER TABLE `conversions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback_replies`
--
ALTER TABLE `feedback_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `meal_logs`
--
ALTER TABLE `meal_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `meal_plans`
--
ALTER TABLE `meal_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `remindars`
--
ALTER TABLE `remindars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `report_links`
--
ALTER TABLE `report_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `scheduled_emails`
--
ALTER TABLE `scheduled_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `symptom_logs`
--
ALTER TABLE `symptom_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `webauthn_keys`
--
ALTER TABLE `webauthn_keys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversions`
--
ALTER TABLE `conversions`
  ADD CONSTRAINT `fk_user_conv` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `feedback_replies`
--
ALTER TABLE `feedback_replies`
  ADD CONSTRAINT `feedback_replies_ibfk_1` FOREIGN KEY (`feedback_id`) REFERENCES `feedback` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `meal_logs`
--
ALTER TABLE `meal_logs`
  ADD CONSTRAINT `fk_meal_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `meal_plans`
--
ALTER TABLE `meal_plans`
  ADD CONSTRAINT `meal_plans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meal_plans_ibfk_2` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_user_notif` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_links`
--
ALTER TABLE `report_links`
  ADD CONSTRAINT `report_links_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `scheduled_emails`
--
ALTER TABLE `scheduled_emails`
  ADD CONSTRAINT `scheduled_emails_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD CONSTRAINT `support_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `symptom_logs`
--
ALTER TABLE `symptom_logs`
  ADD CONSTRAINT `fk_symptom_logs_user ` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `conversions_ibfk_1` FOREIGN KEY (`id`) REFERENCES `conversions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `fk_user_logs` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
