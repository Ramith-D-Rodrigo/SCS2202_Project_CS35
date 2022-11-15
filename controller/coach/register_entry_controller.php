<?php
     session_start();
         require_once("../../src/general/uuid.php");
         require_once("../../src/coach/dbconnection.php");
         require_once("../../src/general/website_functions/our_sports_functions.php");

    
    $allsports = getAllSports($connection); //get all sports

    $sport_info = [];
    while($row = $allsports -> fetch_object()){
        if($row -> min_coaching_session_price===null )
        {
            continue;
        }
        $sport_id =  bin_to_uuid($row -> sport_id, $connection);
        $sport_name = $row -> sport_name;


       array_push($sport_info,[$sport_id, $sport_name]) ;
    }
         $_SESSION["sports"] = $sport_info;
         header("Location: /public/coach/coach_register.php");

         $connection -> close(); //close the database connection  


    ?>