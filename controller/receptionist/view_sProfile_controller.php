<?php
    session_start();

    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");

    $index = $_POST['viewBtn'];
    $user = $_SESSION['profileResults'][$index];

    $staffM = new Staff();
    $receptionist = $staffM -> getStaffMemeber($_SESSION['userrole']);

    $userProfile = $receptionist -> getWantedUserProfile($user['fName'],$user['lName'],$user['contactN'],$connection);
    // print_r($results);
    // print_r($_SESSION['profileResults'][$index]);
    if(count($userProfile)===0){
        array_push($userProfile,['errMsg'=>"Sorry, No record of such user"]);
    }

    if(isset($userProfile['errMsg'])){
        $_SESSION['searchErrorMsg'] = $userProfile['errMsg'];
    }else{
        unset($_SESSION['searchErrorMsg']);
        $_SESSION['userProfile'] = $userProfile;
    }

    // print_r($_SESSION['userProfile']);
    // $row = $_SESSION['userProfile'][2][0];
    // print_r($row['contact_num']);
    header("Location: /public/receptionist/user_profile.php");
    $connection -> close();
?>