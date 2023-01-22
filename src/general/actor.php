<?php
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
        }

        public function setUserID($id){
            $this -> userID = $id;
        }

        public function getUserID(){
            return $this -> userID;
        }

        public function getUsername(){
            return $this -> username;
        }

        public function getUserRole(){
            return $this -> userRole;
        }

        public function getEmailAddress(){
            return $this -> emailAddress;
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
    }
?>