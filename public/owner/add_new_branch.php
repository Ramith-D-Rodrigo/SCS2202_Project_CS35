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
        <link rel="stylesheet" href="/styles/general/styles.css">
        <link rel="stylesheet" href="/styles/general/staff.css">
        <link rel="stylesheet" href="/styles/general/notification.css">
        <link rel="stylesheet" href="/styles/owner/add_new_branch.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css">
        <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>

        <title>Add New Branch</title>
    </head>

    <body>
        <?php require_once("header.php"); ?>

        <main class="body-container">
            <div class="content-box">
                <form>
                    <div class="row-container">
                        <div class="left-field">
                            City
                        </div>
                        <div class="right-field">
                            <textarea id="city" name="city" required pattern="[a-zA-Z]+"></textarea>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-field">
                            Address
                        </div>
                        <div class="right-field">
                            <textarea id="address" name="address" required></textarea>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Opening Time
                        </div>
                        <div class="right-field">
                            <input type="time" id="openingTime" name="openingTime" required>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Closing Time
                        </div>
                        <div class="right-field">
                            <input type="time" id="closingTime" name="closingTime" required>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Email Address
                        </div>
                        <div class="right-field">
                            <input id="email" name="email" required type="email">
                        </div>
                    </div>
                    
                    <div class="row-container">
                        <div class="left-field">
                            Opening Date
                        </div>
                        <div class="right-field">
                            <input type="date" id="openingDate" name="openingDate" required>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Offering Sports
                        </div>
                        <div class="right-field">
                            <!-- check box -->
                            <div class="sports-container" id="sports">
                            </div>
                        </div>
                    </div>
                    <div class="msg" id="msg"></div>
                    <div class="submit-btn-container">
                        <button type="submit">Add Branch</button>
                    </div>
                </form>
            </div>

            <div class="content-box">
                <div class="card-title">Location of the Branch</div>
                <div class="btn-container">
                    <button id="currLocation">Current Location</button>
                </div>
                <div class="map-container">
                    <div id="map">
                    </div>
                </div>
            </div>
        </main>
        <?php require_once("../../public/general/footer.php"); ?>
    </body>
    <script type="module" src="/js/owner/add_new_branch.js"></script>
    <script type="module" src="/js/general/notifications.js"></script>
</html>