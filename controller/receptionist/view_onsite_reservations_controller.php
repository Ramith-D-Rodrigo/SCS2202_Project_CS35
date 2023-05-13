<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
        Security::redirectUserBase();
        die();
    }
    
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");

    $staffM = new Staff();
    $receptionist = $staffM -> getStaffMember($_SESSION['userrole']);
    $receptionist -> setDetails(uid: $_SESSION['userid']);
    $onsiteReservationInfo = $receptionist -> getOnsiteReservations($connection);

    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($onsiteReservationInfo);
    $connection -> close();
    
    ?>