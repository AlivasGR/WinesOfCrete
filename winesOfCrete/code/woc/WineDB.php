<?php
    
    function addWine($retailPrice, $wholesalePrice,$winery,$name,$color,$date,$photo, $varieties){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }    
        mysqli_set_charset($conn, "utf8");
        
        $sql = "INSERT INTO wine(retailPrice, wholesalePrice, winery, name, color, date, photo) VALUES ('$retailPrice', '$wholesalePrice', '$winery', '$name', '$color', '$date', '$photo');";
        $result = mysqli_query($conn, $sql);
        
        if(!$result){
            mysqli_close($conn);
            return false;
        }
        $arr_len = count($varieties);
        
        $sq2 = "SELECT wid FROM wine WHERE wid = LAST_INSERT_ID();";
        $toReturn = mysqli_fetch_assoc(mysqli_query($conn, $sq2));
        
        $wid = $toReturn['wid'];
        
        for($i =0 ; $i < $arr_len; $i++){
            $res = mysqli_fetch_assoc(getVarietyByName($varieties[$i]));
            $vid = $res['vid'];
            $sq2 = "INSERT INTO winemadeofvariety(wid,vid) VALUES('$wid','$vid');";
            $result = mysqli_query($conn, $sq2);
        }      
        
        mysqli_close($conn);
        return $result;
    }
    
    function getWines(){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }    
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM Wine;";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }
    
    function getWineById($wid) {
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM Wine where wid = $wid;";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;    
    }
    
    function getWineByName($wineName){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM Wine where name = '$wineName';";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;    
    }
    
    function getWinesByColor($wineColor){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $sql = "SELECT * FROM Wine where color = '$wineColor';";        
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;        
    }
    
    function getWinesByWinery($winery){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM Wine where winery = '$winery';";        
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;        
    }
    
    function getWinesInRetailPriceInterval($lowerBound, $upperBound){
       $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }   
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM Wine where retailPrice >= '$lowerBound' and retailPrice <= '$upperBound';";        
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;              
    }
    
    function getWinesInWholesalePriceInterval($lowerBound, $upperBound){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }   
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM Wine where wholesalePrice >= '$lowerBound' and wholesalePrice <= '$upperBound';";        
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;              
    }
    
    function getWinesInDateInterval($lowerBound, $upperBound){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }    
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM Wine where date >= '$lowerBound' and date <= '$upperBound';";        
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }
    
    function getWinesByVariety($wineVariety){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }    
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT w.wid, w.price, w.winery, w.name, w.color, w.date, "
                . "w.photo FROM Wine w, Variety v, WineMadeOfVariety wv where "
            . "w.wid = wv.wid and v.vid = wv.vid and v.name = '$wineVariety';";        
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;        
    }
    
    function getVarietiesOfWine($wineId){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }    
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT v.vid, v.name FROM Variety v,".
                " WineMadeOfVariety wv WHERE wv.wid = '$wineId' ".
                " and v.vid = wv.vid";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;              
    }

    function winesJOINVarieties(){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }    
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT v.vid, v.name, wv.wid FROM Variety v, ".
               "WineMadeOfVariety wv WHERE v.vid = wv.vid;";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }
	
    function getBestWinesByVariety($wineVariety){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }    
        mysqli_set_charset($conn, "utf8");
        $sql =  "SELECT w.*, p.bottlesThisMonth FROM Wine w, mostpopularwines p, Variety v, "
                . "winemadeofvariety wv where w.wid = p.wid and w.wid = wv.wid "
                . "and wv.vid = v.vid and v.name = '$wineVariety' "
                ."ORDER BY p.bottlesThisMonth DESC LIMIT 10;";   
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;        
    }
	
    function getBestWinesByWinery($winery){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT w.*, p.bottlesThisMonth FROM Wine w, mostpopularwines p where w.wid = p.wid "
            ."and  w.winery = '$winery' ORDER BY p.bottlesThisMonth DESC LIMIT 10;";        
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;        
    }
    
    function getBestWinesByColor($wineColor){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $sql = "SELECT w.*, p.bottlesThisMonth FROM Wine w, mostpopularwines p where w.wid = p.wid "
            ."and w.color = '$wineColor' ORDER BY p.bottlesThisMonth DESC LIMIT 10;";        
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;        
    }
    
    function getBestWinesByDate($date){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $sql = "SELECT w.*, p.bottlesThisMonth FROM Wine w, mostpopularwines p where w.wid = p.wid "
            ."and w.date = '$date' ORDER BY p.bottlesThisMonth DESC LIMIT 10;";       
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;        
    }       
    
    function getBestWinesGeneral(){
        $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT w.*, p.bottlesThisMonth FROM Wine w, mostpopularwines p where w.wid = p.wid "
            ."ORDER BY p.bottlesThisMonth DESC LIMIT 10;"; 
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;        
    }
    
    function searchWinesSubstr($substr){    
       $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }    
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT * FROM Wine WHERE name LIKE '%$substr%';";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;           
    }
    
    function searchWinesAllFilters($substr, $dateLower, $dateUpper, $priceLower, 
                            $priceUpper, $color, $winery, $variety, $isMerchant){
       $conn = mysqli_connect($GLOBALS['db_server'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_name']);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }    
        mysqli_set_charset($conn, "utf8");
        $sql = "SELECT DISTINCT Wine.wid, Wine.color, Wine.date, Wine.photo, "
                . "Wine.name, Wine.winery, Wine.retailPrice, Wine.wholesalePrice"
                . " FROM Wine, WineMadeOfVariety, Variety WHERE Wine.name LIKE '%$substr%'";
        $price = ($isMerchant == 0)?("retailPrice"):("wholesalePrice");
        if(strcmp($color, "any") != 0){
            $sql = $sql." and color = '$color'";
        }
        if( strcmp($winery, "any") != 0){
            $sql = $sql." and winery = '$winery'";
        }
        if( strcmp($variety, "any") != 0){
            $sql = $sql." and Variety.name = '$variety' and WineMadeOfVariety.wid ".
                    "= Wine.wid and WineMadeOfVariety.vid = Variety.vid";
        }
        if( strcmp($dateLower, "") != 0){
            $sql = $sql." and wine.date >= '$dateLower'";
        }
        if( strcmp($dateUpper, "") != 0){
            $sql = $sql." and wine.date <= '$dateUpper'";
        }
        if( strcmp($priceLower, "") != 0){
            $sql = $sql." and wine.".$price." >= '$priceLower'";
        }
        if( strcmp($priceUpper, "") != 0){
            $sql = $sql." and wine.".$price." <= '$priceUpper'";
        }
        $sql = $sql.";";
        //echo $sql;
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);      
        return $result;          
    }