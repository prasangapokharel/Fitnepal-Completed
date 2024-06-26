-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2024 at 01:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitness`
--

-- --------------------------------------------------------

--
-- Table structure for table `bankpayment`
--

CREATE TABLE `bankpayment` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('verified','unverified') DEFAULT 'unverified',
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `account_number` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `transaction_hash` varchar(255) DEFAULT NULL,
  `holderName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bankpayment`
--

INSERT INTO `bankpayment` (`id`, `username`, `user_id`, `image`, `status`, `transaction_date`, `account_number`, `branch`, `transaction_hash`, `holderName`) VALUES
(1, 'Elliott George', 3, 'manualpay/BRS.png', '', '2024-05-11 15:20:25', NULL, NULL, NULL, NULL),
(2, 'Ethan Skinner', 3, 'manualpay/tgg.jpg', 'verified', '2024-05-11 15:50:51', '733', 'Et quo autem delenit', 'Vel ratione est quos', NULL),
(3, 'Prasanga Raman Pokharel', 3, 'manualpay/sale bannner social media post .png', 'verified', '2024-05-14 03:42:43', '3123234993', 'Inaruwa', '22b2332r322', NULL),
(4, 'Prasanga Raman Pokharel', 3, 'manualpay/sale bannner social media post .png', 'verified', '2024-05-14 03:45:10', '3123234993', 'Inaruwa', '22b2332r322', '3123234993'),
(5, 'Prasanga Raman Pokharel', 3, 'manualpay/sale bannner social media post .png', 'verified', '2024-05-14 03:46:59', '3123234993', 'Inaruwa', '22b2332r322', '3123234993'),
(6, 'Vincent Underwood', 3, 'Payment/manualpay/TRYME (70 x 70 px).png', 'verified', '2024-05-14 03:47:43', '595', 'Aliqua Libero ut qu', 'Irure do sapiente qu', '595'),
(7, 'Vincent Underwood', 3, 'Payment/manualpay/cheat.png', 'verified', '2024-05-14 03:48:07', '595', 'Aliqua Libero ut qu', 'Irure do sapiente qu', '595'),
(8, 'Vincent Underwood', 3, 'manualpay/cheat.png', 'verified', '2024-05-14 03:48:57', '595', 'Aliqua Libero ut qu', 'Irure do sapiente qu', '595'),
(9, 'Ashsih Khadka', 3, 'manualpay/2.jpg', 'verified', '2024-05-14 04:38:57', '8432432847328', 'Itahari', '38483239f33', '8432432847328'),
(10, 'Ross Bennett', 3, 'manualpay/c699ebe8-a0a2-4d80-ae6d-59ed07059634.jpeg', 'unverified', '2024-06-06 18:55:16', '960', 'Molestiae a voluptas', 'Similique libero sed', 'Ross Bennett'),
(11, 'Reed Rasmussen', 3, 'manualpay/c699ebe8-a0a2-4d80-ae6d-59ed07059634.jpeg', 'unverified', '2024-06-06 19:00:12', '975', 'Quas est totam ullam', 'Aliquid deserunt aut', 'Reed Rasmussen');

-- --------------------------------------------------------

--
-- Table structure for table `calorie`
--

CREATE TABLE `calorie` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `amount` bigint(11) NOT NULL,
  `calories` int(11) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `calorie`
--

INSERT INTO `calorie` (`id`, `user_id`, `date`, `amount`, `calories`, `description`) VALUES
(6, 3, '2024-05-08 00:00:00', 5, 300, 'Beer');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `viewed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `name`, `email`, `subject`, `message`, `viewed`) VALUES
(7, 'Rahim Morgan', 'libicasu@mailinator.com', NULL, 'Tempora velit error', 1),
(8, 'Mariko Baker', 'zylaferyby@mailinator.com', NULL, 'Laborum Ullamco aut', 1),
(9, 'Mariko Baker', 'zylaferyby@mailinator.com', NULL, 'Laborum Ullamco aut', 1),
(10, 'Mariko Baker', 'zylaferyby@mailinator.com', NULL, 'Laborum Ullamco aut', 1),
(11, 'Mariko Baker', 'zylaferyby@mailinator.com', NULL, 'Laborum Ullamco aut', 1),
(12, 'Mariko Baker', 'zylaferyby@mailinator.com', NULL, 'Laborum Ullamco aut', 1),
(13, 'Mariko Baker', 'zylaferyby@mailinator.com', NULL, 'Laborum Ullamco aut', 1),
(14, 'Mariko Baker', 'zylaferyby@mailinator.com', NULL, 'Laborum Ullamco aut', 1),
(15, 'Mariko Baker', 'zylaferyby@mailinator.com', NULL, 'Laborum Ullamco aut', 1),
(16, 'Gareth Wiley', 'zejebyza@mailinator.com', NULL, 'Dolores ipsa accusa', 1),
(17, 'Paula Houston', 'jevud@mailinator.com', NULL, 'Est ipsa nisi pari', 1),
(18, 'Noah Grant', 'hinyb@mailinator.com', NULL, 'Consequat Veritatis', 1),
(19, 'Constance Thomas', 'wowikor@mailinator.com', NULL, 'Possimus quidem vol', 1);

-- --------------------------------------------------------

--
-- Table structure for table `diets`
--

CREATE TABLE `diets` (
  `id` int(11) NOT NULL,
  `category` enum('weight-loss','weight-gain','keto') NOT NULL,
  `food_image` varchar(255) DEFAULT NULL,
  `food_name` varchar(255) NOT NULL,
  `protein` decimal(5,2) NOT NULL,
  `calories` int(11) NOT NULL,
  `meal_type` enum('breakfast','lunch','dinner') NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diets`
--

INSERT INTO `diets` (`id`, `category`, `food_image`, `food_name`, `protein`, `calories`, `meal_type`, `description`) VALUES
(24, 'keto', 'admin/uploads/663ba554c827a-6278160.jpg', 'Inga Acosta', 61.00, 75, 'lunch', 'Vero qui voluptate p');

-- --------------------------------------------------------

--
-- Table structure for table `diet_items`
--

CREATE TABLE `diet_items` (
  `id` int(11) NOT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `category` enum('veg','non-veg','ayurvedic','dairy') DEFAULT NULL,
  `calories` int(11) DEFAULT NULL,
  `serving` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_items`
--

INSERT INTO `diet_items` (`id`, `food_name`, `category`, `calories`, `serving`, `description`, `user_id`) VALUES
(23, 'Martina Cardenas', 'non-veg', 46, 59, 'In qui anim harum ea', 4),
(24, 'Cadman Fleming', 'dairy', 2, 71, 'Omnis explicabo Asp', 4),
(30, 'Jamalia Bradford', 'dairy', 98, 5, 'Commodo pariatur Qu', 3);

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE `entries` (
  `id` int(11) NOT NULL,
  `meal_name` varchar(255) NOT NULL,
  `protein_grams` float NOT NULL,
  `meal_time` time NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_protein` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entries`
--

INSERT INTO `entries` (`id`, `meal_name`, `protein_grams`, `meal_time`, `user_id`, `total_protein`) VALUES
(1, 'Chicken Salad', 30, '12:00:00', 101, 30),
(2, 'Greek Yogurt', 10, '08:00:00', 102, 10),
(3, 'Grilled Salmon', 25, '19:00:00', 103, 25),
(0, 'Turkey Breast', 29, '14:22:00', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `login_time` datetime DEFAULT current_timestamp(),
  `device` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `login_time`, `device`, `ip_address`) VALUES
(1, 11787, '2024-05-04 19:36:18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(2, 10002, '2024-05-04 19:42:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(3, 11787, '2024-05-04 20:02:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(4, 10002, '2024-05-04 20:02:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(5, 11787, '2024-05-04 20:08:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(6, 11787, '2024-05-04 20:36:02', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(7, 10002, '2024-05-04 20:36:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(8, 11787, '2024-05-04 20:44:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(9, 10002, '2024-05-04 21:28:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(10, 11787, '2024-05-04 22:09:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(11, 10002, '2024-05-04 22:10:01', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(12, 10002, '2024-05-04 22:10:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(13, 11787, '2024-05-04 22:12:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(14, 11787, '2024-05-04 22:15:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(15, 11787, '2024-05-05 12:37:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(16, 10002, '2024-05-05 12:50:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(17, 11787, '2024-05-05 13:57:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(18, 11787, '2024-05-05 14:57:41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(19, 11787, '2024-05-05 14:59:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(20, 11787, '2024-05-05 16:00:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(21, 11787, '2024-05-05 20:34:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(22, 10002, '2024-05-05 20:36:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(23, 11787, '2024-05-05 20:40:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(24, 11787, '2024-05-05 20:50:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(25, 10002, '2024-05-05 20:51:30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(26, 11787, '2024-05-05 20:52:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(27, 11787, '2024-05-05 20:54:24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(28, 10002, '2024-05-05 20:57:47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(29, 11787, '2024-05-05 21:25:59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(30, 11787, '2024-05-05 21:26:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(31, 10002, '2024-05-05 22:51:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(32, 10002, '2024-05-06 14:33:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(33, 10002, '2024-05-06 14:37:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(34, 10002, '2024-05-06 14:37:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(35, 10002, '2024-05-06 14:46:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(36, 10002, '2024-05-06 15:18:30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(37, 10002, '2024-05-06 20:14:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 OPR/109.0.0.0', '::1'),
(38, 11787, '2024-05-06 20:23:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(39, 10002, '2024-05-06 20:28:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(40, 10002, '2024-05-06 23:06:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(41, 10002, '2024-05-07 16:38:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(42, 10002, '2024-05-07 16:56:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(43, 10002, '2024-05-07 16:56:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(44, 11787, '2024-05-07 17:28:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(45, 11787, '2024-05-07 17:29:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(46, 10002, '2024-05-07 22:43:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(47, 10002, '2024-05-07 22:50:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(48, 11787, '2024-05-07 22:50:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(49, 11787, '2024-05-08 17:18:42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(50, 10002, '2024-05-08 17:45:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(51, 11787, '2024-05-08 17:45:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(52, 11787, '2024-05-08 21:13:59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(53, 10002, '2024-05-08 21:16:29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(54, 11787, '2024-05-08 21:37:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(55, 10002, '2024-05-10 22:17:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(56, 10002, '2024-05-10 22:46:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(57, 10002, '2024-05-10 23:04:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(58, 10002, '2024-05-11 16:16:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(59, 10002, '2024-05-11 16:20:01', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(60, 11787, '2024-05-11 20:15:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(61, 11787, '2024-05-11 20:59:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(62, 10002, '2024-05-12 07:08:29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(63, 11787, '2024-05-12 07:39:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(64, 10002, '2024-05-12 07:41:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(65, 11787, '2024-05-14 09:22:12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(66, 10002, '2024-05-14 09:40:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(67, 11787, '2024-05-14 09:51:12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(68, 10002, '2024-05-14 10:06:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0', '::1'),
(69, 11787, '2024-05-14 10:06:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '::1'),
(70, 11787, '2024-05-20 20:19:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(71, 11787, '2024-05-25 20:13:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(72, 11787, '2024-05-25 20:26:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(73, 11787, '2024-05-25 20:45:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36 Edg/125.0.0.0', '::1'),
(75, 10002, '2024-05-25 21:26:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36 Edg/125.0.0.0', '::1'),
(76, 11787, '2024-05-26 10:18:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(77, 11787, '2024-06-05 20:32:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(78, 10002, '2024-06-05 23:22:01', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36 Edg/125.0.0.0', '::1'),
(79, 10002, '2024-06-05 23:29:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36 Edg/125.0.0.0', '::1'),
(80, 11787, '2024-06-06 00:28:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(81, 11787, '2024-06-07 00:31:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(82, 10002, '2024-06-07 01:23:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(83, 11787, '2024-06-07 01:29:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(84, 11787, '2024-06-07 20:27:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(85, 10002, '2024-06-07 20:29:46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(86, 11787, '2024-06-13 12:14:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(87, 10002, '2024-06-13 12:19:18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(88, 10002, '2024-06-13 12:22:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(89, 11787, '2024-06-13 12:22:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', '::1'),
(90, 11787, '2024-06-16 20:27:19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '::1'),
(91, 11787, '2024-06-16 23:02:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '::1'),
(92, 11787, '2024-06-16 23:19:42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '::1'),
(93, 11787, '2024-06-16 23:27:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 Edg/126.0.0.0', '::1'),
(94, 11787, '2024-06-17 11:46:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '::1'),
(95, 10002, '2024-06-17 11:47:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '::1'),
(96, 11787, '2024-06-17 11:47:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '::1'),
(97, 11787, '2024-06-17 16:36:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '::1'),
(98, 11787, '2024-06-17 16:44:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '::1'),
(99, 10002, '2024-06-17 16:47:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '::1'),
(100, 11787, '2024-06-17 16:48:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `np_nutrition`
--

CREATE TABLE `np_nutrition` (
  `id` int(11) NOT NULL,
  `Food_name` varchar(255) NOT NULL,
  `Protein` float NOT NULL,
  `Calories` float NOT NULL,
  `Amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `np_nutrition`
--

INSERT INTO `np_nutrition` (`id`, `Food_name`, `Protein`, `Calories`, `Amount`) VALUES
(1, 'Chicken Breast', 31, 165, 100),
(2, 'Turkey Breast', 29, 135, 100),
(3, 'Salmon', 25, 206, 100),
(4, 'Tuna', 30, 144, 100),
(5, 'Eggs', 13, 155, 100),
(6, 'Greek Yogurt', 10, 59, 100),
(7, 'Cottage Cheese', 11, 98, 100),
(8, 'Lean Beef', 26, 250, 100),
(9, 'Pork Tenderloin', 28, 143, 100),
(10, 'Quinoa', 4, 120, 100),
(11, 'Brown Rice', 2.6, 111, 100),
(12, 'Sweet Potato', 1.6, 86, 100),
(13, 'Oats', 16.9, 389, 100),
(14, 'Whole Wheat Bread', 7.9, 247, 100),
(15, 'Almonds', 21.2, 576, 100),
(16, 'Peanuts', 25.8, 567, 100),
(17, 'Walnuts', 15.2, 654, 100),
(18, 'Chickpeas', 8.9, 164, 100),
(19, 'Lentils', 9, 116, 100),
(20, 'Black Beans', 8.9, 132, 100),
(21, 'Kidney Beans', 8.7, 127, 100),
(22, 'Broccoli', 2.8, 34, 100),
(23, 'Spinach', 2.9, 23, 100),
(24, 'Kale', 2.9, 35, 100),
(25, 'Brussels Sprouts', 3.4, 43, 100),
(26, 'Asparagus', 2.2, 20, 100),
(27, 'Bell Peppers', 0.9, 31, 100),
(28, 'Carrots', 0.9, 41, 100),
(29, 'Cauliflower', 1.9, 25, 100),
(30, 'Tomatoes', 0.9, 18, 100),
(31, 'Blueberries', 0.7, 57, 100),
(32, 'Strawberries', 0.8, 32, 100),
(33, 'Bananas', 1.1, 89, 100),
(34, 'Apples', 0.3, 52, 100),
(35, 'Oranges', 1, 47, 100),
(36, 'Pineapple', 0.5, 50, 100),
(37, 'Cottage Cheese', 10.4, 98, 100),
(38, 'Milk', 3.4, 42, 100),
(39, 'Whey Protein', 70, 407, 100),
(40, 'Casein Protein', 70, 402, 100),
(41, 'Creatine', 0, 0, 100),
(42, 'Beta-Alanine', 0, 0, 100),
(43, 'BCAAs', 0, 0, 100),
(44, 'Fish Oil', 0, 902, 100),
(45, 'Multivitamin', 0, 0, 100),
(46, 'Vitamin D', 0, 0, 100),
(47, 'Magnesium', 0, 0, 100);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(1, 'prasanga@gmail.com', '96c241fd32916db5439c009b89127ed0', '2024-05-04 15:40:56'),
(2, 'prasanga@gmail.com', 'ddf31e9b3ad7eee90bf3a1e7a060e762', '2024-05-04 15:41:05'),
(3, 'prasanga@gmail.com', 'f16db62ad033aca3bac3b4989a440c46', '2024-05-04 15:41:14'),
(4, 'prasanga@gmail.com', '008babac0f740bfe3c61554f8fe19a8b', '2024-05-04 15:42:28'),
(5, 'incpractical@gmail.com', '39f5319067e9644af83ebc7bdd480102', '2024-05-04 15:44:59'),
(6, 'incpractical@gmail.com', '63a9dda99f7f82cd2eb933e0fb4f5f60', '2024-05-04 15:53:07'),
(7, 'incpractical@gmail.com', '8297d37a418535784e90ce061fbf1fd5', '2024-05-04 15:53:49'),
(8, 'incpractical@gmail.com', '340c022a230c56025929b38a2490092c', '2024-05-04 15:56:37'),
(9, 'incpractical@gmail.com', '59a6d508d6548e54919a923989f999ad', '2024-05-04 15:59:58'),
(10, 'incpractical@gmail.com', '157c80991525fe65762afc85fa983f94', '2024-05-04 16:00:15');

-- --------------------------------------------------------

--
-- Table structure for table `payment_record`
--

CREATE TABLE `payment_record` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT curdate(),
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `payable_amount` decimal(10,2) DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT 'Unknown',
  `transaction_reference` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sitesettings`
--

CREATE TABLE `sitesettings` (
  `id` int(11) NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `header_image` varchar(255) NOT NULL,
  `site_logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sitesettings`
--

INSERT INTO `sitesettings` (`id`, `site_title`, `header_image`, `site_logo`) VALUES
(1, 'Abra Pro', 'C:/xampp/htdocs/fitnepal/home/assets/8.png', 'C:/xampp/htdocs/fitnepal/home/assets/3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `height` int(11) NOT NULL,
  `activity` enum('normal','intermediate','highly_active') NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `registration_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) DEFAULT 'inactive',
  `role` varchar(50) DEFAULT 'user',
  `google_auth_secret` varchar(32) DEFAULT NULL,
  `verified` enum('Unverified','Verified') DEFAULT 'Unverified',
  `muscle_protein` double DEFAULT NULL,
  `normal_protein` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `email`, `password`, `age`, `weight`, `height`, `activity`, `profile_picture`, `registration_time`, `status`, `role`, `google_auth_secret`, `verified`, `muscle_protein`, `normal_protein`) VALUES
(3, 11787, 'Prasanga Pokharel', 'prasanga@gmail.com', '$2y$10$H2Y7f6Ph26npbfj0eG33wuyPcrEH/ews9B3YIdGMCclOUDgUNDxMa', 11, 68.00, 93, 'highly_active', 'profilepic/protein logo.png', '2024-05-02 18:09:41', 'active', 'user', 'IAWTC4TZWDMYWSWL', 'Unverified', 136, 54.400000000000006),
(18, 24872, 'Roanna Mcfarland', 'tukanez@mailinator.com', '$2y$10$o//xJXFHa4saJ7QUIXs94uRE7uXh28Oy55Xin9TorwHQKLolBr5FC', 35, 29.00, 48, 'intermediate', NULL, '2024-05-04 09:48:00', 'inactive', 'user', NULL, 'Unverified', NULL, NULL),
(21, 10002, 'Abijeet Raut', 'inc@gmail.com', '$2y$10$w/fPyYONqgrfAtyH.CJIq.hSVUKSdchcprNHUefyUeK7u7OZgIQPi', 22, 65.00, 175, 'normal', 'profilepic/49d8e82040dfc158d398c2dbefbf11a2.jpg', '2024-05-04 13:31:47', 'active', 'admin', 'E6RI4VBSA3MHDBIY', 'Unverified', NULL, NULL),
(22, 54473, 'Sylvester Chandler', 'incpractical@gmail.com', '$2y$10$plJ6UBpDqBmNej3ncAXtrem77aJcxUHyIKietI6w4H2hzGUxZEopq', 51, 40.00, 12, 'normal', NULL, '2024-05-04 15:44:34', 'inactive', 'user', NULL, 'Unverified', NULL, NULL),
(23, 32300, 'Sawyer Irwin', 'lipogoge@mailinator.com', '$2y$10$fCpqjw6OwX3w0aQwSPikueIP5TONQ.hoPwPgCfizjN97sUSeryWzG', 35, 22.00, 54, 'normal', NULL, '2024-05-04 16:24:11', 'inactive', 'user', NULL, 'Unverified', NULL, NULL),
(26, 49260, 'Prasanga Pokharel', 'rasuzygo@mailinator.com', '$2y$10$UWZfNo5rJyf.sIEtBCR0Vul8VjJUypRsZDy0CRYNaEC8sAgCtPP/u', 85, 96.00, 35, '', NULL, '2024-06-13 06:29:01', 'inactive', 'user', NULL, 'Unverified', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bankpayment`
--
ALTER TABLE `bankpayment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calorie`
--
ALTER TABLE `calorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diets`
--
ALTER TABLE `diets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diet_items`
--
ALTER TABLE `diet_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `np_nutrition`
--
ALTER TABLE `np_nutrition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_record`
--
ALTER TABLE `payment_record`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sitesettings`
--
ALTER TABLE `sitesettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bankpayment`
--
ALTER TABLE `bankpayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `calorie`
--
ALTER TABLE `calorie`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `diets`
--
ALTER TABLE `diets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `diet_items`
--
ALTER TABLE `diet_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `np_nutrition`
--
ALTER TABLE `np_nutrition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment_record`
--
ALTER TABLE `payment_record`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sitesettings`
--
ALTER TABLE `sitesettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calorie`
--
ALTER TABLE `calorie`
  ADD CONSTRAINT `calorie_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_record`
--
ALTER TABLE `payment_record`
  ADD CONSTRAINT `payment_record_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
