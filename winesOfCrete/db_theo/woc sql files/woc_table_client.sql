
-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `mid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `client`:
--   `mid`
--       `member` -> `mid`
--

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
