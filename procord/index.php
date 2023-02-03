<?php
  include("../includes/connect.php");
  include("../includes/conditions.php");
  if($_COOKIE["role"] == "proco" || $_COOKIE["role"] == "admin"){
    $role = $_COOKIE["role"];
  }else{
    header("Location: /logbook_online/onlinelogbook/index.php");
  }
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Co-ordinator - Home</title>
    <style>
      ::-webkit-calendar-picker-indicator {
      filter: invert(1);
    }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <?php
    $sql="select * from procos where username='$username'";
    $result=mysqli_query($conn, $sql)->fetch_assoc();
    $sem_proco = $result["sem"];
    $year_proco = $result["year"];
    if (isset($_POST['semester'])){
        $semester= $_POST['semester'];
        $startdate= $_POST['startdate'];
        $enddate= $_POST['enddate'];
        $logno= $_POST['logno'];
        $year= $_POST['year'];
        $query= "insert into log_creation (log_no,year,sem,date_from,date_to) values ('$logno','$year','$semester','$startdate','$enddate')";
        $result_insert= mysqli_query($conn,$query);
    };
    
    ?>

    <?php include('../includes/navbar.php')?>
    
      <div class="container my-5">
        <h2>Add Logs for Users:</h2>
      <div class="container my-4">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
          <div class="row g-3">

          <div class="col-sm-4 col-xs-4">
              <label for="logno" class="form-label">Log Number</label>
              <select class="form-select" id="logno" name="logno" required>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
              </select>
            </div>

            <div class="col-sm-4 col-xs-4">
              <label for="semester" class="form-label">Semester</label>
              <input class="form-control" value="<?php echo $result["sem"] ?>" id="semester" name="semester" readonly>
            </div>
            <div class="col-sm-4 col-xs-4">
              <label for="semester" class="form-label">Year</label>
              <input class="form-control" name="year" id="year" type="text" value="<?php echo $result["year"] ?>" readonly>
            </div>

          <div class="row g-3 my-1">
            <div class="col-sm-6 col-xs-6">
              <label for="startdate" class="form-label">Example date</label>
              <input type="date" class="bg-dark rounded-3 border border-light form-control " id="startdate" name="startdate" required>
            </div>
            <div class="col-sm-6 col-xs-6">
              <label for="enddate" class="form-label">Example date</label>
              <input type="date" class="bg-dark rounded-3 border border-light form-control" id="enddate" name="enddate" required>
            </div>
          </div>
        </div>

          <div class="row g-3 my-2">
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
              <button class="w-100 btn btn-outline-info" name="submit" type="submit">Submit</button>
            </div>
          </div>

        </form>
      </div>

      <hr>

      <div class="container">
        <h2 class="my-4">Previously Created Logs: </h2>
          <?php
            $query= "select * from log_creation where sem='$sem_proco' and year='$year_proco'";
            $result_log= mysqli_query($conn,$query);
            while ($res=$result_log->fetch_assoc()){
              echo ('
                <div class="card my-4 text-center">
                  <div class="card-header">
                    Log Number '.$res["log_no"].'
                  </div>
                  <div class="card-body">
                    <blockquote class="blockquote mb-0">
                      <p>Year: '. $res["year"] .'</p>
                      <p>Sem: '. $res["sem"] .'</p>
                      <p>Date: '. $res["date_from"] .' To '. $res["date_to"] .'</p>
                    </blockquote>
                  </div>
                </div>
              ');
            }
          ?>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>