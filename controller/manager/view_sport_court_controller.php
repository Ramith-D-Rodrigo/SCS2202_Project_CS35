<?php
    require_once("../../src/manager/manager.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/manager/manager_dbconnection.php");

    session_start();
    $managerBranchID = $_SESSION['branchID'];

    $branch = new Branch($managerBranchID);

    $branchCourts = $branch -> getBranchCourts($connection);

    $allCourts = [];
    foreach($branchCourts as $currCourt){
        $courtID = $currCourt -> getID();
        $courtStatus = $currCourt -> getStatus($connection);
        $courtName = $currCourt -> getName($connection);
        $currSport = $currCourt -> getSport($connection);
        $currSport -> getDetails($connection, ['sportName']);
        $sportName = json_decode(json_encode($currSport), true)['sportName'];
        array_push($allCourts, ['courtID' => $courtID, 'courtName' => $courtName, 'sport' => $sportName, "status" => $courtStatus]);
        
    }
    $_SESSION['branchCourts'] = $allCourts;
    header("Location: /public/manager/sport_court.php");
    $connection -> close();
?>