<!DOCTYPE html>
<?php
include("connect.php"); ?>
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

    <nav class="navbar navbar-expand-sm navbar-dark bg-dark-subtle">
        <div class="d-flex container-fluid">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z" />
                <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
            </svg>
            <a class="flex-grow-1 navbar-brand mx-1 font-weight-bold">Online Logbook</a>
            <button class="navbar-toggler mx-1" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav nav-pills ms-auto">
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="./guideview.php">Home</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="#" aria-current="page">Your Groups</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <?php
    // echo "hello";
    $group_no = 0;
    $sql_select = "select max(groupno)+1 from groups";
    $result = mysqli_query($conn, $sql_select);
    while ($data = $result->fetch_assoc()) {
        // echo var_dump($data);
        $group_no = $data['max(groupno)+1'] ;
        // echo $group_no;
    }
    if (isset($_POST['moodlesubmit'])) {
        $guide_id = "1234567890"; //fhilal hardcoded hai 
        $title = $_POST['title'];



        $moodle_array = $_POST['moodleid'];
        foreach ($moodle_array as $moodleid) {
            $sql_insert = "insert into groups(`groupno`,`student_id`,`title`) values($group_no,$moodleid,$title)";

            $inserted = mysqli_query($conn, $sql_insert);
        }
        if ($inserted) {
            header("guideview.php");
        }
    }

    ?>

    <form class="row" action=<?php htmlspecialchars($_SERVER['PHP_SELF']) ?> method="POST">
        <div class="form-group row">
            <div class="col-md-6 col-xs-12">
                <label class="control-label"> Group No.</label>
            </div>
            <div class="col-md-6 col-xs-12">
                <label class="control-label"> <?php echo $group_no ?></label>
            </div>

        </div>
        <div class="form-group row">
            <div class="input-group col-md-6 col-xs-12">
                <span class="input-group-text">Project Title</span>
                <input type="text" name="title" class="form-control">
            </div>

        </div>

        </div>
        <div class="form-group row">
            <div class="input-group">
                <span class="input-group-text">Moodle IDs of members</span>
                <input type="text" maxlength="8" name="moodleid[]" class="form-control">
                <input type="text" maxlength="8" name="moodleid[]" class="form-control">
                <input type="text" maxlength="8" name="moodleid[]" class="form-control">
                <input type="text" maxlength="8" name="moodleid[]" class="form-control">
            </div>
        </div>
        <div class="form-group row">

            <div class="col-md-6">
                <button type="submit" name="moodlesubmit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>



    <div>


        <table class="table table-bordered border-primary">
            <tr>

                <th>Group No.</th>
                <th>Student Id</th>
                <th>Student Name</th>

                <th>Project Title</th>
            </tr>
            <?php
            $guide_id = "1234567890";
            $query = "select * from groups where guide_id =$guide_id ";
            $result = mysqli_query($conn, $query);
            while ($data = $result->fetch_assoc()) {
                // echo var_dump($data);
                $group_no = $data['groupno'];
                $studentid = $data['student_id'];
                $title = $data['title'];

                $query2 = "select * from userinfo where username=" . $studentid;
                $sdata = mysqli_query($conn, $query2)->fetch_assoc();

                $studentname = $sdata['name'];
                echo "<tr>
                <td>".$group_no." </td>
                <td>".$studentid." </td>
                <td>".$studentname." </td>
                <td>".$title." </td>
                </tr>";
                

            }
            ?>



        </table>
    </div>








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">

    </script>
</body>

</html>