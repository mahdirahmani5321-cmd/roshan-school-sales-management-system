-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2025 at 09:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rssms`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `photo` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `price`, `stock_quantity`, `photo`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dari 1st Class Book', 300.00, 14, 'product_693e943c26bba0.04982687.jpg', 'active', '2025-12-14 02:37:01', '2025-12-14 23:11:21'),
(3, 1, 'english', 400.00, 40, 'product_693e9486de7eb6.09377873.jpg', 'inactive', '2025-12-14 02:42:14', '2025-12-14 02:50:48'),
(4, 2, 'small t-shirt', 200.00, 27, 'product_693e964854e022.59157728.jpg', 'active', '2025-12-14 02:49:44', '2025-12-14 23:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`category_id`, `category_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Books ', 'Books from 1st class up to 12th class exist\r\n', '2025-12-14 19:22:02', '2025-12-14 19:22:02'),
(2, 'Clothes', 'from age 12 up to 20 years old kids cloths are exist', '2025-12-14 10:23:29', '2025-12-14 10:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `sale_item_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,0) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `total_price` decimal(10,0) DEFAULT NULL,
  `invoice_number` varchar(200) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sale_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`sale_item_id`, `product_id`, `quantity`, `unit_price`, `discount`, `total_price`, `invoice_number`, `student_id`, `user_id`, `sale_date`) VALUES
(4, 1, 4, 300, 180, 1020, 'INV-00003', 2, 2, '2025-12-14 23:11:21'),
(5, 4, 1, 200, 0, 200, 'INV-00004', 1, 2, '2025-12-14 23:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_code` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_code`, `full_name`, `class`, `phone`, `status`, `create_at`, `updated_at`) VALUES
(1, 'STD-020', 'Aziz', '1', '0783234123', 'active', '2025-12-14 10:09:08', '2025-12-14 10:15:10'),
(2, 'STD-021', 'Halim Jan', '3', '07312711232', 'inactive', '2025-12-14 10:10:09', '2025-12-14 10:10:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `lastname`, `email`, `password`, `status`, `create_at`, `updated_at`) VALUES
(1, 'mahdi', 'rahmani', 'mahdirahmani@gmail.com', 'c08047dcb8519f19dc45a0550fd2df0a', 'active', '2025-12-14 05:39:42', '2025-12-15 05:26:47'),
(2, 'Hamza', 'Nawabi', 'hamzanawabi123@gmail.com', '0192023a7bbd73250516f069df18b500', 'active', '2025-12-14 07:13:03', '2025-12-15 07:10:57'),
(3, 'shafi', 'noori', 'shafi@gmail.com', '0192023a7bbd73250516f069df18b500', 'active', '2025-12-14 08:44:36', '2025-12-14 08:44:36'),
(4, 'noor', 'azizi', 'azizi@gmail.com', '0192023a7bbd73250516f069df18b500', 'inactive', '2025-12-14 08:46:34', '2025-12-14 08:48:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`sale_item_id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `sale_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`category_id`) ON UPDATE CASCADE;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `sale_items_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
