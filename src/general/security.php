<?php

    class Security{
        private static $connection;

        public static function passwordResetCheck($input){  //checks the user input and returns the email address, the suername and the role of the actor
            require("dbconnection.php");
            self::$connection = $connection;
            $sql = sprintf("SELECT `email_address`, `username`, `user_role`, `user_id` FROM `login_details` 
            WHERE username = '%s' OR email_address = '%s'",
            self::$connection -> real_escape_string($input),
            self::$connection -> real_escape_string($input));

            $result = self::$connection -> query($sql);
            $row = $result -> fetch_object();

            if($row === null){
                return false;
            }

            $email = $row -> email_address;
            $username = $row -> username;
            $userRole = $row -> user_role;
            $userID = $row -> user_id;
            unset($row);
            $result -> free_result();
            self::$connection -> close();

            return array($email, $username, $userRole, $userID);
        }
    }

?>