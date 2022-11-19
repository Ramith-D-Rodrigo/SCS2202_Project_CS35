<?php
    $resultArr = [];
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/website_functions/our_branches_functions.php");
    require_once("../../src/general/branch.php");
    
    $allBranches = getAllBranches($connection);
    
    while($row = $allBranches -> fetch_object()){
        $tempBranch = new Branch($row -> branch_id);
        $sports = $tempBranch -> getAllSports($connection);
    }

    echo json_encode($result -> fetch_object() -> city);
?>