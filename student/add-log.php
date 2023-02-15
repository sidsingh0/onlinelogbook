<!DOCTYPE html>
<?php 

    include("../includes/conditions.php");
    if ($_COOKIE['role']!='student'){
        header("Location: /onlinelogbook/logout.php?logout=true");
    }
?>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <?php include('../includes/navbar.php')?>
    <?php include('../includes/connect.php')?>

    <?php
        if(isset($_POST["sem"])){
            $sql_get = "select * from groups where student_id='$username' order by sem desc";
            $res_get = mysqli_query($conn, $sql_get)->fetch_assoc();
            if(!$res_get){
                echo "PLEASE WAIT FOR A GUIDE TO ADD U";
                exit;
            }else{
                $groupno = $res_get["groupno"];
                $year_of=$res_get["year"];
                $div_of=$res_get["division"];
            }
            $startdate = date('Y-m-d',strtotime($_POST["start"]));
            $enddate = date('Y-m-d',strtotime($_POST["end"]));
            $currDate = $_POST["date"];
            $currDate=date('Y-m-d', strtotime($currDate));
            if(($currDate >= $startdate) && ($currDate <= $enddate)){ 
                $semester = $_POST["sem"];
                $logno = $_POST["log"];
            }else{
                header("Location: /onlinelogbook/student/index.php");
            }
        }else{
            if (isset($_POST['button_submit'])){
                $sem = $_POST['semester'];
                $logno= $_POST['logno'];
                $plannedprog= $_POST['plannedprog'];
                $achievedprog= $_POST['achievedprog'];
                $date= $_POST['date'];
                $year= $_POST["year"];
                $groupno= $_POST["groupno"];
                $division= $_POST["div"];
                $check="select * from log_content where ((log_no=$logno and groupno=$groupno) and (aca_year=$aca_year and division='$division')) and (year='$year' and dept='$dept')";
                $result_check = mysqli_query($conn, $check);
                if(mysqli_num_rows($result_check) > 0){
                    exit("NO MASTI");
                }else{
                    $query= "insert into log_content (sem,groupno,log_no,progress_planned,progress_achieved,date,year,division,dept) values ('$sem',$groupno,$logno,'$plannedprog','$achievedprog','$date', '$year','$division','$dept')";
                    $result= mysqli_query($conn,$query) or die(mysqli_error($conn));
                    if($result){
                        echo " <script>window.location = '/onlinelogbook/student/index.php'</script>";
                    }
                }
            }else{
                header("Location: /onlinelogbook/student/index.php");
            }
        }
        
    ?>

    <div class="container">
    <div class="container my-4">
      <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>" method="POST">
        <div class="row g-3">

        <div class="col-sm-4">
            <input type="hidden" class="form-control" id="semester" value="<?php echo $semester; ?>" name="semester" readonly>
        </div>

        <div class="col-sm-4">
            <input type="hidden" class="form-control" id="grpno" value="<?php echo $groupno; ?>" name="groupno" readonly>
        </div>

        <div class="col-sm-4">
            <input type="hidden" class="form-control" id="year" value="<?php echo $year_of; ?>" name="year" readonly>
        </div>

        <div class="col-sm-4">
            <input type="hidden" class="form-control" id="div" value="<?php echo $div_of; ?>" name="div" readonly>
        </div>

        <div class="col-sm-4">
            <input type="hidden" class="form-control" id="logno" value="<?php echo $logno; ?>" name="logno" readonly>
        </div>

        <div class="row g-3 my-1">
            <div class="col-sm-6">
                <label for="plannedprog" class="form-label">Progress Planned</label>
                <textarea type="text" name="plannedprog" id="plannedprog" placeholder="" class="form-control" required></textarea>
            </div>

            <div class="col-sm-6">
                <label for="achievedprog" class="form-label">Progress Achieved</label>
                <textarea type="text" name="achievedprog" id="achievedprog" placeholder="" class="form-control" required></textarea>
            </div>
        </div>

        <div class="row g-3 my-2">
            <div class="col-sm-12">
              <label for="date" class="form-label">Today's Date</label>
              <input type="date" value="<?php echo $currDate; ?>" class="bg-dark rounded-3 border border-light form-control" id="date" name="date" readonly>
            </div>
        </div>

      </div>

        <div class="row g-3 my-3">
          <center>
          <div class="col-xs-12">
            <button class="w-100 btn btn-outline-info" name="button_submit" type="submit">Submit</button>
          </div>
          </center>
        </div>

      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>