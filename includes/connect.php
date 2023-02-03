<?php

    $servername="localhost";
    $username="root";
    $password="";
    $database="logbook";

    $conn= mysqli_connect($servername,$username,$password,$database);
    if (! $conn ) {
        die('Sorry we failed to connect!');
    }

?>