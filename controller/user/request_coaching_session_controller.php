<?php
    //this script is used to request to join a coaching session
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck : TRUE, acceptingUserRoles : ['user'])){
        Security::redirectUserBase();
        die();
    }

    //check request method
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        Security::redirectUserBase();
        die();
    }

    //get user response json
    $requestJSON = file_get_contents('php://input');
    if($requestJSON == NULL){
        Security::redirectUserBase();
        die();
    }

    //decode json
    $userRequest = json_decode($requestJSON, true);


    if(!isset($userRequest['requestingSession'])){  //session id not set
        http_response_code(400);
        header('Content-Type: application/json');
        $returnMsg['msg'] = 'Invalid Request';
        echo json_encode($returnMsg);
        die();
    }

    if(isset($userRequest['userMessage']) && strlen(($userRequest['userMessage'])) > 450){  //user message is too long
        http_response_code(400);
        header('Content-Type: application/json');
        $returnMsg['msg'] = 'Message is too long';
        echo json_encode($returnMsg);
        die();
    }

    $userRequest['userMessage'] = htmlspecialchars($userRequest['userMessage'], ENT_QUOTES);    //escape html characters

    require_once('../../src/coach/coaching_session.php');
    require_once("../../src/user/user.php");


    $requestingUser = new User();
    $requestingUser -> setUserID($_SESSION['userid']);

    //check the session's capacity
    $requestingSession = new Coaching_Session($userRequest['requestingSession']);
    if(!$requestingSession -> getAvailability($requestingUser -> getConnection())){  //the session is not available
        http_response_code(400);
        header('Content-Type: application/json');
        $returnMsg['msg'] = 'The session has reached its capacity';
        echo json_encode($returnMsg);
        die();
    }

    if($requestingUser -> isStudent()){ //the user is already a student
        //check if the user has already joined the session
        $ongoingSessions = $requestingUser -> getOngoingCoachingSessions();

        if($ongoingSessions != []){ //has ongoing sessions
            foreach($ongoingSessions as $session){
                if($session -> getSessionID() == $userRequest['requestingSession']){    //found the session and the user is already joined
                    http_response_code(400);
                    header('Content-Type: application/json');
                    $returnMsg['msg'] = 'You have already joined this session';
                    echo json_encode($returnMsg);
                    die();
                }

                //check whether the user is joined in some other session that is being held at the same time and day of the week as the requested session
                $session -> getDetails($requestingUser -> getConnection(), ['day', 'startingTime', 'endingTime']);
                $requestingSession -> getDetails($requestingUser -> getConnection(), ['day', 'startingTime', 'endingTime']);

                $checkingSessionASSOC = json_decode(json_encode($session), true);
                $requestingSessionASSOC = json_decode(json_encode($requestingSession), true);

                if($checkingSessionASSOC['day'] == $requestingSessionASSOC['day']){ //same day
                    //4 conditions
                    //1 - checking session starts before requesting session and ends after the requesting session
                    if($checkingSessionASSOC['startingTime'] < $requestingSessionASSOC['startingTime'] && $checkingSessionASSOC['endingTime'] > $requestingSessionASSOC['endingTime']){
                        http_response_code(400);
                        header('Content-Type: application/json');
                        $returnMsg['msg'] = 'You have already joined a session that is being held at the same time and day of the week as the requested session';
                        echo json_encode($returnMsg);
                        die();
                    }

                    //2 - checking session starts after or same time as requesting session and ends before or same time as requesting session
                    if($checkingSessionASSOC['startingTime'] >= $requestingSessionASSOC['startingTime'] && $checkingSessionASSOC['endingTime'] <= $requestingSessionASSOC['endingTime']){
                        http_response_code(400);
                        header('Content-Type: application/json');
                        $returnMsg['msg'] = 'You have already joined a session that is being held at the same time and day of the week as the requested session';
                        echo json_encode($returnMsg);
                        die();
                    }

                    //3 - checking session starts before the requesting session but ends before or same time as requesting session's ending time
                    if($checkingSessionASSOC['startingTime'] < $requestingSessionASSOC['startingTime'] && $checkingSessionASSOC['endingTime'] <= $requestingSessionASSOC['endingTime'] && $checkingSessionASSOC['endingTime'] > $requestingSessionASSOC['startingTime']){
                        http_response_code(400);
                        header('Content-Type: application/json');
                        $returnMsg['msg'] = 'You have already joined a session that is being held at the same time and day of the week as the requested session';
                        echo json_encode($returnMsg);
                        die();
                    }

                    //4 - checking session starts after or same time as requesting session's starting time but ends after the requesting session
                    if($checkingSessionASSOC['startingTime'] >= $requestingSessionASSOC['startingTime'] && $checkingSessionASSOC['startingTime'] < $requestingSessionASSOC['endingTime'] && $checkingSessionASSOC['endingTime'] > $requestingSessionASSOC['endingTime']){
                        http_response_code(400);
                        header('Content-Type: application/json');
                        $returnMsg['msg'] = 'You have already joined a session that is being held at the same time and day of the week as the requested session';
                        echo json_encode($returnMsg);
                        die();
                    }
                }

            }
        }
    }

    //check if the user has already requested to join the session
    $pendingRequests = $requestingUser -> getPendingCoachingSessionRequests();
    if($pendingRequests != []){ //has pending coaching session requests
        foreach($pendingRequests as $currRequest){
            if($currRequest -> getSessionID() == $userRequest['requestingSession']){    //found the session and the user has already requested to join
                http_response_code(400);
                header('Content-Type: application/json');
                $returnMsg['msg'] = 'You have already requested to join this session';
                echo json_encode($returnMsg);
                die();
            }
        }
    }

    //check if the user has weight and height entered in his profile
    $requestingUser -> getProfileDetails(['height', 'weight']);

    $userArr = json_decode(json_encode($requestingUser), true);
    if(!isset($userArr['height']) || !isset($userArr['weight']) || $userArr['height'] == null || $userArr['weight'] == null){    //the user has not entered his weight and height
        http_response_code(400);
        header('Content-Type: application/json');
        $returnMsg['msg'] = 'Please enter your weight and height in your profile';
        echo json_encode($returnMsg);
        die();
    }

    //the user can request now
    $status = $requestingUser -> requestCoachingSession($requestingSession, $userRequest['userMessage']);
    if(!$status){   //request failed
        http_response_code(400);
        header('Content-Type: application/json');
        $returnMsg['msg'] = 'Request Failed';
        echo json_encode($returnMsg);
        die();
    }

    //request success
    http_response_code(200);
    header('Content-Type: application/json');
    $returnMsg['msg'] = 'Request Sent Successfully';
    echo json_encode($returnMsg);
    die();
?>