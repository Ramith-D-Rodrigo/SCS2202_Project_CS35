<?php
    session_start();
    require_once("../../src/general/security.php");

    if(!Security::userAuthentication(TRUE, ['owner'])){
        Security::redirectUserBase();
        die();
    }

    


?>