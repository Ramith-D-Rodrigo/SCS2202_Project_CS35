<?php
    session_start();
    if(!(isset($_SESSION['userid']) && isset($_SESSION['userrole']))) {
        header("Location: /public/receptionist/receptionist_login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/general/styles.css">
    <link rel="stylesheet" href="/styles/receptionist/receptionist.css" />
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
        <div id="profilePic">
        </div>
        <div class="row-container">
            <div class="left-side"> Name: </div>
            <div class="right-side" id="name"> </div>
        </div>
        <br>
        <div class="row-container">
            <div class="left-side"> Gender: </div>
            <div class="right-side" id="gender"> 
            </div>
        </div>
        <br>
        <div class="row-container">
            <div class="left-side"> Birthday: </div>
            <div class="right-side" id="bday"> </div>
        </div>
        <br>
        <div class="row-container">
            <div class="left-side"> Contact Number: </div>
            <div class="right-side" id="contactN"> </div>
        </div>
        <br>
        <div class="row-container">
            <div class="left-side"> Home Address: </div>
            <div class="right-side"> <textarea rows='1' readonly id="address"> </textarea> </div>
        </div>
        <br>
        <div class="row-container">
            <div class="left-side"> Height: </div>
            <div class="right-side" id="height">
            </div>
        </div>
        <div class="row-container">
            <div class="left-side"> Weight: </div>
            <div class="right-side" id="weight"> </div>
        </div>
                
        <u> Emergency Details </u>
            <div id="eDetails">
            </div>
            <br>
            <u> Medical Concerns </u> 
            <div id="medicalConcerns">
            </div>
        </div>
    </main>
    
</body>
<script src="/js/receptionist/user_profile.js"></script>
</html>