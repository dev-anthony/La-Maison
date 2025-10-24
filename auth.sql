-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2025 at 02:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET NAMES utf8mb4;

--
-- Database: `auth`
--

-- --------------------------------------------------------
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Tony', 'anthonyachibi@gmail.com', '$2y$10$MarSNpYU6zHFe0Z7iNPCGuRpWC8N68xTFboJ1pFr3fNVhMCZNLR6u', '2025-10-22 11:27:49');

-- --------------------------------------------------------
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('Pending','approved','rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `applications` (`id`, `house_id`, `user_id`, `status`, `created_at`, `applied_at`) VALUES
(1, 1, 1, 'approved', '2025-10-22 11:50:05', '2025-10-22 11:51:26');

-- --------------------------------------------------------
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `houses`
--

CREATE TABLE `houses` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `location` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `status` enum('available','taken') DEFAULT 'available',
  `image` varchar(255) DEFAULT NULL,
  `admin_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `houses` (`id`, `title`, `location`, `price`, `description`, `status`, `image`, `admin_id`, `created_at`) VALUES
(1, 'Harmony Estate', 'Enugu City, Enugu', 18000000.00, 'Newly built 3-bedroom detached house with a beautiful garden.', 'available', '68f8c0ed0d482_68b92c6cd7b48_68628c4a9df50_683cc4079e03f_background-for-house-app.jpg', 1, '2025-10-22 11:33:01'),
(2, 'Emerald Suites', 'Owerri, Imo', 15000000.00, 'Beautiful 3-bedroom serviced apartment with solar power backup.', 'available', '68f8c13c05a98_68b92e389c80c_pexels-maximilianmedia-399627.jpg', 1, '2025-10-22 11:34:20'),
(3, 'Oakwood Villa', 'Lekki Phase 1, Lagos', 45000000.00, 'A modern 4-bedroom duplex with a private pool, rooftop terrace, and 24-hour security.', 'available', '68f8c1852723e_681c8072a6b96_pexels-karina-badura-3100400-31935468.jpg', 1, '2025-10-22 11:35:33'),
(4, 'Maple Residency', 'Garki, Abuja', 30000000.00, 'Spacious 3-bedroom bungalow located in a serene and secure neighborhood.', 'available', '68f8c1d42bc21_68b92d65a75d4_pexels-curtis-adams-1694007-6510949.jpg', 1, '2025-10-22 11:36:52');

-- --------------------------------------------------------
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `sender_type` enum('user','admin') NOT NULL,
  `receiver_type` enum('user','admin') NOT NULL,
  `message` text DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `sender_type`, `receiver_type`, `message`, `file_url`, `timestamp`, `is_read`) VALUES
(1, 1, 1, 'user', 'admin', 'hi', NULL, '2025-10-22 11:38:32', 1),
(2, 1, 1, 'user', 'admin', 'hello', NULL, '2025-10-22 11:44:39', 1);

-- --------------------------------------------------------
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 'A new rental application has been submitted for your house.', 0, '2025-10-22 11:50:05'),
(2, 1, 'Your rental application has been approved. Proceed to payment here: <a href=\'/Authentication/Frontend/php/house-details.php?id=1\'>View House</a>', 0, '2025-10-22 11:51:58');

-- --------------------------------------------------------
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `transaction_ref` varchar(100) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('success','failed','pending') DEFAULT 'pending',
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `payments` (`id`, `property_id`, `user_id`, `email`, `transaction_ref`, `amount`, `status`, `paid_at`) VALUES
(1, 1, 1, 'anthonyjoseph2569@gmail.com', 'HOUSE_1_105465629', 18000000.00, 'success', '2025-10-22 11:58:44');

-- --------------------------------------------------------
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Anthony Joseph', 'anthonyjoseph2569@gmail.com', '$2y$10$L4p6kwLIBNsMSi3wv2e31eTyif8ZsiwRunRUPFsnlK2/WjbqMyRwy', '2025-10-22 11:25:15');

-- --------------------------------------------------------
-- Indexes and Constraints
--

ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `house_id` (`house_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `houses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_ref` (`transaction_ref`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

-- --------------------------------------------------------
-- AUTO_INCREMENT
--

ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `houses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- --------------------------------------------------------
-- Foreign Keys
--

ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `houses`
  ADD CONSTRAINT `houses_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

COMMIT;
