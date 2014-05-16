-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2014 at 07:10 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `meetandgreet`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_eventcategories`
--

CREATE TABLE IF NOT EXISTS `tbl_eventcategories` (
  `catId` int(5) NOT NULL,
  `categorie` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `iconURL` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`catId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_eventcategories`
--

INSERT INTO `tbl_eventcategories` (`catId`, `categorie`, `iconURL`) VALUES
(1, 'Other', 'pin-other'),
(2, 'Food', 'pin-food'),
(3, 'Drinks', 'pin-drinks'),
(4, 'Sports', 'pin-sports'),
(5, 'Party', 'pin-party'),
(6, 'Socialize', 'pin-social');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE IF NOT EXISTS `tbl_events` (
  `eventId` int(5) NOT NULL AUTO_INCREMENT,
  `eventName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user` int(5) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `catId` int(5) NOT NULL,
  `startTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visibility` int(5) DEFAULT NULL,
  `latitude` decimal(15,12) NOT NULL,
  `longitude` decimal(15,12) NOT NULL,
  PRIMARY KEY (`eventId`),
  KEY `events_ibfk_2` (`visibility`),
  KEY `events_ibfk_3` (`catId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`eventId`, `eventName`, `user`, `description`, `catId`, `startTime`, `visibility`, `latitude`, `longitude`) VALUES
(1, '', 1, 'hackathon', 1, '2014-05-16 00:41:41', NULL, '51.059257000000', '3.720036000000'),
(2, 'hackathon', 5, 'safdfs', 1, '2014-05-16 04:13:54', NULL, '51.054342200000', '3.717424300000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_eventsusers`
--

CREATE TABLE IF NOT EXISTS `tbl_eventsusers` (
  `eventId` int(5) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`eventId`,`userId`),
  KEY `eventsusers_ibfk_2` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_eventsusers`
--

INSERT INTO `tbl_eventsusers` (`eventId`, `userId`) VALUES
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_friends`
--

CREATE TABLE IF NOT EXISTS `tbl_friends` (
  `userId` int(11) NOT NULL DEFAULT '0',
  `friendId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`,`friendId`),
  KEY `friends_ibfk_2` (`friendId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_friends`
--

INSERT INTO `tbl_friends` (`userId`, `friendId`) VALUES
(5, 1),
(1, 2),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_levels`
--

CREATE TABLE IF NOT EXISTS `tbl_levels` (
  `level` int(5) NOT NULL AUTO_INCREMENT,
  `expRequired` int(10) NOT NULL,
  `title` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`level`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_levels`
--

INSERT INTO `tbl_levels` (`level`, `expRequired`, `title`) VALUES
(1, 10, 'Forever alone'),
(2, 25, 'Socialy awkward pinguin'),
(3, 62, 'Human being'),
(4, 156, 'Succes kid'),
(5, 390, 'Overly attatched'),
(6, 976, 'Creeper');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE IF NOT EXISTS `tbl_messages` (
  `msgId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `receiverId` int(10) unsigned NOT NULL,
  `message` varchar(255) NOT NULL,
  `senderId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`msgId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_messages`
--

INSERT INTO `tbl_messages` (`msgId`, `receiverId`, `message`, `senderId`) VALUES
(1, 5, 'Testing messages super duper looooooooooooooooooooooooooooong message', 1),
(2, 5, 'Numba 2', 2),
(5, 5, 'Hi! I joined your event!', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_pic` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  `exp` int(10) NOT NULL,
  `userType` int(2) NOT NULL DEFAULT '1',
  `latitude` decimal(15,12) NOT NULL,
  `longitude` decimal(15,12) NOT NULL,
  `last_login` datetime NOT NULL,
  PRIMARY KEY (`userId`),
  KEY `users_ibfk_1` (`userType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userId`, `username`, `firstname`, `lastname`, `email`, `password`, `address`, `city`, `dob`, `gender`, `member_since`, `profile_pic`, `about`, `exp`, `userType`, `latitude`, `longitude`, `last_login`) VALUES
(1, 'PereGullis', 'Pere', 'Gullis', 'notthevictim@gmail.com', '8c2da486a8b3e78cd123358c4be00c4d', 'Omstraat 34 bus 12', 'Bilzen', '2014-02-06', '0', '2014-02-06 13:41:48', NULL, '', 0, 1, '51.059257000000', '3.721036000000', '2014-05-16 00:00:00'),
(2, 'GullisDumfan', 'Gullis', 'Idonknow', 'adsdasdas@hotmail.com', '8c2da486a8b3e78cd123358c4be00c4d', 'Omstraat 34 bus 12', 'Bilzen', '2014-02-12', '0', '2014-02-12 21:42:12', NULL, '', 0, 1, '0.000000000000', '0.000000000000', '0000-00-00 00:00:00'),
(3, 'CornelJanssen', 'Cornel', 'Janssen', 'iets@iets.iets', '402bebba1c63fd382b68ee2f148586a1', 'Omstraat 34 bus 12', 'Bilzen', '2014-02-12', '0', '2014-02-12 21:42:12', NULL, '', 0, 1, '0.000000000000', '0.000000000000', '0000-00-00 00:00:00'),
(4, 'NickThoelen', 'Cornel', 'Janssen', 'iets@iets.iets', '402bebba1c63fd382b68ee2f148586a1', 'Omstraat 34 bus 12', 'Bilzen', '2014-02-12', '0', '2014-02-12 21:42:12', NULL, '', 0, 1, '0.000000000000', '0.000000000000', '0000-00-00 00:00:00'),
(5, 'arno', 'Cornel', 'Janssen', 'iets@iets.iets', '402bebba1c63fd382b68ee2f148586a1', 'Omstraat 34 bus 12', 'Bilzen', '2014-02-12', '0', '2014-02-12 21:42:12', NULL, '', 0, 1, '51.031792000000', '3.702029500000', '2014-05-16 07:07:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usertypes`
--

CREATE TABLE IF NOT EXISTS `tbl_usertypes` (
  `typeId` int(5) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`typeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_usertypes`
--

INSERT INTO `tbl_usertypes` (`typeId`, `type`) VALUES
(1, 'temporary'),
(2, 'registered');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_visibility`
--

CREATE TABLE IF NOT EXISTS `tbl_visibility` (
  `visibilityId` int(5) NOT NULL AUTO_INCREMENT,
  `description` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`visibilityId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_visibility`
--

INSERT INTO `tbl_visibility` (`visibilityId`, `description`) VALUES
(1, 'Public'),
(2, 'Friends only');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`catId`) REFERENCES `tbl_eventcategories` (`catId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`visibility`) REFERENCES `tbl_visibility` (`visibilityId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `events_ibfk_3` FOREIGN KEY (`catId`) REFERENCES `tbl_eventcategories` (`catId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_eventsusers`
--
ALTER TABLE `tbl_eventsusers`
  ADD CONSTRAINT `eventsusers_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `tbl_events` (`eventId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eventsusers_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `tbl_users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_friends`
--
ALTER TABLE `tbl_friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `tbl_users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friendId`) REFERENCES `tbl_users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`userType`) REFERENCES `tbl_usertypes` (`typeId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
