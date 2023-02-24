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
    require_once("../../src/general/sport_court.php");

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
    $courts = [];

    //get general details of the coaching sessions (day, time, sport, coach)

    foreach($allSessions as $currSession){
        $currSession -> getDetails($user -> getConnection(), ['day', 'startingTime', 'endingTime', 'coachID', 'courtID']);
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

            unset($tempCoach);
        }

        if(!array_key_exists($temp['courtID'], $courts)){
            $tempCourt = new Sports_Court($temp['courtID']);
            $courtName = $tempCourt -> getName($user -> getConnection());
            $courtBranch = $tempCourt -> getBranch($user -> getConnection());

            $tempBranch = new Branch($courtBranch);
            $branchLocation = $tempBranch -> getDetails($user -> getConnection(), 'city');

            $courts += [$temp['courtID'] => ['name' => $courtName, 'branch' => $branchLocation]];

            unset($tempCourt);
            unset($tempBranch);
        }

        //check the session user status 
        if(in_array($currSession, $ongoingCoachingSessions)){   //ongoing
            $currSession -> status = 'ongoing';
        }else if(in_array($currSession, $pendingCoachingSessions)){ //pending
            $currSession -> status = 'pending';
        }else if(in_array($currSession, $leftCoachingSessions)){    //left
            $currSession -> status = 'left';
        }

    }

    $returnMsg = ['coachingSessions' => $allSessions, 'coaches' => $coaches, 'courts' => $courts];
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($returnMsg);
    die();

?>
