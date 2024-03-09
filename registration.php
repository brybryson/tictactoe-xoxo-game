<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: index.php");
    exit(); // Add exit() to stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="registration.css">
    <link rel="icon" href="new-logo-icon.PNG">
</head>
<body>
<div class="main-container">
    <div class="login">
        <div class="button">
            <a href="login.php"><button id="login" onclick="playButtonClickAndSound()">SIGN UP</button></a>
            <a href="index.php"><button id="close" onclick="playButtonClickAndSound()">X</button></a>
        </div>
        <img class="login-box" src="login-box-2.svg">

        <?php
        if(isset($_POST["submit"])){
            $LastName = $_POST["LastName"];
            $FirstName = $_POST["FirstName"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $RepeatPassword = $_POST["repeat_password"];
            
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();

            if (empty($LastName) || empty($FirstName) || empty($email) || empty($password) || empty($RepeatPassword)) {
                array_push($errors, "All fields are required");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }

            if (strlen($password) < 8) {
                array_push ($errors, "Password must be at least 8 characters long");
            }

            if($password != $RepeatPassword){
                array_push($errors, "Passwords do not match");
            }

            // Change "hatdog" to your table name
            require_once "database.php";
            $sql = "SELECT * FROM personal_info WHERE email='$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                array_push($errors, "Email already exists");
            }

            if (count($errors) > 0){
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {
                $sql = "INSERT INTO personal_info(LastName, FirstName, email, password) values(?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $preparestmt = mysqli_stmt_prepare($stmt, $sql);
                if ($preparestmt) {
                    mysqli_stmt_bind_param($stmt, "ssss", $LastName, $FirstName, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'> You are Registered Successfully! </div>";
                } else {
                    die("Something went wrong");
                }
            }
        }
        ?>

        <form class="login-form" action="registration.php" method="post">
            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" class="form-control" name="LastName" >
            </div>

            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" class="form-control" name="FirstName">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" >
            </div>

            <div class="form-group">
                <label for="password">Repeat Password</label>
                <input type="password" class="form-control" name="repeat_password" >
            </div>

            <!-- <div class="form-btn">                        
                <input type="submit" value="Play" name="submit" id="play">
            </div> -->
            <div class="form-btn">
                    <input type="submit" name="submit" class="btn btn-primary" id="play" value="REGISTER">
                </div>

            <div class="register-link">
                <p>Already registered? <a href="login.php">Login Here</a></p>
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
<!-- <script src="script.js" name="Register" placeholder="submit"></script> -->
</body>
</html>
