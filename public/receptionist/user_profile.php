<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
        Security::redirectUserBase();
        die();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/general/styles.css">
    <link rel="stylesheet" href="/styles/general/staff.css">
    <link rel="stylesheet" href="/styles/receptionist/receptionist.css">
    <link rel="stylesheet" href="/styles/receptionist/profiles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>User Profile</title>
</head>
<body>
    <?php
        require_once("dashboard_header.php");    
    ?>
    <main class="body-container">
        <div class="content-box">
            <div class="row-container"> 
            <div class="searchError"> </div>
            </div>
            <!-- <div id="profilePic" style="display:flex; justify-content:center;margin-bottom:5%">
            </div> -->
            <div class="row-container">
                <div class="left-side"> Name: </div>
                <input class="right-side" id="name"> </input>
            </div>
            <br>
            <div class="row-container">
                <div class="left-side"> Gender: </div>
                <input class="right-side" id="gender"> </input>
            </div>
            <br>
            <div class="row-container">
                <div class="left-side"> Birthday: </div>
                <input class="right-side" id="bday"> </input>
            </div>
            <br>
            <div class="row-container">
                <div class="left-side"> Contact Number: </div>
                <input class="right-side" id="contactN"> </input>
            </div>
            <br>
            <div class="row-container">
                <div class="left-side"> Home Address: </div>
                <div class="right-side"> <textarea rows='1' readonly id="address"> </textarea> </div>
            </div>
            <br>
            <div class="row-container">
                <div class="left-side"> Height: </div>
                <input class="right-side" id="height">
                </input>
            </div>
            <div class="row-container">
                <div class="left-side"> Weight: </div>
                <input class="right-side" id="weight"> </input>
            </div>
                    
            <h3> Emergency Details </h3>
                <div class="row-container">
                    <div class="left-side">Name: </div>
                    <div class="right-side"> <select id="eName"> </select> </div>
                </div>
                    <br>
                <div class="row-container">
                    <div class="left-side">Relationship: </div>
                    <div class="right-side"> <output id="eRelationship"></output></div>
                </div>
                    <br>
                <div class="row-container">
                    <div class="left-side">Contact Number: </div>
                    <div class="right-side"><output id="eContactN"></output> </div>
                </div>
                <br>
                <div class="row-container">
                    <div class="left-side"> Medical Concerns: </div>
                    <div class="right-side" id="medicalConcerns"> </div>
                </div>
                <!-- <h3> Medical Concerns </h3> 
                <div id="medicalConcerns" >
                </div> -->
        </div>
    </main>
    
</body>
<script src="/js/receptionist/user_profile.js"></script>
<script type="module" src="/js/general/notifications.js"></script>
</html>