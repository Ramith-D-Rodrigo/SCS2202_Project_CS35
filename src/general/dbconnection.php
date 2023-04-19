<?php
    //general connection to the database (Any Actor, basically the connection for the users who are not logged in)
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
?>