<?php
    session_start();

    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");

    $userID = $_GET['userID'];

    $staffM = new Staff();
    $receptionist = $staffM -> getStaffMemeber($_SESSION['userrole']);

    $userProfile = $receptionist -> getWantedUserProfile($userID,$connection);

    if(count($userProfile)===0){
        array_push($userProfile,['errMsg'=>"Sorry, No record of such user"]);
    }

    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($userProfile);
    $connection -> close();
?>