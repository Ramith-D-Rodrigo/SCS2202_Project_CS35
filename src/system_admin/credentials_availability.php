<?php

    function checkReceptionistEmail($email, $database){
        $hasEmailsql = sprintf("SELECT * FROM RECEPTIONIST WHERE email_address = '%s'", $database -> real_escape_string(htmlspecialchars($email, ENT_QUOTES)));     //sql query
        $result = $database -> query($hasEmailsql);
        return $result;
    }

    function checkManagerEmail($email, $database){
        $hasEmailsql = sprintf("SELECT * FROM MANAGER WHERE email_address = '%s'", $database -> real_escape_string(htmlspecialchars($email, ENT_QUOTES)));     //sql query
        $result = $database -> query($hasEmailsql);
        return $result;
    }

    function checkUsername($username, $database){
        $hasUsernamesql = sprintf("SELECT * FROM `login_details` WHERE `username` = '%s'", $database -> real_escape_string(htmlspecialchars($username, ENT_QUOTES)));   //sql query
        $result = $database -> query($hasUsernamesql);
        return $result;
    }

?>
