
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
-- RELATIONSHIPS FOR TABLE `member`:
--

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`mid`, `username`, `password`, `fname`, `lname`, `tel`, `address`, `city`, `country`, `debt`, `totalMoneySpent`, `cardno`, `balance`) VALUES
(1, 'AlivasGR', '2ea773bcbb3d8beb860430c807ef5d9a', 'Anastasis', 'Livanidis', '1234567890', 'Paroikia', 'Paros', 'GR', '62.75', '4752.03', '1234-5678-9012-3456', '3459.75'),
(3, 'geomlyd', 'e31179c08d2235e0377a57cd484278b1', 'George', 'Lydakis', '2810233472', 'Patelarou 2', 'Heraklion', 'GR', '0.00', '200.00', '1234-5678-9012-3456', '0.00'),
(8, 'spyros', 'dfc8f6b72827a2ae85f505269aff304c', 'spyros', 'lydakis', '2810233472', 'ghfdjhfjx', 'Heraklion', 'GR', '0.00', '0.00', '1234-5678-9012-3456', '0.00'),
(9, 'manosgior', '12b7062b71147da5fcfeafbb6bf4bbea', 'Manos', 'Giortamis', '1111111111', 'Papandreou', 'Heraklion', 'GR', '0.00', '1610.10', '1111-1111-1111-1111', '389.90');

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
