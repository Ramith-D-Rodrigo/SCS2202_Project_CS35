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

    $profileResults = $receptionist -> getCoachProfiles($connection);

    if(count($profileResults)===0) {    //if the array is empty, then there are no results
        array_push($profileResults,['errMsg' => "Sorry, Can't find any coach profiles"]);
        // $_SESSION['searchErrorMsg'] = $profileResults['errMsg'];
    }

    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($profileResults);
    $connection -> close();
?>