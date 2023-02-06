<?php
  include("../includes/connect.php");
  include("../includes/conditions.php");
  if ($_COOKIE['role']!='proco'){
    header("Location: /logbook_online/onlinelogbook/logout.php?logout=true");
  }

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Co-ordinator - View</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <?php include('../includes/navbar.php')?>
    <?php 
      $sql_get="select * from procos where username=$username";
      $res_get=mysqli_query($conn, $sql_get)->fetch_assoc();
      if($res_get){
        $semester = $res_get["sem"];
        $year = $res_get["year"];
      }else{
        exit;
      }
    ?>
    <div class="container">
      <h2 class="text-center my-5">List of all the guides and groups of semester <?php echo $semester; ?></h2>



      <table class="table table-bordered border-secondary">
            <?php
            // $query = "SELECT g.groupno, g.title, g.sem, u.name, u.username from groups g JOIN userinfo u ON g.guide_id = u.username WHERE g.sem='$semester' and g.year='$year' group BY g.guide_id, g.groupno;";
            $query="select u.name, g.guide_id from groups g JOIN userinfo u ON g.guide_id=u.username where g.sem='$semester' and g.year='$year' group by g.guide_id";
            $result = mysqli_query($conn, $query);
            while ($data=$result->fetch_assoc()) {
                $guide_id = $data['guide_id'];
                $guidename = $data["name"];
                echo "<tr class='text-center'>
                        <th colspan='4'> Guide Name: ".$guidename." </th>
                      </tr>";

                echo "
                <tr>
                  <th>Group No.</th>
                  <th>Project Title</th>
                  <th>Logs Filled</th>
                  <th>View Logs</th>
                </tr>";
                $sql_guide_get = "select * from groups where guide_id='$guide_id' and sem='$semester'group by groupno , year, division";
                $res_guide_get = mysqli_query($conn, $sql_guide_get);
                while($r=$res_guide_get->fetch_assoc()){
                  $group_no = $r['groupno'];
                  $division=$r['division'];
                  $year_of = $r['year'];
                  $title = $r['title'];
                  $sql_log_get = "select count(*) as count from log_content where (groupno=$group_no and year='$year_of') and (division='$division')";
                  $res_log_get = mysqli_query($conn, $sql_log_get)->fetch_assoc();
                  echo "
                  <td>".$r["year"]." ".$r["division"]."". $group_no." </td>
                  <td>".$title." </td>
                  <td class='". (($res_log_get["count"] >= 6) ? 'bg-success':'bg-danger') ." fw-bold'>". $res_log_get["count"] ." </td>
                  <td><a href='view-logs.php?groupno=".$group_no."&year=".$r["year"]."&div=".$r["division"]."'>View</a></td>
                  </tr>";
                }
            }
            ?>

        </table>

    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>