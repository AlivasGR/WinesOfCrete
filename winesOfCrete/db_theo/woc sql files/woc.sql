-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2018 at 04:40 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `woc`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `mid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`mid`) VALUES
(3),
(8);

--
-- Triggers `client`
--
DELIMITER $$
CREATE TRIGGER `client_update_constraints` BEFORE UPDATE ON `client` FOR EACH ROW BEGIN
IF NEW.mid != OLD.mid THEN
	signal sqlstate '45000' set message_text = 'Member id cannot be changed';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `mid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `address` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `debt` decimal(6,2) NOT NULL,
  `totalMoneySpent` decimal(6,2) NOT NULL,
  `cardno` varchar(19) NOT NULL,
  `balance` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`mid`, `username`, `password`, `fname`, `lname`, `tel`, `address`, `city`, `country`, `debt`, `totalMoneySpent`, `cardno`, `balance`) VALUES
(1, 'AlivasGR', '2ea773bcbb3d8beb860430c807ef5d9a', 'Anastasis', 'Livanidis', '1234567890', 'Paroikia', 'Paros', 'GR', '62.75', '4752.03', '1234-5678-9012-3456', '3459.75'),
(3, 'geomlyd', 'e31179c08d2235e0377a57cd484278b1', 'George', 'Lydakis', '2810233472', 'Patelarou 2', 'Heraklion', 'GR', '0.00', '0.00', '1234-5678-9012-3456', '0.00'),
(8, 'spyros', 'dfc8f6b72827a2ae85f505269aff304c', 'spyros', 'lydakis', '2810233472', 'ghfdjhfjx', 'Heraklion', 'GR', '0.00', '0.00', '1234-5678-9012-3456', '0.00'),
(9, 'manosgior', '12b7062b71147da5fcfeafbb6bf4bbea', 'Manos', 'Giortamis', '1111111111', 'Papandreou', 'Heraklion', 'GR', '0.00', '769.38', '1111-1111-1111-1111', '866.42');

--
-- Triggers `member`
--
DELIMITER $$
CREATE TRIGGER `member_delete_constraints` BEFORE DELETE ON `member` FOR EACH ROW BEGIN
IF OLD.debt != 0 THEN
	signal sqlstate '45000' set message_text = 'Cannot delete a member with debt';
END IF;
IF EXISTS(SELECT state FROM order_t o WHERE o.mid = OLD.mid AND o.state != 'DELIVERED') THEN
	signal sqlstate '45000' set message_text = 'Cannot delete a member with undelivered orders';
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `member_domain_constraints` BEFORE INSERT ON `member` FOR EACH ROW BEGIN
IF (NEW.tel REGEXP '[0-9]{10}') = 0 THEN
	signal sqlstate '45000' set message_text = 'Invalid phone number!';
END IF;
IF NEW.debt != 0 THEN
	SET NEW.debt = 0;
END IF;
IF NEW.totalMoneySpent != 0 THEN
	SET NEW.totalMoneySpent = 0;
END IF;
IF NEW.balance != 0 THEN
	SET NEW.balance = 0;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `member_update_constraints` BEFORE UPDATE ON `member` FOR EACH ROW BEGIN
IF (NEW.tel REGEXP '[0-9]{10}') = 0 THEN
	signal sqlstate '45000' set message_text = 'Invalid phone number!';
END IF;
IF NEW.debt < 0 THEN
	signal sqlstate '45000' set message_text = 'Invalid debt!';
END IF;
IF NEW.totalMoneySpent < 0 THEN
	signal sqlstate '45000' set message_text = 'Invalid total money spent for member!';
END IF;
IF NEW.mid != OLD.mid THEN
	signal sqlstate '45000' set message_text = 'Member id cannot be changed';
END IF;
IF NEW.username != OLD.username THEN
	signal sqlstate '45000' set message_text = 'Username cannot be changed';
END IF;
IF NEW.balance < 0 THEN
	signal sqlstate '45000' set message_text = 'Negative balance!';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `mid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`mid`) VALUES
(1),
(9);

--
-- Triggers `merchant`
--
DELIMITER $$
CREATE TRIGGER `merchant_update_constraints` BEFORE UPDATE ON `merchant` FOR EACH ROW BEGIN
IF NEW.mid != OLD.mid THEN
	signal sqlstate '45000' set message_text = 'Member id cannot be changed';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `mostpopularwines`
--

CREATE TABLE `mostpopularwines` (
  `wid` int(11) NOT NULL,
  `bottlesThisMonth` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mostpopularwines`
--

INSERT INTO `mostpopularwines` (`wid`, `bottlesThisMonth`) VALUES
(1, 232),
(2, 41),
(3, 312),
(4, 6),
(5, 6),
(6, 6),
(7, 15),
(16, 6),
(19, 6),
(20, 6),
(25, 6);

--
-- Triggers `mostpopularwines`
--
DELIMITER $$
CREATE TRIGGER `mostpopularwines_domain_constraints` BEFORE INSERT ON `mostpopularwines` FOR EACH ROW BEGIN
IF NEW.bottlesThisMonth <= 0 THEN
	signal sqlstate '45000' set message_text = 'Negative amount of bottles!';
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `mostpopularwines_update_constraints` BEFORE UPDATE ON `mostpopularwines` FOR EACH ROW BEGIN
IF NEW.bottlesThisMonth != OLD.bottlesThisMonth THEN
	signal sqlstate '45000' set message_text = 'Can''t change number of bottles in mostpopularwines after creation';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `orderconsistsofwine`
--

CREATE TABLE `orderconsistsofwine` (
  `oid` int(11) NOT NULL,
  `wid` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderconsistsofwine`
--

INSERT INTO `orderconsistsofwine` (`oid`, `wid`, `amount`) VALUES
(24, 5, 6),
(24, 6, 6),
(24, 20, 6),
(25, 3, 278),
(25, 4, 6),
(25, 7, 6),
(26, 1, 3),
(26, 3, 5),
(26, 7, 4),
(27, 1, 5),
(27, 3, 5),
(27, 7, 5),
(28, 1, 5),
(30, 16, 6),
(30, 19, 6),
(30, 25, 6),
(31, 1, 12),
(31, 2, 12),
(31, 3, 12),
(32, 1, 7),
(32, 2, 9),
(32, 3, 12),
(33, 1, 100),
(33, 2, 20),
(34, 1, 100),
(38, 1, 6),
(38, 2, 6),
(38, 3, 6),
(40, 4, 6),
(40, 6, 12),
(40, 10, 8),
(41, 26, 6),
(41, 30, 6),
(41, 31, 6),
(42, 21, 20),
(42, 25, 15),
(42, 28, 20),
(43, 6, 15),
(43, 24, 20),
(43, 30, 20),
(44, 6, 6),
(44, 8, 10),
(44, 9, 8);

--
-- Triggers `orderconsistsofwine`
--
DELIMITER $$
CREATE TRIGGER `orderconsistsofwine_domain_constraints` BEFORE INSERT ON `orderconsistsofwine` FOR EACH ROW BEGIN
IF NEW.amount <= 0 THEN
	signal sqlstate '45000' set message_text = 'Negative amount of bottles!';
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `orderconsistsofwine_update_constraints` BEFORE UPDATE ON `orderconsistsofwine` FOR EACH ROW BEGIN
IF NEW.amount < 0 THEN
	signal sqlstate '45000' set message_text = 'Negative amount of bottles!';
END IF;
IF NEW.amount > OLD.amount  THEN
	signal sqlstate '45000' set message_text = 'Cannot increase order''s bottles after submission';
END IF; 
IF NEW.oid != OLD.oid THEN
	signal sqlstate '45000' set message_text = 'Cannot change order id after creation of order';
END IF;
IF NEW.oid != OLD.oid THEN
	signal sqlstate '45000' set message_text = 'Cannot change order id after creation of order';
END IF;
IF NEW.wid != OLD.wid THEN
	signal sqlstate '45000' set message_text = 'Cannot change id of wine referred by order after creation of order';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order_t`
--

CREATE TABLE `order_t` (
  `oid` int(11) NOT NULL,
  `mid` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `cost` decimal(6,2) NOT NULL,
  `discount` int(11) NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_t`
--

INSERT INTO `order_t` (`oid`, `mid`, `date`, `cost`, `discount`, `state`) VALUES
(24, 1, '2017-12-31 10:47:00', '198.00', 0, 'DELIVERED'),
(25, 1, '2017-12-31 11:10:46', '1468.98', 10, 'DELIVERED'),
(26, NULL, '2017-12-31 11:18:48', '116.70', 0, 'DELIVERED'),
(27, NULL, '2017-12-31 11:43:55', '149.00', 0, 'DELIVERED'),
(28, NULL, '2017-12-31 11:46:27', '50.00', 0, 'DELIVERED'),
(30, 1, '2017-12-31 18:07:17', '183.00', 0, 'DELIVERED'),
(31, 1, '2017-12-31 18:09:20', '234.00', 0, 'DELIVERED'),
(32, 1, '2017-12-31 18:10:42', '176.00', 0, 'DELIVERED'),
(33, NULL, '2017-12-31 18:16:44', '1160.00', 0, 'DELIVERED'),
(34, NULL, '2017-12-31 18:18:17', '1000.00', 0, 'DELIVERED'),
(35, NULL, '2017-12-31 17:00:00', '800.00', 0, 'AWAITING_PAYMENT'),
(36, 8, '2017-12-31 20:00:00', '200.00', 0, 'DELIVERED'),
(37, 8, '2017-12-31 20:00:00', '300.00', 0, 'AWAITING_PAYMENT'),
(38, 9, '2018-01-01 17:11:52', '117.00', 0, 'DELIVERED'),
(40, 9, '2018-01-01 17:17:49', '209.40', 0, 'FULLY_PAID'),
(41, 1, '2018-01-01 17:27:32', '217.20', 0, 'AWAITING_PAYMENT'),
(42, 1, '2018-01-01 17:30:13', '553.50', 10, 'FULLY_PAID'),
(43, 1, '2018-01-01 17:36:22', '506.70', 10, 'AWAITING_PAYMENT'),
(44, 9, '2018-01-01 17:36:57', '178.40', 0, 'FULLY_PAID');

--
-- Triggers `order_t`
--
DELIMITER $$
CREATE TRIGGER `order_t_update_constraints` BEFORE UPDATE ON `order_t` FOR EACH ROW BEGIN
IF NEW.oid != OLD.oid THEN
	signal sqlstate '45000' set message_text = 'Cannot change order id after creation of order';
END IF;
IF NEW.mid != OLD.mid THEN
	signal sqlstate '45000' set message_text = 'Cannot change member id referred to by order after creation of order';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `oid` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`oid`, `type`, `amount`, `date`) VALUES
(24, 'PAYMENT', '198.00', '2017-12-31 10:47:00'),
(25, 'PAYMENT', '1000.00', '2017-12-31 11:10:46'),
(25, 'PAYMENT', '0.10', '2017-12-31 11:11:11'),
(25, 'PAYMENT', '0.01', '2017-12-31 11:12:27'),
(25, 'REFUND', '4.95', '2017-12-31 11:12:51'),
(25, 'PAYMENT', '577.77', '2017-12-31 11:13:19'),
(25, 'REFUND', '24.75', '2017-12-31 18:18:46'),
(25, 'REFUND', '9.90', '2017-12-31 18:22:48'),
(25, 'REFUND', '4.95', '2017-12-31 18:33:41'),
(25, 'REFUND', '4.95', '2017-12-31 18:35:18'),
(25, 'REFUND', '4.95', '2017-12-31 18:36:21'),
(26, 'PAYMENT', '10.00', '2017-12-31 11:18:48'),
(26, 'PAYMENT', '106.70', '2017-12-31 11:19:12'),
(27, 'PAYMENT', '149.00', '2017-12-31 11:43:55'),
(28, 'PAYMENT', '50.00', '2017-12-31 11:46:27'),
(30, 'PAYMENT', '183.00', '2017-12-31 18:07:17'),
(31, 'PAYMENT', '100.00', '2017-12-31 18:09:20'),
(31, 'PAYMENT', '134.00', '2017-12-31 19:15:11'),
(32, 'PAYMENT', '40.00', '2017-12-31 18:10:42'),
(32, 'PAYMENT', '136.00', '2017-12-31 19:14:49'),
(33, 'PAYMENT', '1000.00', '2017-12-31 18:16:44'),
(33, 'PAYMENT', '160.00', '2017-12-31 18:50:50'),
(34, 'PAYMENT', '500.00', '2017-12-31 18:18:17'),
(34, 'PAYMENT', '500.00', '2017-12-31 18:50:13'),
(38, 'PAYMENT', '100.00', '2018-01-01 17:11:52'),
(38, 'PAYMENT', '17.00', '2018-01-01 17:13:55'),
(40, 'PAYMENT', '100.00', '2018-01-01 17:17:49'),
(40, 'PAYMENT', '50.00', '2018-01-01 17:18:06'),
(40, 'REFUND', '27.60', '2018-01-01 17:21:07'),
(40, 'PAYMENT', '87.00', '2018-01-01 17:35:11'),
(41, 'PAYMENT', '100.00', '2018-01-01 17:27:32'),
(42, 'PAYMENT', '100.00', '2018-01-01 17:30:13'),
(42, 'REFUND', '58.50', '2018-01-01 17:31:44'),
(42, 'PAYMENT', '512.00', '2018-01-01 17:35:23'),
(43, 'PAYMENT', '100.00', '2018-01-01 17:36:22'),
(43, 'REFUND', '49.50', '2018-01-01 17:37:13'),
(43, 'PAYMENT', '456.20', '2018-01-01 17:37:55'),
(44, 'PAYMENT', '200.00', '2018-01-01 17:36:57'),
(44, 'PAYMENT', '20.00', '2018-01-01 17:37:15'),
(44, 'REFUND', '66.00', '2018-01-01 17:37:53'),
(44, 'PAYMENT', '24.40', '2018-01-01 17:38:18');

--
-- Triggers `transactions`
--
DELIMITER $$
CREATE TRIGGER `transactions_domain_constraints` BEFORE INSERT ON `transactions` FOR EACH ROW BEGIN
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `variety`
--

CREATE TABLE `variety` (
  `vid` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `variety`
--

INSERT INTO `variety` (`vid`, `name`) VALUES
(12, 'Cabernet Sauvignon'),
(13, 'Chardonnay'),
(14, 'Merlot'),
(18, 'Roussanne'),
(17, 'Sangiovese'),
(15, 'Sauvignon Blanc'),
(16, 'Syrah'),
(1, 'Βηλάνα'),
(2, 'Βιδιανό'),
(3, 'Δαφνί'),
(4, 'Θραψαθήρι'),
(5, 'Κοτσιφάλι'),
(6, 'Λιάτικο'),
(7, 'Μαλβαζία'),
(8, 'Μαντηλάρι'),
(9, 'Μοσχάτο Λευκό'),
(10, 'Πλυτό'),
(11, 'Ρωμέικο');

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

-- --------------------------------------------------------

--
-- Table structure for table `winemadeofvariety`
--

CREATE TABLE `winemadeofvariety` (
  `wid` int(11) NOT NULL,
  `vid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `winemadeofvariety`
--

INSERT INTO `winemadeofvariety` (`wid`, `vid`) VALUES
(1, 13),
(2, 7),
(3, 7),
(4, 7),
(4, 9),
(5, 5),
(6, 16),
(7, 8),
(7, 11),
(8, 8),
(8, 11),
(9, 1),
(9, 18),
(10, 1),
(10, 4),
(12, 5),
(12, 8),
(12, 16),
(14, 5),
(14, 16),
(15, 2),
(16, 15),
(17, 16),
(18, 5),
(19, 2),
(19, 9),
(20, 12),
(21, 12),
(22, 12),
(23, 12),
(24, 3),
(25, 6),
(26, 2),
(27, 8),
(27, 12),
(28, 10),
(28, 15),
(29, 5),
(29, 8),
(30, 5),
(30, 8),
(31, 5),
(31, 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `mostpopularwines`
--
ALTER TABLE `mostpopularwines`
  ADD PRIMARY KEY (`wid`);

--
-- Indexes for table `orderconsistsofwine`
--
ALTER TABLE `orderconsistsofwine`
  ADD PRIMARY KEY (`oid`,`wid`),
  ADD KEY `FK_order` (`oid`),
  ADD KEY `FK_Wine` (`wid`);

--
-- Indexes for table `order_t`
--
ALTER TABLE `order_t`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `FK_Order_t_Member` (`mid`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`oid`,`date`),
  ADD KEY `FK_Payment_Order` (`oid`);

--
-- Indexes for table `variety`
--
ALTER TABLE `variety`
  ADD PRIMARY KEY (`vid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `wine`
--
ALTER TABLE `wine`
  ADD PRIMARY KEY (`wid`);

--
-- Indexes for table `winemadeofvariety`
--
ALTER TABLE `winemadeofvariety`
  ADD PRIMARY KEY (`wid`,`vid`),
  ADD KEY `FK_Variety` (`vid`),
  ADD KEY `FK_WineMadeOfVariety_Wine` (`wid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_t`
--
ALTER TABLE `order_t`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `variety`
--
ALTER TABLE `variety`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `wine`
--
ALTER TABLE `wine`
  MODIFY `wid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_Client_Member` FOREIGN KEY (`mid`) REFERENCES `member` (`mid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `merchant`
--
ALTER TABLE `merchant`
  ADD CONSTRAINT `FK_Merchant_Member` FOREIGN KEY (`mid`) REFERENCES `member` (`mid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mostpopularwines`
--
ALTER TABLE `mostpopularwines`
  ADD CONSTRAINT `FK_MostPopularWines` FOREIGN KEY (`wid`) REFERENCES `wine` (`wid`);

--
-- Constraints for table `orderconsistsofwine`
--
ALTER TABLE `orderconsistsofwine`
  ADD CONSTRAINT `FK_Wine` FOREIGN KEY (`wid`) REFERENCES `wine` (`wid`),
  ADD CONSTRAINT `FK_order` FOREIGN KEY (`oid`) REFERENCES `order_t` (`oid`) ON DELETE CASCADE;

--
-- Constraints for table `order_t`
--
ALTER TABLE `order_t`
  ADD CONSTRAINT `FK_Order_t_Member` FOREIGN KEY (`mid`) REFERENCES `member` (`mid`) ON DELETE SET NULL;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `FK_Payment_Order` FOREIGN KEY (`oid`) REFERENCES `order_t` (`oid`) ON DELETE CASCADE;

--
-- Constraints for table `winemadeofvariety`
--
ALTER TABLE `winemadeofvariety`
  ADD CONSTRAINT `FK_Variety` FOREIGN KEY (`vid`) REFERENCES `variety` (`vid`),
  ADD CONSTRAINT `FK_WineMadeOfVariety_Wine` FOREIGN KEY (`wid`) REFERENCES `wine` (`wid`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `update_most_popular_wines` ON SCHEDULE EVERY 1 MONTH STARTS '2018-01-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE
FROM
    mostpopularwines;
INSERT INTO mostpopularwines(
    SELECT
        wine.wid,
        SUM(amount)
    FROM
        wine,
        orderconsistsofwine,
    	order_t
    WHERE
        order_t.oid = orderconsistsofwine.oid and wine.wid = orderconsistsofwine.wid and (MONTH(CURDATE()) - MONTH(order_t.date) = 1 or MONTH(CURRENT_DATE) - MONTH(order_t.date) = -11)
    GROUP BY
        orderconsistsofwine.wid
);
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
