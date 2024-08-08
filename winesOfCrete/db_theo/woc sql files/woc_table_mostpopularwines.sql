
-- --------------------------------------------------------

--
-- Table structure for table `mostpopularwines`
--

CREATE TABLE `mostpopularwines` (
  `wid` int(11) NOT NULL,
  `bottlesThisMonth` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `mostpopularwines`:
--   `wid`
--       `wine` -> `wid`
--

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
