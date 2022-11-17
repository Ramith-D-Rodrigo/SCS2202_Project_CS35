<?php
class Manager{
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

public function setDetails ($uid='', $fname='', $lname='', $email='', $contactNo='', $dob='', $gender='', $username='', $password='', $brID='' ){
    $this -> managerID = $uid;
    $this -> firstName = $fname;
    $this -> lastName = $lname;
    $this -> emailAddress = $email;
    $this -> contactNum = $contactNo;
    $this -> dateOfBirth = $dob;
    $this -> gender = $gender;
    $this -> username = $username;
    $this -> password = $password;
    $this -> branchID = $brID;
    $this -> staffRole = 'manager';
}
public function getManagerID(){    //managerID get
    return $this -> managerID;
}

private function create_login_details_entry($database){   //enter details to the login_details table
    $result = $database -> query(sprintf("INSERT INTO `login_details`
    (`user_id`, 
    `username`, 
    `password`, 
    `user_role`) 
    VALUES 
    (UUID_TO_BIN('%s', 1),'%s','%s','manager')",
    $database -> real_escape_string($this -> managerID),
    $database -> real_escape_string($this -> username),
    $database -> real_escape_string($this -> password))); 

    return $result;
}


private function create_staff_entry($database){  //enter details to the staff table

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
    $database -> real_escape_string($this -> mnagerID),
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


public function registerManager($database){    //public function to register the manager
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
    $this -> managerID = $rows -> uuid;    

    return ["Successfully Logged In", $rows -> user_role];  //return the message and role
}



}
?>