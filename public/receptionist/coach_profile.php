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
    <link rel="stylesheet" href="/styles/receptionist/receptionist.css">
    <link rel="stylesheet" href="/styles/receptionist/profiles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Coach Profile</title>
</head>
<body>
    <?php
        require_once("dashboard_header.php");
    ?>
    <main class="body-container">
    <div style="display:flex;flex-direction:row" id="search_results">
        <div class="content-box" id="profileData">
            <div id="profilePic" style="display:flex; justify-content:center;margin-bottom:5%">
            </div>
            <div id="errProfile-msg">
            </div>
            <div class="row-container">
                <div class="left-side"> Coach ID: </div>
                <input class="right-side" id="cid"> </input>
            </div>
            <div class="row-container">
                <div class="left-side"> Sport: </div>
                <input class="right-side" id="sport"> </input>
            </div>
            <br>
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
                <div class="left-side"> Email Address: </div>
                <input class="right-side" id="eAddress"> </input>
            </div>
            <br>
            <div class="row-container">
                <div class="left-side"> Overall Rating: </div>
                <input class="right-side" id="rating"> </input>
            </div>
            <br>
            <div class="row-container">
                <div class="left-side"> Qualifications: </div>
                <div id="qualifications" style="display:flex;flex-direction:column" class="right-side"> </div>
            </div>
            <br>
            <br>
            <div class="row-container">
                <div class="left-side"> Coaching Sessions:  </div>
                <div id="sessionInfo" style="display:flex;flex-direction:column" class="right-side"> </div>
            </div>
        </div>
        <div class="content-box" id="feedbackData">  
            <input readonly id="feedbackCaption"></input> 
            <br>
            <br>
            <div id="errFeedback-msg">
            </div>   
            <div id="feedback" style="display:flex;flex-direction:column">
            </div>
        </div>
    </div>
    </main>
    <?php
        require_once("../general/footer.php");
    ?>
</body>
<script src="/js/receptionist/coach_profile.js"></script>
<script type="module" src="/js/general/notifications.js"></script>
</html>