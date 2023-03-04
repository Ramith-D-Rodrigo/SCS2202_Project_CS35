<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/owner/owner.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/sport_court.php");

    $owner  = Owner::getInstance();

    $branches = $owner -> getBranches();

    $returnJSON = [];



    foreach($branches as $currBranch){
        $currBranch -> getDetails($owner -> getConnection(), ['address', 'branchEmail', 'city', 'openingTime', 'closingTime', 'revenue', 'openingDate', 'latitude', 'longitude']);  //get branch details

        $branchManager = $currBranch -> getCurrentManager($owner -> getConnection());  //branch manager
        $branchReceptionist = $currBranch -> getCurrentReceptionist($owner -> getConnection());    //branch receptionist

        $branchManager -> getDetails(['firstName', 'lastName', 'contactNum', 'gender']);
        $branchReceptionist -> getDetails(['firstName', 'lastName', 'contactNum', 'gender']);

        $currBranch -> getBranchPictures($owner -> getConnection());    //get branch photos

        $branchCourts = $currBranch -> getBranchCourts($owner -> getConnection());  //get branch courts

        $sportIDs = [];
        $sports = [];

        foreach($branchCourts as $currCourt){
            $sport = $currCourt -> getSport($owner -> getConnection()); //get the sport of that court
            $sport -> getDetails($owner -> getConnection(), ['sportName']); //get the sport name

            if(!in_array($sport -> getID(), $sportIDs)){
                $sports[] = $sport -> getDetails($owner -> getConnection(), ['sportName']); //get the sport name and store it in the array
                $sportIDs[] = $sport -> getID();
            }

        }

        $returnJSON[] = ["branchDetails" => $currBranch, "branchManager" => $branchManager, "branchReceptionist" => $branchReceptionist, "branchCourts" => $branchCourts, "sports" => $sports];
    }

    header("Content-Type: application/json;");
    echo json_encode($returnJSON, JSON_PRETTY_PRINT);
?>