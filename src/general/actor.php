<?php
    class Actor{
        protected $emailAddress;
        protected $username;
        protected $userID;
        protected $userRole;
        protected $passwordHash;
        protected $connection;

        public function __construct($userRole = ''){    //establish the database connection according to the given user role
            if($userRole === ''){
                require_once("dbconnection.php");
                $this -> connection = $connection;
            }
        }

        public function getUserID(){
            return $this -> userID;
        }

        public function getUsername(){
            return $this -> username;
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

            if($resultRow -> is_active === 0 && ($resultRow -> user_role === 'user' || $resultRow -> user_role === 'coach')){   //user is not active
                //has to send the email code
                return ["Account is not active, Please Activate your account using the code that has been sent to your email"];
            }
            else if($resultRow -> is_active === 0 && ($resultRow -> user_role === 'manager' || $resultRow -> user_role === 'owner' || $resultRow -> user_role === 'receptionist')){   //staff is not active
                return ["Account is not active, Please contact the admin to activate your account"];
            }

            //set the object variables
            $this -> userID = $resultRow -> user_id;
            $this -> username = $resultRow -> username;
            $this -> userRole = $resultRow -> user_role;

            return ["Successfully Logged In", $this -> userRole];          
        }

        public function closeConnection(){  //to close the connection of the actor
            $this -> connection -> close();
        }

        public function getConnection(){    //to get the connection of the actor
            return $this -> connection;
        }
    }
?>