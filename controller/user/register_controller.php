<?php
    session_start();
    require_once("../../src/user/user.php");
    require_once("../../src/user/user_dependent.php");
    require_once("../../src/general/security.php");
    
    if(!Security::userAuthentication(logInCheck: TRUE)){
        Security::redirectUserBase();
        die();
    }

    //server request method check
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        http_response_code(405);
        die();
    }


    //all possible inputs for prefilling
    $inputFields = ['firstName', 'lastName', 'emailAddress', 'homeAddress', 'birthday', 'contactNum', 'username', 'gender',
     'password', 'medical_concern1', 'medical_concern2', 'medical_concern3', 'medical_concern4', 'medical_concern5', 'emgcontactNum1', 'name1', 'relationship1',
     'emgcontactNum2', 'name2', 'relationship2', 'emgcontactNum3', 'name3', 'relationship3', 'height', 'weight', 'passwordConfirm', 'user_pic'];

    //Compulsary Details
    
    //for server side validation
    $compulsaryFields = ['firstName', 'lastName', 'birthday', 'contactNum', 'homeAddress', 'gender', 
        'emailAddress', 'username', 'password', 'passwordConfirm', 'name1', 'relationship1', 'emgcontactNum1'];
/*
    $onlyLettersFields = ['firstName', 'lastName', 'medical_concern1', 'medical_concern2', 'medical_concern3', 'medical_concern4', 'medical_concern5', 'name1' , 'name2', 'name3'];

    $onlyNumbersFields = ['contactNum', 'emgcontactNum1', 'emgcontactNum2', 'emgcontactNum3', 'height', 'weight']; */

    $relationshipFields = ["Father", "Mother", "Sibling 1", "Sibling 2", "Friend 1", "Friend 2", "Partner", "Other"];

    $validationErrFlag = false;

    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    $returnMsg = [];    //to echo the json response

    foreach($inputFields as $i){    //validation
        if(isset($_POST[$i])){  //the user has entered it
            if(($i === 'firstName' || $i === 'lastName')){    //first name and last name validation
                if(!preg_match("/^[a-zA-Z]+$/", $_POST[$i])){ //doesn't match the pattern
                    $returnMsg['RegUnsuccessMsg'] = 'Name Error';
                    $validationErrFlag = true;
                    break;
                }
                else if(strlen($i) > 50){  //maximum is 100 (varchar100) but keeping it lower than 50 to make sure
                    $returnMsg['RegUnsuccessMsg'] = 'Name Length Error';
                    $validationErrFlag = true;
                    break;
                }

            }
            else if($i === 'gender'){ //gender validation
                if($_POST[$i] !== 'm' && $_POST[$i] !== 'f'){
                    $returnMsg['RegUnsuccessMsg'] = 'Gender Error';
                    $validationErrFlag = true;
                    break;
                }
            }
            else if($i === 'birthday'){ //birthday validation
                if(!strtotime($_POST[$i])){ //not a valid date
                    $returnMsg['RegUnsuccessMsg'] = 'Birthday Error';
                    $validationErrFlag = true;
                    break;
                }

                $currDate = date_create();
                $bDay = date_create($_POST[$i]);
                $diff = date_diff($currDate, $bDay);
                
                if($diff -> y < 14){    //age should be atleast 14 years
                    $returnMsg['RegUnsuccessMsg'] = 'Age Error';
                    $validationErrFlag = true;
                    break;
                }
            }
            else if($i === 'contactNum' || $i === 'emgcontactNum1' || $i === 'emgcontactNum2' || $i === 'emgcontactNum3'){
                if(!preg_match("/^[0-9]{10,11}$/", $_POST[$i])){  //doesn't match the pattern
                    $returnMsg['RegUnsuccessMsg'] = 'Contact Number Error';
                    $validationErrFlag = true;
                    break;
                }
            }
            else if($i === 'homeAddress'){
                if(strlen($_POST[$i]) > 225){ //max is varchar250 in db
                    $returnMsg['RegUnsuccessMsg'] = 'Address length Error';
                    $validationErrFlag = true;
                    break;
                }
            }
            else if($i === 'height' || $i === 'weight'){
                if($_POST[$i] !== ''){  //has entered some value
                    if(!preg_match("/^\d*\.?\d*$/", $_POST[$i])){   //doesn't match the pattern
                        $returnMsg['RegUnsuccessMsg'] = 'Height/Weight Error';
                        $validationErrFlag = true;
                        break;
                    }
                }
            }
            else if($i === 'username'){ //username validation
                if(!preg_match("/^[a-z]([a-z0-9_]){5,15}$/", $_POST[$i])){
                    $returnMsg['RegUnsuccessMsg'] = 'Username Error';
                    $validationErrFlag = true;
                    break;
                }
            }
            else if($i === 'password'){ //password validation
                if(!preg_match("/(?=.*\d)(?=.*[A-Z]).{8,}/", $_POST[$i])){
                    $returnMsg['RegUnsuccessMsg'] = 'Password Error';
                    $validationErrFlag = true;
                    break;
                }

                if($_POST[$i] !== $_POST['passwordConfirm']){   //password is not equal
                    $returnMsg['RegUnsuccessMsg'] = 'Password Not Matching Error';
                    $validationErrFlag = true;
                    break;
                }
            }
            else if($i === 'medical_concern1' || $i === 'medical_concern2' || $i === 'medical_concern3' || $i === 'medical_concern4' || $i === 'medical_concern5' || $i === 'name1' || $i === 'name2' || $i === 'name3'){
                if(!preg_match("/^[a-zA-Z ]+$/", $_POST[$i])){
                    $returnMsg['RegUnsuccessMsg'] = 'Medical Concerns/Emergency Contact Names Error';
                    $validationErrFlag = true;
                    break;
                }

                if(strlen($_POST[$i]) > 40){    //max is 50varchar
                    $returnMsg['RegUnsuccessMsg'] = 'Medical Concerns/Emergency Contact Names Length Error';
                    $validationErrFlag = true;
                    break;
                }
            }
            else if($i === 'relationship1' || $i === 'relationship2' || $i === 'relationship3'){
                if(!(in_array($_POST[$i], $relationshipFields))){   //invalid relationship
                    $returnMsg['RegUnsuccessMsg'] = 'Relationship Error';
                    $validationErrFlag = true;
                    break;
                }
            }

            $_POST[$i] = htmlspecialchars($_POST[$i], ENT_QUOTES);
        }
        else{  //user has not entered it
            if(in_array($i, $compulsaryFields)){    //a compulsary field
                $returnMsg['RegUnsuccessMsg'] = 'Compulsary Field Error';
                $validationErrFlag = true;
                break;
            }
        }
    }

    if($validationErrFlag === true){
        $returnMsg['RegUnsuccessMsg'] = $returnMsg['RegUnsuccessMsg'] . '<br>Please Enter Valid Information';
        echo json_encode($returnMsg);
        exit();
    }
    
    //Checking if the account already exists
    require_once("../../src/general/security.php");
    //email availability   
    $emailCheck = Security::checkEmailAvailability($_POST['emailAddress']);
    if($emailCheck === false){  //email is not valid
        $returnMsg['RegUnsuccessMsg'] = 'Email Address Error';
        echo json_encode($returnMsg);
        exit();
    }

    //username availability    
    $usernameCheck = Security::checkUsernameAvailability($_POST['username']);
    if($usernameCheck === false){   //username is not valid
        $returnMsg['RegUnsuccessMsg'] = 'Username Error';
        echo json_encode($returnMsg);
        exit();
    }

    //can create a account

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);    //hash the password

    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['emailAddress'], ENT_QUOTES);
    $address = htmlspecialchars($_POST['homeAddress'], ENT_QUOTES);
    $contactNo = htmlspecialchars($_POST['contactNum'], ENT_QUOTES);
    $fName = htmlspecialchars($_POST['firstName'], ENT_QUOTES);
    $lName = htmlspecialchars($_POST['lastName'], ENT_QUOTES);
    $bday = htmlspecialchars($_POST['birthday'], ENT_QUOTES);
    $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES);

    //creating userid
    $prefix1 = substr($username, 0, 3);
    $prefix2 = substr($lName, 0, 3);
    $userid = uniqid($prefix1.$prefix2);

    if(isset($_POST['height'])){
        $height = htmlspecialchars($_POST['height'], ENT_QUOTES);
    }
    else{
        $height = NULL;
    }

    if(isset($_POST['weight'])){
        $weight = htmlspecialchars($_POST['weight'], ENT_QUOTES);
    }
    else{
        $weight = NULL;
    }

    //user medical concerns
    $medical_concerns = [];

    foreach($inputFields as $i){
        if(preg_match("/medical_concern[1-5]/", $i)){   //found a match 
            if(isset($_POST[$i])){
                array_push($medical_concerns, htmlspecialchars($_POST[$i], ENT_QUOTES));
            }
        }
    }

    //user dependents
    $user_dependents = [];
    $j = 1;
    while($j <= 3){
        $name = NULL;
        $contact = NULL;
        $relationship = NULL;

        foreach($inputFields as $i){
            if(preg_match(sprintf("/name%s/",$j), $i)){   //found a match for name
                if(isset($_POST[$i])){
                    $name =  htmlspecialchars($_POST[$i], ENT_QUOTES);
                }
            }
            else if(preg_match(sprintf("/emgcontactNum%s/",$j), $i)){ //found a match for contact number
                if(isset($_POST[$i])){
                    $contact = htmlspecialchars($_POST[$i], ENT_QUOTES);
                }
            }
            else if(preg_match(sprintf("/relationship%s/",$j), $i)){ //found a match for relationship
                if(isset($_POST[$i])){
                    $relationship = htmlspecialchars($_POST[$i], ENT_QUOTES);
                }
            }
        }
        if($name !== NULL && $contact !== NULL  && $relationship !== NULL){ //there is a contact information
            $newDependent = new UserDependent($name, $relationship, $contact);  //create the dependent
            $newDependent -> setOwner($userid);     //set the user id
            array_push($user_dependents, $newDependent);    //push to the array
        }
        $j = $j + 1;
    }

    //profile picture
    $profilePicFlag = false;
/*     echo $_FILES['user_pic']['name'];
    echo "<br>";
    echo $_FILES['user_pic']['tmp_name']; */

    if(!empty($_FILES['user_pic']['name'])){    //user has uploaded a picture
        //check image size
        if($_FILES['user_pic']['size'] > 2097152){ //image size is greater than 1MB
            $returnMsg['RegUnsuccessMsg'] = 'Image size is too large';
            echo json_encode($returnMsg);
            exit();
        }
        $profilePicFlag = true;
        $pic = $_FILES['user_pic']['tmp_name'];   //the image
        $picName = $_FILES['user_pic']['name'];
        $picExtension = explode('.', $picName);

        //check image extension
        if(!in_array(strtolower(end($picExtension)), $allowedExtensions)){
            $returnMsg['RegUnsuccessMsg'] = 'Invalid image type';
            echo json_encode($returnMsg);
            exit();
        }

        $picExtension = strtolower(end($picExtension)); //get image extension

        $picNewName = uniqid($username);    //create a new name for the image
        $picNewName = $picNewName . '.' . $picExtension; //concat the extension
        
        move_uploaded_file($pic, '../../uploads/user_profile_images/'.$picNewName);  //move the file to this directory
    }

    $new_user = new User();
    $new_user -> setDetails($fName, $lName, $email, $address, $contactNo, $bday, $userid, $user_dependents, $height, $weight, $medical_concerns, $username, $password, $gender);

    if($profilePicFlag === true){    //has uploaded a profile pic
        $new_user -> setProfilePic('../../uploads/user_profile_images/'.$picNewName);    //add the directory to the profile pic
    }
    else{
        $new_user -> setProfilePic("NULL");
    }

    $result = $new_user -> registerUser();

    if($result === TRUE){   //successfully registered
        //time for email verification and account activation
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;

        //generating random code for email verification
        $mailVerificationCode = rand(100000, 999999);
        $_SESSION['mailVerificationCode'] = $mailVerificationCode;    //store the verification code in the session
        $_SESSION['verifyUserID'] = $userid;  //store the userid in the session

        require_once("../../src/general/mailer.php");

        $emailResult = Mailer::registerAccount($email, $fName . ' ' . $lName, $mailVerificationCode);    //send the email
        if($emailResult === FALSE){ //check email sent successfully or not
            $returnMsg['RegUnsuccessMsg'] = 'Error Registering the Account, Please check your email address';
    
            do{
                $deleteResult = $new_user -> deleteUser(); //delete the user
            }
            while($deleteResult != TRUE);   
            echo json_encode($returnMsg);
        }
        else{
            $returnMsg['RegSuccessMsg'] = 'An email has been sent to your email address. <br>Please verify your account using the code sent to your email address.';
            echo json_encode($returnMsg);
        }
    }
    else{
        //echo "Error Registering the Account";
        $returnMsg['RegUnsuccessMsg'] = 'Error Registering the Account';
        echo json_encode($returnMsg);
    }

    unset($new_user);
?>