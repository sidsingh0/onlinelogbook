<?php 
session_start();
include('connect.php');
$api_url = '/diary/logbook/api_hidden_url/we_need_name.php?u=20102125';
$json_data = file_get_contents($api_url);
$response_data = json_decode($json_data);
$dept = $response_data->dept;
function get_token($username){
    $token=md5(date("l").$username.date("d"));
    return $token;
}

function errordisp($title,$description){
    echo '<div class="alert alert-primary alert-dismissible fade show mx-1 my-3" role="alert">
    <strong>'.$title.'</strong>'. $description.'
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
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
        header("Location: /diary/logbook/logout.php?logout=true");
    }
    if ($token==$_COOKIE['token']){}
    else{
        header("Location: /diary/logbook/logout.php?logout=true");
    }
}else{
    header("Location: /diary/logbook/index.php");
}
?>