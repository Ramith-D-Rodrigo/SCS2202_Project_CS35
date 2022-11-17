<?php
    require_once("../../src/general/uuid.php");
class Receptionist{
    private $receptionistID;
    private $firstName;
    private $lastName;
    private $emailAddress;
    private $contactNum;
    private $joinDate;
    private $leaveDate;
    private $dateOfBirth;
    private $username;
    private $password;
    private $gender;
    private $branchID;
    private $staffRole;


    public function setDetails($fName='', $lName='', $email='', $contactNo='', $dob='', $gender='', $uid='', $username='', $password='', $brID = ''){
        $this -> receptionistID = $uid;
        $this -> firstName = $fName;
        $this -> lastName = $lName;
        $this -> emailAddress = $email;
        $this -> contactNum = $contactNo;
        $this -> dateOfBirth = $dob;
        $this -> gender = $gender;
        $this -> username = $username;
        $this -> password = $password;
        $this -> branchID = $brID;
        $this -> staffRole = 'receptionist';
    }

    public function getReceptionistID(){    //receptionistID getter
        return $this -> receptionistID;
    }

    private function create_login_details_entry($database){   //enter details to the login_details table
        $result = $database -> query(sprintf("INSERT INTO `login_details`
        (`user_id`, 
        `username`,
        `email_address`, 
        `password`, 
        `user_role`,
        `is_active`) 
        VALUES 
        (UUID_TO_BIN('%s', 1),'%s','%s','%s','receptionist',1)",
        $database -> real_escape_string($this -> receptionistID),
        $database -> real_escape_string($this -> username),
        $database -> real_escape_string($this -> emailAddress),
        $database -> real_escape_string($this -> password))); 

/*         if ($result === TRUE) {
            echo "New log in details record created successfully<br>";
        }
        else{
            echo "Error<br>";
        } */
        return $result;
    }

    private function create_staff_entry($database){  //enter details to the staff table

        $result = $database -> query(sprintf("INSERT INTO `staff`
        (`staff_id`,   
        `contact_number`, 
        `gender`, 
        `date_of_birth`,
        `first_name`, 
        `last_name`, 
        `join_date`, 
        `leave_date`, 
        `branch_id`,
        `staff_role`) 
        VALUES 
        (UUID_TO_BIN('%s', 1),'%s','%s','%s','%s','%s','%s', NULLIF('%s', ''), UUID_TO_BIN('%s', 1), '%s')",
        $database -> real_escape_string($this -> receptionistID),
        $database -> real_escape_string($this -> contactNum),
        $database -> real_escape_string($this -> gender),
        $database -> real_escape_string($this -> dateOfBirth),
        $database -> real_escape_string($this -> firstName),
        $database -> real_escape_string($this -> lastName),
        $database -> real_escape_string($this -> joinDate),
        $database -> real_escape_string($this -> leaveDate),
        $database -> real_escape_string($this -> branchID),
        $database -> real_escape_string($this -> staffRole))); 

        return $result;
    }

    private function create_receptionist_entry($database) {
        $sql = sprintf("INSERT INTO `receptionist` (`receptionist_id`) 
        VALUES (UUID_TO_BIN('%s',1))",
        $database -> real_escape_string($this -> receptionistID));

        $result = $database->query($sql);

        return $result;
    }

    public function registerReceptionist($database){    //public function to register the user
        $this -> joinDate = date("Y-m-d");
        $this -> leaveDate = '';
        $loginEntry = $this -> create_login_details_entry($database);
        $staffEntry = $this -> create_staff_entry($database);
        $receptionistEntry = $this -> create_receptionist_entry($database);

        if($loginEntry  === TRUE && $staffEntry  === TRUE && $receptionistEntry === TRUE){    //all has to be true (successfully registered)
            return TRUE;
        }
    }

    public function login($username, $password, $database){
        $sql = sprintf("SELECT BIN_TO_UUID(`user_id`, 1) AS uuid, 
        `username`, 
        `password`, 
        `user_role` 
        FROM `login_details`  
        WHERE `username` = '%s'", 
        $database -> real_escape_string($username));

        $result = $database -> query($sql);

        $rows = $result -> fetch_object();  //get the resulting row

        if($rows === NULL){ //no result. hence no user
            return ["No Such User Exists"];
        }

        $hash = $rows -> password;
        if(password_verify($password, $hash) === FALSE){    //Incorrect Password
            return ["Incorrect Password"];
        }

        //setting user data for session
        $this -> receptionistID = $rows -> uuid;

        $getBranch = sprintf("SELECT BIN_TO_UUID(`branch_id`, 1) AS brid  
        FROM `staff`  
        WHERE `staff_id` = UUID_TO_BIN('%s',1)", 
        $database -> real_escape_string($this -> receptionistID));

        $brResult = $database -> query($getBranch);

        $branchIDResult = $brResult -> fetch_object();   //get the branch_id
        $this -> branchID = $branchIDResult -> brid;

        $getBrName = sprintf("SELECT `city`  
        FROM `branch`  
        WHERE `branch_id` = UUID_TO_BIN('%s',1)", 
        $database -> real_escape_string($this -> branchID));

        $brNameResult = $database -> query($getBrName);

        $branchName = $brNameResult -> fetch_object();   //get the branch_city
    
        return ["Successfully Logged In", $rows -> user_role, $branchName -> city, $this -> branchID, $rows -> username];  //return the message and other important details
    }

    public function reqMaintenance($reason,$sportName,$courtName,$startDate,$endDate,$stfID,$database) {

        $crtID = sprintf("SELECT BIN_TO_UUID(`sports_court`.`court_id`,1) AS court_id
        from `sports_court` INNER JOIN 
        `sport` ON 
        `sports_court`.`sport_id` = `sport`.`sport_id` INNER JOIN 
        `staff` ON 
        `sports_court`.`branch_id` = `staff`.`branch_id` 
        WHERE `staff`.`staff_id` = UUID_TO_BIN('%s',1) 
        AND `sports_court`.`court_name` = '%s' 
        AND `sport`.`sport_name`= '%s' 
        AND `sports_court`.`request_status`='a'",
        $database -> real_escape_string($stfID),
        $database -> real_escape_string($courtName),
        $database -> real_escape_string($sportName));

        $crtIDRes = $database -> query($crtID);
        $row = $crtIDRes -> fetch_object();
        $courtID = $row -> court_id;             //get the court id     

        $courtQuery = sprintf("INSERT INTO court_maintenance 
        (`court_id`,
        `starting_date`,
        `ending_date`,
        `status`,
        `message`,
        `decision`,
        `requested_receptionist`) VALUES 
        (UUID_TO_BIN('%s',1),'%s','%s','pending','%s','p',UUID_TO_BIN('%s',1))",
        $database -> real_escape_string($courtID),
        $database -> real_escape_string($startDate),
        $database -> real_escape_string($endDate),
        $database -> real_escape_string($reason),
        $database -> real_escape_string($stfID));

        $results = $database -> query($courtQuery);
        if ($results === TRUE) {
            echo "Request Submitted Successfully<br>";
        }
        else{
            echo "Error<br>";
        } 
        return $results;
    }

    public function editBranch($staffID,$branchID,$database) {
        
        $branchSql = sprintf("SELECT DISTINCT `branch`.`city` AS location, 
        `branch`.`branch_email` AS email
        from `branch` INNER JOIN `staff` ON
        `branch`.`branch_id` = `staff`.`branch_id`
        WHERE `staff`.`branch_id` = UUID_TO_BIN('%s',1)",
        $database -> real_escape_string($branchID));

        $branchResult = $database -> query($branchSql);   //get the branch results
        
        $row = $branchResult -> fetch_object();   //get the branch details

        $branchLoc = $row -> location;
        $branchEmail = $row -> email;

        $branchNum = sprintf("SELECT DISTINCT `staff`.`contact_number` AS contact_number 
        from `staff` 
        WHERE `staff`.`branch_id` = UUID_TO_BIN('%s',1) AND `staff`.`leave_date` is NULL",
        $database -> real_escape_string($branchID));

        $numResult = $database -> query($branchNum);   //get the branch contact numbers
        
        
        $numArray = [];
        while($row = $numResult -> fetch_object()){   //get the branch details
            $number = $row -> contact_number;
            array_push($numArray,$number);
        }
        $result = [];
        array_push($result,$branchLoc,$branchEmail,$numArray);

        if(count($result) === 0){   //couldn't find any branch that provide the searched sport
            return ['errMsg' => "Sorry, Cannot find what you are looking For"];
        }

        return $result;
    }

}

?>