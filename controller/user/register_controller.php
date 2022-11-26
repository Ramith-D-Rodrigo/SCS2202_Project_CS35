<?php
    session_start();
    require_once("../../src/user/user.php");
    require_once("../../src/user/user_dependent.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/user/credentials_availability.php");
    require_once("../../src/general/uuid.php"); //to generate uuids


    //all possible inputs for prefilling
    $inputFields = ['firstName', 'lastName', 'emailAddress', 'homeAddress', 'firstName', 'lastName', 'birthday', 'contactNum', 'username', 'gender',
     'password', 'medical_concern1', 'medical_concern2', 'medical_concern3', 'medical_concern4', 'medical_concern5', 'emgcontactNum1', 'name1', 'relationship1',
     'emgcontactNum2', 'name2', 'relationship2', 'emgcontactNum3', 'name3', 'relationship3', 'height', 'weight'];

    //Compulsary Details

    foreach($inputFields as $i){    //store session details
        if(isset($_POST[$i])){
            $_POST[$i] = htmlspecialchars($_POST[$i], ENT_QUOTES);
            $_SESSION[$i] = $_POST[$i];
        }
    }
    
    //Checking if the account already exists

    //email availability   
    $hasEmailResult = checkEmail($_POST['emailAddress'], $connection);

    if(isset($_SESSION['successMsg'])){ //same user is trying to register (in the same session) We have to unset the message
        unset($_SESSION['successMsg']);
    }

    if($hasEmailResult -> num_rows > 0){    //account already exists
        $_SESSION['emailError'] = "Account with same Email Address exists.";
        header("Location: /public/user/user_register.php");
        $connection -> close(); //close the database connection
        exit(); //exit the registration
    }
    else{
        unset($_SESSION['emailError']); //email is available, hence unset the error message
    }
    
    //username availability    
    $hasUsernameResult = checkUsername($_POST['username'], $connection);

    if($hasUsernameResult -> num_rows > 0){    //account already exists
        $_SESSION['usernameError'] = "Account with same Username exists.";
        header("Location: /public/user/user_register.php");
        $connection -> close(); //close the database connection
        exit(); //exit the registration
    }
    else{
        unset($_SESSION['usernameError']); //username is available, hence unset the error message
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
        $profilePicFlag = true;
        $pic = $_FILES['user_pic']['tmp_name'];   //the image
        $picName = $_FILES['user_pic']['name'];
        $picExtension = explode('.', $picName);
        $picExtension = strtolower(end($picExtension)); //get image extension

        $picNewName = uniqid($username);    //create a new name for the image
        $picNewName = $picNewName . '.' . $picExtension; //concat the extension
        
        move_uploaded_file($pic, '../../public/user/profile_images/'.$picNewName);  //move the file to this directory
    }

    $new_user = new User();
    $new_user -> setDetails($fName, $lName, $email, $address, $contactNo, $bday, $userid, $user_dependents, $height, $weight, $medical_concerns, $username, $password, $gender);

    if($profilePicFlag === true){    //has uploaded a profile pic
        $new_user -> setProfilePic($picNewName);
    }
    else{
        $new_user -> setProfilePic("NULL");
    }

    $result = $new_user -> registerUser($connection);

    if($result === TRUE){   //successfully registered
        echo "Successfully registered";
/*         foreach($inputFields as $i){    //store session details
            if(isset($_SESSION[$i])){   //unsetting input values
                session_unset($i);
            }
        } */
        session_unset(); //free all current session variables 

        $_SESSION['RegsuccessMsg'] = 'Registered Successfully';
        header("Location: /public/user/user_register.php");
    }
    else{
        echo "Error Registering the Account";
        $_SESSION['RegUnsuccessMsg'] = 'Error Registering the Account';
        header("Location: /public/user/user_register.php");
    }

    $connection -> close(); //close the database connection
?>