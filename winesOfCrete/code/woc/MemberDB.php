<?php

function getMembers() {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * FROM Member;";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getBadMembers() {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * FROM Member WHERE debt > 0 ORDER BY debt DESC;";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getGoodMembers() {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * FROM Member WHERE debt = 0 ORDER BY totalMoneySpent DESC;";
    $result = mysqli_query($conn, $sql);   
    
    mysqli_close($conn);
    return $result;
}

function getMember($username) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT * FROM Member WHERE username = '$username';";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function checkMember($username, $password) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT mid FROM Member WHERE username = '$username' AND password = '$password';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {        
        $result = true;
    } else {       
        $result = false;
    }
    mysqli_close($conn);
    return $result;
}

function addMember($username, $password, $fname, $lname, $telephone, $cardno, $bankno, $country, $city, $address, $ismerchant) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "INSERT INTO Member(username, password, fname, lname, tel, address, city, country, debt, cardno, balance, bank_no) VALUES ('$username', '$password', '$fname', '$lname', '$telephone', '$address', '$city', '$country', 0, '$cardno', 0, '$bankno');";
    $result = mysqli_query($conn, $sql);
    
    if(!$result){       
        mysqli_close($conn);
        return false;
    }
        
    $sq2 = "SELECT mid FROM Member WHERE username = '$username';";
    $res2 = mysqli_query($conn, $sq2);
    if (mysqli_num_rows($res2) > 0) {
        $row = mysqli_fetch_assoc($res2);
        $resmid = $row["mid"];
        if ($ismerchant == 1) {
            $sql = "INSERT INTO Merchant(mid) VALUES('$resmid');";
        } else {
            $sql = "INSERT INTO Client(mid) VALUES('$resmid');";
        }
        mysqli_query($conn, $sql);
    }
    mysqli_close($conn);
    return $result;
}

function updateMember($username, $password, $fname, $lname, $telephone, $cardno, $bankno, $country, $city, $address, $debt) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "UPDATE Member SET password = '$password', fname = '$fname', lname = '$lname', tel = '$telephone', address = '$address', city = '$city', country = '$country', debt = '$debt',  cardno = '$cardno', bank_no = '$bankno' WHERE username = '$username';";
    $result = mysqli_query($conn, $sql);
    
    mysqli_close($conn);
    return $result;
}

function updateDebt($mid) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    
    $sq0 = "SELECT oid,cost from Order_t WHERE mid = '$mid';";
    $res0 = mysqli_query($conn, $sq0);
    $debt = 0 ;
    $cost = 0;
    
    while ($row = mysqli_fetch_assoc($res0)){
        $debt += getSumOfTransaction($row['oid']);
        $cost += $row['cost'];
    }
    $debt = $cost - $debt;
    
    $sq1 = "UPDATE Member SET debt = '$debt' where mid = '$mid';";
    $res1= mysqli_query($conn, $sq1);  
    
    mysqli_close($conn);
    return $res1;
}

function deleteMember($username) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    
    $sql = "DELETE FROM Member WHERE username = '$username';";
    $result = mysqli_query($conn, $sql);
    
    if(!$result){        
        mysqli_close($conn);
        return false;
    }
    mysqli_close($conn);
    return true;
}

function checkValidUsername($username) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT username FROM Member WHERE username = '$username';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        mysqli_close($conn);
        return false;
    } else {
        mysqli_close($conn);
        return true;
    }
}


function isMerchant($username) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT Member.mid FROM Member, Merchant WHERE Member.mid = Merchant.mid AND Member.username = '$username';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        mysqli_close($conn);
        return true;
    } else {
        mysqli_close($conn);
        return false;
    }
}

function getMidFromUsername($username) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $sql = "SELECT mid FROM Member WHERE username = '$username';";
    $result = mysqli_query($conn, $sql);  
    mysqli_close($conn);
    return $result;
}

function MemberIsReadyToOrder($mid,$date, $amount) {
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    
    $sq0 = "SELECT balance FROM Member WHERE mid = '$mid';";
    $res = mysqli_fetch_assoc(mysqli_query($conn, $sq0)); 
    
    if($res['balance'] < $amount) {
        mysqli_close($conn);
        return 0;
    }
    
    $sql = "SELECT o.oid, state FROM Order_t o where o.mid = '$mid' and TIMESTAMPDIFF(DAY, o.date, '$date') >= 10;";
    $result = mysqli_query($conn, $sql);  
    if (mysqli_num_rows($result) > 0) {      
        while($row = mysqli_fetch_assoc($result)){
            if(!strcmp($row['state'],"AWAITING_PAYMENT")) {
                mysqli_close($conn);
                return 0;        
            }
        }     
    }   
    mysqli_close($conn);
    return 1;
}

function MemberIsReadyToDelete($mid){      
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");  
    
    $sq1 = "SELECT debt FROM Member where mid = '$mid';";
    $res = mysqli_fetch_assoc(mysqli_query($conn, $sq1));
    if ($res['debt'] > 0) {        
        mysqli_close($conn);
        return 0;
    }
    $sq2 = "SELECT * FROM Order_t where mid = '$mid';";
    $result = mysqli_query($conn, $sq2);    
    if (mysqli_num_rows($result) > 0) {       
        while($row = mysqli_fetch_assoc($result)){
            if(strcmp($row["state"], "DELIVERED") != 0) {
                mysqli_close($conn);
                return 0;        
            }            
        }     
    }
    mysqli_close($conn);
    return 1;    
}

function getDebt($username) {    
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT debt FROM Member WHERE username = '$username';";
    
    $result = mysqli_query($conn, $sql);
    
    mysqli_close($conn);
    return $result;
}
   
function updateToTalOrders($mid,$amount){    
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8"); 
    if ($amount >= 0) {
        $sign = "+";
    } else {
        $sign = "-";
        $amount = -$amount;
    }
    $sq1 = "UPDATE Member SET totalMoneySpent = totalMoneySpent " . $sign . " " . $amount . " WHERE mid = '$mid';";
    $result1 = mysqli_query($conn, $sq1);  
    
     mysqli_close($conn);
    return $result1;
}

function updateBalance($mid,$amount){    
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8"); 
    if ($amount >= 0) {
        $sign = "+";
    } else {
        $sign = "-";
        $amount = -$amount;
    }
    $sq1 = "UPDATE Member SET balance = balance " . $sign . " " . $amount . " WHERE mid = '$mid';";
   
    $result1 = mysqli_query($conn, $sq1);  
    
    mysqli_close($conn);
    return $result1;
}

function getBalance($mid) {    
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    
    $sql = "SELECT balance FROM Member WHERE mid = '$mid';";    
    $result = mysqli_query($conn, $sql);
    
    mysqli_close($conn);
    return $result;
}

function payOldestOrder($mid,$amount){
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    
    $sq1 = "SELECT oid FROM Order_t WHERE mid = '$mid' and state = 'AWAITING_PAYMENT' ORDER BY date ASC;";
    $result = mysqli_query($conn, $sq1);
    
     if (mysqli_num_rows($result) > 0) {       
        while(($row = mysqli_fetch_assoc($result)) && ($amount>0)){
            $paid = getSumOfTransaction($row["oid"]);
            $total = getOrderCost($row["oid"]);
            $to_pay = ($amount>($total-$paid)) ? ($total-$paid) : $amount;
            $temp = addTransaction($row["oid"],'PAYMENT',$to_pay, date('Y-m-d H:i:s'));
            if (is_string($temp)) {
                echo "<script>alert('$temp')</script>";
                return false;
            }           
            $amount -= $to_pay;        
        }     
    } else {
        return false;
    }
    
    mysqli_close($conn);
    return true;
}