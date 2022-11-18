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
    
         $court_info["id"] = bin_to_uuid($row->court_id,$connection);
         $court_info["name"] = $row->court_name;

         
     $branch_info = [];
    
     $branch_info["city"] = $row->city;
     $branch_info["opening_time"] = $row->opening_time;
     $branch_info["closing_time"] = $row->closing_time;
     $branch_info["id"] = bin_to_uuid ($row->branch_id,$connection);

    //  array_push($branches,$branch_info);

    if(!isset($branches[$branch_info["id"]])){
      
        $branches[$branch_info["id"]] = [$branch_info,"courts"=>[$court_info]];

    }
    else{
        array_push( $branches[$branch_info["id"]]["courts"],$court_info);

    }

    
}

print_r($branches);

$_SESSION['BranchesWithCourts'] = $branches;

?>