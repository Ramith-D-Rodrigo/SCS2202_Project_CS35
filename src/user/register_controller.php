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

    $hasEmailsql = sprintf("SELECT * FROM USER WHERE email_address = '%s'", $connection -> real_escape_string(htmlspecialchars($_POST['emailAddress'])));    //Checking if the account already exists
    $hasEmailResult = $connection -> query($hasEmailsql);

    if($hasEmailResult -> num_rows > 0){    //account already exists
        $_SESSION['emailError'] = "Account with same Email Address exists.";
        return require_once './user_register.php';  //go back to the form
    }
    //can create a account

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);    //hash the password
    $useridsql = 'SELECT UUID()';   //create an user id using uuid function
    $userIDResult = $connection -> query($useridsql); //get the result from query

    foreach($userIDResult as $row){   //get the user id
        $userid = $row['UUID()'];
    }

    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['emailAddress']);
    $address = htmlspecialchars($_POST['homeAddress']);
    $contactNo = htmlspecialchars($_POST['contactNum']);
    $fName = htmlspecialchars($_POST['firstName']);
    $lName = htmlspecialchars($_POST['lastName']);
    $bday = htmlspecialchars($_POST['birthday']);
    $gender = htmlspecialchars($_POST['gender']);

    if(isset($_POST['height'])){
        $height = htmlspecialchars($_POST['height']);
    }
    else{
        $height = null;
    }

    if(isset($_POST['weight'])){
        $weight = htmlspecialchars($_POST['weight']);
    }
    else{
        $weight = null;
    }

    //user medical concerns
    $medical_concerns = [];

    foreach($inputFields as $i){
        if(preg_match("/medical_concern[1-5]/", $i)){   //found a match 
            if(isset($_POST[$i])){
                array_push($medical_concerns, htmlspecialchars($_POST[$i]));
            }
        }
    }

    //user dependents
    $user_dependents = [];
    $j = 1;
    while($j <= 3){
        $name = null;
        $contact = null;
        $relationship = null;

        foreach($inputFields as $i){
            if(preg_match(sprintf("/name%s/",$j), $i)){   //found a match for name
                if(isset($_POST[$i])){
                    $name =  htmlspecialchars($_POST[$i]);
                }
            }
            else if(preg_match(sprintf("/emgcontactNum%s/",$j), $i)){ //found a match for contact number
                if(isset($_POST[$i])){
                    $contact = htmlspecialchars($_POST[$i]);
                }
            }
            else if(preg_match(sprintf("/relationship%s/",$j), $i)){ //found a match for relationship
                if(isset($_POST[$i])){
                    $relationship = htmlspecialchars($_POST[$i]);
                }
            }
        }
        echo "<br>";
        echo $name;
        echo "<br>"; 
        echo "<br>";
        echo $relationship;
        echo "<br>";
        echo "<br>";
        echo $contact;
        echo "<br>";
        if($name !== null && $contact !== null  && $relationship !== null){ //there is a contact information
            echo "Inside dependent creation";
            $newDependent = new UserDependent($name, $relationship, $contact);  //create the dependent
            $newDependent -> setOwner($userid);     //set the user id
            array_push($user_dependents, $newDependent);    //push to the array
        }
        $j = $j + 1;
    }
    print_r($_POST);

    $new_user = new User($fName, $lName, $email, $address, $contactNo, $bday, $userid, $user_dependents, $height, $weight, $medical_concerns, $username, $password, $gender);
    $new_user -> registerUser($connection);
?>