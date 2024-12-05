-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 11:15 PM
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
-- Database: `osint_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ids`
--

CREATE TABLE `ids` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `access_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ids`
--

INSERT INTO `ids` (`id`, `user`, `access_id`) VALUES
(2, 'Administrator', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `manager_ids`
--

CREATE TABLE `manager_ids` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `access_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager_ids`
--

INSERT INTO `manager_ids` (`id`, `user`, `access_id`) VALUES
(1, 'adminsitrator', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `osints`
--

CREATE TABLE `osints` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `osint` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `osints`
--

INSERT INTO `osints` (`id`, `title`, `osint`, `created_at`) VALUES

-- --------------------------------------------------------

--
-- Table structure for table `staff_chat`
--

CREATE TABLE `staff_chat` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ids`
--
ALTER TABLE `ids`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `access_id` (`access_id`);

--
-- Indexes for table `manager_ids`
--
ALTER TABLE `manager_ids`
  ADD PRIMARY KEY (`id`,`user`,`access_id`);

--
-- Indexes for table `osints`
--
ALTER TABLE `osints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_chat`
--
ALTER TABLE `staff_chat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ids`
--
ALTER TABLE `ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `osints`
--
ALTER TABLE `osints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `staff_chat`
--
ALTER TABLE `staff_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
