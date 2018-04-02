-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 02, 2018 at 01:58 PM
-- Server version: 5.7.19
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id_employee` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id_employee`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id_employee`, `name`, `surname`, `gender`, `email`, `starting_date`, `nin`, `date_of_birthday`, `post_code`, `address`, `phone_number`, `payrate`, `department`, `position`, `holiday_allowance`, `user_id`) VALUES
(1, 'andrea', 'musso', 'm', 'eandram@hotmail.it', '2018-01-01', 'sn040497b', '1983-02-02', 'n154ax', NULL, '07478821689', 8.5, 'boh', NULL, 23, 1),
(66, 'andrea', 'musso', 'm', 'eandram@hotmail.it', '2018-03-12', 'sn040497b', '2018-03-04', 'n154ax', '54 tynemouth road, , , , , london,', '07478821689', 12.5, 'boh', 'chef de partie', 28, 81);

-- --------------------------------------------------------

--
-- Table structure for table `file_uploaded`
--

DROP TABLE IF EXISTS `file_uploaded`;
CREATE TABLE IF NOT EXISTS `file_uploaded` (
  `id_info` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(45) NOT NULL,
  `file_info` varchar(155) DEFAULT NULL,
  PRIMARY KEY (`id_info`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `file_uploaded`
--

INSERT INTO `file_uploaded` (`id_info`, `file_name`, `file_info`) VALUES
(67, 'WRP Introduction.pdf', NULL),
(68, 'workflow.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payslip`
--

DROP TABLE IF EXISTS `payslip`;
CREATE TABLE IF NOT EXISTS `payslip` (
  `payslip_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(45) NOT NULL,
  `month` tinyint(12) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  PRIMARY KEY (`payslip_id`),
  KEY `employee_id_idx` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payslip`
--

INSERT INTO `payslip` (`payslip_id`, `file_name`, `month`, `employee_id`, `year`) VALUES
(38, 'Andrea Musso.pdf', 1, 66, 2018),
(39, 'city on river.jpg', 1, 66, 2018),
(40, 'silverymoon.jpg', 2, 66, 2018),
(44, 'logo.png', 7, 66, 2018),
(45, 'Capture2.PNG', 6, 66, 2018);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_rota`
--

DROP TABLE IF EXISTS `schedule_rota`;
CREATE TABLE IF NOT EXISTS `schedule_rota` (
  `shift_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  KEY `shift_id_idx` (`shift_id`),
  KEY `employee_id_idx` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule_rota`
--

INSERT INTO `schedule_rota` (`shift_id`, `employee_id`, `date`) VALUES
(3, 66, '2018-04-02'),
(1, 66, '2018-04-03'),
(5, 66, '2018-04-05'),
(4, 66, '2018-04-05'),
(2, 66, '2018-04-06'),
(5, 66, '2018-04-07'),
(2, 66, '2018-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

DROP TABLE IF EXISTS `shift`;
CREATE TABLE IF NOT EXISTS `shift` (
  `id_shift` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` time DEFAULT NULL,
  `finish_time` time DEFAULT NULL,
  `shift_length` int(11) DEFAULT NULL,
  `is_off` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_shift`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

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

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(150) NOT NULL,
  `adminaccess` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `username`, `password`, `adminaccess`) VALUES
(1, 'admin1', '$2y$10$Gs6MZ/eR0StXWyEJa8ZA9.9IyKhGI3Z6UxRLSFInw670wRJciHs0W', '1'),
(81, 'users1', '$2y$10$cjb14lrNRLKg2u9PApv0ne/3aqKvlUuqRxfJ.WHOzMP1buyOPEdXK', '0');

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
