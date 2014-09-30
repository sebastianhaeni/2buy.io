-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2014 at 05:40 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `community`
--

INSERT INTO `community` (`idCommunity`, `name`, `admin`) VALUES
(1, 'Laubegg WG', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
`idProduct` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `inSuggestions` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`idProduct`, `name`, `addedBy`, `inSuggestions`) VALUES
(1, 'Brot', NULL, 1),
(2, 'Milch', NULL, 1),
(3, 'Butter', NULL, 1),
(4, 'Sirup', NULL, 1),
(5, 'Toast', NULL, 1),
(6, 'Abfallsäcke 35L', NULL, 1),
(7, 'Acetto Balsamico', NULL, 1),
(8, 'Alufolie', NULL, 1),
(9, 'Aromat', NULL, 1),
(10, 'Backpapier', NULL, 1),
(11, 'Frischhaltefolie', NULL, 1),
(12, 'Gewürzessig', NULL, 1),
(13, 'WC-Papier', NULL, 1),
(18, 'Haushaltspapier', NULL, 1),
(36, 'Kartoffelstock', NULL, 1),
(37, 'Ketchup', NULL, 1),
(38, 'Knoblauch', NULL, 1),
(39, 'Kräuterbrot', NULL, 1),
(40, 'Mehl', NULL, 1),
(41, 'Mayonaise', NULL, 1),
(42, 'Olivenöl', NULL, 1),
(43, 'Orangensaft', NULL, 1),
(44, 'Pfefferkörner', NULL, 1),
(45, 'Putzbürsteli', NULL, 1),
(46, 'Putzlappen', NULL, 1),
(47, 'Putzmittel', NULL, 1),
(48, 'Putzschwämme', NULL, 1),
(49, 'Rapsöl', NULL, 1),
(50, 'Reibkäse', NULL, 1),
(51, 'Reis', NULL, 1),
(52, 'Risotto', NULL, 1),
(53, 'Salz', NULL, 1),
(54, 'Senf', NULL, 1),
(55, 'Sonnenblumenöl', NULL, 1),
(56, 'Spaghetti', NULL, 1),
(57, 'Staubsaugersäcke', NULL, 1),
(58, 'Tabs', NULL, 1),
(59, 'Teigwaren', NULL, 1),
(60, 'Waschmittel', NULL, 1),
(61, 'WC-Ente', NULL, 1),
(62, 'Zitronenkonzentrat', NULL, 1),
(63, 'Zopf', NULL, 1),
(64, 'Zucker', NULL, 1),
(65, 'Zwiebeln', NULL, 1);

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
  `phone` varchar(16) NOT NULL,
  `receiveUpdates` tinyint(1) NOT NULL DEFAULT '0',
  `receiveSms` tinyint(1) NOT NULL DEFAULT '0',
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `idCommunity`, `name`, `email`, `password`, `phone`, `receiveUpdates`, `receiveSms`, `isAdmin`) VALUES
(1, 1, 'Administrator', 'admin@shoppinglist', '$2y$10$Kph8hEg215iNlolNbOJXDeUakBKSPNMw8CLO9EYyXjzUGE3qk7gKm', '+41 79 123 45 67', 0, 0, 1);

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
 ADD PRIMARY KEY (`idProduct`), ADD UNIQUE KEY `name` (`name`), ADD KEY `addedBy` (`addedBy`);

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
 ADD PRIMARY KEY (`idUser`), ADD KEY `fk_user_community1_idx` (`idCommunity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `community`
--
ALTER TABLE `community`
MODIFY `idCommunity` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `idProduct` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
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
MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
