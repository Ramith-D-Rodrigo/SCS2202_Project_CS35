<?php
    session_start();
    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is not logged in
        header("Location: /index.php");
        exit();
    }

    if($_SESSION['userrole'] !== 'coach'){   //not an user (might be another actor)
        header("Location: /index.php");
        exit();
    }
    require_once("../../src/coach/coach.php");
    require_once("../../src/user/dbconnection.php");
    
    ?>