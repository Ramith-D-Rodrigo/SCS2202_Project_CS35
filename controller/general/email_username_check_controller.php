<?php
    //this script is used to check if the user input email address or username during the password reset functiontiality
    session_start();
    require_once("../../src/general/actor.php");
    require_once("../../src/general/security.php");
    require_once("../../src/general/mailer.php");

    if(!Security::userAuthentication(logInCheck : TRUE)){
        http_response_code(401);
        die();
    }

    //get the json data from the request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    if($data == null){
        http_response_code(400);
        die();
    }
    $userInput = $data['userInput'];

    //check if the user input is an email address or a username
    $returnVal = Security::passwordResetCheck($userInput);
    if($returnVal === false){   //if the user input is not an email address or a username or the user input is not in the database
        header('Content-Type: application/json;');
        echo json_encode(array("errMsg" => "Invalid Email Address or Username"));
        exit();
    }

    //check the user role
    if($returnVal[2] === "owner" || $returnVal[2] === "manager" || $returnVal[2] === "receptionist"){  //staff roles
        header('Content-Type: application/json;');
        echo json_encode(array("errMsg" => "Please contact the system administrator to reset your password"));
        exit();
    }
    else if($returnVal[2] === 'admin'){
        header('Content-Type: application/json;');
        echo json_encode(array("errMsg" => "Unable to send the email. <br>Please try again later"));
        exit();
    }

    $email = $returnVal[0];
    $username = $returnVal[1];
    $userID = $returnVal[3];

    //generate random code
    $code = rand(100000, 999999);

    //store the code in the session
    $_SESSION['code'] = $code;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;
    $_SESSION['resetUserID'] = $userID;

    $status = Mailer::passwordReset($email, $username, $code);
    if($status === false){
        header('Content-Type: application/json;');
        echo json_encode(array("errMsg" => "Unable to send the email. <br>Please try again later"));
        exit();
    }

    header('Content-Type: application/json;');
    echo json_encode(array("successMsg" => "An Email has been sent to your Email Address.<br>Please check your email and enter the code to reset your password"));
    exit();

?>

