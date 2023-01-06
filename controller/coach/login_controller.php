<?php
    session_start();
    require_once("../../src/coach/coach.php");
    require_once("../../src/coach/dbconnection.php");


    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginUser = new Coach();

    $resultmsg = $loginUser -> login($username, $password, $connection);

    if(count($resultmsg) === 1){    //login failed
        $_SESSION['errMsg'] = $resultmsg[0];
    }
    else{   //log in success
        unset($_SESSION['errMsg']);
        $_SESSION['LogInsuccessMsg'] = $resultmsg[0];
        $_SESSION['userrole'] =  $resultmsg[1];
        $profilePic = $loginUser -> getProfilePic();
        
        if($profilePic !== ''){ //user has set an profile pic
            $_SESSION['userProfilePic'] = $profilePic;
        }
        $_SESSION['userid'] = $loginUser -> getUserID();
        $_SESSION['username'] = $resultmsg[2];
        $_SESSION['coachsportid'] = $loginUser -> getSport();
    }
    header("Location: /public/coach/coach_login.php");
    $connection -> close();
?>