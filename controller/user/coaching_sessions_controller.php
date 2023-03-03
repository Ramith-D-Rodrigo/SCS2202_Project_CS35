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

    //get ongoing registered coaching sessions
    $ongoingCoachingSessions = $user -> getOngoingCoachingSessions();

    //get pending coaching session requests
    $pendingCoachingSessions = $user -> getPendingCoachingSessionRequests();    //returns an array of coaching session objects

    //get left coaching sessions
    $leftCoachingSessions = $user -> getLeftCoachingSessions();


    $allSessions = array_merge($ongoingCoachingSessions, $pendingCoachingSessions, $leftCoachingSessions); //merge all the arrays

    if(empty($allSessions)){    //no sessions
        $returnMsg['msg'] = "You haven't joined any coaching sessions yet.";
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode($returnMsg);
        die();
    }

    
    $coaches = [];
    $courts = [];

    //store the session ids in an array for excluding duplicates (if the user has requested to join a session which he has previously left
    //or if the user has joined a session which he has previously left)

    $sessionIDs = [];

    //get general details of the coaching sessions (day, time, sport, coach)

    foreach($allSessions as $key => $currSession){
        if(in_array($currSession -> getSessionID(), $sessionIDs)){ //if the session is already in the array
            //remove the currentSession from allSessions
            unset($allSessions[$key]);
        }

        $currSession -> getDetails($user -> getConnection(), ['day', 'startingTime', 'endingTime', 'coachID', 'courtID', 'paymentAmount']);
        $temp = json_decode(json_encode($currSession), true);

        if(!array_key_exists($temp['coachID'], $coaches)){  //if the coach is not in the array
            $tempCoach = new Coach();
            $tempCoach -> setUserID($temp['coachID']);
            $coachPic = $tempCoach -> getDetails('photo');

            $firstName = $tempCoach -> getDetails('firstName');
            $lastName = $tempCoach -> getDetails('lastName');

            $coachName = $firstName . ' ' . $lastName;

            $tempSport = new Sport();
            $tempSport -> setID($tempCoach -> getSport());

            $tempSport -> getDetails($user -> getConnection(), ['sportName']);

            $sportName = json_decode(json_encode($tempSport), true)['sportName'];
            
            $coaches += [$temp['coachID'] => ['sport' => $sportName, 'photo' => $coachPic, 'name' => $coachName]];

            unset($tempCoach);
        }

        if(!array_key_exists($temp['courtID'], $courts)){
            $tempCourt = new Sports_Court($temp['courtID']);
            $courtName = $tempCourt -> getName($user -> getConnection());
            $courtBranch = $tempCourt -> getBranch($user -> getConnection());

            $tempBranch = new Branch($courtBranch);
            $tempBranch -> getDetails($user -> getConnection(), ['city']);

            $branchLocation =  json_decode(json_encode($tempBranch), true)['city'];
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

        array_push($sessionIDs, $currSession -> getSessionID());

    }

    $returnMsg = ['coachingSessions' => $allSessions, 'coaches' => $coaches, 'courts' => $courts];
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($returnMsg);
    die();

?>
