<?php
    session_start();
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/sport.php");
    require_once("../../src/general/website_functions/our_sports_functions.php");

    $allSports = getAllSports($connection); //get all sports

    $returningResult = [];
    foreach($allSports as $currSport){
        $sport_id = $currSport -> sport_id;
        $allBranches = branchesWithThatSport($sport_id, $connection);
        if(count($allBranches) === 0){ //there are no branch that provide the current considering sport
            continue;
        }
        array_push($returningResult, ['sport_id' => $sport_id, 'sport_name' => $currSport -> sport_name, 'reserve_price' => $currSport -> reservation_price, 'providing_branches' => $allBranches]);
        unset($allBranches);
    }
    
    $returningJSON =  json_encode($returningResult);
    echo $returningJSON;
    unset($returningResult);
    unset($allSports);
    //header("Location: /public/general/our_sports.php");
    $connection -> close();
?>