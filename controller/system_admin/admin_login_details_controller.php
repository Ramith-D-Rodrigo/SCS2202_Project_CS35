<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['admin'])){
        Security::redirectUserBase();
        die();
    }


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