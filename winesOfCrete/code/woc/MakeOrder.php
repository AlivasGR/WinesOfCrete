<?php

function makeOrder() {
    $mid0 = mysqli_fetch_assoc(getMidFromUsername($_SESSION['username']));
    $mid = $mid0['mid'];
    $total_cost = $_SESSION['total'];
    $discount = 0;
    $is_Merchant = false;

    if (isMerchant($_SESSION['username'])) {
        $is_Merchant = true;
    }

    if ($is_Merchant) {
        if (!checkBasket()) {
            echo "<script>alert('Insufficient number of bottles. You need at least 6 bottles of at least 3 different wines')</script>";
            return 0;
        }
        $discount = ($total_cost > 400) ? 10 : ($total_cost > 280 ? 5 : 0);
        $price_with_disc = -($total_cost * 0.01 * $discount);
    }
    date_default_timezone_set('Europe/Athens');
    $date = date('Y-m-d H:i:s');

    if (MemberIsReadyToOrder($mid, $date, $_POST['paid'])) {
        $state = ($_POST['paid'] == $total_cost) ? "FULLY_PAID" : "AWAITING_PAYMENT";
        $temp0 = addOrder($mid, $date, $total_cost, $state);

        if (is_string($temp0)) {
            echo "<script>alert('$temp0')</script>";
            return false;
        }
        $oid0 = mysqli_fetch_assoc($temp0);
        $oid = $oid0['oid'];
        $temp = addTransaction($oid, "PAYMENT", $_POST['paid'], $date);
        if (is_string($temp)) {
            echo "<script>alert('$temp')</script>";
            return false;
        }

        foreach ($_SESSION['cart'] as $k => $v) {
            $temp3 = addOrderConsistsOfWine($oid, $k, $_SESSION['cart'][$k]['quantity']);        
            if (is_string($temp3)) {
                echo "<script>alert('$temp3')</script>";
                return false;
            }
        }

        unset($_SESSION['cart']);
    } else {
        $bl = mysqli_fetch_assoc(getBalance($mid));
        $balance = $bl['balance'];
        if ($balance < $_POST['paid']) {
            echo "<script>alert('Insufficient balance. Please add money to your balance.')</script>";
        } else {
            echo "<script>alert('You have unpaid orders older than 10 days. Please pay your debt.')</script>";
        }
    }
}

function checkBasket() {
    if (!empty($_SESSION['cart'])) {
        if (count($_SESSION['cart'], COUNT_NORMAL) < 3) {
            return 0;
        }
        $count = 0;
        foreach ($_SESSION['cart'] as $k => $v) {
            if ($_SESSION['cart'][$k]['quantity'] >= 6) {
                $count++;
            }
        }
        if ($count < 3) {
            return 0;
        }
        return 1;
    }
}

function returnFromOrder($oid, $wid, $amount) {
    $wine = mysqli_fetch_assoc(getWineById($wid));
    if (isMerchant($_SESSION['username'])) {
        if (!checkOrderValidity($oid, $wid, $amount)) {
            echo "<script>alert('Your order cannot have less than 6 bottles of at least 3 different wines')</script>";
            return false;
        }
        $returnValue = $wine['wholesalePrice'] * $amount;
    } else {
        $returnValue = $wine['retailPrice'] * $amount;
    }
    $disc = mysqli_fetch_assoc(getOrderDiscount($oid));
    $returnValue -= $returnValue * $disc['discount'] * 0.01;

    $total_paid = getSumOfTransaction($oid);
    if ($returnValue > $total_paid) {
        echo "<script>alert('You cannot refund items you have not paid for !')</script>";
        return false;
    }
    $temp = updateOrderCost($oid, -$returnValue);
    if (is_string($temp)) {
        echo "<script>alert('$temp')</script>";
        return false;
    }
    date_default_timezone_set('Europe/Athens');
    $date = date('Y-m-d H:i:s');

    $temp = addTransaction($oid, "REFUND", $returnValue, $date);
    if (is_string($temp)) {
        echo "<script>alert('$temp')</script>";
        return false;
    }
    $mid0 = mysqli_fetch_assoc(getMidFromUsername($_SESSION['username']));
    $mid = $mid0['mid'];
    $temp = updateOrderContent($oid, $wid, $amount);
    if (is_string($temp)) {
        echo "<script>alert('$temp')</script>";
        return false;
    }
    return true;
}
