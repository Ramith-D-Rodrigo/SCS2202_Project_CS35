<?php
    session_start();
    require_once("../../src/general/security.php");
    require_once("../../src/general/mailer.php");
    require_once("../../src/user/user.php");

    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){
        Security::redirectUserBase();
        die();
    }

    if(!isset($_SESSION['verificationCode'])){  //verification code not set
        Security::redirectUserBase();
        die();
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){  //if the request is not a POST request
        Security::redirectUserBase();
        die();
    }

    //get the user request data
    $requestJSON = json_decode(file_get_contents('php://input'), true);

    $userCode = $requestJSON['verificationCode'];

    $deactivatingUser = new User();
    $deactivatingUser -> setUserID($_SESSION['userid']);
    $userEmail = $deactivatingUser -> getEmailAddress();
    $username = $deactivatingUser -> getUsername();

    if($userCode != $_SESSION['verificationCode']){  //if the verification code is not correct
        //resend the code
        $code = rand(100000, 999999);
        $_SESSION['verificationCode'] = $code;


        Mailer::deactivateAccount($userEmail, $username, $code);

        http_response_code(401);    //unauthorized
        header('Content-Type: application/json;');
        echo json_encode(array("msg" => "Invalid Verification Code. <br> New Code has been sent to your email."));
        die();
    }

    if($deactivatingUser -> deactivateAccount()){
        //inform the account deactivation to the user by email
        $status = Mailer::deactivateAccountNotification($userEmail, $username);

        //delete the session variables by logging out
        $deactivatingUser -> logout();
        unset($deactivatingUser);
    
        http_response_code(200);
        header('Content-Type: application/json;');
        echo json_encode(array("msg" => "Account Deactivated Successfully"));
        die();
    }
    else{
        http_response_code(500);
        header('Content-Type: application/json;');
        echo json_encode(array("msg" => "Account Deactivation Failed. <br> Please try again later."));
        die();
    }
?>