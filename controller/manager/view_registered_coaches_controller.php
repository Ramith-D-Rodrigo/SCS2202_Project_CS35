<?php

session_start();

require_once("../../src/manager/manager.php");
require_once("../../src/coach/coach.php");
require_once("../../src/general/sport.php");
require_once("../../src/general/branch.php");
require_once("../../src/general/website_functions/reg_coaches_functions.php");

$manager = new Manager();
$managerBranch = new Branch($_SESSION['branchID']);

$database = $manager -> getConnection();
$coachObj = getAllCoaches($database);

$allRegisteredCoaches = [];
foreach($coachObj as $registeredCoachObj ){

    $coachID = $registeredCoachObj -> coachID;
    $sportID = $registeredCoachObj -> sport;

    $coach = new Coach();
    $coach -> setDetails(uid:$coachID);
    $firstName = $coach -> getDetails('firstName');
    $lastName = $coach -> getDetails('lastName');

    $sport = new Sport();
    $sport -> setID($sportID);
    $sport -> getDetails($database,['sportName']);
    $sportName = json_decode(json_encode($sport), true)['sportName'];
    array_push($allRegisteredCoaches, ['coachID' => $coachID, 'firstName' => $firstName, 'lastName' => $lastName,'sport' => $sportID,'sportName' => $sportName ]);
}
// print_r($allRegisteredCoaches);

$_SESSION['coachObj'] = $allRegisteredCoaches;
header("Location: /public/manager/registered_coaches.php");

?>
