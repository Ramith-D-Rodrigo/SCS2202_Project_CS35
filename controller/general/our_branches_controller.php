<?php
    $resultArr = [];
    require_once("../../src/general/dbconnection.php");
    require_once("../../src/general/website_functions/our_branches_functions.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/manager/manager.php");
    require_once("../../src/receptionist/receptionist.php");
    
    $allBranches = getAllBranches($connection); //get all branch IDs (in an array)

    $branchInfo = [];
    
    foreach($allBranches as $branchID){   //travser all the branch IDs

        $tempBranch = new Branch($branchID);    //create new branch object

        $tempBranch -> getDetails($connection, ['address', 'city', 'branchEmail', 'openingTime', 'closingTime', 'currManager', 'currReceptionist']);
        $branchSports = $tempBranch -> offeringSports($connection);

        //traverse the sports array and get the sport name
        foreach($branchSports as $currSport){
            $currSport -> getDetails($connection, ['sportName']);
        }
        $branchRating = $tempBranch -> getBranchRating($connection);

        $branchJSON = json_encode($tempBranch); //encode and decode to unset un-necessary info
        $branchASSOC = json_decode($branchJSON, true);

        //get branch pictures
        $branchASSOC['photos'] = $tempBranch -> getBranchPictures($connection);


        $branchManager = new Manager(); //to get manager details
        $branchManager -> setUserID($branchASSOC['currManager']);

        $branchManager -> getDetails(['firstName', 'lastName', 'contactNum', 'gender']);

        $branchReceptionist = new Receptionist(); //to get receptionist details
        $branchReceptionist -> setUserID($branchASSOC['currReceptionist']);

        $branchReceptionist -> getDetails(['firstName', 'lastName', 'contactNum', 'gender']);

        $branchASSOC['sports'] = $branchSports;
        $branchASSOC['rating'] = $branchRating;
        $branchASSOC['manager'] = $branchManager;
        $branchASSOC['receptionist'] = $branchReceptionist;


        array_push($branchInfo, $branchASSOC);   //push to array;

        unset($tempBranch);
        unset($branchASSOC);
        unset($branchJSON);
    }

    $connection -> close();
    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($branchInfo, JSON_PRETTY_PRINT);
    unset($branchInfo);
?>