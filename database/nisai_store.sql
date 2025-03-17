-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2025 at 04:15 AM
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
-- Database: `nisai_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `catid` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`catid`, `cat_title`, `picture`) VALUES
(1, 'សម្លៀកបំពាក់បុរស', 'istockphoto-864505242-612x612.jpg'),
(3, 'សំលៀកបំពាក់ស្ត្រី', '67c06a283750a_474625795_122191110932089828_2218410427387453237_n.jpg'),
(4, 'សំលៀកបំពាក់កុមារ', 'D10F3A55-2952-4D86-A06D-778FD9E4989C.jpeg'),
(5, 'Sportswear', '465652208_8721822621234753_4844209421079483033_n.jpg'),
(6, 'Outerwear ', 'Mens-Jacket-Coats-Inforgraphic-RMRS-1000.jpg'),
(7, 'Sleepwear ', '650b036bade7e06f942acaa1-lecgee-womens-4-pcs-satin-pajamas-set.jpg'),
(8, 'អាវយឺត', '475030249_626046546487003_511233801569818552_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `catid` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `size` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `catid`, `supplier_id`, `price`, `stock`, `size`, `color`, `image`, `created_at`, `updated_at`, `product_code`) VALUES
(3, 'Shirts', 1, 2, 10.00, 20, 'M', 'ពណ៌សរ', '67bfddc69112b.jpg', '2025-02-16 05:36:34', '2025-02-27 03:36:38', 'S001'),
(4, 'Shirts1', 3, 2, 15.00, 19, 'S', 'ពណ៌ខ្មៅ', '320717523_2048525178871776_3883248287693631467_n (1).jpg', '2025-02-16 05:37:09', '2025-02-26 15:03:20', 'S002'),
(5, 'អាវយឺត ដៃខ្លី', 8, 1, 5.00, 8, 'L', 'ពណ៏ក្រហម', '475030249_626046546487003_511233801569818552_n.jpg', '2025-02-27 14:05:53', '2025-02-27 15:22:26', '105'),
(6, 'អាវយឺត ដៃខ្លី', 8, 2, 5.00, 8, 'M', 'ពណ៏ក្រហម', '474838003_626046676486990_884064253820469824_n.jpg', '2025-02-27 14:09:24', '2025-02-27 15:21:48', '115'),
(7, 'អាវយឺត ', 8, 2, 7.00, 15, 'L', 'ពណ៌សរ', '471480157_597403326226839_2686564181309337728_n.jpg', '2025-02-27 14:13:42', '2025-02-27 14:13:42', '110'),
(8, 'អាវយឺត ដៃខ្លី', 8, 2, 7.00, 8, 'M', 'ពណ៌ខ្មៅ', '471426167_597403346226837_8793461616854188392_n.jpg', '2025-02-27 14:14:42', '2025-02-27 15:20:57', '111');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `discount` decimal(5,2) DEFAULT 0.00,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `cashier_name` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Completed','Pending','Cancelled') DEFAULT 'Completed',
  `price` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `product_id`, `product_code`, `product_name`, `color`, `quantity`, `discount`, `sale_date`, `cashier_name`, `total_amount`, `status`, `price`) VALUES
(1, 0, 'S001', 'Shirts', 'ពណ៌សរ', 2, 0.00, '2025-02-26 09:22:00', 'admin', 20.00, 'Completed', '10.00'),
(2, 0, 'S002', 'Shirts1', 'ពណ៌ខ្មៅ', 1, 0.00, '2025-02-26 09:22:00', 'admin', 25.00, 'Completed', '15.00'),
(3, 0, 'S001', 'Shirts', 'ពណ៌សរ', 2, 10.00, '2025-02-26 09:22:00', 'admin', 18.00, 'Completed', '10.00'),
(4, 0, 'S001', 'Shirts', 'ពណ៌សរ', 1, 0.00, '2025-02-26 09:31:00', 'admin', 10.00, 'Completed', '10.00'),
(5, 0, 'S002', 'Shirts1', 'ពណ៌ខ្មៅ', 1, 0.00, '2025-02-26 09:31:00', 'admin', 25.00, 'Completed', '15.00'),
(6, 0, 'S001', 'Shirts', 'ពណ៌សរ', 1, 0.00, '0000-00-00 00:00:00', 'soknov', 10.00, 'Completed', '10.00'),
(7, 0, 'S001', 'Shirts', 'ពណ៌សរ', 1, 0.00, '0000-00-00 00:00:00', 'soknov', 10.00, 'Completed', '10.00'),
(8, 0, 'S001', 'Shirts', 'ពណ៌សរ', 2, 2.00, '2025-02-26 09:46:26', 'soknov', 19.60, 'Completed', '10.00'),
(9, 0, 'S002', 'Shirts1', 'ពណ៌ខ្មៅ', 2, 0.00, '2025-02-26 09:46:26', 'soknov', 49.60, 'Completed', '15.00'),
(11, 0, 'S001', 'Shirts', 'ពណ៌សរ', 1, 0.00, '2025-02-27 07:54:43', 'admin', 10.00, 'Completed', '10.00'),
(12, 0, '115', 'អាវយឺត ដៃខ្លី', 'ពណ៏ក្រហម', 1, 0.00, '2025-02-27 08:19:24', 'admin', 5.00, 'Completed', '5.00'),
(13, 0, '115', 'អាវយឺត ដៃខ្លី', 'ពណ៏ក្រហម', 2, 3.00, '2025-02-27 09:15:50', 'admin', 9.70, 'Completed', '5.00'),
(14, 0, '111', 'អាវយឺត ដៃខ្លី', 'ពណ៌ខ្មៅ', 2, 0.00, '2025-02-27 09:20:46', 'admin', 14.00, 'Completed', '7.00'),
(15, 0, '115', 'អាវយឺត ដៃខ្លី', 'ពណ៏ក្រហម', 2, 3.00, '2025-02-27 09:21:30', 'admin', 9.70, 'Completed', '5.00'),
(16, 0, '105', 'អាវយឺត ដៃខ្លី', 'ពណ៏ក្រហម', 2, 0.00, '2025-02-27 09:22:09', 'admin', 10.00, 'Completed', '5.00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `address`, `created_at`) VALUES
(1, 'Lem', '0882256288', 'takoe', '2025-02-06 02:43:54'),
(2, 'Sok Nov', '0886230338', 'Phnom​ phenh', '2025-02-06 02:50:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('0','1') DEFAULT '0' COMMENT '0 = Active, 1 = Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$I7Uu2p/DyLRhxdo0egWuHeLV/YWyAbEmflL2Sgqa.iMgDhrR4trqm', '2025-02-26 14:21:04', '0'),
(2, 'user', 'soknov@gmail.com', '$2y$10$hlWQlmcR5q7or1VFHwIcVeVNde1MJ7kQ05WpQH/H7unMBAFdJqHzO', '2025-02-26 14:21:27', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`),
  ADD KEY `fk_products_category` (`catid`),
  ADD KEY `fk_products_supplier` (`supplier_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`catid`) REFERENCES `category` (`catid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_products_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
