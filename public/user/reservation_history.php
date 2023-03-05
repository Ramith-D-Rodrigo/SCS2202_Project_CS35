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
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
                <link rel="stylesheet" href="/styles/user/cancel_reservation.css">
                <link rel="stylesheet" href="./styles/general/notification.css">
                <link rel="stylesheet" href="/styles/user/give_feedback.css">
                <title>Reservation History</title>
            </head>
            <body>
                <?php
                    require_once("../../public/general/header.php");
                ?>
                <main>
                    <div class="content-box" style="overflow-x:auto;" id="reservationHistoryBox">
                    </div>
                </main>
                <div id="authFormDiv" class="content-box">
                        <form>
                            <p style="text-align:center">Please Authenticate Yourself<br>to Cancel the Reservation</p>
                            <p style="text-align:center"><i class="fas fa-user-lock" style="font-size:1.5rem"></i></p>
                            <p id="authMsg" style="text-align:center"></p>
                            <div style="display:flex; flex-direction:column">
                                <input type="text" name="username" id="username" placeholder="Username" required minlength="6" maxlength="15">
                                <input type="password" name="password" id="password" placeholder="Password" required>
                                <div class="err-msg"></div>
                                <div class="success-msg"></div>

                                <div style="display:flex; flex-direction:row; justify-content:space-between">
                                    <button style="width:25%;" type="submit">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </button>
                                    <button style="width:25%;" id="authCancel">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div id="altMsg"></div>
                            </div>
                        </form>
                </div>

                <div class="content-box" id="msgBox">
                    <div style="text-align:center">
                        <div id="msg" style="display:flex; flex-direction:column"></div>
                    </div>
                    <div style="text-align:center; margin-top: 3rem">
                        <span id="dismiss">
                            Dismiss <i class="fas fa-times"></i>
                        </span>
                    </div>
                </div>

                <div class="content-box" id="feedbackBox">
                    <div style="text-align:center; font-size:1.5rem">
                        How Was Your Experience? <i class="fas fa-smile-beam" style="font-size:1.5rem"></i>
                        <form>
                            <p id="feedbackMsg" style="padding:1rem" style="width:60%"></p>
                            <div style="display:flex; flex-direction:column;">
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

                                <div style="display: flex; flex-direction:row; justify-content:space-between">
                                    <button id="sendFeedback" style="width:25%;" type="submit">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                    <button id="cancelFeedback" style="width:25%;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>    
                </div>
                <?php
                    require_once("../../public/general/footer.php");
                ?>    
            </body>
            <script src="/js/user/account_links.js"></script>
            <script type="module" src="/js/user/reservation_history.js"></script>
            <script type="module" src="/js/general/notifications.js"></script>
        </html>
    <?php
    }
?>