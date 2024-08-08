<a href = "logout.php" id = "logoutmini">Logout</a> 
<img src ="css/cart.png" id ="cart_icon" alt = "cart" onclick = "carttoggler()"/> 
<div id = "cart"> 
    <span id = "cartpop"> 
        <?php manipBasket(); ?> 
    </span> 
</div>
<div id ="profilearea">
    <a href = "profile.php?navc=navcprofile" id = "profilelink"><?php echo $_SESSION['username'] ?></a>
    <div class ="dropdown" id ="usermenu">
        <span id ="menupop">
            <ul id ="userlinks">
                <li class ="userlink"><a href ="profile.php?navc=navcprofile&mc=mcdetails">Account Details</a></li>
                <li class ="userlink"><a href = "profile.php?navc=navcprofile&mc=mcorders">Your Orders</a></li>
                <li class ="userlink"><a href ="profile.php?navc=navcprofile&mc=mctransactions">Transaction History</a></li>
            </ul>
        </span>
    </div>
</div>