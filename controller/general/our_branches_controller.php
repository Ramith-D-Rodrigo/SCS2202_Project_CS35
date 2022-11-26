<?php
    $resultArr = [];
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/website_functions/our_branches_functions.php");
    require_once("../../src/general/branch.php");
    
    $allBranches = getAllBranches($connection);

    $branchInfo = [];
    
    while($row = $allBranches -> fetch_object()){   //travser all the branches (result)

        $tempBranch = new Branch($row -> branch_id);    //create new branch object

        $branch_photos = $tempBranch -> getBranchPictures($connection); //get branch photos

        $result = $tempBranch -> getDetails($connection);
        $currBranchInfo = $result -> fetch_object();

        $tempBranch -> setDetails(city: $currBranchInfo -> city, 
            address: $currBranchInfo -> address, 
            email: $currBranchInfo -> branch_email, 
            opening_time: $currBranchInfo -> opening_time, 
            closing_time: $currBranchInfo -> closing_time);

        
        $branchJSON = json_encode($tempBranch);
        array_push($branchInfo, $branchJSON);   //push to array;
    }

    echo json_encode($branchInfo);
?>