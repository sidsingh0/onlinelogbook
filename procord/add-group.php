<?php
  include("../includes/connect.php");
  include("../includes/conditions.php");
  if($_COOKIE["role"] == "proco" || $_COOKIE["role"] == "admin"){
    $role = $_COOKIE["role"];
  }else{
    header("Location: /diary/logbook/logout.php?logout=true");
  }
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Coordinator - Add Group</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <?php include('../includes/navbar.php')?>
    
    <div class="container my-5">
    <?php

    if (isset($_POST['moodlesubmit'])) {
        $division=$_POST["division"];
        $year = $_POST["year"];
        $sem = $_POST["sem"];
        $guide_id = $username; 
        $title = $_POST['title'];
        $moodle_array = $_POST['moodleid'];
        $can_add = true;

        foreach ($moodle_array as $moodleid) {
            $check_grp_exist = "select * from groups where student_id=$moodleid and sem='$sem'";
            $res_grp_exist = mysqli_query($conn, $check_grp_exist);
            if(mysqli_num_rows($res_grp_exist) > 0){
                $res_grp_exist = $res_grp_exist->fetch_assoc();
                $can_add = false;
                $guide=$res_grp_exist["guide_id"];
                $guide_query = "select * from userinfo where username=$guide";
                $res_guide = mysqli_query($conn, $guide_query)->fetch_assoc();
                echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>('.$moodleid.') Student Already in a group!</strong> Guide Name: <b>'. $res_guide["name"] .'</b> Contact: '. $res_guide["mobile_no"] .'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                break;
            }else{
                break;
            }
        }
        if($can_add){
            $group_no = 0;
            $sql_select = "select max(groupno) as group_no from groups where ((division='$division' and year='$year') and (aca_year=$aca_year and sem='$sem')) and dept='$dept'";
            $result = mysqli_query($conn, $sql_select);
            if($result){
                while ($data = $result->fetch_assoc()) {
                    $group_no = $data['group_no'] ;
                }
            }
            $group_no = $group_no + 1;
            foreach($moodle_array as $moodleid){
                if(!($moodleid == "")){
                    $sql_insert = "insert into groups(groupno,guide_id,student_id,sem,year,title,division,dept) values($group_no,$username,'$moodleid','$sem','$year','$title','$division','$dept')";
                    $inserted = mysqli_query($conn, $sql_insert) or die("Maybe the moodle ids added by you were invalid!");
                }
            }
        }
    }

    ?>


    <h1 class="my-3">Add A Group:</h1>
    <hr>
    <form class="row" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <div class="form-group row mb-2">
            <div class="col-xs-12">
            <div class="input-group col-md-6 col-xs-12">
                <span class="input-group-text">Semester</span>
                <select class="form-select" name="sem" id="semcheck" oninput="setYearFromSem(this);" required>
                    <option >III</option>
                    <option >IV</option>
                    <option >V</option>
                    <option >VI</option>
                    <option >VII</option>
                    <option >VIII</option>
                </select>
            </div>
            </div>
        </div>
    
        <div class="form-group row mb-2">
            <div class="col-xs-12">
                <div class="input-group col-md-6 col-xs-12">
                <span class="input-group-text">Year</span>
                <input class="form-control" value="SE" name="year" id="yearcheck" readonly>
                </div>
            </div>
        </div>

        <div class="form-group row mb-2">
            <div class="col-xs-12">
                <div class="input-group col-md-6 col-xs-12">
                <span class="input-group-text">Division</span>
                <select class="form-select" name="division" id="division" required>
                    <option value=" ">No division</option>
                    <option >A</option>
                    <option >B</option>
                    <option >C</option>
                </select>
                </div>
            </div>
        </div>

        <div class="form-group row mb-2">
            <div class="input-group col-md-6 col-xs-12">
                <span class="input-group-text">Project Title</span>
                <input type="text" name="title" class="form-control" required>
            </div>
        
        </div>
        <div class="mb-3 row mt-5">
            <label for="inputPassword" class="col-sm-2 col-form-label">Team Member 1 (Leader):</label>
            <div class="col-sm-10">
                <input type="text" maxlength="8" name="moodleid[]" class="form-control moodle" id="inputPassword" required>
            </div>
            <div class="mt-4 text-center">
            </div>
        </div>
        <div class="mb-3 row mt-5">
            <label for="inputPassword" class="col-sm-2 col-form-label">Team Member 2:</label>
            <div class="col-sm-10">
                <input type="text" maxlength="8" name="moodleid[]" class="form-control moodle" id="inputPassword" required>
            </div>
            <div class="mt-4 text-center">
            </div>
        </div>
        <div class="mb-3 row mt-5">
            <label for="inputPassword" class="col-sm-2 col-form-label">Team Member 3:</label>
            <div class="col-sm-10">
                <input type="text" maxlength="8" name="moodleid[]" class="form-control moodle" id="inputPassword" required>
            </div>
            <div class="mt-4 text-center">
            </div>
        </div>
        <div class="mb-3 row mt-5">
            <label for="inputPassword" class="col-sm-2 col-form-label">Team Member 4 (Optional):</label>
            <div class="col-sm-10">
                <input type="text" maxlength="8" name="moodleid[]" class="form-control moodle" id="inputPassword">
            </div>
            <div class="mt-4 text-center">
            </div>
        </div>
        
<?php 
    // $i=1;
    // while($i < 5){
    //     echo '
    //     <div class="mb-3 row mt-5">
    //         <label for="inputPassword" class="col-sm-2 col-form-label">Team Member '.$i.':</label>
    //         <div class="col-sm-10">
    //             <input type="text" maxlength="8" name="moodleid[]" class="form-control moodle" id="inputPassword">
    //         </div>
    //         <div class="mt-4 text-center">

    //         </div>
    //     </div>';
    //     $i++;
    // }
?>
        <!-- <div class="form-group row my-2">
        <div class="form-group row mb-2">
            <div class="input-group">
                <span class="input-group-text">Moodle IDs of members</span>
                <input type="text" maxlength="8" name="moodleid[]" class="form-control moodle" required>
                <span></span>
                <input type="text" maxlength="8" name="moodleid[]" class="form-control moodle" required>
                <span></span>
                <input type="text" maxlength="8" name="moodleid[]" class="form-control moodle" required>
                <span></span>
                <input type="text" maxlength="8" name="moodleid[]" class="form-control moodle" required>
                <span></span>
            </div>
        </div> -->
        <div class="form-group row">
        </div>
        <div class="form-group row mb-2">
            <div class="col-xs-12">
                <button type="submit" name="moodlesubmit" class="w-100 btn btn-outline-info">Submit</button>
            </div>
        </div>
    </form>

    <hr>
    </div>
    
    <script>
        function setYearFromSem(sem){
            let a = sem.value;
            if(a === "III" || a === "IV"){
                $("#yearcheck").val("SE");
            }else if(a === "V" || a === "VI"){
                $("#yearcheck").val("TE");
            }else{
                $("#yearcheck").val("BE");
            }
            
        }
        
        $('.moodle').on("input",function () {
            let curr = $(this);
            $.ajax({
                    type: "GET",
                    url:'/diary/logbook/api_hidden_url/we_need_name.php?u='+this.value,
                    success: function(response) {
                        response = JSON.stringify(response);
                        response = JSON.parse(response);
                        let text = "Name: " + response.msg;
                        curr.closest('div').next('div').text(text);     
                    },      
                });
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>