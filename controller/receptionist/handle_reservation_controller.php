<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
        Security::redirectUserBase();
        die();
    }
    
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");
    require_once("../../src/general/reservation.php");

    $requestJSON =  file_get_contents("php://input");   //get the raw json string
    $decisionDetails = json_decode($requestJSON, true);
    
    $decisionDetails = explode(",",$decisionDetails);  //split the string into the decision and reservationID

    // print_r($decisionDetails);
    $staffM = new Staff();
    $receptionist = $staffM -> getStaffMember($_SESSION['userrole']);
    $decision = $receptionist -> handleReservation($decisionDetails[1],$decisionDetails[0],$connection);

    //sending a notification about the reservation status
    $reservation = new Reservation();
    $reservation -> setID($decisionDetails[1]);
    $userID = json_decode(json_encode($reservation -> getDetails($connection,['userID'])),true)['userID'];   //get the userID if the reservation made by a user

   
    if($userID !== ''){   //if this is a user reservation
        $resInfo = $reservation -> getDetails($connection,['date','startingTime','endingTime']);
        $resJSON = json_decode(json_encode($resInfo),true);
        $date = $resJSON['date'];
        $startingTime = $resJSON['startingTime'];
        $endingTime = $resJSON['endingTime'];

        if($decisionDetails[0] === "Checked In"){
            $desc = "You have checked in for the time slot of ".$startingTime. "-" .$endingTime. "of" .$date;
        }else{
            $desc = "You haven't checked in for the time slot of ".$startingTime. "-" .$endingTime. "of" .$date;
        }

        $notificationID = uniqid("notreserv");
        $receptionist -> addNotification($notificationID,"Reservation Status",$desc,date('Y-m-d'),$userID);
    }
    
    
    header("Content-Type: application/json");
    echo json_encode($decision);
    exit();
?>