<?php
    require_once("notification.php");
    require_once("../../controller/CONSTANTS.php");
    class Actor{
        protected $emailAddress;
        protected $username;
        protected $userID;
        protected $userRole;
        protected $password;
        protected $isActive;
        protected $connection;

        public function __construct($userRole = ''){    //establish the database connection according to the given user role
            if($userRole === ''){
                require("dbconnection.php");
                $this -> connection = $connection;
            }
            else if($userRole === 'user'){
                require("../../src/user/dbconnection.php");
                $this -> connection = $connection;
            }
            else if($userRole === 'coach'){
                require("../../src/coach/dbconnection.php");
                $this -> connection = $connection;
            }
            else if($userRole === 'admin'){
                require("../../src/system_admin/dbconnection.php");
                $this -> connection = $connection;
            }
            else if($userRole === 'manager'){
                require("../../src/manager/manager_dbconnection.php");
                $this -> connection = $connection;
            }
            else if($userRole === 'owner'){
                require("../../src/owner/dbconnection.php");
                $this -> connection = $connection;
            }
            else if($userRole === 'receptionist'){
                require("../../src/receptionist/dbconnection.php");
                $this -> connection = $connection;
            }
            else{
                die("Invalid User Role");
            }
        }

        public function setUserID($id){
            $this -> userID = $id;
        }

        public function getUserID(){
            return $this -> userID;
        }

        public function getUsername(){
            if(isset($this -> username)){
                return $this -> username;
            }
            else{ //get from the database
                $sql = sprintf("SELECT username FROM `login_details` WHERE userID = '%s'", $this -> connection -> real_escape_string($this -> userID));
                $result = $this -> connection -> query($sql);
                $resultRow = $result -> fetch_object();
                $this -> username = $resultRow -> username;
                $result -> free_result();
                unset($resultRow);
                return $this -> username;
            }
        }

        public function getUserRole(){
            return $this -> userRole;
        }

        public function getEmailAddress(){
            if(isset($this -> emailAddress) && $this -> emailAddress != ''){
                return $this -> emailAddress;
            }
            else{ //get from the database
                $sql = sprintf("SELECT emailAddress FROM `login_details` WHERE userID = '%s'", $this -> connection -> real_escape_string($this -> userID));
                $result = $this -> connection -> query($sql);
                $resultRow = $result -> fetch_object();
                $this -> emailAddress = $resultRow -> emailAddress;
                $result -> free_result();
                unset($resultRow);
                return $this -> emailAddress;
            }
        }

        public function login($inputUsername, $inputPassword){
            $sql = sprintf("SELECT * FROM `login_details` 
            WHERE username = '%s'", 
            $this -> connection -> real_escape_string($inputUsername)); //sql to get the user details

            $result = $this -> connection -> query($sql); //execute the query

            $resultRow = $result -> fetch_object();

            if($resultRow === null){    //no such user
                return ["No Such User Exists"];
            }

            $hash = $resultRow -> password;

            if(password_verify($inputPassword, $hash) === false){   //incorrect password
                return ["Incorrect Password"];
            }

/*             //set the object variables
            $this -> userID = $resultRow -> userID;
            $this -> username = $resultRow -> username;
            $this -> userRole = $resultRow -> userRole;
            $this -> emailAddress = $resultRow -> emailAddress; */

            //foreach loop to set object variables
            foreach($resultRow as $key => $value){
                //exclude password
                if($key === 'password'){
                    continue;
                }
                $this -> $key = $value;
            }

            if($resultRow -> isActive == 0 && ($resultRow -> userRole === 'user' || $resultRow -> userRole === 'coach')){   //user is not active
                //has to send the email code              
                return ["Account is not active<br>Please Activate your account using the code that has been sent to your email"];
            }
            else if($resultRow -> isActive == 0 && ($resultRow -> userRole === 'manager' || $resultRow -> userRole === 'owner' || $resultRow -> userRole === 'receptionist')){   //staff is not active
                return ["Account is not active<br>Please contact the admin to activate your account"];
            }

            return ["Successfully Logged In", $this -> userRole];          
        }

        public function closeConnection(){  //to close the connection of the actor
            $this -> connection -> close();
        }

        public function getConnection(){    //to get the connection of the actor
            return $this -> connection;
        }

        public function activateAccount(){
            $this -> isActive = 1;
            $sql = sprintf("UPDATE `login_details` SET `isActive` = '%s' WHERE `userID` = '%s'",
            $this -> connection -> real_escape_string($this -> isActive),
            $this -> connection -> real_escape_string($this -> userID));
    
            $result = $this -> connection -> query($sql);
            
            if($result === FALSE){
                return FALSE;
            }
            return TRUE;
        }

        public function logout(){
            session_start();
            $result1 = session_unset();
            $result2 = session_destroy();
            if($result1 === true && $result2 === true){
                return true;
            }
            else{
                return false;
            }
        }

        public function resetPassword($newPasswordHash){
            $sql = sprintf("UPDATE `login_details` SET `password` = '%s' WHERE `userID` = '%s'",
            $this -> connection -> real_escape_string($newPasswordHash),
            $this -> connection -> real_escape_string($this -> userID));

            $result = $this -> connection -> query($sql);

            if($result === FALSE){
                return FALSE;
            }
            return TRUE;
        }

        public function getNotifications(){
            $sql = sprintf("SELECT `notificationID` FROM `notification` WHERE `userID` = '%s' AND `date` <= '%s' ORDER BY `date` DESC",
            $this -> connection -> real_escape_string($this -> userID),
            $this -> connection -> real_escape_string(date("Y-m-d")));

            $result = $this -> connection -> query($sql);

            if($result === FALSE){
                return null;
            }

            $notifications = array();
            while($resultRow = $result -> fetch_object()){
                $currNotifcation = new Notification($resultRow -> notificationID);
                $notifications[] = $currNotifcation;
            }
            $result -> free_result();

            return $notifications;
        }

        public function readNotification($notification){
            //set the lifetime of the notification in time format
            $lifeTime = strval(NOTIFICATION_LIFE_TIME_HOURS) .":00:00";
            $notification -> setDetails(lifetime: $lifeTime);
            return $notification -> markAsRead($this -> connection);
        }
    }
?>