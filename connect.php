<?php 
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "logbook";
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if(!$conn){
    die("Could not connect");
}
?>