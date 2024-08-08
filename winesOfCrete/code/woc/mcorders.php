<?php
$user = mysqli_fetch_assoc(getMember($_SESSION['username']));
$orders = getOrdersByMember($user['mid']);
$joined = winesJOINVarieties();
$displayedPrice = (isMerchant($_SESSION['username']) == 1) ? ("wholesalePrice") : ("retailPrice");
?>
<ul id ="orderlist">
    <?php
    if (mysqli_num_rows($orders) > 0) {
        $i = 0;
        echo "<div id = \"payrestarea\"><form method = \"post\" action = \"profile.php?navc=navcprofile&mc=mcorders\" class = \"paymentform\">";
        echo "<label for = \"payment\">Pay Rest of Oldest Order</label><input type = \"text\" name = \"payment\" placeholder = \"0\" class = \"refcheckbox\"/>";
        echo "<input type = \"submit\" class = \"orderbutton\" value = \"Refund\"/>";
        echo "</form></div>";        
        while ($order = mysqli_fetch_assoc($orders)) {
            echo "<li>";
            echo "<h2>Order: " . $order['date'] . "</h2>";
            echo "<input type = \"button\" value = \"Show More\" id = \"ob$i\" class = \"orderbutton\" onclick = \"ordermanip($i)\"/>";
            echo "<form method = \"post\" action = \"profile.php?navc=navcprofile&mc=mcorders&oid=".$order['oid']."\" class = \"delform\">";
            echo "<input type = \"submit\" value = \"Mark as Delivered\" class = \"delivbutton\" name = \"delbutton\"/>";
            echo "</form>";
            echo "<div class = \"orderdetails\">";           
            echo "<p class = \"orderstatus\">" . $order['state'] . "</p>";
            echo "<div class = \"ordercontent\" id = \"id$i\">";
            $ordercontent = getWinesOfOrder($order['oid']);
            $oid = $order['oid'];
            $counter = 0;
            while ($orderwine = mysqli_fetch_assoc($ordercontent)) {
                $counter++;
                $row = mysqli_fetch_assoc(getWineById($orderwine['wid']));
                $wid = $row['wid'];
                $displayed = 
                        "<div class=\"wineContainer\">" .
                        "<a href=\"" . $row["photo"] . "\"target=\"_blank\">" .
                        "<img class=\"wineImage\" src=\"" . $row["photo"] . "\" alt=\"Wine\">" .
                        "</a>" .
                        "<p><b>" . $orderwine['amount'] . " από: " . $row["name"] . "</b>" .
                        "<form class = \"retform\" method = \"post\" action = \"profile.php?navc=navcprofile&mc=mcorders&oid=$oid&wid=$wid\">" .
                        "<label for = \"refund\">Refund:</label><input type = \"text\"  name = \"refund\" placeholder = \"0\" class = \"refcheckbox\"/>" .
                        "<input type = \"submit\" class = \"orderbutton\" value = \"Refund\"/>" .
                        "</form>" .
                        "<br/><br/>Οινοποιείο Παραγωγής: " .$row["winery"] .
                        "<br/>Χρώμα κράσιου: " . $row["color"] .
                        "<br/>Έτος παραγωγής: " . $row["date"] .
                        "<br/>Χρησιμοποιηθέντες ποικιλίες: ";
                mysqli_data_seek($joined, 0); /* print all varieties of current wine */
                while ($varietyRow = mysqli_fetch_assoc($joined)) {
                    if ($varietyRow["wid"] == $row["wid"]) {
                        $displayed = $displayed . $varietyRow["name"] . ", ";
                    }
                }
                $displayed = rtrim($displayed, ", ");
                $displayed = $displayed . "</p>" .
                        "<div class=\"winePrice\">" . $row[$displayedPrice] . "€</div>" .
                        "</div>";
                echo $displayed;
            }
            if ($counter == 0) {
                 $displayed = 
                        "<div class=\"wineContainer\">" .
                        "<h3>This order has been completely refunded</h3>" .
                        "</div>";
                 echo $displayed;
            }
            echo "</div>";
            echo "<input type = \"button\" value = \"Show Transactions\" id = \"ot$i\" class = \"transbutton\" onclick = \"transmanip($i)\"/>";
            echo "<div  class = \"ordertrans\" id = \"tb$i\">";
            $ordertrans = getTransactionsByOrder($oid);
            echo "<table class = \"transtable\">";
            echo "<tr><th>Date</th><th>Type</th><th>Amount</th></tr>";
            while ($ordertran = mysqli_fetch_assoc($ordertrans)) {
                echo "<tr>";
                echo "<td>" . $ordertran['date'] . "</td>";
                echo "<td>" . $ordertran['type'] . "</td>";
                echo "<td>" . $ordertran['amount']. " €</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
            echo "<div class = \"orderbottom\">";
            echo "Total: " . $order['cost'] . " € with discount: " . $order['discount'] . "%";
            echo "<br/>Paid: " . getSumOfTransaction($order['oid']) . " €";
            if (getSumOfTransaction($order['oid']) < $order['cost']) {
                $remainder = $order['cost'] - getSumOfTransaction($order['oid']);
                $oid =  $order['oid'];
                echo "<form method = \"post\" class = \"paymentform\" action = \"profile.php?navc=navcprofile&mc=mcorders&oid=$oid\" >";
                echo "<label for = \"paidr\">Pay rest of order: </label>";
                echo "<input type = \"text\"  name = \"paidr\" value = \"$remainder\"/><span>€</span>";
                echo "<input type = \"submit\" value = \"Update Payment\"/>";
                echo "</form>";
            }
            echo "</div>";
            echo "</div>";
            echo "</li>";
            $i++;
        }
    } else {
        echo "<h2>You haven't ordered anything!</h2>";
        echo "<p>Go order something and come back!</p>";
    }
    ?>
</ul>

<?php
date_default_timezone_set('Europe/Athens');
if (!empty($_POST['paidr'])) {
    $order = mysqli_fetch_assoc(getOrder($_GET['oid']));
    $remainder = $order['cost'] - getSumOfTransaction($order['oid']);
    if (round($_POST['paidr'], 2) > round($remainder, 2) || round($_POST['paidr'], 2) < 0) {
        echo "<script>alert('Invalid amount: " . $_POST['paidr'] . "')</script>";
    } else {
        $mid0 = mysqli_fetch_assoc(getMidFromUsername($_SESSION['username']));
        $mid = $mid0['mid'];
        $bl = mysqli_fetch_assoc(getBalance($mid));
        $balance = $bl['balance'];
        if($balance < round($_POST['paidr'], 2)) {
            echo "<script>alert('Insufficient balance. Please add money to your balance.')</script>";
        }
        $temp = addTransaction($order['oid'], "PAYMENT", $_POST['paidr'], date('Y-m-d H:i:s'));
        if (is_string($temp)) {
            echo "<script>alert('$temp')</script>";
            return false;
        }       
    }
    echo "<meta http-equiv=\"refresh\" content=\"0;profile.php?navc=navcprofile&mc=mcorders\">";
}

if (!empty($_POST['refund'])) {
    $order = mysqli_fetch_assoc(getOrder($_GET['oid']));
    $wine = mysqli_fetch_assoc(getWineById($_GET['wid']));
    $wam = mysqli_fetch_assoc(getWineAmountInOrder($order['oid'], $wine['wid']));
    if (round($_POST['refund'],2) > round($wam['amount'],2) || round($_POST['refund'],2) < 0) {
        echo "<script>alert('Invalid amount')</script>";
    } else {
        if (!returnFromOrder($order['oid'], $wine['wid'], $_POST['refund'])) {
            echo("<script>alert('Refund could not be completed. ')</script>");
        }
    }
    echo "<meta http-equiv=\"refresh\" content=\"0;profile.php?navc=navcprofile&mc=mcorders\">";
}

if (!empty($_POST['payment'])) {
    $mid0 = mysqli_fetch_assoc(getMidFromUsername($_SESSION['username']));
    $mid = $mid0['mid'];
    $balance = mysqli_fetch_assoc(getBalance($mid));
    if($_POST['payment'] < 0 || $_POST['payment'] > $balance){
        echo("<script>alert('Insufficient balance for refund')</script>");
    }
    if(!payOldestOrder($mid,$_POST['payment'])){
        echo "<script>alert('Transaction failed')</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delbutton'])) {
    $order = mysqli_fetch_assoc(getOrder($_GET['oid']));
    if (strcmp($order['state'], "FULLY_PAID") != 0) {
        
    } else {
        $temp = updateOrderState($order['oid'], "DELIVERED");
        if (is_string($temp)) {
            echo "<script>alert('$temp')</script>";
            return false;
        }   
    }
    echo "<meta http-equiv=\"refresh\" content=\"0;profile.php?navc=navcprofile&mc=mcorders\">";
}