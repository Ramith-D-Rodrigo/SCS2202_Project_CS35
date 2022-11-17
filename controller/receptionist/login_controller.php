<?php
    session_start();
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");


    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginRecep = new Receptionist();

    $resultmsg = $loginRecep -> login($username, $password, $connection);  //call the login function

    if(count($resultmsg) === 1){    //login failed
        $_SESSION['errMsg'] = $resultmsg[0];
    }
    else{   //log in success
        unset($_SESSION['errMsg']);
        $_SESSION['LogInsuccessMsg'] = $resultmsg[0];
        $_SESSION['userrole'] =  $resultmsg[1];
        $_SESSION['userid'] = $loginRecep -> getReceptionistID();
        $_SESSION['branchName'] = $resultmsg[2];
        $_SESSION['branchid'] = $resultmsg[3];
        $_SESSION['username'] = $resultmsg[4];
    }
    header("Location: /public/receptionist/receptionist_login.php");
    $connection -> close();
?>