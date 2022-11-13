<?php
    session_start();
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/uuid.php");
    require_once("../../src/general/sport.php");
    require_once("../../src/general/website_functions/our_sports_functions.php");

    $allsports = getAllSports($connection); //get all sports

    $returningResult = [];
    while($row = $allsports -> fetch_object()){
        $sport_id = $row -> sport_id;
        $result = branchesWithThatSport($sport_id, $connection);
        if($result -> num_rows === 0){ //there are no sport that provide the current considering sport
            $result -> free_result();
            continue;
        }
        $branches = []; //the branches who provide that sport
        while($currBranch = $result -> fetch_object()){ 
            $branchID = $currBranch -> branch_id;
            $branchName = $currBranch -> branch_name;
            array_push($branches, ['branch_name' => $branchName, 'branch_id' => $branchID]);
        }
        array_push($returningResult, ['sport_id' => bin_to_uuid($sport_id, $connection), 'sport_name' => $row ->sport_name, 'reserve_price' => $row -> reservation_price, 'providing_branches' => $branches]);
        $result -> free_result();
    }

    $_SESSION['our_Sports'] = $returningResult;
    unset($returningResult);
    print_r($_SESSION);
    $allsports -> free_result();

    header("Location: /public/general/our_sports.php");
    $connection -> close();
?>