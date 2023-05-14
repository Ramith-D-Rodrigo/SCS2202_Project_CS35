<?php
    //User connection to the database
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $db = "sportude";

    $connection = new mysqli($serverName, $username, $password, $db);    //establish the connection to the server

    // Checking connection
    if ($connection -> connect_error){
        die("Connection failed: " . $connection -> connect_error);  //connection failure
    }
    //echo "Connected successfully\n";

    //turn off report mode
    //mysqli_report(MYSQLI_REPORT_OFF);

    //turn on report mode
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>