<?php
session_start();
include("base.php");
include("MemberDB.php");
include("WineDB.php");
include("OrderDB.php");
include("MakeOrder.php");
include("OrderConsistsOfWineDB.php");
include("Basket.php");
include("header.php");
include("nav.php");

function displayTrendingWines($wineTable) {
    $displayed = "";   
    $i = 1;
    $joined = winesJOINVarieties();    
    while ($row = mysqli_fetch_assoc($wineTable)) {        
        $displayed = $displayed ."<p class=\"trendingNumber\">".$i.".</p>".
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
        $displayed = $displayed."</p>";
        $displayed = $displayed."<div class=\"winesSold\">Πουλήθηκαν<br/>".
                $row["bottlesThisMonth"]."<br/>μπουκάλια</div>";
        $displayed = $displayed . "</div>";       
        $i++;
    }
    echo $displayed;
}
?>
<div class ="Container" id ="mastercontainer">
    <div class="filterArea">        
        <form method="post" action="trendingWines.php?navc=navctrendingWines">
               
            <input type="submit" class = "mostPopularButton" name="searchGeneral" value="Τα δημοφιλέστερα κρασιά του μήνα">
            
            <table>                              
                <tr>
                    <td>
                        Έτος :
                        <select name="year">                           
                            <option value="2002">2002</option>
                            <option value="2005">2005</option>
                            <option value="2007">2007</option>
                            <option value="2009">2009</option>
                            <option value="2011">2011</option>
                            <option value="2012">2012</option>
                            <option value="2013">2013</option>
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                        </select>
                        
                        <input type="submit" name="searchYear" value="Ανά έτος">
                    </td>
                    <td>
                        Χρώμα:
                        <select name="color">                            
                            <option value="Κόκκινο">Κόκκινο</option>
                            <option value="Λευκό">Λευκό</option>
                            <option value="Ροζέ">Ροζέ</option>
                        </select>
                        <input type="submit" name="searchColor" value="Ανά χρώμα">
                    </td>                                      
                    <td>
                        Οινοποιείο:
                        <select name="winery">                            
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
                        <input type="submit" name="searchWinery" value="Ανά οινοποιείο">
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
                        <input type="submit" name="searchVariety" value="Ανά ποικιλία">
                    </td>                     
                </tr>         
            </table>
        </form>  
    </div>
    <?php
    if(isset($_POST["searchGeneral"])){
        $displayedWines = getBestWinesGeneral();
    }
    else if (isset($_POST["searchWinery"])){
        $displayedWines = getBestWinesByWinery($_POST["winery"]);
    }
    else if (isset($_POST["searchColor"])){
        $displayedWines = getBestWinesByColor($_POST["color"]);
    }
    else if (isset($_POST["searchYear"])){
        $displayedWines = getBestWinesByDate($_POST["year"]);
    }
    else if (isset($_POST["searchVariety"])){
        $displayedWines = getBestWinesByVariety($_POST["variety"]);
    }    
    else{
        $displayedWines = getBestWinesGeneral();
    }
    displayTrendingWines($displayedWines);
    ?>
</div>
<?php include("footer.php");