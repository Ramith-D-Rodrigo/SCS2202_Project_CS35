<?php
    //this script is used to give feedback to the coach
    session_start();
    require_once("../../src/general/security.php");
    require_once("../../controller/CONSTANTS.php");

    //check authentication
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){
        Security::redirectUserBase();
        die();
    }

    $returnMsg = [];

    //check server request method
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        http_response_code(400);
        $returnMsg['msg'] = 'Invalid Request';
        header('Content-Type: application/json');
        echo json_encode($returnMsg);
        die();
    }

    //get user request input 
    $requestArr = json_decode(file_get_contents('php://input'), true);

    //check required fields
    if(!isset($requestArr['coachID']) || !isset($requestArr['feedback']) || !isset($requestArr['rating']) || !isset($requestArr['sessionID'])){
        http_response_code(400);
        $returnMsg['msg'] = 'Invalid Request';
        header('Content-Type: application/json');
        echo json_encode($returnMsg);
        die();
    }

    require_once("../../src/user/user.php");
    require_once("../../src/coach/coaching_session.php");
    require_once("../../src/coach/coach.php");

    $feedbackUser = new User();
    $feedbackReceivingCoach = new Coach();
    $registeredSession = new Coaching_Session($requestArr['sessionID']);

    $feedbackUser -> setUserID($_SESSION['userid']);
    $feedbackReceivingCoach -> setUserID($requestArr['coachID']);

    //get user's ongoing coaching session to check if the session id is valid
    $userOngoingSessions = $feedbackUser -> getOngoingCoachingSessions();

    $validationFlag = true;

    foreach($userOngoingSessions as $session){
        if($session -> getSessionID() === $registeredSession -> getSessionID()){    //found the matching session

            //check whether the session is belonging to requesting coach
            $tempCoach = $session -> getCoach($feedbackUser -> getConnection());    //get the coach of the session

            if($tempCoach -> getUserID() !== $feedbackReceivingCoach -> getUserID()){   //check the coach ids and they are not the same
                $validationFlag = false;
                break;
            }
            //session and coach are valid
            $validationFlag = true;
            $registeredSession = $session;
            break;
        }
    }

    if(!$validationFlag){   //did not find any session that matches the session id 
        http_response_code(400);
        $returnMsg['msg'] = 'Invalid Request';
        header('Content-Type: application/json');
        echo json_encode($returnMsg);
        die();
    }

    $validationFlag = true; //reset the flag

    //check whether the user has already given feedback to the coach within last 30 days
    $coachFeedbacks = $feedbackReceivingCoach -> getFeedback();

    foreach($coachFeedbacks as $feedback){
        if($feedback -> stuID === $feedbackUser -> getUserID()){    //found the matching feedback
            //check the date
            date_default_timezone_set(SERVER_TIMEZONE);
            $feedbackDate = new DateTime($feedback -> date);
            $currDate = new DateTime("now");
            $diff = $currDate -> diff($feedbackDate);

            if($diff -> days < 30){ //the feedback is within 30 days
                $validationFlag = false;
                unset($feedbackDate);
                unset($currDate);
                break;
            }
        }
    }

    if(!$validationFlag){   //the user has already given feedback to the coach within last 30 days
        http_response_code(401);   //unauthorized
        $returnMsg['msg'] = 'You have already given feedback to this coach within last 30 days';
        header('Content-Type: application/json');
        echo json_encode($returnMsg);
        die();
    }

    //can give feedback
    $flag = $feedbackUser -> giveFeedback($registeredSession, $feedbackReceivingCoach, htmlspecialchars($requestArr['feedback'], ENT_QUOTES), $requestArr['rating']);

    if($flag){
        http_response_code(200);
        $returnMsg['msg'] = 'Feedback sent successfully';
        header('Content-Type: application/json');
        echo json_encode($returnMsg);
        die();
    }else{
        http_response_code(500);
        $returnMsg['msg'] = 'Error occurred while sending feedback';
        header('Content-Type: application/json');
        echo json_encode($returnMsg);
        die();
    }

?>