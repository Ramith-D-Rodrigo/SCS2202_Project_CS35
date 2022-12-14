<?php
    session_start();
    $_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <link rel="stylesheet" href="/styles/general/reservation_schedule.css">
        <title>Reservation Schedule</title>
    </head>
    <body>
        <?php
            require_once("header.php");
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
                    <form method="post" action="/controller/user/make_reservation_controller.php">
                        <div style="display:flex; flex-direction: row; flex-wrap: wrap; justify-content:space-around">
                            <div style ="flex-basis: 33.333333%">
                                Sport : <input name ="reservingSport" readonly id="reservingSportInput"> 
                            </div>

                            <div style ="flex-basis: 33.333333%">
                                Branch : <input name = "reservingBranch" readonly id="reservingBranchInput">
                            </div>

                            <div style ="flex-basis: 33.333333%">
                                Sport Court : <input name="reservingSportCourt" id="selectedSportCourt" readonly>
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
                            <div style ="flex:auto">
                                Number of People : <input type="text" required name="numOfPeople" id="numOfPeople" min="1" pattern="[0-9]+">
                            </div>
                        </div>
                        <div class="err-msg" id="errMsg">
                            <?php if(isset($_SESSION['reservationFail'])){
                                echo $_SESSION['reservationFail'];
                                unset($_SESSION['reservationFail']);
                            }
                            ?>
                        </div>
                        <div class="success-msg">
                        <?php if(isset($_SESSION['reservationSuccess'])){
                            echo $_SESSION['reservationSuccess'];
                            unset($_SESSION['reservationSuccess']);
                        }
                        ?>
                        </div>
                        <div style="text-align:center">
                            Reservation Price : <input readonly id="reservationPrice" name="reservationPrice">
                        </div>
                        <div style="display:flex; align-items: center; justify-content: center;">
                            <button type="submit" name="makeReserveBtn" id="makeReserveBtn" onclick="return validateForm(event)" style="margin-top:10px;">Make Reservation</button>
                        </div>
                        <div style="text-align:center; font-style:italic; margin-top:10px; font-size:smaller">
                            Contact Relevant branch manager for Formal reservations incase of holding events
                        </div>
                    </form>
            </div>

        </main>

        <?php
            require_once("footer.php");
        ?>
    </body>
    <script src="/js/general/reservation_schedule.js"></script>
    <script src="/js/general/reservation_validation.js"></script>
    <script src="/js/user/account_links.js"></script>
</html>