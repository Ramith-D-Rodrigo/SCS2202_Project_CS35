<?php
    session_start();
    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is not logged in
        header("Location: /index.php");
        exit();
    }

    if($_SESSION['userrole'] !== 'user'){   //not an user (might be another actor)
        header("Location: /index.php");
        exit();
    }
    require_once("../../src/user/user.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/uuid.php");
    
    $user = new User();
    $user -> setDetails(uid: $_SESSION['userid']);
    $reservationHistory = $user -> getReservationHistory($connection);
    
    $reservations = [];

    if(isset($_SESSION['reservationHistory'])){ //previous reservation history clear
        unset($_SESSION['reservationHistory']);
    }

    if($reservationHistory -> num_rows !== 0){  //has reservations
        while($row = $reservationHistory -> fetch_object()){    //travserse each reservation
            $row -> reservation_id = bin_to_uuid($row -> reservation_id, $connection);  //convert the uuid

            $startingTime = $row -> starting_time;
            $endingTime = $row -> ending_time;

            $row -> {"time_period"} = $startingTime . " to " . $endingTime;

            array_push($reservations, $row);
        }
        $_SESSION['reservationHistory'] = $reservations;
    }

    unset($user);
    header("Location: /public/user/reservation_history.php");    
    $connection -> close();

?>