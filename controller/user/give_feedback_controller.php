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

    $userInput = file_get_contents("php://input");
    $userInput = json_decode($userInput, true);

    $reservation = new Reservation();
    $reservation -> setID($userInput['reservationID']);

    $user = new User();
    $user -> setUserID($_SESSION['userid']);

    $branchID = $reservation -> getReservedBranch($user -> getConnection());

    $branch = new Branch($branchID);

    $user -> giveFeedback($reservation, $branch, $userInput['feedback'], $userInput['rating'], $user -> getConnection());


?>