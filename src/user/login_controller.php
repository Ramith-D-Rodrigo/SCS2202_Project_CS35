<?php
    session_start();
    require_once("./user.php");
    require_once("./dbconnection.php");


    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginUser = new User();

    $resultmsg = $loginUser -> login($username, $password, $connection);

    if(count($resultmsg) === 1){    //login failed
        $_SESSION['errMsg'] = $resultmsg[0];
        echo $_SESSION['errMsg'];
    }
    else{   //log in success
        unset($_SESSION['errMsg']);
        $_SESSION['successMsg'] = $resultmsg[0];
        $_SESSION['userrole'] =  $resultmsg[1];
        $_SESSION['userid'] = $loginUser -> getUserID();
        echo $_SESSION['successMsg'];
    }
    header("Location: ./user_login.php");
    
?>