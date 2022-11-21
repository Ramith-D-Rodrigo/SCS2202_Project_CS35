<?php

    function checkStaffEmail($email, $database){
        $hasEmailsql = sprintf("SELECT * FROM `login_details` WHERE `email_address` = '%s'", $database -> real_escape_string(htmlspecialchars($email, ENT_QUOTES)));     //sql query
        $result = $database -> query($hasEmailsql);
        return $result;
    }

    function checkUsername($username, $database){
        $hasUsernamesql = sprintf("SELECT * FROM `login_details` WHERE `username` = '%s'", $database -> real_escape_string(htmlspecialchars($username, ENT_QUOTES)));   //sql query
        $result = $database -> query($hasUsernamesql);
        return $result;
    }

    function checkReceptionist($branchName,$database) {

        $sql = sprintf("SELECT BIN_TO_UUID(`branch_id`,1) AS uuid FROM `branch` WHERE `city`= '%s'",$database -> real_escape_string($branchName));
        $result = $database -> query($sql);

        $branchID = $result -> fetch_object() -> uuid;
        $hasReceptionistsql = sprintf("SELECT * FROM `staff` WHERE `staff_role` = 'receptionist' AND `branch_id` = UUID_TO_BIN('%s',1) AND `leave_date` IS NULL", $database -> real_escape_string($branchID));   //sql query
        $result = $database -> query($hasReceptionistsql);
        return $result;
    }

    function checkManager($branchName,$database) {

        $sql = sprintf("SELECT BIN_TO_UUID(`branch_id`,1) as uuid FROM `branch` WHERE `city`= '%s'",$database -> real_escape_string($branchName));
        $result = $database -> query($sql);

        $branchID = $result -> fetch_object() -> uuid;
        $hasManagersql = sprintf("SELECT * FROM `staff` WHERE `staff_role` = 'manager' AND `branch_id` = UUID_TO_BIN('%s',1) AND `leave_date` IS NULL", $database -> real_escape_string($branchID));   //sql query
        $result = $database -> query($hasManagersql);
        return $result;
    }

?>
