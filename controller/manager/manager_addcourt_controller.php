<?php
    session_start();
    require_once("../../src/manager/manager.php");
    require_once("../../src/general/sport.php");
    require_once("../../src/manager/manager_dbconnection.php");
    require_once("../../src/general/branch.php");

    
    $sport = $_POST['sport'];
    $courtName = $_POST['courtName'];
    

    
    $sport_obj = new Sport();
    $manager_obj = new Manager();
    $branch_obj = new Branch($_SESSION['branchID']);
    $manager_obj -> setDetails(uid: $_SESSION['userid']);

    $sport_id = $sport_obj -> getSportID($sport, $connection) -> fetch_object() -> sport_id;
    $sport_obj -> setID($sport_id);

    $courtID = uniqid(substr($sport, 0, 3)."court");

    
    $result = $manager_obj -> add_court($connection, $courtName, $sport_id, $_SESSION['branchID'], $courtID, $_SESSION['userid']);
    
    if($result === TRUE){
        $resultmsg = "Request sent to the owner Successfully";
    }
    else{
        $resultmsg = "Error Sending the request";
    }

    $_SESSION['resultMsg'] = $resultmsg;
    // $resultmsg = $addCourt -> ($sport, $courtName);

    header("Location: /public/manager/manager_add_court.php");
    $connection -> close();
?>