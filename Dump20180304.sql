CREATE DATABASE  IF NOT EXISTS `wellstreetapp` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `wellstreetapp`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: wellstreetapp
-- ------------------------------------------------------
-- Server version	5.7.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
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
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'andrea','musso','m','eandram@hotmail.it','2018-01-01','sn040497b','1983-02-02','n154ax',NULL,'07478821689',8.5,'boh',NULL,23,1),(60,'john','rambo','f','eandram@hotmail.it','2018-01-30','sn040497b','2018-02-27','e147pn','flat 3, caledonia house, 64 salmon lane, , , london,','07478821689',6.5,'foh','',25,74),(62,'luke','skywalker','m','eandram@hotmail.it','2018-02-06','sn040497b','2018-01-31','n154ax','54 tynemouth road, , , , , london,','07478821689',6.5,'boh','',15,77),(63,'darth','varder','m','eandram@hotmail.it','2018-02-15','sn040497b','2018-02-07','n154ax','','07478821689',48.5,'boh','chef de partie',15,78),(65,'cristoforo','colombo','m','eandram@hotmail.it','2018-01-30','sn040497b','2018-02-07','n154ax','','07478821689',6.5,'foh','',12,80),(66,'andrea','musso','m','eandram@hotmail.it','2018-03-12','sn040497b','2018-03-04','n154ax','54 tynemouth road, , , , , london,','07478821689',12.5,'boh','chef de partie',28,81);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_uploaded`
--

DROP TABLE IF EXISTS `file_uploaded`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_uploaded` (
  `id_info` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(45) NOT NULL,
  `file_info` varchar(155) DEFAULT NULL,
  PRIMARY KEY (`id_info`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_uploaded`
--

LOCK TABLES `file_uploaded` WRITE;
/*!40000 ALTER TABLE `file_uploaded` DISABLE KEYS */;
INSERT INTO `file_uploaded` VALUES (64,'Andrea Musso.pdf',NULL),(61,'Andrea Musso CV.docx',NULL),(62,'Andrea Musso.pdf','Curriculum vitae andrea musso');
/*!40000 ALTER TABLE `file_uploaded` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payslip`
--

DROP TABLE IF EXISTS `payslip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payslip` (
  `payslip_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(45) NOT NULL,
  `month` tinyint(12) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  PRIMARY KEY (`payslip_id`),
  KEY `employee_id_idx` (`employee_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payslip`
--

LOCK TABLES `payslip` WRITE;
/*!40000 ALTER TABLE `payslip` DISABLE KEYS */;
INSERT INTO `payslip` VALUES (1,'Andrea Musso.pdf',1,60,2018),(2,'AM.png',1,60,2018),(3,'AM.png',1,60,2018),(4,'AM.png',1,60,2018),(5,'AM.png',1,60,2018),(6,'AM.png',1,60,2018),(7,'AM.png',1,60,2018),(8,'AM.png',1,60,2018),(9,'AM.png',1,60,2018),(10,'AM.png',1,60,2018),(11,'AM.png',1,60,2018),(12,'AM.png',1,60,2018),(13,'AM.png',1,60,2018),(14,'AM.png',1,60,2018),(15,'AM.png',1,60,2018),(16,'AM.png',1,60,2018),(17,'AM.png',1,60,2018),(18,'AM.png',1,60,2018),(19,'AM.png',1,60,2018),(20,'AM.png',1,60,2018),(21,'AM.png',1,60,2018),(22,'AM.png',1,60,2018),(23,'AM.png',1,60,2018),(24,'AM.png',4,60,2018),(25,'Andrea Musso.pdf',12,60,2018),(26,'AM.png',12,60,2018),(27,'AM.png',1,60,2018),(28,'Andrea Musso.pdf',1,62,2018),(29,'CvI.docx',1,65,2018),(30,'Andrea Musso.pdf',7,65,2018),(31,'Andrea Musso.pdf',6,60,2018),(32,'CvI.docx',1,65,2018),(33,'Andrea Musso.pdf',12,65,2018),(34,'Andrea Musso.pdf',5,65,2018),(35,'Andrea Musso.pdf',10,65,2018),(36,'AM.png',8,65,2018),(37,'AM.png',1,63,2018),(38,'Andrea Musso.pdf',1,66,2018);
/*!40000 ALTER TABLE `payslip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_rota`
--

DROP TABLE IF EXISTS `schedule_rota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_rota` (
  `shift_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  KEY `shift_id_idx` (`shift_id`),
  KEY `employee_id_idx` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_rota`
--

LOCK TABLES `schedule_rota` WRITE;
/*!40000 ALTER TABLE `schedule_rota` DISABLE KEYS */;
INSERT INTO `schedule_rota` VALUES (5,60,'2018-03-05'),(3,60,'2018-03-06'),(4,60,'2018-03-07'),(5,60,'2018-03-08'),(1,60,'2018-03-09'),(1,60,'2018-03-10'),(2,60,'2018-03-11'),(4,65,'2018-03-05'),(5,65,'2018-03-06'),(5,65,'2018-03-07'),(4,65,'2018-03-08'),(2,65,'2018-03-09'),(2,65,'2018-03-10'),(1,65,'2018-03-11'),(3,62,'2018-03-05'),(5,62,'2018-03-06'),(5,62,'2018-03-07'),(3,62,'2018-03-08'),(3,62,'2018-03-09'),(3,62,'2018-03-10'),(5,62,'2018-03-11'),(5,63,'2018-03-05'),(3,63,'2018-03-06'),(5,63,'2018-03-07'),(5,63,'2018-03-08'),(5,63,'2018-03-09'),(4,63,'2018-03-10'),(5,63,'2018-03-11'),(3,60,'2018-03-12'),(5,60,'2018-03-13'),(5,60,'2018-03-14'),(5,60,'2018-03-15'),(5,60,'2018-03-16'),(5,60,'2018-03-17'),(5,60,'2018-03-18'),(5,65,'2018-03-12'),(5,65,'2018-03-13'),(5,65,'2018-03-14'),(3,65,'2018-03-15'),(5,65,'2018-03-16'),(5,65,'2018-03-17'),(5,65,'2018-03-18'),(5,62,'2018-03-12'),(5,62,'2018-03-13'),(5,62,'2018-03-14'),(5,62,'2018-03-15'),(5,62,'2018-03-16'),(5,62,'2018-03-17'),(5,62,'2018-03-18'),(3,63,'2018-03-12'),(5,63,'2018-03-13'),(5,63,'2018-03-14'),(5,63,'2018-03-15'),(5,63,'2018-03-16'),(5,63,'2018-03-17'),(5,63,'2018-03-18');
/*!40000 ALTER TABLE `schedule_rota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shift`
--

DROP TABLE IF EXISTS `shift`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shift` (
  `id_shift` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` time DEFAULT NULL,
  `finish_time` time DEFAULT NULL,
  `shift_length` int(11) DEFAULT NULL,
  `is_off` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_shift`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shift`
--

LOCK TABLES `shift` WRITE;
/*!40000 ALTER TABLE `shift` DISABLE KEYS */;
INSERT INTO `shift` VALUES (1,'07:00:00','15:00:00',500,0),(2,'09:00:00','17:00:00',500,0),(3,'07:00:00','14:00:00',420,0),(4,'11:00:00','17:00:00',360,0),(5,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `shift` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(150) NOT NULL,
  `adminaccess` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin1','$2y$10$Gs6MZ/eR0StXWyEJa8ZA9.9IyKhGI3Z6UxRLSFInw670wRJciHs0W','1'),(74,'eandram12','$2y$10$447d/JAzfjKiMeDaLH4l6eyfIWvS6mHDrkE0.55u.yRI8v6s6nJeC','0'),(77,'komander33','$2y$10$lXwPcvrCfrZPwS8BKEfPiORfPsQq73qiPRWeLgpSPJzk4U1SZfHAa','0'),(78,'golpe2','$2y$10$3d/iM5gwUqqV2r6sGOVSyuKdTSW6M4j9q9AYruS7LEzioor0b.Q0a','0'),(80,'dorian55','$2y$10$y5Yfn0iqNUhx/JCxSexs4uv6ADolHmVyrPzy.RFoOoxMOUg2BMqYm','0'),(81,'users1','$2y$10$cjb14lrNRLKg2u9PApv0ne/3aqKvlUuqRxfJ.WHOzMP1buyOPEdXK','0');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-04 12:17:17
