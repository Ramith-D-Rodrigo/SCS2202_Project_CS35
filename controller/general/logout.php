<?php
    session_start();    //to get session info

    //echo "log out button";

    //print_r($_SESSION);

    $result = session_destroy();  //clear the session


    //echo $result;   //print session destruction result

    //print_r($_SESSION);

    header("Location: /index.php"); //redirect back to the homepage
?>