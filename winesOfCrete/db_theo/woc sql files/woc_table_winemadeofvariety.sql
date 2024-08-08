
-- --------------------------------------------------------

--
-- Table structure for table `winemadeofvariety`
--

CREATE TABLE `winemadeofvariety` (
  `wid` int(11) NOT NULL,
  `vid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `winemadeofvariety`:
--   `vid`
--       `variety` -> `vid`
--   `wid`
--       `wine` -> `wid`
--

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
