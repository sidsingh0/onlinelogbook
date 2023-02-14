<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, OPTIONS");
    header('Content-Type: application/json; charset=utf-8');
    include("../includes/connect.php");
    if(isset($_GET["u"])){
        $u = $_GET["u"];
        if(strlen($u) == 8){
            $sql="select * from userinfo where username=$u";
            $result=mysqli_query($conn, $sql)->fetch_assoc();
            
            if($result){
                $data = [ 'msg' => $result["name"], 'dept' => $result['dept']];
            }else{
                $data = ['msg' => "Invalid Moodle"];
            }
        }else{
            $data = ['msg' => "Invalid Moodle"];
        }
        echo json_encode($data, JSON_FORCE_OBJECT);
    }else{
        header("/logbook_online/onlinelogbook/index.php");
    }
?>