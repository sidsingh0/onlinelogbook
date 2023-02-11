<?php
  include("./includes/conditions.php");
  if(isset($_GET["logout"])){
    if($_GET["logout"] == "true"){
      setcookie("username", '', time() - 3600);
      setcookie("role", '', time() - 3600);
      setcookie("token", '', time() - 3600);
      session_destroy();
      header("Location: /logbook_online/onlinelogbook/index.php");
    }
  }
?>