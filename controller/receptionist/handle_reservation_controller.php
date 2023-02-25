<?php
    session_start();
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");

    
    $reservationID = htmlspecialchars($_POST['reservationID']);
    $decision = htmlspecialchars($_POST['btnVal']);

    $staffM = new Staff();
    $receptionist = $staffM -> getStaffMemeber($_SESSION['userrole']);
    $decision = $receptionist -> handleReservation($reservationID,$decision,$connection);

    if($decision){
        header("Location: /public/receptionist/view_reservations.php");
        $connection -> close();
        exit();
    }