<?php
    // require_once("../../src/manager/manager.php");
    require_once("../../src/manager/manager_dbconnection.php");
    require_once("../../src/general/branch.php");

    $managerBranchID = $_SESSION['branchID'];
    
    $branch = new Branch($managerBranchID);
    $timeResult =  $branch ->get_time($connection);
    $allTimes=[];
    foreach($Result as $time){
        $temporaryOpen =$time['openingTime'];
        $temporaryClose= $time['closingTime'];
        echo $time['openingTime'];
        array_push($allTimes,['openingTime'=>$temporaryOpen,'closingTime'=>$temporaryClose]);
    }
    echo $time['openingTime'];

    $_SESSION['branchTime'] = $allTime;
    header("Location: /public/manager/manager_edit_time.php");
    $connection -> close();

?>