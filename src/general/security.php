<?php

    class Security{
        private static $connection;

        public static function passwordResetCheck($input){  //checks the user input and returns the email address, the suername and the role of the actor
            require("dbconnection.php");
            self::$connection = $connection;
            $sql = sprintf("SELECT `emailAddress`, `username`, `userRole`, `userID` FROM `login_details` 
            WHERE username = '%s' OR emailAddress = '%s'",
            self::$connection -> real_escape_string($input),
            self::$connection -> real_escape_string($input));

            $result = self::$connection -> query($sql);
            $row = $result -> fetch_object();

            if($row === null){
                return false;
            }

            $email = $row -> emailAddress;
            $username = $row -> username;
            $userRole = $row -> userRole;
            $userID = $row -> userID;
            unset($row);
            $result -> free_result();
            self::$connection -> close();

            return array($email, $username, $userRole, $userID);
        }

        public static function checkEmailAvailability($email){   //checks if the email address is available
            $santizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL); //sanitize the email address

            if(!filter_var($santizedEmail, FILTER_VALIDATE_EMAIL) ){ //check if the email is valid
                return false;
            }

            require("dbconnection.php");
            self::$connection = $connection;
            $sql = sprintf("SELECT `emailAddress` FROM `login_details` WHERE `emailAddress` = '%s'", self::$connection -> real_escape_string($santizedEmail));

            $result = self::$connection -> query($sql);
            //$row = $result -> fetch_object();
            self::$connection -> close();

            if($result -> num_rows == 0){  //if the email address is not in the database, it is available
                return true;
            }
            else{
                
                return false;
            }
        }

        public static function checkUsernameAvailability($inputUsername){
            require("dbconnection.php");
            self::$connection = $connection;
            $sql = sprintf("SELECT `username` FROM `login_details` WHERE username = '%s'", self::$connection -> real_escape_string($inputUsername));
            $result = self::$connection -> query($sql);

            //$row = $result -> fetch_object();
            self::$connection -> close();

            if($result -> num_rows == 0){  //if the username is not in the database, it is available
                return true;
            }
            else{
                //$row -> free_result();
                return false;
            }
        }

        public static function ActionAuthentication($inputUsername, $inputPassword, $userRole, $userID){  //function that validates the login credentials for actions that require authentication
            require("dbconnection.php");
            self::$connection = $connection;
            $sql = sprintf("SELECT `userID`, `username`, `password`, `userRole` 
            FROM `login_details` 
            WHERE `username` = '%s' AND `userID` = '%s' AND `userRole` = '%s'",
            self::$connection -> real_escape_string($inputUsername),
            self::$connection -> real_escape_string($userID),
            self::$connection -> real_escape_string($userRole));

            $result = self::$connection -> query($sql);
            $row = $result -> fetch_object();
            $result -> free_result();

            self::$connection -> close();
            
            if($row === null){  //incorrect username, email or user role
                return false;
            }

            if(!password_verify($inputPassword, $row -> password)){  //incorrect password
                return false;
            }

            return true;    //if all the conditions are met, the user is authenticated
        }

        public static function userAuthentication(bool $logInCheck, array $acceptingUserRoles = []){  //function to check whether the user has authentication to access the page
            if($logInCheck == FALSE){   //no need to be logged in to access the page
                if(!isset($_SESSION['userid'])){    //the user is not logged in
                    return true; //can access
                }
                else{   //the user is logged in
                    if(!($_SESSION['userrole'] === 'user')){   //if the logged in person is not a coach or an user
                        return false;   //they cannot access (we are referring to staff here)
                    }
                    else{
                        return true;
                    }
                }
            }
            else{   //access is based on the userRole
                if(!isset($_SESSION['userid'])){    //the user is not logged in
                    if(empty($acceptingUserRoles)){ //no one can access when logged in (register, login pages, etc)
                        return true;
                    }   
                    return false;   //no access
                }
                else{   //is logged in
                    if(!in_array($_SESSION['userrole'], $acceptingUserRoles)){  //the user is trying to access a page that cannot be accessed by their role (works for empty array)
                        return false;
                    }
                    else{   //can access
                        return true;
                    }
                }
            }
        }

        public static function redirectUserBase(){  //redirects the user to the appropriate page (starting page) based on the user role
            if(!isset($_SESSION['userrole'])){  //homepage
                header("Location: /index.php");
                return;
            }
            switch($_SESSION['userrole']){
                case 'admin':
                    header("Location: /public/system_admin/admin_dashboard.php");
                    break;
                case 'owner':
                    header("Location: /public/owner/owner_dashboard.php");
                    break;
                case 'manager':
                    header("Location: /public/manager/manager_dashboard.php");
                    break;
                case 'receptionist':
                    header("Location: /public/receptionist/receptionist_dashboard.php");
                    break;
                case 'coach':
                    header("Location: /public/coach/coach_dashboard.php");
                    break;
                case 'any' || 'user':
                    header("Location: /index.php");
                    break;
            }
        }
    }

?>