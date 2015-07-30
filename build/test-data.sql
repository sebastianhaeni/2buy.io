--
-- Database: `2buy`
--

--
-- Dumping data for table `community`
--

INSERT INTO `community` (`idCommunity`, `name`) VALUES
(1, 'Laubegg WG');

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `name`, `email`, `password`, `phone`) VALUES
(1, 'Administrator', 'admin@2buy.io', '$2y$10$Kph8hEg215iNlolNbOJXDeUakBKSPNMw8CLO9EYyXjzUGE3qk7gKm', NULL);

--
-- Dumping data for table `community_has_user`
--

INSERT INTO `community_has_user` (`idCommunity`, `idUser`, `admin`, `receiveNotifications`) VALUES
(1, 1, 1, 1);

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`idProduct`, `idCommunity`, `name`, `addedBy`, `inSuggestions`) VALUES
(1, 1, 'Brot', NULL, 1),
(2, 1, 'Milch', NULL, 1),
(3, 1, 'Butter', NULL, 1),
(4, 1, 'Sirup', NULL, 1),
(5, 1, 'Toast', NULL, 1),
(6, 1, 'Abfallsäcke 35L', NULL, 1),
(7, 1, 'Acetto Balsamico', NULL, 1),
(8, 1, 'Alufolie', NULL, 1),
(9, 1, 'Aromat', NULL, 1),
(10, 1, 'Backpapier', NULL, 1),
(11, 1, 'Frischhaltefolie', NULL, 1),
(12, 1, 'Gewürzessig', NULL, 1),
(13, 1, 'WC-Papier', NULL, 1),
(18, 1, 'Haushaltspapier', NULL, 1),
(36, 1, 'Kartoffelstock', NULL, 1),
(37, 1, 'Ketchup', NULL, 1),
(38, 1, 'Knoblauch', NULL, 1),
(39, 1, 'Kräuterbrot', NULL, 1),
(40, 1, 'Mehl', NULL, 1),
(41, 1, 'Mayonaise', NULL, 1),
(42, 1, 'Olivenöl', NULL, 1),
(43, 1, 'Orangensaft', NULL, 1),
(44, 1, 'Pfefferkörner', NULL, 1),
(45, 1, 'Putzbürsteli', NULL, 1),
(46, 1, 'Putzlappen', NULL, 1),
(47, 1, 'Putzmittel', NULL, 1),
(48, 1, 'Putzschwämme', NULL, 1),
(49, 1, 'Rapsöl', NULL, 1),
(50, 1, 'Reibkäse', NULL, 1),
(51, 1, 'Reis', NULL, 1),
(52, 1, 'Risotto', NULL, 1),
(53, 1, 'Salz', NULL, 1),
(54, 1, 'Senf', NULL, 1),
(55, 1, 'Sonnenblumenöl', NULL, 1),
(56, 1, 'Spaghetti', NULL, 1),
(57, 1, 'Staubsaugersäcke', NULL, 1),
(58, 1, 'Tabs', NULL, 1),
(59, 1, 'Teigwaren', NULL, 1),
(60, 1, 'Waschmittel', NULL, 1),
(61, 1, 'WC-Ente', NULL, 1),
(62, 1, 'Zitronenkonzentrat', NULL, 1),
(63, 1, 'Zopf', NULL, 1),
(64, 1, 'Zucker', NULL, 1),
(65, 1, 'Zwiebeln', NULL, 1),
(66, 1, 'Entkalkungsmittel Kaffeemaschine', 1, 1),
(67, 1, 'Nesquick (Cacao)', 2, 1),
(69, 1, 'Maggi', 2, 1),
(72, 1, 'Bouillon', 2, 1);
