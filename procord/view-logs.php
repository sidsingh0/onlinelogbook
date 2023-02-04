<?php
  include("../includes/connect.php");
  include("../includes/conditions.php");
  if(isset($_GET["groupno"])){
    $group_no=$_GET["groupno"];
  }else{
    header("Location: /logbook_online/onlinelogbook/procord/procord-view.php");
    exit;
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
    <?php include('../includes/navbar.php');?>

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
              <th>Date</th> 
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
                echo "<tr>
                <td>".$logno." </td>
                <td colspan=2>".$progplanned." </td>
                <td colspan=2>".$progachieved." </td>
                <td colspan=2>".(($guidereview == "") ? $input: $guidereview)." </td>
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