-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2014 at 12:58 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `shoppinglist`
--

-- --------------------------------------------------------

--
-- Table structure for table `community`
--

CREATE TABLE IF NOT EXISTS `community` (
  `idCommunity` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`idCommunity`),
  KEY `fk_community_user_idx` (`admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `idProduct` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `inSuggestions` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idProduct`),
  UNIQUE KEY `name` (`name`),
  KEY `addedBy` (`addedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `remember_me_token`
--

CREATE TABLE IF NOT EXISTS `remember_me_token` (
  `idToken` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `userAgent` varchar(150) DEFAULT NULL,
  `timestampCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idToken`),
  KEY `fk_remember_me_token_user1_idx` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

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
  KEY `reportedBy` (`reportedBy`),
  KEY `boughtBy` (`boughtBy`),
  KEY `idProduct` (`idProduct`),
  KEY `cancelledBy` (`cancelledBy`),
  KEY `editedBy` (`editedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `idCommunity` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `receiveUpdates` tinyint(1) NOT NULL DEFAULT '0',
  `receiveSms` tinyint(1) NOT NULL DEFAULT '0',
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_user_community1_idx` (`idCommunity`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `idCommunity`, `name`, `email`, `password`, `phone`, `receiveUpdates`, `receiveSms`, `isAdmin`) VALUES
(0, NULL, 'Administrator', 'admin@shoppinglist', '$2y$10$Kph8hEg215iNlolNbOJXDeUakBKSPNMw8CLO9EYyXjzUGE3qk7gKm', NULL, 0, 0, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `community`
--
ALTER TABLE `community`
  ADD CONSTRAINT `fk_community_user` FOREIGN KEY (`admin`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`addedBy`) REFERENCES `user` (`idUser`);

--
-- Constraints for table `remember_me_token`
--
ALTER TABLE `remember_me_token`
  ADD CONSTRAINT `fk_remember_me_token_user1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`reportedBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`boughtBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`cancelledBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_5` FOREIGN KEY (`editedBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
