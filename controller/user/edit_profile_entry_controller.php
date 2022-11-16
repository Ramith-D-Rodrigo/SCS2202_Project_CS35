<?php
    session_start();

    require_once("../../src/general/uuid.php");
    require_once("../../src/user/user.php");
    require_once("../../src/user/dbconnection.php");

    $userID = $_SESSION['userid'];

    $user = new User();
    $user -> setDetails(uid: $userID);
    
    $user -> getProfileDetails($connection);

    print_r(json_encode($user));  //convert user details to json

    //header("Location: /public/user/edit_profile.php");
    $connection -> close();
?>