<?php 
include("./includes/conditions.php");
if(isset($_COOKIE["role"])){
    $role = $_COOKIE["role"];
    if($role == "student"){
        header("Location: /logbook_online/onlinelogbook/student/index.php");
    }else if($role == "guide"){
        header("Location: /logbook_online/onlinelogbook/guide/index.php");
    }else if($role == "proco"){
        header("Location: /logbook_online/onlinelogbook/procord/index.php");
    }else if($role == "admin"){
        header("Location: /logbook_online/onlinelogbook/procord/index.php");
    }
}else{
    header("Location: /logbook_online/onlinelogbook/index.php");
}

?>