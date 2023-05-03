<?php
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: FALSE, acceptingUserRoles:['user'])){ //cannot access (NOT operator)
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
                <link rel="stylesheet" href="/styles/general/reservation_schedule.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>Reservation Schedule</title>
            </head>
            <body>
                <?php
                    require_once("header.php");
                ?>
                <main>
                    <div class='content-box'>
                        <div class="branch-info">
                            <div id="reservingSportName">
                                Sport :
                            </div>

                            <div id="reservingBranchLocation">
                                Branch : 
                            </div>
                            <div id="reservationPriceDisplay">
                                Reservation Price :
                            </div>
                            <div id="branchOpeningTime">
                                Branch Opening Time :
                            </div>
                            <div id="branchClosingTime">
                                Branch Closing Time :
                            </div>                         
                        </div>

                        <div id="allScheduleDetails">
                            <div id="scheduleNavBtns">
                                <button id="prevBtn">Previous</button>
                                <button id="nextBtn">Next</button>
                            </div>
                        </div>                      
                    </div>

                    <div class='content-box'>
                            <div class="title">
                                Make a Reservation
                            </div>
                            <form method="post">
                                <div class="reservation-info">
                                    <div class="row-container">
                                        <div class="left-field">Sport </div>
                                        <div class="right-field">
                                            <input name ="reservingSport" readonly id="reservingSportInput"> 
                                        </div>
                                    </div>
                                    
                                    <div class="row-container">
                                        <div class="left-field">Branch </div>
                                        <div class="right-field">
                                            <input name = "reservingBranch" readonly id="reservingBranchInput">
                                        </div>
                                    </div>

                                    <div class="row-container">
                                        <div class="left-field">Sport Court</div>
                                        <div class="right-field">
                                            <input name="reservingSportCourt" id="selectedSportCourt" readonly>
                                        </div>
                                        
                                    </div>

                                    <div class="row-container">
                                        <div class="left-field">Date </div>
                                        <div class="right-field">
                                            <input type="date" name="reservingDate" id="reservationDate" required>
                                        </div>
                                    </div>
                                        
                                    <div class="row-container">
                                        <div class="left-field">Starting Time </div>
                                        <div class="right-field">
                                            <input type="time" name="reservingStartTime" id="reserveStartingTime" required>
                                        </div>
                                        
                                    </div>

                                    <div class="row-container">
                                        <div class="left-field">Ending Time </div>
                                        <div class="right-field">
                                            <input type="time" required name="reservingEndTime" id="reserveEndingTime">
                                        </div>
                                    </div>
                                    <div class="row-container">
                                        <div class="left-field">
                                            Number of People
                                        </div>
                                        <div class="right-field">
                                            <input type="text" required name="numOfPeople" id="numOfPeople" min="1" pattern="[0-9]+">
                                        </div>
                                    </div>
                                </div>
                                <div class="err-msg" id="errMsg"></div>
                                <div class="success-msg" id="successMsg"></div>
                                <div class="reservation-price">
                                    Reservation Price <input readonly id="reservationPrice" name="reservationPrice">
                                </div>
                                <div style="display:flex; align-items: center; justify-content: center;">
                                    <button type="submit" name="makeReserveBtn" id="makeReserveBtn" onclick="return validateForm(event)" style="margin-top:10px;">Proceed to Payment <i class="fa-solid fa-credit-card" style="margin:0 10px"></i>
                                    </button>
                                </div>
                                <div style="text-align:center; font-style:italic; margin-top:10px; font-size:smaller">
                                    Contact Relevant branch manager for Formal reservations incase of holding events

                                    <br>
                                    Refer <a href="/public/general/about_us.php#guidelines" style="all:unset; cursor:pointer">Here</a> for Reservation Guidelines
                                </div>
                            </form>
                    </div>
                </main>
                <div class="content-box" id="paymentBox">
                    <form id="payment-form">
                        <div style="font-size:1.5rem">
                            Payment Details
                        </div>
                        <div id="amount" style="font-size:1.2rem; margin: 20px auto">
                        </div>
                        <div id="card-holder-name-div">
                        <i class="fa-solid fa-signature" style="color: gray"></i>
                            <input type="text" id="card-holder-name" name="card-holder-name" placeholder="Name on Card" required>
                        </div>
                        <div id="card-element">
                        </div>
                        <div id="card-errors" role="alert"></div>
                        <button id="paymentGatewaySubmitBtn" value="paymentSubmit" name="paymentBtn" type="submit">
                            <span id="button-text">Pay Now</span>
                        </button>
                        <div id="payment-message" class="hidden"></div>
                    </form>
                    <div class="payment-gateway-footer">
                        <div style="font-size:0.7rem; font-style:italic">
                            The payment gateway is powered by 
                        </div>
                        <i class="fa-brands fa-stripe" style="font-size:1.3rem; margin: 0 5px"></i>
                    </div>
                </div>
                <?php
                    require_once("footer.php");
                ?>
            </body>
            <script type="module" src="/js/general/reservation_schedule.js"></script>
            <script type="module" src="/js/general/reservation_validation.js"></script>
            <script type="module" src="/js/user/make_reservation.js"></script>
            <script src="/js/user/account_links.js"></script>
            <script src="https://js.stripe.com/v3/"></script>
            <script type="module" src="/js/general/notifications.js"></script>
        </html>
    <?php
    }
?>