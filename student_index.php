<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <?php include('includes/navbar.php')?>
    <?php include('includes/connect.php')?>

    <div class="container">
    <div class="container my-4">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <div class="row g-3">

        <div class="col-sm-4">
            <label for="semester" class="form-label">Semester</label>
            <select class="form-select" id="semester" name="semester" required>
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
              <option>6</option>
              <option>7</option>
              <option>8</option>
            </select>
        </div>

        <div class="col-sm-4">
            <label for="groupno" class="form-label">Group No.</label>
            <input class="form-control" name="groupno" id="groupno" type="number" placeholder="" required>
        </div>

        <div class="col-sm-4">
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
              <label for="date" class="form-label">Submission Date</label>
              <input type="date" class="bg-dark rounded-3 border border-light form-control" id="date" name="date" required>
            </div>
        </div>


      </div>

        <div class="row g-3 my-3">
          <center>
          <div class="col-sm-6">
            <button class="btn btn-primary" name="button_submit" type="submit">Submit</button>
          </div>
          </center>
        </div>

        <?php
          if (isset($_POST['button_submit'])){
              $sem = $_POST['semester'];
              $groupno= $_POST['groupno'];
              $logno= $_POST['logno'];
              $plannedprog= $_POST['plannedprog'];
              $achievedprog= $_POST['achievedprog'];
              $date= $_POST['date'];

              $query= "insert into log_content (sem,groupno,log_no,progress_planned,progress_achieved,date) values ('$sem','$groupno','$logno','$plannedprog','$achievedprog','$date')";
              $result= mysqli_query($conn,$query);
          };
    
    ?>

      </form>
    </div>
        
    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                                
    <div>
        <table class="table table-bordered border-secondary">
          <thead class = "thead-dark">
            <tr>
              <th>Sem</th>
              <th>Group No.</th>
              <th>Log No.</th>
              <th colspan=2>Planned Progress</th>
              <th colspan=2>Achieved Progress</th>
              <th colspan=2>Guide Review</th>
              <th>Date</th> 
            </tr>
        </thead>
            <?php
            $groupno = "2";
            $query = "select * from log_content where groupno = $groupno order by 'log_no'";
            $result = mysqli_query($conn, $query);
            while ($data = $result->fetch_assoc()) {
                $sem = $data['sem'];
                $logno = $data['log_no'];
                $progplanned = $data['progress_planned'];
                $progachieved = $data['progress_achieved'];
                $guidereview = $data['guide_review'];
                $date = date("d-m-Y", strtotime($data['date']));
                
                echo "<tr>
                <td>".$sem." </td>
                <td>".$groupno." </td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>