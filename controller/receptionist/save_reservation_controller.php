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
    require_once("../../src/general/sport_court.php");

    $requestJSON =  file_get_contents("php://input");   //get the raw json string
    $reservationDetails = json_decode($requestJSON, true);
    // print_r($reservationDetails);
    $courtID = $reservationDetails['makeReserveBtn'];   //get the details of the reservation to store
    $name = htmlspecialchars($reservationDetails['name'], ENT_QUOTES);
    $contactNumber = htmlspecialchars($reservationDetails['contactNumber'], ENT_QUOTES);
    $numOfPeople = htmlspecialchars($reservationDetails['numOfPeople'], ENT_QUOTES);
    $startingTime = $reservationDetails['reservingStartTime'];
    $endingTime = $reservationDetails['reservingEndTime'];
    $reservationFee = $reservationDetails['reservationFee'];
    $date = $reservationDetails['reservingDate'];
    $recepID = $reservationDetails['receptionistID'];
    $resID = $reservationDetails['reservationID'];

    $staffMember = new Staff();
    $receptionist = $staffMember -> getStaffMember('receptionist');   
    $receptionist -> setDetails(uid : $recepID);
    $court = new Sports_Court($courtID);
    $result = $receptionist -> makeReservation($resID, $date, $startingTime, $endingTime, $numOfPeople, $reservationFee, $court, $name, $contactNumber, $connection);
    // print_r($result);

    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($result);
    $connection -> close();

?>