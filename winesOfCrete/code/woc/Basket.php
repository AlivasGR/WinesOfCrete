<?php

function add2Basket() { //total == $p, paid == amount client chooses to pay
    if (!empty($_POST['quantity'])) {
        $wine = getWineById($_GET['wid']);
        $winea = mysqli_fetch_assoc($wine); 
        $winearray = [$_GET['wid'] => ['name' => $winea['name'],
                'wholesalePrice' => $winea['wholesalePrice'],
                'retailPrice' => $winea['retailPrice'],
                'quantity' => $_POST['quantity']]];
//        echo $_GET['wid'] . " ";
//        echo $winearray[$_GET['wid']]['name'] . " ";
//        echo $winearray[$_GET['wid']]['quantity'] . "<br/>===<br/>";
        if (!empty($_SESSION['cart'])) {
//            foreach($_SESSION['cart'] as $k => $v) {
//                echo "wid: " . $k ." name: " .$_SESSION['cart'][$k]['name'] . " quantity: " .$_SESSION['cart'][$k]['quantity'] . "<br/>";
//            }
            if (in_array($_GET['wid'], array_keys($_SESSION['cart']))) {
                foreach ($_SESSION['cart'] as $k => $v) {
                    if ($winea['wid'] == $k) {
                        if (empty($_SESSION['cart'][$k]['quantity'])) {
                            $_SESSION['cart'][$k]['quantity'] = 0;
                        }
                        $_SESSION['cart'][$k]['quantity'] += $_POST['quantity'];
                    }
                }
            } else {
                $_SESSION['cart'] = $_SESSION['cart'] + $winearray;
            }
        } else {
            $_SESSION['cart'] = $winearray;
        }
    }
}

function removeFromBasket() {
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $k => $v) {
            if ($_GET['wid'] == $k) {
                if (!empty($_POST['quantity'])) {
                    $_SESSION['cart'][$k]['quantity'] = $_POST['quantity'];
                    if ($_SESSION['cart'][$k]['quantity'] <= 0) {
                        unset($_SESSION['cart'][$k]);
                    }
                } else {
                    unset($_SESSION['cart'][$k]);
                }
            }
            if (empty($_SESSION['cart'])) {
                unset($_SESSION['cart']);
            }
        }
    }
}

function updateBasket() {
    $p = 0;
    if (!empty($_SESSION['cart'])) {
        $i = 0;
        foreach ($_SESSION['cart'] as $k => $v) {
            echo "<div class = \"cartitem\" id = \"ci$i\">";
            echo "<p class = \"winename\">" . $_SESSION['cart'][$k]['name'] . "</p>";
            if (isMerchant($_SESSION['username'])) {
                echo "<p class = \"wineprice\">" . $_SESSION['cart'][$k]['wholesalePrice'] . "€</p>";
                $p += $_SESSION['cart'][$k]['wholesalePrice'] * $_SESSION['cart'][$k]['quantity'];
            } else {
                echo "<p class = \"wineprice\">" . $_SESSION['cart'][$k]['retailPrice'] . "€</p>";
                $p += $_SESSION['cart'][$k]['retailPrice'] * $_SESSION['cart'][$k]['quantity'];
            }
            echo "<form method = \"post\" action = \"" . $_SERVER['PHP_SELF'] . "?mode=remove&wid=$k\" class = \"cartform\" id = \"cf$i\">";
            echo "<input type = \"text\" name = \"quantity\" value = \"" . $_SESSION['cart'][$k]['quantity'] . "\"/>";
            echo "<input type = \"submit\" value = \"Change\"/></form>";
            echo "<a href = \"" . $_SERVER['PHP_SELF'] . "?mode=remove&wid=$k\" class = \"cartitemclear\" id = \"cic$i\"></a>";
            echo "</div>";
            $i++;
        }
    }
    $dc = $p;
    if (isMerchant($_SESSION['username'])) {
        $dc = $p > 400 ? $p - 0.1 * $p : ($p > 280 ? $p - 0.05 * $p : $p);
    }
    echo "<div id = \"cartbottom\">";
    echo "<p id = \"totalmessage\">Total: " . (($dc != $p) ? "<strike>$p</strike> $dc" : $p) . " €</p>";
    if ($p > 0) {
        echo "<form method = \"post\" action = \"" . $_SERVER['PHP_SELF'] . "?mode=clear\" id = \"buyform\">";
        echo "<div id = \"formcontent\"><span class = \"paymessage\">Pay </span>";
        echo "<input type = \"text\" name = \"paid\" value = \"0\" pattern = \"^[0-9]+\.?[0-9]+$\"/>";
        echo "<span class = \"paymessage\"> /$dc €</span></div>";
        echo "<input type = \"submit\" value = \"Buy\" id = \"buybutton\"/><a href = \"" . $_SERVER['PHP_SELF'] . "?mode=clear\" id = \"clearbutton\"><span>Clear</span></a></form>";
    }
    echo "</div>";
    $_SESSION['total'] = $p;
    $_SESSION['totaldc'] = $dc;
}

function manipBasket() {
    if (!empty($_GET['mode'])) {
        switch ($_GET['mode']) {
            case "add":
                add2Basket();
                break;
            case "remove":
                removeFromBasket();
                break;
            case "clear":
                unset($_SESSION['cart']);
                break;
        }
    }
    updateBasket();
}

if (!empty($_POST['paid'])) {
    if ($_POST['paid'] > $_SESSION['totaldc'] || $_POST['paid'] < 0) {
        echo "<script>alert('Invalid payment amount')</script>";
    } else {
        makeOrder();
    }
}
