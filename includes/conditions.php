<?php 
session_start();
include('connect.php');

function get_token($username){
    $token=md5(date("l").$username.date("d"));
    return $token;
}

if(isset($_COOKIE["username"])){
    $username = $_COOKIE["username"];
    $token=get_token($username);
    $query="select * from users where username=$username";
    $result=mysqli_query($conn,$query)->fetch_assoc();
    $dbrole=$result['role'];
    if($_COOKIE["role"] == $dbrole){
        $role = $_COOKIE["role"];
    }else{
        header("Location: /logbook_online/onlinelogbook/logout.php?logout=true");
    }
    if ($token==$_COOKIE['token']){}
    else{
        header("Location: /logbook_online/onlinelogbook/logout.php?logout=true");
    }
}else{
    header("Location: /logbook_online/onlinelogbook/index.php");
}



?>