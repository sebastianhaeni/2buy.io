-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2014 at 12:11 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `shoppinglist`
--

-- --------------------------------------------------------

--
-- Table structure for table `community`
--

DROP TABLE IF EXISTS `community`;
CREATE TABLE IF NOT EXISTS `community` (
  `idCommunity` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`idCommunity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `community_has_user`
--

DROP TABLE IF EXISTS `community_has_user`;
CREATE TABLE IF NOT EXISTS `community_has_user` (
  `idCommunity` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `receiveNotifications` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idCommunity`,`idUser`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invite`
--

DROP TABLE IF EXISTS `invite`;
CREATE TABLE IF NOT EXISTS `invite` (
  `idInvite` int(11) NOT NULL AUTO_INCREMENT,
  `idCommunity` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  PRIMARY KEY (`idInvite`),
  KEY `idCommunity` (`idCommunity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `idProduct` int(11) NOT NULL AUTO_INCREMENT,
  `idCommunity` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `inSuggestions` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idProduct`),
  KEY `idCommunity` (`idCommunity`),
  KEY `addedBy` (`addedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `remember_me_token`
--

DROP TABLE IF EXISTS `remember_me_token`;
CREATE TABLE IF NOT EXISTS `remember_me_token` (
  `idToken` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `userAgent` varchar(150) DEFAULT NULL,
  `timestampCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idToken`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `idTransaction` int(11) NOT NULL AUTO_INCREMENT,
  `idProduct` int(11) NOT NULL,
  `reportedBy` int(11) NOT NULL,
  `reportedDate` datetime NOT NULL,
  `editedBy` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `boughtBy` int(11) DEFAULT NULL,
  `cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `cancelledBy` int(11) DEFAULT NULL,
  `closeDate` datetime DEFAULT NULL,
  PRIMARY KEY (`idTransaction`),
  KEY `idProduct` (`idProduct`),
  KEY `reportedBy` (`reportedBy`),
  KEY `editedBy` (`editedBy`),
  KEY `boughtBy` (`boughtBy`),
  KEY `cancelledBy` (`cancelledBy`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `community_has_user`
--
ALTER TABLE `community_has_user`
  ADD CONSTRAINT `community_has_user_ibfk_1` FOREIGN KEY (`idCommunity`) REFERENCES `community` (`idCommunity`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `community_has_user_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invite`
--
ALTER TABLE `invite`
  ADD CONSTRAINT `invite_ibfk_1` FOREIGN KEY (`idCommunity`) REFERENCES `community` (`idCommunity`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`idCommunity`) REFERENCES `community` (`idCommunity`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `remember_me_token`
--
ALTER TABLE `remember_me_token`
  ADD CONSTRAINT `remember_me_token_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_5` FOREIGN KEY (`cancelledBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`reportedBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`editedBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`boughtBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
