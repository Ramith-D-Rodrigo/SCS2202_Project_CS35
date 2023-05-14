<?php
session_start();
require_once("../../src/manager/manager.php");
require_once("../../src/general/branch.php");

$manager = new Manager();
$managerBranch = new Branch($_SESSION['branchID']);

$database = $manager -> getConnection();
$branchRating = $managerBranch -> getBranchRating($database);

print_r($branchRating);

$branchFeedback = $managerBranch -> getBranchFeedback($database,null,['date','description']);

print_r($branchFeedback);





?>