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
    // print_r($row);
    $court_info = [];
    
         $court_info["id"] = $row->court_id;
         $court_info["name"] = $row->court_name;

         
     $branch_info = [];
    
     $branch_info["city"] = $row->city;
     $branch_info["opening_time"] = $row->opening_time;
     $branch_info["closing_time"] = $row->closing_time;
     $branch_info["id"] = $row->branch_id;

    //  array_push($branches,$branch_info);

    if(!isset($branches[$branch_info["id"]])){
      
        $branches[$branch_info["id"]] = [$branch_info,"courts"=>[$court_info]];

    }
    else{
        array_push( $branches[$branch_info["id"]]["courts"],$court_info);

    }

    if(!isset($_SESSION["min_coaching_session_price"])){

        $_SESSION["min_coaching_session_price"] = $row->min_coaching_session_price;
    }

    if(!isset($_SESSION["reservation_price"])){

        $_SESSION["reservation_price"] = $row->reservation_price;
    }

    if(!isset($_SESSION["max_no_of_students"])){

        $_SESSION["max_no_of_students"] = $row->max_no_of_students;
    }


    
}

//print_r($branches);

$_SESSION['BranchesWithCourts'] = $branches;

header("Location: /public/coach/coach_addsession.php");


?>