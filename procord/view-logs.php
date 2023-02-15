<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Coordinator - View Logs</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        html{
            color-scheme: dark!important;
        }
    </style>
</head>

<body>
<?php
  include('../includes/navbar.php');
  include("../includes/connect.php");
  include("../includes/conditions.php");
  if(isset($_GET["groupno"])){
    $group_no=$_GET["groupno"];
    $year_of=$_GET["year"];
    $div_of=$_GET["div"];
    $sem=$_GET["sem"];
  }else{
    header("Location: /diary/logbook/procord/procord-view.php");
    exit;
  }
  if($_COOKIE["role"] == "proco"){
    $role = $_COOKIE["role"];
  }else{
    header("Location: /diary/logbook/logout.php?logout=true");
  }
  if(isset($_POST["log_id"])){
    $log_id = $_POST["log_id"];
    $progress_planned = $_POST["progress_planned"];
    $progress_achieved = $_POST["progress_achieved"];
    $guide_review = $_POST["guide_review"];
    $sql_update = "update log_content set progress_planned='$progress_planned' , progress_achieved = '$progress_achieved', guide_review='$guide_review' where id=$log_id";
    $res_update = mysqli_query($conn, $sql_update);

  }

  if(isset($_POST["student_id"])){
    $student_id = $_POST["student_id"];
    $new_id = $_POST["username"];
    $sql_update = "update groups set student_id=$new_id where ((student_id=$student_id and year='$year_of') and (division='$div_of' and groupno=$group_no)) and ((aca_year=$aca_year and sem='$sem') and dept='$dept')";
    try{
        $res_update = mysqli_query($conn, $sql_update);
        if(!$res_update){
            exit("Moodle does not exist");
        }}catch(Exception $e){
            errordisp('','Please enter correct moodle id');
        }
  }

  if (isset($_POST["update_title_btn"])){
    $title_update=$_POST['update_title'];
    $query="update groups set title='$title_update' where (division='$div_of' and groupno=$group_no) and ((aca_year=$aca_year and sem='$sem') and (dept='$dept' and year='$year_of'))";
    $updateresult=mysqli_query($conn,$query);
  }
?>
    <?php
    $sql="select * from groups where ((groupno=$group_no and year='$year_of') and (division='$div_of' and aca_year=$aca_year)) and (sem='$sem' and dept='$dept')";
    $result=mysqli_query($conn, $sql)->fetch_assoc();
    if($result){
        $title = $result["title"];
        $guide_id = $result["guide_id"];
        $groupid=$result["id"];
        $guide_name_query="select name from userinfo where username=".$guide_id;
        $res_guide_name = mysqli_query($conn, $guide_name_query)->fetch_assoc();
        $guide_name = $res_guide_name["name"];
    }else{
        exit("No group found");
    }
    ?>

    <div class="container my-5">
    <h1 class="my-4">Project Title - <?php echo $title; ?></h1>
    <h5>Guide Name - <?php echo $guide_name; ?></h5>
    <hr>
    <h3 class="my-3">Group Details:</h3>
        <table class="table table-bordered border-secondary">
            <tr>
              <th colspan=3>
              <div class="col-xs-12 col-md-12 my-2">
                <form action="<?php echo $_SERVER['REQUEST_URI']?>" method="POST">
                <div class="input-group col-md-6 col-xs-12">
                    <span class="input-group-text">Project Title</span>
                    <input type="hidden" class>
                    <input type="text" class="form-control" name="update_title" value="<?php echo $title?>" required>
                    <button type="submit" name="update_title_btn" class="btn btn-outline-info">Update</button>
                </div>
                </form>
              </div>
              </th>
            </tr>
        
        
        
        <tr>
                <th>Student Id</th>
                <th>Student Name</th>
                <th>Edit</th>
            </tr>
            <?php
            $sql="select * from groups where ((groupno=$group_no and year='$year_of') and (division='$div_of' and aca_year=$aca_year)) and (sem='$sem' and dept='$dept')";
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
      <hr>
        <h3 class="my-3">Logs Uploaded:</h3>
    
            <?php 
            $sql_log = "select * from log_content where ((groupno=$group_no and year='$year_of') and (division='$div_of' and aca_year=$aca_year)) and (sem='$sem' and dept='$dept')";
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
    <hr>
    <button class="w-100 btn btn-info" onclick="window.open('/diary/logbook/logbook-pdf.php?groupno=<?php echo $group_no; ?>&year=<?php echo $year_of; ?>&div=<?php echo $div_of; ?>&sem=<?php echo $sem; ?>&acayear=<?php echo $aca_year; ?>&dept=<?php echo $dept; ?>', 'newwindow','width=1000,height=1000'); return false;">Get Log Book</button>
    <hr>
          <h3 class="my-3">Log Details:</h3>                      
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
            $query = "select * from log_content where ((groupno=$group_no and year='$year_of') and (division='$div_of' and aca_year=$aca_year)) and (sem='$sem' and dept='$dept') order by 'log_no'";
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
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>