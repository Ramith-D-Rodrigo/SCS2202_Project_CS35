<?php
    session_start();

    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");

    $requestJson = file_get_contents("php://input");
    $reservation = json_decode($requestJson, true);

    // print_r($reservationID['reservationID']);
    $staffM = new Staff();
    $receptionist = $staffM -> getStaffMemeber($_SESSION['userrole']);
    $receptionist -> setDetails(uid: $_SESSION['userid']);
    $decision = $receptionist -> cancelOnsiteReservation($reservation['reservationID'],$connection);

    header('Content-type: application/json');
    echo json_encode($decision);
    die();
    
?>