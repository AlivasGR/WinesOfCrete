<?php

function addOrderConsistsOfWine($oid,$wid, $amount) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");  
    
    $sq0 = "INSERT INTO OrderConsistsOfWine(oid,wid,amount) VALUES('$oid','$wid', '$amount');";
    $result = mysqli_query($conn, $sq0);   
    if (!$result) {
        $temp = mysqli_error($conn);
        mysqli_close($conn);
        return $temp;
    }
    mysqli_close($conn);
    return $result;
}

function getWinesOfOrder($oid) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");  
    $sql = "SELECT wid, amount FROM OrderConsistsOfWine WHERE oid = '$oid'";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getWineAmountInOrder($oid, $wid) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT amount FROM OrderConsistsOfWine WHERE oid = '$oid' AND wid = '$wid'";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function updateOrderContent($oid, $wid, $amount) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $orderam = mysqli_fetch_assoc(getWineAmountInOrder($oid, $wid));
    $neam = $orderam['amount'] - $amount;
    $sql = "UPDATE OrderConsistsOfWine SET amount = $neam WHERE oid = '$oid' AND wid = '$wid';";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $temp = mysqli_error($conn);
        mysqli_close($conn);
        return $temp;
    }
    $wam = mysqli_fetch_assoc(getWineAmountInOrder($oid, $wid));
    if ($wam['amount'] <= 0) {
        $sql = "DELETE FROM OrderConsistsOfWine WHERE oid = '$oid' AND wid = '$wid';";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $temp = mysqli_error($conn);
            mysqli_close($conn);
            return $temp;
        }
    }
    mysqli_close($conn);
}