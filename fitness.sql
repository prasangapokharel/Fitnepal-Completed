-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 03:34 AM
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
(4, 3, '2024-03-16 00:00:00', 3, 300, 'Beer'),
(5, 3, '1996-08-29 00:00:00', 5, 30, 'Egg');

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
(24, 'Cadman Fleming', 'dairy', 2, 71, 'Omnis explicabo Asp', 4);

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE `entries` (
  `id` int(11) NOT NULL,
  `meal_name` varchar(255) NOT NULL,
  `protein_grams` float NOT NULL,
  `meal_time` time NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entries`
--

INSERT INTO `entries` (`id`, `meal_name`, `protein_grams`, `meal_time`, `user_id`) VALUES
(0, 'Idona Ferguson', 59, '07:37:00', 3),
(0, 'Zenaida Donovan', 38, '20:08:00', 3),
(0, 'Audra Madden', 79, '07:31:00', 3),
(0, 'Owen Mcbride', 18, '20:26:00', 3),
(0, 'Maggie Odom', 57, '02:42:00', 3),
(0, 'Urielle Frost', 31, '13:55:00', 4),
(0, 'Palmer House', 93, '11:31:00', 4),
(0, 'Kelly Burris', 73, '04:05:00', 4),
(0, 'Aimee Gates', 41, '01:59:00', 3),
(0, 'Brandon Valdez', 89, '21:48:00', 3),
(0, 'Chicken Breast', 31, '14:22:00', 4),
(0, 'Milk', 3.4, '11:12:00', 4),
(0, 'Chicken Breast', 31, '08:00:00', 6);

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
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `calories_consumed` decimal(8,2) DEFAULT NULL,
  `protein_consumed` decimal(8,2) DEFAULT NULL,
  `progress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `email`, `password`, `age`, `weight`, `height`, `activity`, `profile_picture`) VALUES
(3, 11787, 'Cody Murphy', 'prasanga@gmail.com', '$2y$10$MY3oRnkfwUoE160D4jhoTuhYxzEQAuUm7J9Onv7AVSsrThPvOXIYO', 11, 68.00, 93, 'highly_active', 'profilepic/selena rare.jpg'),
(4, 80453, 'Rhiannon Schroeder', 'jaya@gmail.com', '$2y$10$pKkcRTU/54TROeqcfvpaseKzXwTLttPtGRlqriCKBNQJS8OJQD8SS', 16, 15.00, 70, 'intermediate', 'profilepic/logo.png'),
(5, 85182, 'Prasanga Raman Raman', 'godsupercell1@gmail.com', '$2y$10$lKx2T85GPAe2xketeJOboubyuC1iUfGVc2RMyAF8rLZLF9V3gVC7O', 22, 98.00, 172, 'intermediate', NULL),
(6, 95956, 'Pratik Acharya', 'pratik@gmail.com', '$2y$10$l9zfu.KPEWmjGuiVGmVpjOUHirrU7B/GQ537WHxsm4.Vjs8DZkB1e', 28, 81.00, 168, 'intermediate', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calorie`
--
ALTER TABLE `calorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `diet_items`
--
ALTER TABLE `diet_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `np_nutrition`
--
ALTER TABLE `np_nutrition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calorie`
--
ALTER TABLE `calorie`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `diet_items`
--
ALTER TABLE `diet_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `np_nutrition`
--
ALTER TABLE `np_nutrition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calorie`
--
ALTER TABLE `calorie`
  ADD CONSTRAINT `calorie_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `tracking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
