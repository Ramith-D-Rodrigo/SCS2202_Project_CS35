<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/owner/owner.php");
    require_once("../../src/general/branch.php");

    $owner  = Owner::getInstance();

    $branchID = $_GET['branchID'];
    $sportID = $_GET['sport'];
    $from = $_GET['from'];
    $to = $_GET['to'];
    $days = $_GET['days'];
    
    $dataSet = [];
    $branch = new Branch($branchID);
    $currDate = new DateTime($from);
    if($sportID == 'all'){
        for($i = 0; $i < $days; $i++){
            $currD['date'] = $currDate -> format('Y-m-d');   //get the current date
            $currD['revenue'] = $owner -> getRevenue(dateFrom: $currDate -> format('Y-m-d'),dateTo: $currDate -> format('Y-m-d'),branch: $branch); //get the total revenue for that day
            array_push($dataSet,$currD);
            $currDate -> modify('+1 day');   //increment the date by 1 day
        }
    }else{
        $sport = new Sport();
        $sport -> setID($sportID);
        for($i = 0; $i < $days; $i++){
            $currD['date'] = $currDate -> format('Y-m-d');   //get the current date
            $currD['revenue'] = $owner -> getRevenue(dateFrom: $currDate -> format('Y-m-d'),dateTo: $currDate -> format('Y-m-d'),branch: $branch,sport: $sport); //get the total revenue for that day
            array_push($dataSet,$currD);
            $currDate -> modify('+1 day');   //increment the date by 1 day
        }
    }
    

    header('Content-Type: application/json');
    echo json_encode($dataSet);
    die();
?>