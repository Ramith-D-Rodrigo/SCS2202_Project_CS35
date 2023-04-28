<?php
    require_once("../../src/general/actor.php");

    //echo "log out button";
    $logOutActor = new Actor();

    do{
        $result = $logOutActor -> logOut();
    }while($result === false);  //maks sure that the session is destroyed

    unset($logOutActor);
    header("Location: /"); //redirect back to the homepage
?>