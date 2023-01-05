<?php
    session_start();

    require_once("../../src/general/dbconnection.php");
    require_once("../../src/general/website_functions/reg_coaches_functions.php");
    require_once("../../src/coach/coach.php");

    $coaches = getAllCoaches($connection);
    
    $result = array();

    foreach($coaches as $currCoach){
        $tempCoach = new Coach();
        $tempCoach -> setDetails(uid: $currCoach -> coach_id, sport: $currCoach -> sport);
        $fName = $tempCoach -> getDetails('first_name');
        $lName = $tempCoach -> getDetails('last_name');
        $gender = $tempCoach -> getDetails('gender');
        $photo = $tempCoach -> getDetails('photo');
        $rating = $tempCoach -> getRating();

        $sport = new Sport();
        $sport -> setID($currCoach -> sport);
        $sportName = $sport -> getDetails($connection, 'sportName');

        $result[] = array(
            "coachID" => $currCoach -> coach_id,
            "sport" => $sportName,
            "firstName" => $fName,
            "lastName" => $lName,
            "gender" => $gender,
            "rating" => $rating,
            "photo" => $photo);

        unset($tempCoach);
        unset($sport);
    }

    unset($coaches);
    $connection -> close();

    //echo the result as a json
    header("application/json");
    echo json_encode($result);
?>