
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
-- RELATIONSHIPS FOR TABLE `orderconsistsofwine`:
--   `wid`
--       `wine` -> `wid`
--   `oid`
--       `order_t` -> `oid`
--

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
(41, 26, 6),
(41, 30, 6),
(41, 31, 6),
(42, 21, 20),
(42, 25, 15),
(42, 28, 20),
(43, 6, 15),
(43, 24, 20),
(43, 30, 20),
(45, 1, 80),
(45, 6, 15),
(45, 7, 30),
(46, 1, 70),
(46, 2, 10),
(46, 3, 10);

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
