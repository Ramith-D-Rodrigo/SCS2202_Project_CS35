<?php
session_start();
require("../../src/receptionist/receptionist.php");
require("../../src/receptionist/dbconnection.php");
require("../../src/system_admin/staff.php");

$staffMember = new Staff();
$receptionist = $staffMember -> getStaffMemeber($_SESSION['userrole']);  

$coachID = htmlspecialchars($_GET['coachID']);
$branch = htmlspecialchars($_GET['branch']);

$sessionInfo = $receptionist -> getSeesionOnBranch($coachID,$branch,$connection);

if(count($sessionInfo)=== 0) {
    array_push($sessionInfo,['errMsg' => "Sorry, There is some error when retrieving the session info"]);
}

header('Content-Type: application/json;');    
echo json_encode($sessionInfo);
$connection -> close();  //close the connection

?>