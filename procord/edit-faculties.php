<?php
  include("../includes/connect.php");
  include("../includes/conditions.php");

  if(isset($_COOKIE["role"])){
    if($_COOKIE["role"] != "admin"){
        header("Location: ". $_SERVER["HTTP_REFERER"]);
      }
  }


  if(isset($_POST["f_username"])){
    $f_username=$_POST["f_username"];
    $f_role=$_POST["f_role"];
    $f_sem=$_POST["f_sem"];
    $f_year=$_POST["f_year"];
    if($f_role == "proco"){
      $sql1="select * from procos where username='$f_username'";
      $result1=mysqli_query($conn, $sql1)->fetch_assoc();
      if($result1){
        $sql2="update procos set sem='$f_sem', year='$f_year' where username=$f_username";
        $res2=mysqli_query($conn, $sql2);
      }else{
        $sql2="insert into procos (username, sem, year) values ('$f_username', '$f_sem', '$f_year')";
        $res2=mysqli_query($conn, $sql2);
      }
    }
    $sql3="update users set role='$f_role' where username=$f_username";
    $res3=mysqli_query($conn, $sql3); 
  }
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Faculties</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
    <?php include('../includes/navbar.php')?>
    <div class="container">
        <h3 class="my-4">Below listed are all the faculties:</h3>
        <hr>
    <?php 
    $sql = "select * from users NATURAL JOIN userinfo where role='proco' OR role='guide'";
    $res=mysqli_query($conn, $sql) or die(mysqli_error($conn));

    echo '
    <div class="col-lg-12" style="border-radius:6px;overflow:hidden;border:0.2px solid grey">
    <div class="table-responsive"> 
    <table class="table table-bordered border-secondary rounded-2 my-0">
        <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Name</th>
                <th scope="col">Mobile Number</th>
                <th scope="col">Department</th>
                <th scope="col">Role</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
    <tbody>';
    

    while($r = $res->fetch_assoc()){
        echo '

        <div class="modal fade" id="exampleModal'. $r["username"]. '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="'.$_SERVER["PHP_SELF"].'">
          <div class="col-xs-12 my-3">
            <label for="'. $r["username"]. '" class="form-label">Faculty Username</label>
            <input class="form-control" name="f_username" id="'. $r["username"]. '" value="'. $r["username"]. '" readonly>
          </div>
          <div class="col-xs-12 mb-3">
            <label for="role" class="form-label">Faculty Role</label>
            <select class="form-select" name="f_role" id="role">
                <option value="guide" >Guide</option>
                <option value="proco" >Project Co-ordinator</option>
            </select>
          </div>

          <div class="col-xs-12 mb-3 my-3">
            <label for="role" class="form-label">Semester</label>
            <select class="form-select" name="f_sem" id="role">
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

        <div class="col-xs-12 mb-3">
          <label for="role" class="form-label">Year</label>
          <select class="form-select" name="f_year" id="role">
              <option >SE</option>
              <option >TE</option>
              <option >BE</option>
          </select>
        </div>

          <div class="row g-3 my-2">
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
              <button class="w-100 btn btn-outline-info" name="submit" type="submit">Submit</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
        
        <tr>
        <td class="fw-bold">'. $r["username"] .'</td>
        <td>'. $r["name"] .'</td>
        <td>'. $r["mobile_no"] .'</td>
        <td>'. $r["dept"] .'</td>
        <td>'. $r["role"] .'</td>
        <td>
            <button type="button" class="text-white btn" data-bs-toggle="modal" data-bs-target="#exampleModal'. $r["username"]. '">
            <i class="bi bi-pencil-fill"></i>
            </button>
        </td>
      </tr>';
    };

      echo '
    </tbody>
    </table>
    </div>
    </div>';

    ?>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>