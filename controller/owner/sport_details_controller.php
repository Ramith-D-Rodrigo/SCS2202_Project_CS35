<?php
    //this script is used to get the details of all the sports that the complex is offering to display in the sport details page
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/owner/owner.php");

    $owner  = Owner::getInstance();

    $sports = $owner -> getSports();

    foreach($sports as $currSport){
        $currSport -> getDetails($owner -> getConnection(), ['sportName', 'description', 'reservationPrice', 'MaxNoOfStudents', 'minCoachingSessionPrice']);

    }

    header("Content-Type: application/json;");
    echo json_encode($sports, JSON_PRETTY_PRINT);
?>
