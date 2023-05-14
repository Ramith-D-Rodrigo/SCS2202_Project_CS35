<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/system_admin/staff.php");
    require_once("../../src/general/branch.php");

    $staffMember = new Staff();
    $receptionist = $staffMember -> getStaffMember($_SESSION['userrole']);
    $receptionist -> setUserID($_SESSION['userid']);
    $receptionist -> getDetails(['contactNum']);

    $branch = new Branch($_SESSION['branchID']);
    $branch -> getDetails($connection,['address','branchEmail']);
    
    //create a unique id for the reservationID
    $recepID = $_SESSION['userid'];
    $prefix = "Res-recep".substr($recepID,12,(strlen($recepID)-12));   //get only the branchID from recep ID
    $reservationID = uniqid($prefix,false);
    $reservationID = substr($reservationID,0,30);  //get the first 30 characters of the generated id

    $generalInfo = [
        "receptionist" =>   $receptionist,
        "branch" => $branch,
        "reservationID" => $reservationID
    ];

    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($generalInfo);
    $connection -> close();

?>