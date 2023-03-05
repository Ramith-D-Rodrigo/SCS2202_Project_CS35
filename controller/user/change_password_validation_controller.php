<?php 
    session_start();
    require_once("../../src/general/security.php"); //security class

    //check the authentication
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){  //not authenticated
        Security::redirectUserBase();
        die();
    }

    //check the request method
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        Security::redirectUserBase();
        die();
    }

    //check the user input
    $requestInput = json_decode(file_get_contents("php://input"), true);
    if($requestInput == null || !isset($requestInput['newPassword']) || !isset($requestInput['newPasswordConfirm'])){
        $returnMsg['msg'] = "Invalid Request";
        http_response_code(401);
        header('Content-Type: application/json;');
        echo json_encode($returnMsg);
        die();
    }

    $returnMsg = array();

    //password matching check
    if($requestInput['newPassword'] != $requestInput['newPasswordConfirm']){
        $returnMsg['msg'] = "Passwords do not match";
        http_response_code(400);
        header('Content-Type: application/json;');
        echo json_encode($returnMsg);
        die();
    }
    
    //password pattern check
    if(!preg_match("/(?=.*\d)(?=.*[A-Z]).{8,}/", $requestInput['newPassword'])){
        $returnMsg['msg'] = "Password length must be atleast 8 characters.<br> Must include an uppercase letter and a number";
        http_response_code(400);
        header('Content-Type: application/json;');
        echo json_encode($returnMsg);
        die();
    }

    //all matches, store the hashed password in the session, create a random code and send it to the user's email
    $_SESSION['newPassword'] = password_hash($requestInput['newPassword'], PASSWORD_DEFAULT);
    $code = rand(100000, 999999);
    $_SESSION['verificationCode'] = $code;

    //send the email
    require_once("../../src/general/mailer.php");
    require_once("../../src/user/user.php");
    $actionUser = new User();
    $actionUser -> setUserID($_SESSION['userid']);

    $username = $actionUser -> getUsername();
    $email = $actionUser -> getEmailAddress();

    $_SESSION['resetCheck'] = true;
    
    $status = Mailer::passwordReset($email, $username, $code);

    if($status == false){
        $returnMsg['msg'] = "Error sending the Email";
        http_response_code(500);
        header('Content-Type: application/json;');
        echo json_encode($returnMsg);
        die();
    }

    $actionUser -> closeConnection();
    unset($actionUser);
    //send the response
    http_response_code(200);
    $returnMsg['msg'] = "Verification Code Sent";
    header('Content-Type: application/json;');
    echo json_encode($returnMsg);
?>


    



