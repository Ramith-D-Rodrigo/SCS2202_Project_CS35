<?php
    session_start();
    require_once("../../src/user/user.php");
    require_once("../../src/user/user_dependent.php");
    require_once("../../src/general/security.php");

    $editableFields = ['contactNo', 
    'height', 
    'weight', 
    'homeAddress', 
    'profilePic',  
    'medical_concern1', 
    'medical_concern2', 
    'medical_concern3', 
    'medical_concern4', 
    'medical_concern5',
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
            if($field == "contactNo"){  // contact number validation
                if(!preg_match("/^[0-9]{10,11}$/", $_POST[$field])){
                    $returnMsg["errMsg"] = "Invalid Contact Number";
                    $validationErrFlag = true;
                    break;
                }
                $arr['contactNum'] = $_POST[$field];
            }
            else if($field == 'height'){    // height validation
                //floating point number regex
                if(!preg_match("/^\d*\.?\d*$/", $_POST[$field])){
                    if($_POST[$field] == ''){
                        $flag = $editingUser -> isStudent();   //to check if user is student (students cannot remove height and weight)

                        if($flag == true){
                            $returnMsg["errMsg"] = "You cannot change your height and weight as you are a student";
                            $validationErrFlag = true;
                            break;
                        }
                    }
                    else{
                        $returnMsg["errMsg"] = "Invalid Height";
                        $validationErrFlag = true;
                        break;
                    }
                }
                $arr['height'] = $_POST[$field];
            }
            else if($field == 'weight'){    // weight validation
                if(!preg_match("/^\d*\.?\d*$/", $_POST[$field])){
                    if($_POST[$field] == ''){
                        $flag = $editingUser -> isStudent();   //to check if user is student (students cannot remove height and weight)
                        if($flag == true){
                            $returnMsg["errMsg"] = "You cannot change your height and weight as you are a student";
                            $validationErrFlag = true;
                            break;
                        }
                    }
                    else{
                        $returnMsg["errMsg"] = "Invalid Weight";
                        $validationErrFlag = true;
                        break;
                    }
                }
                $arr['weight'] = $_POST[$field];
            }
            else if($field === 'medical_concern1' || $field === 'medical_concern2' || $field === 'medical_concern3' || $field === 'medical_concern4' || $field === 'medical_concern5' || $field === 'name1' || $field === 'name2' || $field === 'name3'){   // medical concerns validation and emergency name validation
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
        if($_FILES['profilePic']['size'] > 2097152){ //image size is greater than 1MB
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
                
                move_uploaded_file($pic, '../../public/user/profile_images/'.$picNewName);  //move the file to this directory
                $arr['profilePic'] = '../../public/user/profile_images/'.$picNewName;

                //delete the old profile picture
                $oldPic = $editingUser -> getProfilePic();
                if($oldPic != ''){  //if the user has a profile picture
                    unlink($oldPic);
                }
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
        $medicalConcerns = null;
    }
    else{
        for($i = 1; $i <= 5; $i++){
            if(isset($_POST['medical_concern'.$i])){    //the medical concern exists
                array_push($medicalConcerns, $_POST['medical_concern'.$i]);
            }
        }
    }

    $arr['medicalConcerns'] = $medicalConcerns;
    $arr['dependents'] = $userDependents;

    $editingUser -> editProfile($arr);  //edit the user profile

    


?>