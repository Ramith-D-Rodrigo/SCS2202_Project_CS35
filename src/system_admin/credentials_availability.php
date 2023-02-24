<?php

    function checkContactNumber($contactN,$database){
        $sql = sprintf("SELECT * FROM `staff` WHERE `contactNum` ='%s'",
        $database -> real_escape_string($contactN));

        $result = $database -> query($sql);
        return $result;
    }

    function checkBranchEmail($email, $database){
        $hasEmailsql = sprintf("SELECT * FROM `branch` WHERE `branchEmail` = '%s'", $database -> real_escape_string(htmlspecialchars($email, ENT_QUOTES)));     //check existing same email
        $result = $database -> query($hasEmailsql);    
        return $result;
    }

    function checkStaffEmail($email, $database){
        $hasEmailsql = sprintf("SELECT * FROM `login_details` WHERE `emailAddress` = '%s'", $database -> real_escape_string(htmlspecialchars($email, ENT_QUOTES)));     //check existing same email
        $result = $database -> query($hasEmailsql);    
        return $result;
    }

    function checkUsername($username, $database){
        $hasUsernamesql = sprintf("SELECT * FROM `login_details` WHERE `username` = '%s'", $database -> real_escape_string(htmlspecialchars($username, ENT_QUOTES)));   //check existing same username
        $result = $database -> query($hasUsernamesql);
        return $result;
    }

    function checkReceptionist($branchName,$database) {

        $sql = sprintf("SELECT `branchID` FROM `branch` WHERE `city`= '%s'",$database -> real_escape_string($branchName));
        $result = $database -> query($sql);

        $branchID = $result -> fetch_object() -> branchID;
        $hasReceptionistsql = sprintf("SELECT * FROM `staff` WHERE `staffRole` = 'receptionist' AND `branchID` = '%s' AND `leaveDate` IS NULL", $database -> real_escape_string($branchID));   //check there's aready having a receptionist
        $result = $database -> query($hasReceptionistsql);
        return $result;
    }

    function checkManager($branchName,$database) {

        $sql = sprintf("SELECT `branchID` FROM `branch` WHERE `city`= '%s'",$database -> real_escape_string($branchName));
        $result = $database -> query($sql);

        $branchID = $result -> fetch_object() -> branchID;
        $hasManagersql = sprintf("SELECT * FROM `staff` WHERE `staffRole` = 'manager' AND `branchID` = '%s' AND `leaveDate` IS NULL", $database -> real_escape_string($branchID));   //check there's aready having a manager
        $result = $database -> query($hasManagersql);
        return $result;
    }

?>
