<?php
    session_start();
    require_once("../../src/coach/coach.php");
    require_once("../../src/coach/dbconnection.php");
    require_once("../../src/coach/credentials_availability.php");
    require_once("../../src/general/uuid.php"); //to generate uuids


    //all possible inputs for prefilling
    $inputFields = ['firstName', 'lastName', 'emailAddress', 'homeAddress', 'firstName', 'lastName', 'birthday', 'contactNum', 'username', 'gender',
     'password', 'coach_qualification1', 'coach_qualification2', 'coach_qualification3', 'coach_qualification4', 'coach_qualification5' ];

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
        header("Location: /public/coach/coach_register.php");
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
        header("Location: /public/coach/coach_register.php");
        $connection -> close(); //close the database connection
        exit(); //exit the registration
    }
    else{
        unset($_SESSION['usernameError']); //username is available, hence unset the error message
    }


    //can create a account

    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['emailAddress'], ENT_QUOTES);
    $address = htmlspecialchars($_POST['homeAddress'], ENT_QUOTES);
    $contactNo = htmlspecialchars($_POST['contactNum'], ENT_QUOTES);
    $fName = htmlspecialchars($_POST['firstName'], ENT_QUOTES);
    $lName = htmlspecialchars($_POST['lastName'], ENT_QUOTES);
    $bday = htmlspecialchars($_POST['birthday'], ENT_QUOTES);
    $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES);
    $sport = htmlspecialchars($_POST['sport'], ENT_QUOTES);

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);    //hash the password
   

    //create user id
    $prefix1 = "coach_";
    $prefix2 = substr($username , 0,3);
    $userid = uniqid($prefix1.$prefix2);
    
    //coach Qualifications
    $coach_qualifications = [];

    foreach($inputFields as $i){
        if(preg_match("/coach_qualification[1-5]/", $i)){   //found a match 
            if(isset($_POST[$i])){
                array_push($coach_qualifications, htmlspecialchars($_POST[$i], ENT_QUOTES));
            }
        }
    }

    

    //profile picture
    $profilePicFlag = false;
/*     echo $_FILES['coach_pic']['name'];
    echo "<br>";
    echo $_FILES['coach_pic']['tmp_name']; */

    if(!empty($_FILES['coach_pic']['name'])){    //coach has uploaded a picture
        $profilePicFlag = true;
        $pic = $_FILES['coach_pic']['tmp_name'];   //the image
        $picName = $_FILES['coach_pic']['name'];
        $picExtension = explode('.', $picName);
        $picExtension = strtolower(end($picExtension)); //get image extension

        $picNewName = uniqid($username);    //create a new name for the image
        $picNewName = $picNewName . '.' . $picExtension; //concat the extension
        
        move_uploaded_file($pic, '../../public/coach/profile_images/'.$picNewName);  //move the file to this directory
    }

    $new_coach = new Coach();
    $new_coach -> setDetails($fName, $lName, $email, $address, $contactNo, $bday, $userid, $coach_qualifications, $username, $password, $gender,$sport);

    $new_coach -> setProfilePic($picNewName);
    $result = $new_coach -> registercoach($connection);

    if($result === TRUE){   //successfully registered
        echo "Successfully registered";
/*         foreach($inputFields as $i){    //store session details
            if(isset($_SESSION[$i])){   //unsetting input values
                session_unset($i);
            }
        } */
        session_unset(); //free all current session variables 

        $_SESSION['RegsuccessMsg'] = 'Registered Successfully';
        header("Location: /public/coach/coach_register.php");
    }
    else{
        echo "Error Registering the Account";
        $_SESSION['RegUnsuccessMsg'] = 'Error Registering the Account';
        session_unset(); //free all current session variables 

         header("Location: /public/coach/coach_register.php");
    }

    $connection -> close(); //close the database connection
?>