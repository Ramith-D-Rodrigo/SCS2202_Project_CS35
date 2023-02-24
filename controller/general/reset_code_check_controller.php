<?php
    session_start();
    if((isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is logged in
        header("Location: /index.php"); //the user shouldn't be able to access the page
        exit();
    }

    if(!isset($_SESSION['resetUserID'])){  //if the user is not logged in and has not checked the reset code
        header('Content-Type: application/json;');
        echo json_encode(array("errMsg" => "Unable to reset your password. <br>Please try again later"));
        exit();
    }

    require_once("../../src/general/actor.php");
    require_once("../../src/general/mailer.php");

    //get the json data from the request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $userInputCode = $data['userInputCode'];

    if($_SESSION['code'] != $userInputCode){   //has entered a wrong code
        //new code
        $code = rand(100000, 999999);
        $_SESSION['code'] = $code;
        //resend the email
        $status = Mailer::passwordReset($_SESSION['email'], $_SESSION['username'], $code);
        header('Content-Type: application/json;');
        echo json_encode(array("errMsg" => "Invalid Code.<br>Please try again using the new code that has been sent to your email address"));
        exit();
    }

    //delete the data from the session
    unset($_SESSION['code']);
    unset($_SESSION['email']);
    unset($_SESSION['username']);

    $_SESSION['resetCheck'] = true;

    header('Content-Type: application/json;');
    echo json_encode(array("successMsg" => "Please enter your new password"));
    exit();
?>