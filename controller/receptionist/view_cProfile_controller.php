<?php
    session_start();

    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");

    $coachID = $_GET['coachID'];

    $staffM = new Staff();
    $receptionist = $staffM -> getStaffMemeber($_SESSION['userrole']);

    $coachProfile = $receptionist -> getWantedCoachProfile($coachID,$connection);

    if(count($coachProfile)===0){
        array_push($userProfile,['errMsg'=>"Sorry, No record of such user"]);
    }

    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($coachProfile);
    $connection -> close();
?>