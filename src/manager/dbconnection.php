<?php
    //manager connection to the database
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $db = "sportude";


    $connection = new mysqli($serverName, $username, $password, $db);    //establish the connection with the database

    // Checking connection
    if ($connection -> connect_error){
        die("Connection failed: " . $connection -> connect_error);  //connection failure
    }
    //echo "Connected successfully\n";
?>