-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 10, 2012 at 11:13 PM
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
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `technicianID` int(25) NOT NULL,
  `memberID` int(25) NOT NULL,
  `serviceID` int(25) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`memberID`, `mem_card`, `email`, `password`, `firstName`, `lastName`, `phone`, `address`, `city`, `state`, `zip_code`, `vipMember`) VALUES
(5, NULL, 'jhon@zend.com', 'quick', 'john', 'elia', '234', 'xyz', 'xyz', 'xyz', 234, 0),
(6, NULL, 'zoper@gmail.com', 'quick', 'zoper', 'Studios', '2342', 'xyz', 'xyz', 'skd', 342, 0);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `serviceID` int(25) NOT NULL AUTO_INCREMENT,
  `serviceName` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  PRIMARY KEY (`serviceID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`serviceID`, `serviceName`, `duration`) VALUES
(28, 'Nail: RE Touching', '15 Minutes'),
(29, 'rwr', '15 Minutes'),
(30, 'sdfsdf', '45 Minutes'),
(31, 'Nail: RE Touching', '15 Minutes'),
(32, 'Nail: RE Touching', '15 Minutes'),
(33, 'sdfsdf', '15 Minutes');

-- --------------------------------------------------------

--
-- Table structure for table `shopcustomhours`
--

CREATE TABLE IF NOT EXISTS `shopcustomhours` (
  `ID` int(25) NOT NULL AUTO_INCREMENT,
  `day` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `closeAllDay` bit(1) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `shopcustomhours`
--

INSERT INTO `shopcustomhours` (`ID`, `day`, `date`, `closeAllDay`, `start`, `end`, `comments`) VALUES
(2, '', '2012-08-05', b'1', '3:00pm', '7:00pm', 'sdfs');

-- --------------------------------------------------------

--
-- Table structure for table `shophours`
--

CREATE TABLE IF NOT EXISTS `shophours` (
  `ID` int(25) NOT NULL AUTO_INCREMENT,
  `day` varchar(255) NOT NULL,
  `closeAllDay` bit(1) NOT NULL,
  `open` varchar(255) NOT NULL,
  `close` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `technician`
--

CREATE TABLE IF NOT EXISTS `technician` (
  `technicianID` int(25) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `status` bit(1) NOT NULL,
  PRIMARY KEY (`technicianID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

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
(51, 'aaa', b'1');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `technicianhours`
--

INSERT INTO `technicianhours` (`id`, `technicianID`, `day`, `closeAllDay`, `open`, `close`) VALUES
(97, 45, 'Monday', 1, '0', '0'),
(98, 46, 'Monday', 0, '1', '1'),
(99, 47, 'Monday', 0, '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `technicianservices`
--

CREATE TABLE IF NOT EXISTS `technicianservices` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `technicianID` int(25) NOT NULL,
  `serviceID` int(25) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
