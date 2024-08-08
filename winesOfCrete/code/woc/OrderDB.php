<?php

function getOrders() {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * FROM Order_t;";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getOrdersByMember($member_id) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * FROM Order_t where mid = '$member_id';";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getOrdersByDate($date) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * FROM Order_t where date = '$date';";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getOrdersByState($state) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * FROM Order_t where state = '$state';";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getOrdersInPriceInterval($min, $max) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * FROM Order_t where cost >= '$min' and cost <= '$max';";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getOrder($order_id) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * FROM Order_t WHERE oid = '$order_id';";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getOrderCost($oid){
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT cost FROM Order_t WHERE oid = '$oid';";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    
    mysqli_close($conn);
    return $result["cost"];    
}

function addOrder($member_id, $date, $cost, $state) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");

    $sq0 = "INSERT INTO Order_t(mid,date,cost,state) VALUES('$member_id','$date', '$cost', '$state');";
    $result = mysqli_query($conn, $sq0);
    if (!$result) {
        $temp = mysqli_error($conn);
        mysqli_close($conn);
        return $temp;
    }
    $sq3 = "SELECT oid FROM Order_t WHERE oid = LAST_INSERT_ID();";
    $toReturn = mysqli_query($conn, $sq3);


    mysqli_close($conn);
    return $toReturn;
}

function updateOrderState($oid, $state) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "UPDATE Order_t SET state = '$state' WHERE oid = '$oid';";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        $temp = mysqli_error($conn);
        mysqli_close($conn);
        return $temp;
    }
    mysqli_close($conn);
    return $res;
}

function updateOrderCost($oid, $cost) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sq0 = "SELECT oid,cost FROM Order_t WHERE oid = '$oid';";
    $res00 = mysqli_fetch_assoc(mysqli_query($conn, $sq0));
    $curr_cost = $res00['cost'];
    $curr_cost += $cost;    
    $sql = "UPDATE Order_t SET cost  = '$curr_cost' WHERE oid = '$oid';";
    $res = mysqli_query($conn, $sql);  
    if (!$res) {
        $temp = mysqli_error($conn);
        mysqli_close($conn);
        return $temp;
    }
    mysqli_close($conn);
    return $curr_cost;
}

function updateDiscount($oid, $discount) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "UPDATE Order_t SET discount = '$discount' WHERE oid = '$oid';";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        $temp = mysqli_error($conn);
        mysqli_close($conn);
        return $temp;
    }
    mysqli_close($conn);
    return $res;
}

function applyDiscount($oid) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");

    $sq1 = "SELECT discount FROM Order_t  where oid = '$oid';";
    $res10 = mysqli_fetch_assoc(mysqli_query($conn, $sq1));
    $res1 = $res10['discount'];

    $sq2 = "SELECT cost FROM Order_t  where oid = '$oid';";
    $res20 = mysqli_fetch_assoc(mysqli_query($conn, $sq2));
    $res2 = $res20['cost'];

    $res3 = $res2 - ($res1 * 0.01 * $res2);
    $sq3 = "UPDATE Order_t SET cost = '$res3' WHERE oid = '$oid';";
    $res = mysqli_query($conn, $sq3);
    if (!$res) {
        $temp = mysqli_error($conn);
        mysqli_close($conn);
        return $temp;
    }

    mysqli_close($conn);
    return $res2;
}

function getOrderDiscount($oid) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");

    $sq1 = "SELECT discount FROM Order_t  where oid = '$oid';";
    $res = mysqli_query($conn, $sq1);

    mysqli_close($conn);
    return $res;
}

function checkOrderValidity($oid, $wid, $amount) {
    $wines = getWinesOfOrder($oid);
    $count = 0;
    while ($wine = mysqli_fetch_assoc($wines)) {
        $am = 0;
        if ($wine['wid'] == $wid) {
            $am = $wine['amount'] - $amount;
        } else {
            $am = $wine['amount'];
        }
        if ($am >= 6) {
            $count++;
        }
    }
    if ($count >= 3) {
        return true;
    } else {
        return false;
    }
}
