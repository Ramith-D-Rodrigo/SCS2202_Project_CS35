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

    $courtObjects = $receptionist -> getAllSports($_SESSION['branchID'],$connection); // get the sports of the particular branch
   
    if(count($courtObjects)=== 0) {
        array_push($courtObjects,['errMsg' => "Sorry, Cannot find what you are looking For"]);
    }

    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($courtObjects);
    $connection -> close();

?>