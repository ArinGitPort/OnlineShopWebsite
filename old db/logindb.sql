-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2024 at 05:05 PM
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
  `price` decimal(65,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `dateadded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deleteditem`
--

CREATE TABLE `deleteditem` (
  `id` int(11) NOT NULL,
  `deletedproduct` varchar(80) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `datedeleted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `productname` varchar(80) NOT NULL,
  `qty` int(255) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `category` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `productname`, `qty`, `price`, `category`) VALUES
(1, 'Cappybara Bunni Charm', 100, 28.00, 'Bunni Charms'),
(2, 'Mia Bunny Charm', 100, 20.00, 'Bunni Charms'),
(3, 'Totoro Phone/Key or Bag Charm', 30, 10.00, 'Phone Strap / Bag Charms'),
(4, 'Sanrio Phone/Key or Bag Charm', 27, 10.00, 'Phone Strap / Bag Charms');

-- --------------------------------------------------------

--
-- Table structure for table `orderhistory`
--

CREATE TABLE `orderhistory` (
  `id` int(11) NOT NULL,
  `productname` varchar(100) NOT NULL,
  `qty` int(50) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `customername` varchar(100) NOT NULL,
  `datecompleted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderhistory`
--

INSERT INTO `orderhistory` (`id`, `productname`, `qty`, `price`, `category`, `customername`, `datecompleted`) VALUES
(12, 'Stickers', 20, 235.34, 'Deco Stickers', 'Allen', '2024-10-18 14:26:51'),
(13, 'Controller', 23, 32.00, 'General Goods', 'Allen', '2024-10-18 14:27:15'),
(14, 'Clay', 23, 225.00, 'General Goods', 'Allen', '2024-10-18 14:30:23'),
(15, 'Bag', 2, 235.00, 'General Goods', 'Allen', '2024-10-18 14:30:24'),
(16, 'Clay3', 123, 123.00, 'General Goods', 'Joshua', '2024-10-18 14:31:03'),
(17, 'Clay2', 123, 123.00, 'General Goods', 'Allen', '2024-10-19 09:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `productorder`
--

CREATE TABLE `productorder` (
  `id` int(11) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `qty` int(100) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `category` varchar(50) NOT NULL,
  `customername` varchar(100) NOT NULL,
  `dateadded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productorder`
--

INSERT INTO `productorder` (`id`, `productname`, `qty`, `price`, `category`, `customername`, `dateadded`) VALUES
(1, 'Sanrio Phone/Key or Bag Charm', 3, 10.00, 'Bunni Charms', 'Allen', '2024-10-20 14:21:41');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `useremail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `username`, `userpassword`, `useremail`) VALUES
(1, 'admin', '$2y$10$qHIEEuTx2E8xfLM7LN8YYOIdSiheOCJNnzhzOwhw3/mSYg6zZG4Hy', 'admin@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addeditem`
--
ALTER TABLE `addeditem`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `addeditem`
--
ALTER TABLE `addeditem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deleteditem`
--
ALTER TABLE `deleteditem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orderhistory`
--
ALTER TABLE `orderhistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `productorder`
--
ALTER TABLE `productorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
