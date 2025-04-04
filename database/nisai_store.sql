-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 04:21 PM
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
(6, 'ខោអាវខាងក្រៅ', 'Mens-Jacket-Coats-Inforgraphic-RMRS-1000.jpg'),
(7, 'ឈុតគេង', '650b036bade7e06f942acaa1-lecgee-womens-4-pcs-satin-pajamas-set.jpg'),
(8, 'អាវយឺត', '67c867a018dcc.jpg'),
(9, 'អាវកីឡា', '465652208_8721822621234753_4844209421079483033_n.jpg');

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
(5, 'អាវយឺត ដៃខ្លី', 8, 1, 5.00, 14, 'L', 'ពណ៏ក្រហម', '475030249_626046546487003_511233801569818552_n.jpg', '2025-02-27 14:05:53', '2025-03-26 09:44:37', '105'),
(9, 'អាវ', 1, 1, 5.00, 11, 'M', 'ពណ៌សរ', '67c904a7bdd61.jpg', '2025-03-06 02:06:00', '2025-03-17 07:07:51', 'P001'),
(12, 'អាវស្រី', 3, 1, 5.00, 6, 'L', 'ពណ៌ខ្មៅ', '471426167_597403346226837_8793461616854188392_n.jpg', '2025-03-15 10:44:06', '2025-03-26 09:33:07', '106'),
(13, 'អាវដៃវែង', 1, 1, 5.00, 10, 'XL', 'ពណ៌ត្នោត', '485067583_634240566063627_5107529723671366182_n.jpg', '2025-03-26 09:53:07', '2025-03-26 09:53:07', '110');

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
(3, 0, 'P001', 'អាវ', 'ពណ៌សរ', 2, 0.00, '2025-03-06 07:32:11', 'admin', 10.00, 'Completed', '5.00'),
(4, 0, '105', 'អាវយឺត ដៃខ្លី', 'ពណ៏ក្រហម', 2, 10.00, '2025-03-06 07:33:22', 'admin', 9.00, 'Completed', '5.00'),
(5, 0, 'P001', 'អាវ', 'ពណ៌សរ', 1, 20.00, '2025-03-06 07:33:22', 'admin', 4.00, 'Completed', '5.00'),
(6, 0, 'P001', 'អាវ', 'ពណ៌សរ', 1, 0.00, '2025-03-06 07:37:04', 'admin', 5.00, 'Completed', '5.00'),
(7, 0, 'P001', 'អាវ', 'ពណ៌សរ', 1, 0.00, '2025-03-06 07:38:03', 'admin', 5.00, 'Completed', '5.00'),
(8, 0, 'P001', 'អាវ', 'ពណ៌សរ', 1, 0.00, '2025-03-06 07:39:56', 'admin', 5.00, 'Completed', '5.00'),
(9, 0, '105', 'អាវយឺត ដៃខ្លី', 'ពណ៏ក្រហម', 3, 0.00, '2025-03-16 01:26:33', 'admin', 15.00, 'Completed', '5.00'),
(10, 0, 'P001', 'អាវ', 'ពណ៌សរ', 3, 50.00, '2025-03-17 01:07:31', 'soknov', 7.50, 'Completed', '5.00'),
(11, 0, '105', 'អាវយឺត ដៃខ្លី', 'ពណ៏ក្រហម', 2, 0.00, '2025-03-25 01:39:04', 'soknov', 10.00, 'Completed', '5.00'),
(12, 0, '105', 'អាវយឺត ដៃខ្លី', 'ពណ៏ក្រហម', 1, 0.00, '2025-03-25 01:54:28', 'soknov', 5.00, 'Completed', '5.00'),
(13, 0, '105', 'អាវយឺត ដៃខ្លី', 'ពណ៏ក្រហម', 1, 0.00, '2025-03-25 02:13:51', 'soknov', 5.00, 'Completed', '5.00'),
(14, 0, '106', 'អាវស្រី', 'ពណ៌ខ្មៅ', 1, 0.00, '2025-03-25 02:14:23', 'soknov', 5.00, 'Completed', '5.00'),
(15, 0, '105', 'អាវយឺត ដៃខ្លី', 'ពណ៏ក្រហម', 1, 0.00, '2025-03-26 03:27:01', 'admin', 5.00, 'Completed', '5.00'),
(16, 0, '106', 'អាវស្រី', 'ពណ៌ខ្មៅ', 2, 0.00, '2025-03-26 03:32:03', 'admin', 10.00, 'Completed', '5.00'),
(17, 0, '106', 'អាវស្រី', 'ពណ៌ខ្មៅ', 1, 0.00, '2025-03-26 03:33:02', 'admin', 5.00, 'Completed', '5.00'),
(18, 0, '105', 'អាវយឺត ដៃខ្លី', 'ពណ៏ក្រហម', 1, 0.00, '2025-03-26 03:44:26', 'admin', 5.00, 'Completed', '5.00');

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
(1, 'Lem', '0123456789', 'takoe', '2025-02-06 02:43:54'),
(5, 'Suppliers', '08811223333', 'Phnom​ penh', '2025-03-16 05:58:48');

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
  `role` enum('admin','employee') DEFAULT 'employee',
  `status` tinyint(1) DEFAULT 1 COMMENT '1=Active, 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`, `status`) VALUES
(1, 'soknov', 'soknov6236@gmail.com', '$2y$10$e0aELOtGPbkeciP3A0I94.yMktUfB4TVltuDucVRL9j1li8BlOoGu', '2025-03-28 10:13:04', 'admin', 1),
(7, 'admin', 'admin@gmail.com', '$2y$10$/k0ctlYm4NGn9LIJ1ADhsuB7T26h9PRjzX6KFAW9lrH1u5zL7HZYe', '2025-03-30 12:47:26', 'admin', 1),
(8, 'lem123', 'lem123@gmail.com', '$2y$10$cKcrUi4uxTlQWaqOxkKL9OH/e4HkhcBIjF/Bg0uWEaY8UBR9lsiDS', '2025-03-30 12:50:05', 'employee', 1);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
