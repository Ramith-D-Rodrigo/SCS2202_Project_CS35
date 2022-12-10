<?php
    $resultArr = [];
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/website_functions/our_branches_functions.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/manager/manager.php");
    
    $allBranches = getAllBranches($connection); //get all branch IDs (in an array)

    $branchInfo = [];
    
    foreach($allBranches as $branchID){   //travser all the branch IDs

        $tempBranch = new Branch($branchID);    //create new branch object

        $tempBranch -> getDetails($connection);
        $branchSports = $tempBranch -> getAllSports($connection);

        $branchJSON = json_encode($tempBranch); //encode and decode to unset un-necessary info
        $branchASSOC = json_decode($branchJSON, true);
        $branchASSOC['sports'] = $branchSports;
        //manager un-necessary info
        unset($branchASSOC['manager']['branchID']);
        unset($branchASSOC['manager']['dateOfBirth']);
        unset($branchASSOC['manager']['emailAddress']);
        unset($branchASSOC['manager']['joinDate']);
        unset($branchASSOC['manager']['leaveDate']);
        unset($branchASSOC['manager']['managerID']);
        unset($branchASSOC['manager']['username']);
        unset($branchASSOC['manager']['staffRole']);
        unset($branchASSOC['manager']['password']);

        //receptionist un-necessary info
        unset($branchASSOC['receptionist']['branchID']);
        unset($branchASSOC['receptionist']['dateOfBirth']);
        unset($branchASSOC['receptionist']['emailAddress']);
        unset($branchASSOC['receptionist']['joinDate']);
        unset($branchASSOC['receptionist']['leaveDate']);
        unset($branchASSOC['receptionist']['receptionistID']);
        unset($branchASSOC['receptionist']['username']);
        unset($branchASSOC['receptionist']['staffRole']);
        unset($branchASSOC['receptionist']['password']);

        array_push($branchInfo, $branchASSOC);   //push to array;

        unset($tempBranch);
        unset($branchASSOC);
        unset($branchJSON);
    }

    $connection -> close();
    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($branchInfo);
    unset($branchInfo);
?>