<?php
session_start();
require("../../src/receptionist/receptionist.php");
require("../../src/receptionist/dbconnection.php");
require("../../src/system_admin/staff.php");

$staffMember = new Staff();
$receptionist = $staffMember -> getStaffMemeber($_SESSION['userrole']);  

$userID = htmlspecialchars($_GET['userID']);
$name = htmlspecialchars($_GET['name']);

$dependentInfo = $receptionist -> getUserDependentInfo($userID,$name,$connection);

if(count($dependentInfo)=== 0) {
    array_push($dependentInfo,['errMsg' => "Sorry, There are no dependents for this user"]);
}

header('Content-Type: application/json;');    
echo json_encode($dependentInfo);
$connection -> close();  //close the connection

?>