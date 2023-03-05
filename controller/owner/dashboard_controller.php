<?php
    session_start();
    require_once("../../src/general/security.php");
    require_once("../../controller/CONSTANTS.php");

    if(!Security::userAuthentication(TRUE, ['owner'])){ //not authenticated
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/owner/owner.php");

    $owner = Owner::getInstance();  //get the owner instance

    $owner -> setUserID($_SESSION['userid']);  //set the owner's userID

    //get dashboard data

    //revenue for the month
    date_default_timezone_set(SERVER_TIMEZONE);
    //set the date range

    $startDate = date('Y-m-01');    //first day of the month
    $endDate = date('Y-m-t');   //last day of the month

    $revenue = $owner -> getRevenue($startDate, $endDate); //get the revenue for the month

    //get branches
    $branches = $owner -> getBranches();

    //get branch city names and the feedbacks
    $branchCityNames = [];
    $branchFeedbacks = [];

    foreach($branches as $branch){
        $branch -> getDetails($owner -> getConnection(), ['city']); //get the city name
        array_push($branchCityNames, json_decode(json_encode($branch), true)['city']);

        $currBranchFeedbacks = $branch -> getBranchFeedback($owner -> getConnection(), 3, ['description', 'rating', 'date']);  //get the recent 3 feedbacks of the branch

        foreach($currBranchFeedbacks as $feedback){
            array_push($branchFeedbacks, $feedback);
        }
    }

    //get pending manager requests
    $requests = $owner -> managerRequests(manager: null, discountDecision: 'p', courtDecision: 'p');

    //get sports 

    $sports = $owner -> getSports($owner -> getConnection());

    foreach($sports as $sport){
        $sport -> getDetails($owner -> getConnection(), ['sportName']);
    }

    
    $returnJSON = [];

    $returnJSON['revenue'] = $revenue;
    $returnJSON['branches'] = $branchCityNames;
    $returnJSON['feedbacks'] = $branchFeedbacks;
    $returnJSON['requests'] = count($requests);
    $returnJSON['sports'] = $sports;

    header('Content-Type: application/json');
    echo json_encode($returnJSON, JSON_PRETTY_PRINT); 

?>