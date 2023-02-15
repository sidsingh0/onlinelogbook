<!DOCTYPE html>
<?php
include("../includes/conditions.php");
if ($_COOKIE['role'] != 'guide') {
    header("Location: /diary/logbook/logout.php?logout=true");
}
?>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <?php include("../includes/connect.php"); ?>
    <?php include("../includes/navbar.php"); ?>

    <div class="container my-5">
        <div>
            <h3 class="my-3">Groups Under You:</h3>
            <br />
            <div style="border-radius:6px;overflow:hidden;border:0.2px solid grey">
                <div class="col-lg-12" style="border-radius:6px;overflow:hidden;border:0.2px solid grey">
                    <div class="table-responsive">
                        <table class="table table-bordered border-secondary rounded-2 my-0">
                            <tr>

                <th>Group No.</th>
                <th>Student Id</th>
                <th>Student Name</th>
                <th>Project Title</th>
                <th>View Logs</th>
            </tr>
            <?php
            $guide_id = $username;
            $query = "select * from groups where (guide_id =$guide_id and aca_year=$aca_year) and dept='$dept' group by groupno , year, division;";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) ==0){
                echo '<tr><td colspan="5" class="text-center">No groups under you yet! Add <a href="add-group.php" >Group</a></td></tr>';
            }
            while ($data = $result->fetch_assoc()) {
                // echo var_dump($data);
                $group_no = $data['groupno'];
                $studentid = $data['student_id'];
                $title = $data['title'];
                $sem = $data['sem'];
                $query2 = "select * from userinfo where username=" . $studentid;
                $sdata = mysqli_query($conn, $query2)->fetch_assoc();
                $studentname = $sdata['name'];
                echo "<tr>
                <td>".$data["year"]." ".$data["division"]."". $group_no." </td>
                <td>".$studentid." </td>
                <td>".$studentname." </td>
                <td>".$title." </td>
                <td><a href='view-logs.php?groupno=".$group_no."&year=".$data["year"]."&div=".$data["division"]."&sem=".$sem."'>View</a></td>
                </tr>";

            }
            ?>



                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>