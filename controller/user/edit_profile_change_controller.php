<?php
    //this script is used to edit the user profile
    session_start();
    require_once("../../src/user/user.php");
    require_once("../../src/user/user_dependent.php");
    require_once("../../src/general/security.php");
    require_once("../../config.php");

    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){
        Security::redirectUserBase();
        die();
    }

    //server request method check
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        http_response_code(405);
        die();
    }
    

    $editableFields = ['contactNum', 
    'height', 
    'weight', 
    'homeAddress', 
    'profilePic',  
    'medicalConcern1', 
    'medicalConcern2', 
    'medicalConcern3', 
    'medicalConcern4', 
    'medicalConcern5',
    'name1',
    'name2',
    'name3',
    'contact1',
    'contact2',
    'contact3',
    'relationship1',
    'relationship2',
    'relationship3',
    'medicalAllRemoved'];

    $relationshipFields = ["Father", "Mother", "Sibling 1", "Sibling 2", "Friend 1", "Friend 2", "Partner", "Other"];

    $allowedExtensions = ['jpg', 'jpeg', 'png'];



    $returnMsg = [];
    $validationErrFlag = false;

    $editingUser = new User();
    $editingUser -> setUserID($_SESSION['userid']);

    //user input validation and insertion

    $arr = array(); //array to store the editing primitive values like contact num, home address
    foreach($editableFields as $field){
        if(isset($_POST[$field])){  //check if field is set ( the user has inputted something)
            $_POST[$field] = trim($_POST[$field]);  //remove leading and trailing whitespace
            $_POST[$field] = htmlspecialchars($_POST[$field], ENT_QUOTES);  //convert special characters to html entities
            if($field == "contactNum"){  // contact number validation
                if(!preg_match("/^[0-9]{10,11}$/", $_POST[$field])){
                    $returnMsg["errMsg"] = "Invalid Contact Number";
                    $validationErrFlag = true;
                    break;
                }
                $arr['contactNum'] = $_POST[$field];
            }
            else if($field == 'height'){    // height validation
                if($_POST[$field] == ''){   //empty string
                    $flag = $editingUser -> isStudent();   //to check if user is student (students cannot remove height and weight)

                    if($flag == true){
                        $returnMsg["errMsg"] = "You cannot change your height and weight as you have joined for a session(s).";
                        $validationErrFlag = true;
                        break;
                    }
                    else{ //if not a student, then check for pending coaching session requests
                        $sessionRequests = $editingUser -> getPendingCoachingSessionRequests();

                        if(count($sessionRequests) != 0){   //has pending requests, thus cannot edit
                            $returnMsg["errMsg"] = "You cannot change your height and weight as you have requested for a session(s).";
                            $validationErrFlag = true;
                            break;
                        }

                    }
                }
                //floating point number regex
                if(!preg_match("/^\d*\.?\d*$/", $_POST[$field])){
                    $returnMsg["errMsg"] = "Invalid Height";
                    $validationErrFlag = true;
                    break;
                }

                $arr['height'] = $_POST[$field];
            }
            else if($field == 'weight'){    // weight validation
                if($_POST[$field] == ''){
                    $flag = $editingUser -> isStudent();   //to check if user is student (students cannot remove height and weight)
                    if($flag == true){
                        $returnMsg["errMsg"] = "You cannot change your height and weight as you are a student";
                        $validationErrFlag = true;
                        break;
                    }
                    else{ //if not a student, then check for pending coaching session requests
                        $sessionRequests = $editingUser -> getPendingCoachingSessionRequests();

                        if(count($sessionRequests) != 0){   //has pending requests, thus cannot edit
                            $returnMsg["errMsg"] = "You cannot change your height and weight as you have requested for a session(s).";
                            $validationErrFlag = true;
                            break;
                        }
                    }
                }
                if(!preg_match("/^\d*\.?\d*$/", $_POST[$field])){
                    $returnMsg["errMsg"] = "Invalid Weight";
                    $validationErrFlag = true;
                    break;
                }
                
                $arr['weight'] = $_POST[$field];
            }
            else if($field === 'medicalConcern1' || $field === 'medicalConcern2' || $field === 'medicalConcern3' || $field === 'medicalConcern4' || $field === 'medicalConcern5' || $field === 'name1' || $field === 'name2' || $field === 'name3'){   // medical concerns validation and emergency name validation
                if(!preg_match("/^[a-zA-Z ]*$/", $_POST[$field])){
                    $returnMsg["errMsg"] = "Invalid Medical Concerns / Emergency Contact Name";
                    $validationErrFlag = true;
                    break;
                }
                if(strlen($_POST[$field]) > 40){    //max is 50varchar
                    $returnMsg['errMsg'] = 'Medical Concerns/Emergency Contact Names Length Error';
                    $validationErrFlag = true;
                    break;
                }
            }
            else if($field == 'contact1' || $field == 'contact2' || $field == 'contact3'){
                if(!preg_match("/^[0-9]{10,11}$/", $_POST[$field])){
                    $returnMsg["errMsg"] = "Invalid Contact Number";
                    $validationErrFlag = true;
                    break;
                }
            }
            else if($field == 'relationship1' || $field == 'relationship2' || $field == 'relationship3'){
                if(!in_array($_POST[$field], $relationshipFields)){
                    $returnMsg["errMsg"] = "Invalid Relationship";
                    $validationErrFlag = true;
                    break;
                }
            }
            else if($field == 'homeAddress'){
                if(strlen($_POST[$field]) > 225){   //max is 250varchar
                    $returnMsg['errMsg'] = 'Home Address Length Error';
                    $validationErrFlag = true;
                    break;
                }
                $arr['homeAddress'] = $_POST[$field];
            }

        }
    }

    //profile picture upload validation
    if(!empty($_FILES['profilePic']['name'])){   //if the user uploaded a profile picture
        //check image size
        if($_FILES['profilePic']['size'] > MAX_USER_PROFILE_PICTURE_SIZE){ //image size is greater than 1MB
            $returnMsg['errMsg'] = 'Image size is too large';
            $validationErrFlag = true;
        }
        else{
            $profilePicFlag = true;
            $pic = $_FILES['profilePic']['tmp_name'];   //the image
            $picName = $_FILES['profilePic']['name'];
            $picExtension = explode('.', $picName);
    
            //check image extension
            if(!in_array(strtolower(end($picExtension)), $allowedExtensions)){  //invalid image type
                $returnMsg['RegUnsuccessMsg'] = 'Invalid image type';
                $validationErrFlag = true;
            }
            else{
                $picExtension = strtolower(end($picExtension)); //get image extension
    
                $picNewName = uniqid($editingUser -> getUsername());    //create a new name for the image
                $picNewName = $picNewName . '.' . $picExtension; //concat the extension
                
                move_uploaded_file($pic, '../../uploads/user_profile_images/'.$picNewName);  //move the file to this directory
                $arr['profilePhoto'] = '../../uploads/user_profile_images/'.$picNewName;    //profilePhoto is the column name

                //delete the old profile picture
                $oldPic = $editingUser -> getProfilePic();
                if($oldPic != ''){  //if the user has a profile picture
                    if(file_exists($oldPic)){   //if the file exists
                        $result = unlink($oldPic);    //delete the file
                        if(!$result){   //if the file cannot be deleted
                            $returnMsg['errMsg'] = 'Error Changing the Old Profile Picture';
                            $validationErrFlag = true;
                        }
                    }
                }
                //set the new profile picture in session
                $_SESSION['userProfilePic'] = $arr['profilePhoto'];
            }
        }
        
    }

    if($validationErrFlag){ //if there is a validation error, return the error message
        echo json_encode($returnMsg);
        $editingUser -> closeConnection();
        unset($editingUser);
        exit();
    }


    $userDependents = array();

    for($i = 1; $i <= 3; $i++){
        if(isset($_POST['name'.$i]) && isset($_POST['contact'.$i]) && isset($_POST['relationship'.$i])){    //the user dependent info exists
            $userDependent = new UserDependent(name: $_POST['name'.$i], contactNo: $_POST['contact'.$i], relationship: $_POST['relationship'.$i]);
            $userDependent -> setOwner($_SESSION['userid']);
            array_push($userDependents, $userDependent);
        }
    }

    $medicalConcerns = array();

    if(isset($_POST['medicalAllRemoved'])){ //if all medical concerns are removed
        $arr['medicalConcerns'] = "removeAll";  //remove all medical concerns
    }
    else{
        for($i = 1; $i <= 5; $i++){
            if(isset($_POST['medicalConcern'.$i])){    //the medical concern exists
                $concernFlag = true;
                array_push($medicalConcerns, $_POST['medicalConcern'.$i]);
            }
        }
    }

    if(sizeof($medicalConcerns) !== 0){ //has new medical concerns to add
        $arr['medicalConcerns'] = $medicalConcerns;
    }

    if(sizeof($userDependents) !== 0){  //has emergency contacts to change
        $arr['dependents'] = $userDependents;
    }
  
    $result = $editingUser -> editProfile($arr);  //edit the user profile
    if($result == true){
        $returnMsg['successMsg'] = 'Profile Edited Successfully';
        $editingUser -> closeConnection();
        unset($editingUser);
        echo json_encode($returnMsg);
        exit();
    }
    else{
        $returnMsg['errMsg'] = 'Profile Edit Unsuccessful';
        $editingUser -> closeConnection();
        unset($editingUser);
        echo json_encode($returnMsg);
        exit();
    }

?>