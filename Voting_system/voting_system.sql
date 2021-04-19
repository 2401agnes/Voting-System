-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2021 at 07:41 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voting_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `position_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `user_id`, `position_id`) VALUES
(2, 13, 4),
(4, 12, 4),
(5, 15, 6),
(6, 21, 4),
(7, 18, 4),
(8, 15, 4),
(10, 19, 6);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(5) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `name`) VALUES
(4, 'Chairperson'),
(6, 'Secretary');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `national_id` int(6) NOT NULL,
  `names` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(20) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `locality` varchar(50) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `national_id`, `names`, `password`, `email`, `phone_no`, `locality`, `photo`, `admin`) VALUES
(13, 36371524, 'Chastity Davis', '$2y$10$G9VKBIMzJX15QhmS/SOCD.byCal5r5intFDUxgxatCxfTMBbyFXiK', 'vuba@mailinator.com', ' +1 (161) 391-5', 'Sit sequi sit volu', 'uploads/7103395_download (2).jpg', 0),
(14, 99, 'Shay Gay', '$2y$10$M6aKqQFAm3qC6.3connGDeU.p88ElltkNkJKzUEGNoRAXEKifLOUy', 'lofumi@mailinator.co', ' +1 (153) 704-2', 'Ea aut id dolorem do', 'uploads/8180782_download.jpg', 0),
(15, 22, 'Reed Blevins', '$2y$10$3Q8RVxh86kcIo31kn0hmbuE8WKmzGhnGR.SBcYRL6EHjiMeE/9J0S', 'subu@mailinator.com', ' +1 (408) 296-1', 'Ducimus enim conseq', 'uploads/1934123_download (1).jpg', 0),
(17, 363715240, 'Makokha Tunai', '$2y$10$gYEOU2gri/SEG6OPezEXjeFD9OEP9fb42H4xNFdcIIITybJ/aT03a', 'tuna@gmail.com', ' 0790026441', 'Kakamega', 'uploads/8060043_download (2).jpg', 1),
(18, 92, 'Mechelle Byers', '$2y$10$liiuOuQLJXswPydCEmn35.nNghQ9XcfVPSsLkXfHHnm7MG0c7DyaC', 'xigohacilo@mailinato', ' +1 (194) 466-7', 'Dignissimos quos qui', 'uploads/3847529_download.jpg', 0),
(19, 32, 'Alexandra Leonard', '$2y$10$GVrE6GEjSPl4GQiUtxjSfe7qsKsYaPBc/Tl7Y5yTji7TuQonXxor.', 'noqicama@mailinator.', ' +1 (688) 196-7', 'Sunt cupiditate dolo', 'uploads/2994962_download (1).jpg', 0),
(20, 33, 'Thane Christian', '$2y$10$uukSKznBOfGG8ghRXb674.t31bnb9O4iHnEmnJWF4vQhdnoWAhXrW', 'wiheqoca@mailinator.', ' +1 (329) 756-7', 'Modi sed ea minima e', 'uploads/7251212_download (1).jpg', 0),
(21, 61, 'Jakeem Glover', '$2y$10$MnhKwb/B25X.C.zZh6C08u4JkvzJHs4xFkX6uiyOlJY9o2EqbO9Ii', 'zavehacyc@mailinator', ' +1 (638) 812-5', 'Laboriosam odio ess', 'uploads/6190039_download (2).jpg', 0),
(23, 64, 'Harper Garcia', '$2y$10$fswcGamEyCEbmTOwGWKjlOPn9JSCClzCmKdIRIMMwUGFqNa4MlkFy', 'qeju@mailinator.com', ' +1 (238) 719-3', 'Quis voluptates veli', 'uploads/6341065_download (1).jpg', 0),
(25, 90, 'Xaviera Bowen', '$2y$10$LkuzK1/1CD8pXGSo4tFrku4py2uKpCCkGGQurVIGQtoJKWzjpPGXi', 'quwe@mailinator.com', ' +1 (422) 321-1', 'Sapiente non commodo', 'uploads/4508232_download (1).jpg', 0),
(26, 12, 'Emmanuel', '$2y$10$iiq5r7uQgj2xsyteeiELZOkdlycberf09ZfoJ3aNoSU7LdX94CbFS', 'em@gmail.com', ' 089998854345', 'Angorom', 'uploads/9306591_WIN_20210407_13_25_53_Pro.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(5) NOT NULL,
  `candidate_id` int(5) NOT NULL,
  `position_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `vote_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `candidate_id`, `position_id`, `user_id`, `vote_date`) VALUES
(6, 2, 4, 18, '2021-04-15 11:57:46'),
(7, 6, 4, 18, '2021-04-15 11:58:51'),
(8, 6, 4, 17, '2021-04-15 02:25:04'),
(9, 7, 4, 18, '2021-04-15 04:57:34'),
(10, 2, 4, 18, '2021-04-15 04:59:02'),
(12, 2, 4, 18, '2021-04-15 05:06:48'),
(13, 7, 4, 18, '2021-04-15 05:08:02'),
(14, 6, 4, 18, '2021-04-15 05:09:03'),
(15, 5, 6, 18, '2021-04-15 05:21:11'),
(16, 2, 4, 18, '2021-04-15 09:17:00'),
(17, 6, 4, 18, '2021-04-15 09:17:06'),
(18, 2, 4, 18, '2021-04-15 09:21:56'),
(19, 2, 4, 18, '2021-04-15 09:22:01'),
(20, 2, 4, 18, '2021-04-15 10:06:44'),
(21, 7, 4, 18, '2021-04-15 10:07:01'),
(22, 5, 6, 18, '2021-04-15 10:13:45'),
(23, 7, 4, 18, '2021-04-15 10:13:51'),
(24, 8, 4, 18, '2021-04-15 10:13:57'),
(26, 10, 6, 18, '2021-04-17 08:56:08'),
(30, 10, 6, 17, '2021-04-17 11:09:44'),
(31, 2, 4, 18, '2021-04-17 11:48:28'),
(32, 6, 4, 18, '2021-04-17 11:48:33'),
(33, 6, 4, 18, '2021-04-17 11:55:26'),
(34, 7, 4, 18, '2021-04-17 11:55:33'),
(35, 7, 4, 18, '2021-04-17 11:57:23'),
(36, 8, 4, 18, '2021-04-17 11:58:08'),
(37, 8, 4, 18, '2021-04-17 11:58:20'),
(38, 2, 4, 18, '2021-04-17 12:09:34'),
(39, 6, 4, 18, '2021-04-17 12:09:39'),
(40, 2, 4, 18, '2021-04-17 12:11:35'),
(41, 8, 4, 18, '2021-04-17 12:11:42'),
(42, 2, 4, 18, '2021-04-17 12:13:45'),
(43, 2, 4, 17, '2021-04-17 12:18:19'),
(44, 6, 4, 17, '2021-04-17 12:18:25'),
(45, 2, 4, 18, '2021-04-17 12:18:33'),
(46, 2, 4, 18, '2021-04-17 12:24:32'),
(47, 8, 4, 18, '2021-04-17 12:25:24'),
(48, 2, 4, 18, '2021-04-17 12:25:29'),
(49, 2, 4, 18, '2021-04-17 03:25:57'),
(50, 6, 4, 18, '2021-04-17 03:26:05'),
(51, 6, 4, 18, '2021-04-17 03:26:30'),
(52, 2, 4, 18, '2021-04-17 03:27:03'),
(53, 2, 4, 18, '2021-04-17 03:30:18'),
(54, 7, 4, 18, '2021-04-17 03:34:34'),
(55, 5, 6, 17, '2021-04-17 08:35:40'),
(56, 5, 6, 18, '2021-04-18 07:14:56'),
(57, 6, 4, 18, '2021-04-18 07:27:02'),
(58, 2, 4, 18, '2021-04-18 07:29:15'),
(59, 6, 4, 18, '2021-04-18 07:29:19'),
(60, 2, 4, 18, '2021-04-18 07:32:20'),
(61, 7, 4, 18, '2021-04-18 07:32:26'),
(62, 6, 4, 18, '2021-04-18 07:32:46'),
(63, 6, 4, 18, '2021-04-18 07:33:34'),
(64, 6, 4, 18, '2021-04-18 07:37:14'),
(65, 6, 4, 18, '2021-04-19 07:12:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `national_id` (`national_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_id` (`candidate_id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`),
  ADD CONSTRAINT `votes_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
