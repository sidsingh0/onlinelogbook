<?php
  include("../includes/connect.php");
  include("../includes/conditions.php");
  if(isset($_GET["groupno"])){
    $group_no=$_GET["groupno"];
  }else{
    header("Location: /logbook_online/onlinelogbook/procord/procord-view.php");
    exit;
  }

  if(isset($_POST["log_id"])){
    $log_id = $_POST["log_id"];
    $progress_planned = $_POST["progress_planned"];
    $progress_achieved = $_POST["progress_achieved"];
    $guide_review = $_POST["guide_review"];
    $sql_update = "update log_content set progress_planned = '$progress_planned' , progress_achieved = '$progress_achieved', guide_review='$guide_review' where id=$log_id";
    $res_update = mysqli_query($conn, $sql_update);
  }

  if(isset($_POST["student_id"])){
    $student_id = $_POST["student_id"];
    $new_id = $_POST["username"];
    $sql_update = "update groups set student_id=$new_id where student_id=$student_id";
    $res_update = mysqli_query($conn, $sql_update);
    if(!$res_update){
        exit("Moodle does not exist");
    }
  }
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide - View Logs</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        html{
            color-scheme: dark!important;
        }
    </style>
</head>
<body>
    <?php include('../includes/navbar.php');
    $sql="select * from groups where groupno=$group_no";
    $result=mysqli_query($conn, $sql)->fetch_assoc();
    if($result){
        $title = $result["title"];
    }else{
        exit("No group found");
    }
    ?>

    <div class="container my-5">
    <h2 class="my-4">Project Title - <?php echo $title; ?></h2>
    <hr>
    <h4>Group Details:</h4>
        <table class="table table-bordered border-secondary">
            <tr>
                <th>Student Id</th>
                <th>Student Name</th>
                <th>Edit</th>
            </tr>
            <?php
            $sql="select * from groups where groupno=$group_no";
            $result=mysqli_query($conn, $sql);
            while ($data = $result->fetch_assoc()) {
                $studentid = $data['student_id'];
                $query2 = "select * from userinfo where username=" . $studentid;
                $sdata = mysqli_query($conn, $query2)->fetch_assoc();
                $studentname = $sdata['name'];
                echo '
              <div class="modal fade" id="exampleModal'. $data["student_id"]. '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Details</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="'.$_SERVER["REQUEST_URI"].'">
                        <input type="hidden" name="student_id" value="'. $data["student_id"].'">
                        <div class="form-floating">
                            <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "8" class="form-control" name="username" id="username" value="'. $studentid .'" required>
                            <label for="username">Moodle ID</label>
                        </div>

                        <div class="row g-3 my-2">
                          <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                            <button class="w-100 btn btn-outline-info" name="submit" type="submit">Update</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>';
                echo "<tr>
                <td>".$studentid." </td>
                <td>".$studentname." </td>
                <td>
                    <button type='button' class='text-white btn' data-bs-toggle='modal' data-bs-target='#exampleModal". $studentid. "'>
                        Edit Student ID
                    </button>
                </td>
                </tr>";
            }
            ?>
        </table>
    </div>

    <div class="container my-5">
        <h2 class="my-3">Logs Uploaded:</h2>
    <hr>
            <?php 
            $sql_log = "select * from log_content where groupno=$group_no";
            $res_log = mysqli_query($conn, $sql_log);
            if(mysqli_num_rows($res_log) > 0){
                while($res=$res_log->fetch_assoc()){ 
                    echo '
                    <div class="card my-4">
                        <div class="card-body text-white">
                            Log # '. $res["log_no"] .' was uploaded on '. $res["date"] .' 
                        </div>
                    </div>';
                }
            }else{
                echo "No Logs uploaded by this group yet!";
            }
        ?>

    </div>


<div class="container">
          
    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
    <button class="w-100 btn btn-info" onclick="window.open('/logbook_online/onlinelogbook/logbook.php?groupno=<?php echo $group_no;?>', 'newwindow','width=1000,height=1000'); return false;">Get Log Book</button>
      
          <h2 class="my-5">Log Details:</h2>                      
    <div>
        <table class="table table-bordered border-secondary">
          <thead class = "thead-dark">
            <tr>
              <th>Log No.</th>
              <th colspan=2>Planned Progress</th>
              <th colspan=2>Achieved Progress</th>
              <th colspan=2>Guide Review</th>
              <th>Edit</th> 
            </tr>
        </thead>
            <?php
            $query = "select * from log_content where groupno=$group_no order by 'log_no'";
            $result = mysqli_query($conn, $query);
            while ($data = $result->fetch_assoc()) {
                $sem = $data['sem'];
                $logno = $data['log_no'];
                $progplanned = $data['progress_planned'];
                $progachieved = $data['progress_achieved'];
                $guidereview = $data['guide_review'];
                $date = date("d-m-Y", strtotime($data['date']));
                $input = 'Guide did not review!';
                echo '
              <div class="modal fade" id="exampleModal'. $data["id"]. '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Details</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="'.$_SERVER["REQUEST_URI"].'">
                        <input type="hidden" name="log_id" value="'. $data["id"].'">
                        <div class="col-xs-12 my-3">
                          <label for="progress_planned" class="form-label">Progress Planned</label>
                          <input class="form-control" name="progress_planned" id="'. $data["progress_planned"]. '" value="'. $data["progress_planned"]. '" required>
                        </div>
                        <div class="col-xs-12">
                            <label for="progress_achieved" class="form-label">Progress Achieved</label>
                            <input class="form-control" name="progress_achieved" id="'. $data["progress_achieved"]. '" value="'. $data["progress_achieved"]. '" required>
                        </div>  
                        <div class="col-xs-12 my-3">
                            <label for="guide_review" class="form-label">Guide Review</label>
                            <input class="form-control" name="guide_review" id="'. $data["guide_review"]. '" value="'. $data["guide_review"]. '" required>
                        </div>  
                        <div class="row g-3 my-2">
                          <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                            <button class="w-100 btn btn-outline-info" name="submit" type="submit">Update</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>';

                echo 
                "<tr>
                <td>".$logno." </td>
                <td colspan=2>".$progplanned." </td>
                <td colspan=2>".$progachieved." </td>
                <td colspan=2>".(($guidereview == "") ? $input: $guidereview)." </td>
                <td>
                    <button type='button' class='text-white btn' data-bs-toggle='modal' data-bs-target='#exampleModal". $data['id']. "'>
                    Edit
                    </button>
                </td>
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