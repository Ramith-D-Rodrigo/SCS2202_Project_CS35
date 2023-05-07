<?php
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    // if(!Security::userAuthentication(logInCheck: FALSE)){ //cannot access (NOT operator)
    //     Security::redirectUserBase();
    // }
    // else{
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="/styles/general/styles.css">
                <link rel="stylesheet" href="/styles/general/staff.css">
                <link rel="stylesheet" href="/styles/general/reservation_schedule.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
                <link rel="stylesheet" href="/styles/general/notification.css">
                <title>Reservation Schedule</title>
            </head>
            <body>
                <?php
                    require_once("dashboard_header.php");
                ?>
                <main>
                    <div class='content-box'>
                        <div style="display:flex; flex-direction:row; justify-content:space-between;">

                            <div id="reservingSportName">
                                Sport :
                            </div>

                            <div id="reservingBranchLocation">
                                Branch : 
                            </div>
                            <div id="reservationPriceDisplay">
                                Reservation Price :
                            </div>
                        </div>
                        <div style="margin-top: 10px; display:flex; flex-direction:row; justify-content:space-between;">
                            <div id="branchOpeningTime">
                                Branch Opening Time :
                            </div>
                            <div id="branchClosingTime">
                                Branch Closing Time :
                            </div>
                        </div>

                        <div style="margin-top:10px"  id="allScheduleDetails">
                            <div style="float:right" id="scheduleNavBtns">
                                <button id="prevBtn">Previous</button>
                                <button id="nextBtn">Next</button>
                            </div>
                        </div>                      
                    </div>

                    <div class='content-box'>
                            <div style="text-align:center; margin-bottom: 20px">
                                Make a Reservation
                            </div>
                            <form id="formData" method="post">
                                <div style="display:flex; flex-direction: row; flex-wrap: wrap; justify-content:space-around">
                                    <div style ="flex-basis: 33.333333%">
                                        Sport : <input name ="reservingSport" readonly id="reservingSportInput"> 
                                    </div>

                                    <div style ="flex-basis: 33.333333%">
                                        Branch : <input name = "reservingBranch" readonly id="reservingBranchInput">
                                    </div>

                                    <div style ="flex-basis: 33.333333%">
                                        Sport Court : <input style="width:60%" name="reservingSportCourt" id="selectedSportCourt" readonly>
                                    </div>

                                    <div style ="flex-basis: 33.333333%">
                                        Date : <input type="date" name="reservingDate" id="reservationDate" required>
                                    </div>
                                        
                                    <div style ="flex-basis: 33.333333%">
                                        Starting Time : <input type="time" name="reservingStartTime" required id="reserveStartingTime">
                                        
                                    </div>

                                    <div style ="flex-basis: 33.333333%">
                                        Ending Time : <input type="time" required name="reservingEndTime" id="reserveEndingTime">
                                    </div>
                                    <div style ="flex-basis: 33.333333%">
                                        Name : <input style="width:75%" type="text" required name="name" id="name" pattern="[a-zA-Z. ]+">
                                    </div>
                                    <div style ="flex-basis: 33.333333%">
                                        Contact Number : <input style="width:58%" type="text" required name="contactNum" id="contactNum" minlength="10" maxlength="11" pattern="[0-9]+">
                                    </div>
                                    <div style ="flex-basis: 33.333333%">
                                        Number of People : <input style="width:56%" type="text" required name="numOfPeople" id="numOfPeople" minlength="1" pattern="[0-9]+">
                                    </div>
                                </div>
                                <div style="text-align:center">
                                    Reservation Price : <input readonly id="reservationPrice" name="reservationPrice">
                                </div>
                                <div style="display:flex; align-items: center; justify-content: flex-end;">
                                    <button type="submit" name="makeReserveBtn" id="makeReserveBtn" onclick="return validateForm(event)" style="margin-top:10px;">Proceed to Payment<i class="fa-solid fa-cash-register" style="margin:0 10px"></i>
                                    </button>
                                    <button onclick="window.location.href='onsite_reservation_entry.php'" >Cancel<i class="fa-regular fa-rectangle-xmark" style="margin:0 10px"></i>
                                    </button>
                                </div>
                                <div class="err-msg" id="errMsg"></div>
                                <div class="success-msg" id="successMsg"></div>
                                <div style="text-align:center; font-style:italic; margin-top:10px; font-size:smaller">
                                    Contact Relevant branch manager for Formal reservations incase of holding events
                                </div>
                            </form>
                    </div>
                </main>
                <?php
                    require_once("../general/footer.php");
                ?>
            </body>
            <script type="module" src="/js/receptionist/reservation_schedule.js"></script>
            <script type="module" src="/js/receptionist/reservation_validation.js"></script>
            <script type="module" src="/js/receptionist/reservation_availability.js"></script>
            <!-- <script src="/js/user/account_links.js"></script> -->
            <!-- <script src="https://js.stripe.com/v3/"></script> -->
            <!-- <script type="module" src="/js/general/notifications.js"></script> -->
        </html>
    <?php
    // }
?>