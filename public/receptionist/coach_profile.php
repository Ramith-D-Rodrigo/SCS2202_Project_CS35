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
    <link rel="stylesheet" href="/styles/general/staff.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Coach Profile</title>
</head>
<body>
    <?php
        require_once("dashboard_header.php");
    ?>
    <main>
    <div style="display:flex;flex-direction:row" id="search_results">
        <div class="content-box" style="width:45%" id="profileData">
            <div id="profilePic" style="display:flex; justify-content:center;margin-bottom:5%">
            </div>
            <div id="errProfile-msg">
            </div>
            <div class="row-container">
            <div class="left-side"> Coach ID: </div>
            <div class="right-side" id="cid"> </div>
            </div>
            <div class="row-container">
                <div class="left-side"> Sport: </div>
                <div class="right-side" id="sport"> </div>
            </div>
            <br>
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
                <div class="left-side"> Email Address: </div>
                <div class="right-side" id="eAddress"> </div>
            </div>
            <br>
            <div class="row-container">
                <div class="left-side"> Overall Rating: </div>
                <div class="right-side" id="rating"> </div>
            </div>
            <br>
            Qualifications
            <br>
            <br>
            <div id="qualifications"> </div>

            <div class="row-container">
                <div class="left-side"> Session Branches:  </div>
                <div class="right-side">
                    <select id="sessionBranch"> </select>
                </div>
            </div>
            <div class="row-container">
                <div class="left-side"> Coaching Sessions:  </div>
                <div class="right-side" id="sessionInfo">   
                </div>
            </div>
        </div>
        <div class="content-box" style="width:44%" id="feedbackData">  
            Student Feedback
            <br>
            <br>
            <div id="errFeedback-msg">
            </div>   
            <div id="feedback"> </div>
    </div>
    </main>
    <?php
        require_once("../general/footer.php");
    ?>
</body>
<script src="/js/receptionist/coach_profile.js"></script>
</html>