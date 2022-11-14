<?php
    session_start();
    require_once("../../src/general/branch.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/uuid.php");

    if($_SERVER['REQUEST_METHOD'] === 'POST'){  //we are coming from a post request
        $reservationPlace = $_SESSION[$_POST['reserveBtn']];    //get the array
        $_SESSION['reservationPlace'] = $reservationPlace;  //assign the array to session
    }
    else{
        $reservationPlace = $_SESSION['reservationPlace'];
    }

    //branch id -> 0th index, sport id -> 1st index, branch location -> 2nd index, sport name -> 3rd index, opening time -> 4th index, closing time -> 5th index, reservation price -> 6th index

    $branch = new Branch(uuid_to_bin($reservationPlace[0], $connection));

    $sports_courts = $branch -> getSportCourts(uuid_to_bin($reservationPlace[1], $connection), $connection);  //get all the sports court of that branch's sport

    $allCourts = [];


    while($courtResult = $sports_courts -> fetch_object()){ //traverse all the sports courts
        $tempCourt = new Sports_Court($courtResult -> court_id);    //no need to convert to bin as we already received uuid in binary format
        $tempSchedule = $tempCourt -> getSchedule($connection); //get the schedule of that particular sport (all the reservations)

        $courtSchedule = [];    //to store each court's reservations
        $courtName = $tempCourt -> getName($connection);

        while($scheduleResult = $tempSchedule -> fetch_object()){   //create the array for current schedule reservations
            $reservationDetails = [];   //to store current court's each reservation's details
            if($scheduleResult -> date < date("Y-m-d") || $scheduleResult -> status === 'Cancelled'){    //no need to check for previous reservations and cancelled ones
                continue;
            }
            $reservationDetails['date'] = $scheduleResult -> date;
            $reservationDetails['starting_time'] = $scheduleResult -> starting_time;
            $reservationDetails['ending_time'] = $scheduleResult -> ending_time;

            $courtSchedule[$scheduleResult -> reservation_id] =  $reservationDetails;   //reservation details stored in courtschedule
        }
        $allCourts[bin_to_uuid($courtResult -> court_id, $connection)] = ['schedule' => $courtSchedule, 'courtName' => $courtName];  //reservation schedule of the court is sotred in the courts array
        unset($tempCourt);
    }
    print_r($allCourts);

    $_SESSION['reservingBranch'] = $reservationPlace[2];    //reserving branch
    $_SESSION['reservingSport'] = $reservationPlace[3]; //reserving sport
    $_SESSION['opening_time'] = $reservationPlace[4];
    $_SESSION['closing_time'] = $reservationPlace[5];
    $_SESSION['reserve_price'] = $reservationPlace[6]; 
    $_SESSION['branch_reservation_schedule'] = $allCourts;

    header("Location: /public/general/reservation_schedule.php");
    $connection -> close();

?>