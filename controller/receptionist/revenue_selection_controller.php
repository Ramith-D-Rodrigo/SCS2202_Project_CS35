<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/sport.php");
    require_once("../../src/system_admin/staff.php");

    $staffMember  = new Staff();
    $receptionist = $staffMember -> getStaffMemeber($_SESSION['userrole']);

    $branch = new Branch($_SESSION['branchID']);

    $branchSports = $branch -> offeringSports($receptionist -> getConnection());

    foreach($branchSports as $currSport){
        $currSport -> getDetails($receptionist -> getConnection(), ['sportName']);
    }

    header("Content-Type: application/json;");
    echo json_encode($branchSports);
    die();
?>