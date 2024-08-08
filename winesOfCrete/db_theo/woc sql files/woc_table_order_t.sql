
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
-- RELATIONSHIPS FOR TABLE `order_t`:
--   `mid`
--       `member` -> `mid`
--

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
(41, 1, '2018-01-01 17:27:32', '217.20', 0, 'AWAITING_PAYMENT'),
(42, 1, '2018-01-01 17:30:13', '553.50', 10, 'FULLY_PAID'),
(43, 1, '2018-01-01 17:36:22', '506.70', 10, 'AWAITING_PAYMENT'),
(45, 9, '2018-01-01 17:41:51', '1002.60', 10, 'FULLY_PAID'),
(46, 9, '2018-01-01 19:24:23', '607.50', 10, 'FULLY_PAID');

--
-- Triggers `order_t`
--
DELIMITER $$
CREATE TRIGGER `order_t_domain_constraints` BEFORE INSERT ON `order_t` FOR EACH ROW BEGIN
IF NEW.state != 'DELIVERED' AND NEW.state != 'AWAITING_PAYMENT' AND NEW.state != 'FULLY_PAID' THEN
	signal sqlstate '45000' set message_text = 'Invalid order state';
END IF;
IF NEW.cost < 0 THEN
	signal sqlstate '45000' set message_text = 'Negative order cost';
END IF;
IF NEW.discount != 0 AND NEW.discount != 5 AND NEW.discount != 10 THEN
	signal sqlstate '45000' set message_text = 'Invalid order discount';
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `order_t_update_constraints` BEFORE UPDATE ON `order_t` FOR EACH ROW BEGIN
IF NEW.oid != OLD.oid THEN
	signal sqlstate '45000' set message_text = 'Cannot change order id after creation of order';
END IF;
IF NEW.mid != OLD.mid THEN
	signal sqlstate '45000' set message_text = 'Cannot change member id referred to by order after creation of order';
END IF;
IF NEW.state != 'DELIVERED' AND NEW.state != 'AWAITING_PAYMENT' AND NEW.state != 'FULLY_PAID' THEN
	signal sqlstate '45000' set message_text = 'Invalid order state';
END IF;
IF NEW.cost < 0 THEN
	signal sqlstate '45000' set message_text = 'Negative order cost';
END IF;
IF NEW.discount != 0 AND NEW.discount != 5 AND NEW.discount != 10 THEN
	signal sqlstate '45000' set message_text = 'Invalid order discount';
END IF;
END
$$
DELIMITER ;
