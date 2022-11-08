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
                    </div>

                    <div class="court-tabs">
                        <?php foreach($_SESSION['branch_reservation_schedule'] as $courtid => $court){?>
                            <input type="radio" id=<?php echo $courtid ?> name="selectedCourt">
                            <label for=<?php echo $courtid ?>>Court 1</label>
                            <div class="court-schedule">
                                Schedule
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
                    <div style="display:flex; flex-direction: row; flex-wrap: wrap; justify-content:space-around">
                        <div style ="flex-basis: 33.333333%">
                            Sport : <input value= <?php echo $_SESSION['reservingSport'] ?> readonly> 
                        </div>

                        <div style ="flex-basis: 33.333333%">
                            Branch : <input value= <?php echo $_SESSION['reservingBranch']?> readonly>
                        </div>

                        <div style ="flex-basis: 33.333333%">
                            Sport Court : <input value =<?php echo $_SESSION['reservingBranch']?> readonly>
                        </div>

                        <div style ="flex-basis: 33.333333%">
                            Date : <input type="date" required>
                        </div>
                            
                        <div style ="flex-basis: 33.333333%">
                            Starting Time : <input type="time" step="1800" required id="reserveStartingTime">
                            
                        </div>

                        <div style ="flex-basis: 33.333333%">
                            Ending Time : <input type="time" step="1800" required id="reserveStartingTime">
                        </div>

                    </div>
                    <div class="err-msg" id="errMsg">

                    </div>
            </div>

        </main>

        <?php
            require_once("footer.php");
        ?>
    </body>
    <script src="/js/general/reservation_validation.js"></script>
</html>