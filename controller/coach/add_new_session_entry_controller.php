<?php
     session_start();
     require_once("../../src/coach/dbconnection.php");
     require_once("../../src/coach/coach.php");


 $coachsport = $_SESSION['coachsportid'] ;

 $coach = new Coach() ;
 $coach -> setDetails(sport:$coachsport);

 $result = $coach -> getBranchesWithCourts($connection);

 $branches = [];
 

while($row = $result->fetch_object()){
    $court_info = [];
    
         $court_info["id"] = $row->courtID;
         $court_info["name"] = $row->courtName;

         
     $branch_info = [];
    
     $branch_info["city"] = $row->city;
     $branch_info["opening_time"] = $row->openingTime;
     $branch_info["closing_time"] = $row->closingTime;
     $branch_info["id"] = $row->branchID;

    //  array_push($branches,$branch_info);

    if(!isset($branches[$branch_info["id"]])){
      
        $branches[$branch_info["id"]] = [$branch_info,"courts"=>[$court_info]];

    }
    else{
        array_push( $branches[$branch_info["id"]]["courts"],$court_info);

    }

    if(!isset($_SESSION["min_coaching_session_price"])){

        $_SESSION["min_coaching_session_price"] = $row->minCoachingSessionPrice;
    }

    if(!isset($_SESSION["reservation_price"])){

        $_SESSION["reservation_price"] = $row->reservationPrice;
    }

    if(!isset($_SESSION["max_no_of_students"])){

        $_SESSION["max_no_of_students"] = $row->maxNoOfStudents;
    }


    
}

//print_r($branches);

$_SESSION['BranchesWithCourts'] = $branches;

header("Location: /public/coach/coach_addsession.php");


?>