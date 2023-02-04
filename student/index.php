<?php
  include("../includes/connect.php");
  include("../includes/conditions.php");
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student - Home</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <?php include('../includes/navbar.php');?>
    <?php 
        $sql_get = "select * from groups where student_id ='$username'";
        $res_get = mysqli_query($conn, $sql_get)->fetch_assoc();
        if($res_get){
            $groupno=$res_get["groupno"];
            $semester=$res_get["sem"];
            $year=$res_get["year"];
            $guide_id=$res_get["guide_id"];
            $title=$res_get["title"];
            $sql="select * from groups where groupno=$groupno";
            $result=mysqli_query($conn, $sql);
        }else{
            echo "Please wait for a guide to add you!";
        }
    ?>
    <div class="container">
        <h2 class="my-4">Group for Semester - <?php echo $semester; ?></h2>
        
        <?php            
            $sql_guide="select * from userinfo where username=$guide_id";
            $res_guide=mysqli_query($conn, $sql_guide)->fetch_assoc(); 
        ?>
        <h2 class="my-4">Guide Name - <?php echo $res_guide["name"]; ?> </h2>
        <h2 class="my-4">Project Title - <?php echo $title; ?></h2>
        <br><hr>
        <h4>Group Details:</h4>
        <table class="table table-bordered border-secondary">
            <tr>
                <th>Student Id</th>
                <th>Student Name</th>
            </tr>
            <?php
            while ($data = $result->fetch_assoc()) {
                $studentid = $data['student_id'];
                $title = $data['title'];

                $query2 = "select * from userinfo where username=" . $studentid;
                $sdata = mysqli_query($conn, $query2)->fetch_assoc();

                $studentname = $sdata['name'];

                echo "<tr>
                <td>".$studentid." </td>
                <td>".$studentname." </td>
                </tr>";
            }
            ?>



        </table>
        
    </div>


    <div class="container my-5">
    <hr>
        <h2 class="my-3">Logs Pending:</h2>
    <hr>
            <?php 
            $sql_log = "select * from log_creation where sem='$semester' and year='$year'";
            $res_log = mysqli_query($conn, $sql_log);

            while($res=$res_log->fetch_assoc()){
                $startdate = date("d-m-Y", strtotime($res['date_from']));
                $enddate = date("d-m-Y", strtotime($res['date_to']));
                $currDate = date('d-m-Y');
                $currDate=date('d-m-Y', strtotime($currDate));
                if (($currDate >= $startdate) && ($currDate <= $enddate)){ 
                    $log_no = $res["log_no"];
                    $sql_log_content = "select * from log_content where log_no=$log_no and groupno=$groupno";
                    $res_log_content = mysqli_query($conn, $sql_log_content) or die(mysqli_error($conn));   
                    if($res_log_content->fetch_assoc()){

                    } else{
                        echo '
                        <div class="card">
                            <a class="text-white" href="add-log.php?log='. $res["log_no"] .'&sem='. $semester .'&date='. $currDate .'" ><div class="card-body">
                                Log # '. $res["log_no"] .' shall be uploaded by '. $enddate .' 
                            </div></a>
                        </div>';
                    }

                }

            }
        
        ?>

    </div>


<div class="container">
    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
          <h2 class="my-5">Previously Filled Logs:</h2>                      
    <div>
        <table class="table table-bordered border-secondary">
          <thead class = "thead-dark">
            <tr>
              <th>Log No.</th>
              <th colspan=2>Planned Progress</th>
              <th colspan=2>Achieved Progress</th>
              <th colspan=2>Guide Review</th>
              <th>Date</th> 
            </tr>
        </thead>
            <?php
            $query = "select * from log_content where groupno=$groupno order by 'log_no'";
            $result = mysqli_query($conn, $query);
            while ($data = $result->fetch_assoc()) {
                $sem = $data['sem'];
                $logno = $data['log_no'];
                $progplanned = $data['progress_planned'];
                $progachieved = $data['progress_achieved'];
                $guidereview = $data['guide_review'];
                $date = date("d-m-Y", strtotime($data['date']));
                
                echo "<tr>
                <td>".$logno." </td>
                <td colspan=2>".$progplanned." </td>
                <td colspan=2>".$progachieved." </td>
                <td colspan=2>".$guidereview." </td>
                <td>".$date." </td>
                </tr>";
            }
            ?>
        </table>
    </div>


    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>