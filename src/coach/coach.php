<?php
    require_once("../../src/general/uuid.php");
class Coach{
    private $userID;
    private $firstName;
    private $lastName;
    private $emailAddress;
    private $homeAddress;
    private $contactNum;
    private $registeredDate;
    private $dateOfBirth;
    private $qualifications;
    private $username;
    private $password;
    private $gender;
    private $isactive;
    private $profilePic;
    private $sport;

    public function setDetails($fName='', $lName='', $email='', $address='', $contactNo='', $dob='', $uid='',$qualifications='', $username='', $password='', $gender='',$sport=''){
        $this -> userID = $uid;
        $this -> firstName = $fName;
        $this -> lastName = $lName;
        $this -> emailAddress = $email;
        $this -> homeAddress = $address;
        $this -> contactNum = $contactNo;
        $this -> dateOfBirth = $dob;
        $this -> qualifications = $qualifications;
        $this -> username = $username;
        $this -> password = $password;
        $this -> gender = $gender;
        $this -> sport = $sport;
    }

    public function setProfilePic($profilePic){
        $this -> profilePic = $profilePic;
    }

    public function getUserID(){    //userID getter
        return $this -> userID;
    }

    public function getProfilePic(){
        return $this -> profilePic;
    }

    private function create_login_details_entry($database){   //first we createe the log in details entry
        $result = $database -> query(sprintf("INSERT INTO `login_details`
        (`user_id`, 
        `username`, 
        `password`,
        `email_address`, 
        `is_active`,
        `user_role`) 
        VALUES 
        (UUID_TO_BIN('%s', 1),'%s','%s','%s','%s','coach')",
        $database -> real_escape_string($this -> userID),
        $database -> real_escape_string($this -> username),
        $database -> real_escape_string($this -> password),
        $database -> real_escape_string($this -> emailAddress),
        $database -> real_escape_string($this -> isactive),
    )); 

/*         if ($result === TRUE) {
            echo "New log in details record created successfully<br>";
        }
        else{
            echo "Error<br>";
        } */
        return $result;
    }

    private function create_coach_entry($database){  //Create entry in coach table
       $result = $database -> query(sprintf("INSERT INTO `coach`
        (`coach_id`, 
        `first_name`, 
        `last_name`,
        `home_address`, 
        `birthday`, 
        `gender`, 
        `contact_num`, 
        `photo`,
         `sport`,
          `register_date`)
           VALUES 
           (UUID_TO_BIN('%s', 1),'%s','%s','%s','%s','%s','%s','%s',UUID_TO_BIN('%s', 1),'%s')",
            $database -> real_escape_string($this -> userID),
            $database -> real_escape_string($this -> firstName),
            $database -> real_escape_string($this -> lastName),
            $database -> real_escape_string($this -> homeAddress),
            $database -> real_escape_string($this -> dateOfBirth),
            $database -> real_escape_string($this -> gender),
            $database -> real_escape_string($this -> contactNum),
            $database -> real_escape_string($this -> profilePic),
            $database -> real_escape_string($this -> sport),
            $database -> real_escape_string($this -> registeredDate)));
       

        return $result;
/*         if ($result === TRUE) {
            echo "New user record created successfully<br>";
        }
        else{
            echo "Error<br>";
        } */
   
    }

    private function create_coach_qualifications($database){
        $flag = TRUE;
        if(count($this -> qualifications) != 0){   //has qualifications
            foreach($this -> qualifications as $i){
                $result = $database -> query(sprintf("INSERT INTO `coach_qualification`
                (`coach_id`, 
                `qualification`) 
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

    public function registercoach($database){    //public function to register the coach
        $this -> registeredDate = date("Y-m-d");
        $this -> isactive = 1;
        $loginEntry = $this -> create_login_details_entry($database);
        if( $loginEntry===false){
            return false;
        }
        $userEntry = $this -> create_coach_entry($database);
        if( $userEntry===false){
            return false;
        }
        $qualificationsEntry = $this -> create_coach_qualifications($database); 
        if( $qualificationsEntry===false){
            return false;
        }
        

        if($loginEntry  === TRUE && $userEntry  === TRUE && $qualificationsEntry  === TRUE ){   
            return TRUE;
        }
        else{
            return FALSE;
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
        
        //get the profile pic from the datbase and store in the object's attribute
        $sqlPic = sprintf("SELECT `photo` , `sport` 
        FROM `coach` 
        WHERE `coach_id` = '%s'",
        $database -> real_escape_string(uuid_to_bin($this -> userID, $database)));

        $result = $database -> query($sqlPic);
        $resultRow = $result -> fetch_object();
        $this -> profilePic =  $resultRow -> photo;
        $this -> sport = (bin_to_uuid( $resultRow -> sport, $database));
       
        return ["Successfully Logged In", $rows -> user_role, $rows -> username];  //return the message and role

    }    

    public function getBranchesWithCourts($database){
         $sql = sprintf("SELECT  
        `sc`.`court_id`, 
        `sc`.`court_name`, 
        `b`.`branch_id`, 
        `b`.`city`, 
        `b`.`opening_time`, 
        `b`.`closing_time`, 
        `s`.`sport_name`,
        `s`.`min_coaching_session_price`,
        `s`.`reservation_price` ,
        `s`.`max_no_of_students`  
        FROM `sports_court` `sc`
        INNER JOIN  `branch` `b`
        ON `b`.`branch_id` = `sc`.`branch_id`
        INNER JOIN `sport` `s` 
        ON `s`.`sport_id` = `sc`.`sport_id`

        WHERE `s`.`sport_id` = '%s'
        AND `b`.`request_status`= 'a' 
        AND `sc`.`request_status`='a'",
        $database -> real_escape_string(uuid_to_bin($this -> sport, $database)));

        $result = $database -> query($sql);
        return $result;

       
    }

    public function getSessionDetail($database){
        $sql = sprintf("SELECT `cs`.`session_id`, 
       `cs`.`starting_time`, 
       `cs`.`ending_time`,
       `cs`.`day`, 
       `cs`.`coach_monthly_payment`, 
       `sc`.`court_name`, 
       `b`.`city` 
       FROM `coaching_session` `cs`
       INNER JOIN  `sports_court` `sc`
       ON `cs`.`court_id` = `sc`.`court_id`
       INNER JOIN `branch` `b` 
       ON `sc`.`branch_id` = `b`.`branch_id`
       INNER JOIN `coach` `c` 
       ON `c`.`coach_id` = `cs`.`coach_id`
       WHERE `c`.`coach_id` = '%s'",
       $database -> real_escape_string(uuid_to_bin($this ->userID, $database)));

       $result = $database -> query($sql);
       return $result;
}
    public function getSport(){

        return $this->sport;
    }
}

