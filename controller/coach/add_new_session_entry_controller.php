<?php
     session_start();
     
        require_once("../../src/general/security.php"); 

        if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['coach'])){
            Security::redirectUserBase();
            die();
        }

     require_once("../../src/coach/dbconnection.php");
     require_once("../../src/coach/coach.php");
     require_once("../../src/general/branch.php");
     require_once("../../src/general/sport.php");
     require_once("../../src/general/sport_court.php");

     require_once("../../src/general/website_functions/our_sports_functions.php");



 $coachsport = $_SESSION['coachsportid'] ;

 $coach = new Coach() ;
 $coach -> setDetails(sport:$coachsport);
 $coach -> setUserID($_SESSION['userid']);

 $branches =  branchesWithThatSport( $coachsport, $coach -> getConnection());
 
 $sportObj = new Sport();
 $sportObj -> setID($coachsport);

 $response = [];
 $branch_info = [];

foreach($branches as $currBranch){
    $tempBranch = new Branch($currBranch -> branch_id);

    $branchCourts = $tempBranch ->getBranchCourts($coach -> getConnection(), $sportObj, 'a');
    
    $branchCourtInfo = [];
    foreach($branchCourts as $currCourt){
        $name = $currCourt -> getName($coach -> getConnection());
        $id = $currCourt -> getID();

        array_push($branchCourtInfo,['courtID' => $id, 'courtName' => $name]);
    }
 

     $tempBranch -> getDetails($coach -> getConnection(), ['city', 'openingTime', 'closingTime']);

     $branchArr = json_decode(json_encode($tempBranch), true);
     $branchArr['courts'] = $branchCourtInfo;

     array_push($branch_info, $branchArr);
    //  array_push($branches,$branch_info);
    
}

$sportObj -> getDetails($coach -> getConnection(), ['minCoachingSessionPrice', 'maxNoOfStudents']);

$response = ['sportDetails' => $sportObj, 'branchAndCourts' => $branch_info];


//print_r($branches);

echo json_encode($response);




?>