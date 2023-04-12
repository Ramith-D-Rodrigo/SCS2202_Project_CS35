<?php
    session_start();

    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");

    $reservationID = $_GET['reservationID'];
    $staffM = new Staff();
    $receptionist = $staffM -> getStaffMemeber($_SESSION['userrole']);
    $receptionist -> setDetails(uid: $_SESSION['userid']);
    $onsiteReservationInfo = $receptionist -> cancelOnsiteReservation($reservationID,$connection);

    header("Location: /public/receptionist/cancel_onsite_reservations.php");
    $connection -> close();
    
?>