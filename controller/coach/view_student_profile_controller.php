<?php
     session_start();
          require_once("../../src/general/security.php");

          if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['coach'])){
               Security::redirectUserBase();
               die();
           }
       
         require_once("../../src/coach/dbconnection.php");
         

?>         