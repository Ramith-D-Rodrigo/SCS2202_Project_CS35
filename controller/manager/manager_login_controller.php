<?php
    session_start();
    require_once("../../src/manager/manager.php");
    require_once("../../src/manager/manager_dbconnection.php");


    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginManager = new Manager();

    $resultmsg = $loginManager -> login($username, $password, $connection);

    if(count($resultmsg) === 1){    //login failed
        $_SESSION['errMsg'] = $resultmsg[0];
    }
    else{   //log in success
        unset($_SESSION['errMsg']);
        $_SESSION['LogInsuccessMsg'] = $resultmsg[0];
        $_SESSION['userrole'] =  $resultmsg[1];
        $_SESSION['userid'] = $loginManager -> getID();
        $_SESSION['city'] = $resultmsg[2];
        $_SESSION['branchID'] = $resultmsg[3];
        $_SESSION['username'] = $resultmsg[4];
    }
    header("Location: /public/manager/manager_login.php");
    $connection -> close();
?>