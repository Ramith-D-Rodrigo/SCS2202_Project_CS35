<?php
    session_start();

    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");

    $staffM = new Staff();
    $receptionist = $staffM -> getStaffMemeber($_SESSION['userrole']);

    $profileResults = $receptionist -> getUserProfiles($connection);

    if(count($profileResults)===0) {    //if the array is empty, then there are no results
        array_push($profileResults,['errMsg' => "Sorry, Can't find any user profiles"]);
        // $_SESSION['searchErrorMsg'] = $profileResults['errMsg'];
    }

    // if(isset($profileResults['errMsg'])){
    // }
    // else{
    //     unset($_SESSION['searchErrorMsg']);
    //     $_SESSION['profileResults'] = $profileResults;
    // }

    // print_r($profileResults);
    // header("Location: /public/receptionist/view_user_profiles.php");
    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($profileResults);
    $connection -> close();
?>