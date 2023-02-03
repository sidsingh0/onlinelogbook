<?php 
session_start();
if(isset($_COOKIE["username"])){
    $username = $_COOKIE["username"];
}else{
    header("Location: /logbook_online/onlinelogbook/index.php");
}
?>