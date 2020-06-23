-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 23, 2020 at 07:00 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logreg`
--

-- --------------------------------------------------------

--
-- Table structure for table `recovery`
--

CREATE TABLE `recovery` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `recovery`
--

INSERT INTO `recovery` (`id`, `user_id`, `code`, `status`, `createdAt`) VALUES
(1, 11, '61a18d79f816f2f8849592ce6', '0', '2020-06-16 23:17:02'),
(2, 11, '4a323b0d06fbc5670573c55ab', '0', '2020-06-18 10:47:20'),
(3, 11, 'efe9d7efe23f7b51b36a1423c', '0', '2020-06-18 11:11:45'),
(4, 11, '974299e7ba65114dfa44a7622', '0', '2020-06-18 19:44:30'),
(6, 11, '46c1359c6151406d4fe015bfe', '1', '2020-06-18 23:06:38'),
(7, 11, 'b4d34a970a20a604c79324a48', '1', '2020-06-19 20:40:24'),
(8, 11, '2335019006b0b21833d070741', '1', '2020-06-19 20:49:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `joined` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `birthdate` datetime NOT NULL,
  `gender` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `username`, `firstName`, `lastName`, `phone`, `joined`, `birthdate`, `gender`) VALUES
(11, 'sazzadmanxy@gmail.com', '$2y$10$oOoPvY4GemJ4ouYWe871ZO5rosegBx1uFjcQiubmv8NvVhpd4xTpW', 'don', 'Mr.', 'test', '8801516177230', '2020-06-14 19:58:40', '1994-09-15 00:00:00', 'male'),
(21, 'big.benz@yahoo.com', '$2y$10$b7i4NjJjZCoKPbr9JD6FyeLuFmteQSaVjXm4w1Xe1WCJXo2remZUy', 'jap', 'spartakus', 'theGladiator', '8801616177230', '2020-06-22 19:48:20', '1985-07-14 00:00:00', 'male');

-- --------------------------------------------------------

--
-- Table structure for table `verification`
--

CREATE TABLE `verification` (
  `user_id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `verification`
--

INSERT INTO `verification` (`user_id`, `code`, `status`, `createdAt`) VALUES
(8, '0', '0', '2020-06-11 19:40:35'),
(8, '0', '0', '2020-06-11 20:06:56'),
(8, '0', '0', '2020-06-12 19:51:06'),
(10, '0', '0', '2020-06-13 23:36:47'),
(11, '0', '0', '2020-06-14 20:30:36'),
(11, '0', '0', '2020-06-14 22:21:37'),
(11, '0', '0', '2020-06-15 21:14:29'),
(11, '8E7C80', '1', '2020-06-15 21:28:03'),
(21, 'cc321f1baeb7989d5b661c01b', '1', '2020-06-22 19:48:44'),
(22, 'b3e42dc9e75de2ce177409428', '0', '2020-06-22 22:08:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recovery`
--
ALTER TABLE `recovery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recovery`
--
ALTER TABLE `recovery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
