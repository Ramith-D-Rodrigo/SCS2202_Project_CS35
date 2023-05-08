<?php
    //this script is used to get the schedule of a particular branch's sport and display it in the reservation schedule page
    session_start();
    require_once("../../src/general/branch.php");
    require_once("../../src/general/dbconnection.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/sport.php");

    require_once("../../src/general/security.php");

    if(!Security::userAuthentication(logInCheck : false, acceptingUserRoles: ['user'])){   //owner because owner can also view the schedule (reusing the same script)
        Security::redirectUserBase();
        die();
    }

    $scheduleBranchID = $_GET['branch'];
    $scheduleSport = $_GET['sport'];

    $branch = new Branch($scheduleBranchID);
    $branch -> getDetails($connection, ['city', 'openingTime', 'closingTime']);

    $sport = new Sport();   
    $sport -> setID($scheduleSport);
    $sports_courts = $branch -> getBranchCourts($connection, $sport, 'a');  //get all the sports court of that branch's sport (request status should be accepted)

    //to get sport details
    $sport -> getDetails($connection, ['sportName', 'reservationPrice']);

    $allCourts = [];


    foreach($sports_courts as $currCourt){ //traverse all the sports courts
        $tempSchedule = $currCourt -> getSchedule($connection); //get the schedule of that particular sport (all the reservations)

        $courtSchedule = [];    //to store each court's reservations
        $courtName = $currCourt -> getName($connection);

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
            $coachingSessionDetails['startDate'] = $currCoachingSession -> startDate;
            $coachingSessionDetails['cancelDate'] = $currCoachingSession -> cancelDate;

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

        $allCourts[$currCourt -> getID()] = ['schedule' => $courtSchedule, 'courtName' => $courtName];  //reservation schedule of the court is stored in the courts array
        unset($tempCourt);
    }

    //branch maintenance
    $branchMaintenance = $branch -> getBranchMaintenance($connection, ['startingDate', 'endingDate'], date("Y-m-d"), 'a');

    //get branch discount
    $branchDiscount = $branch -> getCurrentDiscount($connection);


    $branchJSON = json_encode($branch);
    $neededInfo = json_decode($branchJSON, true);

    $neededInfo['reservingSport'] = $sport;
    $neededInfo['branchReservationSchedule'] = $allCourts;
    $neededInfo['branchMaintenance'] = $branchMaintenance;
    $neededInfo['branchDiscount'] = $branchDiscount;

    unset($allCourts);
    unset($sport);
    unset($branch);

    $connection -> close();
    header('Content-Type: application/json');    //because we are sending json
    echo json_encode($neededInfo, JSON_PRETTY_PRINT);
?>