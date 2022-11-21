<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");

    $admin = new Admin();
    $getAllBr = $admin -> getAllBranches($connection);

    if(count($getAllBr) === 0) {
        array_push($getAllBr,['errMsg' => "Sorry, Cannot find what you are looking For"]);
    }

    if(isset($getAllBr['errMsg'])){   //no branch was found
        $_SESSION['searchErrorMsg'] = $getAllBr['errMsg'];
    }
    else{
        unset($_SESSION['searchErrorMsg']);
        $_SESSION['allBranchResult'] = $getAllBr;
    }

    header("Location: /public/system_admin/staff_register.php");
    $connection -> close();

?>