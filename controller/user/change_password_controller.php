<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){
        Security::redirectUserBase();
        die();
    }

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        Security::redirectUserBase();
        die();
    }

    $returnMsg = array();

    if($_SESSION['resetCheck'] != true){    //user hasn't went through the reset password process (verification code sent to email)
        $returnMsg['errMsg'] = "Please Try Again Later";
        http_response_code(401);
        header('Content-Type: application/json;');
        echo json_encode($returnMsg);
        die();
    }

    $requestInput = json_decode(file_get_contents("php://input"), true);
    if($requestInput == null || !isset($requestInput['verificationCode'])){ //some error with post request
        $returnMsg['errMsg'] = "Invalid Request";
        http_response_code(401);
        header('Content-Type: application/json;');
        echo json_encode($returnMsg);
        die();
    }

    if($requestInput['verificationCode'] != $_SESSION['verificationCode']){
        $returnMsg['errMsg'] = "Invalid Code";
        //invalid request code
        http_response_code(400);
        header('Content-Type: application/json;');
        echo json_encode($returnMsg);
        die();
    }

    require_once("../../src/user/user.php");
    $actionUser = new User();
    $actionUser -> setUserID($_SESSION['userid']);

    $flag = $actionUser -> resetPassword($_SESSION['newPassword']);

    unset($_SESSION['newPassword']);
    unset($_SESSION['verificationCode']);
    unset($_SESSION['resetCheck']);

    if($flag){
        $returnMsg['msg'] = "Password Changed Successfully";
        http_response_code(200);

    }else{
        $returnMsg['errMsg'] = "Something Went Wrong";
        http_response_code(400);

    }
    header('Content-Type: application/json;');
    echo json_encode($returnMsg);


?>