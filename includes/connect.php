<?php

    $servername="localhost";
    $username_db="root";
    $password="";
    $database="logbook";

    $conn= mysqli_connect($servername,$username_db,$password,$database);
    if (! $conn ) {
        die('Sorry we failed to connect!');
    }

?>