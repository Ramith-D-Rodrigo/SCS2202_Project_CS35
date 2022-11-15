<?php

    function checkEmail($email, $database){
        $hasEmailsql = sprintf("SELECT * FROM `login_details` WHERE email_address = '%s'", $database -> real_escape_string(htmlspecialchars($email, ENT_QUOTES)));     //sql query
        $result = $database -> query($hasEmailsql);
        return $result;
    }

    function checkUsername($username, $database){
        $hasUsernamesql = sprintf("SELECT * FROM `login_details` WHERE `username` = '%s'", $database -> real_escape_string(htmlspecialchars($username, ENT_QUOTES)));   //sql query
        $result = $database -> query($hasUsernamesql);
        return $result;
    }

?>
