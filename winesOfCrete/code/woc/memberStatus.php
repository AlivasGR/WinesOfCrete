<?php
session_start();
include("base.php");
include("MemberDB.php");
include("WineDB.php");
include("Basket.php");
include("header.php");
include("nav.php");

function displayBadMembers(){
    $badMembersTable = getBadMembers();
    $displayed = "<table class=\"memberTable\">"
            . "<tr>"
            . "<th>Ονοματεπώνυμο πελάτη</th>"
            . "<th>Χρέος</th>"
            . "<th>Έμπορος</th>"
            ."</tr>";
    while ($row = mysqli_fetch_assoc($badMembersTable)) {
        $displayed = $displayed."<tr>";
        $displayed = $displayed."<td>".$row["fname"]." ".$row["lname"]."</td>";
        $displayed = $displayed."<td>".$row["debt"]." €";
        $displayed = $displayed."<td>".( (isMerchant($row["username"]) == 1)?
                                                              ("Ναι"):("Όχι") );
        $displayed = $displayed."</tr>";
    }
    $displayed = $displayed."</table>";
    echo $displayed;
}

function displayGoodMembers(){
    $goodMembersTable = getGoodMembers();
    $displayed = "<table class=\"memberTable\">"
            . "<tr>"
            . "<th>Ονοματεπώνυμο πελάτη</th>"
            . "<th>Συνολική αξία παραγγελιών</th>"
            . "<th>Έμπορος</th>"
            ."</tr>";
    while ($row = mysqli_fetch_assoc($goodMembersTable)) {
        if($row["totalMoneySpent"] > 0){
            $displayed = $displayed."<tr>";
            $displayed = $displayed."<td>".$row["fname"]." ".$row["lname"]."</td>";
            $displayed = $displayed."<td>".$row["totalMoneySpent"]." €";
            $displayed = $displayed."<td>".( (isMerchant($row["username"]) == 1)?
                                                                  ("Ναι"):("Όχι") );
            $displayed = $displayed."</tr>";
        }
    }
    $displayed = $displayed."</table>";
    echo $displayed;
}
?>
<div class ="Container" id ="mastercontainer">
    <h class="statusHeader"><b>Κατάσταση κακών πελατών</b></br></br></h>
    <?php
    displayBadMembers();
    ?>    
    <h class="statusHeader"></b></br></br><b>Κατάσταση καλών πελατών</b></br></br></h>
    <?php
    displayGoodMembers();
    ?>
</div>