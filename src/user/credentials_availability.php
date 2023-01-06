<?php

    function checkEmail($email, $database){ //returns true if the email is already registered, false if not
        $hasEmailsql = sprintf("SELECT * FROM `login_details` WHERE email_address = '%s'", $database -> real_escape_string(htmlspecialchars($email, ENT_QUOTES)));     //sql query
        $result = $database -> query($hasEmailsql);
        $flag = false;

        if($result -> num_rows > 0){
            $flag = true;
        }
        $result -> free_result();
        return $flag;
    }

    function checkUsername($username, $database){   //returns true if the username is already registered, false if not
        $hasUsernamesql = sprintf("SELECT * FROM `login_details` WHERE `username` = '%s'", $database -> real_escape_string(htmlspecialchars($username, ENT_QUOTES)));   //sql query
        $result = $database -> query($hasUsernamesql);
        $flag = false;

        if($result -> num_rows > 0){
            $flag = true;
        }
        $result -> free_result();
        return $flag;
    }
?>
