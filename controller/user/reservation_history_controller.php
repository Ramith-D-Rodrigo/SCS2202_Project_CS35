<?php
    //this script is used to get the reservation history of the user
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/user/user.php");
    
    $user = new User();
    $user -> setDetails(uid: $_SESSION['userid']);
    $reservationHistory = $user -> getReservationHistory();
    

    unset($user);
    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($reservationHistory);
?>