-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 14, 2011 at 02:43 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `team_mgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `leagues`
--

CREATE TABLE IF NOT EXISTS `leagues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `leagues`
--

INSERT INTO `leagues` (`id`, `name`) VALUES
(1, 'Little League'),
(2, 'Big Boys'),
(3, 'Peanut League');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(10) unsigned NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `address` varchar(128) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `state_id` tinyint(3) unsigned DEFAULT NULL,
  `zip` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `team_id`, `first_name`, `last_name`, `address`, `city`, `state_id`, `zip`, `email`, `phone`) VALUES
(1, 1, 'Billy', 'Bob', '', '', 0, '', '', ''),
(2, 2, 'Tom', 'Foolery', '123 Street', 'Big City', 33, '12345', '', ''),
(3, 3, 'Shifty', 'Steve', 'Back Alley', 'Chicago', 14, '54321', 'shifty.steve@scams.com', '(123) 456-7890'),
(4, 4, 'Lefty', 'Jones', 'Long Road', 'West Side', 11, '', '', ''),
(5, 4, 'Sammy', 'Slider', '', '', 0, '', '', ''),
(6, 3, 'Dan', 'Diver', '', '', 0, '', '', ''),
(7, 1, 'Pete', 'Popper', '', '', 0, '', '', ''),
(8, 1, 'Robby', 'Runner', '', '', 0, '', '', ''),
(9, 4, 'Horace', 'Homer', '426 Elm Street', 'New York', 33, '23422', 'horace.homer@superstrikers.com', '(234) 234-2343 ext. 43');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `abbr` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `abbr`) VALUES
(1, 'ALABAMA', 'AL'),
(2, 'ALASKA', 'AK'),
(3, 'ARIZONA', 'AZ'),
(4, 'ARKANSAS', 'AR'),
(5, 'CALIFORNIA', 'CA'),
(6, 'COLORADO', 'CO'),
(7, 'CONNECTICUT', 'CT'),
(8, 'DELAWARE', 'DE'),
(9, 'DISTRICT OF COLUMBIA', 'DC'),
(10, 'FLORIDA', 'FL'),
(11, 'GEORGIA', 'GA'),
(12, 'HAWAII', 'HI'),
(13, 'IDAHO', 'ID'),
(14, 'ILLINOIS', 'IL'),
(15, 'INDIANA', 'IN'),
(16, 'IOWA', 'IA'),
(17, 'KANSAS', 'KS'),
(18, 'KENTUCKY', 'KY'),
(19, 'LOUISIANA', 'LA'),
(20, 'MAINE', 'ME'),
(21, 'MARYLAND', 'MD'),
(22, 'MASSACHUSETTS', 'MA'),
(23, 'MICHIGAN', 'MI'),
(24, 'MINNESOTA', 'MN'),
(25, 'MISSISSIPPI', 'MS'),
(26, 'MISSOURI', 'MO'),
(27, 'MONTANA', 'MT'),
(28, 'NEBRASKA', 'NE'),
(29, 'NEVADA', 'NV'),
(30, 'NEW HAMPSHIRE', 'NH'),
(31, 'NEW JERSEY', 'NJ'),
(32, 'NEW MEXICO', 'NM'),
(33, 'NEW YORK', 'NY'),
(34, 'NORTH CAROLINA', 'NC'),
(35, 'NORTH DAKOTA', 'ND'),
(36, 'OHIO', 'OH'),
(37, 'OKLAHOMA', 'OK'),
(38, 'OREGON', 'OR'),
(39, 'PENNSYLVANIA', 'PA'),
(40, 'RHODE ISLAND', 'RI'),
(41, 'SOUTH CAROLINA', 'SC'),
(42, 'SOUTH DAKOTA', 'SD'),
(43, 'TENNESSEE', 'TN'),
(44, 'TEXAS', 'TX'),
(45, 'UTAH', 'UT'),
(46, 'VERMONT', 'VT'),
(47, 'VIRGINIA', 'VA'),
(48, 'WASHINGTON', 'WA'),
(49, 'WEST VIRGINIA', 'WV'),
(50, 'WISCONSIN', 'WI'),
(51, 'WYOMING', 'WY');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `league_id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `mascot` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `league_id`, `name`, `mascot`) VALUES
(1, 1, 'Tigers', 'Tigger'),
(2, 2, 'Lions', ''),
(3, 3, 'Bears', 'Pooh'),
(4, 2, 'Super Strikers', ''),
(5, 3, 'Little Sluggers', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
