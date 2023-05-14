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

    $btnValue = $_GET['btn'];
    $request = explode(",",$btnValue);  
    $owner  = Owner::getInstance();

    // print_r(count($request));
    $results = '';
    if($request[6] == "discount"){  
        $managerID = $request[0];

        $manager = new Manager();
        $manager -> setDetails(uid: $managerID);
        $results = $owner -> getDiscountRequests($manager, $decision = 'p');
        $results = array_merge([$request[1],$request[3],$request[4],$request[5]],$results);

    }else{
        $managerID = $request[0];
        $branchID = $request[1];
        $sportID = $request[2];

        $manager = new Manager();
        $manager -> setDetails(uid: $managerID);
        $results = $owner -> getSportCourtRequests($manager, $decision = 'p');

        $branch = new Branch($branchID);
        $sport = new Sport();
        $sport -> setID($sportID);
        $sport -> getDetails($owner -> getConnection(),['sportName']);
        $courtCount  = count($branch -> getBranchCourts($owner -> getConnection(),$sport,'a'));   //find the existing number of courts
        $results = array_merge([$request[6],$request[3],$request[4],$request[5],$courtCount,$sport],$results);
        
    }

    header('Content-Type: application/json');
    echo  json_encode($results);
    die();
    

    // if(count(explode(",",$btnValue)))
?>