<?php
session_start();
include("base.php");
include("MemberDB.php");
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
    if (!empty($_GET['mc'])) {
        include($_GET['mc'].".php");
    } else {
        include("mcprofile.php");
    }
    ?>
</div>
<?php
include("footer.php");