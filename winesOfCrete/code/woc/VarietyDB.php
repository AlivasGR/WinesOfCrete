<?php

function addVariety($name){
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    
    $sql = "INSERT INTO variety(name) VALUES('$name');";
    $result = mysqli_query($conn, $sql);    
    if (!$result) {
        echo $result;
        printf("Errormessage: %s\n", mysqli_error($conn));
    }
    
    if(!$result){
        mysqli_close($conn);
        return false;
    }   
    
    mysqli_close($conn);
    return $result;   
}

function getVarietyByName($name){    
    $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    
    $sql = "SELECT * FROM variety WHERE name = '$name';";
    $result = mysqli_query($conn, $sql);
    
    mysqli_close($conn);
    return $result;    
}
