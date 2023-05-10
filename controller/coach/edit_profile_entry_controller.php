<?php
    session_start();

    require_once("../../src/general/uuid.php");
    require_once("../../src/coach/coach.php");
    require_once("../../src/coach/dbconnection.php");

    $userID = $_SESSION['userid'];

    $user = new User();
    $user -> setDetails(uid: $userID);
    
    $user -> getProfileDetails();

    //$_SESSION['profileInfo'] = ;  //convert user details to json

    header('Content-Type: application/json');    //because we are sending json
    echo json_encode($user);

    //header("Location: /public/user/edit_profile.php");
    //$connection -> close();
?>