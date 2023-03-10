<?php
include("./includes/connect.php");
include("./includes/conditions.php");
if (isset($_GET["groupno"])) {
    $group_no = $_GET["groupno"];
} else {
    header("Location: /diary/logbook/procord/procord-view.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APSIT Logbook</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        hr {
            border-top: solid 1px #000 !important;
        }

        @media print {
            .btn {
                display: none;
            }

            a[href]:after {
                content: none !important;
            }

            .each-page {
                page-break-after: always;
                margin-top: 0;
            }

            p {
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <center><a href="/diary/logbook/logbook-pdf.php?groupno=<?php echo $group_no; ?>" target="_blank" class=" w-75 btn btn-outline-info">Download</a></center>
        <div class="each-page">
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <center>
                <h2>A.P. Shah Institute Of Technology</h2>
            </center>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <?php $year_now = date("y"); ?>
            <?php
            $sql = "select * from groups where groupno=$group_no";
            $res = mysqli_query($conn, $sql)->fetch_assoc();
            $semester = $res["sem"];
            $year = $res["year"];
            $title = $res["title"];
            $guide_id = $res["guide_id"];
            $sql_i = "select * from userinfo where username = '$guide_id'";
            $res_i = mysqli_query($conn, $sql_i)->fetch_assoc();
            $guide_name = $res_i["name"];
            ?>
            <center>
                <h5 class="text-muted">Academic Year <?php echo date("y", strtotime("-1 year")) . " - " . $year_now; ?></h5>
            </center>
            <p>Year: <?php echo $year; ?></p>
            <p>Sem: <?php echo $semester; ?></p>

            <h6>Project Title: <?php echo $title; ?></h6>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">

            <?php
            $sql = "select * from groups where groupno=$group_no";
            $res = mysqli_query($conn, $sql);
            $i = 1;
            while ($r = $res->fetch_assoc()) {
                $student_id = $r["student_id"];
                $sql_inside = "select * from userinfo where username = '$student_id'";
                $res_inside = mysqli_query($conn, $sql_inside)->fetch_assoc();
                echo '
            <h6>Team Member ' . $i . ' :</h6>
            
            <p>Name: ' . $res_inside["name"] . '</p>
            <p>Moodle ID: ' . $student_id . '</p>
            <p>Email: ' . $res_inside["email"] . '</p>
            <p>Mobile No: ' . $res_inside["mobile_no"] . '</p>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">';
                $i++;
            }

            ?>
            <div class="mt-5">
                <?php include("./footer-of-logbook.php"); ?>
            </div>
            <h6>Guide Name: <?php echo $guide_name; ?></h6>
        </div>
        <br clear="all" style="page-break-before:always" />

        <!-- loop here for all logs -->
        <?php
        $query = "select * from log_content where groupno =$group_no";
        $result = mysqli_query($conn, $query);
        while ($data = $result->fetch_assoc()) {
            $progress_planned = $data['progress_planned'];
            $progress_achieved = $data['progress_achieved'];
            $guide_review = $data["guide_review"];
            $date_of_log_sub = $data["date"];
            $log_no = $data["log_no"];

            $sql_for_grps = "select * from groups g join userinfo u on g.student_id=u.username where groupno=$group_no";
            $res_for_grps = mysqli_query($conn, $sql_for_grps);

            echo "
                <div class='container each-page'>
                <hr style='height:2px;border-width:0;color:gray;background-color:gray'>
                    <center><h2>A.P. Shah Institute Of Technology</h2></center>
                    <hr style='height:2px;border-width:0;color:gray;background-color:gray'>
                    <center>
                        <h5 class='text-muted'>Academic Year " . date('y', strtotime('-1 year')) . " - " . $year_now . "</h5>
                    </center>
                    <p>Year: " . $year . "</p>
                    <p>Sem: " . $semester . "</p>
                    <p>Log Number: " . $log_no . "</p>
                        <div class='col-lg-12' style='border-radius:6px;overflow:hidden;border:0.2px solid grey'>
                            <div class='table-responsive'>
                                <table class='table table-bordered border-secondary my-2'>
                                    <tr>
                                        <th>Progress Planned</th>
                                        <th>Progress Achieved</th>
                                    </tr>
                                    <tr>
                                        <td>" . $progress_planned . " </td>
                                        <td>" . $progress_achieved . " </td>
                                    </tr>
                    
                                </table>    
                            </div>
                        </div>
                    <p><span class='fw-bold'>Guide Review: </span>" . $guide_review . "</p>";
            echo "<p class='fw-bold'>Signature</p>";
            $i = 1;
            while ($d = $res_for_grps->fetch_assoc()) {
                echo "<p>Team Member " . $i . ": " . $d["student_id"] . " - " . $d["name"] . "</p>";
                $i++;
            }
            echo '
                    <hr class="mb-5" style="height:2px;border-width:0;color:gray;background-color:gray">
                    <div class="mt-5">
                    <div class="d-flex flex-row justify-content-between">
                        <h6 class="text-start p-2 col-md-4 col-lg-4 col-sm-4 col-xs-4 my-3">Project Guide</h6>
                        <h6 class="text-center p-2 col-md-4 col-lg-4 col-sm-4 col-xs-4 my-3">Project Co-ordinator</h6>
                        <h6 class="text-end p-2 col-md-4 col-lg-4 col-sm-4 col-xs-4 my-3">Head Of Department</h6>
                    </div>
                    </div>
                    <h6>Guide Name: ' . $guide_name . '</h6>
                    <h6>Date: ' . $date_of_log_sub . '</h6></div>
                    <br clear="all" style="page-break-before:always" />';
        }
        ?>





    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>

</html>