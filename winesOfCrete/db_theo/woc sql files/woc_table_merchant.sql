
-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `mid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `merchant`:
--   `mid`
--       `member` -> `mid`
--

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
