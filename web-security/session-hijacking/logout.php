<?php
session_start();
session_destroy();
setcookie("sessionid", "", time()-3600, "/"); 
header("Location: index.php");
?>

