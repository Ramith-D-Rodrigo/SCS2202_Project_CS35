<?php
    //receptionist connection to the database
    include_once("../../hostChange.php");
    if(localFlag){
        $serverName = "localhost";
        $username = "root";
        $password = "";
        $db = "sportude";
    }
    else{
        $serverName = "sql12.freesqldatabase.com";
        $username = "sql12596346";
        $password = "gd6Bi5h8BX";
        $db = "sql12596346";
    }


    $connection = new mysqli($serverName, $username, $password, $db);    //establish the connection with the database

    // Checking connection
    if ($connection -> connect_error){
        die("Connection failed: " . $connection -> connect_error);  //connection failure
    }
    //echo "Connected successfully\n";
?>