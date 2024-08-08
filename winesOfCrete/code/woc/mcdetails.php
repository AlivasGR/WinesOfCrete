<?php
$user = mysqli_fetch_assoc(getMember($_SESSION['username']));

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$pass0Err = $pass1Err = $pass2Err = $fnmErr = $lnmErr = $telErr = $crdErr = $bnkErr = $ctrErr = $citErr = $adrErr = "";
$pass0 = $pass1 = $pass2 = $fnm = $lnm = $tel = $crd = $bnk = $ctr = $cit = $adr = "";

function checkOldPass() {
    if (empty($_POST["opass"])) {
        $GLOBALS['pass0Err'] = "Old Password is Required";
        return false;
    } elseif (!preg_match("/(?=^.{8,30}$)(?=.*[^a-zA-Z0-9])(?=.*[a-zA-Z])(?=.*[0-9]).*$/", $_POST["opass"])) {
        $GLOBALS['pass0Err'] = "Incorrect Format. Only 8 to 30 characters, at least 1 lower, 1 upper, 1 number, and 1 special character required";
        return false;
    } elseif (strcmp(md5($_POST["opass"]), $GLOBALS['user']['password']) != 0) {
        $GLOBALS['pass0Err'] = "This isn't your old password";
    } else {
        $GLOBALS['pass0'] = test_input($_POST["opass"]);
        return true;
    }
}

function validatePass() {
    if (empty($_POST["pass1"])) {
        $GLOBALS['pass1Err'] = "New Password is Required";
        return false;
    } elseif (!preg_match("/(?=^.{8,30}$)(?=.*[^a-zA-Z0-9])(?=.*[a-zA-Z])(?=.*[0-9]).*$/", $_POST["pass1"])) {
        $GLOBALS['pass1Err'] = "Incorrect Format. Only 8 to 30 characters, at least 1 lower, 1 upper, 1 number, and 1 special character required";
        return false;
    } else {
        $GLOBALS['pass1'] = test_input($_POST["pass1"]);
//echo "<p>".$GLOBALS['pass1']."</p><br/>";
        return true;
    }
}

function checkPass() {
    if (empty($_POST["pass2"])) {
        $GLOBALS['pass2Err'] = "Confirm password is Required";
        return false;
    } elseif (strcmp($GLOBALS['pass1'], $_POST["pass2"]) != 0) {
        $GLOBALS['pass2Err'] = "Passwords don't match";
        return false;
    } else {
        $GLOBALS['pass2'] = test_input($_POST["pass2"]);
//echo "<p>".$GLOBALS['pass2']."</p><br/>";
        return true;
    }
}

function validateFname() {
    if (empty($_POST["fname"])) {
        $GLOBALS['fnmErr'] = "First Name is Required";
        return false;
    } elseif (!preg_match("/[A-Za-z]{4,30}/", $_POST["fname"])) {
        $GLOBALS['fnmErr'] = "Incorrect Format. Only 4 to 30 letters allowed";
        return false;
    } else {
        $GLOBALS['fnm'] = test_input($_POST["fname"]);
//echo "<p>".$GLOBALS['fnm']."</p><br/>";
        return true;
    }
}

function validateLname() {
    if (empty($_POST["lname"])) {
        $GLOBALS['lnmErr'] = "Last Name is Required";
        return false;
    } elseif (!preg_match("/[A-Za-z]{4,30}/", $_POST["lname"])) {
        $GLOBALS['lnmErr'] = "Incorrect Format. Only 4 to 30 letters allowed";
        return false;
    } else {
        $GLOBALS['lnm'] = test_input($_POST["lname"]);
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
        $GLOBALS['crdErr'] = "Credit Card is Required";
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
        $GLOBALS['bnkErr'] = "Bank number is Required";
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

if (!empty($_POST['fname'])) {
    if (validateFname()) {
        updateMember($user['username'], $user['password'], $fnm, $user['lname'], $user['tel'], $user['cardno'], $user['bank_no'], $user['country'], $user['city'], $user['address'], $user['debt']);
    }
}

if (!empty($_POST['lname'])) {
    if (validateLname()) {
        updateMember($user['username'], $user['password'], $user['fname'], $lnm, $user['tel'], $user['cardno'], $user['bank_no'], $user['country'], $user['city'], $user['address'], $user['debt']);
    }
}

if (!empty($_POST['pass1'])) {
    if (validatePass() && checkOldPass() && checkPass()) {
        updateMember($user['username'], md5($pass1), $user['fname'], $user['lname'], $user['tel'], $user['cardno'], $user['bank_no'], $user['country'], $user['city'], $user['address'], $user['debt']);
    }
}

if (!empty($_POST['tel'])) {
    if (validateTel()) {
        updateMember($user['username'], $user['password'], $user['fname'], $user['lname'], $tel, $user['cardno'], $user['bank_no'], $user['country'], $user['city'], $user['address'], $user['debt']);
    }
}

if (!empty($_POST['cardno'])) {
    if (validateCardno()) {
        updateMember($user['username'], $user['password'], $user['fname'], $user['lname'], $user['tel'], $crd, $user['bank_no'], $user['country'], $user['city'], $user['address'], $user['debt']);
    }
}

if (!empty($_POST['bankno'])) {
    if (validateBankno()) {
        updateMember($user['username'], $user['password'], $user['fname'], $user['lname'], $user['tel'], $user['cardno'], $bnk, $user['country'], $user['city'], $user['address'], $user['debt']);
    }
}

if (!empty($_POST['country'])) {
    if (validateCountry()) {
        updateMember($user['username'], $user['password'], $user['fname'], $user['lname'], $user['tel'], $user['cardno'], $user['bank_no'], $ctr, $user['city'], $user['address'], $user['debt']);
    }
}

if (!empty($_POST['city'])) {
    if (validateCity()) {
        updateMember($user['username'], $user['password'], $user['fname'], $user['lname'], $user['tel'], $user['cardno'], $user['bank_no'], $user['country'], $cit, $user['address'], $user['debt']);
    }
}

if (!empty($_POST['address'])) {
    if (validateAddress()) {
        updateMember($user['username'], $user['password'], $user['fname'], $user['lname'], $user['tel'], $user['cardno'], $user['bank_no'], $user['country'], $user['city'], $adr, $user['debt']);
    }
}

$user = mysqli_fetch_assoc(getMember($_SESSION['username']));
?>
<ul id ="detailslist">
    <li id ="balancefield">
        <div class = "detail" id = "balancebox">
            <form class ="updbalform" method ="post" action ="profile.php?navc=navcprofile&mc=mcdetails">
                <label for ="balance">Update Balance</label>
                <input type ="text" value ="0" pattern = "^([0-9]+\.)?[0-9]+$" name ="balance"/>
                <input type ="submit" value ="Submit"/>
            </form>
            <h2>Balance</h2>
            <p><?php echo $user['balance'] . " €"; ?></p>
        </div>
    </li>
    <li id ="fnamefield">
        <div class = "detail" id = "fnamebox">
            <input type = "button" value = "Edit" class = "editbutton" onclick = "toggler('fnameform')"/>
            <h2>First Name</h2>
            <p><?php echo $user['fname']; ?></p>
            <form class ="hiddenform" id ="fnameform" method = "post" action = "profile.php?navc=navcprofile&mc=mcdetails">
                <label for ="fname">Edit First Name:</label><br/>
                <input type ="text" pattern = "[\w]{4,30}" name = "fname" placeholder ="Enter New First Name"/><br/><p class = "errmsg" id ="fnmmsg"><?php echo $fnmErr; ?></p>
                <input type ="submit" value ="Submit"><br/>
            </form>
        </div>
    </li>
    <li id ="lnamefield">
        <div class = "detail" id = "lnamebox">
            <input type = "button" value = "Edit" class = "editbutton" onclick = "toggler('lnameform')"/>
            <h2>Last Name</h2>
            <p><?php echo $user['lname']; ?></p>
            <form class ="hiddenform" pattern = "[\w]{4,30}" id ="lnameform" method = "post" action = "profile.php?navc=navcprofile&mc=mcdetails">
                <label for ="lname">Edit Last Name:</label><br/>
                <input type ="text" name = "lname" placeholder ="Enter New Last Name"/><br/><p class = "errmsg" id ="lnmmsg"><?php echo $lnmErr; ?></p>
                <input type ="submit" value ="Submit"><br/>
            </form>
        </div>
    </li>
    <li id ="debtfield">
        <div class = "detail" id = "debtbox">
            <h2>Debt</h2>
            <p><?php echo $user['debt']; ?></p>
        </div>
    </li>
    <li id ="pwdfield">
        <div class = "detail" id = "pwdbox">
            <input type = "button" value = "Edit" class = "editbutton" onclick = "toggler('pform')"/>
            <h2>Password</h2>
            <form class ="hiddenform" id ="pform" method = "post" action = "profile.php?navc=navcprofile&mc=mcdetails">
                <label for ="opass">Edit Password:</label><br/>
                <input type ="password" pattern ="(?=^.{8,30}$)(?=.*[^a-zA-Z0-9])(?=.*[a-zA-Z])(?=.*[0-9]).*$" name = "opass" placeholder ="Enter Old Password"/><br/><p class ="errmsg" id ="pwd0msg"><?php echo $pass0Err; ?></p>
                <input type ="password" pattern ="(?=^.{8,30}$)(?=.*[^a-zA-Z0-9])(?=.*[a-zA-Z])(?=.*[0-9]).*$" name = "pass1" placeholder ="Enter New Password"/><br/><p class = "errmsg" id ="pwdmsg"><?php echo $pass1Err; ?></p>
                <input type ="password" pattern ="(?=^.{8,30}$)(?=.*[^a-zA-Z0-9])(?=.*[a-zA-Z])(?=.*[0-9]).*$" name = "pass2" placeholder ="Re-Enter New Password"/><br/><p class = "errmsg" id ="pwd2msg"><?php echo $pass2Err; ?></p>
                <input type ="submit" value ="Submit"><br/>
            </form>
        </div>
    </li>
    <li id ="telfield">
        <div class = "detail" id = "telbox">
            <input type = "button" value = "Edit" class = "editbutton" onclick = "toggler('telform')"/>
            <h2>Telephone</h2>
            <p><?php echo $user['tel']; ?></p>      
            <form class ="hiddenform" id ="telform" method = "post" action = "profile.php?navc=navcprofile&mc=mcdetails">
                <label for ="tel">Edit Telephone:</label><br/>
                <input type ="text" pattern = "[0-9]{10}" name = "tel" placeholder ="Enter New Telephone"/><br/><p class = "errmsg" id ="telmsg"><?php echo $telErr; ?></p>
                <input type ="submit" value ="Submit"><br/>
            </form>
        </div>
    </li>
    <li id ="cardfield">
        <div class = "detail" id = "cardbox">
            <input type = "button" value = "Edit" class = "editbutton" onclick = "toggler('cardform')"/>
            <h2>Credit Card</h2>
            <p><?php echo $user['cardno']; ?></p>
            <form class ="hiddenform" id ="cardform" method = "post" action = "profile.php?navc=navcprofile&mc=mcdetails">
                <label for ="cardno">Edit Card Number:</label><br/>
                <input type ="text" pattern = "([0-9]{4}-){3}[0-9]{4}" name = "cardno" placeholder ="Enter New Card Number"/><br/><p class = "errmsg" id ="crdmsg"><?php echo $crdErr; ?></p>
                <input type ="submit" value ="Submit"><br/>
            </form>
        </div>
    </li>
    <li id ="bankfield">
        <div class = "detail" id = "bankbox">
            <input type = "button" value = "Edit" class = "editbutton" onclick = "toggler('bankform')"/>
            <h2>Bank Account Number</h2>
            <p><?php echo $user['bank_no']; ?></p>
            <form class ="hiddenform" id ="bankform" method = "post" action = "profile.php?navc=navcprofile&mc=mcdetails">
                <label for ="bankno">Edit Bank Account Number:</label><br/>
                <input type ="text" pattern = "GR([0-9]{2})-([0-9]{4}-){5}[0-9]{3}" name = "bankno" placeholder ="Enter New Bank Account Number"/><br/><p class = "errmsg" id ="bnkmsg"><?php echo $bnkErr; ?></p>
                <input type ="submit" value ="Submit"><br/>
            </form>
        </div>
    </li>
    <li id ="ctrfield">
        <div class = "detail" id = "ctrbox">
            <input type = "button" value = "Edit" class = "editbutton" onclick = "toggler('ctrform')"/>
            <h2>Country</h2>
            <p><?php echo $user['country']; ?></p>
            <form class ="hiddenform" id ="ctrform" method = "post" action = "profile.php?navc=navcprofile&mc=mcdetails">
                <select id = "ctr" name = "country">
                    <option value="AF">Afghanistan</option>
                    <option value="AX">Åland Islands</option>
                    <option value="AL">Albania</option>
                    <option value="DZ">Algeria</option>
                    <option value="AS">American Samoa</option>
                    <option value="AD">Andorra</option>
                    <option value="AO">Angola</option>
                    <option value="AI">Anguilla</option>
                    <option value="AQ">Antarctica</option>
                    <option value="AG">Antigua and Barbuda</option>
                    <option value="AR">Argentina</option>
                    <option value="AM">Armenia</option>
                    <option value="AW">Aruba</option>
                    <option value="AU">Australia</option>
                    <option value="AT">Austria</option>
                    <option value="AZ">Azerbaijan</option>
                    <option value="BS">Bahamas</option>
                    <option value="BH">Bahrain</option>
                    <option value="BD">Bangladesh</option>
                    <option value="BB">Barbados</option>
                    <option value="BY">Belarus</option>
                    <option value="BE">Belgium</option>
                    <option value="BZ">Belize</option>
                    <option value="BJ">Benin</option>
                    <option value="BM">Bermuda</option>
                    <option value="BT">Bhutan</option>
                    <option value="BO">Bolivia, Plurinational State of</option>
                    <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                    <option value="BA">Bosnia and Herzegovina</option>
                    <option value="BW">Botswana</option>
                    <option value="BV">Bouvet Island</option>
                    <option value="BR">Brazil</option>
                    <option value="IO">British Indian Ocean Territory</option>
                    <option value="BN">Brunei Darussalam</option>
                    <option value="BG">Bulgaria</option>
                    <option value="BF">Burkina Faso</option>
                    <option value="BI">Burundi</option>
                    <option value="KH">Cambodia</option>
                    <option value="CM">Cameroon</option>
                    <option value="CA">Canada</option>
                    <option value="CV">Cape Verde</option>
                    <option value="KY">Cayman Islands</option>
                    <option value="CF">Central African Republic</option>
                    <option value="TD">Chad</option>
                    <option value="CL">Chile</option>
                    <option value="CN">China</option>
                    <option value="CX">Christmas Island</option>
                    <option value="CC">Cocos (Keeling) Islands</option>
                    <option value="CO">Colombia</option>
                    <option value="KM">Comoros</option>
                    <option value="CG">Congo</option>
                    <option value="CD">Congo, the Democratic Republic of the</option>
                    <option value="CK">Cook Islands</option>
                    <option value="CR">Costa Rica</option>
                    <option value="CI">Côte d'Ivoire</option>
                    <option value="HR">Croatia</option>
                    <option value="CU">Cuba</option>
                    <option value="CW">Curaçao</option>
                    <option value="CY">Cyprus</option>
                    <option value="CZ">Czech Republic</option>
                    <option value="DK">Denmark</option>
                    <option value="DJ">Djibouti</option>
                    <option value="DM">Dominica</option>
                    <option value="DO">Dominican Republic</option>
                    <option value="EC">Ecuador</option>
                    <option value="EG">Egypt</option>
                    <option value="SV">El Salvador</option>
                    <option value="GQ">Equatorial Guinea</option>
                    <option value="ER">Eritrea</option>
                    <option value="EE">Estonia</option>
                    <option value="ET">Ethiopia</option>
                    <option value="FK">Falkland Islands (Malvinas)</option>
                    <option value="FO">Faroe Islands</option>
                    <option value="FJ">Fiji</option>
                    <option value="FI">Finland</option>
                    <option value="FR">France</option>
                    <option value="GF">French Guiana</option>
                    <option value="PF">French Polynesia</option>
                    <option value="TF">French Southern Territories</option>
                    <option value="GA">Gabon</option>
                    <option value="GM">Gambia</option>
                    <option value="GE">Georgia</option>
                    <option value="DE">Germany</option>
                    <option value="GH">Ghana</option>
                    <option value="GI">Gibraltar</option>
                    <option value="GR" selected>Greece</option>
                    <option value="GL">Greenland</option>
                    <option value="GD">Grenada</option>
                    <option value="GP">Guadeloupe</option>
                    <option value="GU">Guam</option>
                    <option value="GT">Guatemala</option>
                    <option value="GG">Guernsey</option>
                    <option value="GN">Guinea</option>
                    <option value="GW">Guinea-Bissau</option>
                    <option value="GY">Guyana</option>
                    <option value="HT">Haiti</option>
                    <option value="HM">Heard Island and McDonald Islands</option>
                    <option value="VA">Holy See (Vatican City State)</option>
                    <option value="HN">Honduras</option>
                    <option value="HK">Hong Kong</option>
                    <option value="HU">Hungary</option>
                    <option value="IS">Iceland</option>
                    <option value="IN">India</option>
                    <option value="ID">Indonesia</option>
                    <option value="IR">Iran, Islamic Republic of</option>
                    <option value="IQ">Iraq</option>
                    <option value="IE">Ireland</option>
                    <option value="IM">Isle of Man</option>
                    <option value="IL">Israel</option>
                    <option value="IT">Italy</option>
                    <option value="JM">Jamaica</option>
                    <option value="JP">Japan</option>
                    <option value="JE">Jersey</option>
                    <option value="JO">Jordan</option>
                    <option value="KZ">Kazakhstan</option>
                    <option value="KE">Kenya</option>
                    <option value="KI">Kiribati</option>
                    <option value="KP">Korea, Democratic People's Republic of</option>
                    <option value="KR">Korea, Republic of</option>
                    <option value="KW">Kuwait</option>
                    <option value="KG">Kyrgyzstan</option>
                    <option value="LA">Lao People's Democratic Republic</option>
                    <option value="LV">Latvia</option>
                    <option value="LB">Lebanon</option>
                    <option value="LS">Lesotho</option>
                    <option value="LR">Liberia</option>
                    <option value="LY">Libya</option>
                    <option value="LI">Liechtenstein</option>
                    <option value="LT">Lithuania</option>
                    <option value="LU">Luxembourg</option>
                    <option value="MO">Macao</option>
                    <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                    <option value="MG">Madagascar</option>
                    <option value="MW">Malawi</option>
                    <option value="MY">Malaysia</option>
                    <option value="MV">Maldives</option>
                    <option value="ML">Mali</option>
                    <option value="MT">Malta</option>
                    <option value="MH">Marshall Islands</option>
                    <option value="MQ">Martinique</option>
                    <option value="MR">Mauritania</option>
                    <option value="MU">Mauritius</option>
                    <option value="YT">Mayotte</option>
                    <option value="MX">Mexico</option>
                    <option value="FM">Micronesia, Federated States of</option>
                    <option value="MD">Moldova, Republic of</option>
                    <option value="MC">Monaco</option>
                    <option value="MN">Mongolia</option>
                    <option value="ME">Montenegro</option>
                    <option value="MS">Montserrat</option>
                    <option value="MA">Morocco</option>
                    <option value="MZ">Mozambique</option>
                    <option value="MM">Myanmar</option>
                    <option value="NA">Namibia</option>
                    <option value="NR">Nauru</option>
                    <option value="NP">Nepal</option>
                    <option value="NL">Netherlands</option>
                    <option value="NC">New Caledonia</option>
                    <option value="NZ">New Zealand</option>
                    <option value="NI">Nicaragua</option>
                    <option value="NE">Niger</option>
                    <option value="NG">Nigeria</option>
                    <option value="NU">Niue</option>
                    <option value="NF">Norfolk Island</option>
                    <option value="MP">Northern Mariana Islands</option>
                    <option value="NO">Norway</option>
                    <option value="OM">Oman</option>
                    <option value="PK">Pakistan</option>
                    <option value="PW">Palau</option>
                    <option value="PS">Palestinian Territory, Occupied</option>
                    <option value="PA">Panama</option>
                    <option value="PG">Papua New Guinea</option>
                    <option value="PY">Paraguay</option>
                    <option value="PE">Peru</option>
                    <option value="PH">Philippines</option>
                    <option value="PN">Pitcairn</option>
                    <option value="PL">Poland</option>
                    <option value="PT">Portugal</option>
                    <option value="PR">Puerto Rico</option>
                    <option value="QA">Qatar</option>
                    <option value="RE">Réunion</option>
                    <option value="RO">Romania</option>
                    <option value="RU">Russian Federation</option>
                    <option value="RW">Rwanda</option>
                    <option value="BL">Saint Barthélemy</option>
                    <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                    <option value="KN">Saint Kitts and Nevis</option>
                    <option value="LC">Saint Lucia</option>
                    <option value="MF">Saint Martin (French part)</option>
                    <option value="PM">Saint Pierre and Miquelon</option>
                    <option value="VC">Saint Vincent and the Grenadines</option>
                    <option value="WS">Samoa</option>
                    <option value="SM">San Marino</option>
                    <option value="ST">Sao Tome and Principe</option>
                    <option value="SA">Saudi Arabia</option>
                    <option value="SN">Senegal</option>
                    <option value="RS">Serbia</option>
                    <option value="SC">Seychelles</option>
                    <option value="SL">Sierra Leone</option>
                    <option value="SG">Singapore</option>
                    <option value="SX">Sint Maarten (Dutch part)</option>
                    <option value="SK">Slovakia</option>
                    <option value="SI">Slovenia</option>
                    <option value="SB">Solomon Islands</option>
                    <option value="SO">Somalia</option>
                    <option value="ZA">South Africa</option>
                    <option value="GS">South Georgia and the South Sandwich Islands</option>
                    <option value="SS">South Sudan</option>
                    <option value="ES">Spain</option>
                    <option value="LK">Sri Lanka</option>
                    <option value="SD">Sudan</option>
                    <option value="SR">Suriname</option>
                    <option value="SJ">Svalbard and Jan Mayen</option>
                    <option value="SZ">Swaziland</option>
                    <option value="SE">Sweden</option>
                    <option value="CH">Switzerland</option>
                    <option value="SY">Syrian Arab Republic</option>
                    <option value="TW">Taiwan, Province of China</option>
                    <option value="TJ">Tajikistan</option>
                    <option value="TZ">Tanzania, United Republic of</option>
                    <option value="TH">Thailand</option>
                    <option value="TL">Timor-Leste</option>
                    <option value="TG">Togo</option>
                    <option value="TK">Tokelau</option>
                    <option value="TO">Tonga</option>
                    <option value="TT">Trinidad and Tobago</option>
                    <option value="TN">Tunisia</option>
                    <option value="TR">Turkey</option>
                    <option value="TM">Turkmenistan</option>
                    <option value="TC">Turks and Caicos Islands</option>
                    <option value="TV">Tuvalu</option>
                    <option value="UG">Uganda</option>
                    <option value="UA">Ukraine</option>
                    <option value="AE">United Arab Emirates</option>
                    <option value="GB">United Kingdom</option>
                    <option value="US">United States</option>
                    <option value="UM">United States Minor Outlying Islands</option>
                    <option value="UY">Uruguay</option>
                    <option value="UZ">Uzbekistan</option>
                    <option value="VU">Vanuatu</option>
                    <option value="VE">Venezuela, Bolivarian Republic of</option>
                    <option value="VN">Viet Nam</option>
                    <option value="VG">Virgin Islands, British</option>
                    <option value="VI">Virgin Islands, U.S.</option>
                    <option value="WF">Wallis and Futuna</option>
                    <option value="EH">Western Sahara</option>
                    <option value="YE">Yemen</option>
                    <option value="ZM">Zambia</option>
                    <option value="ZW">Zimbabwe</option>
                </select><br/>
                <input type ="submit" value ="Submit"><br/>
            </form>
        </div>
    </li>
    <li id ="cityfield">
        <div class = "detail" id = "citybox">
            <input type = "button" value = "Edit" class = "editbutton" onclick = "toggler('cityform')"/>
            <h2>City</h2>
            <p><?php echo $user['city']; ?></p>
            <form class ="hiddenform" id ="cityform" method = "post" action = "profile.php?navc=navcprofile&mc=mcdetails">
                <label for ="city">Edit City:</label><br/>
                <input type ="text" pattern ="[\w]{2,30}" name = "city" placeholder ="Enter New City"/><br/><p class = "errmsg" id ="citmsg"><?php echo $citErr; ?></p>
                <input type ="submit" value ="Submit"><br/>
            </form>
        </div>
    </li>
    <li id ="adrfield">
        <div class = "detail" id = "adrbox">
            <input type = "button" value = "Edit" class = "editbutton" onclick = "toggler('adressform')"/>
            <h2>Address</h2>
            <p><?php echo $user['address']; ?></p>
            <form class ="hiddenform" id ="adressform" method = "post" action = "profile.php?navc=navcprofile&mc=mcdetails">
                <label for ="address">Edit Address:</label><br/>
                <input type ="text" pattern ="[\w]{2,30}" name = "address" placeholder ="Enter New Address"/><br/><p class = "errmsg" id ="adrmsg" required><?php echo $adrErr; ?></p>
                <input type ="submit" value ="Submit"><br/>
            </form>
        </div>
    </li>
    <li id ="clacfield">
        <div class = "detail" id = "clacbox">
            <h2>Close Account</h2>
            <form method = "post" action = "profile.php?navc=navcprofile&mc=mcdetails">
                <input type = "submit" value = "Close Account" name = "clac" class = "clacbutton"/>
            </form>
        </div>
    </li>
</ul>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clac'])) {
        $user = mysqli_fetch_assoc(getMidFromUsername($_SESSION['username']));
        if (!deleteMember($_SESSION['username'])){            
            echo "<script>alert('You can't close your account. You either have non-zero debt or undelivered orders.')</script>";            
        }
        else echo "<meta http-equiv=\"refresh\" content=\"0;logout.php\">";
    }
}


if (!empty($_POST['balance'])) {
    $user = mysqli_fetch_assoc(getMidFromUsername($_SESSION['username']));
    if ($_POST['balance'] >= 0) {
        updateBalance($user['mid'], $_POST['balance']);
    } else {
        echo "Incorrect balance amount";
    }
    echo "<meta http-equiv=\"refresh\" content=\"0;profile.php?navc=navcprofile&mc=mcdetails\">";;
}
