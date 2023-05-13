<?php

    //this script is used to get all the details of a specific coach to display in the coach profile page
    session_start();
    //script authentication
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck : false, acceptingUserRoles: ['user'])){
        die();
    }

    if(isset($_GET['coachID'])){    //coming from a get request
        $coachID = $_GET['coachID'];
    }
    else{
        exit();
    }

    require_once("../../src/coach/coach.php");
    require_once("../../src/general/sport.php");
    require_once("../../src/general/dbconnection.php");

    $viewingCoach = new Coach();    //coach object

    $viewingCoach -> setUserID($coachID);

    $viewingCoach -> getDetails();  //get coach's details like name, gender, age, etc
    $coachRating = $viewingCoach -> getRating();    //get coach rating

    $coachSport = new Sport();
    $coachSport -> setID($viewingCoach -> getSport());

    $sportName = $coachSport -> getDetails($connection, ['sportName', 'maxNoOfStudents']);   //sport name and max no of students

    //get coaching sessions of the coach

    $coachingSessionsObjs = $viewingCoach -> getAllSessions();
    $coachingSessionsArr = [];  //this is to store the sessions with needed information
    if($coachingSessionsObjs !== NULL){ //has coaching sessions
        foreach($coachingSessionsObjs as $currSession){
            $currSession -> getDetails($connection);

            $tempJSON = json_encode($currSession);  
            $neededInfo = json_decode($tempJSON, true);

            if(isset($neededInfo['cancelDate']) && $neededInfo['cancelDate'] !== NULL){ //if the session is cancelled
                //we do not need this session
                unset($neededInfo);
                continue;
            }

            //filtering session needed information
            unset($neededInfo["coachMonthlyPayment"]);
            array_push($coachingSessionsArr, $neededInfo);
            unset($currSession);
        }
        unset($coachingSessionsObjs);
    }
    $coachFeedback = $viewingCoach -> getFeedback();

    //filtering coach's needed information
    $coachJSON = json_encode($viewingCoach);
    $coachNeededInfo = json_decode($coachJSON, true);
    unset($coachNeededInfo['homeAddress']);
    unset($coachNeededInfo['sport']);
    unset($coachNeededInfo['username']);

    //calculate age
    $today = new DateTime();
    $coachBirthday = new DateTime($coachNeededInfo['birthday']);

    $age = ($today -> diff($coachBirthday)) -> y;
    unset($coachNeededInfo['birthday']);
    $coachNeededInfo['age'] = $age;
    unset($today);
    unset($coachBirthday);


    $returningJSON = array(
        "coachInfo" => $coachNeededInfo,
        "coachRating" => $coachRating,
        "sportInfo" => $coachSport,
        "coachingSessions" => $coachingSessionsArr,
        "coachFeedback" => $coachFeedback
    );


    header('Content-Type: application/json');
    echo json_encode($returningJSON, JSON_PRETTY_PRINT);
?>