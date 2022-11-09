<?php
    session_start();
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/manager/manager.php");
    require_once("../../src/admin/dbconnection.php");
    require_once("../../src/admin/credentials_availability.php");


    //all possible inputs for prefilling
    $inputFields = [`email_address`, `contact_number`, `gender`, `date_of_birth`, `first_name`, 
                                `last_name`];

    //Compulsary Details

    foreach($inputFields as $i){    //store session details
        if(isset($_POST[$i])){
            $_POST[$i] = htmlspecialchars($_POST[$i], ENT_QUOTES);
            $_SESSION[$i] = $_POST[$i];
        }
    }
    
    //Checking if the account already exists

    //email availability
    $hasEmailResult = null;
    if(htmlspecialchars($_POST['staffRole'], ENT_QUOTES)=='Receptionist'){
        $hasEmailResult = checkReceptionistEmail($_POST['emailAddress'], $connection);
    }  
    else {
        $hasEmailResult = checkManagerEmail($_POST['emailAddress'], $connection);
    }

    if(isset($_SESSION['successMsg'])){ //same user is trying to register (in the same session) We have to unset the message
        unset($_SESSION['successMsg']);
    }

    if($hasEmailResult -> num_rows > 0){    //account already exists
        $_SESSION['emailError'] = "Account with same Email Address exists.";
        header("Location: /public/system_admin/staff_register.php");
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
        header("Location: /public/system_admin/staff_register.php");
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

    foreach($userIDResult as $row){   //get the user id  || what is happening here??
        $userid = $row['UUID()'];
    }

    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['emailAddress'], ENT_QUOTES);
    $contactNo = htmlspecialchars($_POST['contactNum'], ENT_QUOTES);
    $fName = htmlspecialchars($_POST['firstName'], ENT_QUOTES);
    $lName = htmlspecialchars($_POST['lastName'], ENT_QUOTES);
    $bday = htmlspecialchars($_POST['birthday'], ENT_QUOTES);
    $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES);
    $staffRole = htmlspecialchars($_POST['staffRole'], ENT_QUOTES);
    $branchID = htmlspecialchars($_POST['branchID'], ENT_QUOTES);


    $result = false;
    if($staffRole == 'Receptionist') {
        $new_receptionist = new Receptionist();
        $new_receptionist -> setDetails($fName, $lName, $email, $contactNo, $bday,  $gender, $userid, $username, $password, $branchID);
        $result = $new_receptionist -> registerReceptionist($connection);
    }
    // else {                 Manager Part
    //     $new_manager = new Manager();
    //     $new_manager -> setDetails($fName, $lName, $email, $contactNo, $bday,  $gender, $userid, $username, $password, $branchID);
    //     $result = $new_manager -> registerManager($connection);
    // }
    

    if($result === TRUE){   //successfully registered
            echo "Successfully registered";
/*         foreach($inputFields as $i){    //store session details
            if(isset($_SESSION[$i])){   //unsetting input values
                session_unset($i);
            }
        } */
        session_unset(); //free all current session variables 

        $_SESSION['RegsuccessMsg'] = 'Registered Successfully';
        header("Location: /public/system_admin/staff_register.php");
    }

    $connection -> close(); //close the database connection
?>