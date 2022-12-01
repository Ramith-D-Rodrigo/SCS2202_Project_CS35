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

        array_push($branchInfo, $tempBranch);   //push to array;

        unset($tempBranch);
    }

    $connection -> close();
    echo json_encode($branchInfo);
?>