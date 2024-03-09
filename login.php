<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: index.php");
    exit();
}

if(isset($_POST["login"])){
    $email=$_POST["email"];
    $password=$_POST["password"];
    require_once "database.php";
    $sql="SELECT * FROM personal_info WHERE email='$email'";
    $result=mysqli_query($conn, $sql);
    $user=mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($user) {
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"]="yes";
            header("Location: index.php");
            die();
        } else {
            echo "<div class='alert alert-danger'> Password does not match</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Email does not match </div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="login-delete.css">
  <link rel="icon" href="new-logo-icon.PNG">
</head>
<body>
            
            
<div class="main-container">
    <div class="login">

    <div class="button">
            <a href="login.php"><button id="login" onclick="playButtonClickAndSound()">LOGIN</button></a>
            <!-- <input type="submit" value="PLAY" name="login" id="play"> -->
            <a href="index.php"><button id="close" onclick="playButtonClickAndSound()">X</button></a>
        </div>

        <img class="login-box" src="login-box-2.svg">

        <form class="login-form" action="login.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

           

            <div class="register-link">
                <p>Doesn't have an account yet? <a href="registration.php">Create Account</a></p>
            </div>

            <div class="form-btn">                        
                <input type="submit" value="Play" class="btn btn-primary" name="login" id="play">
            </div>
        </form>

       
    </div>
</div>



<div class="footer">
        <p>© Copyright 2024 | All rights reserved.<br>
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Created by <span>Angcot · Fesariton · Melliza · Quintos · Sosas</span>
        </p>
        <div class="right-side-footer">
            <p class="hi">Connect with us  &nbsp;  </p>
            <a href="https://www.facebook.com/inytwjo"><img class="icon" src="envelope.svg" alt="Envelope"></a>
            <a href="https://www.facebook.com/inytwjo"><img class="icon" src="facebook.svg" alt="Facebook"></a>
        </div>
    </div>
</body>
</html>




