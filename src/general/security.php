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

        public static function checkEmailAvailability($email){   //checks if the email address is available
            $santizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL); //sanitize the email address

            if(!filter_var($santizedEmail, FILTER_VALIDATE_EMAIL)){ //check if the email is valid
                return false;
            }

            require("dbconnection.php");
            self::$connection = $connection;
            $sql = sprintf("SELECT `email_address` FROM `login_details` WHERE email_address = '%s'", self::$connection -> real_escape_string($santizedEmail));

            $result = self::$connection -> query($sql);
            $row = $result -> fetch_object();
            self::$connection -> close();

            if($row === null){  //if the email address is not in the database, it is available
                return true;
            }
            else{
                $row -> free_result();
                return false;
            }
        }

        public static function checkUsernameAvailability($username){
            require("dbconnection.php");
            self::$connection = $connection;
            $sql = sprintf("SELECT `username` FROM `login_details` WHERE username = '%s'", self::$connection -> real_escape_string($username));

            $result = self::$connection -> query($sql);

            $row = $result -> fetch_object();
            self::$connection -> close();

            if($row === null){  //if the username is not in the database, it is available
                return true;
            }
            else{
                $row -> free_result();
                return false;
            }
        }
    }

?>