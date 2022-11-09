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
        <link rel="stylesheet" href="/styles/general/reservation_schedule.css">
        <title>Reservation Schedule</title>
    </head>
    <body>
        <?php
            require_once("header.php");
        ?>
        <main>
            <div class='content-box'>
                <?php
                    if(isset($_SESSION['branch_reservation_schedule'])){    //get the reservation schedule
                ?>
                    <div style="display:flex; flex-direction:row; justify-content:space-around">

                        <div>
                            Sport : <?php echo $_SESSION['reservingSport'] ?>
                        </div>

                        <div>
                            Branch : <?php echo $_SESSION['reservingBranch'] ?>
                        </div>
                        <div>
                            Reservation Price : Rs.<?php echo $_SESSION['reserve_price'] ?> per Hour
                        </div>
                    </div>

                    <div style="margin-top:10px">
                        <ul>
                            <?php foreach($_SESSION['branch_reservation_schedule'] as $courtid => $court){?>
                                <button id=<?php echo $courtid?> class="courtBtn">Court <?php echo $court['courtName']?></button>
                            <?php
                                }
                            ?>
                        </ul>
                            <?php foreach($_SESSION['branch_reservation_schedule'] as $courtid => $court){?>
                        <div class="court-schedule" id="court<?php echo $courtid?>">
                            Schedule of <?php echo $court['courtName']?>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                    }
                ?>                        

            </div>

            <div class='content-box'>
                    <div style="text-align:center; margin-bottom: 20px">
                        Make a Reservation
                    </div>
                    <form method="post" action="/controller/user/make_reservation_controller.php">
                        <div style="display:flex; flex-direction: row; flex-wrap: wrap; justify-content:space-around">
                            <div style ="flex-basis: 33.333333%">
                                Sport : <input name ="reservingSport" value= <?php echo $_SESSION['reservingSport'] ?> readonly> 
                            </div>

                            <div style ="flex-basis: 33.333333%">
                                Branch : <input name = "reservingBranch" value= <?php echo $_SESSION['reservingBranch']?> readonly>
                            </div>

                            <div style ="flex-basis: 33.333333%">
                                Sport Court : <input name="reservingSportCourt" id="selectedSportCourt" readonly>
                            </div>

                            <div style ="flex-basis: 33.333333%">
                                Date : <input type="date" name="reservingDate" id="reservationDate" required>
                            </div>
                                
                            <div style ="flex-basis: 33.333333%">
                                Starting Time : <input type="time" name="reservingStartTime" required id="reserveStartingTime" min= <?php echo substr($_SESSION['opening_time'],0,5)?> max= <?php echo substr($_SESSION['closing_time'],0,5)?>>
                                
                            </div>

                            <div style ="flex-basis: 33.333333%">
                                Ending Time : <input type="time" required name="reservingEndTime" id="reserveEndingTime" min= <?php echo substr($_SESSION['opening_time'],0,5)?> max= <?php echo substr($_SESSION['closing_time'],0,5)?>>
                            </div>
                            <div style ="flex:auto">
                                Number of People : <input type="text" required name="numOfPeople" id="numOfPeople" min="0" pattern="[0-9]+">
                            </div>
                        </div>
                        <div class="err-msg" id="errMsg">
                            <?php if(isset($_SESSION['reservationFail'])){
                                echo $_SESSION['reservationFail'];
                                unset($_SESSION['reservationFail']);
                            }
                            ?>
                        <div class="success-msg"></div>
                        <?php if(isset($_SESSION['reservationSuccess'])){
                            echo $_SESSION['reservationSuccess'];
                            unset($_SESSION['reservationSuccess']);
                        }
                        ?>
                        </div>
                        <div style="text-align:center">
                            Reservation Price : <input readonly id="reservationPrice" min=<?php echo $_SESSION['reserve_price']?> name="reservationPrice">
                        </div>
                        <div style="display:flex; align-items: center; justify-content: center;">
                            <button type="submit" name="makeReserveBtn" id="makeReserveBtn" onclick="return validateForm(event)" style="margin-top:10px;">Make Reservation</button>
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
</html>