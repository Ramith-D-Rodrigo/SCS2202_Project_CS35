<?php

    function checkStaffEmail($email, $database){
        $hasEmailsql = sprintf("SELECT * FROM `login_details` WHERE `email_address` = '%s'", $database -> real_escape_string(htmlspecialchars($email, ENT_QUOTES)));     //check existing same email
        $result = $database -> query($hasEmailsql);
        return $result;
    }

    function checkUsername($username, $database){
        $hasUsernamesql = sprintf("SELECT * FROM `login_details` WHERE `username` = '%s'", $database -> real_escape_string(htmlspecialchars($username, ENT_QUOTES)));   //check existing same username
        $result = $database -> query($hasUsernamesql);
        return $result;
    }

    function checkReceptionist($branchName,$database) {

        $sql = sprintf("SELECT `branch_id` FROM `branch` WHERE `city`= '%s'",$database -> real_escape_string($branchName));
        $result = $database -> query($sql);

        $branchID = $result -> fetch_object() -> branch_id;
        $hasReceptionistsql = sprintf("SELECT * FROM `staff` WHERE `staff_role` = 'receptionist' AND `branch_id` = '%s' AND `leave_date` IS NULL", $database -> real_escape_string($branchID));   //check there's aready having a receptionist
        $result = $database -> query($hasReceptionistsql);
        return $result;
    }

    function checkManager($branchName,$database) {

        $sql = sprintf("SELECT `branch_id` FROM `branch` WHERE `city`= '%s'",$database -> real_escape_string($branchName));
        $result = $database -> query($sql);

        $branchID = $result -> fetch_object() -> branch_id;
        $hasManagersql = sprintf("SELECT * FROM `staff` WHERE `staff_role` = 'manager' AND `branch_id` = '%s' AND `leave_date` IS NULL", $database -> real_escape_string($branchID));   //check there's aready having a manager
        $result = $database -> query($hasManagersql);
        return $result;
    }

?>
