<?php 
include("./includes/conditions.php");
if(isset($_COOKIE["role"])){
    $role = $_COOKIE["role"];
    if($role == "student"){
        header("Location: /onlinelogbook/student/index.php");
    }else if($role == "guide"){
        header("Location: /onlinelogbook/guide/index.php");
    }else if($role == "proco"){
        header("Location: /onlinelogbook/procord/index.php");
    }else if($role == "admin"){
        header("Location: /onlinelogbook/admin/index.php");
    }
}else{
    header("Location: /onlinelogbook/index.php");
}

?>