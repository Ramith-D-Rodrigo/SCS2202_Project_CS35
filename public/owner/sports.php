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
        <link rel="stylesheet" href="/styles/general/styles.css" />
        <link rel="stylesheet" href="/styles/owner/sports.css" />
        <link rel="stylesheet" href="/styles/general/staff.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>Sports</title>
    </head>

    <body>
        <?php require_once("header.php"); ?>
        <main class="body-container">
            <div class="content-box">
                <div class="options">
                    <div id="sportsFilter">
                        <select id="sportsFilter">
                        </select>
                    </div>
                    <div id="addSport">
                        <button onclick="window.location.href='/public/owner/add_sport.php'">Add New Sport <i class="fa-solid fa-person-running"></i></button>
                    </div>
                </div>

                <div class="sport-container">
                    <div class="sport-info">
                        <form id="displayForm">
                            <div class="row-container">
                                <div class="left-field">Description</div>
                                <div class="right-field">
                                    <textarea id="description" rows="4" cols="50" readonly></textarea>
                                </div>
                            </div>
                            <div class="row-container">
                                <div class="left-field">Maximum Number of Players</div>
                                <div class="right-field">
                                    <input type="number" id="maxPlayers"  min="1" max="100"readonly>
                                </div>
                            </div>
                            <div class="row-container">
                                <div class="left-field">Current Reservation Price</div>
                                <div class="right-field">
                                    <input type="number" id="reservationPrice" readonly>
                                </div>
                            </div>
                        </form>

                        <div id="changeTitle">
                            Want to Change some Information?
                        </div>

                        <form id="changeForm">
                            <div class="row-container">
                                <div class="left-field">New Reservation Price</div>
                                <div class="right-field">
                                    <input type="number" id="newPrice" name="newPrice" required>
                                </div>
                            </div>
                            <div class="row-container">
                                <div class="left-field">New Maximum Number of Players</div>
                                <div class="right-field">
                                    <input type="number" id="newMaxPlayers" name="newMaxPlayers" min="1" max="100" required>
                                </div>
                            </div>
                            <div class="note">
                                If you only wish to change one item, enter the current value of the one that is not being changed as the new value.
                            </div>
                            <div class="btn-container">
                                <button type="submit" id="changeBtn">Change</button>
                            </div>
                        </form>
                    </div>

                    <div class="sport-img-div">
                        <div class="sport-icon-container">
                            <img id="sport-icon" src="" alt="Sport Image" onerror="this.src='/styles/icons/no-results.png'"/>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <?php require_once("../../public/general/footer.php"); ?>
    </body>
</html>