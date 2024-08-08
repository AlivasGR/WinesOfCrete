<div class = "nav" id ="navbar">
    <div id ="navleft" class = "innernav">
        <ul>
            <li><a href = "index.php">Home</a></li>
            <li><a href = "trendingWines.php?navc=navctrending">Trending</a></li>
            <li><a href = "memberStatus.php?navc=navcmemberStatus">Reliable & unreliable members</a></li>
            <?php
            if (!empty($_SESSION['username']) || isset($_COOKIE['username'])) {
                echo "<li><a href = \"eshop.php?navc=navceshop\">E-SHOP</a></li>";
            } else {
                echo "<li><a href = \"register.php?navc=navcregister\">Register</a></li>";                
            }
            ?>
            
        </ul>
    </div>
    <div id ="navcenter" class ="innernav">
        <?php
        $p = "navchome";
        if (isset($_GET["navc"])) {
            $p = $_GET["navc"];
        }
        $page = $p . ".php";
        if (file_exists($page)) {
            include($page);
        } else {
            include("navchome.php");
        }
        ?>
    </div>
    <div id ="navright" class = "innernav">
        <?php     
        if (!empty($_SESSION['username']) || isset($_COOKIE['username'])) {
            //echo "<script>alert('Session found');</script>";
            if (empty($_SESSION['username'])) {
                $_SESSION['username'] = $_COOKIE['username'];
            }
            include("navrlogged.php"); 
        } elseif (!empty($_POST['usernamemini']) && !empty($_POST['passwordmini'])) {
            //echo "<script>alert('login sumbitted');</script>";
            $uid = $_POST['usernamemini'];
            $pass = md5($_POST['passwordmini']);
            if (checkMember($uid, $pass)) {
                $_SESSION['username'] = $uid;      
                setcookie('username', $uid, strtotime( '+30 days' ) );
                echo "<meta http-equiv='refresh' content='=0;index.php' />";
            } else {
                echo "<script>alert('Wrong Username or Password');</script>";
                include("navrunlogged.php");
            }
        } else {
            //echo "<script>alert('Session not found');</script>";
            include("navrunlogged.php");
        }
        ?>
    </div>
</div>