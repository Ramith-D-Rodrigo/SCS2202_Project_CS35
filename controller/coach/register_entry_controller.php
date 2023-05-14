<?php
     session_start();
          require_once("../../src/general/security.php");

          if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: [])){
               Security::redirectUserBase();
               die();
           }
       
         require_once("../../src/general/dbconnection.php");
         require_once("../../src/general/website_functions/our_sports_functions.php");

    
    $allsports = getAllSports($connection); //get all sports

    $sport_info = [];
    foreach($allsports as $sport){

        if($sport -> maxNoOfStudents == null){
               continue;
          }else{
             $branchdetails =  branchesWithThatSport($sport ->sportID, $connection);
               if($branchdetails == []){
               continue;
               }
          }
        $sport_id =   $sport -> sportID;
        $sport_name = $sport -> sportName;


       array_push($sport_info,["sportID" => $sport_id, "sportName" => $sport_name]) ;
    }


         $connection -> close(); //close the database connection  
     echo json_encode($sport_info);

    ?>