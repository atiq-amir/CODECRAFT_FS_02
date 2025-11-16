-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2025 at 12:09 AM
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
-- Database: `hireup`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `pfp` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `phone`, `password`, `role`, `pfp`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '2147483647', '$2y$10$cpm8CLbz4WoVZQR.0KWm1OeBoPL6.5K9hYJ6UbL2TAL6LFsius14G', '', 'reviewer2.jpg', 2147483647),
(2, 'Admin', 'admin1@gmail.com', '2147483647', '$2y$10$Qa6H3OOgjERSgaZ3SlW7auGMFa2QQvvIoiAVF6io6ggokI7rgbdZK', '', 'reviewer1.jpg', 2147483647),
(4, 'Admin', 'admin2@gmail.com', '03471528724', '$2y$10$1xg51yxXpsrr4dDnZty98eEfkRzT4tbN5l9rJ7sltkzl8BQja8vcq', '', '', 2147483647),
(6, 'Admin', 'admin3@gmail.com', '03471528724', '$2y$10$5/ZKKqq3G5lJmhvTx9xxbuJCpYdwdzzl7Pd6qTAxMrtCkPSpke9Iy', '', '', 2147483647),
(10, 'Admin', 'admin4@gmail.com', '03471528724', '$2y$10$EhudgJG70u27Kcnhe5zhx.4ie5WVvvywnPVleAewce49xo9.wLvYm', 'admin', '', 2147483647);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
