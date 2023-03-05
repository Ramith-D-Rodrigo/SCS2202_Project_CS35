<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/owner/owner.php");
    require_once("../../src/general/branch.php");

    $owner  = Owner::getInstance();

    $branchID = $_GET['branchID'];

    if(!isset($branchID)){
        Security::redirectUserBase();
        die();
    }

    $branch = new Branch($branchID);

    $feedback = $branch -> getBranchFeedback($owner -> getConnection());    //user feedbacks

    $branchRating = $branch -> getBranchRating($owner -> getConnection()); //branch rating

    $JSON = ["feedback" => $feedback, "rating" => $branchRating];
    header("Content-Type: application/json;");
    echo json_encode($JSON, JSON_PRETTY_PRINT);
?>
