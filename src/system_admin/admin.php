<?php
class Admin{
    private $adminID;

    public function getadminID(){    //adminID getter
        return $this -> adminID;
    }

    public function login($username, $password, $database){
        $sql = sprintf("SELECT BIN_TO_UUID(`user_id`, true) AS uuid, 
        `username`, 
        `password`, 
        `user_role` 
        FROM `login_details`  
        WHERE `username` = '%s'", 
        $database -> real_escape_string($username));

        $result = $database -> query($sql);

        $rows = $result -> fetch_object();

        if($rows === NULL){ //no result. hence no user
            return ["No Such User Exists"];
        }

        $hash = $rows -> password;
        if(password_verify($password, $hash) === FALSE){    //Incorrect Password
            return ["Incorrect Password"];
        }

        //setting admin data for session
        $this -> adminID = $rows -> uuid;    

        return ["Successfully Logged In", $rows -> user_role];  //return the message and role
    }

}

?>