<?php
     session_start();
          require_once("../../src/general/security.php");

          if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: [])){
               Security::redirectUserBase();
               die();
           }
       
         require_once("../../src/general/dbconnection.php");
         require_once("../../src/coach/coach.php");

    
    //$feedback = getFeedback($connection); //get feedback

    // $sport_info = [];
    // foreach($allfeedbak as $feedback){}

      
      

?>