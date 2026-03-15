-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2026 at 04:24 PM
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
-- Database: `findit_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `found_items`
--

CREATE TABLE `found_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `found_items`
--

INSERT INTO `found_items` (`id`, `user_id`, `title`, `description`, `category`, `image`, `created_at`) VALUES
(1, 1, 'Found Keys', 'Set of car keys found near parking lot', 'Accessories', 'keys_found.jpg', '2026-03-15 10:04:26'),
(2, 2, 'Found Backpack', 'Blue backpack found in lab', 'Bags', 'backpack_found.jpg', '2026-03-15 10:04:26'),
(3, 1, 'Found Wallet', 'Black leather wallet found near cafeteria', 'Accessories', 'wallet_found.jpg', '2026-03-15 10:04:26'),
(4, 3, 'Found Phone', 'iPhone 13 found in library', 'Electronics', 'phone_found.jpg', '2026-03-15 10:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `lost_items`
--

CREATE TABLE `lost_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `lost_items`
--

INSERT INTO `lost_items` (`id`, `user_id`, `title`, `description`, `category`, `image`, `created_at`) VALUES
(1, 2, 'Lost Wallet', 'Black leather wallet lost near library', 'Accessories', 'wallet.jpg', '2026-03-15 10:03:28'),
(2, 3, 'Lost Phone', 'iPhone 13 lost in cafeteria', 'Electronics', 'phone.jpg', '2026-03-15 10:03:28'),
(3, 2, 'Lost Keys', 'House keys with red keychain lost near lab', 'Accessories', 'keys.jpg', '2026-03-15 10:03:28'),
(4, 3, 'Lost Bag', 'Blue backpack lost in library', 'Bags', 'bag.jpg', '2026-03-15 10:03:28'),
(5, 12, 'bag', 'good looking, brown colour', 'sidebag', 'WhatsApp Image 2025-03-01 at 15.26.26 (1).jpeg', '2026-03-15 12:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `missing_persons`
--

CREATE TABLE `missing_persons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `last_seen` varchar(255) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'missing',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `missing_persons`
--

INSERT INTO `missing_persons` (`id`, `user_id`, `name`, `age`, `last_seen`, `contact`, `image`, `status`, `created_at`) VALUES
(1, 2, 'Michael Brown', 25, 'Library', '1234567890', 'michael.jpg', 'missing', '2026-03-15 10:06:31'),
(2, 3, 'Sarah Lee', 30, 'Cafeteria', '0987654321', 'sarah.jpg', 'missing', '2026-03-15 10:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `created_at`) VALUES
(1, 1, 'New lost item reported: Lost Wallet', '2026-03-15 10:07:54'),
(2, 1, 'New missing person reported: Michael Brown', '2026-03-15 10:07:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'naja', 'fathimanajah002@gmail.com', '$2y$10$ddgsuz1Hgfea7929ni1UkOmTEZ5iAnXm1jH9fVGZXhiRew5vGHKoC', 'user'),
(2, '1.5707963267948966', 'admin@findit.com', '123456', 'admin'),
(3, 'admin', 'admin@gmail.com', '123456', 'admin'),
(4, 'admin', 'admin@gmail.com', '1234', 'admin'),
(5, 'fathima', 'jhgdcv@gmai.com', '9876', 'user'),
(6, 'Admin User', 'admin@example.com', '$2y$10$eW5f1mH6Zl1OVL6o9z9C5OrE4i7KbC8eHw/uv7jE4o6B/rnxh0QyG', 'admin'),
(7, 'John Doe', 'john@example.com', '$2y$10$Kf7zDlQpNve7wT3F/bdB4uQbyyM5FzE7OdJgZC7VwBzLCzZ7x5qfK', 'user'),
(8, 'Jane Smith', 'jane@example.com', '$2y$10$Kf7zDlQpNve7wT3F/bdB4uQbyyM5FzE7OdJgZC7VwBzLCzZ7x5qfK', 'user'),
(9, 'Admin User', 'admin@example.com', '$2y$10$eW5f1mH6Zl1OVL6o9z9C5OrE4i7KbC8eHw/uv7jE4o6B/rnxh0QyG', 'admin'),
(10, 'John Doe', 'john@example.com', '$2y$10$Kf7zDlQpNve7wT3F/bdB4uQbyyM5FzE7OdJgZC7VwBzLCzZ7x5qfK', 'user'),
(11, 'Jane Smith', 'jane@example.com', '$2y$10$Kf7zDlQpNve7wT3F/bdB4uQbyyM5FzE7OdJgZC7VwBzLCzZ7x5qfK', 'user'),
(12, 'minha', 'minha@gmail.com', '$2y$10$SQ9vTUXVegItbuTKMTPk7elejf4AZFwpB.p9jUl8lRCUsy7wQ8CGa', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `found_items`
--
ALTER TABLE `found_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lost_items`
--
ALTER TABLE `lost_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `missing_persons`
--
ALTER TABLE `missing_persons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
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
-- AUTO_INCREMENT for table `found_items`
--
ALTER TABLE `found_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lost_items`
--
ALTER TABLE `lost_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `missing_persons`
--
ALTER TABLE `missing_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `missing_persons`
--
ALTER TABLE `missing_persons`
  ADD CONSTRAINT `missing_persons_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
