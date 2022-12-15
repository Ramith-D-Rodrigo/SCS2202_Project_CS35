 <?php
    require_once("../../src/general/uuid.php");
class Owner{
    private $ownerID;
    private $firstName;
    private $lastName;
    private $emailAddress;
    private $contactNum;
    private $username;
    private $password;
    private $staffRole;


    public function setDetails( $uid='',$fName='', $lName='', $email='', $contactNo='', $username='', $password='' ){
        $this -> ownerID = $uid;
        $this -> firstName = $fName;
        $this -> lastName = $lName;
        $this -> emailAddress = $email;
        $this -> contactNum = $contactNo;
        $this -> username = $username;
        $this -> password = $password;
        $this -> staffRole = 'owner';
    }

    public function getOwnerID(){    //OwnerID getter
        return $this -> ownerID;
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
        '%s','%s','%s','%s','owner',1)",
        $database -> real_escape_string($this -> ownerID),
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

  private function create_owner_entry($database) {
        $sql =(sprintf("INSERT INTO `owner`
         (`owner_id`,
         `contact_no`,
         `first_name`, 
         `last_name`) 
        VALUES '%s','%s','%s','%s','%s')",
        $database -> real_escape_string($this -> ownerID),
        $database -> real_escape_string($this -> contactNum),
        $database -> real_escape_string($this -> firstName),
        $database -> real_escape_string($this -> lastName)));

        $result = $database->query($sql);

        return $result;
    }

    public function registerOwner($database){    //public function to register the user
        // $this -> joinDate = date("Y-m-d");
        // $this -> leaveDate = '';
        $loginEntry = $this -> create_login_details_entry($database);
        //$staffEntry = $this -> create_staff_entry($database);
        $ownerEntry = $this -> create_owner_entry($database);

        if($loginEntry  === TRUE && $ownerEntry === TRUE){    //all has to be true (successfully registered)
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
            return ["No Such User Exists"];
        }

        $hash = $rows -> password;
        if(password_verify($password, $hash) === FALSE){    //Incorrect Password
            return ["Incorrect Password"];
        }

        //setting user data for session
        $this -> ownerID = $rows -> usrer_id;

        // $getBranch = sprintf("SELECT BIN_TO_UUID(`branch_id`, 1) AS brid  
        // FROM `staff`  
        // WHERE `staff_id` = UUID_TO_BIN('%s',1)", 
        // $database -> real_escape_string($this -> receptionistID));

        // $brResult = $database -> query($getBranch);

        // $branchIDResult = $brResult -> fetch_object();   //get the branch_id
        // $this -> branchID = $branchIDResult -> brid;

        // $getBrName = sprintf("SELECT `city`  
        // FROM `branch`  
        // WHERE `branch_id` = UUID_TO_BIN('%s',1)", 
        // $database -> real_escape_string($this -> branchID));

        // $brNameResult = $database -> query($getBrName);

        // $branchName = $brNameResult -> fetch_object();   //get the branch_city
    
        return ["Successfully Logged In", $rows -> user_role ,$rows -> username];  //return the message and other important details
    }

   
    }

   



?>