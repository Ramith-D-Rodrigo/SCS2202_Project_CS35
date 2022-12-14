<?php
    session_start();
    require_once("../../src/owner/owner.php");
    require_once("../../src/owner/dbconnection.php");


    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginRecep = new Owner();

    $resultmsg = $loginRecep -> login($username, $password, $connection);  //call the login function

    if(count($resultmsg) === 1){    //login failed
        $_SESSION['errMsg'] = $resultmsg[0];
    }
    else{   //log in success
        unset($_SESSION['errMsg']);
        $_SESSION['LogInsuccessMsg'] = $resultmsg[0];
        $_SESSION['userrole'] =  $resultmsg[1];
       // $_SESSION['userid'] = $loginUser -> getOwnerID();
        
      
        $_SESSION['username'] = $resultmsg[2];
    }
    header("Location: /public/owner/owner_login.php");
    $connection -> close();
?>