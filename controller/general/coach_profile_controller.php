<?php
    session_start();
    //script authentication
    if(isset($_SESSION['userid']) && isset($_SESSION['userrole']) && ($_SESSION['userrole'] === 'manager' || $_SESSION['userrole'] === 'owner' || $_SESSION['userrole'] === 'admin' || $_SESSION['userrole'] === 'receptionist')){
        exit();
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

    $sportName = $coachSport -> getDetails($connection);   //sport name and max no of students

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

    //calculate age
    $today = new DateTime();
    $coachBirthday = new DateTime($coachNeededInfo['birthday']);

    $age = ($today -> diff($coachBirthday)) -> y;
    unset($coachNeededInfo['birthday']);
    $coachNeededInfo['age'] = $age;
    unset($today);
    unset($coachBirthday);

    //filtering sport's needed information
    $sportJSON = json_encode($coachSport);
    $sportNeededInfo = json_decode($sportJSON, true);
    unset($sportNeededInfo['description']);
    unset($sportNeededInfo['reservationPrice']);

    $returningJSON = array(
        "coachInfo" => $coachNeededInfo,
        "coachRating" => $coachRating,
        "sportInfo" => $sportNeededInfo,
        "coachingSessions" => $coachingSessionsArr,
        "coachFeedback" => $coachFeedback
    );


    header('Content-Type: application/json');
    echo json_encode($returningJSON, JSON_PRETTY_PRINT);
?>