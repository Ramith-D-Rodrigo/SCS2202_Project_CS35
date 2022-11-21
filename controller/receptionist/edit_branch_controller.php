<?php
    session_start();

    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");

    $recep = new Receptionist();
    
    $result = $recep -> editBranch($_SESSION['userid'], $_SESSION['branchid'],$connection);  //search the branch to edit

    if(isset($result['errMsg'])){   //no branch was found
        $_SESSION['searchErrorMsg'] = $result['errMsg'];
    }
    else{
        unset($_SESSION['searchErrorMsg']);
        $_SESSION['searchResult'] = $result;
    }
    //print_r($_SESSION['searchResult']);
    header("Location: /public/receptionist/edit_branch.php");
    $connection -> close();
?>