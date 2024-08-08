
-- --------------------------------------------------------

--
-- Table structure for table `wine`
--

CREATE TABLE `wine` (
  `wid` int(11) NOT NULL,
  `retailPrice` decimal(6,2) NOT NULL,
  `wholesalePrice` decimal(6,2) NOT NULL,
  `winery` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `color` varchar(30) NOT NULL,
  `date` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `wine`:
--

--
-- Dumping data for table `wine`
--

INSERT INTO `wine` (`wid`, `retailPrice`, `wholesalePrice`, `winery`, `name`, `color`, `date`, `photo`) VALUES
(1, '10.00', '8.00', 'Δουλουφάκης Οινοποιείο', 'CHARDONNAY Λευκός Ξηρός οίνος', 'Λευκό', '2015', 'images/1.jpg'),
(2, '8.00', '6.00', 'Δουλουφάκης Οινοποιείο', 'FEMINA Λευκός Ξηρός οίνος', 'Λευκό', '2013', 'images/2.jpg'),
(3, '7.50', '5.50', 'ALEXAKIS WINERY', 'Malvasia Aromatica', 'Λευκό', '2012', 'images/3.jpg'),
(4, '8.90', '6.90', 'ALEXAKIS WINERY', 'Moscato Sweetheart', 'Λευκό', '2016', 'images/4.jpg'),
(5, '12.00', '10.00', 'Μανουσάκη Οινοποιία', 'Nostos Mourvèdre', 'Κόκκινο', '2015', 'images/5.jpg'),
(6, '13.00', '11.00', 'Αμπελώνες Καραβιτάκη', 'Ελιά Καραβιτάκ', 'Κόκκινο', '2017', 'images/6.jpg'),
(7, '12.30', '10.30', 'Μανουσάκη Οινοποιία', '2 Mazi Red', 'Κόκκινο', '2015', 'images/7.jpg'),
(8, '8.60', '6.60', 'Μανουσάκη Οινοποιία', '2 Mazi Rosé', 'Ροζέ', '2016', 'images/8.jpg'),
(9, '7.80', '5.80', 'Μανουσάκη Οινοποιία', '2 Mazi White', 'Λευκό', '2005', 'images/9.jpg'),
(10, '6.50', '4.50', 'ΜΙΝΩΣ Κρασιά Κρήτης ΑΕ – Οινοποιείο Μηλιαράκη', '35o - 25o Λευκό', 'Λευκό', '2007', 'images/10.jpg'),
(12, '8.70', '6.70', 'ΜΙΝΩΣ Κρασιά Κρήτης ΑΕ – Οινοποιείο Μηλιαράκη', '35ο - 25ο Ερυθρό', 'Κόκκινο', '2014', 'images/11.jpg'),
(14, '13.00', '11.00', 'ΜΙΝΩΣ Κρασιά Κρήτης ΑΕ – Οινοποιείο Μηλιαράκη', '35ο - 25ο Ροζέ', 'Ροζέ', '2013', 'images/12.jpg'),
(15, '15.00', '13.00', 'Οινοποιείο Αφοί Σπ. Μαραγκάκη', '8η Τέχνη', 'Λευκό', '2016', 'images/13.jpg'),
(16, '9.00', '7.00', 'Ρους Οινοποιία Ταμιωλακη', 'Ahinos', 'Λευκό', '2002', 'images/14.jpg'),
(17, '13.30', '11.30', 'Δουλουφάκης Οινοποιείο', 'ALARGO Ερυθρός Ξηρός οίνος', 'Βαθύ κόκκινο χρώμα', '2009', 'images/15.jpg'),
(18, '12.80', '10.80', 'ALEXAKIS WINERY', 'Artis ', 'Κόκκινο', '2015', 'images/16.jpg'),
(19, '12.50', '10.50', 'ALEXAKIS WINERY', 'Artis', 'Λευκό', '2015', 'images/17.jpg'),
(20, '14.00', '12.00', 'Κτήμα Μιχαλάκη', 'CABERNET SAUVIGNON', 'Κόκκινο', '2017', 'images/18.jpg'),
(21, '9.00', '7.00', 'Οινοποιείο Ευφροσύνη', 'CABERNET SAUVIGNON “INDIGO”', 'Κόκκινο', '2014', 'images/19.jpg'),
(22, '14.20', '12.20', 'Ιδαια Οινοποιητική ', 'CABERNET SAUVIGNON, ΙΔΑΙΑ', 'Κόκκινο', '2013', 'images/20.jpg'),
(23, '7.50', '5.50', 'Κτήμα Μιχαλάκη', 'CHARDONNAY', 'Λευκό', '2014', 'images/21.jpg'),
(24, '8.20', '6.20', 'Λυραράκης - ΓΕΑ ΑΕ', 'Λυραράκης Δαφνί \"Ψαράδες', 'Λευκό', '2015', 'images/22.jpg'),
(25, '15.00', '13.00', 'Δουλουφάκης Οινοποιείο', 'DAFNIOS ερυθρός', 'Κόκκινο', '2017', 'images/23.jpg'),
(26, '14.00', '12.00', 'Δουλουφάκης Οινοποιείο', 'DAFNIOS λευκός', 'Λευκό', '2012', 'images/24.jpg'),
(27, '14.70', '12.70', 'Silva Δασκαλάκη', 'Emphasis Ερυθρό', 'Κόκκινο', '2013', 'images/25.jpg'),
(28, '16.00', '14.00', 'Silva Δασκαλάκη', 'Emphasis Λευκό', 'Λευκό', '2013', 'images/26.jpg'),
(29, '13.70', '11.70', 'Κτήμα Μιχαλάκη', 'LATO ΡΟΖΕ', 'Ροζέ', '2016', 'images/27.jpg'),
(30, '15.70', '13.70', 'Κτήμα Μιχαλάκη', 'LE MANOIR ΡΟΖΕ ΜΙΧΑΛΑΚΗ', 'Ροζέ', '2011', 'images/28.jpg'),
(31, '12.50', '10.50', 'Δουλουφάκης Οινοποιείο', 'ENOTRIA ροζέ', 'Ροζέ', '2002', 'images/29.jpg');

--
-- Triggers `wine`
--
DELIMITER $$
CREATE TRIGGER `wine_domain_constraints` BEFORE INSERT ON `wine` FOR EACH ROW BEGIN
IF NEW.retailPrice <= 0 THEN
	signal sqlstate '45000' set message_text = 'Negative retail price!';
END IF;
IF NEW.wholesalePrice <= 0 THEN
	signal sqlstate '45000' set message_text = 'Negative wholesale price!';
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `wine_update_constraints` BEFORE UPDATE ON `wine` FOR EACH ROW BEGIN
IF NEW.retailPrice <= 0 THEN
	signal sqlstate '45000' set message_text = 'Negative retail price!';
END IF;
IF NEW.wholesalePrice <= 0 THEN
	signal sqlstate '45000' set message_text = 'Negative wholesale price!';
END IF;
IF NEW.wid != OLD.wid THEN
	signal sqlstate '45000' set message_text = 'Wine id cannot be changed';
END IF;
END
$$
DELIMITER ;
