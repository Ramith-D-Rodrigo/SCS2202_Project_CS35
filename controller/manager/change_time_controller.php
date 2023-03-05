<?php
 
 session_start();
 require_once("../../src/general/branch.php");
 require_once("../../src/manager/manager.php");
 require_once("../../src/manager/manager_dbconnection.php");

 $openingTime = $_POST['newOpen'];
 $closingTime = $_POST['newClose'];

  $manager = new Manager();

 $manager -> changeTimeofaBranch($connection,$openingTime,$closingTime,$_SESSION['branchID']);


  header("Location: /public/manager/manager_edit_time.php");
  $connection -> close();
?>
 







