<?php
    //this script is used to get all the feedback of the branches to display in the our feedback page
    session_start();
    require_once("../../src/general/website_functions/our_branches_functions.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/branch.php");

    $allBranches = getAllBranches($connection); //get all the branches

    require_once("../../src/general/security.php");

    if(!Security::userAuthentication(logInCheck : false, acceptingUserRoles: ['user'])){
        Security::redirectUserBase();
        die();
    }

    $allFeedbacksBranchWise = [];
    
    foreach($allBranches as $currBranchID){
        $tempBranch = new Branch($currBranchID);    //create a temporary branch obj for result

        $branchFeedback = $tempBranch -> getBranchFeedback($connection);    //get the branch feedback for that created branch obj

        $tempBranch -> getDetails($connection, ['city']);

        $branchCity = json_decode(json_encode($tempBranch), true)['city'];    //get the city of the branch

        $allFeedbacksBranchWise[$currBranchID." ".$branchCity] = $branchFeedback;   //branch id and branch city as indices
        unset($tempBranch);
        unset($branchFeedback);
    }

    $connection -> close();
    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($allFeedbacksBranchWise);
?>