<?php
    //this script is used to get the details of all the branches of the complex and the sports that each branch is offering to display in the reservation schedule page
    //for owner to select the branch and the sport to get the reservation schedule
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/owner/owner.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/sport.php");

    $owner  = Owner::getInstance();

    $branches = $owner -> getBranches();    //get all the branches of the complex

    $returnJSON = [];

    $branchSports = [];

    foreach($branches as $currBranch){
        //get branch city
        $currBranch -> getDetails($owner -> getConnection(), ['city']);

        $sportArr = $currBranch -> offeringSports($owner -> getConnection());  //get the sports that the branch is offering



        foreach($sportArr as $currSport){
            $currSport -> getDetails($owner -> getConnection(), ['sportName']); //get the sport name
        }

        $currBranch -> sports = $sportArr;  //store the sports in the branch object

        array_push($returnJSON, $currBranch);   //store the branch object in the return array
    }

    header("Content-Type: application/json;");
    echo json_encode($returnJSON, JSON_PRETTY_PRINT);
?>
