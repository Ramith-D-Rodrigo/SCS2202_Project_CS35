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
        <?php
                require_once("../general/footer.php");
        ?>
    </body>
    <script type="module" src="/js/general/notifications.js"></script>
    <script type="module" src="/js/owner/reservation_schedule.js"></script>
</html>
