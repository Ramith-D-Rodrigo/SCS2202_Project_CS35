<?php
    require_once("../../src/manager/manager.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/manager/manager_dbconnection.php");

    session_start();
    $managerBranchID = $_SESSION['branchID'];

    $branch = new Branch($managerBranchID);

    $branchSports = $branch -> getAllSports($connection);

    $allCourts = [];
    foreach($branchSports as $currSport){
        $courts = $branch -> getSportCourts($currSport -> sportID, $connection);
        foreach($courts as $currCourt){
            $tempCourt = new Sports_Court($currCourt);
            $status = $tempCourt -> getStatus($connection);
            $tempCourtName = $tempCourt -> getName($connection);
            array_push($allCourts, ['courtID' => $currCourt, 'courtName' => $tempCourtName, 'sport' => $currSport -> sportName, "status" => $status]);
        }
    }
    $_SESSION['branchCourts'] = $allCourts;
    header("Location: /public/manager/sport_court.php");
    $connection -> close();
?>