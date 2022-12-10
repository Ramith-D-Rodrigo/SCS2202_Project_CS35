<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");


    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginAdmin = Admin::getInstance();

    $resultmsg = $loginAdmin -> login($username, $password, $connection);

    if(count($resultmsg) === 1){    //login failed
        $_SESSION['errMsg'] = $resultmsg[0];
    }
    else{   //log in success
        unset($_SESSION['errMsg']);
        $_SESSION['LogInsuccessMsg'] = $resultmsg[0];
        $_SESSION['userrole'] =  $resultmsg[1];
        $_SESSION['username'] =  $resultmsg[2];
        $_SESSION['userid'] = $loginAdmin -> getAdminID();

        // print_r($_SESSION['userid']);
        // print_r($_SESSION['userrole']);
        // print_r($_SESSION['username']);
        // print_r($_SESSION['LogInsuccessMsg']);
    }
    header("Location: /public/system_admin/admin_login.php");
    $connection -> close();
?>