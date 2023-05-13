<?php
    //this script is used to authenticate the user when they enter the username and password in an authentication form
    session_start();
    require_once("../../src/general/actor.php");
    require_once("../../src/general/security.php");

    $userInput = json_decode(file_get_contents("php://input"), true);

    $returnMsg = array();

    //check for validation
    if(!isset($userInput['username']) || !isset($userInput['password'])){   //if the username or password is not set
        $statusCode = 400;
        $returnMsg['errMsg'] = "Invalid Request";
        http_response_code($statusCode);
        header("Content-Type: application/json");
        echo json_encode($returnMsg);
        die();
    }

    $username = $userInput['username'];
    $password = $userInput['password'];

    $authResult = Security::ActionAuthentication($username, $password, $_SESSION['userrole'], $_SESSION['userid']);   //authenticate the user

    //send a http response

    $statusCode = null;
    if($authResult === true){   //if the user is authenticated
        $statusCode = 200;
        $returnMsg['message'] = "Valid Credentials";
        $_SESSION['userAuth'] = true; //let the server know that user is authenticated
    }
    else{   //if the user is not authenticated
        $statusCode = 401;
        $returnMsg['errMsg'] = "Invalid Credentials";

    }

    http_response_code($statusCode);    //send the http response code (200 or 401)
    header("Content-Type: application/json");   //send the content type
    echo json_encode($returnMsg);
    die();
?>