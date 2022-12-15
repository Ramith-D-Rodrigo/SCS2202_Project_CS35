<?php
    session_start();
    require_once("../../src/manager/manager.php");
    require_once("../../src/manager/manager_dbconnection.php");

    
    $sport = $_POST['sport'];
    $courtName = $_POST['courtName'];
    

    
    $addCourt = new Manager();
    $branch = "Colombo";

    // $spor -> getSportID($sport, $connection);
    $sport_id_ = ($addCourt -> getSportID($sport, $connection));
    $branch_id = ($addCourt -> getBranchID( $connection , $branch));
    

    $addCourt -> add_court($connection,$courtName, $sport_id_ ,$branch_id);
    print_r($addCourt);die();

    // $resultmsg = $addCourt -> ($sport, $courtName);

    header("Location: /public/manager/manager_dashboard.php");
    $connection -> close();
?>