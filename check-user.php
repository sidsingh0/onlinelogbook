<?php 
include("./includes/conditions.php");
if(isset($_COOKIE["role"])){
    $role = $_COOKIE["role"];
    if($role == "student"){
        header("Location: /diary/logbook/student/index.php");
    }else if($role == "guide"){
        header("Location: /diary/logbook/guide/index.php");
    }else if($role == "proco"){
        header("Location: /diary/logbook/procord/index.php");
    }else if($role == "admin"){
        header("Location: /diary/logbook/admin/index.php");
    }
}else{
    header("Location: /diary/logbook/index.php");
}

?>