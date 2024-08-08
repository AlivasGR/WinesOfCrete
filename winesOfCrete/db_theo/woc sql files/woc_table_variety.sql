
-- --------------------------------------------------------

--
-- Table structure for table `variety`
--

CREATE TABLE `variety` (
  `vid` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `variety`:
--

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
