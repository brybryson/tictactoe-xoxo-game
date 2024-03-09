<?php
    $hostName = "localhost";
    $dbUser = "id21913042_tictacto225db";
    $dbPassword = "Database123!";
    //change the dbName to "melliza_log_register"
    $dbName = "id21913042_ttt225db"; 
    $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
    if (!$conn) {
        die("Something went wrong!");
    }
?>