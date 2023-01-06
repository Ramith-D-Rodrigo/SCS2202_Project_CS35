<?php
    require_once("../../src/general/reservation.php");
    require_once("../../src/general/actor.php");

class User extends Actor implements JsonSerializable{
    private $firstName;
    private $lastName;
    private $homeAddress;
    private $contactNum;
    private $height;
    private $weight;
    private $registeredDate;
    private $dateOfBirth;
    private $dependents;
    private $medicalConcerns;
    private $gender;
    private $isactive;
    private $profilePic;

    public function __construct($actor = null){
        if($actor !== null){
            $this -> userID = $actor -> getUserID();
            $this -> username = $actor -> getUsername();
        }
        require("dbconnection.php");   //get the user connection to the db
        $this -> connection = $connection;
    }

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
        $sqlPic = sprintf("SELECT `profile_photo` 
        FROM `user` 
        WHERE `user_id` = '%s'",
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sqlPic);
        $picRow = $result -> fetch_object();
        if($picRow === NULL){
            $this -> profilePic = '';
        }
        else{
            $this -> profilePic =  $picRow -> profile_photo;
        }
        return $this -> profilePic;
    }

    private function create_login_details_entry(){   //first we createe the log in details entry
        $result = $this -> connection -> query(sprintf("INSERT INTO `login_details`
        (`user_id`, 
        `username`, 
        `email_address`,
        `password`, 
        `user_role`,
        `is_active`) 
        VALUES 
        ('%s','%s','%s','%s','user', '%s')",
        $this -> connection -> real_escape_string($this -> userID),
        $this -> connection -> real_escape_string($this -> username),
        $this -> connection -> real_escape_string($this -> emailAddress),
        $this -> connection -> real_escape_string($this -> password),
        $this -> connection -> real_escape_string($this -> isactive))); 

/*         if ($result === TRUE) {
            echo "New log in details record created successfully<br>";
        }
        else{
            echo "Error<br>";
        } */
        return $result;
    }

    private function create_user_entry(){  //Create entry in user table
        $result = $this -> connection -> query(sprintf("INSERT INTO `user`
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
        $this -> connection -> real_escape_string($this -> userID),
        $this -> connection -> real_escape_string($this -> firstName),
        $this -> connection -> real_escape_string($this -> lastName),
        $this -> connection -> real_escape_string($this -> gender),
        $this -> connection -> real_escape_string($this -> homeAddress),
        $this -> connection -> real_escape_string($this -> contactNum),
        $this -> connection -> real_escape_string($this -> dateOfBirth),
        $this -> connection -> real_escape_string($this -> registeredDate),
        $this -> connection -> real_escape_string($this -> height),
        $this -> connection -> real_escape_string($this -> weight),
        $this -> connection -> real_escape_string($this -> profilePic))); 

        return $result;
/*         if ($result === TRUE) {
            echo "New user record created successfully<br>";
        }
        else{
            echo "Error<br>";
        } */
    }

    private function create_user_dependents(){ //Create entries for all the user dependents
        $flag = TRUE;
        foreach($this -> dependents as $dependent){
            $result = $dependent -> create_entry($this -> connection);
            if($result === FALSE){
                return FALSE;
            }
        }
        return $flag;
    }

    private function create_user_medicalConcerns(){
        $flag = TRUE;
        if(count($this -> medicalConcerns) != 0){   //has medical concerns
            foreach($this -> medicalConcerns as $i){
                $result = $this -> connection -> query(sprintf("INSERT INTO `user_medical_concern`
                (`user_id`, 
                `medical_concern`) 
                VALUES 
                ('%s','%s')", 
                $this -> connection -> real_escape_string($this -> userID),
                $this -> connection -> real_escape_string($i)));

                if ($result === FALSE) {    //got an error
                    return FALSE;
                }
            }
        }
        return $flag;
    }

    public function registerUser(){    //public function to register the user
        $this -> registeredDate = date("Y-m-d");
        $this -> isactive = 0;  //still pending, has to verify using the email
        $loginEntry = $this -> create_login_details_entry();
        $userEntry = $this -> create_user_entry();
        $medicalConcernEntry = $this -> create_user_medicalConcerns(); 
        $dependentEntry = $this -> create_user_dependents(); //finally, create the entries for the dependents

        if($loginEntry  === TRUE && $userEntry  === TRUE && $medicalConcernEntry  === TRUE && $dependentEntry === TRUE){    //all has to be true (successfully registered)
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    //deleting user entries functions

    private function delete_login_details_entry(){  //delete login details entry
        $result = $this -> connection -> query(sprintf("DELETE FROM `login_details`
        WHERE `user_id` = '%s'",
        $this -> connection -> real_escape_string($this -> userID))); 

        return $result;
    }

    private function delete_user_entry(){  //Delete entry in user table
        $result = $this -> connection -> query(sprintf("DELETE FROM `user`
        WHERE `user_id` = '%s'",
        $this -> connection -> real_escape_string($this -> userID))); 

        return $result;
    }

    private function delete_user_medicalConcerns(){ //Delete entries for the user medical concerns
        $flag = TRUE;
        if(count($this -> medicalConcerns) != 0){   //has medical concerns
            foreach($this -> medicalConcerns as $i){
                $result = $this -> connection -> query(sprintf("DELETE FROM `user_medical_concern`
                WHERE `user_id` = '%s' AND `medical_concern` = '%s'",
                $this -> connection -> real_escape_string($this -> userID),
                $this -> connection -> real_escape_string($i)));

                if ($result === FALSE) {    //got an error
                    return FALSE;
                }
            }
        }
        return $flag;
    }

    private function delete_user_dependents(){  //Delete entries for all the user dependents
        $flag = TRUE;
        foreach($this -> dependents as $dependent){
            $result = $dependent -> delete_entry($this -> connection);
            if($result === FALSE){
                return FALSE;
            }
        }
        return $flag;
    }

    public function deleteUser(){   //we need to delete in the reverse order
        $dependentEntry = $this -> delete_user_dependents();
        if($dependentEntry == FALSE){  //coudln't delete the dependents
            return FALSE;
        }

        $medicalConcernEntry = $this -> delete_user_medicalConcerns();
        if($medicalConcernEntry == FALSE){ //coudln't delete the medical concerns
            return FALSE;
        }

        $userEntry = $this -> delete_user_entry();
        if($userEntry == FALSE){   //coudln't delete the user entry
            return FALSE;
        }

        $loginEntry = $this -> delete_login_details_entry();
        if($loginEntry == FALSE){  //coudln't delete the login details
            return FALSE;
        }

        return TRUE;
    }

    public function activateAccount(){
        $this -> isactive = 1;
        $sql = sprintf("UPDATE `login_details` SET `is_active` = '%s' WHERE `user_id` = '%s'",
        $this -> connection -> real_escape_string($this -> isactive),
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sql);
        
        if($result === FALSE){
            return FALSE;
        }
        return TRUE;
    }

    public function searchSport($sportName){
        $sportSql = sprintf("SELECT `sport_id`,
        `sport_name`,
        `reservation_price`
        FROM `sport` 
        WHERE `sport_name` 
        LIKE '%%%s%%'", //to escape % in sprintf, we need to add % again
        $this -> connection -> real_escape_string($sportName));

        $sportResult = $this -> connection -> query($sportSql);   //get the sports results

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
            `request_status` = 'a'", $this -> connection -> real_escape_string($row['sport_id'])); //find the branches with the searched sports (per sport)
            $branchResult = $this -> connection -> query($courtBranchSql);

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

    public function makeReservation($date, $st, $et, $people, $payment, $court){
        $result = $court -> createReservation($this -> userID, $date, $st, $et, $payment, $people, $this -> connection);
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

    public function getProfileDetails($wantedProperty = ''){   //get the profile details and store in the object
        if($wantedProperty !== ''){ //when needed only single property
            $detailsSql = sprintf("SELECT `%s` FROM `user` WHERE `user_id` = '%s'", 
            $this -> connection -> real_escape_string($wantedProperty), 
            $this -> connection -> real_escape_string($this -> userID)); //user details

            $result = $this -> connection -> query($detailsSql);
            $resultObj = $result -> fetch_object();
            $returnVal = $resultObj -> {$wantedProperty};
            $result -> free_result();
            unset($resultObj);
            return $returnVal;
        }

        $detailsSql = sprintf("SELECT * FROM `user` WHERE `user_id` = '%s'", $this -> connection -> real_escape_string($this -> userID)); //user details

        $loginSql = sprintf("SELECT * FROM `login_details` WHERE `user_id` = '%s'", $this -> connection -> real_escape_string($this -> userID));  //login details

        $medicalConcernsSql = sprintf("SELECT `medical_concern` FROM `user_medical_concern` WHERE `user_id` = '%s'", $this -> connection -> real_escape_string($this -> userID)); //medical concerns

        $dependentsSql = sprintf("SELECT `name`,`relationship`,`contact_num` FROM `user_dependent` WHERE `owner_id` = '%s'", $this -> connection -> real_escape_string($this -> userID)); //user dependents

        $detailsResult = $this -> connection -> query($detailsSql);
        $detailsrow = $detailsResult -> fetch_object();

        $loginResult = $this -> connection -> query($loginSql);
        $loginrow = $loginResult -> fetch_object();

        $medicalConcernResult = $this -> connection -> query($medicalConcernsSql);
        $medicalConcernsArr = $medicalConcernResult -> fetch_all(MYSQLI_ASSOC);

        $dependentResult = $this -> connection -> query($dependentsSql);
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

    public function jsonSerialize() : mixed{    //to json encode
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