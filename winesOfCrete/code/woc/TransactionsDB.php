<?php

function addTransaction($oid,$type,$amount, $date) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");     
        
    $sql = "INSERT INTO transactions(oid,type,amount,date) VALUES('$oid','$type','$amount', '$date');";
    $result = mysqli_query($conn, $sql);    
    
    if(!$result){
        $tmp = mysqli_error($conn);
        mysqli_close($conn);
        return $tmp;
    }
    
    $sq2  = "SELECT sum(amount) as total FROM transactions where oid = '$oid' and type = 'PAYMENT';";    
    $res20 = mysqli_fetch_assoc(mysqli_query($conn, $sq2));   
    $res2 = $res20['total'];
    
    $sq3 = "SELECT sum(amount) as total FROM transactions where oid = '$oid' and type = 'REFUND';";
    $res30 = mysqli_fetch_assoc(mysqli_query($conn, $sq3));   
    $res3 = $res30['total'];
    
    $sq4 = "SELECT cost,mid FROM Order_t WHERE oid = '$oid';";
    $res40 = mysqli_fetch_assoc(mysqli_query($conn, $sq4));   
    $res4 = $res40['cost'];
    
    if (($res2-$res3) == $res4) {
        $temp = updateOrderState($oid,"FULLY_PAID");        
        if (is_string($temp)) {
            return $temp;
        }
    } 
    
    mysqli_close($conn);
    return $result;
}

function getSumOfTransaction($oid){
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8"); 
    
    $sq0  = "SELECT sum(amount) AS total FROM transactions where oid = '$oid' and type = 'REFUND';";
    $res0 = mysqli_fetch_assoc(mysqli_query($conn, $sq0));
    $sq1  = "SELECT sum(amount) AS total FROM transactions where oid = '$oid' and type = 'PAYMENT';";
    $res1 = mysqli_fetch_assoc(mysqli_query($conn, $sq1));  
    
    $res3 = $res1['total'] - $res0['total'];
    
    mysqli_close($conn);
    return $res3;
}
function getTransactions() {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8"); 
    $sql = "SELECT * FROM transactions;";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getTransactionsByOrder($oid) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8"); 
    $sql = "SELECT * FROM transactions where oid = '$oid';";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getTransactionsByDateInterval($dateMin, $dateMax) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8"); 
    $sql = "SELECT * FROM transactions where date >= '$dateMin' and date <= $dateMax;";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getTransactionsByOrderAndDate($oid,$date) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8"); 
    $sql = "SELECT * FROM transactions where oid = '$oid' and date = '$date';";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getTransactionsInPriceInterval($min, $max) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8"); 
    $sql = "SELECT * FROM transactions where amount >= '$min' and cost <= '$max';";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getTransactionsOfMember($mid) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8"); 
    $sql = "SELECT transactions.oid, type, amount, transactions.date FROM transactions, order_t WHERE mid = '$mid' AND order_t.oid = transactions.oid;";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getTransactionsOfMemberInDateInterval($mid, $dateMin, $dateMax) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8"); 
    $sql = "SELECT transactions.oid, type, amount, transactions.date FROM transactions, order_t WHERE mid = '$mid' AND order_t.oid = transactions.oid AND transactions.date >= '$dateMin' AND transactions.date <= '$dateMax;'";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}