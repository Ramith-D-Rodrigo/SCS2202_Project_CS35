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

    $staffMember = new Staff();
    $recep = $staffMember -> getStaffMember('receptionist');          //$_SESSION['userrole']
    
    $result = $recep -> editBranch($_SESSION['userid'], $_SESSION['branchID'],$connection);  //search the branch to edit

    if(count($result) === 0){   //couldn't find any branch that provide the searched sport
        array_push($result,['errMsg' => "Sorry, Cannot find what you are looking For"]);
    }
    
    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($result);
    //print_r($_SESSION['searchResult']);
    // header("Location: /public/receptionist/edit_branch.php");
    $connection -> close();
?>