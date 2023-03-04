<?php
    session_start();
    require_once("../../src/general/security.php");
    require_once("../CONSTANTS.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    //server request method
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if($requestMethod != 'POST'){
        http_response_code(400);
        die();
    }

    //check for authorization
    if($_SESSION['userAuth'] != true){
        http_response_code(401);
        die();
    }

    require_once("../../src/owner/owner.php");
    require_once("../../src/general/sport.php");

    $owner  = Owner::getInstance();

    $userInputs = json_decode(file_get_contents("php://input"), true);

    $sportID = $userInputs['sportID'];

    $changingSport = new Sport();
    $changingSport -> setID($sportID);

    $changingColumns = array();

    //check for changing values
    if(isset($userInputs['newDescription'])){
       $changingColumns['description'] = $userInputs['newDescription'];
    }

    if(isset($userInputs['newPrice'])){
        $changingColumns['reservationPrice'] = $userInputs['newPrice'];

        //calculate the new min coaching session price 
        $changingColumns['minCoachingSessionPrice'] = $userInputs['newPrice'] * MIN_COACHING_SESSION_PERCENTAGE + $userInputs['newPrice'];
    }

    if(isset($userInputs['newMaxPlayers'])){
        $changingColumns['maxNoOfStudents'] = $userInputs['newMaxPlayers'];
    }


    $status = $owner -> updateSportDetails($changingSport, $changingColumns);

    $retunMsg = array();
    if($status){
        http_response_code(200);
        $retunMsg['msg'] = "Details updated successfully";
    }
    else{
        http_response_code(500);
        $retunMsg['msg'] = "Failed to update details";
    }

    header("Content-Type: application/json");
    echo json_encode($retunMsg);
    
?>