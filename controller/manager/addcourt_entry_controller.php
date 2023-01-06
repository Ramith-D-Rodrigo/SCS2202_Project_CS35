<?php
    session_start();
    require_once("../../src/manager/manager_dbconnection.php");
    require_once("../../src/general/branch.php");

    $managerBranch = new Branch($_SESSION['branchID']);
    $sports = $managerBranch -> getAllSports($connection);
    print_r($sports);

    foreach($sports as $currSport){
        $tempCourtID = $managerBranch -> getSportCourts($currSport -> sport_id, $connection);
        $tempCourt = new Sports_Court($tempCourtID);
        
        $tempCourt -> getName($connection);
        
    
    }

?>
