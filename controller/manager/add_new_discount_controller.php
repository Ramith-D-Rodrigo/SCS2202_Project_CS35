<?php
 
    session_start();
    require_once("../../src/general/branch.php");
    require_once("../../src/manager/manager.php");
    require_once("../../src/manager/manager_dbconnection.php");

    $startingDate = $_POST['startDate'];
    $endingDate   = $_POST['endDate'];
    $discountValue= $_POST['percentage'];

    $manager = new Manager();
    $result = $manager -> addDiscount($connection,$_SESSION['userid'],$startingDate,$endingDate,$discountValue, $_SESSION['branchID']);
  
    if($result === TRUE){
        $resultmsg = "Request sent to the owner successfully";
    }
    else{
        $resultmsg = "Error Sending the request";
    }
    
    $_SESSION['resultMsg'] = $resultmsg;

    header("Location: /public/manager/manager_add_new_discount.php");
    $connection -> close();
?>