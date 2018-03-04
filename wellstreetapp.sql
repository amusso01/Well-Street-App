-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2018 at 12:33 PM
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
(60, 'john', 'rambo', 'f', 'eandram@hotmail.it', '2018-01-30', 'sn040497b', '2018-02-27', 'e147pn', 'flat 3, caledonia house, 64 salmon lane, , , london,', '07478821689', 6.5, 'foh', '', 25, 74),
(62, 'luke', 'skywalker', 'm', 'eandram@hotmail.it', '2018-02-06', 'sn040497b', '2018-01-31', 'n154ax', '54 tynemouth road, , , , , london,', '07478821689', 6.5, 'boh', '', 15, 77),
(63, 'darth', 'varder', 'm', 'eandram@hotmail.it', '2018-02-15', 'sn040497b', '2018-02-07', 'n154ax', '', '07478821689', 48.5, 'boh', 'chef de partie', 15, 78),
(65, 'cristoforo', 'colombo', 'm', 'eandram@hotmail.it', '2018-01-30', 'sn040497b', '2018-02-07', 'n154ax', '', '07478821689', 6.5, 'foh', '', 12, 80),
(66, 'andrea', 'musso', 'm', 'eandram@hotmail.it', '2018-03-12', 'sn040497b', '2018-03-04', 'n154ax', '54 tynemouth road, , , , , london,', '07478821689', 12.5, 'boh', 'chef de partie', 28, 81);

-- --------------------------------------------------------

--
-- Table structure for table `file_uploaded`
--

CREATE TABLE `file_uploaded` (
  `id_info` int(11) NOT NULL,
  `file_name` varchar(45) NOT NULL,
  `file_info` varchar(155) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `file_uploaded`
--

INSERT INTO `file_uploaded` (`id_info`, `file_name`, `file_info`) VALUES
(64, 'Andrea Musso.pdf', NULL),
(61, 'Andrea Musso CV.docx', NULL),
(62, 'Andrea Musso.pdf', 'Curriculum vitae andrea musso');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payslip`
--

INSERT INTO `payslip` (`payslip_id`, `file_name`, `month`, `employee_id`, `year`) VALUES
(1, 'Andrea Musso.pdf', 1, 60, 2018),
(2, 'AM.png', 1, 60, 2018),
(3, 'AM.png', 1, 60, 2018),
(4, 'AM.png', 1, 60, 2018),
(5, 'AM.png', 1, 60, 2018),
(6, 'AM.png', 1, 60, 2018),
(7, 'AM.png', 1, 60, 2018),
(8, 'AM.png', 1, 60, 2018),
(9, 'AM.png', 1, 60, 2018),
(10, 'AM.png', 1, 60, 2018),
(11, 'AM.png', 1, 60, 2018),
(12, 'AM.png', 1, 60, 2018),
(13, 'AM.png', 1, 60, 2018),
(14, 'AM.png', 1, 60, 2018),
(15, 'AM.png', 1, 60, 2018),
(16, 'AM.png', 1, 60, 2018),
(17, 'AM.png', 1, 60, 2018),
(18, 'AM.png', 1, 60, 2018),
(19, 'AM.png', 1, 60, 2018),
(20, 'AM.png', 1, 60, 2018),
(21, 'AM.png', 1, 60, 2018),
(22, 'AM.png', 1, 60, 2018),
(23, 'AM.png', 1, 60, 2018),
(24, 'AM.png', 4, 60, 2018),
(25, 'Andrea Musso.pdf', 12, 60, 2018),
(26, 'AM.png', 12, 60, 2018),
(27, 'AM.png', 1, 60, 2018),
(28, 'Andrea Musso.pdf', 1, 62, 2018),
(29, 'CvI.docx', 1, 65, 2018),
(30, 'Andrea Musso.pdf', 7, 65, 2018),
(31, 'Andrea Musso.pdf', 6, 60, 2018),
(32, 'CvI.docx', 1, 65, 2018),
(33, 'Andrea Musso.pdf', 12, 65, 2018),
(34, 'Andrea Musso.pdf', 5, 65, 2018),
(35, 'Andrea Musso.pdf', 10, 65, 2018),
(36, 'AM.png', 8, 65, 2018),
(37, 'AM.png', 1, 63, 2018),
(38, 'Andrea Musso.pdf', 1, 66, 2018);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_rota`
--

CREATE TABLE `schedule_rota` (
  `shift_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule_rota`
--

INSERT INTO `schedule_rota` (`shift_id`, `employee_id`, `date`) VALUES
(5, 60, '2018-03-05'),
(3, 60, '2018-03-06'),
(4, 60, '2018-03-07'),
(5, 60, '2018-03-08'),
(1, 60, '2018-03-09'),
(1, 60, '2018-03-10'),
(2, 60, '2018-03-11'),
(4, 65, '2018-03-05'),
(5, 65, '2018-03-06'),
(5, 65, '2018-03-07'),
(4, 65, '2018-03-08'),
(2, 65, '2018-03-09'),
(2, 65, '2018-03-10'),
(1, 65, '2018-03-11'),
(3, 62, '2018-03-05'),
(5, 62, '2018-03-06'),
(5, 62, '2018-03-07'),
(3, 62, '2018-03-08'),
(3, 62, '2018-03-09'),
(3, 62, '2018-03-10'),
(5, 62, '2018-03-11'),
(5, 63, '2018-03-05'),
(3, 63, '2018-03-06'),
(5, 63, '2018-03-07'),
(5, 63, '2018-03-08'),
(5, 63, '2018-03-09'),
(4, 63, '2018-03-10'),
(5, 63, '2018-03-11'),
(3, 60, '2018-03-12'),
(5, 60, '2018-03-13'),
(5, 60, '2018-03-14'),
(5, 60, '2018-03-15'),
(5, 60, '2018-03-16'),
(5, 60, '2018-03-17'),
(5, 60, '2018-03-18'),
(5, 65, '2018-03-12'),
(5, 65, '2018-03-13'),
(5, 65, '2018-03-14'),
(3, 65, '2018-03-15'),
(5, 65, '2018-03-16'),
(5, 65, '2018-03-17'),
(5, 65, '2018-03-18'),
(5, 62, '2018-03-12'),
(5, 62, '2018-03-13'),
(5, 62, '2018-03-14'),
(5, 62, '2018-03-15'),
(5, 62, '2018-03-16'),
(5, 62, '2018-03-17'),
(5, 62, '2018-03-18'),
(3, 63, '2018-03-12'),
(5, 63, '2018-03-13'),
(5, 63, '2018-03-14'),
(5, 63, '2018-03-15'),
(5, 63, '2018-03-16'),
(5, 63, '2018-03-17'),
(5, 63, '2018-03-18');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
(74, 'eandram12', '$2y$10$447d/JAzfjKiMeDaLH4l6eyfIWvS6mHDrkE0.55u.yRI8v6s6nJeC', '0'),
(77, 'komander33', '$2y$10$lXwPcvrCfrZPwS8BKEfPiORfPsQq73qiPRWeLgpSPJzk4U1SZfHAa', '0'),
(78, 'golpe2', '$2y$10$3d/iM5gwUqqV2r6sGOVSyuKdTSW6M4j9q9AYruS7LEzioor0b.Q0a', '0'),
(80, 'dorian55', '$2y$10$y5Yfn0iqNUhx/JCxSexs4uv6ADolHmVyrPzy.RFoOoxMOUg2BMqYm', '0'),
(81, 'users1', '$2y$10$cjb14lrNRLKg2u9PApv0ne/3aqKvlUuqRxfJ.WHOzMP1buyOPEdXK', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id_employee`),
  ADD UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  ADD KEY `user_id_idx` (`user_id`);

--
-- Indexes for table `file_uploaded`
--
ALTER TABLE `file_uploaded`
  ADD PRIMARY KEY (`id_info`);

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
  MODIFY `id_employee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `file_uploaded`
--
ALTER TABLE `file_uploaded`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `payslip`
--
ALTER TABLE `payslip`
  MODIFY `payslip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id_shift` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
