<?php
     session_start();
       
         require_once("../../src/coach/dbconnection.php");
         require_once("../../src/general/website_functions/our_sports_functions.php");

    
    $allsports = getAllSports($connection); //get all sports

    $sport_info = [];
    foreach($allsports as $sport){
        // if( $min_coaching_session_price===null )
        // {
        //     continue;
        // }
        $sport_id =   $sport -> sportID;
        $sport_name = $sport -> sportName;


       array_push($sport_info,[$sport_id, $sport_name]) ;
    }
         $_SESSION["sports"] = $sport_info;
         header("Location: /public/coach/coach_register.php");

         $connection -> close(); //close the database connection  


    ?>