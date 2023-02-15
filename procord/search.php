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
    <title>Project Coordinator - Search</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <?php include('../includes/navbar.php')?>
    <div class="container my-5">

    <h1>Search A Group:</h1>
    <hr>
    <form class="row" action="view-logs.php" method="GET">
        <div class="form-group row mb-2">
            <div class="col-xs-12 col-md-6 my-2">
                <div class="input-group col-md-6 col-xs-12">
                <span class="input-group-text">Year</span>
                <!-- <input class="form-control" value="SE" name="year" id="yearcheck" readonly> -->
                <select class="form-select" name="year" required>
                    <option >SE</option>
                    <option >TE</option>
                    <option >BE</option>
                    <!-- <option >C</option> -->
                </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 my-2">
                <div class="input-group col-md-6 col-xs-12">
                    <span class="input-group-text">Semester</span>
                    <!-- <input class="form-control" value="<?php //echo $sem_proco; ?>" id="sem" name="sem" readonly> -->
                    <select class="form-select" name="sem" id="sem" required>
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
            <div class="col-xs-12 col-md-6 my-2">
                <div class="input-group col-md-6 col-xs-12">
                <span class="input-group-text">Division</span>
                <select class="form-select" name="div" id="division" required>
                    <option value=" ">No division</option>
                    <option >A</option>
                    <option >B</option>
                    <option >C</option>
                </select>
                </div>
            </div>  
            <div class="col-xs-12 col-md-6 my-2">
                <div class="input-group col-md-6 col-xs-12">
                    <span class="input-group-text">Group No</span>
                    <input type="number" class="form-control" name="groupno" required>
                </div>
            </div>
        </div>


        <div class="form-group row mt-3">
        </div>
        <div class="form-group row mb-2">
            <div class="col-xs-12 col-md-12">
                <button type="submit" name="searchsubmit" class="w-100 btn btn-outline-info">Search</button>
            </div>
        </div>
    </form>

    <hr>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>