<?php
    session_start();
    require_once("../../src/general/security.php");

    if(!Security::userAuthentication(logInCheck : TRUE)){
        Security::redirectUserBase();
        die();
    }

    if(!isset($_SESSION['resetCheck']) || $_SESSION['resetCheck'] !== true){  //if the user is not logged in and has not checked the reset code
        header('Content-Type: application/json;');
        echo json_encode(array("errMsg" => "Unable to reset your password. <br>Please try again later"));
        exit();
    }

    require_once("../../src/general/actor.php");

    //get the json data from the request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $password = $data['newPassword'];
    $confirmPassword = $data['confirmPassword'];

    //password pattern check
    if(!preg_match("/(?=.*\d)(?=.*[A-Z]).{8,}/", $password)){
        header('Content-Type: application/json;');
        echo json_encode(array("errMsg" => "Password length must be atleast 8 characters. Must include an uppercase letter and a number"));
        exit();
    }

    if($password !== $confirmPassword){   //passwords do not match
        header('Content-Type: application/json;');
        echo json_encode(array("errMsg" => "Passwords do not match"));
        exit();
    }

    //hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $resettingActor = new Actor();
    $resettingActor -> setUserID($_SESSION['resetUserID']);
    $result = $resettingActor -> resetPassword($passwordHash);


    if($result === TRUE){   //successfully reset the password
        //delete the data from the session
        session_unset();
        session_destroy();
        header('Content-Type: application/json;');
        echo json_encode(array("successMsg" => "Password reset is successful."));
    }
    else{
        header('Content-Type: application/json;');
        echo json_encode(array("errMsg" => "Unable to reset your password. <br>Please try again"));
    }

    $resettingActor -> closeConnection();
    unset($resettingActor);
    exit();

?>