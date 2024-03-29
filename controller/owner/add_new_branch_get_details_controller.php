<?php
    //this script is used to get the details of the sports to display in the add new branch page so the owner can choose the sports that the branch will provide
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    require_once('../../src/owner/owner.php');
    $owner = Owner::getInstance();  //get the owner instance

    $owner -> setUserID($_SESSION['userid']);  //set the owner's userID

    //get sports
    $sports = $owner -> getSports();

    foreach($sports as $sport){
        $sport -> getDetails($owner -> getConnection(), ['sportName']);
    }

    header('Content-Type: application/json');
    echo json_encode($sports);
?>
