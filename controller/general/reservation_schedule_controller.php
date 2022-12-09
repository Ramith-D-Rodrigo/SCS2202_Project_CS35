<?php
    session_start();
    require_once("../../src/general/branch.php");
    require_once("../../src/user/dbconnection.php");
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
    $sports_courts = $branch -> getSportCourts($reservationPlace[1], $connection);  //get all the sports court of that branch's sport

    $sport = new Sport();   //to get sport details
    $sport -> setID($reservationPlace[1]);
    $sport -> getDetails($connection);

    $allCourts = [];


    foreach($sports_courts as $currCourt){ //traverse all the sports courts
        $tempCourt = new Sports_Court($currCourt); 
        $tempSchedule = $tempCourt -> getSchedule($connection); //get the schedule of that particular sport (all the reservations)

        $courtSchedule = [];    //to store each court's reservations
        $courtName = $tempCourt -> getName($connection);

        foreach($tempSchedule as $currReservation){   //create the array for current schedule reservations
            $reservationDetails = [];   //to store current court's each reservation's details
            if($currReservation -> date < date("Y-m-d") || $currReservation -> status === 'Cancelled'){    //no need to check for previous reservations and cancelled ones
                continue;
            }
            $reservationDetails['date'] = $currReservation -> date;
            $reservationDetails['starting_time'] = $currReservation -> starting_time;
            $reservationDetails['ending_time'] = $currReservation -> ending_time;

            $courtSchedule[$currReservation -> reservation_id] =  $reservationDetails;   //reservation details stored in courtschedule
            unset($reservationDetails);
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
    $neededInfo['branch_reservation_schedule'] = $allCourts;

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