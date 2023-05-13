<?php
    //this script is used to get the schedule of a branch's sport (depends on the start date) and display it in the schedule page of the owner
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/owner/owner.php");

    $owner = Owner::getInstance();
    $owner -> setUserID($_SESSION['userid']);

    require_once("../../src/general/branch.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/sport.php");

    $scheduleBranchID = $_GET['branch'];
    $scheduleSport = $_GET['sport'];
    $startDate = $_GET['startDate'];
    $branch = new Branch($scheduleBranchID);
    $branch -> getDetails($owner -> getConnection(), ['openingTime', 'closingTime']);

    $sport = new Sport();   
    $sport -> setID($scheduleSport);
    $sports_courts = $branch -> getBranchCourts($owner -> getConnection(), $sport, 'a');  //get all the sports court of that branch's sport (request status should be accepted)

    $allCourts = [];

    foreach($sports_courts as $currCourt){ //traverse all the sports courts
        $tempSchedule = $currCourt -> getSchedule($owner -> getConnection(), $startDate); //get the schedule of that particular sport (all the reservations)

        $courtSchedule = [];    //to store each court's reservations
        $courtName = $currCourt -> getName($owner -> getConnection());

        //user reservations
        $i = 0;
        foreach($tempSchedule['reservations'] as $currReservation){   //create the array for current schedule reservations
            $reservationDetails = [];   //to store current court's each reservation's details
            if($currReservation -> status === 'Cancelled' || $currReservation -> status === 'Refunded'){    // no need to check for cancelled or refunded reservations
                continue;
            }
            //get only the needed information
            $reservationDetails['date'] = $currReservation -> date;
            $reservationDetails['startingTime'] = $currReservation -> startingTime;
            $reservationDetails['endingTime'] = $currReservation -> endingTime;
            $reservationDetails['reservationID'] = $currReservation -> reservationID;

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
            $coachingSessionDetails['sessionID'] = $currCoachingSession -> sessionID;

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
    $branchMaintenance = $branch -> getBranchMaintenance($owner -> getConnection(), ['startingDate', 'endingDate'], $startDate, 'a');

    $branchJSON = json_encode($branch);
    $neededInfo = json_decode($branchJSON, true);
    $neededInfo['branchReservationSchedule'] = $allCourts;
    $neededInfo['branchMaintenance'] = $branchMaintenance;

    unset($allCourts);
    unset($sport);
    unset($branch);

    header('Content-Type: application/json');    //because we are sending json
    echo json_encode($neededInfo, JSON_PRETTY_PRINT);
?>