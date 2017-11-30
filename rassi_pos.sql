-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2017 at 07:23 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rassi_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cprod_id` int(10) UNSIGNED NOT NULL,
  `cprod_qty` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(20) NOT NULL,
  `product_code` varchar(250) NOT NULL,
  `product_quantity` int(10) UNSIGNED NOT NULL,
  `product_price` decimal(15,2) UNSIGNED NOT NULL,
  `product_description` text,
  `product_model` varchar(200) NOT NULL,
  `product_brand` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `sale_id` int(8) UNSIGNED ZEROFILL NOT NULL,
  `sale_cashier` int(10) UNSIGNED NOT NULL,
  `sale_cash` decimal(15,2) UNSIGNED NOT NULL,
  `sale_time` datetime NOT NULL,
  `sale_dine` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_item`
--

CREATE TABLE `sale_item` (
  `sale_id` int(8) UNSIGNED ZEROFILL NOT NULL,
  `prod_id` int(10) UNSIGNED NOT NULL,
  `prod_qty` int(10) UNSIGNED NOT NULL,
  `prod_price` decimal(15,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subproduct`
--

CREATE TABLE `subproduct` (
  `parent_id` int(10) UNSIGNED NOT NULL,
  `child_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `passcode` varchar(50) NOT NULL,
  `user_type` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `passcode`, `user_type`) VALUES
(1, 'James Ginete', '12345', b'0'),
(3, 'Jayson Jarquio', '12345', b'1'),
(4, 'Vann Amarillo', '67890', b'0'),
(6, 'Ira Gamban', '67890', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `product` (`cprod_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_name` (`product_name`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `users_cashier` (`sale_cashier`);

--
-- Indexes for table `sale_item`
--
ALTER TABLE `sale_item`
  ADD UNIQUE KEY `sale_id_prod_id` (`sale_id`,`prod_id`),
  ADD KEY `sale_item_products` (`prod_id`);

--
-- Indexes for table `subproduct`
--
ALTER TABLE `subproduct`
  ADD UNIQUE KEY `parent_id_child_id` (`parent_id`,`child_id`),
  ADD KEY `child` (`child_id`);

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
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `sale_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `product` FOREIGN KEY (`cprod_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `users_cashier` FOREIGN KEY (`sale_cashier`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `sale_item`
--
ALTER TABLE `sale_item`
  ADD CONSTRAINT `sale_item_products` FOREIGN KEY (`prod_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `sales` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`sale_id`);

--
-- Constraints for table `subproduct`
--
ALTER TABLE `subproduct`
  ADD CONSTRAINT `child` FOREIGN KEY (`child_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `parent` FOREIGN KEY (`parent_id`) REFERENCES `products` (`product_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
