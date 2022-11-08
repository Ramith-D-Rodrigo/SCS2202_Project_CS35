<?php
    session_start();
    require_once("../../src/general/branch.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/sport_court.php");

    $reservationPlace = explode(',',$_POST['reserveBtn']);  //split the branch and sport id branch id -> 0th index, sport id -> 1st index, branch location -> 2nd index, sport name -> 3rd index

    $branch = new Branch($reservationPlace[0]);

    $sports_courts = $branch -> getSportCourts($reservationPlace[1], $connection);  //get all the sports court of that branch's sport

    $allCourts = [];

    while($courtResult = $sports_courts -> fetch_object()){ //traverse all the sports courts
        $tempCourt = new Sports_Court($courtResult -> court_id);
        $tempSchedule = $tempCourt -> getSchedule($connection); //get the schedule of that particular sport (all the reservations)

        $courtSchedule = [];    //to store each court's reservations

        while($scheduleResult = $tempSchedule -> fetch_object()){   //create the array for current schedule reservations
            $reservationDetails = [];   //to store current court's each reservation's details
            if($scheduleResult -> date > date("Y-m-d")){    //no need to check for previous reservations
                continue;
            }
            $reservationDetails['date'] = $scheduleResult -> date;
            $reservationDetails['starting_time'] = $scheduleResult -> starting_time;
            $reservationDetails['ending_time'] = $scheduleResult -> ending_time;

            $courtSchedule[$scheduleResult -> reservation_id] =  $reservationDetails;   //reservation details stored in courtschedule
        }
        $allCourts[$courtResult -> court_id] = ['schedule' => $courtSchedule, 'courtName' => $courtResult -> court_name];  //reservation schedule of the court is sotred in the courts array
    }
    print_r($allCourts);

    $_SESSION['reservingBranch'] = $reservationPlace[2];    //reserving branch
    $_SESSION['reservingSport'] = $reservationPlace[3]; //reserving sport
    $_SESSION['branch_reservation_schedule'] = $allCourts;

    header("Location: /public/general/reservation_schedule.php");
    $connection -> close();

?>