-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2022 at 11:28 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vaccine`
--
CREATE DATABASE IF NOT EXISTS `vaccine` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `vaccine`;

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id_consultation` bigint(20) UNSIGNED NOT NULL,
  `society_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('accepted','decline','pending') DEFAULT 'pending',
  `disease_history` text NOT NULL,
  `current_symptomps` text NOT NULL,
  `doctor_notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id_consultation`, `society_id`, `doctor_id`, `status`, `disease_history`, `current_symptomps`, `doctor_notes`) VALUES
(3, 2, NULL, 'pending', 'No I haven\'t', 'No', ''),
(4, 2, NULL, 'pending', 'No I haven\'t', 'No', ''),
(5, 2, NULL, 'pending', 'No I haven\'t', 'No', ''),
(6, 2, NULL, 'pending', 'kepala pusing\r\n', 'No', '');

-- --------------------------------------------------------

--
-- Table structure for table `medicals`
--

CREATE TABLE `medicals` (
  `id_medicals` bigint(20) UNSIGNED NOT NULL,
  `spot_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('officer','doctor') NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medicals`
--

INSERT INTO `medicals` (`id_medicals`, `spot_id`, `user_id`, `role`, `name`) VALUES
(1, 1, 1, 'doctor', 'doody ferdiansyah');

-- --------------------------------------------------------

--
-- Table structure for table `regionals`
--

CREATE TABLE `regionals` (
  `id_regionals` bigint(20) UNSIGNED NOT NULL,
  `province` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `regionals`
--

INSERT INTO `regionals` (`id_regionals`, `province`, `district`) VALUES
(1, 'Jawa Timur', 'malang selatan');

-- --------------------------------------------------------

--
-- Table structure for table `societies`
--

CREATE TABLE `societies` (
  `id_societies` bigint(20) UNSIGNED NOT NULL,
  `id_card_number` char(8) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `born_date` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `address` text DEFAULT NULL,
  `regional_id` bigint(20) UNSIGNED NOT NULL,
  `login_tokens` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `societies`
--

INSERT INTO `societies` (`id_societies`, `id_card_number`, `password`, `name`, `born_date`, `gender`, `address`, `regional_id`, `login_tokens`) VALUES
(2, '001', '$2y$10$es.Morszr88m4OAtW6.Av.JWG6GudZ29.8.yTJFFiPIDOz5wAfNh.', 'fahrudin', '2003-10-18', 'male', 'banjarejo pagelaran malang', 1, 'dc5c7986daef50c1e02ab09b442ee34f');

-- --------------------------------------------------------

--
-- Table structure for table `spots`
--

CREATE TABLE `spots` (
  `id_spots` bigint(20) UNSIGNED NOT NULL,
  `regional_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `serve` tinyint(4) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spots`
--

INSERT INTO `spots` (`id_spots`, `regional_id`, `name`, `address`, `serve`, `capacity`) VALUES
(1, 1, 'Rumah Sakit islam', 'gondanglegi', 3, 15);

-- --------------------------------------------------------

--
-- Table structure for table `spot_vaccines`
--

CREATE TABLE `spot_vaccines` (
  `id_spot_vaccines` bigint(20) UNSIGNED NOT NULL,
  `spot_id` bigint(20) UNSIGNED NOT NULL,
  `vaccine_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spot_vaccines`
--

INSERT INTO `spot_vaccines` (`id_spot_vaccines`, `spot_id`, `vaccine_id`) VALUES
(1, 1, 5),
(2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`) VALUES
(1, 'doddy ferdiansyah', 'doddy ferdiansyah');

-- --------------------------------------------------------

--
-- Table structure for table `vaccinations`
--

CREATE TABLE `vaccinations` (
  `id_vaccinations` bigint(20) UNSIGNED NOT NULL,
  `dose` tinyint(4) NOT NULL,
  `date` date DEFAULT NULL,
  `society_id` bigint(20) UNSIGNED DEFAULT NULL,
  `spot_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vaccine_id` bigint(20) UNSIGNED DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `officer_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccinations`
--

INSERT INTO `vaccinations` (`id_vaccinations`, `dose`, `date`, `society_id`, `spot_id`, `vaccine_id`, `doctor_id`, `officer_id`) VALUES
(1, 0, '2020-12-20', 2, 1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vaccines`
--

CREATE TABLE `vaccines` (
  `id_vaccines` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccines`
--

INSERT INTO `vaccines` (`id_vaccines`, `name`) VALUES
(1, 'Sinovac'),
(2, 'AstraZeneca'),
(3, 'Moderna'),
(4, 'Pfizer'),
(5, 'Sinnopharm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id_consultation`),
  ADD KEY `society_id` (`society_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `medicals`
--
ALTER TABLE `medicals`
  ADD PRIMARY KEY (`id_medicals`),
  ADD KEY `spot_id` (`spot_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `regionals`
--
ALTER TABLE `regionals`
  ADD PRIMARY KEY (`id_regionals`);

--
-- Indexes for table `societies`
--
ALTER TABLE `societies`
  ADD PRIMARY KEY (`id_societies`,`id_card_number`),
  ADD KEY `regional_id` (`regional_id`);

--
-- Indexes for table `spots`
--
ALTER TABLE `spots`
  ADD PRIMARY KEY (`id_spots`),
  ADD KEY `regional_id` (`regional_id`),
  ADD KEY `address` (`address`(768)),
  ADD KEY `serve` (`serve`),
  ADD KEY `capacity` (`capacity`);

--
-- Indexes for table `spot_vaccines`
--
ALTER TABLE `spot_vaccines`
  ADD PRIMARY KEY (`id_spot_vaccines`),
  ADD KEY `spot_id` (`spot_id`),
  ADD KEY `vaccine_id` (`vaccine_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- Indexes for table `vaccinations`
--
ALTER TABLE `vaccinations`
  ADD PRIMARY KEY (`id_vaccinations`),
  ADD KEY `society_id` (`society_id`),
  ADD KEY `spot_id` (`spot_id`),
  ADD KEY `vaccine_id` (`vaccine_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `officer_id` (`officer_id`);

--
-- Indexes for table `vaccines`
--
ALTER TABLE `vaccines`
  ADD PRIMARY KEY (`id_vaccines`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id_consultation` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `medicals`
--
ALTER TABLE `medicals`
  MODIFY `id_medicals` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `regionals`
--
ALTER TABLE `regionals`
  MODIFY `id_regionals` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `societies`
--
ALTER TABLE `societies`
  MODIFY `id_societies` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `spots`
--
ALTER TABLE `spots`
  MODIFY `id_spots` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `spot_vaccines`
--
ALTER TABLE `spot_vaccines`
  MODIFY `id_spot_vaccines` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vaccinations`
--
ALTER TABLE `vaccinations`
  MODIFY `id_vaccinations` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vaccines`
--
ALTER TABLE `vaccines`
  MODIFY `id_vaccines` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_ibfk_1` FOREIGN KEY (`society_id`) REFERENCES `societies` (`id_societies`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consultations_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `medicals` (`id_medicals`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicals`
--
ALTER TABLE `medicals`
  ADD CONSTRAINT `medicals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicals_ibfk_2` FOREIGN KEY (`spot_id`) REFERENCES `spots` (`id_spots`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `societies`
--
ALTER TABLE `societies`
  ADD CONSTRAINT `societies_ibfk_1` FOREIGN KEY (`regional_id`) REFERENCES `regionals` (`id_regionals`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `spots`
--
ALTER TABLE `spots`
  ADD CONSTRAINT `spots_ibfk_1` FOREIGN KEY (`regional_id`) REFERENCES `regionals` (`id_regionals`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `spot_vaccines`
--
ALTER TABLE `spot_vaccines`
  ADD CONSTRAINT `spot_vaccines_ibfk_1` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccines` (`id_vaccines`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spot_vaccines_ibfk_2` FOREIGN KEY (`spot_id`) REFERENCES `spots` (`id_spots`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vaccinations`
--
ALTER TABLE `vaccinations`
  ADD CONSTRAINT `vaccinations_ibfk_1` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccines` (`id_vaccines`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vaccinations_ibfk_2` FOREIGN KEY (`society_id`) REFERENCES `societies` (`id_societies`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vaccinations_ibfk_3` FOREIGN KEY (`doctor_id`) REFERENCES `medicals` (`id_medicals`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vaccinations_ibfk_4` FOREIGN KEY (`officer_id`) REFERENCES `medicals` (`id_medicals`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vaccinations_ibfk_5` FOREIGN KEY (`spot_id`) REFERENCES `spots` (`id_spots`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
