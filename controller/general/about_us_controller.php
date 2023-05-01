<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: FALSE, acceptingUserRoles: ['user'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/general/website_functions/our_branches_functions.php");
    require_once("../../src/general/dbconnection.php");
    require_once("../../src/general/branch.php");

    $branches = getAllBranches($connection);

    $returnJSON = [];

    $branchPhotos = [];
    $courtPhotos = [];

    foreach($branches as $currID){
        $tempBranch = new Branch($currID);
        
        //get branch photos
        $currBranchPhotos = $tempBranch -> getBranchPictures($connection);    

        //add current branch photos to array 
        $branchPhotos = array_merge($branchPhotos, $currBranchPhotos);


        //get sport courts of the branch
        $sportCourts = $tempBranch -> getBranchCourts($connection, null, 'a');

        foreach($sportCourts as $currCourt){
            $currCourtPhotos = $currCourt -> getPhotos($connection);

            //add current court photos to array 
            $courtPhotos = array_merge($courtPhotos, $currCourtPhotos);
        }
    }

    $returnJSON['branchPhotos'] = $branchPhotos;
    $returnJSON['courtPhotos'] = $courtPhotos;

    $connection -> close();
    header('Content-Type: application/json');
    echo json_encode($returnJSON, JSON_PRETTY_PRINT);
?>