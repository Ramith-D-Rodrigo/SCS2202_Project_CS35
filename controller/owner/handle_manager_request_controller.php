<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/owner/owner.php");

    $requestJSON =  file_get_contents("php://input");   //get the raw json string
    $decisionDetails = json_decode($requestJSON, true);
    // print_r($decisionDetails);
    $owner  = Owner::getInstance();

    if(count($decisionDetails) == 2){
        $result = $owner -> updateManagerRequest(courtID: $decisionDetails['courtID'],decision: $decisionDetails['decision']);
    }else{
        $result = $owner -> updateManagerRequest(manager: $decisionDetails['manager'],startingDate: $decisionDetails['startingDate'],decision: $decisionDetails['decision']);
    }
    
    header('Content-Type: application/json');
    echo json_encode($result);
    die();


?>