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
    $getAllBr = $admin -> getAllBranches($connection);

    if(count($getAllBr) === 0) {
        array_push($getAllBr,['errMsg' => "Sorry, There are no branches saved in the database"]);
    }

    
    header('Content-Type: application/json;');
    echo json_encode($getAllBr);
    $connection -> close();

?>