-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2015 at 11:18 AM
-- Server version: 1.0.19
-- PHP Version: 5.4.39-0+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `universal_user_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE IF NOT EXISTS `api_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `app` varchar(255) NOT NULL,
  `write` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `building_info`
--

CREATE TABLE IF NOT EXISTS `building_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus` int(11) NOT NULL,
  `datatel_name` varchar(255) NOT NULL,
  `common_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `building_info`
--

INSERT INTO `building_info` (`id`, `campus`, `datatel_name`, `common_name`) VALUES
(1, 1, '37-1', '37 First Street'),
(2, 1, '90-1', '90 1st Street'),
(3, 1, '92-1', '92 1st Street'),
(4, 1, 'ACKR', 'Ackerman Hall'),
(5, 2, 'ACRH', 'Albany Res Hall'),
(6, 2, 'ADB', 'Art & Design Bldg.'),
(7, 2, 'ADM', 'Administration Bldg'),
(8, 1, 'ADMO', 'Admission House'),
(9, 1, 'ALUM', 'Alumnae/i House'),
(10, 2, 'ARM', 'Armory'),
(11, 2, 'ART', 'Graphic Design Building'),
(12, 2, 'AXT', 'Health Sciences Building'),
(13, 1, 'BUCH', 'Buchman Pavilion'),
(14, 1, 'BUSH', 'Bush Memorial'),
(15, 1, 'CARR', 'Carriage House'),
(16, 2, 'CCR', 'Kahl Center'),
(17, 1, 'COWE', 'Cowee Hall'),
(18, 1, 'DAYC', 'Day Care Center'),
(19, 1, 'DINH', 'Dining Hall'),
(20, 1, 'EDUC', 'Education Building'),
(21, 1, 'FR', 'French House'),
(22, 1, 'FREN', 'French House Annex'),
(23, 1, 'FRER', 'Frear House'),
(24, 2, 'FRO', 'Froman Hall'),
(25, 2, 'GDB', 'Graphic Design Building'),
(26, 1, 'GERM', 'Do Not Use'),
(27, 1, 'GR', 'German House'),
(28, 1, 'GURL', 'Gurley Hall'),
(29, 2, 'GYM', 'Gymnasium'),
(30, 1, 'HA', 'Hart Hall'),
(31, 1, 'HART', 'Hart Hall'),
(32, 1, 'HVCC', 'HVCC'),
(33, 1, 'JNPA', 'John Paine Building'),
(34, 1, 'KELL', 'Do Not Use'),
(35, 1, 'KS', 'Kellas-Slocum'),
(36, 2, 'LIB', 'Library - 2any'),
(37, 1, 'LIBT', 'Library - Troy'),
(38, 1, 'MA', 'Manning Hall'),
(39, 1, 'MANN', 'Manning'),
(40, 1, 'MCKA', 'McKins1 Annex'),
(41, 1, 'MEAD', 'James L. Meader Thr'),
(42, 1, 'MK', 'McKins1'),
(43, 1, 'MS', 'McMurray/Spicer/Gale'),
(44, 1, 'MSG', 'Do Not Use'),
(45, 1, 'NEFF', 'Neff Athletic Center'),
(46, 2, 'OPA', 'Opalka Gallery'),
(47, 1, 'PLUM', 'Plum Building'),
(48, 1, 'RI', 'Ricketts Hall'),
(49, 1, 'RICK', 'Ricketts Hall'),
(50, 1, 'ROBC', 'Robison Center'),
(51, 1, 'ROYC', 'Roy Court'),
(52, 2, 'RTH', 'Rathbone Hall'),
(53, 1, 'SA', 'Sage Hall'),
(54, 1, 'SAGE', 'Do Not Use'),
(55, 2, 'SCE', 'Science Building'),
(56, 1, 'SCIH', 'Science Hall'),
(57, 1, 'SFAC', 'Schacht Fine Arts Cn'),
(58, 2, 'SHAL', 'South Hall'),
(59, 1, 'SL', 'Slocum Hall'),
(60, 1, 'SLC', 'Shea Learning Center'),
(61, 1, 'SP', 'Spanish House'),
(62, 1, 'SPAN', 'Spanish House'),
(63, 1, 'TNIS', 'Tennis Courts'),
(64, 2, 'UHA', 'Uh College Suites'),
(65, 2, 'UHRH', 'University Heights Res. Apts.'),
(66, 1, 'VAND', 'Vanderheyden Hall'),
(67, 1, 'WALK', 'Walker Center'),
(68, 1, 'WO', 'Wool House'),
(69, 1, 'WOOL', 'Do Not Use'),
(70, 2, 'WST', 'West Hall');

-- --------------------------------------------------------

--
-- Table structure for table `campus_info`
--

CREATE TABLE IF NOT EXISTS `campus_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datatel_name` varchar(255) NOT NULL,
  `common_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `campus_info`
--

INSERT INTO `campus_info` (`id`, `datatel_name`, `common_name`) VALUES
(1, 'TRY', 'Russell Sage College'),
(2, 'ALB', 'Sage College of Albany');

-- --------------------------------------------------------

--
-- Table structure for table `role_info`
--

CREATE TABLE IF NOT EXISTS `role_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datatel_name` varchar(255) NOT NULL,
  `common_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `role_info`
--

INSERT INTO `role_info` (`id`, `datatel_name`, `common_name`) VALUES
(1, 'STUDENT', 'Student'),
(2, 'EMPLOYEE', 'Employee'),
(3, 'FACULTY', 'Faculty'),
(4, 'ADJUNCT', 'Adjunct');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_num` int(7) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name_first` varchar(255) NOT NULL,
  `name_middle` varchar(255) DEFAULT NULL,
  `name_last` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email2` varchar(255) DEFAULT NULL,
  `building` int(11) DEFAULT NULL,
  `role` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `phone` int(10) DEFAULT NULL,
  `room` int(3) DEFAULT NULL,
  `has_photo_id` tinyint(1) DEFAULT '0',
  `photo_id_url` varchar(255) DEFAULT NULL,
  `photo_id_filename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
