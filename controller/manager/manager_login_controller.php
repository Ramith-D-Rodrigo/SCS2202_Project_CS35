<?php
    session_start();
    require_once("../../src/manager/manager.php");
    require_once("../../src/manager/dbconnection.php");


    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginUser = new User();

    $resultmsg = $loginUser -> login($username, $password, $connection);

    if(count($resultmsg) === 1){    //login failed
        $_SESSION['errMsg'] = $resultmsg[0];
    }
    else{   //log in success
        unset($_SESSION['errMsg']);
        $_SESSION['LogInsuccessMsg'] = $resultmsg[0];
        $_SESSION['userrole'] =  $resultmsg[1];
        $_SESSION['userid'] = $loginUser -> getUserID();

    }
    header("Location: /public/manager/manager_login.php");
    $connection -> close();
    ?>