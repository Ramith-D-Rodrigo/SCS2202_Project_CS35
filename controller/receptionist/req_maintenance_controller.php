<?php
    session_start();
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");

    //all possible inputs for prefilling
    $inputFields = [`reason`, `sportName`,`courtName`,`sDate`,`eDate`];

    //Compulsary Details

    foreach($inputFields as $i){    //store session details
        if(isset($_POST[$i])){
            $_POST[$i] = htmlspecialchars($_POST[$i], ENT_QUOTES);
            $_SESSION[$i] = $_POST[$i];
        }
    }
    
    $reason = htmlspecialchars($_POST['reason'], ENT_QUOTES);
    $sportName = htmlspecialchars($_POST['sportName'], ENT_QUOTES);
    $courtName = htmlspecialchars($_POST['courtName'], ENT_QUOTES);
    $sDate = htmlspecialchars($_POST['sDate'], ENT_QUOTES);
    $eDate = htmlspecialchars($_POST['eDate'], ENT_QUOTES);


    $recep = new Receptionist();
    $results = $recep -> reqMaintenance($reason,$sportName,$courtName,$sDate,$eDate,$connection);

    if($results === TRUE){   //successfully registered
            echo "Successfully Submitted";
/*         foreach($inputFields as $i){    //store session details
            if(isset($_SESSION[$i])){   //unsetting input values
                session_unset($i);
            }
        } */
        session_unset(); //free all current session variables 

        $_SESSION['RegsuccessMsg'] = 'Submitted';
        header("Location: /public/receptionist/request_maintenance.php");
    }

    $connection -> close(); //close the database connection
?>