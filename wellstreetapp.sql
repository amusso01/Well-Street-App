-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2018 at 05:24 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wellstreetapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id_employee` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `email` varchar(45) NOT NULL,
  `starting_date` date NOT NULL,
  `nin` varchar(45) NOT NULL,
  `date_of_birthday` date NOT NULL,
  `post_code` varchar(15) NOT NULL,
  `address` varchar(75) DEFAULT NULL,
  `phone_number` varchar(45) NOT NULL,
  `payrate` double NOT NULL,
  `department` enum('boh','foh') NOT NULL,
  `position` varchar(45) DEFAULT NULL,
  `holiday_allowance` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id_employee`, `name`, `surname`, `gender`, `email`, `starting_date`, `nin`, `date_of_birthday`, `post_code`, `address`, `phone_number`, `payrate`, `department`, `position`, `holiday_allowance`, `user_id`) VALUES
(1, 'andrea', 'musso', 'm', 'eandram@hotmail.it', '2018-01-01', 'sn040497b', '1983-02-02', 'n154ax', NULL, '07478821689', 8.5, 'boh', NULL, 23, 1),
(73, 'andrea', 'musso', 'm', 'eandram@hotmail.it', '2018-04-20', 'sn040497b', '1983-07-08', 'se59qw', 'flat 25, mirlees court, 50 coldharbour lane, , , london,', '07478821689', 12.5, 'foh', 'chef', 16, 88);

-- --------------------------------------------------------

--
-- Table structure for table `file_uploaded`
--

CREATE TABLE `file_uploaded` (
  `id_info` int(11) NOT NULL,
  `file_name` varchar(45) NOT NULL,
  `file_info` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_request`
--

CREATE TABLE `holiday_request` (
  `holiday_id` int(11) NOT NULL,
  `holiday_start` date NOT NULL,
  `holiday_end` date NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `holiday_approved` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payslip`
--

CREATE TABLE `payslip` (
  `payslip_id` int(11) NOT NULL,
  `file_name` varchar(45) NOT NULL,
  `month` tinyint(12) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_rota`
--

CREATE TABLE `schedule_rota` (
  `shift_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id_shift` int(11) NOT NULL,
  `start_time` time DEFAULT NULL,
  `finish_time` time DEFAULT NULL,
  `shift_length` int(11) DEFAULT NULL,
  `is_off` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id_shift`, `start_time`, `finish_time`, `shift_length`, `is_off`) VALUES
(1, '07:00:00', '15:00:00', 500, 0),
(2, '09:00:00', '17:00:00', 500, 0),
(3, '07:00:00', '14:00:00', 420, 0),
(4, '11:00:00', '17:00:00', 360, 0),
(5, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(150) NOT NULL,
  `adminaccess` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `username`, `password`, `adminaccess`) VALUES
(1, 'admin1', '$2y$10$Gs6MZ/eR0StXWyEJa8ZA9.9IyKhGI3Z6UxRLSFInw670wRJciHs0W', '1'),
(88, 'users1', '$2y$10$pITJguXXrqZHYRNf1w69jumaUPIwHH8.R/ZliHIH4/EumfVDMazk.', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id_employee`),
  ADD UNIQUE KEY `user_id_UNIQUE` (`user_id`);

--
-- Indexes for table `file_uploaded`
--
ALTER TABLE `file_uploaded`
  ADD PRIMARY KEY (`id_info`);

--
-- Indexes for table `holiday_request`
--
ALTER TABLE `holiday_request`
  ADD PRIMARY KEY (`holiday_id`),
  ADD KEY `employee_id_idx` (`employee_id`);

--
-- Indexes for table `payslip`
--
ALTER TABLE `payslip`
  ADD PRIMARY KEY (`payslip_id`),
  ADD KEY `employee_id_idx` (`employee_id`);

--
-- Indexes for table `schedule_rota`
--
ALTER TABLE `schedule_rota`
  ADD KEY `shift_id_idx` (`shift_id`),
  ADD KEY `employee_id_idx` (`employee_id`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id_shift`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id_employee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `file_uploaded`
--
ALTER TABLE `file_uploaded`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `holiday_request`
--
ALTER TABLE `holiday_request`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;
--
-- AUTO_INCREMENT for table `payslip`
--
ALTER TABLE `payslip`
  MODIFY `payslip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id_shift` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payslip`
--
ALTER TABLE `payslip`
  ADD CONSTRAINT `employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id_employee`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
