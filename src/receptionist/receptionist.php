<?php
class Receptionist{
    private $receptionistID;
    private $firstName;
    private $lastName;
    private $emailAddress;
    // private $homeAddress;
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
        `password`, 
        `user_role`) 
        VALUES 
        (UUID_TO_BIN('%s', 1),'%s','%s','receptionist')",
        $database -> real_escape_string($this -> receptionistID),
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

    private function create_staff_entry($database){  //enter details to the staff table
        // echo $this -> receptionistID ;
        // echo $this -> firstName;
        // echo $this -> lastName;
        // echo $this -> emailAddress;
        // echo $this -> contactNum ;
        // echo $this -> dateOfBirth ;
        // echo $this -> gender;
        // echo $this -> username ;
        // echo $this -> password ;
        // echo $this -> branchID ;
        echo $this -> staffRole = 'receptionist';
        $result = $database -> query(sprintf("INSERT INTO `staff`
        (`staff_id`,  
        `email_address`,  
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
        (UUID_TO_BIN('%s', 1),'%s','%s','%s','%s','%s','%s','%s', NULLIF('%s', ''), '%s', '%s')",
        $database -> real_escape_string($this -> receptionistID),
        $database -> real_escape_string($this -> emailAddress),
        $database -> real_escape_string($this -> contactNum),
        $database -> real_escape_string($this -> gender),
        $database -> real_escape_string($this -> dateOfBirth),
        $database -> real_escape_string($this -> firstName),
        $database -> real_escape_string($this -> lastName),
        $database -> real_escape_string($this -> joinDate),
        $database -> real_escape_string($this -> leaveDate),
        $database -> real_escape_string($this -> branchID),
        $database -> real_escape_string($this -> staffRole))); 

        if ($result === TRUE) {
            echo "New log in details record created successfully<br>";
        }
        else{
            echo "Error<br>";
        } 
        return $result;
    }


    public function registerReceptionist($database){    //public function to register the user
        $this -> joinDate = date("Y-m-d");
        $this -> leaveDate = '';
        $loginEntry = $this -> create_login_details_entry($database);
        $staffEntry = $this -> create_staff_entry($database);

        if($loginEntry  === TRUE && $staffEntry  === TRUE){    //all has to be true (successfully registered)
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
        $this -> receptionistID = $rows -> uuid;    

        return ["Successfully Logged In", $rows -> user_role];  //return the message and role
    }

    public function reqMaintenance($reason,$sportName,$courtName,$startDate,$endDate,$database) {

        // $brnchID = sprintf("SELECT branch_id from staff where staff_id=UUID_To_BIN(%s,1)",$database -> real_escape_string($staffID));
        // $id = $database -> query($brnchID);
        // foreach($id as $row){   //get the user id 
        //     $brnchid = $row['branch_id'];
        // }
        echo $sportName;
        echo $courtName;
        $stfID = '0x11ed60c6bc55d9b8b16d34e6d70e248d';
        $crtID = sprintf("SELECT `sports_court`.`court_id` 
        from `sports_court` INNER JOIN 
        `sport` ON 
        `sports_court`.`sport_id` = `sport`.`sport_id` INNER JOIN 
        `staff` ON 
        `sports_court`.`branch_id` = `staff`.`branch_id` 
        WHERE `staff`.`staff_id` = '%s' AND `sports_court`.`court_name` = '%s' AND `sport`.`sport_name`= '%s' ",
        $database -> real_escape_string($stfID),
        $database -> real_escape_string($courtName),
        $database -> real_escape_string($sportName));

        $crtIDS = $database -> query($crtID);
        $courtID = '';
        foreach($crtIDS as $row){   //get the court id 
            $courtID = $row['court_id'];
        }
        echo $courtID;
        $results = sprintf("INSERT INTO court_maintenance 
        (`court_id`,
        `strating_date`,
        `ending_date`,
        `status`,
        `decision`
        `requested_receptionist`) VALUES 
        ('%s','%s','%s','pending','p','%s')",
        $database -> real_escape_string($courtID),
        $database -> real_escape_string($startDate),
        $database -> real_escape_string($endDate),
        $database -> real_escape_string($stfID));
        // $database -> real_escape_string($staffID));

        if ($results === TRUE) {
            echo "Submitted successfully<br>";
        }
        else{
            echo "Error<br>";
        } 
        return $results;
    }

    public function editBranch($staffID,$database) {
        
        $branchSql = sprintf("SELECT `branch`.`location`, 
        `branch`.`branch_email` ,
        `branch`.`branch_id` ,
        from `branch` INNER JOIN `staff` ON
        `branch`.`branch_id` = `staff`.`branch_id`
        WHERE `staff`.`branch_id` = '%s'",
        $database -> real_escape_string($staffID));

        $branchResult = $database -> query($branchSql);   //get the branch results
        
        foreach($branchResult as $row){   //get the branch details
            $branchLoc = $row['location'];
            $branchEmail = $row['branch_email'];
            $branchID = $row['branch_id'];
        }
        $branchNum = sprintf("SELECT `staff`.`contact_number`, 
        from `staff` 
        WHERE `staff`.`branch_id` = '%s'",
        $database -> real_escape_string($branchID));

        $numResult = $database -> query($branchNum);   //get the branch results
        
        $numResult = [];
        foreach($numResult as $row){   //get the branch details
            $number = $row['contact_number'];
            array_push($numResult,$number);
        }
        $result = [];
        array_push($result,$branchLoc,$branchEmail,$numResult);

        if(count($result) === 0){   //couldn't find any branch that provide the searched sport
            return ['errMsg' => "Sorry, Cannot find what you are looking For"];
        }

        return $result;
    }

}

?>