-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 22, 2015 at 10:47 AM
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
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `building_info`
--

INSERT INTO `building_info` (`id`, `campus`, `code`, `name`) VALUES
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
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `campus_info`
--

INSERT INTO `campus_info` (`id`, `code`, `name`) VALUES
(1, 'TRY', 'Russell Sage College'),
(2, 'ALB', 'Sage College of Albany');

-- --------------------------------------------------------

--
-- Table structure for table `department_info`
--

CREATE TABLE IF NOT EXISTS `department_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `academic` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `department_info`
--

INSERT INTO `department_info` (`id`, `code`, `name`, `academic`) VALUES
(1, 'CEU', 'Continuing Education', 1),
(2, 'HUM', 'Humanities', 1),
(3, 'AMS', 'American Studies', 1),
(4, 'AMS, ENG', 'American Studies, English', 1),
(5, 'BIO', 'Biology', 1),
(6, 'CAT', 'Creat Art in Therapy', 1),
(7, 'CRJ', 'Criminal Justice', 1),
(8, 'CRM', 'Criminal Justice', 1),
(9, 'ENG', 'English', 1),
(10, 'ENG, PSY', 'English, Psychology', 1),
(11, 'ITD', 'Interdisciplinary', 1),
(12, 'HST', 'History', 1),
(13, 'HIS', 'History', 1),
(14, 'GLO', 'Intern''tl Globalization Studie', 1),
(15, 'MAT', 'Mathematics', 1),
(16, 'POL', 'Political Science', 1),
(17, 'PACE', 'Publ Pol, Advoc & Civil Engagt', 1),
(18, 'PSY', 'Psychology', 1),
(19, 'SOC', 'Sociology', 1),
(20, 'THR', 'Theatre', 1),
(21, 'BUS', 'Business', 1),
(22, 'MGT', 'Management', 1),
(23, 'ART', 'Art', 1),
(24, 'GMD', 'Graphic & Media Design', 1),
(25, 'IND', 'Interior Design', 1),
(26, 'PHG', 'Photography', 1),
(27, 'ACC', 'Accounting', 1),
(28, 'ZZZ', 'Miscellaneous', 1),
(29, 'CHM', 'Chemistry', 1),
(30, 'EDU', 'Education', 1),
(31, 'CSI', 'Computer Science', 1),
(32, 'SCI', 'Science', 1),
(33, 'HSC', 'Health Sciences', 1),
(34, 'LAW', 'Law', 1),
(35, 'MAT, CSI', 'Mathematics, Computer Science', 1),
(36, 'NSG', 'Nursing', 1),
(37, 'NTR', 'Nutrition', 1),
(38, 'PSC', 'Political Science', 1),
(39, 'PED', 'Physical Education', 1),
(40, 'ITC', 'Information Technology', 1),
(41, 'HSA', 'Health Services Adm', 1),
(42, 'SCP', 'Professional School Counseling', 1),
(43, 'PTY', 'Physical Therapy', 1),
(44, 'MBA', 'Master Business Adm', 1),
(45, 'OTH', 'Occupational Therapy', 1),
(46, 'PTH', 'Physical Therapy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `program_info`
--

CREATE TABLE IF NOT EXISTS `program_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department` (`department`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=438 ;

--
-- Dumping data for table `program_info`
--

INSERT INTO `program_info` (`id`, `code`, `name`, `department`) VALUES
(1, 'CE.NONMATRIC', 'CONTINUING EDUCATION NONMATRIC', 1),
(2, 'JCA.AA.INS', 'INDIVIDUAL STUDIES', 2),
(3, 'RSC.BA.AMS', 'AMERICAN STUDIES', 3),
(4, 'RSC.BA.AMS.ENG', 'DOUBLE MJR: AMERICAN STUDIES & ENGLISH', 4),
(5, 'RSC.BA.BIO', 'BIOLOGY (BA DEGREE)', 5),
(6, 'RSC.BA.BIO.4OTH', 'BIOLOGY', 5),
(7, 'RSC.BA.BIO.4PTH', 'BIOLOGY', 5),
(8, 'RSC.BA.BIO.ENVS', 'BIOLOGY WITH ENVIRONMENTAL SCIENCE CONCENTRATION', 5),
(9, 'RSC.BA.BIO.OTH', 'BIOLOGY LEADING TO THE MS IN OTH', 5),
(10, 'RSC.BA.BIO.PTH', 'BIOLOGY LEADING TO PTH', 5),
(11, 'RSC.BA.CAT.ART', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN VISUAL ART', 6),
(12, 'RSC.BA.CAT.ART.4OTH', 'CREATIVE ARTS THERAPY WITH ART CONCENTRATION', 6),
(13, 'RSC.BA.CAT.ART.CHL', 'CREATIVE ARTS THERAPY: ART - CHILD LIFE SPECIALIST', 6),
(14, 'RSC.BA.CAT.ART.OTH', 'CREATIVE ARTS THERAPY - ART LEADING TO OTH', 6),
(15, 'RSC.BA.CAT.DAN', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN DANCE', 6),
(16, 'RSC.BA.CAT.DAN.4OTH', 'CREATIVE ARTS THERAPY WITH DANCE CONCENTRATION', 6),
(17, 'RSC.BA.CAT.DAN.CHL', 'CREATIVE ARTS THERAPY: DANCE - CHILD LIFE SPECIALIST', 6),
(18, 'RSC.BA.CAT.DAN.OTH', 'CREATIVE ARTS THERAPY - DANCE LEADING TO OTH', 6),
(19, 'RSC.BA.CAT.MUS', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN MUSIC', 6),
(20, 'RSC.BA.CAT.MUS.4OTH', 'CREATIVE ARTS THERAPY WITH MUSIC CONCENTRATION', 6),
(21, 'RSC.BA.CAT.MUS.CHL', 'CREATIVE ARTS THERAPY: MUSIC - CHILD LIFE SPECIALIST', 6),
(22, 'RSC.BA.CAT.MUS.OTH', 'CREATIVE ARTS THERAPY - MUSIC LEADING TO OTH', 6),
(23, 'RSC.BA.CAT.THR', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN THEATRE', 6),
(24, 'RSC.BA.CAT.THR.4OTH', 'CREATIVE ARTS THERAPY WITH THEATRE CONCENTRATION', 6),
(25, 'RSC.BA.CAT.THR.CHL', 'CREATIVE ARTS THERAPY: THEATRE - CHILD LIFE SPECIALIST', 6),
(26, 'RSC.BA.CAT.THR.OTH', 'CREATIVE ARTS THERAPY - THEATRE LEADING TO OTH', 6),
(27, 'RSC.BA.CRM', 'CRIMINAL JUSTICE', 7),
(28, 'RSC.BA.CRM.SOC', 'DOUBLE MAJOR: CRIMINAL JUSTICE & SOCIOLOGY', 8),
(29, 'RSC.BA.ENG', 'ENGLISH', 9),
(30, 'RSC.BA.ENG.CRM', 'DOUBLE MAJOR: ENGLISH & CRIMINAL JUSTICE', 9),
(31, 'RSC.BA.ENG.OTH', 'ENG LEADING TO MS IN OTH', 9),
(32, 'RSC.BA.ENG.PSY', 'DOUBLE MAJOR: ENGLISH AND PSYCHOLOGY', 10),
(33, 'RSC.BA.ENG.PTH', 'ENGLISH LEADING TO PTH', 9),
(34, 'RSC.BA.ENG.THR', 'DOUBLE MAJOR: ENGLISH AND THEATRE', 9),
(35, 'RSC.BA.ENVIR.STU', 'ENVIRONMENTAL STUDIES', 11),
(36, 'RSC.BA.HIS', 'HISTORY', 12),
(37, 'RSC.BA.HIS.AMS', 'HISTORY: AMERICAN STUDIES PATHWAY', 13),
(38, 'RSC.BA.HIS.IGS', 'HISTORY: INTERNATIONAL GLOBALIZATION PATHWAY', 13),
(39, 'RSC.BA.HIS.OTH', 'HISTORY LEADING TO MS IN OTH', 12),
(40, 'RSC.BA.HIS.PTH', 'HISTORY LEADING TO PTH', 12),
(41, 'RSC.BA.HIS.PUH', 'HISTORY: PUBLIC HISTORY PATHWAY', 13),
(42, 'RSC.BA.INT.GLO', 'INTERNATIONAL & GLOBALIZATION STUDIES', 14),
(43, 'RSC.BA.INTER.DAN.THY', 'INTER MJR: DANCE & THERAPY', 11),
(44, 'RSC.BA.INTER.PER.HMN', 'INTER MJR: PERSPECTIVES IN HUMANITIES', 11),
(45, 'RSC.BA.INTER.SPA.CUL', 'INTER MJR: SPANISH LANGUAGE & CULTURE', 11),
(46, 'RSC.BA.INTER.THA.OTH', 'INTER MJR: THERAPEUTIC STUDIES & ART LEADING TO OTH', 11),
(47, 'RSC.BA.MAT', 'MATHEMATICS', 15),
(48, 'RSC.BA.MAT.4PTH', 'MATHEMATICS', 15),
(49, 'RSC.BA.MAT.EG', 'MATHEMATICS (FOR ENGINEERING OPTION AT RPI)', 15),
(50, 'RSC.BA.MAT.MSMAT', 'MATHEMATICS', 15),
(51, 'RSC.BA.PACE', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMENT', 16),
(52, 'RSC.BA.PACE.CFP', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMENT: CHILD/FAM POL', 17),
(53, 'RSC.BA.PACE.CRJ', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMENT: CRIM JUST POL', 17),
(54, 'RSC.BA.PACE.EFP.IGS', 'DOUBLE MJR: PACE W/ECO & FIN POLICY & INTERNAT''L GLOBAL STU', 17),
(55, 'RSC.BA.PACE.PBH', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMNT: PUBLIC HEALTH', 17),
(56, 'RSC.BA.POL', 'POLITICAL SCIENCE', 16),
(57, 'RSC.BA.POL.OTH', 'POLITICAL SCIENCE LEADING TO MS IN OTH', 16),
(58, 'RSC.BA.PSY', 'PSYCHOLOGY', 18),
(59, 'RSC.BA.PSY.4OTH', 'PSYCHOLOGY', 18),
(60, 'RSC.BA.PSY.4PTH', 'PSYCHOLOGY', 18),
(61, 'RSC.BA.PSY.OTH', 'PSYCHOLOGY LEADING TO MS IN OTH', 18),
(62, 'RSC.BA.PSY.PTH', 'PSYCHOLOGY LEADING TO PTH', 18),
(63, 'RSC.BA.SOC', 'SOCIOLOGY', 19),
(64, 'RSC.BA.SOC.4PTH', 'SOCIOLOGY', 19),
(65, 'RSC.BA.SOC.ADV', 'SOCIOLOGY W/SOCIAL & HEALTH ADVOCACY CONCENTRATION', 19),
(66, 'RSC.BA.SOC.CRIM', 'SOCIOLOGY WITH A CONCENTRATION IN CRIME AND SOCIETY', 19),
(67, 'RSC.BA.SOC.CRJ', 'SOCIOLOGY WITH CRIME & JUSTICE', 19),
(68, 'RSC.BA.SOC.OTH', 'SOCIOLOGY LEADING TO MS IN OTH', 19),
(69, 'RSC.BA.SOC.PBH', 'SOCIOLOGY WITH PUBLIC HEALTH', 19),
(70, 'RSC.BA.SOC.PSY', 'DOUBLE MAJOR: SOCIOLOGY & PSYCHOLOGY', 19),
(71, 'RSC.BA.SOC.PTH', 'SOCIOLOGY LEADING TO PTH', 19),
(72, 'RSC.BA.THR', 'THEATRE', 20),
(73, 'RSC.BBA.BUS', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
(74, 'RSC.BBA.BUS.MKT', 'BUSINESS ADMINISTRATION - MARKETING', 22),
(75, 'RSC.BBA.BUS.MSHSA', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
(76, 'RSC.BBA.BUS.MSMBA', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
(77, 'RSC.BBA.BUS.MSORG', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
(78, 'RSC.BBA.BUS.ORG', 'BUSINESS ADMINISTRATION - ORGANIZATIONAL STUDIES', 22),
(79, 'RSC.BBA.BUS.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
(80, 'RSC.BFA.ART', 'BFA FINE ARTS', 23),
(81, 'RSC.BFA.GMD', 'BFA GRAPHIC & MEDIA DESIGN', 24),
(82, 'RSC.BFA.IND', 'BFA IN INTERIOR DESIGN', 25),
(83, 'RSC.BFA.PHG', 'BFA PHOTOGRAPHY', 26),
(84, 'RSC.BS.ACC', 'ACCOUNTING', 21),
(85, 'RSC.BS.ACC.MSMBA', 'ACCOUNTING', 27),
(86, 'RSC.BS.AEX', 'ACADEMIC EXPLORATION', 28),
(87, 'RSC.BS.APP.BIO', 'APPLIED BIOLOGY', 5),
(88, 'RSC.BS.APP.BIO.4OTH', 'APPLIED BIOLOGY', 5),
(89, 'RSC.BS.APP.BIO.4PTY', 'APPLIED BIOLOGY', 5),
(90, 'RSC.BS.APP.BIO.ENV', 'APPLIED BIOLOGY: ENVIRONMENTAL SCIENCE', 5),
(91, 'RSC.BS.APP.BIO.FBI', 'APPLIED BIOLOGY (BIOLOGY/FORENSIC BIOLOGY)', 5),
(92, 'RSC.BS.APP.BIO.ILL', 'APPLIED BIOLOGY: ILLUSTRATION', 5),
(93, 'RSC.BS.APP.BIO.L&S', 'APPLIED BIOLOGY: LAW & SOCIETY', 5),
(94, 'RSC.BS.APP.BIO.MGT', 'APPLIED BIOLOGY: MANAGEMENT', 5),
(95, 'RSC.BS.APP.BIO.NTR', 'APPLIED BIOLOGY: NUTRITION SCIENCE', 5),
(96, 'RSC.BS.APP.BIO.OTH', 'APPLIED BIOLOGY LEADING TO OTH', 5),
(97, 'RSC.BS.APP.BIO.PBH', 'APPLIED BIOLOGY (BIOLOGY/PUBLIC HEALTH)', 5),
(98, 'RSC.BS.APP.BIO.PMD', 'APPLIED BIOLOGY: PRE-MED/PRE-PHYSICIAN ASST', 5),
(99, 'RSC.BS.APP.BIO.PTY', 'APPLIED BIOLOGY: PHYSICAL THERAPY', 5),
(100, 'RSC.BS.APP.BIO.SCI', 'APPLIED BIOLOGY: SCIENCE WRITING', 5),
(101, 'RSC.BS.ART', 'STUDIO ART', 23),
(102, 'RSC.BS.BIO', 'BIOLOGY (BS DEGREE)', 5),
(103, 'RSC.BS.BIOCHM.ACS', 'BIOCHEMISTRY (ACS CERTIFIED)', 29),
(104, 'RSC.BS.BIOCHM.NON', 'BIOCHEMISTRY (NON-CERTIFIED)', 29),
(105, 'RSC.BS.BUS.ADM', 'BUSINESS ADMINISTRATION', 21),
(106, 'RSC.BS.BUS.ADM.MKT', 'BUSINESS ADMINISTRATION - MARKETING', 22),
(107, 'RSC.BS.BUS.ADM.MSHSA', 'BUSINESS ADMINISTRATION', 21),
(108, 'RSC.BS.BUS.ADM.MSMBA', 'BUSINESS ADMINISTRATION', 21),
(109, 'RSC.BS.BUS.ADM.MSORG', 'BUSINESS ADMINISTRATION', 21),
(110, 'RSC.BS.BUS.ADM.ORG', 'BUSINESS ADMINISTRATION - ORGANIZATIONAL STUDIES', 22),
(111, 'RSC.BS.BUS.ADM.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
(112, 'RSC.BS.CE.ENG', 'ENGLISH CHILDHOOD EDUCATION', 30),
(113, 'RSC.BS.CE.ENG.MSLIT', 'ENGLISH CHILDHOOD EDUCATION', 30),
(114, 'RSC.BS.CE.ENG.MSLSP', 'ENGLISH CHILDHOOD EDUCATION', 30),
(115, 'RSC.BS.CE.ENG.MSSCP', 'ENGLISH CHILDHOOD EDUCATION', 30),
(116, 'RSC.BS.CE.ENG.MSSED', 'ENGLISH CHILDHOOD EDUCATION', 30),
(117, 'RSC.BS.CE.HIS', 'HISTORY CHILDHOOD EDUCATION', 30),
(118, 'RSC.BS.CE.HIS.MSLIT', 'HISTORY CHILDHOOD EDUCATION', 30),
(119, 'RSC.BS.CE.HIS.MSLSP', 'HISTORY CHILDHOOD EDUCATION', 30),
(120, 'RSC.BS.CE.HIS.MSSCP', 'HISTORY CHILDHOOD EDUCATION', 30),
(121, 'RSC.BS.CE.HIS.MSSED', 'HISTORY CHILDHOOD EDUCATION', 30),
(122, 'RSC.BS.CE.LFS', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
(123, 'RSC.BS.CE.LFS.MSLIT', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
(124, 'RSC.BS.CE.LFS.MSLSP', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
(125, 'RSC.BS.CE.LFS.MSSCP', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
(126, 'RSC.BS.CE.LFS.MSSED', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
(127, 'RSC.BS.CE.MAT', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
(128, 'RSC.BS.CE.MAT.MSLIT', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
(129, 'RSC.BS.CE.MAT.MSLSP', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
(130, 'RSC.BS.CE.MAT.MSSCP', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
(131, 'RSC.BS.CE.MAT.MSSED', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
(132, 'RSC.BS.CE.PSY', 'PSYCHOLOGY CHILDHOOD EDUCATION', 30),
(133, 'RSC.BS.CE.PSY.MSLIT', 'PSYCHOLOGY CHILDHOOD EDUCATION', 30),
(134, 'RSC.BS.CE.PSY.MSSED', 'PSYCHOLOGY CHILDHOOD EDUCATION', 30),
(135, 'RSC.BS.CHM.ASC', 'CHEMISTRY (ACS CERTIFIED)', 29),
(136, 'RSC.BS.CHM.NON', 'CHEMISTRY (NON-CERTIFIED)', 29),
(137, 'RSC.BS.CHM.PTH', 'CHEMISTRY LEADING TO PTH', 29),
(138, 'RSC.BS.CHME.PTH', 'CHEMISTRY EVEN YEAR LEADING TO PTH', 29),
(139, 'RSC.BS.CIS', 'COMPUTER INFORMATION SYSTEMS', 31),
(140, 'RSC.BS.CMCE.ENG', 'ENGLISH CHILDHOOD EDUC & MIDDLE CHILDHOOD EDUC (SPEC)', 30),
(141, 'RSC.BS.CMCE.HIS', 'HIST CHILDHOOD EDUC & SOC STUD MIDDLE CHILDHOOD EDUC (SPEC)', 30),
(142, 'RSC.BS.CMCE.MAT', 'MATH CHILDHOOD EDUC & MATH MIDDLE CHILDHOOD EDUC (SPEC)', 30),
(143, 'RSC.BS.CMCE.NS', 'NATURAL SCIENCE CHILDHOOD EDUC & MIDDLE CHILDHOOD EDUC (GEN)', 30),
(144, 'RSC.BS.FOR.SCI.BIO', 'DOUBLE MJR: FORENSIC SCI & BIOLOGY', 29),
(145, 'RSC.BS.FOREN.CHM.NON', 'DOUBLE MAJOR: FORENSIC SCIENCE & CHEMISTRY NON CERT', 29),
(146, 'RSC.BS.FOREN.SCI', 'FORENSIC SCIENCE', 32),
(147, 'RSC.BS.HSC', 'HEALTH SCIENCE', 33),
(148, 'RSC.BS.HSC.4OTH', 'HEALTH SCIENCE', 33),
(149, 'RSC.BS.HSC.4PTH', 'HEALTH SCIENCE', 33),
(150, 'RSC.BS.HSC.OTH', 'HEALTH SCIENCE LEADING TO OTH', 33),
(151, 'RSC.BS.HSC.PTH', 'HEALTH SCIENCE LEADING TO DPT', 33),
(152, 'RSC.BS.INTER.CHSS', 'INTER MJR: COMMUNITY HEALTH & SOCIAL SERVICES', 11),
(153, 'RSC.BS.INTER.HEL.OTH', 'INTER MJR: HEALTH STUDIES LEADING TO OTH', 11),
(154, 'RSC.BS.INTER.HES.OTH', 'INTER MJR: HEALTH STUDIES LEADING TO OTH', 11),
(155, 'RSC.BS.INTER.HET.OTH', 'INTER MJR: HEALTH STUDIES LEADING TO OTH', 11),
(156, 'RSC.BS.INTER.HEW.OTH', 'INTER MJR: HEALTH & WELLNESS STUDIES LEADING TO OTH', 11),
(157, 'RSC.BS.INTER.HLS.OTH', 'INTER MJR: HEALTH STUDIES LEADING TO OTH', 11),
(158, 'RSC.BS.INTER.HLTH', 'INTER MJR: HEALTH STUDIES', 11),
(159, 'RSC.BS.INTER.HS.WELL', 'INTER MJR: HEALTH STUDIES: COGNITIVE/KINESTHETIC', 11),
(160, 'RSC.BS.INTER.HSO.OTH', 'INTER MJR: HEALTH & SOCIETY LEADING TO OTH', 11),
(161, 'RSC.BS.INTER.HUH.OTH', 'INTER MJR: HUMAN HEALTH & WELLNESS LEADING TO OTH', 11),
(162, 'RSC.BS.INTER.HWL.OTH', 'INTER MJR: HEALTH & WELLNESS LEADING TO OTH', 11),
(163, 'RSC.BS.INTER.MAT.EDU', 'INTER MJR: MATHEMATICS & EDUCATION STUDIES', 11),
(164, 'RSC.BS.INTER.PSC.POL', 'INTER MJR: POLITICS & POLICY', 11),
(165, 'RSC.BS.INTERDIS', 'RUSSELL SAGE INTERDISCIPLINARY MAJOR FOR ADMISSIONS', 11),
(166, 'RSC.BS.INTERDIS.4OTH', 'INTERDISCIPLINARY STUDIES', 11),
(167, 'RSC.BS.INTERDIS.4PTH', 'INTERDISCIPLINARY STUDIES', 11),
(168, 'RSC.BS.INTERDIS.OTH', 'RSC OTH INTERDISCIPLINARY STUDIES FOR ADMISSIONS', 11),
(169, 'RSC.BS.LAWSOC.CRM', 'LAW & SOCIETY - CRIMINAL JUSTICE PATHWAY', 34),
(170, 'RSC.BS.LAWSOC.LGL', 'LAW & SOCIETY - LEGAL PATHWAY', 34),
(171, 'RSC.BS.LAWSOC.PSY', 'LAW & SOCIETY - PSYCHOLOGY PATHWAY', 34),
(172, 'RSC.BS.MAT.CIS', 'DOUBLE MJR: MATHEMATICS & COMPUTER INFO SYSTEMS', 35),
(173, 'RSC.BS.MUS.THR', 'MUSICAL THEATRE', 20),
(174, 'RSC.BS.NSG.BASIC', 'NURSING (BASIC)', 36),
(175, 'RSC.BS.NTR', 'NUTRITION', 37),
(176, 'RSC.BS.NTR.MSNTR', 'NUTRITION', 37),
(177, 'RSC.BS.PHYS.ED', 'PHYSICAL EDUCATION', 30),
(178, 'RSC.BS.PHYS.ED.MSSHE', 'PHYSICAL EDUCATION', 30),
(179, 'RSC.BS.PUBL.POLICY', 'PUBLIC AFFAIRS & PUBLIC POLICY', 38),
(180, 'RSC.BS.WCT.PHL', 'WRITING & CONTEMPORARY THOUGHT: PRACTICAL PHILOSOPHY', 2),
(181, 'RSC.BS.WCT.WRIT', 'WRITING & CONTEMPORARY THOUGHT: WRITING', 2),
(182, 'RSC.NONMATRIC', 'RUSSELL SAGE COLLEGE NONMATRIC', 28),
(183, 'SCA.BA.BIO', 'BIOLOGY (BA DEGREE)', 5),
(184, 'SCA.BA.BIO.4OTH', 'BIOLOGY', 5),
(185, 'SCA.BA.BIO.4PTH', 'BIOLOGY', 5),
(186, 'SCA.BA.BIO.ENVS', 'BIOLOGY WITH ENVIRONMENTAL SCIENCE CONCENTRATION', 5),
(187, 'SCA.BA.BIO.OTH', 'BIOLOGY LEADING TO THE MS IN OTH', 5),
(188, 'SCA.BA.BIO.PTH', 'BIOLOGY LEADING TO PTH', 5),
(189, 'SCA.BA.CAT.ART', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN VISUAL ART', 6),
(190, 'SCA.BA.CAT.ART.4OTH', 'CREATIVE ARTS THERAPY WITH ART CONCENTRATION', 6),
(191, 'SCA.BA.CAT.ART.CHL', 'CREATIVE ARTS THERAPY: ART - CHILD LIFE SPECIALIST', 6),
(192, 'SCA.BA.CAT.ART.OTH', 'CREATIVE ARTS THERAPY - ART LEADING TO OTH', 6),
(193, 'SCA.BA.CAT.DAN', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN DANCE', 6),
(194, 'SCA.BA.CAT.DAN.CHL', 'CREATIVE ARTS THERAPY: DANCE - CHILD LIFE SPECIALIST', 6),
(195, 'SCA.BA.CAT.DAN.OTH', 'CREATIVE ARTS THERAPY - DANCE LEADING TO OTH', 6),
(196, 'SCA.BA.CAT.MUS', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN MUSIC', 6),
(197, 'SCA.BA.CAT.MUS.CHL', 'CREATIVE ARTS THERAPY: MUSIC - CHILD LIFE SPECIALIST', 6),
(198, 'SCA.BA.CAT.MUS.OTH', 'CREATIVE ARTS THERAPY - MUSIC LEADING TO OTH', 6),
(199, 'SCA.BA.CAT.THR', 'CREATIVE ARTS IN THERAPY - CONCENTRATION IN THEATRE', 6),
(200, 'SCA.BA.CAT.THR.CHL', 'CREATIVE ARTS THERAPY: THEATRE - CHILD LIFE SPECIALIST', 6),
(201, 'SCA.BA.CAT.THR.OTH', 'CREATIVE ARTS THERAPY - THEATRE LEADING TO OTH', 6),
(202, 'SCA.BA.ENG', 'ENGLISH', 9),
(203, 'SCA.BA.ENG.OTH', 'ENG LEADING TO MS IN OTH', 9),
(204, 'SCA.BA.ENG.PTH', 'ENGLISH LEADING TO PTH', 9),
(205, 'SCA.BA.ENVIR.STU', 'ENVIRONMENTAL STUDIES', 11),
(206, 'SCA.BA.HIS', 'HISTORY', 13),
(207, 'SCA.BA.HIS.AMS', 'HISTORY: AMERICAN STUDIES PATHWAY', 13),
(208, 'SCA.BA.HIS.IGS', 'HISTORY WITH INTERNATIONAL GLOBALIZATION PATHWAY', 13),
(209, 'SCA.BA.HIS.PUH', 'HISTORY: PUBLIC HISTORY PATHWAY', 13),
(210, 'SCA.BA.MAT', 'MATHEMATICS', 15),
(211, 'SCA.BA.MAT.4OTH', 'MATHEMATICS', 15),
(212, 'SCA.BA.MAT.EG', 'MATHEMATICS (FOR ENGINEERING OPTION AT RPI)', 15),
(213, 'SCA.BA.PACE', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMENT', 16),
(214, 'SCA.BA.PACE.PBH', 'PUBLIC POLICY, ADVOCACY & CIVIC ENGAGEMNT: PUBLIC HEALTH', 17),
(215, 'SCA.BA.POL', 'POLITICAL SCIENCE', 16),
(216, 'SCA.BA.PSY', 'PSYCHOLOGY', 18),
(217, 'SCA.BA.PSY.4OTH', 'PSYCHOLOGY', 18),
(218, 'SCA.BA.PSY.4PTH', 'PSYCHOLOGY', 18),
(219, 'SCA.BA.PSY.OTH', 'PSYCHOLOGY LEADING TO MS IN OTH', 18),
(220, 'SCA.BA.PSY.PTH', 'PSYCHOLOGY LEADING TO PTH', 18),
(221, 'SCA.BA.SOC', 'SOCIOLOGY', 19),
(222, 'SCA.BA.SOC.CRJ', 'SOCIOLOGY WITH CRIME & JUSTICE', 19),
(223, 'SCA.BA.SOC.OTH', 'SOCIOLOGY LEADING TO MS IN OTH', 19),
(224, 'SCA.BA.SOC.PBH', 'SOCIOLOGY WITH PUBLIC HEALTH', 19),
(225, 'SCA.BA.SOC.PTH', 'SOCIOLOGY LEADING TO PTH', 19),
(226, 'SCA.BA.THR', 'THEATRE', 20),
(227, 'SCA.BBA.BUS', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
(228, 'SCA.BBA.BUS.MKT', 'BUSINESS ADMINISTRATION - MARKETING', 22),
(229, 'SCA.BBA.BUS.MSHSA', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
(230, 'SCA.BBA.BUS.MSMBA', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
(231, 'SCA.BBA.BUS.MSORG', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
(232, 'SCA.BBA.BUS.ORG', 'BUSINESS ADMINISTRATION - ORGANIZATIONAL STUDIES', 22),
(233, 'SCA.BBA.BUS.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
(234, 'SCA.BFA.ART', 'BFA FINE ARTS', 23),
(235, 'SCA.BFA.ART.MSMAT', 'BFA FINE ARTS', 23),
(236, 'SCA.BFA.ART.PHG', 'BFA FINE ARTS W/PHOTOGRAPHY CONCENTRATION', 26),
(237, 'SCA.BFA.GMD', 'BFA GRAPHIC & MEDIA DESIGN', 23),
(238, 'SCA.BFA.IND', 'BFA IN INTERIOR DESIGN', 25),
(239, 'SCA.BFA.PHG', 'BFA PHOTOGRAPHY', 26),
(240, 'SCA.BS.ACC', 'ACCOUNTING', 27),
(241, 'SCA.BS.ACC.MSMBA', 'ACCOUNTING', 27),
(242, 'SCA.BS.AEX', 'ACADEMIC EXPLORATION', 28),
(243, 'SCA.BS.APP.BIO', 'APPLIED BIOLOGY', 5),
(244, 'SCA.BS.APP.BIO.4OTH', 'APPLIED BIOLOGY', 5),
(245, 'SCA.BS.APP.BIO.4PTY', 'APPLIED BIOLOGY', 5),
(246, 'SCA.BS.APP.BIO.ENV', 'APPLIED BIOLOGY: ENVIRONMENTAL SCIENCE', 5),
(247, 'SCA.BS.APP.BIO.FBI', 'APPLIED BIOLOGY (BIOLOGY/FORENSIC BIOLOGY)', 5),
(248, 'SCA.BS.APP.BIO.ILL', 'APPLIED BIOLOGY: ILLUSTRATION', 5),
(249, 'SCA.BS.APP.BIO.L&S', 'APPLIED BIOLOGY: LAW & SOCIETY', 5),
(250, 'SCA.BS.APP.BIO.MGT', 'APPLIED BIOLOGY: MANAGEMENT', 5),
(251, 'SCA.BS.APP.BIO.NTR', 'APPLIED BIOLOGY: NUTRITION SCIENCE', 5),
(252, 'SCA.BS.APP.BIO.OTH', 'APPLIED BIOLOGY LEADING TO OTH', 5),
(253, 'SCA.BS.APP.BIO.PBH', 'APPLIED BIOLOGY (BIOLOGY/PUBLIC HEALTH)', 5),
(254, 'SCA.BS.APP.BIO.PMD', 'APPLIED BIOLOGY: PRE-MED/PRE-PHYSICIAN ASST', 5),
(255, 'SCA.BS.APP.BIO.PTY', 'APPLIED BIOLOGY: PHYSICAL THERAPY', 5),
(256, 'SCA.BS.APP.BIO.SCI', 'APPLIED BIOLOGY: SCIENCE WRITING', 5),
(257, 'SCA.BS.ART', 'STUDIO ART', 23),
(258, 'SCA.BS.BIO', 'BIOLOGY (B.S. DEGREE)', 5),
(259, 'SCA.BS.BIOCHM.ACS', 'BIOCHEMISTRY (ACS CERTIFIED)', 29),
(260, 'SCA.BS.BIOCHM.NON', 'BIOCHEMISTRY (NON-CERTIFIED)', 29),
(261, 'SCA.BS.BUS.ADM', 'BUSINESS ADMINISTRATION', 21),
(262, 'SCA.BS.BUS.ADM.MKT', 'BUSINESS ADMINISTRATION - MARKETING', 22),
(263, 'SCA.BS.BUS.ADM.MSHSA', 'BUSINESS ADMINISTRATION', 22),
(264, 'SCA.BS.BUS.ADM.MSMBA', 'BUSINESS ADMINISTRATION', 22),
(265, 'SCA.BS.BUS.ADM.MSORG', 'BUSINESS ADMINISTRATION', 22),
(266, 'SCA.BS.BUS.ADM.ORG', 'BUSINESS ADMINISTRATION - ORGANIZATIONAL STUDIES', 22),
(267, 'SCA.BS.BUS.ADM.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
(268, 'SCA.BS.CE.ENG', 'ENGLISH CHILDHOOD EDUCATION', 30),
(269, 'SCA.BS.CE.ENG.MSLIT', 'ENGLISH CHILDHOOD EDUCATION', 30),
(270, 'SCA.BS.CE.ENG.MSLSP', 'ENGLISH CHILDHOOD EDUCATION', 30),
(271, 'SCA.BS.CE.ENG.MSSCP', 'ENGLISH CHILDHOOD EDUCATION', 30),
(272, 'SCA.BS.CE.ENG.MSSED', 'ENGLISH CHILDHOOD EDUCATION', 30),
(273, 'SCA.BS.CE.HIS', 'HISTORY CHILDHOOD EDUCATION', 30),
(274, 'SCA.BS.CE.HIS.MSLIT', 'HISTORY CHILDHOOD EDUCATION', 30),
(275, 'SCA.BS.CE.HIS.MSLSP', 'HISTORY CHILDHOOD EDUCATION', 30),
(276, 'SCA.BS.CE.HIS.MSSCP', 'HISTORY CHILDHOOD EDUCATION', 30),
(277, 'SCA.BS.CE.HIS.MSSED', 'HISTORY CHILDHOOD EDUCATION', 30),
(278, 'SCA.BS.CE.LFS', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
(279, 'SCA.BS.CE.LFS.MSLIT', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
(280, 'SCA.BS.CE.LFS.MSLSP', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
(281, 'SCA.BS.CE.LFS.MSSCP', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
(282, 'SCA.BS.CE.LFS.MSSED', 'LIFE SCIENCE CHILDHOOD EDUCATION', 30),
(283, 'SCA.BS.CE.MAT', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
(284, 'SCA.BS.CE.MAT.MSLIT', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
(285, 'SCA.BS.CE.MAT.MSLSP', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
(286, 'SCA.BS.CE.MAT.MSSCP', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
(287, 'SCA.BS.CE.MAT.MSSED', 'MATHEMATICS CHILDHOOD EDUCATION', 30),
(288, 'SCA.BS.CHM.ACS', 'CHEMISTRY ACS CERTIFIED', 29),
(289, 'SCA.BS.CHM.NON', 'CHEMISTRY (NON-CERTIFIED)', 29),
(290, 'SCA.BS.CHM.PTH', 'CHEMISTRY LEADING TO PTH', 29),
(291, 'SCA.BS.CIS', 'COMPUTER INFORMATION SYSTEMS', 31),
(292, 'SCA.BS.CLI.BIO.CYTO', 'BS CLINICAL BIOLOGY LEADING TO CYTOTECHNOLOGY CERT', 5),
(293, 'SCA.BS.CLI.BIO.LAB', 'BS CLINICAL BIOLOGY LEADING TO CLINICAL LAB SCI CERT', 5),
(294, 'SCA.BS.CMCE.ENG', 'ENGLISH CHILDHOOD EDUC & MIDDLE CHILDHOOD EDUC (SPEC)', 30),
(295, 'SCA.BS.CMCE.HIS', 'HIST CHILDHOOD EDUC & SOC STUD MIDDLE CHILDHOOD EDUC (SPEC)', 30),
(296, 'SCA.BS.CMCE.MAT', 'MATH CHILDHOOD EDUC & MATH MIDDLE CHILDHOOD EDUC (SPEC)', 30),
(297, 'SCA.BS.CMCE.NS', 'NATURAL SCIENCE CHILDHOOD EDUC & MIDDLE CHILDHOOD EDUC (GEN)', 30),
(298, 'SCA.BS.CREAT.STU.WRT', 'CREATIVE STUDIES - WRITING EMPHASIS', 2),
(299, 'SCA.BS.FOREN.SCI', 'FORENSIC SCIENCE', 32),
(300, 'SCA.BS.HSC', 'HEALTH SCIENCES', 33),
(301, 'SCA.BS.HSC.4OTH', 'HEALTH SCIENCE', 33),
(302, 'SCA.BS.HSC.4PTH', 'HEALTH SCIENCE', 33),
(303, 'SCA.BS.HSC.OTH', 'HEALTH SCIENCE LEADING TO OTH', 33),
(304, 'SCA.BS.HSC.PTH', 'HEALTH SCIENCE LEADING TO DPT', 33),
(305, 'SCA.BS.INTER.ENG.PSY', 'INTER MJR: ENGLISH & PSYCHOLOGY STUDIES', 11),
(306, 'SCA.BS.INTER.PSY.ART', 'INTER MJR: PSYCHOLOGY & VISUAL ART STUDIES', 11),
(307, 'SCA.BS.INTER.PSY.EGL', 'INTER MJR: PSYCHOLOGY & ENGLISH STUDIES', 11),
(308, 'SCA.BS.INTER.PYMGT', 'INTER MJR: PSYCHOLOGY & MANAGEMENT STUDIES', 11),
(309, 'SCA.BS.INTERDIS', 'INTERDISCIPLINARY STUDIES', 11),
(310, 'SCA.BS.INTERDIS.4OTH', 'INTERDISCIPLINARY STUDIES', 11),
(311, 'SCA.BS.INTERDIS.4PTH', 'INTERDISCIPLINARY STUDIES', 11),
(312, 'SCA.BS.LAWSOC.CRM', 'LAW & SOCIETY - CRIMINAL JUSTICE PATHWAY', 34),
(313, 'SCA.BS.LAWSOC.LGL', 'LAW & SOCIETY - LEGAL PATHWAY', 34),
(314, 'SCA.BS.LAWSOC.PSY', 'LAW & SOCIETY - PSYCHOLOGY PATHWAY', 34),
(315, 'SCA.BS.MUS.THR', 'MUSICAL THEATRE', 20),
(316, 'SCA.BS.NSG.BASIC', 'NURSING BASIC', 36),
(317, 'SCA.BS.NTR', 'NUTRITION', 37),
(318, 'SCA.BS.NTR.MSNTR', 'NUTRITION', 37),
(319, 'SCA.BS.PHYS.ED', 'PHYSICAL EDUCATION', 30),
(320, 'SCA.BS.PHYS.ED.MSSHE', 'PHYSICAL EDUCATION', 39),
(321, 'SCA.BS.PUBL.POLICY', 'PUBLIC AFFAIRS & PUBLIC POLICY', 38),
(322, 'SCA.BS.WCT.PHL', 'WRITING & CONTEMPORARY THOUGHT: PRACTICAL PHILOSOPHY', 2),
(323, 'SCA.BS.WCT.WRIT', 'WRITING & CONTEMPORARY THOUGHT: WRITING', 2),
(324, 'SCA.CERT.LAS', 'CERTIFICATE IN LEGAL STUDIES', 34),
(325, 'SCA.NONMATRIC', 'SAGE COLLEGE OF ALBANY - NONMATRIC', 28),
(326, 'SCAC.BA.LIB.STUD.AD', 'LIBERAL STUDIES', 2),
(327, 'SCAC.BA.LIB.STUD.AM', 'LIBERAL STUDIES (AMERICAN STUDIES EMPHASIS)', 2),
(328, 'SCAC.BA.LIB.STUD.EN', 'LIBERAL STUDIES (ENGLISH EMPHASIS)', 2),
(329, 'SCAC.BA.LIB.STUD.ID', 'LIBERAL STUDIES (INDIVIDUAL STUDIES EMPHASIS)', 2),
(330, 'SCAC.BBA.BUS', 'BACHELOR OF BUSINESS ADMINISTRATION', 21),
(331, 'SCAC.BBA.BUS.MKT', 'BACHELOR OF BUSINESS ADMINISTRATION - MARKETING', 22),
(332, 'SCAC.BBA.BUS.MSHSA', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
(333, 'SCAC.BBA.BUS.MSMBA', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
(334, 'SCAC.BBA.BUS.MSORG', 'BACHELOR OF BUSINESS ADMINISTRATION', 22),
(335, 'SCAC.BBA.BUS.ONL', 'BACHELOR OF BUSINESS ADMINISTRATION ONLINE', 21),
(336, 'SCAC.BBA.BUS.ORG', 'BACHELOR OF BUSINESS ADMIN - ORGANIZATIONAL STUDIES', 22),
(337, 'SCAC.BBA.BUS.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
(338, 'SCAC.BS.ACC', 'ACCOUNTING', 27),
(339, 'SCAC.BS.ACC.MSHSA', 'ACCOUNTING', 22),
(340, 'SCAC.BS.ACC.MSMBA', 'ACCOUNTING', 22),
(341, 'SCAC.BS.ACC.MSORG', 'ACCOUNTING', 22),
(342, 'SCAC.BS.ACC.ONL', 'ACCOUNTING ONLINE', 27),
(343, 'SCAC.BS.BUS.ADM', 'BUSINESS ADMINISTRATION', 21),
(344, 'SCAC.BS.BUS.ADM.MKT', 'BUSINESS ADMIN - MARKETING', 22),
(345, 'SCAC.BS.BUS.ADM.ORG', 'BUSINESS ADMIN - ORGANIZATIONAL STUDIES', 22),
(346, 'SCAC.BS.BUS.ADM.SPM', 'BUSINESS ADMINISTRATION - SPORT MANAGEMENT CONCENTRATION', 22),
(347, 'SCAC.BS.BUS.MSHSA', 'BUSINESS ADMINISTRATION', 21),
(348, 'SCAC.BS.BUS.MSMBA', 'BUSINESS ADMINISTRATION', 22),
(349, 'SCAC.BS.BUS.MSORG', 'BUSINESS ADMINISTRATION', 22),
(350, 'SCAC.BS.CIS', 'COMPUTER INFORMATION SYSTEMS', 31),
(351, 'SCAC.BS.CRLJ.POLICY', 'CRIME, LAW & JUSTICE POLICY', 8),
(352, 'SCAC.BS.CRM.POLICY', 'CRIME & JUSTICE POLICY', 8),
(353, 'SCAC.BS.INTER.BUS.PY', 'INTER MJR: BUS ADMIN & PSYCHOLOGY STUDIES', 11),
(354, 'SCAC.BS.INTER.PSYMG', 'INTER MJR: PSYCH & MGT STUDIES', 11),
(355, 'SCAC.BS.INTERDIS', 'BACHELOR OF SCIENCE IN INTERDISCIPLINARY STUDIES', 28),
(356, 'SCAC.BS.ITC.CST.ONL', 'INFORMATION TECHN - CYBER SECURITY', 40),
(357, 'SCAC.BS.LEGAL', 'LEGAL STUDIES', 34),
(358, 'SCAC.BS.NETWK', 'COMPUTER NETWORK AND SYSTEMS ADMINISTRATION', 31),
(359, 'SCAC.BS.NSG.RN', 'NURSING (RN)', 36),
(360, 'SCAC.BS.NSG.RN.MSNSG', 'NURSING RN', 36),
(361, 'SCAC.BS.NSG.RN.ONL', 'NURSING RN ONLINE', 36),
(362, 'SCAC.BS.PSY', 'PSYCHOLOGY (BS)', 18),
(363, 'SCAC.CERT.CST.ONL', 'CYBER SECURITY CERTIFICATE ONLINE', 40),
(364, 'SCAC.CERT.ITC.ONL', 'INFORMATION TECHN CERTIFICATE ONLINE', 40),
(365, 'SCAC.CERT.PMD', 'CERT. IN POST-BACCALAUREATE PRE-MEDICAL STUDIES', 5),
(366, 'SCAC.NONMATRIC', 'SCA: SAW NONMATRIC', 28),
(367, 'SGS.CERT.ABA', 'APPL BEHAVIOR ANALYSIS POST MASTER''S CERT', 30),
(368, 'SGS.CERT.ASP', 'ADV CERT: ASSESSMENT & PLANNING', 30),
(369, 'SGS.CERT.DI', 'DIETETIC INTERNSHIP', 37),
(370, 'SGS.CERT.DI.ONL', 'DIETETIC INTERNSHIP (ONLINE)', 37),
(371, 'SGS.CERT.FMH', 'FORENSIC MENTAL HEALTH CERTIFICATE', 18),
(372, 'SGS.CERT.HSA', 'CERT IN ADV STUDY OF HEALTH SERVICES ADMIN', 41),
(373, 'SGS.CERT.LIT', 'ADV CERT: LITERACY', 30),
(374, 'SGS.CERT.NTR', 'POST-BACCALAUREATE CERTIFICATE IN NUTRITION', 37),
(375, 'SGS.CERT.PMN.ACUTE', 'PMN ACUTE CARE NURSE PRACTITIONER', 36),
(376, 'SGS.CERT.PMN.ADHLH', 'ADULT HEALTH NURSING', 36),
(377, 'SGS.CERT.PMN.ADMIN', 'PMN NURSE ADMINISTRATOR/EXECUTIVE', 36),
(378, 'SGS.CERT.PMN.ADULT', 'PMN ADULT NURSE PRACTITIONER', 36),
(379, 'SGS.CERT.PMN.AGNP', 'PMN ADULT GERONTOLOGY NURSE PRACTITIONER', 36),
(380, 'SGS.CERT.PMN.CLINLDR', 'PMN CLINICAL NURSE LEADER/SPECIALIST', 36),
(381, 'SGS.CERT.PMN.EDUC', 'PMN NURSE EDUCATOR', 36),
(382, 'SGS.CERT.PMN.FAM', 'PMN FAMILY NURSE PRACTITIONER', 36),
(383, 'SGS.CERT.PMN.PSYNP', 'PMN PSYCHIATRIC MENTAL HEALTH NURSE PRACTITIONER', 36),
(384, 'SGS.CERT.PMN.PSYSPEC', 'PMN PSYCHIATRIC MENTAL HEALTH CLINICAL NURSE SPECIALIST', 36),
(385, 'SGS.CERT.SCP', 'ADV CERT PROFESSIONAL SCHOOL COUNSELING', 42),
(386, 'SGS.CERT.TEI', 'ADV CERT: TECHNOLOGY INTEGRATION', 30),
(387, 'SGS.DNS.NSG.LDR', 'NURSING EDUCATION & LEADERSHIP', 36),
(388, 'SGS.DPT.PHY.THERAPY', 'PHYSICAL THERAPY', 43),
(389, 'SGS.EDD.EDU.LDR', 'EDUCATIONAL LEADERSHIP', 30),
(390, 'SGS.MA.COMM.PSY.GEN', 'COMMUNITY PSYCHOLOGY PROGRAM', 18),
(391, 'SGS.MA.COUNS.COM.FMH', 'COUNSELING & COMMUNITY PSYCH W/ FORENS MENTAL HLTH CERT', 18),
(392, 'SGS.MA.COUNS.COM.PSY', 'Counseling and Community Psych.', 18),
(393, 'SGS.MAT.ART', 'MASTER OF ARTS IN TEACHING - ART EDUCATION (K-12)', 30),
(394, 'SGS.MAT.ENG.AE', 'MASTER OF ARTS IN TEACHING: ENGLISH ADOLESC EDUCATION', 30),
(395, 'SGS.MBA.BUS.ADM', 'BUSINESS ADMINISTRATION - GENERAL CONCENTRATION', 44),
(396, 'SGS.MBA.BUS.ADM.FIN', 'BUSINESS ADMIN - FINANCE', 44),
(397, 'SGS.MBA.BUS.ADM.HRM', 'BUSINESS ADMIN - HUMAN RESOURCES', 44),
(398, 'SGS.MBA.BUS.ADM.MKT', 'BUSINESS ADMIN - MARKETING', 44),
(399, 'SGS.MBA.BUS.ADM.ONL', 'BUSINESS ADMINISTRATION ONLINE', 44),
(400, 'SGS.MBA.BUS.ADM.STRA', 'BUSINESS ADMIN - BUS STRATEGY', 44),
(401, 'SGS.MBA.JD.BUS.LAW', 'JOINT DEGREE - MBA BUSINESS ADMIN & JD LAW', 44),
(402, 'SGS.MS.ABA', 'APPLIED BEHAVIOR ANALYSIS & AUTISM', 30),
(403, 'SGS.MS.APP.NTR', 'APPLIED NUTRITION (MS)', 37),
(404, 'SGS.MS.APP.NTR.DI', 'APPLIED NUTRITION (MS) WITH DIETETIC INTERNSHIP CERT', 37),
(405, 'SGS.MS.CHILD.LIT', 'CHILDHOOD EDUCATION/LITERACY CHILDHOOD (1-6)', 30),
(406, 'SGS.MS.CHILD.SPE', 'CHILDHOOD EDUCATION/SPECIAL EDUCATION CHILDHOOD', 30),
(407, 'SGS.MS.COM.HLTH.GCH', 'COMMUNITY HEALTH EDUCATION - GREATER COM TR', 30),
(408, 'SGS.MS.FMH', 'FORENSIC MENTAL HEALTH', 18),
(409, 'SGS.MS.HLTH.ADM.DI', 'HEALTH SRVCES ADMIN - DIETETIC INTERNSHIP TRACK', 41),
(410, 'SGS.MS.HLTH.ADM.GNT', 'HEALTH SRVCES ADMIN - GERONTOLOGY TRACK', 41),
(411, 'SGS.MS.HLTH.ADM.NTHS', 'HLTH SRVCES ADMIN - NON-THESIS OPTION', 41),
(412, 'SGS.MS.HLTH.ADM.THES', 'HLTH SRVCES ADMIN - THESIS OPTION', 41),
(413, 'SGS.MS.HSA.NTHS.ONL', 'HEALTH SERVICES ADMINISTRATION - NON THESIS (ONLINE)', 41),
(414, 'SGS.MS.HSA.THES.ONL', 'HEALTH SERVICES ADMINISTRATION - THESIS (ONLINE)', 41),
(415, 'SGS.MS.LIT.SPEC.ED', 'LITERACY/SPECIAL EDUCATION', 30),
(416, 'SGS.MS.MBA.NSG.BUS', 'COMBINED DEGREE - MS NSG AND MBA BUSINESS ADMINISTRATION', 36),
(417, 'SGS.MS.MTX', 'MASTER''S IN TEACHING EXCELLENCE', 30),
(418, 'SGS.MS.NSG.AD.GNT.NP', 'ADULT GERONTOLOGY NURSE PRACTITIONER', 36),
(419, 'SGS.MS.NSG.ADLT.GER', 'ADULT GERIATRIC ADVANCE PRACTICE NURSING', 36),
(420, 'SGS.MS.NSG.ADLT.HLTH', 'ADULT HEALTH NURSING', 36),
(421, 'SGS.MS.NSG.ADLT.PRCT', 'ADULT NURSE PRACTITIONER', 36),
(422, 'SGS.MS.NSG.FAM.MHNP', 'FAMILY PSYCH MENTAL HLTH NURSE PRACTITIONER', 36),
(423, 'SGS.MS.NSG.FAM.NUR.P', 'FAMILY NURSE PRACTITIONER', 36),
(424, 'SGS.MS.NSG.PMH', 'PSYCHIATRIC MENTAL HEALTH NURSING CLINICAL NRSE SPCLST', 36),
(425, 'SGS.MS.ORG.MGT', 'ORGANIZATION MANAGEMENT', 22),
(426, 'SGS.MS.ORG.MGT.ONL', 'ORGANIZATION MANAGEMENT ONLINE', 22),
(427, 'SGS.MS.ORG.MGT.PAD', 'ORGANIZATION MANAGEMENT - W/PUBLIC ADMIN CONCENTRATION', 22),
(428, 'SGS.MS.OTH', 'OCCUPATIONAL THERAPY', 45),
(429, 'SGS.MS.SCH.HLTH.ED', 'SCHOOL HEALTH EDUCATION', 30),
(430, 'SGS.MS.SCH.HLTH.PED', 'SCHOOL HEALTH EDUCATION (PED)', 30),
(431, 'SGS.MS.SCP', 'PROFESSIONAL SCHOOL COUNSELING', 30),
(432, 'SGS.MSE.CHILD.SPC.ED', 'SPECIAL EDUCATION (CHILDHOOD)', 30),
(433, 'SGS.MSE.CHILDHD.ED', 'CHILDHOOD EDUCATION', 30),
(434, 'SGS.MSE.LIT.ED', 'LITERACY EDUCATION', 30),
(435, 'SGS.NONMATRIC', 'GRADUATE NONMATRIC', 28),
(436, 'SGS.TDPT.PHY.THERAPY', 'PHYSICAL THERAPY (TRANSITIONAL DPT)', 46),
(437, 'TSC.AA.BS.CRM', 'CRIMINAL JUSTICE 2 PLUS 2', 8);

-- --------------------------------------------------------

--
-- Table structure for table `role_info`
--

CREATE TABLE IF NOT EXISTS `role_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `role_info`
--

INSERT INTO `role_info` (`id`, `code`, `name`) VALUES
(1, 'STUDENT', 'Student'),
(2, 'EMPLOYEE', 'Employee'),
(3, 'FACULTY', 'Faculty'),
(4, 'ADJUNCT', 'Adjunct');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sageid` int(7) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name_first` varchar(255) NOT NULL,
  `name_middle` varchar(255) DEFAULT NULL,
  `name_last` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `building` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(255) DEFAULT NULL,
  `room` int(3) DEFAULT NULL,
  `floor` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_departments`
--

CREATE TABLE IF NOT EXISTS `user_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_programs`
--

CREATE TABLE IF NOT EXISTS `user_programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `program` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(11) NOT NULL DEFAULT '0',
  `user` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
