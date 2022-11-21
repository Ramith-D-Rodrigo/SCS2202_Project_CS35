<?php
    session_start();
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/uuid.php");

    $branch = new Branch(uuid_to_bin($_SESSION['branchid'],$connection));

    $spNames = $branch -> getAllSports($_SESSION['userid'],$connection);
   
    if(count($spNames)=== 0) {
        array_push($spNames,['errMsg' => "Sorry, Cannot find what you are looking For"]);
    }

    if(isset($spNames['errMsg'])){   //no sport was found
        $_SESSION['searchErrorMsg'] = $spNames['errMsg'];
    }
    else{
        unset($_SESSION['searchErrorMsg']);
        $_SESSION['sportResult'] = $spNames;
    }
    //print_r($_SESSION['searchResult']);

    $courtNames = $branch -> getAllCourts($connection);

    if(count($courtNames)=== 0) {
        array_push($courtNames,['errMsg' => "Sorry, Cannot find what you are looking For"]);
    }

    if(isset($courtNames['errMsg'])){   //no court was found
        $_SESSION['searchErrorMsg'] = $courtNames['errMsg'];
    }
    else{
        unset($_SESSION['searchErrorMsg']);
        $_SESSION['courtResult'] = $courtNames;
    }
    header("Location: /public/receptionist/request_maintenance.php");
    $connection -> close();

?>