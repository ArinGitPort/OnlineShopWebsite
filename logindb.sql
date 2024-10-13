-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 07:53 PM
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
(18, 'cfd', 2, 3, '2024-10-13 15:43:45');

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
(15, 'rfg', '2024-10-11 18:08:40');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `productname` varchar(80) NOT NULL,
  `qty` int(255) NOT NULL,
  `price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `productname`, `qty`, `price`) VALUES
(16, 'asd', 213, 2),
(17, 'gfdf', 2, 21),
(18, 'cfd', 2, 3);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
