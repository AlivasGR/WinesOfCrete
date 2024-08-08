<?php 
session_start();
setcookie('username', $_SESSION['username'], time()-3600);
$_SESSION = array(); 
session_destroy();
?>
<meta http-equiv="refresh" content="0;index.php">
