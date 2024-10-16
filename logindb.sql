-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 07:26 AM
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
-- Database: `logindb`
--

-- --------------------------------------------------------

--
-- Table structure for table `addeditem`
--

CREATE TABLE `addeditem` (
  `id` int(11) NOT NULL,
  `productname` varchar(80) NOT NULL,
  `qty` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `dateadded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addeditem`
--

INSERT INTO `addeditem` (`id`, `productname`, `qty`, `price`, `dateadded`) VALUES
(11, 'Clay2', 123, 123, '2024-10-11 18:06:30'),
(12, 'alleb2', 123, 132, '2024-10-11 18:06:30'),
(13, 'asd', 123, 123, '2024-10-11 18:08:24'),
(14, 'sdg', 123, 3, '2024-10-11 18:08:30'),
(15, 'rfg', 123, 45, '2024-10-11 18:08:35'),
(16, 'asd', 213, 2, '2024-10-11 18:16:24'),
(17, 'gfdf', 2, 21, '2024-10-13 15:43:39'),
(18, 'cfd', 2, 3, '2024-10-13 15:43:45'),
(19, 'Clay', 2, 0, '2024-10-14 07:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `deleteditem`
--

CREATE TABLE `deleteditem` (
  `id` int(11) NOT NULL,
  `deletedproduct` varchar(80) NOT NULL,
  `datedeleted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleteditem`
--

INSERT INTO `deleteditem` (`id`, `deletedproduct`, `datedeleted`) VALUES
(2, 'bread', '0000-00-00 00:00:00'),
(3, 'Gun', '2024-10-11 17:22:07'),
(4, 'Clay', '2024-10-11 17:22:26'),
(5, 'hello', '2024-10-11 17:48:14'),
(6, 'Clay', '2024-10-11 17:26:19'),
(7, 'Toy', '2024-10-11 17:51:46'),
(8, 'hello', '2024-10-11 17:53:51'),
(9, 'alleb', '2024-10-11 18:03:25'),
(10, 'Clay2', '2024-10-11 18:03:26'),
(11, 'Clay2', '2024-10-11 18:03:28'),
(12, 'alleb2', '2024-10-11 18:08:38'),
(13, 'asd', '2024-10-11 18:08:39'),
(14, 'sdg', '2024-10-11 18:08:39'),
(15, 'rfg', '2024-10-11 18:08:40'),
(16, 'asd', '2024-10-14 07:50:11'),
(18, 'cfd', '2024-10-14 07:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `productname` varchar(80) NOT NULL,
  `qty` int(255) NOT NULL,
  `price` int(255) NOT NULL,
  `category` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `productname`, `qty`, `price`, `category`) VALUES
(17, 'gfdf', 2, 21, ''),
(19, 'Clay', 2, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `orderhistory`
--

CREATE TABLE `orderhistory` (
  `id` int(11) NOT NULL,
  `productname` varchar(100) NOT NULL,
  `qty` int(50) NOT NULL,
  `price` int(50) NOT NULL,
  `category` varchar(100) NOT NULL,
  `customername` varchar(100) NOT NULL,
  `datecompleted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productorder`
--

CREATE TABLE `productorder` (
  `id` int(11) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `qty` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `customername` varchar(100) NOT NULL,
  `dateadded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productorder`
--

INSERT INTO `productorder` (`id`, `productname`, `qty`, `price`, `category`, `customername`, `dateadded`) VALUES
(1, 'Clay', 20, 100, 'Bunni Charms', 'Allen', '2024-10-15 14:55:30'),
(2, 'Toy', 2, 50, 'Bunni Charms', 'Allen', '2024-10-15 14:58:10'),
(3, 'Controller', 30, 200, 'Phone Strap', 'Allen', '2024-10-15 15:01:24'),
(4, 'Bag', 30, 200, 'Phone Strap', 'Allen', '2024-10-15 15:04:21'),
(5, 'Bag', 30, 200, 'Phone Strap', 'Allen', '2024-10-15 15:06:10'),
(6, 'Bag', 30, 200, 'Phone Strap', 'Allen', '2024-10-15 15:07:03'),
(7, 'Bag', 30, 200, 'Phone Strap', 'Allen', '2024-10-15 15:08:58'),
(8, 'Bag', 30, 200, 'Phone Strap', 'Allen', '2024-10-15 15:09:20'),
(9, 'Food', 4, 34, 'Phone Strap', 'Allen', '2024-10-15 15:17:00'),
(10, 'Chao Fan', 4, 34, 'Phone Strap', 'Allen', '2024-10-15 15:17:29'),
(11, 'Aqua Flask', 2, 123, '', 'Allen', '2024-10-15 15:33:00'),
(12, 'Clay', 2, 3, '', 'Allen', '2024-10-15 15:33:22'),
(13, 'Clay2', 1, 2, '', 'Allen', '2024-10-15 15:33:36'),
(14, 'Bag', 1, 3, 'Boxes and Bundles', 'Allen', '2024-10-15 15:36:05'),
(15, 'Toy', 23, 60, 'General Goods', 'Jeremiah', '2024-10-16 05:07:14'),
(16, 'Controller', 10, 200, 'General Goods', 'Jorge', '2024-10-16 05:11:40'),
(17, 'Laptop', 5, 2000, 'Boxes and Bundles', 'Joshua', '2024-10-16 05:15:11'),
(18, 'Iphone', 10, 300, 'General Goods', 'Joshua', '2024-10-16 05:15:41'),
(19, 'Zeph', 10, 20, 'General Goods', 'Jose', '2024-10-16 05:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deleteditem`
--
ALTER TABLE `deleteditem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderhistory`
--
ALTER TABLE `orderhistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productorder`
--
ALTER TABLE `productorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deleteditem`
--
ALTER TABLE `deleteditem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orderhistory`
--
ALTER TABLE `orderhistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productorder`
--
ALTER TABLE `productorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
