<?php
class User{
    private $userID;
    private $firstName;
    private $lastName;
    private $emailAddress;
    private $homeAddress;
    private $contactNum;
    private $height;
    private $weight;
    private $registeredDate;
    private $dateOfBirth;
    private $dependents;
    private $medicalConcerns;
    private $username;
    private $password;
    private $gender;
    private $isactive;

    public function setDetails($fName='', $lName='', $email='', $address='', $contactNo='', $dob='', $uid='', $dependents='', $height='', $weight='', $medicalConcerns='', $username='', $password='', $gender=''){
        $this -> userID = $uid;
        $this -> firstName = $fName;
        $this -> lastName = $lName;
        $this -> emailAddress = $email;
        $this -> homeAddress = $address;
        $this -> contactNum = $contactNo;
        $this -> dateOfBirth = $dob;
        $this -> height = $height;
        $this -> weight = $weight;
        $this -> medicalConcerns = $medicalConcerns;
        $this -> dependents = $dependents;
        $this -> username = $username;
        $this -> password = $password;
        $this -> gender = $gender;
    }

    public function getUserID(){    //userID getter
        return $this -> userID;
    }

    private function create_login_details_entry($database){   //first we createe the log in details entry
        $result = $database -> query(sprintf("INSERT INTO `login_details`
        (`user_id`, 
        `username`, 
        `password`, 
        `user_role`) 
        VALUES 
        (UUID_TO_BIN('%s', 1),'%s','%s','user')",
        $database -> real_escape_string($this -> userID),
        $database -> real_escape_string($this -> username),
        $database -> real_escape_string($this -> password))); 

/*         if ($result === TRUE) {
            echo "New log in details record created successfully<br>";
        }
        else{
            echo "Error<br>";
        } */
        return $result;
    }

    private function create_user_entry($database){  //Create entry in user table
        $result = $database -> query(sprintf("INSERT INTO `user`
        (`user_id`, 
        `first_name`, 
        `last_name`, 
        `email_address`, 
        `gender`, 
        `home_address`, 
        `contact_num`, 
        `birthday`, 
        `register_date`, 
        `height`, 
        `weight`,
        `is_active`) 
        VALUES 
        (UUID_TO_BIN('%s', 1),'%s','%s','%s','%s','%s','%s','%s','%s', NULLIF('%s', ''), NULLIF('%s', ''), '%s')",
        $database -> real_escape_string($this -> userID),
        $database -> real_escape_string($this -> firstName),
        $database -> real_escape_string($this -> lastName),
        $database -> real_escape_string($this -> emailAddress),
        $database -> real_escape_string($this -> gender),
        $database -> real_escape_string($this -> homeAddress),
        $database -> real_escape_string($this -> contactNum),
        $database -> real_escape_string($this -> dateOfBirth),
        $database -> real_escape_string($this -> registeredDate),
        $database -> real_escape_string($this -> height),
        $database -> real_escape_string($this -> weight),
        $database -> real_escape_string($this -> isactive))); 

        return $result;
/*         if ($result === TRUE) {
            echo "New user record created successfully<br>";
        }
        else{
            echo "Error<br>";
        } */
    }

    private function create_user_dependents($database){ //Create entries for all the user dependents
        $flag = TRUE;
        foreach($this -> dependents as $dependent){
            $result = $dependent -> create_entry($database);
            if($result === FALSE){
                return FALSE;
            }
        }
        return $flag;
    }

    private function create_user_medicalConcerns($database){
        $flag = TRUE;
        if(count($this -> medicalConcerns) != 0){   //has medical concerns
            foreach($this -> medicalConcerns as $i){
                $result = $database -> query(sprintf("INSERT INTO `user_medical_concern`
                (`user_id`, 
                `medical_concern`) 
                VALUES 
                (UUID_TO_BIN('%s', 1),'%s')", 
                $database -> real_escape_string($this -> userID),
                $database -> real_escape_string($i)));

                if ($result === FALSE) {    //got an error
                    return FALSE;
                }
            }
        }
        return $flag;
    }

    public function registerUser($database){    //public function to register the user
        $this -> registeredDate = date("Y-m-d");
        $this -> isactive = 1;
        $loginEntry = $this -> create_login_details_entry($database);
        $userEntry = $this -> create_user_entry($database);
        $medicalConcernEntry = $this -> create_user_medicalConcerns($database); 
        $dependentEntry = $this -> create_user_dependents($database); //finally, create the entries for the dependents

        if($loginEntry  === TRUE && $userEntry  === TRUE && $medicalConcernEntry  === TRUE && $dependentEntry === TRUE){    //all has to be true (successfully registered)
            return TRUE;
        }
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

        //setting user data for session
        $this -> userID = $rows -> uuid;    

        return ["Successfully Logged In", $rows -> user_role];  //return the message and role
    }

    public function searchSport($sportName, $database){
        $sql = sprintf("SELECT BIN_TO_UUID(`sport_id`, true) AS sport_id,
        `description`  
        FROM `sport` 
        WHERE `sport_name` 
        LIKE '%%%s%%'", //to escape % in sprintf, we need to add % again
        $database -> real_escape_string($sportName));

        $result = $database -> query($sql);

        return $result;
    }
}

?>