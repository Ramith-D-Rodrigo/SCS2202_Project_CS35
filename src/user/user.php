<?php
    require_once("../../src/general/reservation.php");
class User implements JsonSerializable{
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
        `email_address`,
        `password`, 
        `user_role`,
        `is_active`) 
        VALUES 
        ('%s','%s','%s','%s','user', '%s')",
        $database -> real_escape_string($this -> userID),
        $database -> real_escape_string($this -> username),
        $database -> real_escape_string($this -> emailAddress),
        $database -> real_escape_string($this -> password),
        $database -> real_escape_string($this -> isactive))); 

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
        `gender`, 
        `home_address`, 
        `contact_num`, 
        `birthday`, 
        `register_date`, 
        `height`, 
        `weight`,
        `profile_photo`) 
        VALUES 
        ('%s','%s','%s','%s','%s','%s','%s','%s', NULLIF('%s', ''), NULLIF('%s', ''), NULLIF('%s', 'NULL'))",
        $database -> real_escape_string($this -> userID),
        $database -> real_escape_string($this -> firstName),
        $database -> real_escape_string($this -> lastName),
        $database -> real_escape_string($this -> gender),
        $database -> real_escape_string($this -> homeAddress),
        $database -> real_escape_string($this -> contactNum),
        $database -> real_escape_string($this -> dateOfBirth),
        $database -> real_escape_string($this -> registeredDate),
        $database -> real_escape_string($this -> height),
        $database -> real_escape_string($this -> weight),
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
                ('%s','%s')", 
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
        $sql = sprintf("SELECT `user_id`, 
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
        $this -> userID = $rows -> user_id;  
        
        //get the profile pic from the datbase and store in the object's attribute
        $sqlPic = sprintf("SELECT `profile_photo` 
        FROM `user` 
        WHERE `user_id` = '%s'",
        $database -> real_escape_string($this -> userID));

        $result = $database -> query($sqlPic);
        $picRow = $result -> fetch_object();
        if($picRow === NULL){
            $this -> profilePic = '';
        }
        else{
            $this -> profilePic =  $picRow -> profile_photo;
        }
        //$this -> getProfilePic();  
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
        while($row = $sportResult -> fetch_assoc()){    //sports found, traverse the table  //request status = a -> court is active, request status = p -> court request of receptionist (pending request)
            $courtBranchSql = sprintf("SELECT DISTINCT `branch_id`   
            FROM `sports_court`
            WHERE `sport_id` 
            LIKE '%s'
            AND
            `request_status` = 'a'", $database -> real_escape_string($row['sport_id'])); //find the branches with the searched sports (per sport)
            $branchResult = $database -> query($courtBranchSql);

            while($branchRow = $branchResult -> fetch_object()){   //getting all the branches
                $branch = $branchRow -> branch_id;

                array_push($result, ['branch' => $branch, 'sport_name' => $row['sport_name'], 'sport_id' => $row['sport_id'], 'reserve_price' => $row['reservation_price']]); //create a branch sport pair
            }
        }
        if(count($result) === 0){   //couldn't find any branch that provide the searched sport
            return ['errMsg' => "Sorry, Cannot find what you are looking For"];
        }

        return $result;
    }

    public function makeReservation($date, $st, $et, $people, $payment, $court, $database){
        $result = $court -> createReservation($this -> userID, $date, $st, $et, $payment, $people, $database);
        return $result;
    }

    public function getReservationHistory($database){   //Joining sport, sport court, branch, reservation tables
        //get all the reservations
        $sql = sprintf("SELECT `reservation_id`
        FROM `reservation`
        WHERE `user_id` = '%s'
        ORDER BY `date`",
        $database -> real_escape_string($this -> userID));

        $result = $database -> query($sql);

        $reservations = [];
        while($row = $result -> fetch_object()){
            $reservationID = $row -> reservation_id;
            $currReservation = new Reservation();
            $currReservation -> setID($reservationID);

/*             $startingTime = $row -> starting_time;
            $endingTime = $row -> ending_time; */

            //$row -> {"time_period"} = $startingTime . " to " . $endingTime;
            $currReservation -> getDetails($database);  //get the reservation details

            array_push($reservations, $currReservation);
            unset($currReservation);
            unset($row);
        }
        $result -> free_result();
        return $reservations;
    }

    public function cancelReservation($reservation, $database){
        $result = $reservation -> cancelReservation($this ->userID, $database);
        return $result;
    }

    public function getProfileDetails($database){   //get the profile details and store in the object
        $detailsSql = sprintf("SELECT * FROM `user` WHERE `user_id` = '%s'", $database -> real_escape_string($this -> userID)); //user details

        $loginSql = sprintf("SELECT * FROM `login_details` WHERE `user_id` = '%s'", $database -> real_escape_string($this -> userID));  //login details

        $medicalConcernsSql = sprintf("SELECT `medical_concern` FROM `user_medical_concern` WHERE `user_id` = '%s'", $database -> real_escape_string($this -> userID)); //medical concerns

        $dependentsSql = sprintf("SELECT `name`,`relationship`,`contact_num` FROM `user_dependent` WHERE `owner_id` = '%s'", $database -> real_escape_string($this -> userID)); //user dependents

        $detailsResult = $database -> query($detailsSql);
        $detailsrow = $detailsResult -> fetch_object();

        $loginResult = $database -> query($loginSql);
        $loginrow = $loginResult -> fetch_object();

        $medicalConcernResult = $database -> query($medicalConcernsSql);
        $medicalConcernsArr = $medicalConcernResult -> fetch_all(MYSQLI_ASSOC);

        $dependentResult = $database -> query($dependentsSql);
        $dependentArr = $dependentResult -> fetch_all(MYSQLI_ASSOC);


        //set details
        $this -> setDetails(
            fName: $detailsrow -> first_name,
            lName: $detailsrow -> last_name,
            gender: $detailsrow -> gender,
            address: $detailsrow -> home_address,
            contactNo: $detailsrow -> contact_num,
            dob: $detailsrow -> birthday,
            height: $detailsrow -> height,
            weight: $detailsrow -> weight,
            email: $loginrow -> email_address,
            password: $loginrow -> password,
            username: $loginrow -> username,
            medicalConcerns: $medicalConcernsArr,
            dependents: $dependentArr);

        $this -> setProfilePic($detailsrow -> profile_photo);   //set profile pic

        $detailsResult -> free_result();    //free the query results
        $medicalConcernResult -> free_result();
        $dependentResult -> free_result();
        $loginResult -> free_result();
    }

    public function jsonSerialize(){    //to json encode
        return [
            'username' => $this -> username,
            'password' => $this -> password,
            'fName' => $this -> firstName,
            'lName' => $this -> lastName,
            'homeAddress' => $this -> homeAddress,
            'gender' => $this -> gender,
            'dob' => $this -> dateOfBirth,
            'height' => $this -> height,
            'weight' => $this -> weight,
            'profilePic' => $this -> profilePic,
            'email' => $this -> emailAddress,
            'contactNo' => $this -> contactNum,
            'medicalConcerns' => $this -> medicalConcerns,
            'dependents' => $this -> dependents
        ];
    }
}
?>