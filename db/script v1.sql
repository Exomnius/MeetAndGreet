--
-- Databank: `meetAndGreet`
--
DROP DATABASE IF EXISTS `meetAndGreet`;
CREATE DATABASE IF NOT EXISTS `meetAndGreet`;
USE `meetAndGreet`;

CREATE TABLE IF NOT EXISTS `tbl_events` (
	`eventId` int(5) NOT NULL AUTO_INCREMENT,
	`user` int(5) NOT NULL,
	`description` Text,
	`catId` int(5) NOT NULL,
	`latitude` decimal(15,12) NOT NULL,
	`longitude` decimal(15,12) NOT NULL,
	PRIMARY KEY (`eventId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `tbl_eventCategories` (
	`catId` int(5) NOT NULL,
	`categorie` varchar(20) NOT NULL,
	`iconURL` varchar(30),
	PRIMARY KEY (`catId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `address` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `member_since` timestamp DEFAULT CURRENT_TIMESTAMP,
  `profile_pic` varchar(30),
  `about` text NOT NULL,
  `userType` int(2) NOT NULL DEFAULT 1,
  `activation_code` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `tbl_userTypes` (
	`typeId` int(5) NOT NULL AUTO_INCREMENT,
	`type` varchar(20) NOT NULL,
	PRIMARY KEY(`typeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT INTO `tbl_userTypes`(`type`) VALUES
('temporary'),
('registered');

INSERT INTO `tbl_users` (`userId`, `username`, `firstname`, `lastname`, `email`, `password`, `address`, `city`, `dob`, `gender`, `member_since`, `activation_code`, `userType`) VALUES
(1, 'PereGullis', 'Pere', 'Gullis', 'notthevictim@gmail.com', '8c2da486a8b3e78cd123358c4be00c4d', 'Omstraat 34 bus 12', 'Bilzen', '2014-02-06', '0', '2014-02-06 14:41:48', 'TAW9svKz0rosl3A',1),
(2, 'GullisDumfan', 'Gullis', 'Idonknow', 'adsdasdas@hotmail.com', '8c2da486a8b3e78cd123358c4be00c4d', 'Omstraat 34 bus 12', 'Bilzen', '2014-02-12', '0', '2014-02-12 22:42:12', 'JtP0ZMxVrrOaIca',2);

INSERT INTO `tbl_eventCategories` (`catId`, `categorie`, `iconURL`) VALUES
(1, 'temporary', 'c'),
(2, 'registered', 'd');

INSERT INTO `tbl_events` (`user`, `description`, `catId`, `latitude`, `longitude`) VALUES
(1, 'hackathon', 1, 51.059257, 3.720036);


ALTER TABLE `tbl_users`
ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`userType`) REFERENCES `tbl_userTypes` (`typeId`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_events`
ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`catId`) REFERENCES `tbl_eventCategories` (`catId`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`catId`) REFERENCES `tbl_eventCategories` (`catId`) ON DELETE CASCADE ON UPDATE CASCADE;

