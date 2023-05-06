<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/owner/owner.php");
    require_once("../../src/general/branch.php");

    $owner  = Owner::getInstance();

    $branches = $owner -> getBranches();
    //create an array of branch details
    $branchDetails = [];

    foreach($branches as $currBranch){
        $currBranch -> getDetails($owner -> getConnection(),['city']);  //branch basic details
        $offeringSports = $currBranch -> offeringSports($owner -> getConnection());  //sports which have accepted court requests
        foreach($offeringSports as $currSport){
            $currSport -> getDetails($owner -> getConnection(),['sportName']);  //sport basic details
        }
        $branch = array();
        $branch['basicInfo'] = $currBranch;
        $branch['sports'] = $offeringSports;
        array_push($branchDetails,$branch);
    }

    header('Content-Type: application/json');
    echo json_encode($branchDetails);
    die();
?>