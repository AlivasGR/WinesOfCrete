<?php
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

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$uidErr = $pass1Err = $pass2Err = $fnmErr = $lnmErr = $telErr = $crdErr = $bnkErr = $ctrErr = $citErr = $adrErr = "";
$uid = $pass1 = $pass2 = $fnm = $lnm = $tel = $crd = $bnk = $ctr = $cit = $adr = $mer = "";
$flag = true;
$visits = 0;

function validateUser() {
    if (empty($_POST["username"])) {
        $GLOBALS['uidErr'] = "Username is Required";
        return false;
    } elseif (!preg_match("/[A-Za-z]{4,30}/", $_POST["username"])) {
        $GLOBALS['uidErr'] = "Incorrect Format. Only 4 to 30 letters allowed";
        return false;
    } elseif (!checkValidUsername($_POST["username"])) {
        $GLOBALS['uidErr'] = "Username Unavailable";
        return false;
    } else {
        $GLOBALS['uid'] = test_input($_POST["username"]);
        //echo "<p>" . $GLOBALS['uid'] . "</p><br/>";
        return true;
    }
}

function validatePass() {
    if (empty($_POST["password"])) {
        $GLOBALS['pass1Err'] = "Password is Required";
        return false;
    } elseif (!preg_match("/(?=^.{8,30}$)(?=.*[^a-zA-Z0-9])(?=.*[a-zA-Z])(?=.*[0-9]).*$/", $_POST["password"])) {
        $GLOBALS['pass1Err'] = "Incorrect Format. Only 8 to 30 characters, at least 1 lower, 1 upper, 1 number, and 1 special character required";
        return false;
    } else {
        $GLOBALS['pass1'] = test_input($_POST["password"]);
        //echo "<p>".$GLOBALS['pass1']."</p><br/>";
        return true;
    }
}

function checkPass() {
    if (empty($_POST["password2"])) {
        $GLOBALS['pass2Err'] = "Confirm password is Required";
        return false;
    } elseif (strcmp($GLOBALS['pass1'], $_POST["password2"]) != 0) {
        $GLOBALS['pass2Err'] = "Passwords don't match";
        return false;
    } else {
        $GLOBALS['pass2'] = test_input($_POST["password2"]);
        //echo "<p>".$GLOBALS['pass2']."</p><br/>";
        return true;
    }
}

function validateFname() {
    if (empty($_POST["firstname"])) {
        $GLOBALS['fnmErr'] = "First Name is Required";
        return false;
    } elseif (!preg_match("/[A-Za-z]{4,30}/", $_POST["firstname"])) {
        $GLOBALS['fnmErr'] = "Incorrect Format. Only 4 to 30 letters allowed";
        return false;
    } else {
        $GLOBALS['fnm'] = test_input($_POST["firstname"]);
        //echo "<p>".$GLOBALS['fnm']."</p><br/>";
        return true;
    }
}

function validateLname() {
    if (empty($_POST["lastname"])) {
        $GLOBALS['lnmErr'] = "Last Name is Required";
        return false;
    } elseif (!preg_match("/[A-Za-z]{4,30}/", $_POST["lastname"])) {
        $GLOBALS['lnmErr'] = "Incorrect Format. Only 4 to 30 letters allowed";
        return false;
    } else {
        $GLOBALS['lnm'] = test_input($_POST["lastname"]);
        //echo "<p>".$GLOBALS['lnm']."</p><br/>";
        return true;
    }
}

function validateTel() {
    if (empty($_POST["tel"])) {
        $GLOBALS['telErr'] = "Telephone is Required";
        return false;
    } elseif (!preg_match("/[0-9]{10}/", $_POST["tel"])) {
        $GLOBALS['telErr'] = "Incorrect Format. Telephone numbers are 10-digit long";
        return false;
    } else {
        $GLOBALS['tel'] = test_input($_POST["tel"]);
        //echo "<p>".$GLOBALS['tel']."</p><br/>";
        return true;
    }
}

function validateCardno() {
    if (empty($_POST["cardno"])) {
        $GLOBALS['crdErr'] = "Card Number is Required";
        return false;
    } elseif (!preg_match("/([0-9]{4}-){3}[0-9]{4}/", $_POST["cardno"])) {
        $GLOBALS['crdErr'] = "Incorrect Format. Card numbers are in  the form xxxx-xxxx-xxxx-xxxx";
        return false;
    } else {
        $GLOBALS['crd'] = test_input($_POST["cardno"]);
        //echo "<p>".$GLOBALS['crd']."</p><br/>";
        return true;
    }
}

function validateBankno() {
    if (empty($_POST["bankno"])) {
        $GLOBALS['bnkErr'] = "Bank Number is Required";
        return false;
    } elseif (!preg_match("/GR([0-9]{2})-([0-9]{4}-){5}[0-9]{3}/", $_POST["bankno"])) {
        $GLOBALS['bnkErr'] = "Incorrect Format. Bank numbers are in  the form GRxx-xxxx-xxxx-xxxx-xxxx-xxxx-xxx";
        return false;
    } else {
        $GLOBALS['bnk'] = test_input($_POST["bankno"]);
        //echo "<p>".$GLOBALS['crd']."</p><br/>";
        return true;
    }
}

function validateCountry() {
    if (empty($_POST["country"])) {
        $GLOBALS['ctrErr'] = "Country is Required";
        return false;
    } else {
        $GLOBALS['ctr'] = test_input($_POST["country"]);
        //echo "<p>".$GLOBALS['ctr']."</p><br/>";
        return true;
    }
}

function validateCity() {
    if (empty($_POST["city"])) {
        $GLOBALS['citErr'] = "City is Required";
        return false;
    } elseif (!preg_match("/[\w]{2,30}/", $_POST["city"])) {
        $GLOBALS['citErr'] = "Incorrect Format. 2 to 30 characters allowed";
        return false;
    } else {
        $GLOBALS['cit'] = test_input($_POST["city"]);
        //echo "<p>".$GLOBALS['cit']."</p><br/>";
        return true;
    }
}

function validateAddress() {
    if (empty($_POST["address"])) {
        $GLOBALS['adrErr'] = "Address is Required";
        return false;
    } elseif (!preg_match("/[\w]{2,30}/", $_POST["address"])) {
        $GLOBALS['adrErr'] = "Incorrect Format. 2 to 30 characters allowed";
        return false;
    } else {
        $GLOBALS['adr'] = test_input($_POST["address"]);
        //echo "<p>".$GLOBALS['adr']."</p><br/>";
        return true;
    }
}

function validateMerchant() {
    $GLOBALS['mer'] = test_input($_POST["merselect"]);
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!validateUser() || !validatePass() || !checkPass() || !validateFname() || !validateLname() || !validateTel() || !validateCardno() || !validateBankno() || !validateCountry() || !validateCity() || !validateAddress() || !validateMerchant()) {
        $flag = false;
        $visits = 1;
    }
    if ($flag == true) {
        $morc = 0;
        if ($mer == 1) {
            $morc = 1;
        }
        if(!addMember($uid, md5($pass1), $fnm, $lnm, $tel, $crd, $bnk, $ctr, $cit, $adr, $morc)){
            echo "<script>alert('Account can't be created I am sorry.')</script>";       
        }
        include("mcregsuc.php");
        $visits = 1;
    }
}

if ($visits == 0 || $flag == false) {
    include("mcregister.php");
}
include("footer.php");
