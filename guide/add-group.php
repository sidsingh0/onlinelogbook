<?php
  include("../includes/connect.php");
  include("../includes/conditions.php");
  if($_COOKIE["role"] == "guide"){
    $role = $_COOKIE["role"];
  }else{
    header("Location: /logbook_online/onlinelogbook/logout.php?logout=true");
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
</head>
<body>
    <?php include('../includes/navbar.php')?>
    <?php
    $group_no = 0;
    $sql_select = "select max(groupno) as group_no from groups";
    $result = mysqli_query($conn, $sql_select);
    if($result){
        while ($data = $result->fetch_assoc()) {
            // echo var_dump($data);
            $group_no = $data['group_no'] ;
            // echo $group_no;
        }
    }

    $group_no = $group_no + 1;
    if (isset($_POST['moodlesubmit'])) {
        $guide_id = $username; 
        $title = $_POST['title'];
        $sem = $_POST["sem"];
        $year = $_POST["year"];
        $moodle_array = $_POST['moodleid'];
        foreach ($moodle_array as $moodleid) {
            $sql_insert = "insert into groups(groupno,guide_id,student_id,sem,year,title) values($group_no,$username,'$moodleid','$sem','$year','$title')";
            $inserted = mysqli_query($conn, $sql_insert) or die(mysqli_error($conn));
        }
    }

    ?>


    <div class="container my-5">
    <h2>Add A Group:</h2>
    <br><hr>
    <form class="row" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <div class="form-group row">
            <div class="col-xs-12 mb-3">
                <label for="role" class="form-label">Semester</label>
                <select class="form-select" name="sem" id="role" required>
                    <option >I</option>
                    <option >II</option>
                    <option >III</option>
                    <option >IV</option>
                    <option >V</option>
                    <option >VI</option>
                    <option >VII</option>
                    <option >VIII</option>
                </select>
            </div>
        </div>
    
        <div class="form-group row my-3">
        <div class="col-xs-12 mb-3">
          <label for="role" class="form-label">Year</label>
          <select class="form-select" name="year" id="role" required>
              <option >SE</option>
              <option >TE</option>
              <option >BE</option>
          </select>
        </div>
        </div>

        <div class="form-group row my-2">
            <div class="input-group col-md-6 col-xs-12">
                <span class="input-group-text">Project Title</span>
                <input type="text" name="title" class="form-control" required>
            </div>

        </div>

        <div class="form-group row my-2">
            <div class="input-group">
                <span class="input-group-text">Moodle IDs of members</span>
                <input type="text" maxlength="8" name="moodleid[]" class="form-control" required>
                <input type="text" maxlength="8" name="moodleid[]" class="form-control" required>
                <input type="text" maxlength="8" name="moodleid[]" class="form-control" required>
                <input type="text" maxlength="8" name="moodleid[]" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">

            <div class="col-xs-12 my-3">
                <button type="submit" name="moodlesubmit" class="w-100 btn btn-outline-info">Submit</button>
            </div>
        </div>
    </form>

    <hr>
    </div>
    




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>