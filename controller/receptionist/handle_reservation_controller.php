<?php
    session_start();
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");

    $requestJSON =  file_get_contents("php://input");   //get the raw json string
    $decisionDetails = json_decode($requestJSON, true);
    
    $decisionDetails = explode(",",$decisionDetails);  //split the string into the decision and reservationID

    // print_r($decisionDetails);
    $staffM = new Staff();
    $receptionist = $staffM -> getStaffMemeber($_SESSION['userrole']);
    $decision = $receptionist -> handleReservation($decisionDetails[1],$decisionDetails[0],$connection);

    header("Content-Type: application/json");
    echo json_encode($decision);
    exit();
?>