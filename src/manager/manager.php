<?php
    require_once("../../src/general/uuid.php");
    require_once("../../src/system_admin/staffMember.php");
class Manager implements StaffMember{
    private $managerID;
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
        $this -> managerID = $uid;
        $this -> firstName = $fName;
        $this -> lastName = $lName;
        $this -> emailAddress = $email;
        $this -> contactNum = $contactNo;
        $this -> dateOfBirth = $dob;
        $this -> gender = $gender;
        $this -> username = $username;
        $this -> password = $password;
        $this -> branchID = $brID;
        $this -> staffRole = 'manager';
    }

    public function getManagerID(){    //managerID getter
        return $this -> managerID;
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
        (UUID_TO_BIN('%s', 1),'%s','%s','%s','manager',1)",
        $database -> real_escape_string($this -> managerID),
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
        $database -> real_escape_string($this -> managerID),
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

    private function create_manager_entry($database) {
        $result = $database->query(sprintf("INSERT INTO `manager` (`manager_id`) VALUES (UUID_TO_BIN('%s',1))",
        $database -> real_escape_string($this -> managerID)));

        return $result;
    }

    public function register($database){    //public function to register the user
        $this -> joinDate = date("Y-m-d");
        $this -> leaveDate = '';
        $loginEntry = $this -> create_login_details_entry($database);
        $staffEntry = $this -> create_staff_entry($database);
        $receptionistEntry = $this -> create_manager_entry($database);

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
        $this -> managerID = $rows -> uuid;

        $getBranch = sprintf("SELECT BIN_TO_UUID(`branch_id`, 1) AS brid  
        FROM `staff`  
        WHERE `staff_id` = UUID_TO_BIN('%s',1)", 
        $database -> real_escape_string($this -> managerID));

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
}
?>