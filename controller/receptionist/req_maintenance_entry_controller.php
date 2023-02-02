<?php
    session_start();
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/system_admin/staff.php");

    $staffMember = new Staff();
    $receptionist = $staffMember -> getStaffMemeber($_SESSION['userrole']);

    $spNames = $receptionist -> getAllSports($_SESSION['branchid'],$connection); // get the sports of the particular branch
   
    if(count($spNames)=== 0) {
        array_push($spNames,['errMsg' => "Sorry, Cannot find what you are looking For"]);
    }

    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($spNames);
    $connection -> close();

?>