<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/owner/owner.php");
    require_once("../../src/manager/manager.php");
    require_once("../../src/general/branch.php");

    $owner  = Owner::getInstance();
    $result = $owner -> managerRequests(discountDecision: "p",courtDecision: "p");  //retrieve all the manager requests including discounts and courts

    foreach($result as $object){
        if(count(get_object_vars($object))>6){  //if the request is for a new court(attribute in the db table is diff.)
            $sport = new Sport();
            $sport -> setID($object -> sportID);
            $sport = $sport -> getDetails($owner -> getConnection(), ['sportName']);  //adding the sport's name to the object
            $object -> sport = $sport;
            $manager = new Manager();
            $manager -> setDetails(uid: $object -> addedManager);
            $object -> type = "court";   //adding the type of the request to the object
        }else{
            $manager = new Manager();  //if the request is for a new discount
            $manager -> setDetails(uid: $object -> managerID);
            $object -> type = "discount";
        }
        
        $manager = $manager -> getDetails(['firstName','lastName']);  //adding the manager's name to the object
        $branch = new Branch($object -> branchID);
        $branch -> getDetails($owner -> getConnection(), ['city']);   //adding the branch's city to the object
        $object -> manager = $manager;
        $object -> branch = $branch;
    }


    header('Content-Type: application/json');
    echo json_encode($result);

?>