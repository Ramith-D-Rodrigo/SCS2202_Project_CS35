<?php
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){ //cannot access (NOT operator)
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
                <link rel="stylesheet" href="/styles/general/our_sports.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
                <link rel="stylesheet" href="/styles/user/coaching_sessions.css">
        <title>Coaching Sessions</title>
            </head>
            <body>
                <?php
                    require_once("../../public/general/header.php");
                ?>
                <main>
                    <div class="body-container">
                        <div class="content-box" style="flex-direction:row">
                            <div>
                                Status
                                <select id="statusFilter">
                                    <option value="all">All</option>
                                    <option value="pending">Pending</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="left">Left</option>
                                </select>
                            </div>

                            <div>
                                Sport
                                <select id="sportFilter">
                                    <option value="all">All</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="body-container" id="coachingSessionsContainer">
                    </div>
                </main> 

                <?php
                    require_once("../../public/general/footer.php");
                ?>

                <div class="body-container popup" id="coachFeedbackFormDiv">
                    <div class="content-box">
                        <h2></h2>
                        <form>
                            <input name="coachID" hidden>
                            <div id="userRating">
                                <i class="fas fa-star rating" style="font-size:1.2rem" id="rating1"></i>
                                <i class="fas fa-star rating" style="font-size:1.2rem" id="rating2"></i>
                                <i class="fas fa-star rating" style="font-size:1.2rem" id="rating3"></i>
                                <i class="fas fa-star rating" style="font-size:1.2rem" id="rating4"></i>
                                <i class="fas fa-star rating" style="font-size:1.2rem" id="rating5"></i>
                            </div>

                            <div>
                                <textarea name="feedback" id="feedback" cols="30" rows="10" placeholder="Your Feedback" required></textarea>
                            </div>

                            <div style="display: flex; flex-direction:row; justify-content:center">
                                <button id="sendFeedback" type="submit">
                                    Send<i class="fas fa-paper-plane" style="margin: 0 0.5rem"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="body-container popup" id="leaveSessionConfirmationDiv">
                    <div class="content-box">
                        <h2></h2>
                        <div style="display: flex; flex-direction:row; justify-content:space-between;">
                            <button id="confirmBtn" class="user-selection-btn">Yes<i class="fas fa-check" style="margin: 0 0.5rem"></i>
                            </button>
                            <button id="cancelBtn" class="user-selection-btn">No<i class="fas fa-times" style="margin: 0 0.5rem"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="content-box" id="msgBox">
                    <div style="text-align:center">
                        <div id="msg" style="display:flex; flex-direction:column;"></div>
                    </div>
                </div>
            </body>
            <script src="/js/user/account_links.js"></script>
            <script type="module" src="/js/user/coaching_sessions.js"></script>
        </html>
    <?php
    }
?>