<?php
    require_once("../../src/general/uuid.php");
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
    private $profilePic;

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
        `is_active`,
        `profile_photo`) 
        VALUES 
        (UUID_TO_BIN('%s', 1),'%s','%s','%s','%s','%s','%s','%s','%s', NULLIF('%s', ''), NULLIF('%s', ''), '%s', NULLIF('%s', 'NULL'))",
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
        $database -> real_escape_string($this -> isactive),
        $database -> real_escape_string($this -> profilePic))); 

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
        $sqlPic = sprintf("SELECT `profile_photo` 
        FROM `user` 
        WHERE `user_id` = '%s'",
        $database -> real_escape_string(uuid_to_bin($this -> userID, $database)));

        $result = $database -> query($sqlPic);
        $picRow = $result -> fetch_object();
        if($picRow === NULL){
            $this -> profilePic = '';
        }
        else{
            $this -> profilePic =  $picRow -> profile_photo;
        }
        $this -> getProfilePic($database);  
        return ["Successfully Logged In", $rows -> user_role];  //return the message and role
    }

    public function searchSport($sportName, $database){
        $sportSql = sprintf("SELECT `sport_id`,
        `sport_name`,
        `reservation_price`
        FROM `sport` 
        WHERE `sport_name` 
        LIKE '%%%s%%'", //to escape % in sprintf, we need to add % again
        $database -> real_escape_string($sportName));

        $sportResult = $database -> query($sportSql);   //get the sports results

        if($sportResult -> num_rows === 0){ //no such sport found
            return ['errMsg' => "Sorry, Cannot find what you are looking For"];
        }

        $result = [];
        while($row = $sportResult -> fetch_assoc()){    //sports found, traverse the table
            $courtBranchSql = sprintf("SELECT DISTINCT `branch_id`   
            FROM `sports_court`
            WHERE `sport_id` 
            LIKE '%s'", $database -> real_escape_string($row['sport_id'])); //find the branches with the searched sports (per sport)
            $branchResult = $database -> query($courtBranchSql);

            while($branchRow = $branchResult -> fetch_object()){   //getting all the branches
                $branch = $branchRow -> branch_id;

                array_push($result, ['branch' => $branch, 'sport_name' => $row['sport_name'], 'sport_id' => $row['sport_id'], 'reserve_price' => $row['reservation_price']]); //create a branch sport pair
            }
        }
        return $result;
    }

    public function makeReservation($date, $st, $et, $people, $payment, $court, $database){
        $newReservation = new Reservation();
        $result = $newReservation -> onlineReservation($date, $st, $et, $people, $payment, $court, $this -> userID, $database);
        unset($newReservation);
        return $result;
    }

    public function getReservationHistory($database){   //Joining sport, sport court, branch, reservation tables
        $sql = sprintf("SELECT `r`.`reservation_id`, 
        `r`.`date`, 
        `r`.`starting_time`, 
        `r`.`ending_time`, 
        `r`.`payment_amount`, 
        `r`.`status`, 
        `b`.`city`, 
        `s`.`sport_name`,
        `sc`.`court_name` 
        FROM `reservation` `r`
        INNER JOIN `sports_court` `sc` 
        ON `r`.`sport_court` = `sc`.`court_id`
        INNER JOIN `sport` `s` 
        ON `s`.`sport_id` = `sc`.`sport_id`
        INNER JOIN `branch` `b` 
        ON `sc`.`branch_id` = `b`.`branch_id`
        WHERE `r`.`user_id` = '%s'
        ORDER BY `r`.`date`",
        $database -> real_escape_string(uuid_to_bin($this -> userID, $database)));

        $result = $database -> query($sql);
        return $result;
    }
}

?>