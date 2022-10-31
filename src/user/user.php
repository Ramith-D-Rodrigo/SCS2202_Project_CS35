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

    public function __construct($fName, $lName, $email, $address, $contactNo, $dob, $uid, $dependents, $height, $weight, $medicalConcerns, $username, $password, $gender){
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
        $this -> registeredDate = date("Y-m-d");
        $this -> dependents = $dependents;
        $this -> username = $username;
        $this -> password = $password;
        $this -> gender = $gender;
        $this -> isactive = 1;
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

        if ($result === TRUE) {
            echo "New log in details record created successfully<br>";
        }
        else{
            echo "Error<br>";
        }
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

        if ($result === TRUE) {
            echo "New user record created successfully<br>";
        }
        else{
            echo "Error<br>";
        }
    }

    private function create_user_dependents($database){ //Create entries for all the user dependents
        foreach($this -> dependents as $dependent){
            $dependent -> create_entry($database);
        }
    }
    private function create_user_medicalConcerns($database){
        if(count($this -> medicalConcerns) != 0){   //has medical concerns
            foreach($this -> medicalConcerns as $i){
                $result = $database -> query(sprintf("INSERT INTO `user_medical_concern`
                (`user_id`, 
                `medical_concern`) 
                VALUES 
                (UUID_TO_BIN('%s', 1),'%s')", 
                $database -> real_escape_string($this -> userID),
                $database -> real_escape_string($i)));

                if ($result === TRUE) {
                    echo "New  medical concern record created successfully<br>";
                }
                else{
                    echo "Error<br>";
                }
            }
        }
    }

    public function registerUser($database){    //public function to register the user
        $this -> create_login_details_entry($database);
        $this -> create_user_entry($database);
        $this -> create_user_medicalConcerns($database); 
        $this -> create_user_dependents($database); //finally, create the entries for the dependents
    }
}

?>