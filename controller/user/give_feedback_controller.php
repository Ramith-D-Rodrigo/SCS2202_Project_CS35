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
    require_once("../../src/general/reservation.php");
    require_once("../../src/general/branch.php");

    $headerCode = null;

    $userInput = file_get_contents("php://input");
    $userInput = json_decode($userInput, true);
    

    if(!isset($userInput['reservationID']) || !isset($userInput['feedback']) || !isset($userInput['rating'])){    //if the user did not enter all the required fields
        $headerCode = 400;
        http_response_code($headerCode);
        exit();
    }

    if($userInput['feedback'] === '' || $userInput['rating'] === ''){    //if the user did not enter all the required fields
        $headerCode = 400;
        http_response_code($headerCode);
        exit();
    }

    $reservation = new Reservation();
    $reservation -> setID($userInput['reservationID']);
    $user = new User();
    $user -> setUserID($_SESSION['userid']);

    $reservation -> getDetails($user -> getConnection(), ['`status`']);

    $status = json_decode(json_encode($reservation), true)['status'];   //get the status of the reservation

    if($status !== 'Checked In' && $status !== 'Declined'){    //if the reservation is not checked in or declined
        $headerCode = 400;
    }
    else{   //can give feedback
        $branch = $reservation -> getReservedBranch($user -> getConnection());
        $endResult = $user -> giveFeedback($reservation, $branch, $userInput['feedback'], $userInput['rating']);

        if($endResult === true){
            $headerCode = 200;
        }
        else{
            $headerCode = 400;
        }
    }

    http_response_code($headerCode);
    exit();

?>