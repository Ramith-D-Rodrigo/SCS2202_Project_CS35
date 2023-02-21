<?php

    function checkContactNumber($contactN,$database){   //check whether the provided contact number already exists on staff table
        $sql = sprintf("SELECT * FROM `staff` WHERE `contactNum` ='%s'",
        $database -> real_escape_string($contactN));

        $result = $database -> query($sql);
        $unavailable = false;
        if($result -> num_rows > 0){
            $unavailable = true;
        }
        return $unavailable;
    }

    function checkBranchEmail($email, $database){   //check whether the provided email already exists on branch table
        $hasEmailsql = sprintf("SELECT * FROM `branch` WHERE `branchEmail` = '%s'", 
        $database -> real_escape_string(htmlspecialchars($email, ENT_QUOTES)));     //check existing same email
        $result = $database -> query($hasEmailsql);    
        $unavailable = false;
        if($result -> num_rows > 0){
            $unavailable = true;
        }
        return $unavailable;
    }

    function checkStaffEmail($email, $database){    //check whether the provided email already exists on staff table
        $hasEmailsql = sprintf("SELECT * FROM `login_details` WHERE `emailAddress` = '%s'", 
        $database -> real_escape_string(htmlspecialchars($email, ENT_QUOTES)));     //check existing same email
        $result = $database -> query($hasEmailsql);    
        $unavailable = false;
        if($result -> num_rows > 0){
            $unavailable = true;
        }
        return $unavailable;
    }

    function checkUsername($username, $database){   //check whether the provided username already exists on login table
        $hasUsernamesql = sprintf("SELECT * FROM `login_details` WHERE `username` = '%s'", 
        $database -> real_escape_string(htmlspecialchars($username, ENT_QUOTES)));   //check existing same username
        $result = $database -> query($hasUsernamesql);
        $unavailable = false;
        if($result -> num_rows > 0){
            $unavailable = true;
        }
        return $unavailable;
    }

    function checkReceptionist($branchName,$database) {   //check whether the provided branch already has a receptionist

        $sql = sprintf("SELECT `branchID` FROM `branch` WHERE `city`= '%s'",
        $database -> real_escape_string($branchName));
        $result = $database -> query($sql);

        $branchID = $result -> fetch_object() -> branchID;
        $hasReceptionistsql = sprintf("SELECT * FROM `staff` WHERE `staffRole` = 'receptionist' AND `branchID` = '%s' AND `leaveDate` IS NULL", 
        $database -> real_escape_string($branchID));   //check there's aready having a receptionist
        $result = $database -> query($hasReceptionistsql);
        $unavailable = false;
        if($result -> num_rows > 0){
            $unavailable = true;
        }
        return $unavailable;
    }

    function checkManager($branchName,$database) {  //check whether the provided branch already has a manager

        $sql = sprintf("SELECT `branchID` FROM `branch` WHERE `city`= '%s'",
        $database -> real_escape_string($branchName));
        $result = $database -> query($sql);

        $branchID = $result -> fetch_object() -> branchID;
        $hasManagersql = sprintf("SELECT * FROM `staff` WHERE `staffRole` = 'manager' AND `branchID` = '%s' AND `leaveDate` IS NULL", 
        $database -> real_escape_string($branchID));   //check there's aready having a manager
        $result = $database -> query($hasManagersql);
        $unavailable = false;
        if($result -> num_rows > 0){
            $unavailable = true;
        }
        return $unavailable;
    }

?>
