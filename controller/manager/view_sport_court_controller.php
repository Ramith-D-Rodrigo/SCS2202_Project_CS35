<?php
    require_once("../../src/manager/manager.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/sport_court.php");


    session_start();
    $manager = new Manager();
    // $managerBranchID = $_SESSION['branchID'];

    $managerbranch = new Branch($_SESSION['branchID']);

    $branchCourts = $managerbranch -> getBranchCourts($manager -> getConnection(), null, 'a');
    
    $allCourts = [];
    foreach($branchCourts as $currCourt){
        // $courtID = $currCourt -> getID();
        $courtName = $currCourt -> getName($manager -> getConnection());
        $currSport = $currCourt -> getSport($manager -> getConnection());
        $currphoto = $currCourt -> getPhotos($manager -> getConnection());
        $currSport -> getDetails($manager -> getConnection(), ['sportName']);
        $sportName = json_decode(json_encode($currSport), true)['sportName'];
        array_push($allCourts, ['courtID' => $courtID, 'courtName' => $courtName, 'sport' => $sportName,'photo' =>$currPhoto, "status" => $courtStatus]);
    }
    $_SESSION['branchCourts'] = $allCourts;
    header("Location: /public/manager/sport_court.php");
    
?>