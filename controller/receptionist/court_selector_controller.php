<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
        Security::redirectUserBase();
        die();
    }
    
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/system_admin/staff.php");

    $staffMember = new Staff();
    $receptionist = $staffMember -> getStaffMember($_SESSION['userrole']);  
    $sportID = htmlspecialchars($_GET['sportID']);  
    $courtNames = $receptionist -> getAvailableCourts($_SESSION['branchID'],$sportID,$connection);  // get the courts of the particular branch

    if(count($courtNames)=== 0) {
        array_push($courtNames,['errMsg' => "Sorry, Cannot find what you are looking For"]);
    }

    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($courtNames);
    $connection -> close();  //close the connection
?>