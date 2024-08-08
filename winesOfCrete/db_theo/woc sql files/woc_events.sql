
DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `update_most_popular_wines` ON SCHEDULE EVERY 1 MONTH STARTS '2018-01-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE
FROM
    mostpopularwines;
INSERT INTO mostpopularwines(
    SELECT
        wine.wid,
        SUM(amount)
    FROM
        wine,
        orderconsistsofwine,
    	order_t
    WHERE
        order_t.oid = orderconsistsofwine.oid and wine.wid = orderconsistsofwine.wid and (MONTH(CURDATE()) - MONTH(order_t.date) = 1 or MONTH(CURRENT_DATE) - MONTH(order_t.date) = -11)
    GROUP BY
        orderconsistsofwine.wid
);
END$$

DELIMITER ;
