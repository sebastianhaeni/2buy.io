-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2014 at 11:20 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

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
`idCommunity` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
`idProduct` int(11) NOT NULL,
  `idCommunity` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `inSuggestions` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `remember_me_token`
--

DROP TABLE IF EXISTS `remember_me_token`;
CREATE TABLE IF NOT EXISTS `remember_me_token` (
`idToken` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `userAgent` varchar(150) DEFAULT NULL,
  `timestampCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
`idTransaction` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `reportedBy` int(11) NOT NULL,
  `reportedDate` datetime NOT NULL,
  `editedBy` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `boughtBy` int(11) DEFAULT NULL,
  `cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `cancelledBy` int(11) DEFAULT NULL,
  `closeDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
`idUser` int(11) NOT NULL,
  `idCommunity` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `receiveUpdates` tinyint(1) NOT NULL DEFAULT '0',
  `receiveSms` tinyint(1) NOT NULL DEFAULT '0',
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `idCommunity`, `name`, `email`, `password`, `phone`, `receiveUpdates`, `receiveSms`, `isAdmin`) VALUES
(0, NULL, 'Administrator', 'admin@shoppinglist', '$2y$10$Kph8hEg215iNlolNbOJXDeUakBKSPNMw8CLO9EYyXjzUGE3qk7gKm', NULL, 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `community`
--
ALTER TABLE `community`
 ADD PRIMARY KEY (`idCommunity`), ADD KEY `fk_community_user_idx` (`admin`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`idProduct`), ADD UNIQUE KEY `name` (`name`), ADD KEY `addedBy` (`addedBy`), ADD KEY `idCommunity` (`idCommunity`);

--
-- Indexes for table `remember_me_token`
--
ALTER TABLE `remember_me_token`
 ADD PRIMARY KEY (`idToken`), ADD KEY `fk_remember_me_token_user1_idx` (`idUser`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
 ADD PRIMARY KEY (`idTransaction`), ADD KEY `reportedBy` (`reportedBy`), ADD KEY `boughtBy` (`boughtBy`), ADD KEY `idProduct` (`idProduct`), ADD KEY `cancelledBy` (`cancelledBy`), ADD KEY `editedBy` (`editedBy`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`idUser`), ADD UNIQUE KEY `email` (`email`), ADD KEY `fk_user_community1_idx` (`idCommunity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `community`
--
ALTER TABLE `community`
MODIFY `idCommunity` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `idProduct` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `remember_me_token`
--
ALTER TABLE `remember_me_token`
MODIFY `idToken` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
MODIFY `idTransaction` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `community`
--
ALTER TABLE `community`
ADD CONSTRAINT `fk_community_user` FOREIGN KEY (`admin`) REFERENCES `user` (`idUser`) ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`addedBy`) REFERENCES `user` (`idUser`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`idCommunity`) REFERENCES `community` (`idCommunity`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `remember_me_token`
--
ALTER TABLE `remember_me_token`
ADD CONSTRAINT `fk_remember_me_token_user1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`reportedBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`boughtBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`cancelledBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `transaction_ibfk_5` FOREIGN KEY (`editedBy`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idCommunity`) REFERENCES `community` (`idCommunity`) ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
