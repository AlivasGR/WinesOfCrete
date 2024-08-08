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

function displayWines($wineTable, $isMerchant) {
    $displayed = "";
    $displayedPrice = ($isMerchant == 1) ? ("wholesalePrice") : ("retailPrice");
    $joined = winesJOINVarieties();
    while ($row = mysqli_fetch_assoc($wineTable)) {
        $displayed = $displayed .
                "<div class=\"wineContainer\">" .
                "<a href=\"" . $row["photo"] . "\"target=\"_blank\">" .
                "<img class=\"wineImage\" src=\"" . $row["photo"] . "\" alt=\"Wine\">" .
                "</a>" .
                "<p><b>" . $row["name"] . "</b>" .
                "<br/><br/>Οινοποιείο Παραγωγής: " . $row["winery"] .
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
                "<form action = \"eshop.php?mode=add&wid=" . $row["wid"] . "\" method = \"post\">" .
                "<input method=\"post\" value=\"1\" name=\"quantity\" type=\"text\" pattern=\"[1-9][0-9]*\" placeholder=\"Ποσότητα\">" .
                "<input type=\"submit\" value=\"Προσθήκη στο καλάθι\"></form>" .
                "</div>";
    }
    echo $displayed;
}
?>
<div class ="Container" id ="mastercontainer">
    <div class="filterArea">
        
        <form method="post" action="eshop.php?navc=navceshop">
            <table>
                <tr>
                    <td>
                        Όνομα:
                        <input name="search" type="text" placeholder="Αναζήτηση κρασιού...">
                    </td>
                    <td>
                        Έτος παραγωγής:
                        <input name="dateLower" type="text" pattern="[1-9][0-9]*" placeholder="Από...">
                    </td>
                    <td>
                        Έτος παραγωγής:
                        <input name="dateUpper" type="text" pattern="[1-9][0-9]*" placeholder="Μέχρι...">
                    </td>
                    <td>
                        Τιμή:
                        <input name="priceLower" type="text" pattern="[1-9][0-9]*" placeholder="Από...">    
                    </td>
                    <td>
                        Τιμή:
                        <input name="priceUpper" type="text" pattern="[1-9][0-9]*" placeholder="Μέχρι...">    
                    </td>
                </tr>
                <tr>
                    <td>
                        Χρώμα:
                        <select name="color">
                            <option value="any">Οποιοδήποτε</option>
                            <option value="Κόκκινο">Κόκκινο</option>
                            <option value="Λευκό">Λευκό</option>
                            <option value="Ροζέ">Ροζέ</option>
                        </select>
                    </td>
                    <td>
                        Οινοποιείο:
                        <select name="winery">
                            <option value="any">Οποιοδήποτε</option>
                            <option value="Δουλουφάκης Οινοποιείο">Δουλουφάκης Οινοποιείο</option>
                            <option value="ALEXAKIS WINERY">ALEXAKIS WINERY</option>
                            <option value="Μανουσάκη Οινοποιία">Μανουσάκη Οινοποιία</option>
                            <option value="Αμπελώνες Καραβιτάκη">Αμπελώνες Καραβιτάκη</option>
                            <option value="ΜΙΝΩΣ Κρασιά Κρήτης ΑΕ – Οινοποιείο Μηλιαράκη">ΜΙΝΩΣ Κρασιά Κρήτης ΑΕ – Οινοποιείο Μηλιαράκη</option>
                            <option value="Οινοποιείο Αφοί Σπ. Μαραγκάκη">Οινοποιείο Αφοί Σπ. Μαραγκάκη</option>
                            <option value="Ρους Οινοποιία Ταμιωλακη">Ρους Οινοποιία Ταμιωλακη</option>
                            <option value="Κτήμα Μιχαλάκη">Κτήμα Μιχαλάκη</option>
                            <option value="Οινοποιείο Ευφροσύνη">Οινοποιείο Ευφροσύνη</option>
                            <option value="Ιδαια Οινοποιητική">Ιδαια Οινοποιητική</option>
                            <option value="Λυραράκης - ΓΕΑ ΑΕ">Λυραράκης - ΓΕΑ ΑΕ</option>
                            <option value="Silva Δασκαλάκη">Silva Δασκαλάκη</option>                      
                        </select>
                    </td>
                    <td>
                        Ποικιλία:
                        <select name="variety">
                            <option value="any">Οποιαδήποτε</option>
                            <option value="Cabernet Sauvignon">Cabernet Sauvignon</option>
                            <option value="Chardonnay">Chardonnay</option>
                            <option value="Merlot">Merlot</option>
                            <option value="Roussanne">Roussanne</option>
                            <option value="Sangiovese">Sangiovese</option>
                            <option value="Sauvignon Blanc">Sauvignon Blanc</option>
                            <option value="Syrah">Syrah</option>
                            <option value="Βηλάνα">Βηλάνα</option>
                            <option value="Βιδιανό">Βιδιανό</option>
                            <option value="Δαφνί">Δαφνί</option>
                            <option value="Θραψαθήρι">Θραψαθήρι</option>
                            <option value="Κοτσιφάλι">Κοτσιφάλι</option>
                            <option value="Λιάτικο">Λιάτικο</option>                         	
                            <option value="Μαλβαζία">Μαλβαζία</option>
                            <option value="Μαντηλάρι">Μαντηλάρι</option>
                            <option value="Μοσχάτο Λευκό">Μοσχάτο Λευκό</option>
                            <option value="Πλυτό">Πλυτό</option>
                            <option value="Ρωμέικο">Ρωμέικο</option>
                        </select>
                    </td>  
                    <td>
                        <input type="submit" name="searchBtn" value="Αναζήτηση">
                    </td>
                    <td>
                        <input type="submit" name="clearBtn" value="Καθαρισμός φίλτρων">
                    </td>                    
                </tr>
            </table>
        </form>  
    </div>
    <?php
    if(isset($_POST["searchBtn"])){
        $displayedWines = searchWinesAllFilters($_POST["search"], 
                $_POST["dateLower"], $_POST["dateUpper"], 
                $_POST["priceLower"], $_POST["priceUpper"], $_POST["color"], 
                $_POST["winery"], $_POST["variety"], 
                                             isMerchant($_SESSION['username']));
    }
    else{
        $displayedWines = getWines();
    }
    displayWines($displayedWines, isMerchant($_SESSION['username']));
    ?>
</div>
<?php include("footer.php");