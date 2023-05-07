<?php
    //this script is used to cancel a coaching session request by the user
    session_start();

    require_once("../../src/general/security.php");

    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){ //not authenticated
        Security::redirectUserBase();
        die();
    }

    //check the server request
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){  //if the request is not a POST request
        Security::redirectUserBase();
        die();
    }

    //get the user request data
    $requestJSON = json_decode(file_get_contents('php://input'), true);

    if(!isset($requestJSON['sessionID'])){  //unable to get the sessionID
        http_response_code(400);
        header('Content-Type: application/json;');
        echo json_encode(array("msg" => "Invalid Request"));
        die();
    }

    $sessionID = $requestJSON['sessionID'];

    require_once("../../src/user/user.php");
    require_once("../../src/coach/coaching_session.php");

    $reqUser = new User();
    $reqUser -> setUserID($_SESSION['userid']);

    $cancellingSession = new Coaching_Session($sessionID);

    //cancel the request

    $status = $reqUser -> cancelCoachingSessionRequest($cancellingSession);

    $msg = [];
    $httpCode = 200;

    if($status == true){
        $msg['msg'] = "The request has been cancelled";
    }
    else{
        $httpCode = 500;    //internal server error
        $msg['msg'] = "The request could not be cancelled";
    }

    unset($reqUser);
    unset($cancellingSession);

    http_response_code($httpCode);
    header('Content-Type: application/json;');
    echo json_encode($msg);
    die();
?>


