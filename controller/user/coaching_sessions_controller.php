<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){ //cannot access (NOT operator)
        Security::redirectUserBase();
    }

    require_once("../../src/user/user.php");
    require_once("../../src/coach/coach.php");
    require_once("../../src/coach/coaching_session.php");
    require_once("../../src/general/sport.php");

    $user = new User();
    $user -> setUserID($_SESSION['userid']);

    $returnMsg = [];

    //check whether the user is a student
    if(!$user -> isStudent()){  
        $returnMsg['msg'] = "You haven't joined any coaching sessions yet.";
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode($returnMsg);
        die();
    }

    //get ongoing registered coaching sessions
    $ongoingCoachingSessions = $user -> getOngoingCoachingSessions();

    $pendingCoachingSessions = $user -> getPendingCoachingSessionRequests();    //returns an array of coaching session objects

    $leftCoachingSessions = $user -> getLeftCoachingSessions();


    $allSessions = array_merge($ongoingCoachingSessions, $pendingCoachingSessions, $leftCoachingSessions); //merge all the arrays
    $coaches = [];

    //get general details of the coaching sessions (day, time, sport, coach)

    foreach($allSessions as $currSession){
        $currSession -> getDetails($user -> getConnection(), ['day', 'startingTime', 'endingTime', 'coachID']);
        $temp = json_decode(json_encode($currSession), true);

        if(!array_key_exists($temp['coachID'], $coaches)){  //if the coach is not in the array
            $tempCoach = new Coach();
            $tempCoach -> setUserID($temp['coachID']);
            $coachPic = $tempCoach -> getDetails('photo');

            $tempSport = new Sport();
            $tempSport -> setID($tempCoach -> getSport());

            $tempSport -> getDetails($user -> getConnection(), ['sportName']);

            $sportName = json_decode(json_encode($tempSport), true)['sportName'];
            
            $coaches += [$temp['coachID'] => ['sport' => $sportName, 'photo' => $coachPic]];
        }
    }

    $returnMsg['data'] = ['coachingSessions' => $allSessions, 'coaches' => $coaches];
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($returnMsg);
    die();

?>
