<?php
    //this script is used to get the profile details of the user
    session_start();

    require_once("../../src/user/user.php");
    require_once("../../src/general/security.php");

    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){
        Security::redirectUserBase();
        die();
    }

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