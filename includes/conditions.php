<?php 
session_start();
include('connect.php');
$api_url = 'http://localhost/logbook_online/onlinelogbook/api_hidden_url/we_need_name.php?u=20102125';
$json_data = file_get_contents($api_url);
$response_data = json_decode($json_data);
$dept = $response_data->dept;
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