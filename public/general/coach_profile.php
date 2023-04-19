<?php
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: FALSE)){//cannot access (NOT operator)
        Security::redirectUserBase();
    }
    else{
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="/styles/general/styles.css">
                <link rel="stylesheet" href="/styles/general/coach_profile.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

                <title>Coach Profile</title>
            </head>
            <body>
                <?php
                    require_once("header.php");
                ?>
                <main>
                    <div class="body-container">
                        <div class="content-box" id="coachInfoContainer">
                            <div class="coach-info">
                                <div class="coach-image-container">
                                    <img class="coach-image" id="coachProfilePic">
                                </div>
                                <div class="detailsContainer">
                                    <div class="row-container">
                                        <div id="coachName" class="left-field personal">Name</div>
                                        <div class="right-field personal"></div>
                                    </div>
                                    <div class="row-container">
                                        <div id="coachAge" class="left-field personal">Age</div>
                                        <div class="right-field personal"></div>
                                    </div>
                                    <div class="row-container">
                                        <div id="coachGender" class="left-field personal">Gender</div>
                                        <div class="right-field personal"></div>
                                    </div>
                                    <div class="row-container">
                                        <div id="coachSport" class="left-field personal">Sport</div>
                                        <div class="right-field personal"></div>
                                    </div>
                                    <div class="row-container">
                                        <div id="coachEmail" class="left-field personal">Email</div>
                                        <div class="right-field personal"></div>
                                    </div>
                                    <div class="row-container">
                                        <div id="coachContactNo" class="left-field personal">Contact No</div>
                                        <div class="right-field personal"></div>
                                    </div>
                                    <div class="row-container">
                                        <div id="coachRating" class="left-field personal">Rating</div>
                                        <div class="right-field personal"></div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="coachQulifationsDiv" class="row-container">
                                    <div class="left-field">Qualifications</div>  
                                    <div class="right-field">
                                        <select id="coachQulifations" style="min-width:25%">
                                        </select>
                                    </div>

                                </div>
                                <div id="sessionBranchesDiv" class="row-container">
                                    <div class="left-field">Session Branches</div>  
                                    <div class="right-field">
                                        <select id="sessionBranches" style="min-width:25%">
                                            <option value="">Select One</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="coachingSessionsDiv" class="row-container">
                                    <div class="left-field">Coaching Sessions</div>
                                    <div class="right-field">
                                        <select id="coachingSessions" style="min-width:25%">
                                            <option value="">Please Select a Branch</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <div class="row-container">
                                        <div class="left-field">Court  </div>
                                        <div class="right-field"><input id="courtName" readonly></div>
                                    </div>
                                    <div class="row-container">
                                        <div class="left-field">Day  </div>
                                        <div class="right-field"><input id="day" readonly></div>
                                    </div>
                                    <div class="row-container">
                                        <div class="left-field">Time Period  </div>
                                        <div class="right-field"><input id="timePeriod" readonly></div>
                                    </div>
                                    <div class="row-container">
                                        <div class="left-field">Starting Time  </div>
                                        <div class="right-field"><input id="startingTime" readonly></div>
                                    </div>
                                    <div class="row-container">
                                        <div class="left-field">Ending Time  </div>
                                        <div class="right-field"><input id="endingTime" readonly></div>
                                    </div>
                                    <div class="row-container">
                                        <div class="left-field">Paymount Amount  </div>
                                        <div class="right-field"><input id="paymentAmount" readonly></div>
                                    </div>
                                    <div class="row-container">
                                        <div class="left-field">Current Number of Students  </div>
                                        <div class="right-field"><input id="noOfStudents" readonly></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="content-box" id="feedbackContainer">
                            <div class="title">Student Feedback</div>
                            <div id="stu-feedbacks"></div>
                            <div id="navIcons">
                                <button id="prevPage"><i class="fa-solid fa-chevron-circle-left" ></i></button>
                                <button id="nextPage"><i class="fa-solid fa-chevron-circle-right" ></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="content-box" id="joinSession">
                        <div class="title">Request to Join a Session</div>
                        <form id="requestForm">
                            <div class="row-container">
                                <div class="left-field">
                                    Branch 
                                </div>
                                <div class="right-field">
                                    <select id="requestingSessionBranch">
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row-container">
                                <div class="left-field">
                                Coaching Session 
                                </div>
                                <div class="right-field">
                                    <select id="requestingSession" name="requestingSession">
                                        <option value="">Please Select a Branch</option>
                                    </select>
                                    <div id="sessionFee">Session Fee : </div>
                                </div> 
                            </div>
                            <div class="row-container">
                                <div class="left-field">
                                    Any Note / Message 
                                </div>
                                <div class="right-field">
                                    <textarea name="userMessage"></textarea> 
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
            <script type="module" src="/js/general/coach_profile.js"></script>
            <script src="/js/user/request_coaching_session.js"></script>
            <script type="module" src="/js/general/notifications.js"></script>
        </html>
    <?php
    }
?>