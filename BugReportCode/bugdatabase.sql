-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Aug 25, 2023 at 07:17 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bugdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `bugtable`
--

DROP TABLE IF EXISTS `bugtable`;
CREATE TABLE IF NOT EXISTS `bugtable` (
  `bug_Number` int NOT NULL AUTO_INCREMENT,
  `prod_Name` varchar(25) DEFAULT NULL,
  `version` varchar(10) DEFAULT NULL,
  `hardware` varchar(10) DEFAULT NULL,
  `os` varchar(10) DEFAULT NULL,
  `freq` varchar(20) DEFAULT NULL,
  `solution` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`bug_Number`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
