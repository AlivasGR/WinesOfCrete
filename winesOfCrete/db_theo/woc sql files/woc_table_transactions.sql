
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
-- RELATIONSHIPS FOR TABLE `transactions`:
--   `oid`
--       `order_t` -> `oid`
--

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
(41, 'PAYMENT', '100.00', '2018-01-01 17:27:32'),
(42, 'PAYMENT', '100.00', '2018-01-01 17:30:13'),
(42, 'REFUND', '58.50', '2018-01-01 17:31:44'),
(42, 'PAYMENT', '512.00', '2018-01-01 17:35:23'),
(43, 'PAYMENT', '100.00', '2018-01-01 17:36:22'),
(43, 'REFUND', '49.50', '2018-01-01 17:37:13'),
(43, 'PAYMENT', '456.20', '2018-01-01 17:37:55'),
(45, 'PAYMENT', '1000.00', '2018-01-01 17:41:51'),
(45, 'REFUND', '144.00', '2018-01-01 17:42:08'),
(45, 'PAYMENT', '200.00', '2018-01-01 17:44:22'),
(45, 'REFUND', '185.40', '2018-01-01 17:44:39'),
(45, 'PAYMENT', '132.00', '2018-01-01 17:44:47'),
(46, 'PAYMENT', '800.00', '2018-01-01 19:24:23'),
(46, 'REFUND', '216.00', '2018-01-01 19:24:42'),
(46, 'PAYMENT', '10.00', '2018-01-01 19:25:00'),
(46, 'PAYMENT', '13.50', '2018-01-01 19:25:12');

--
-- Triggers `transactions`
--
DELIMITER $$
CREATE TRIGGER `transactions_domain_constraints` BEFORE INSERT ON `transactions` FOR EACH ROW BEGIN
IF NEW.type <> 'PAYMENT' && NEW.type <> 'REFUND' THEN
	signal sqlstate '45000' set message_text = 'Invalid state!';
END IF;
IF NEW.amount < 0 THEN
	signal sqlstate '45000' set message_text = 'Negative amount!';
END IF;
IF NEW.date < (SELECT date from order_t WHERE order_t.oid = NEW.oid) THEN
	signal sqlstate '45000' set message_text = 'Transaction date older than corresponding order!';
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transactions_update_constraints` BEFORE UPDATE ON `transactions` FOR EACH ROW BEGIN
IF NEW.type <> 'PAYMENT' && NEW.type <> 'REFUND' THEN
	signal sqlstate '45000' set message_text = 'Invalid state!';
END IF;
IF NEW.amount < 0 THEN
	signal sqlstate '45000' set message_text = 'Negative amount!';
END IF;
IF NEW.date < (SELECT date from order_t WHERE order_t.oid = NEW.oid) THEN
	signal sqlstate '45000' set message_text = 'Transaction date older than corresponding order!';
END IF;
END
$$
DELIMITER ;
