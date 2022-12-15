<?php
    require_once("../../src/general/uuid.php");
    require_once("../../src/system_admin/staffMember.php");

class Manager implements JsonSerializable , StaffMember{

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
 
    public function getID(){    //managerID getter
        if(isset($this -> managerID) || $this -> managerID !== ''){
            return $this -> managerID;
        }
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
        ('%s','%s','%s','%s','manager',1)",
        $database -> real_escape_string($this -> managerID),
        $database -> real_escape_string($this -> username),
        $database -> real_escape_string($this -> emailAddress),
        $database -> real_escape_string($this -> password))); 

/*      if ($result === TRUE) {
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
        ('%s','%s','%s','%s','%s','%s','%s', NULLIF('%s', ''), '%s', '%s')",
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
        $result = $database->query(sprintf("INSERT INTO `manager` (`manager_id`) VALUES ('%s')",
        $database -> real_escape_string($this -> managerID)));

        return $result;
    }

    public function register($database){    //public function to register the user
        $this -> joinDate = date("Y-m-d");
        $this -> leaveDate = '';
        $loginEntry = $this -> create_login_details_entry($database);
        $staffEntry = $this -> create_staff_entry($database);
        $managerEntry = $this -> create_manager_entry($database);

        if($loginEntry  === TRUE && $staffEntry  === TRUE && $managerEntry === TRUE){    //all has to be true (successfully registered)
            return TRUE;
        }
    }

    public function login($username, $password, $database){
        $sql = sprintf("SELECT `user_id`, 
        `username`, 
        `password`, 
        `user_role` 
        FROM `login_details`  
        WHERE `username` = '%s'", 
        $database -> real_escape_string($username));

        $result = $database -> query($sql);

        $rows = $result -> fetch_object();  //get the resulting row

        if($rows === NULL){ //no result. hence no user
            return ["No Such Manager Exists"];
        }

        $hash = $rows -> password;
        if(password_verify($password, $hash) === FALSE){    //Incorrect Password
            return ["Incorrect Password"];
        }

        //setting user data for session
        $this -> managerID = $rows -> user_id;

        $getBranch = sprintf("SELECT `branch_id` AS brid  
        FROM `staff`  
        WHERE `staff_id` = '%s'", 
        $database -> real_escape_string($this -> managerID));

        $brResult = $database -> query($getBranch);

        $branchIDResult = $brResult -> fetch_object();   //get the branch_id
        $this -> branchID = $branchIDResult -> brid;

        $getBrName = sprintf("SELECT `city`  
        FROM `branch`  
        WHERE `branch_id` = '%s'", 
        $database -> real_escape_string($this -> branchID));

        $brNameResult = $database -> query($getBrName);

        $branchName = $brNameResult -> fetch_object();   //get the branch_city
    
        return ["Successfully Logged In", $rows -> user_role, $branchName -> city, $this -> branchID, $rows -> username];  //return the message and other important details
    }

    public function getDetails($database){
        $sql = sprintf("SELECT * FROM `staff` 
        WHERE 
        `staff_id` = '%s'
        AND
        `staff_role` = 'manager'",
        $database -> real_escape_string($this -> managerID));

        $result = $database -> query($sql);
        $row = $result -> fetch_object();

        $this -> setDetails(fName: $row -> first_name, 
            lName: $row -> last_name, 
            contactNo: $row -> contact_number, 
            dob: $row -> date_of_birth,
            brID: $row -> branch_id,
            gender: $row -> gender);

        $this -> joinDate = $row -> join_date;
        $this -> leaveDate = $row -> leave_date;
        $this -> staffRole = $row -> staff_role;

        
        $result -> free_result();
        unset($row);
        return $this;
    }

    public function jsonSerialize(){
        return [
            'managerID' => $this -> managerID,
            'firstName' => $this -> firstName,
            'lastName' => $this -> lastName,
            'emailAddress' => $this -> emailAddress,
            'contactNum' => $this -> contactNum,
            'joinDate' => $this -> joinDate,
            'leaveDate' => $this -> leaveDate,
            'dateOfBirth' => $this -> dateOfBirth,
            'username' => $this -> username,
            'password' => $this -> password,
            'gender' => $this -> gender,
            'branchID' => $this -> branchID,
            'staffRole' => $this -> staffRole 
        ];
        
    }

    public function add_court($database, $court_name ,$sport_id, $branch_id, $courtID, $managerID){
        $result = $database -> query(sprintf("INSERT INTO `sports_court`
        (`court_id`,   
        `sport_id`, 
        `court_name`,
        `branch_id`,
        `request_status`,
        `added_manager`) 
        VALUES 
        ('%s','%s','%s','%s','p','%s')",
        // $database -> real_escape_string($this -> managerID),
        // $database -> real_escape_string($this -> contactNum),
        $database -> real_escape_string($courtID),
        $database -> real_escape_string($sport_id),
        $database -> real_escape_string($court_name), 
        $database -> real_escape_string($branch_id),
        $database -> real_escape_string($managerID))); 
        
        return $result;

    }

    
    // public function getSportID($sportName, $database){
    //     $sportSql = sprintf("SELECT `sport_id`
    //     FROM `sport` 
    //     WHERE `sport_name` = '%s'", //to escape % in sprintf, we need to add % again
    //     $database -> real_escape_string($sportName));

    //     $sportResult = $database -> query($sportSql);
    //     $sportR = mysqli_fetch_assoc($sportResult);
    //     return  $sportR['sport_id'];  //get the sports results

    //     if($sportResult -> num_rows === 0){ //no such sport found
    //         return ['errMsg' => "Sorry, Cannot find what you are looking For"];
    //     }
    // }

    // public function getBranchID( $database, $branch){
    //     $sportSql = sprintf("SELECT `branch_id`
    //     FROM `branch` 
    //     WHERE `city` = '%s'",
    //     $database -> real_escape_string($branch)); //to escape % in sprintf, we need to add % again
    //     // $database -> real_escape_string($sportName));

    //     $sportResult = $database -> query($sportSql);
    //     $sportR = mysqli_fetch_assoc($sportResult);
    //     return  $sportR['branch_id'];  //get the sports results

    //     if($sportResult -> num_rows === 0){ //no such sport found
    //         return ['errMsg' => "Sorry, Cannot find what you are looking For"];
    //     }
    // }

}
?>