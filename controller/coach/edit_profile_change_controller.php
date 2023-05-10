<?php
    session_start();
    require_once("../../src/coach/coach.php");
    require_once("../../src/general/security.php");

    $editableFields = ['contactNo', 
    '', 
    '', 
    'homeAddress', 
    'profilePic'  
     ];


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