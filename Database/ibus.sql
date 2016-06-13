-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ibus
-- ------------------------------------------------------
-- Server version	5.6.24

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
-- Table structure for table `accomodations`
--

DROP TABLE IF EXISTS `accomodations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accomodations` (
  `accomodation_id` int(11) NOT NULL AUTO_INCREMENT,
  `accomodation_name` varchar(45) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `accomodation_route_id` int(11) NOT NULL,
  PRIMARY KEY (`accomodation_id`),
  KEY `fk_accomodations_route1_idx` (`accomodation_route_id`),
  CONSTRAINT `fk_accomodations_route1` FOREIGN KEY (`accomodation_route_id`) REFERENCES `route` (`route_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `bus_id` int(11) NOT NULL,
  `bus_timimg_id` int(11) NOT NULL,
  `employees_ct_reference` varchar(45) NOT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `fk_booking_busses1_idx` (`bus_id`),
  KEY `fk_booking_bus_timimg1_idx` (`bus_timimg_id`),
  KEY `fk_booking_employees1_idx` (`employees_ct_reference`),
  CONSTRAINT `fk_booking_bus_timimg1` FOREIGN KEY (`bus_timimg_id`) REFERENCES `bus_timing` (`bus_timimg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_booking_busses1` FOREIGN KEY (`bus_id`) REFERENCES `busses` (`bus_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_booking_employees1` FOREIGN KEY (`employees_ct_reference`) REFERENCES `employees` (`ct_reference`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bus_timing`
--

DROP TABLE IF EXISTS `bus_timing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bus_timing` (
  `bus_timimg_id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(45) DEFAULT NULL,
  `noofbusses` int(11) DEFAULT NULL,
  PRIMARY KEY (`bus_timimg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `busses`
--

DROP TABLE IF EXISTS `busses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `busses` (
  `bus_id` int(11) NOT NULL AUTO_INCREMENT,
  `no_of_seats` int(11) DEFAULT NULL,
  `bus_name` varchar(45) DEFAULT NULL,
  `route_id` int(11) NOT NULL,
  PRIMARY KEY (`bus_id`),
  KEY `fk_busses_route1_idx` (`route_id`),
  CONSTRAINT `fk_busses_route1` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `ct_reference` varchar(45) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `employee_name` varchar(45) DEFAULT NULL,
  `lg` varchar(45) DEFAULT NULL,
  `stream` varchar(45) DEFAULT NULL,
  `batch` varchar(45) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `accomodation_id` int(11) NOT NULL,
  `role` varchar(30) DEFAULT 'Employee',
  PRIMARY KEY (`ct_reference`),
  KEY `fk_employees_accomodations1_idx` (`accomodation_id`),
  CONSTRAINT `fk_employees_accomodations1` FOREIGN KEY (`accomodation_id`) REFERENCES `accomodations` (`accomodation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `route`
--

DROP TABLE IF EXISTS `route`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `route` (
  `route_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`route_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-26 19:09:31
