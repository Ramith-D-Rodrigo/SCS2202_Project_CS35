<?php
     session_start();
         require_once("../../src/general/uuid.php");
         require_once("../../src/general/sport_court.php");
         require_once("../../src/coach/add_session.php");

         $allbranches = getAllbranches($connection); //get all branches

         $branch_name = [];
         while($row = $allbranches -> fetch_object()){
             if($row -> request_status===null )
             {
                 continue;
             }
             $branch_id =  bin_to_uuid($row -> branch_id, $connection);
             $city = $row -> city;

             array_push($branch_name,[$branch_id, $city]) ;
            }
                 $_SESSION[""] = $branch_name;
                 header("Location: /public/");
        
                 $connection -> close(); //close the database connection  
        
        
            ?>
     