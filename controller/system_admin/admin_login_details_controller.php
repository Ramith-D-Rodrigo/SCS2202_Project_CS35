<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");

    $admin = Admin::getInstance();
    $admin ->setDetails($connection);
    $ID = $admin -> getUserID();
    $email = $admin -> getEmailAddress();
    $array = array($ID,$email);
    
    header('Content-Type : application/json;');
    echo json_encode($array);
    $connection -> close();

?>