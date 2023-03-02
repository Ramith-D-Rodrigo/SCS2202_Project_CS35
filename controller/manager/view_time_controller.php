<?php
    session_start();
    // require_once("../../src/manager/manager.php");
    require_once("../../src/manager/manager_dbconnection.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/manager/manager_dbconnection.php");


    $managerBranchID = $_SESSION['branchID'];
    
    $branch = new Branch($managerBranchID);
    $openingTime =  $branch -> getDetails($connection, 'openingTime');
    $closingTime = $branch -> getDetails($connection, 'closingTime');

    $returnMsg = ['openingTime' => $openingTime, 'closingTime' => $closingTime];
    
    echo json_encode($returnMsg);
/*     foreach($timeResult as $time){
        $temporaryOpen =$time['openingTime'];
        $temporaryClose= $time['closingTime'];
        print_r($time);
        array_push($allTimes,['openingTime'=>$temporaryOpen,'closingTime'=>$temporaryClose]);
    }
    
    $_SESSION['branchTime'] = $allTime;
    header("Location: /public/manager/manager_edit_time.php");
    $connection -> close(); */
    

?>