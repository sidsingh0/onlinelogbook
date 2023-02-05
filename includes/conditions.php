<?php 
session_start();

function get_token($username){
    $token=md5(date("l").$username.date("d"));
    return $token;
}

if(isset($_COOKIE["username"])){
    $username = $_COOKIE["username"];
    $token=get_token($username);
    if ($token==$_COOKIE['token']){}
    else{
        header("Location: /logbook_online/onlinelogbook/logout.php?logout=true");
    }
}else{
    header("Location: /logbook_online/onlinelogbook/index.php");
}

?>