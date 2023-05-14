<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
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
        <title>Reservation Schedule</title>
        <link rel="stylesheet" href="/styles/owner/styles.css" />
        <link rel="stylesheet" href="/styles/general/reservation_schedule.css" />
        <link rel="stylesheet" href="/styles/owner/reservation_schedule.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    </head>

    <body>
        <?php
                require_once("header.php");
        ?>
        <main>
            <div class='content-box' id='user-selection'>
                <form id="court-select">
                    <select required id="branchVal">
                        <option value="">Branch</option>
                    </select>

                    <select required id="sportVal">
                        <option value="">Sport</option>
                    </select>

                    Starting From <input type="date" id="startDate" name="startDate" required>

                    <button type="submit">Get Schedule</button>
                </form> 
            </div>

            <div class='content-box'>
                <div id="allScheduleDetails">
                    <div id="scheduleNavBtns">
                        <button id="prevBtn">Previous</button>
                        <button id="nextBtn">Next</button>
                    </div>
                </div> 
            </div>
        </main>
        <div class='content-box user-reservation pop-up' id="userDetails">
            <div class="img-container row-container">
                <img src="/styles/icons/profile_icon.svg" id="userImg" class="profile-pic">
            </div>
            <div class="res-info">
                <div class="row-container">
                    <div class="left-field">
                        Name
                    </div>
                    <div class="right-field">
                        <input type="text" id="userName" name="userName" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Contact Number
                    </div>
                    <div class="right-field">
                        <input type="text" id="userContactNum" name="UserContactNum" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Reserved Timestamp
                    </div>
                    <div class="right-field">
                        <input type="text" id="timestamp" name="timestamp" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Number of People Attending
                    </div>
                    <div class="right-field">
                        <input type="text" id="peopleCount" name="peopleCount" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Payment Amount
                    </div>
                    <div class="right-field">
                        <input type="text" id="payment" name="payment" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Reservation Status
                    </div>
                    <div class="right-field">
                        <input type="text" id="status" name="status" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class='content-box coaching-session pop-up' id="coachDetails">
            <div class="img-container row-container">
                <img src="/styles/icons/profile_icon.svg" id="coachImg" class="profile-pic">
            </div>
            <div class="res-info">
                <div class="row-container">
                    <div class="left-field">
                        Name
                    </div>
                    <div class="right-field">
                        <input type="text" id="coachName" name="coachName" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Contact Number
                    </div>
                    <div class="right-field">
                        <input type="text" id="coachContactNum" name="coachContactNum" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Coach Monthly Payment
                    </div>
                    <div class="right-field">
                        <input type="text" id="monthlyPayment" name="monthlyPayment" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Current Number of Students
                    </div>
                    <div class="right-field">
                        <input type="text" id="noOfStudents" name="noOfStudents" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Session Payment Amount (For Students)
                    </div>
                    <div class="right-field">
                        <input type="text" id="studentPayment" name="studentPayment" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Start Date
                    </div>
                    <div class="right-field">
                        <input type="text" id="sessionStartDate" name="sessionStartDate" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Cancel Date
                    </div>
                    <div class="right-field">
                        <input type="text" id="sessionCancelDate" name="sessionCancelDate" readonly>
                    </div>
                </div>
            </div>
        </div>
        <?php
                require_once("../general/footer.php");
        ?>
    </body>
    <script type="module" src="/js/general/notifications.js"></script>
    <script type="module" src="/js/owner/reservation_schedule.js"></script>
</html>
