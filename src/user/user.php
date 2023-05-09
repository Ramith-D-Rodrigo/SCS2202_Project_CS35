<?php
    require_once("../../src/general/reservation.php");
    require_once("../../src/general/actor.php");
    require_once("../../src/coach/coaching_session.php");
    require_once("../../controller/CONSTANTS.php");
    require_once("../../src/general/sport_court.php");

class User extends Actor implements JsonSerializable{
    private $firstName;
    private $lastName;
    private $homeAddress;
    private $contactNum;
    private $height;
    private $weight;
    private $registerDate;
    private $birthday;
    private $dependents;
    private $medicalConcerns;
    private $gender;
    private $profilePhoto;

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
        $this -> birthday = $dob;
        $this -> height = $height;
        $this -> weight = $weight;
        $this -> medicalConcerns = $medicalConcerns;
        $this -> dependents = $dependents;
        $this -> username = $username;
        $this -> password = $password;
        $this -> gender = $gender;
    }

    public function setProfilePic($profilePic){
        $this -> profilePhoto = $profilePic;
    }

    public function getProfilePic(){
        $sqlPic = sprintf("SELECT `profilePhoto`
        FROM `user`
        WHERE `userID` = '%s'",
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sqlPic);
        $picRow = $result -> fetch_object();
        if($picRow === NULL){
            $this -> profilePhoto = '';
        }
        else{
            $this -> profilePhoto =  $picRow -> profilePhoto;
        }
        return $this -> profilePhoto;
    }

    private function create_login_details_entry(){   //first we createe the log in details entry
        $result = $this -> connection -> query(sprintf("INSERT INTO `login_details`
        (`userID`,
        `username`,
        `emailAddress`,
        `password`,
        `userRole`,
        `isActive`)
        VALUES
        ('%s','%s','%s','%s','user', '%s')",
        $this -> connection -> real_escape_string($this -> userID),
        $this -> connection -> real_escape_string($this -> username),
        $this -> connection -> real_escape_string($this -> emailAddress),
        $this -> connection -> real_escape_string($this -> password),
        $this -> connection -> real_escape_string($this -> isActive)));

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
        (`userID`,
        `firstName`,
        `lastName`,
        `gender`,
        `homeAddress`,
        `contactNum`,
        `birthday`,
        `registerDate`,
        `height`,
        `weight`,
        `profilePhoto`)
        VALUES
        ('%s','%s','%s','%s','%s','%s','%s','%s', NULLIF('%s', ''), NULLIF('%s', ''), NULLIF('%s', 'NULL'))",
        $this -> connection -> real_escape_string($this -> userID),
        $this -> connection -> real_escape_string($this -> firstName),
        $this -> connection -> real_escape_string($this -> lastName),
        $this -> connection -> real_escape_string($this -> gender),
        $this -> connection -> real_escape_string($this -> homeAddress),
        $this -> connection -> real_escape_string($this -> contactNum),
        $this -> connection -> real_escape_string($this -> birthday),
        $this -> connection -> real_escape_string($this -> registerDate),
        $this -> connection -> real_escape_string($this -> height),
        $this -> connection -> real_escape_string($this -> weight),
        $this -> connection -> real_escape_string($this -> profilePhoto)));

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
                (`userID`,
                `medicalConcern`)
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
        $this -> registerDate = date("Y-m-d");
        $this -> isActive = 0;  //still pending, has to verify using the email
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
        WHERE `userID` = '%s'",
        $this -> connection -> real_escape_string($this -> userID)));

        return $result;
    }

    private function delete_user_entry(){  //Delete entry in user table
        $result = $this -> connection -> query(sprintf("DELETE FROM `user`
        WHERE `userID` = '%s'",
        $this -> connection -> real_escape_string($this -> userID)));

        return $result;
    }

    private function delete_user_medicalConcerns(){ //Delete entries for the user medical concerns
        $flag = TRUE;
        if(count($this -> medicalConcerns) != 0){   //has medical concerns
            foreach($this -> medicalConcerns as $i){
                $result = $this -> connection -> query(sprintf("DELETE FROM `user_medical_concern`
                WHERE `userID` = '%s' AND `medicalConcern` = '%s'",
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

    public function searchSport($sportName){
        $sportSql = sprintf("SELECT `sportID`,
        `sportName`,
        `reservationPrice`
        FROM `sport`
        WHERE `sportName`
        LIKE '%%%s%%'", //to escape % in sprintf, we need to add % again
        $this -> connection -> real_escape_string($sportName));

        $sportResult = $this -> connection -> query($sportSql);   //get the sports results

        if($sportResult -> num_rows === 0){ //no such sport found
            return ['errMsg' => "Sorry, Cannot find what you are looking For"];
        }

        $branchResultArr = [];
        $coachResultArr = [];

        while($row = $sportResult -> fetch_assoc()){    //sports found, traverse the table  //request status = a -> court is active, request status = p -> court request of manager (pending request)
            $courtBranchSql = sprintf("SELECT DISTINCT `branchID`
            FROM `sports_court`
            WHERE `sportID`
            LIKE '%s'
            AND
            `requestStatus` = 'a'", $this -> connection -> real_escape_string($row['sportID'])); //find the branches with the searched sports (per sport)
            $branchResult = $this -> connection -> query($courtBranchSql);

            while($branchRow = $branchResult -> fetch_object()){   //getting all the branches
                $branch = $branchRow -> branchID;

                array_push($branchResultArr, ['branch' => $branch, 'sportName' => $row['sportName'], 'sportID' => $row['sportID'], 'reservationPrice' => $row['reservationPrice']]); //create a branch sport pair
                unset($branchRow);
            }

            $coachSql = sprintf("SELECT `coachID`
            FROM `coach`
            WHERE `sport` = '%s'",
            $this -> connection -> real_escape_string($row['sportID']));

            $coachResult = $this -> connection -> query($coachSql);
            while($coachRow = $coachResult -> fetch_object()){
                array_push($coachResultArr, ['coachID' => $coachRow -> coachID, 'sportName' => $row['sportName'], 'sportID' => $row['sportID']]); //create a coach sport pair
                unset($coachRow);
            }

            unset($row);
        }
        if(count($branchResultArr) === 0 && count($coachResultArr) === 0){   //couldn't find any branch that provide the searched sport (also coaches)
            return ['errMsg' => "Sorry, Cannot find what you are looking For"];
        }
        $result = array('branches' => $branchResultArr, 'coaches' => $coachResultArr);
        return $result;
    }

    public function makeReservation($date, $st, $et, $people, $payment, $chargeID, Sports_Court $court){
        $result = $court -> createReservation($this -> userID, $date, $st, $et, $payment, $people, $chargeID, $this -> connection);
        return $result; //an array
    }

    public function getReservationHistory(){   //Joining sport, sport court, branch, reservation tables
        //get all the reservations
        $sql = sprintf("SELECT `reservationID`
        FROM `reservation`
        WHERE `userID` = '%s'
        ORDER BY `date` DESC",
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sql);

        $reservations = [];
        while($row = $result -> fetch_object()){
            $reservationID = $row -> reservationID;
            $currReservation = new Reservation();
            $currReservation -> setID($reservationID);

/*             $startingTime = $row -> starting_time;
            $endingTime = $row -> ending_time; */

            //$row -> {"time_period"} = $startingTime . " to " . $endingTime;
            $currReservation -> getDetails($this -> connection, ['date', 'startingTime', 'endingTime', 'status', 'reservedDate', 'paymentAmount']);  //get the reservation details

            array_push($reservations, $currReservation);
            unset($currReservation);
            unset($row);
        }
        $result -> free_result();
        return $reservations;
    }

    public function cancelReservation($reservation){
        $result = $reservation -> cancelReservation($this -> userID, $this -> connection);
        return $result;
    }

    public function getProfileDetails($wantedColumns = []){   //get the profile details and store in the object
        if($wantedColumns !== []){  //if the user wants to get specific columns
            $wantedColumns = implode(", ", $wantedColumns);
            $sql = sprintf("SELECT %s FROM `user` WHERE `userID` = '%s'", $wantedColumns, $this -> connection -> real_escape_string($this -> userID));
            $result = $this -> connection -> query($sql);

            $row = $result -> fetch_object();

            $result -> free_result();

            foreach($row as $key => $value){
                $this -> $key = $value;
            }
            return $this;
        }

        $detailsSql = sprintf("SELECT * FROM `user` WHERE `userID` = '%s'", $this -> connection -> real_escape_string($this -> userID)); //user details

        $loginSql = sprintf("SELECT * FROM `login_details` WHERE `userID` = '%s'", $this -> connection -> real_escape_string($this -> userID));  //login details

        $medicalConcernsSql = sprintf("SELECT `medicalConcern` FROM `user_medical_concern` WHERE `userID` = '%s'", $this -> connection -> real_escape_string($this -> userID)); //medical concerns

        $dependentsSql = sprintf("SELECT `name`, `relationship`, `contactNum` FROM `user_dependent` WHERE `ownerID` = '%s'", $this -> connection -> real_escape_string($this -> userID)); //user dependents

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
            fName: $detailsrow -> firstName,
            lName: $detailsrow -> lastName,
            gender: $detailsrow -> gender,
            address: $detailsrow -> homeAddress,
            contactNo: $detailsrow -> contactNum,
            dob: $detailsrow -> birthday,
            height: $detailsrow -> height,
            weight: $detailsrow -> weight,
            email: $loginrow -> emailAddress,
            username: $loginrow -> username,
            medicalConcerns: $medicalConcernsArr,
            dependents: $dependentArr);

        $this -> setProfilePic($detailsrow -> profilePhoto);   //set profile pic

        $detailsResult -> free_result();    //free the query results
        $medicalConcernResult -> free_result();
        $dependentResult -> free_result();
        $loginResult -> free_result();
    }

    public function isStudent(){    //check if the user is a student
        $sql = sprintf("SELECT `stuID` FROM `student` WHERE  `stuID` = '%s'", $this -> connection -> real_escape_string($this -> userID));
        $result = $this -> connection -> query($sql);
        if($result -> num_rows === 0){  //haven't registered as a student
            return false;
        }

        //registered as a student, but he might have left all coaching sessions (resulting he is not a student anymore)

        //check for ongoing coaching sessions
        $ongoingSessions = $this -> getOngoingCoachingSessions();
        if(count($ongoingSessions) === 0){  //no ongoing coaching sessions
            return false;
        }
        return true;
    }

    public function getOngoingCoachingSessions(){   //return coaching sessions the user is attending
        $sql = sprintf("SELECT `sessionID` 
        FROM `student_registered_session` 
        WHERE `stuID` = '%s' 
        AND `leaveDate` IS NULL", $this -> connection -> real_escape_string($this -> userID));
        $result = $this -> connection -> query($sql);
        $sessionArr = [];
        while($row = $result -> fetch_object()){
            $sessionID = $row -> sessionID;
            $currSession = new Coaching_Session($sessionID);
            array_push($sessionArr, $currSession);
            unset($currSession);
            unset($row);
        }
        return $sessionArr;
    }

    public function setDetailsByProperty($propertyName, $propertyValue){   //set the details of the user
        $this -> {$propertyName} = $propertyValue;
    }

    public function editProfile($editingValArr){
        $sql = "UPDATE `user` SET";

        if(array_key_exists('medicalConcerns', $editingValArr)){    //update medical concerns
            //delete the current medical concerns
            $medicalConcernDeleteSql = sprintf("DELETE FROM `user_medical_concern` WHERE `userID` = '%s'", $this -> connection -> real_escape_string($this -> userID));
            $medicalConcernDeleteResult = $this -> connection -> query($medicalConcernDeleteSql);
            if($medicalConcernDeleteResult === false){
                return false;
            }

            if($editingValArr['medicalConcerns'] !== "removeAll"){ //the user is changing the medical concerns
                //insert the new medical concerns
                if(!empty($editingValArr['medicalConcerns'])){  //the user has new medical concerns to enter
                    foreach($editingValArr['medicalConcerns'] as $medicalConcern){
                        $medicalConcernInsertSql = sprintf("INSERT INTO `user_medical_concern` (`userID`, `medicalConcern`) VALUES ('%s', '%s')",
                        $this -> connection -> real_escape_string($this -> userID),
                        $this -> connection -> real_escape_string($medicalConcern));
            
                        $medicalConcernInsertResult = $this -> connection -> query($medicalConcernInsertSql);
                        if($medicalConcernInsertResult === false){
                            return false;
                        }
                    }
                }
            }   //otherwise no need to do anything as the user is removing all medical concerns
        }

        if(array_key_exists('dependents', $editingValArr)){     //update dependents
            //update the dependents
            //delete the current dependents
            $dependentDeleteSql = sprintf("DELETE FROM `user_dependent` WHERE `ownerID` = '%s'", $this -> connection -> real_escape_string($this -> userID));
            $dependentDeleteResult = $this -> connection -> query($dependentDeleteSql);
            if($dependentDeleteResult === false){
                return false;
            }

            //insert the new dependents
            foreach($editingValArr['dependents'] as $dependent){    //dependent cannot be null array as there is always at least one dependent
                $dependentInsertResult = $dependent -> create_entry($this -> connection);   //call user dependent object create function
                if($dependentInsertResult === false){
                    return false;
                }
            }
        }           
        //if the user is editing other details
        //create the update query for user profile details
        foreach($editingValArr as $key => $value){  //set the details of the user
            $this -> {$key} = $value;
            if($key === 'medicalConcerns' || $key === 'dependents'){
                //delete key value pair from the array
                unset($editingValArr[$key]);
                continue;
            }
            $sql .= sprintf(" `%s` = NULLIF('%s', ''),", $key, $this -> connection -> real_escape_string($value));
        }

        if(sizeof($editingValArr) === 0){   //no need to update the user profile (only have medical concerns and dependents)
            return true;
        }

        $sql = substr($sql, 0, -1); //remove the last comma
        $sql .= sprintf(" WHERE `userID` = '%s'", $this -> connection -> real_escape_string($this -> userID));
        
        $result = $this -> connection -> query($sql);
        if($result === false){
            return false;
        }
        
        return true;    //successfully update the profile
    }

    public function getPendingCoachingSessionRequests(){   //function to get coaching sessions that are requested by the user (returns an array of sessionIDs)
        $sql = sprintf("SELECT `sessionID` FROM `user_request_coaching_session` 
        WHERE `userID` = '%s'", 
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sql);
        
        $requestArr = [];
        while($row = $result -> fetch_object()){
            $sessionID = $row -> sessionID;
            $tempSession = new Coaching_Session($sessionID);
            array_push($requestArr, $tempSession);
            unset($row);
        }
        return $requestArr;
    }

    public function getLeftCoachingSessions(){
        $sql = sprintf("SELECT `sessionID` FROM `student_registered_session` 
        WHERE `stuID` = '%s'
        AND `leaveDate` IS NOT NULL",
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sql);

        $sessionArr = [];
        while($row = $result -> fetch_object()){
            $sessionID = $row -> sessionID;
            $tempSession = new Coaching_Session($sessionID);
            array_push($sessionArr, $tempSession);
            unset($row);
        }

        return $sessionArr;
    }

    public function requestCoachingSession($sessionObj, $message){
        date_default_timezone_set(SERVER_TIMEZONE);
        $date = date('Y-m-d');   
        
        $notificationID = uniqid("notReq".substr($this -> userID, 0, 3));

        //send a notification to the coach
        //add the notification first because the notificationID is needed to add the request (foreign key)
        require_once("../../src/general/notification.php");
        $requestNotification = new Notification($notificationID);

        $sessionCoach = $sessionObj -> getCoach($this -> connection);

        $notDescription = "You have a new request from an user to join your Coaching Session. Please check your Coaching Session Requests to accept or reject the request.";
        

        $requestNotification -> setDetails(subject : "New Student Request",
            status : "Unread",
            description : $notDescription,
            date : date("Y-m-d"),
            userID : $sessionCoach -> getUserID());

        $requestNotification -> setNotificationEntry($this -> connection);

        
        $sql = sprintf("INSERT INTO `user_request_coaching_session` 
        (`userID`, `sessionID`, `message`, `requestDate`, `notificationID`) 
        VALUES ('%s', '%s', NULLIF('%s', ''), '%s', '%s')",
        $this -> connection -> real_escape_string($this -> userID),
        $this -> connection -> real_escape_string($sessionObj -> getSessionID()),
        $this -> connection -> real_escape_string($message),
        $this -> connection -> real_escape_string($date),
        $this -> connection -> real_escape_string($notificationID));

        $result = $this -> connection -> query($sql);
        if($result === false){
            return false;
        }

        return true;
    }

    public function cancelCoachingSessionRequest($sessionObj){
        //first get the notificationID of the request
        $sql = sprintf("SELECT `notificationID` FROM `user_request_coaching_session` 
        WHERE `userID` = '%s'
        AND `sessionID` = '%s'",
        $this -> connection -> real_escape_string($this -> userID),
        $this -> connection -> real_escape_string($sessionObj -> getSessionID()));

        $result = $this -> connection -> query($sql);
        $row = $result -> fetch_object();
        $notificationID = $row -> notificationID;

        //delete the session request
        $sql = sprintf("DELETE FROM `user_request_coaching_session` 
        WHERE `userID` = '%s'
        AND `sessionID` = '%s'",
        $this -> connection -> real_escape_string($this -> userID),
        $this -> connection -> real_escape_string($sessionObj -> getSessionID()));

        $result = $this -> connection -> query($sql);
        if($result === false){
            return false;
        }

        //delete the notification
        require_once("../../src/general/notification.php");
        $notification = new Notification($notificationID);
        $notification -> deleteNotification($this -> connection);
        return true;
    }

    public function leaveCoachingSession($sessionObj){
        date_default_timezone_set(SERVER_TIMEZONE);
        $date = date('Y-m-d');
        $sql = sprintf("UPDATE `student_registered_session` 
        SET `leaveDate` = '%s'
        WHERE `stuID` = '%s'
        AND `sessionID` = '%s'",
        $this -> connection -> real_escape_string($date),
        $this -> connection -> real_escape_string($this -> userID),
        $this -> connection -> real_escape_string($sessionObj -> getSessionID()));

        $result = $this -> connection -> query($sql);
        if($result === false){
            return false;
        }
        return true;
    }

    public function giveFeedback($feedbackObj, $feedbackOwner, $feedback, $rating){ //generalized function to give feedback to coach or branch
        if(get_class($feedbackObj) === 'Coaching_Session'){ //the user is giving feedback to a coach
            return $this -> giveCoachFeedback($feedbackObj, $feedbackOwner, $feedback, $rating);
        }
        else if(get_class($feedbackObj) === 'Reservation'){  //the user is giving feedback to a branch
            return $this -> giveBranchFeedback($feedbackObj, $feedbackOwner, $feedback, $rating);
        }
        else{
            return false;
        }
    }

    private function giveCoachFeedback($feedbackObj, $feedbackOwner, $feedback, $rating){ //give feedback to a coach
        $feedbackID = uniqid('coachFB');

        $sql = sprintf("INSERT INTO `student_coach_feedback` 
            (`feedbackID`, `stuID`, `coachID`, `description`, `rating`, `date`)
            VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
            $this -> connection -> real_escape_string($feedbackID),
            $this -> connection -> real_escape_string($this -> userID),
            $this -> connection -> real_escape_string($feedbackOwner -> getUserID()),   //feedback owner is the coach
            $this -> connection -> real_escape_string($feedback),
            $this -> connection -> real_escape_string($rating),
            $this -> connection -> real_escape_string(date('Y-m-d')));

        $result = $this -> connection -> query($sql);
        if($result === false){
            return false;
        }

        return true;
    }

    private function giveBranchFeedback($reservationObj, $branchObj, $feedback, $rating){ //give feedback to a branch
        //update the status of the reservation to let that the user has given feedback
        $updateResult = $reservationObj -> updateStatus($this -> connection, 'feedbackGiven');
        if($updateResult === false){
            return false;
        }

        //insert the feedback into the database
        $feedbackAddResult = $branchObj -> addBranchFeedback($this, $feedback, $rating, $this -> connection);
        if($feedbackAddResult === false){
            return false;
        }
        return true;
    }

    public function deactivateAccount(){
        $sql = sprintf("UPDATE `login_details` SET `isActive` = '0' WHERE `userID` = '%s'", $this -> connection -> real_escape_string($this -> userID));
        $result = $this -> connection -> query($sql);
        if($result === false){
            return false;
        }
        return true;
    }

    public function jsonSerialize() : mixed{    //to json encode
        $ObjectProperties = get_object_vars($this);
        $returnJSON = [];

        foreach($ObjectProperties as $key => $value){
            if($key === 'connection'){
                continue;
            }

            if($key === 'password'){
                continue;
            }

            if(!isset($value)){
                continue;
            }
            $returnJSON[$key] = $value;
        }

        return $returnJSON;
    }
}
?>
