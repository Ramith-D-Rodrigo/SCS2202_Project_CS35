<?php
    //this script is used to leave a coaching session
    session_start();
    require_once("../../src/general/security.php");

    if(!Security::userAuthentication(logInCheck:TRUE, acceptingUserRoles:['user'])){    //not authenticated
        Security::redirectUserBase();
        die();
    }

    //check server request method
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        http_response_code(405);
        header("Content-Type: application/json");
        echo json_encode(array("msg" => "Invalid Request Method"));
        die();
    }

    //get the user data
    $requestData = json_decode(file_get_contents("php://input"), true);

    if(!isset($requestData['sessionID'])){
        http_response_code(400);
        header("Content-Type: application/json");
        echo json_encode(array("msg" => "Invalid Request Data"));
        die();
    }

    $returnMsg = [];
    $httpCode = 200;
    $leavingSessionID = $requestData['sessionID'];

    require_once("../../src/user/user.php");
    require_once("../../src/coach/coaching_session.php");

    $leavingUser = new User();
    $leavingUser -> setUserID($_SESSION['userid']);

    $leavingSession = new Coaching_Session($leavingSessionID);

    //check whether the user is attending the session
    $flag = false;
    $ongoingSessions = $leavingUser -> getOngoingCoachingSessions();

    foreach($ongoingSessions as $session){
        if($session -> getSessionID() == $leavingSession -> getSessionID()){ //found the attending session
            $flag = true;
            break;
        }
    }

    if(!$flag){ //user is not attending the session
        http_response_code(400);
        header("Content-Type: application/json");
        $returnMsg['msg'] = "You are not attending the session";
        echo json_encode($returnMsg);
        die();
    }

    //leave the session
    $result = $leavingUser -> leaveCoachingSession($leavingSession);

    if($result){
        $returnMsg['msg'] = "Successfully left the session";
    }
    else{
        $httpCode = 500;
        $returnMsg['msg'] = "Failed to leave the session";
    }

    http_response_code($httpCode);
    header("Content-Type: application/json");
    echo json_encode($returnMsg);
    die();

?>