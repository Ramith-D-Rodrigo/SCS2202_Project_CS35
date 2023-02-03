<?php
    session_start();

    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");

    $staffM = new Staff();
    $receptionist = $staffM -> getStaffMemeber($_SESSION['userrole']);
    $reservationInfo = $receptionist -> viewReservations($_SESSION['branchID'],$connection);

    if(count($reservationInfo)=== 0){
        array_push($reservationInfo, ['errMsg' => "No reservations found for today"]);
    }

    header('Content-type: application/json');
    echo json_encode($reservationInfo);
    $connection -> close();
    
    ?>