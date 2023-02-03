<?php
    session_start();
    require_once("../../src/general/branch.php");
    require_once("../../src/general/dbconnection.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/sport.php");

/*     if($_SERVER['REQUEST_METHOD'] === 'POST'){  //we are coming from a post request
        $reservationPlace = $_SESSION[$_POST['reserveBtn']];    //get the array
        $_SESSION['reservationPlace'] = $reservationPlace;  //assign the array to session
    }
    else{
        $reservationPlace = $_SESSION['reservationPlace'];
    } */

    $reservationPlace = explode(",",$_GET['reserveBtn']);

    //branch id -> 0th index, sport id -> 1st index

    $branch = new Branch($reservationPlace[0]);
    $branch -> getDetails($connection);
    $sports_courts = $branch -> getSportCourts($reservationPlace[1], $connection, 'a');  //get all the sports court of that branch's sport (request status should be accepted)

    $sport = new Sport();   //to get sport details
    $sport -> setID($reservationPlace[1]);
    $sport -> getDetails($connection);

    $allCourts = [];


    foreach($sports_courts as $currCourt){ //traverse all the sports courts
        $tempCourt = new Sports_Court($currCourt); 
        $tempSchedule = $tempCourt -> getSchedule($connection); //get the schedule of that particular sport (all the reservations)

        $courtSchedule = [];    //to store each court's reservations
        $courtName = $tempCourt -> getName($connection);

        //user reservations
        $i = 0;
        foreach($tempSchedule['reservations'] as $currReservation){   //create the array for current schedule reservations
            $reservationDetails = [];   //to store current court's each reservation's details
            if($currReservation -> date < date("Y-m-d") || $currReservation -> status !== 'Pending'){    //no need to check for previous reservations , and get only pending reservations
                continue;
            }
            //get only the needed information
            $reservationDetails['date'] = $currReservation -> date;
            $reservationDetails['startingTime'] = $currReservation -> startingTime;
            $reservationDetails['endingTime'] = $currReservation -> endingTime;

            $courtSchedule['reservations'][$i] =  $reservationDetails;   //reservation details stored in courtschedule
            $i++;
            unset($reservationDetails);
            unset($currReservation);
        }

        //coaching sessions
        $i = 0;
        foreach($tempSchedule['coachingSessions'] as $currCoachingSession){ //create the array for current schedule coaching sessions
            $coachingSessionDetails = [];   //to store current court's each coaching session's details
            //get only the needed information
            $coachingSessionDetails['day'] = $currCoachingSession -> day;
            $coachingSessionDetails['startingTime'] = $currCoachingSession -> startingTime;
            $coachingSessionDetails['endingTime'] = $currCoachingSession -> endingTime;
            $coachingSessionDetails['timePeriod'] = $currCoachingSession -> timePeriod;

            $courtSchedule['coachingSessions'][$i] =  $coachingSessionDetails;   //coaching session details stored in courtschedule
            $i++;
            unset($coachingSessionDetails);
            unset($currCoachingSession);

        }

        //court maintenace
        $i = 0;
        foreach($tempSchedule['maintenance'] as $currCourtMaintenance){ //create the array for current schedule court maintenance
            $courtMaintenanceDetails = [];   //to store current court's each court maintenance's details
            //get only the needed information
            $courtMaintenanceDetails['startingDate'] = $currCourtMaintenance -> startingDate;
            $courtMaintenanceDetails['endingDate'] = $currCourtMaintenance -> endingDate;

            $courtSchedule['courtMaintenance'][$i] =  $courtMaintenanceDetails;   //court maintenance details stored in courtschedule
            $i++;
            unset($courtMaintenanceDetails);
            unset($currCourtMaintenance);
        }

        $allCourts[$currCourt] = ['schedule' => $courtSchedule, 'courtName' => $courtName];  //reservation schedule of the court is stored in the courts array
        unset($tempCourt);
    }
    //print_r($allCourts);

    $branchJSON = json_encode($branch);
    $neededInfo = json_decode($branchJSON, true);
    unset($neededInfo['manager']);
    unset($neededInfo['email']);
    unset($neededInfo['address']);
    unset($neededInfo['photos']);
    unset($neededInfo['receptionist']);
    $neededInfo['reservingSport'] = $sport;
    $neededInfo['branchReservationSchedule'] = $allCourts;

    unset($allCourts);
    unset($sport);
    unset($branch);

    $connection -> close();
    header('Content-Type: application/json');    //because we are sending json
    echo json_encode($neededInfo);
    //sending opening and closing times as a json response to be received by Javascript
/*     $arr = ["openingTime" => $reservationPlace[4], "closingTime" => $reservationPlace[5]];
    echo json_encode($arr); */
    //header("Location: /public/general/reservation_schedule.php");
?>