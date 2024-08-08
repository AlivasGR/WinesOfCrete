<?php
session_start();
//setcookie('username', "");
include("base.php");
include("MemberDB.php");
include("VarietyDB.php");
include("WineDB.php");
include("OrderDB.php");
include("TransactionsDB.php");
include("MakeOrder.php");
include("OrderConsistsOfWineDB.php");
include("Basket.php");
include("header.php");
include("nav.php");
?>
<div class ="Container" id ="mastercontainer">
    <?php
    $p = "mchome";
    include("mchome.php");
    ?>
</div>
<?php
include("footer.php");



