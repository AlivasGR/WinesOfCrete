
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
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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
