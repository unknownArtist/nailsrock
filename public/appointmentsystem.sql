-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 06, 2012 at 10:08 AM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `appointmentsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE IF NOT EXISTS `adminlogin` (
  `adminID` int(11) NOT NULL AUTO_INCREMENT,
  `adminUsername` varchar(255) NOT NULL,
  `adminPasword` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`adminID`, `adminUsername`, `adminPasword`, `role`) VALUES
(1, 'admin', '123456', 0);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `technicianID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  `serviceID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `technicianID`, `memberID`, `serviceID`) VALUES
(1, 45, 1, 42);

-- --------------------------------------------------------

--
-- Table structure for table `memberaccountnotes`
--

CREATE TABLE IF NOT EXISTS `memberaccountnotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberID` int(11) NOT NULL,
  `date` date NOT NULL,
  `notes` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `memberID` int(11) NOT NULL AUTO_INCREMENT,
  `mem_card` varchar(255) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `vipMember` tinyint(4) NOT NULL,
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`memberID`, `mem_card`, `email`, `password`, `firstName`, `lastName`, `phone`, `address`, `city`, `state`, `zip_code`, `vipMember`) VALUES
(5, NULL, 'jhon@zend.com', 'quick', 'john', 'elia', '234', 'xyz', 'xyz', 'xyz', 234, 0),
(6, NULL, 'zoper@gmail.com', 'quick', 'zoper', 'Studios', '2342', 'xyz', 'xyz', 'skd', 342, 0),
(7, NULL, 'saqib.msn@hotmail.com', 'quick', 'muhammad ', 'Saqib', '234', 'xy', 'abbottabad', 'kpk', 234, 0),
(8, NULL, 'saqib.msn@hotmail.com', '9a5751d5acecf26ff7eb2b33c144efce1c69fe9a', 'muhammad ', 'Saqib', '234', 'xy', 'abbottabad', 'kpk', 234, 1),
(9, NULL, 'saqib.msn@hotmail.com', '9a5751d5acecf26ff7eb2b33c144efce1c69fe9a', 'muhammad ', 'Saqib', '234', 'xy', 'abbottabad', 'kpk', 234, 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `serviceID` int(11) NOT NULL AUTO_INCREMENT,
  `serviceName` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  PRIMARY KEY (`serviceID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`serviceID`, `serviceName`, `duration`) VALUES
(28, 'Nail: RE Touching', '15 Minutes'),
(29, 'rwr', '15 Minutes'),
(30, 'sdfsdf', '45 Minutes'),
(31, 'Nail: RE Touching', '15 Minutes'),
(32, 'Nail: RE Touching', '15 Minutes'),
(33, 'sdfsdf', '15 Minutes'),
(34, 'new service', '15 Minutes'),
(35, 'new service', '15 Minutes'),
(36, 'ddd', '15 Minutes'),
(37, 'nails cutting', '15 Minutes'),
(38, 'Nails: P-Fills', '15 Minutes'),
(39, 'Nails: Acryllic Fills', '60 Minutes'),
(40, 'Nails: Acryllic Fills', '15 Minutes'),
(41, 'Nails: P-Fills', '60 Minutes'),
(42, 'Nails: Acryllic F-S', '45 Minutes'),
(43, 'ddd', '45 Minutes'),
(44, 'Nails: P-Fills', '45 Minutes');

-- --------------------------------------------------------

--
-- Table structure for table `shopcustomhours`
--

CREATE TABLE IF NOT EXISTS `shopcustomhours` (
  `ID` int(25) NOT NULL AUTO_INCREMENT,
  `day` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `closeAllDay` tinyint(4) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `shopcustomhours`
--

INSERT INTO `shopcustomhours` (`ID`, `day`, `date`, `closeAllDay`, `start`, `end`, `comments`) VALUES
(3, '', '2012-08-09', 0, '12:00pm', '6:00pm', 'e3rewr');

-- --------------------------------------------------------

--
-- Table structure for table `shophours`
--

CREATE TABLE IF NOT EXISTS `shophours` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `day` varchar(255) NOT NULL,
  `closeAllDay` bit(1) NOT NULL,
  `open` varchar(255) NOT NULL,
  `close` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `shophours`
--

INSERT INTO `shophours` (`ID`, `day`, `closeAllDay`, `open`, `close`) VALUES
(1, 'Sunday', b'1', '', ''),
(2, 'Monday', b'1', '', ''),
(3, 'Tuesday', b'1', '', ''),
(4, 'Wednesday', b'1', '', ''),
(5, 'Thusday', b'1', '', ''),
(6, 'Friday', b'1', '', ''),
(7, 'Saturday', b'1', '', ''),
(8, 'Sunday', b'1', '', ''),
(9, 'Monday', b'1', '', ''),
(10, 'Tuesday', b'1', '', ''),
(11, 'Wednesday', b'1', '', ''),
(12, 'Thusday', b'1', '', ''),
(13, 'Friday', b'1', '', ''),
(14, 'Saturday', b'1', '', ''),
(15, 'Sunday', b'1', '', ''),
(16, 'Monday', b'1', '', ''),
(17, 'Tuesday', b'1', '', ''),
(18, 'Wednesday', b'1', '', ''),
(19, 'Thusday', b'1', '', ''),
(20, 'Friday', b'1', '', ''),
(21, 'Saturday', b'1', '', ''),
(22, 'Sunday', b'1', '', ''),
(23, 'Monday', b'1', '', ''),
(24, 'Tuesday', b'1', '', ''),
(25, 'Wednesday', b'1', '', ''),
(26, 'Thusday', b'1', '', ''),
(27, 'Friday', b'1', '', ''),
(28, 'Saturday', b'1', '', ''),
(29, 'Sunday', b'1', '', ''),
(30, 'Monday', b'1', '', ''),
(31, 'Tuesday', b'1', '', ''),
(32, 'Wednesday', b'1', '', ''),
(33, 'Thusday', b'1', '', ''),
(34, 'Friday', b'1', '', ''),
(35, 'Saturday', b'1', '', ''),
(36, 'Sunday', b'1', '', ''),
(37, 'Monday', b'1', '', ''),
(38, 'Tuesday', b'1', '', ''),
(39, 'Wednesday', b'1', '', ''),
(40, 'Thusday', b'1', '', ''),
(41, 'Friday', b'1', '', ''),
(42, 'Saturday', b'1', '', ''),
(43, 'Sunday', b'1', '', ''),
(44, 'Monday', b'1', '', ''),
(45, 'Tuesday', b'1', '', ''),
(46, 'Wednesday', b'1', '', ''),
(47, 'Thusday', b'1', '', ''),
(48, 'Friday', b'1', '', ''),
(49, 'Saturday', b'1', '', ''),
(50, 'Sunday', b'1', '', ''),
(51, 'Monday', b'1', '', ''),
(52, 'Tuesday', b'1', '', ''),
(53, 'Wednesday', b'1', '', ''),
(54, 'Thusday', b'1', '', ''),
(55, 'Friday', b'1', '', ''),
(56, 'Saturday', b'1', '', ''),
(57, 'Sunday', b'1', '', ''),
(58, 'Monday', b'1', '', ''),
(59, 'Tuesday', b'1', '', ''),
(60, 'Wednesday', b'1', '', ''),
(61, 'Thusday', b'1', '', ''),
(62, 'Friday', b'1', '', ''),
(63, 'Saturday', b'1', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `technician`
--

CREATE TABLE IF NOT EXISTS `technician` (
  `technicianID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `status` bit(1) NOT NULL,
  PRIMARY KEY (`technicianID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `technician`
--

INSERT INTO `technician` (`technicianID`, `Name`, `status`) VALUES
(45, 'gufran', b'1'),
(46, 'test', b'1'),
(47, 'test', b'1'),
(48, 'timtim', b'1'),
(49, 'timtim', b'1'),
(50, 'timtim', b'1'),
(51, 'aaa', b'1'),
(52, 'saqib', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `technicianhours`
--

CREATE TABLE IF NOT EXISTS `technicianhours` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `technicianID` int(11) NOT NULL,
  `day` varchar(255) NOT NULL,
  `closeAllDay` tinyint(4) NOT NULL,
  `open` varchar(255) NOT NULL,
  `close` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

--
-- Dumping data for table `technicianhours`
--

INSERT INTO `technicianhours` (`id`, `technicianID`, `day`, `closeAllDay`, `open`, `close`) VALUES
(97, 45, '', 1, '0', '0'),
(98, 46, '', 0, '1', '1'),
(99, 47, '', 0, '1', '1'),
(100, 52, 'Monday', 0, '9:00am', '8:00pm'),
(101, 52, 'Tuesday', 0, '9:00am', '8:00pm'),
(102, 52, 'Wednesday', 0, '9:00am', '8:00pm'),
(103, 52, 'Thusday', 0, '9:00am', '8:00pm'),
(104, 52, 'Friday', 0, '9:00am', '8:00pm'),
(105, 52, 'Saturday', 1, '9:00am', '8:00pm'),
(106, 52, 'Sunday', 1, '9:00am', '8:00pm');

-- --------------------------------------------------------

--
-- Table structure for table `technicianservices`
--

CREATE TABLE IF NOT EXISTS `technicianservices` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `technicianID` int(11) NOT NULL,
  `serviceID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `technician_reserved_hours`
--

CREATE TABLE IF NOT EXISTS `technician_reserved_hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `technicianID` int(11) NOT NULL,
  `technician_reserved_hours` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `technician_reserved_hours`
--

INSERT INTO `technician_reserved_hours` (`id`, `technicianID`, `technician_reserved_hours`) VALUES
(1, 45, '10:00 AM'),
(2, 45, '10:15 AM'),
(3, 45, '10:30 AM');

-- --------------------------------------------------------

--
-- Table structure for table `viprewardshistory`
--

CREATE TABLE IF NOT EXISTS `viprewardshistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberID` int(11) NOT NULL,
  `date` date NOT NULL,
  `rewardPoints` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `viprewardshistory`
--

INSERT INTO `viprewardshistory` (`id`, `memberID`, `date`, `rewardPoints`) VALUES
(1, 1, '2012-08-18', 22);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
