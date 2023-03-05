<?php
 
 session_start();
 require_once("../../src/general/branch.php");
 require_once("../../src/manager/manager.php");
 require_once("../../src/manager/manager_dbconnection.php");

 $openingTime = $_POST['newOpen'];
 $closingTime = $_POST['newClose'];

  $manager = new Manager();

  $manager -> setUserID($_SESSION['userid']);

  $status = $manager -> changeTimeofaBranch($openingTime,$closingTime,$_SESSION['branchID']);

  if($status){
    echo json_encode(array("successMsg" => "Time Edited Successfully"));
  }
  else{
    echo json_encode(array("errMsg" => "Failed to Edit Time"));
  }


 // header("Location: /public/manager/manager_edit_time.php");
  //$connection -> close();
?>
 







