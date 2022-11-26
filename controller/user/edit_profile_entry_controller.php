<?php
    session_start();

    require_once("../../src/general/uuid.php");
    require_once("../../src/user/user.php");
    require_once("../../src/user/dbconnection.php");

    $userID = $_SESSION['userid'];

    $user = new User();
    $user -> setDetails(uid: $userID);
    
    $user -> getProfileDetails($connection);

    //$_SESSION['profileInfo'] = ;  //convert user details to json

    echo json_encode($user);

    //header("Location: /public/user/edit_profile.php");
    //$connection -> close();
?>