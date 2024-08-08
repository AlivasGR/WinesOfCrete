<div id ="transfilter">
    <form method ="post" id ="transfilterform" action ="profile.php?navc=navcprofile&mc=mctransactions">
        <label for ="mindate">Select Date Lower Bound</label>
        <input type ="date" name ="mindate"/>
        <label for ="mintime">Select Time Lower Bound</label>
        <input type ="time" name ="mintime"/>
        <label for ="maxdate">Select Date Upper Bound</label>
        <input type ="date" name ="maxdate"/>
        <label for ="maxtime">Select Time Upper Bound</label>
        <input type ="time" name ="maxtime"/>
        <input type ="submit" name = "transfilterbutton" value ="Apply"/>
        <input type ="submit" name ="clearfiltertrans" value ="Clear"/>
    </form>
    <hr/>
</div>
<?php
$mid = mysqli_fetch_assoc(getMidFromUsername($_SESSION['username']));
echo "<div class = \"totaltrans\">";
if (isset($_POST['transfilterbutton'])) {
    $minDate = (!empty($_POST['mindate']) ? $_POST['mindate'] : "1000-01-01") . " " .
            (!empty($_POST['mintime']) ? $_POST['mintime'] : "00:00");
    echo $minDate . " ";
    $maxDate = (!empty($_POST['maxdate']) ? $_POST['maxdate'] : date("Y-m-d")) . " " .
            (!empty($_POST['maxtime']) ? $_POST['maxtime'] : "00:00");
    echo $maxDate . "<br/>";
    $ordertrans = getTransactionsOfMemberInDateInterval($mid['mid'], $minDate, $maxDate);
} else {
    $ordertrans = getTransactionsOfMember($mid['mid']);
}
echo "<table class = \"transtable\">";
echo "<tr><th>Date</th><th>Type</th><th>Amount</th></tr>";
while ($ordertran = mysqli_fetch_assoc($ordertrans)) {
    echo "<tr>";
    echo "<td>" . $ordertran['date'] . "</td>";
    echo "<td>" . $ordertran['type'] . "</td>";
    echo "<td>" . $ordertran['amount'] . " €</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";
