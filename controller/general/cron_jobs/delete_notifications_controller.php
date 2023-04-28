<?php
    //this script is automatically run using a cron job every day at 12:00 AM

    //need to delete all notifications that have been read and older than their lifetime period as specified in the database

    require_once("../../../src/general/website_functions/automating_functions.php");
    require_once("../../../src/general/dbconnection.php");

    deleteNotifications($connection);

    $connection -> close();
?>