<?php
    session_start();

    require_once("../../src/general/dbconnection.php");
    require_once("../../src/general/website_functions/reg_coaches_functions.php");
    require_once("../../src/coach/coach.php");

    $coaches = getAllCoaches($connection);
    
    foreach($coaches as $currCoach){
        $tempCoach = new Coach();
        $tempCoach -> setDetails(uid: $currCoach -> coach_id, sport: $currCoach -> sport);
        $tempCoach -> getDetails(['first_name', 'last_name', 'email_address', 'phone_number', 'profile_picture']);
    }



?>