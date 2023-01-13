<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <link rel="stylesheet" href="/styles/general/coach_profile.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Coach Profile</title>
    </head>
    <body>
        <?php
            require_once("header.php");
        ?>
        <main>
            <div style="display:flex; flex-direction:row; justify-content:center">
                <div class="content-box" style="width:100%;" id="coachInfoContainer">
                    <div style="display:flex; flex-direction: row;">
                        <div class="coach-image-container">
                            <img class="coach-image" id="coachProfilePic">
                        </div>
                        <div class="detailsContainer" style="margin: 10px">
                            <div id="coachName">Name : </div>
                            <div id="coachUsername">Coach Username : </div>
                            <div id="coachAge">Age : </div>
                            <div id="coachGender">Gender : </div>
                            <div id="coachSport">Sport : </div>
                            <div id="coachEmail">Email : </div>
                            <div id="coachContactNo">Contact No : </div>
                            <div id="coachRating">Rating : </div>
                        </div>
                    </div>
                    <div>
                        <div id="coachQulifationsDiv">
                            Qualifications : 
                            <select id="coachQulifations" style="min-width:25%">
                            </select>
                        </div>
                        <div id="sessionBranchesDiv">
                            Session Branches : 
                            <select id="sessionBranches" style="min-width:25%">
                                <option value="">Select One</option>
                            </select>
                        </div>
                        <div id="coachingSessionsDiv">
                            Coaching Sessions : 
                            <select id="coachingSessions" style="min-width:25%">
                                <option value="">Please Select a Branch</option>
                            </select>

                            <div>
                                <div class="row-container">
                                    <div class="left-field">Court : </div>
                                    <div class="right-field"><input id="courtName" readonly></div>
                                </div>
                                <div class="row-container">
                                    <div class="left-field">Day : </div>
                                    <div class="right-field"><input id="day" readonly></div>
                                </div>
                                <div class="row-container">
                                    <div class="left-field">Time Period : </div>
                                    <div class="right-field"><input id="timePeriod" readonly></div>
                                </div>
                                <div class="row-container">
                                    <div class="left-field">Starting Time : </div>
                                    <div class="right-field"><input id="startingTime" readonly></div>
                                </div>
                                <div class="row-container">
                                    <div class="left-field">Ending Time : </div>
                                    <div class="right-field"><input id="endingTime" readonly></div>
                                </div>
                                <div class="row-container">
                                    <div class="left-field">Paymount Amount : </div>
                                    <div class="right-field"><input id="paymentAmount" readonly></div>
                                </div>
                                <div class="row-container">
                                    <div class="left-field">Current Number of Students : </div>
                                    <div class="right-field"><input id="noOfStudents" readonly></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="content-box" style="width:100%" id="feedbackContainer">
                    <div style="text-align:center; margin-bottom: 20px">Student Feedback</div>
                </div>
            </div>
            <div class="content-box" id="joinSession">
                <div style="text-align:center; margin-bottom: 20px">Request to Join a Session</div>
                <form>
                    <div class="row-container">
                        <div class="left-field" style="width:50%">
                            Branch :
                        </div>
                        <div class="right-field" style="width:50%">
                            <select id="requestingSessionBranch">
                                <option value="">Select One</option>
                            </select>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-field" style="width:50%">
                        Coaching Session : 
                        </div>
                        <div class="right-field" style="display:flex; flex-direction: row; align-items:baseline; width:50%"">
                            <select id="requestingSession">
                                <option value="">Please Select a Branch</option>
                            </select>
                            <div style="margin-left: 10px" id="sessionFee">Session Fee : </div>
                        </div> 
                    </div>
                    <div class="row-container">
                        <div class="left-field" style="width:50%">
                            Any Note / Message :
                        </div>
                        <div class="right-field" style="width:50%">
                            <textarea ></textarea> 
                        </div>
                    </div>
                    <div class="err-msg" id="errMsg"></div>
                    <div class="success-msg" id="successMsg"></div>
                    <div id="waitMsg"></div>
                    <div class="btn-container">
                        <button type="submit">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            Send Request
                        </button>
                    </div>
                </form>

            </div>
        </main>
        <?php
            require_once("footer.php");
        ?>
    </body>
    <script src="/js/user/account_links.js"></script>
    <script src="/js/general/coach_profile.js"></script>
</html>