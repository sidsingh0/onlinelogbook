<?php
include("../includes/connect.php");
include("../includes/conditions.php");
if ($_COOKIE['role'] != 'proco') {
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
  <?php include('../includes/navbar.php') ?>
  <?php
  $sql_get = "select * from procos where username=$username";
  $res_get = mysqli_query($conn, $sql_get)->fetch_assoc();
  if ($res_get) {
    $semester = $res_get["sem"];
    $year = $res_get["year"];
  } else {
    exit;
  }
  ?>
  <div class="container">
    <h2 class="text-center my-5">List of all the guides and groups of semester <?php echo $semester; ?></h2>
    <button id="export" class="btn btn-outline-info mb-3 mt-0" style="float: right!important;">Download List</button><br><br><br>
    <div class="col-lg-12" style="border-radius:6px;overflow:hidden;border:0.2px solid grey">
      <div id="datatable" class="table-responsive">

        <table id="table" class="table table-bordered border-secondary mb-0">
          <thead>
            <th colspan="6"><center><?php echo $year." - Semester ".$semester." AY ". date("Y",strtotime("-1 year")) ." - ".$aca_year; ?></center></th>
          <?php
          // $query = "SELECT g.groupno, g.title, g.sem, u.name, u.username from groups g JOIN userinfo u ON g.guide_id = u.username WHERE g.sem='$semester' and g.year='$year' group BY g.guide_id, g.groupno;";
          $query = "select u.name, g.guide_id from groups g JOIN userinfo u ON g.guide_id=u.username where (g.sem='$semester' and g.year='$year') and (g.aca_year=$aca_year and g.dept='$dept') group by g.guide_id";
          $result = mysqli_query($conn, $query);
          echo "                <tr>
          <th>Guide Name</th>
          <th>Group No.</th>
          <th>Student Name</th>
          <th>Project Title</th>
          <th>Logs Filled</th>
          <th>View Logs</th>
        </tr></thead><tbody>";
          while ($data = $result->fetch_assoc()) {
            $guide_id = $data['guide_id'];
            $guidename = $data["name"];          
                $sql_guide_get = "select * from groups where (guide_id='$guide_id' and sem='$semester') and (aca_year=$aca_year and dept='$dept') group by groupno , year, division";
                $res_guide_get = mysqli_query($conn, $sql_guide_get);
                $count = mysqli_num_rows($res_guide_get);
                while($r=$res_guide_get->fetch_assoc()){
                  $group_no = $r['groupno'];
                  $id_grp = $r['id'];
                  $division=$r['division'];
                  $year_of = $r['year'];
                  $title = $r['title'];
                  $sql_log_get = "select count(*) as count from log_content where ((groupno=$group_no and year='$year_of') and (division='$division' and aca_year=$aca_year)) and (sem='$semester' and dept='$dept')";
                  $res_log_get = mysqli_query($conn, $sql_log_get)->fetch_assoc();
                  $sql_grp_get = "select * from groups where ((groupno=$group_no and year='$year_of') and (division='$division' and aca_year=$aca_year)) and (sem='$semester' and dept='$dept')";
                  $res_grp_get = mysqli_query($conn, $sql_grp_get);
                  $count = mysqli_num_rows($res_guide_get);
                  $count_inner = mysqli_num_rows($res_grp_get);
                  echo "
                  <tr>
                  <td class='text-center fw-bold' rowspan='".$count_inner."'>" . $guidename . " </td>
                  <td rowspan='$count_inner'>".$r['year']." ".$r['division']."". $group_no." </td>
                  <td rowspan='$count_inner'>";
                  while($grp_st=$res_grp_get->fetch_assoc()){
                    $sql_inner="select * from userinfo where username=".$grp_st['student_id'];
                    $res_inner=mysqli_query($conn, $sql_inner)->fetch_assoc();
                    echo $res_inner['name'] . "<br>";
                  }
                  echo "</td>
                  <td rowspan='$count_inner'>".$title." </td>
                  <td rowspan='$count_inner' class='". (($res_log_get["count"] >= 6) ? 'bg-success':'bg-danger') ." fw-bold'>". $res_log_get["count"] ." </td>
                  <td rowspan='$count_inner'><a href='view-logs.php?groupno=".$group_no."&year=".$r["year"]."&div=".$r["division"]."&sem=".$semester."'>View</a></td>
                  </tr>";
                  for($i=0;$i<$count_inner-1;$i++){
                    echo "<tr></tr>";
                  };
                }
                
            }
            if(mysqli_num_rows($result) == 0){
              echo "<h3 class='text-center'>No guide has added groups for semester $semester yet!</h3>";
            }
          
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>



<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
  <script>
    function ExportToExcel(fileName)
{
    var isIE = (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0); 
    if (isIE) {
        // IE > 10
        if (typeof Blob != 'undefined') {
            var fileData = new Blob([document.getElementById("datatable").innerHTML.replace(/="  "/gi, "")], {type: 'application/vnd.ms-excel,'});
            window.navigator.msSaveBlob(fileData, fileName + '.xls');
        }
        // IE < 10
        else {
            myFrame.document.open("text/html", "replace");
            myFrame.document.write(document.getElementById("datatable").innerHTML.replace(/="  "/gi, ""));
            myFrame.document.close();
            myFrame.focus();
            myFrame.document.execCommand('SaveAs', true, fileName + '.xls');
        }

    }
    // crome,mozilla
    else {
    var uri = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' + document.getElementById("datatable").innerHTML.replace(/ /g, '%20');
        var link = document.createElement("a");
        link.href = uri;
        link.style = "visibility:hidden";
        link.download = fileName + ".xls";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}
    $(document).ready(function() {
      $('#export').on('click', function(e){
          ExportToExcel("report-on-" + new Date().toLocaleDateString());
      });
});
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>