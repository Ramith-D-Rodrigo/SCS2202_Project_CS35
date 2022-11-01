<?php
    session_start();
    require_once("./user.php");
    require_once("./user_dependent.php");
    require_once("./dbconnection.php");


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
    $hasEmailsql = sprintf("SELECT * FROM USER WHERE email_address = '%s'", $connection -> real_escape_string(htmlspecialchars($_POST['emailAddress'], ENT_QUOTES)));    
    $hasEmailResult = $connection -> query($hasEmailsql);

    if(isset($_SESSION['successMsg'])){ //same user is trying to register (in the same session) We have to unset the message
        unset($_SESSION['successMsg']);
    }

    if($hasEmailResult -> num_rows > 0){    //account already exists
        $_SESSION['emailError'] = "Account with same Email Address exists.";
        header("Location: ./user_register.php");
        $connection -> close(); //close the database connection
        exit(); //exit the registration
    }
    else{
        unset($_SESSION['emailError']); //email is available, hence unset the error message
    }
    
    //username availability
    $hasUsernamesql = sprintf("SELECT * FROM `login_details` WHERE `username` = '%s'", $connection -> real_escape_string(htmlspecialchars($_POST['username'], ENT_QUOTES)));    
    $hasUsernameResult = $connection -> query($hasUsernamesql);

    if($hasUsernameResult -> num_rows > 0){    //account already exists
        $_SESSION['usernameError'] = "Account with same Username exists.";
        header("Location: ./user_register.php");
        $connection -> close(); //close the database connection
        exit(); //exit the registration
    }
    else{
        unset($_SESSION['usernameError']); //username is available, hence unset the error message
    }


    //can create a account

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);    //hash the password
    $useridsql = 'SELECT UUID()';   //create an user id using uuid function
    $userIDResult = $connection -> query($useridsql); //get the result from query

    foreach($userIDResult as $row){   //get the user id
        $userid = $row['UUID()'];
    }

    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['emailAddress'], ENT_QUOTES);
    $address = htmlspecialchars($_POST['homeAddress'], ENT_QUOTES);
    $contactNo = htmlspecialchars($_POST['contactNum'], ENT_QUOTES);
    $fName = htmlspecialchars($_POST['firstName'], ENT_QUOTES);
    $lName = htmlspecialchars($_POST['lastName'], ENT_QUOTES);
    $bday = htmlspecialchars($_POST['birthday'], ENT_QUOTES);
    $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES);

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

    $new_user = new User();
    $new_user -> setDetails($fName, $lName, $email, $address, $contactNo, $bday, $userid, $user_dependents, $height, $weight, $medical_concerns, $username, $password, $gender);
    $result = $new_user -> registerUser($connection);

    if($result === TRUE){   //successfully registered
            echo "Successfully registered";
/*         foreach($inputFields as $i){    //store session details
            if(isset($_SESSION[$i])){   //unsetting input values
                session_unset($i);
            }
        } */
        session_unset(); //free all current session variables 

        $_SESSION['successMsg'] = 'Registered Successfully';
        header("Location: ./user_register.php");
    }

    $connection -> close(); //close the database connection
?>