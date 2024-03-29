<?php
    //this script is used to check the reset code entered by the user and send a new code if the code is wrong
    session_start();
    require_once("../../src/general/security.php");

    if(!Security::userAuthentication(logInCheck : TRUE)){
        Security::redirectUserBase();
        die();
    }

    if(!isset($_SESSION['resetUserID'])){  //if the user has not requested to reset the password
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