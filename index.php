<!doctype html>
<?php 
  include("./includes/connect.php");
  
  function get_token($username){
    $token=md5(date("l").$username.date("d"));
    return $token;
  }
?>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>Signin To APSIT Logbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

html,body {
  height: 100%;
  color-scheme: dark!important;
}

body {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="text"] {
  margin-bottom: -1px;

}

.form-signin input[type="password"] {
  margin-bottom: 10px;

}
    </style>

  </head>
  <?php 
    $msg="";
    if(isset($_POST["username"])){
      $username = $_POST["username"];
      $password = $_POST["password"];
		  $hash = password_hash($password,PASSWORD_DEFAULT);
      $sql = "select * from users where username = $username";
      $result = mysqli_query($conn, $sql)->fetch_assoc();
      if($result){
        if ($password=='1234'){
          session_start();
          setcookie("username", $username, time() + 3600);
          setcookie("role", $result["role"], time() + 3600);
          setcookie("token",get_token($username), time()+3600);
          header("Location: /diary/logbook/change-password.php");
        }
        else{
        if(password_verify($result["password"],$hash)){
          session_start();
          setcookie("username", $username, time() + 3600);
          setcookie("role", $result["role"], time() + 3600);
          setcookie("token",get_token($username), time()+3600);
          header("Location: /diary/logbook/check-user.php");
        }else{
          $msg = "Password is Incorrect";
        }
      } 
      }else{
        $msg = "Username is Incorrect";
      }

    }
  ?>
  <body class="text-center">
    
<main class="form-signin w-100 m-auto">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <!-- <img class="mb-4" src="./logo.png" alt=""> -->
    <h1 class="h3 mb-3 fw-medium">APSIT Online Logbook</h1>
    <p class="text-danger"><?php echo $msg;?></p>

    <div class="form-floating mb-2 rounded-3">
      <input  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "10" class="form-control" name="username" id="username" placeholder="Moodle/Phone No" required>
      <label for="username">Username</label>
    </div>
    <div class="form-floating mb-2 rounded-3">
      <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
      <label for="password">Password</label>
    </div>
    <button class="w-100 btn btn-lg btn-outline-info" type="submit">Sign in</button>
    <p class="mt-4 mb-3 text-muted">&copy; APSIT ??? 2023</p>
  </form>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> 
  </body>
</html>