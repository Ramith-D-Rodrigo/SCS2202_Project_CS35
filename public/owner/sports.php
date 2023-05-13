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
        <link rel="stylesheet" href="/styles/owner/styles.css" />
        <link rel="stylesheet" href="/styles/owner/sports.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>Sports</title>
    </head>

    <body>
        <?php require_once("header.php"); ?>
        <main class="body-container">
            <div class="content-box">
                <div class="options">
                    <div>
                        <select id="sportsFilter">
                        </select>
                    </div>
                    <div id="addSport">
                        <button onclick="window.location.href='/public/owner/add_new_sport.php'">Add New Sport <i class="fa-solid fa-person-running"></i></button>
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
                                <div class="left-field">Current Reservation Price (Per Hour)</div>
                                <div class="right-field">
                                    <input id="reservationPrice" readonly>
                                </div>
                            </div>
                            <div class="row-container">
                                <div class="left-field">Minimum Coaching Session Price (Per Hour)</div>
                                <div class="right-field">
                                    <input id="minCoachingSessionPrice" readonly>
                                </div>
                            </div>
                        </form>

                        <div id="changeTitle">
                            Want to Change some Information?
                        </div>

                        <form id="changeForm">
                            <input type="hidden" id="sportID" name="sportID">
                            <div class="row-container">
                                <div class="left-field">New Description</div>
                                <div class="right-field">
                                    <textarea id="newDescription" name="newDescription"></textarea>
                                </div>
                            </div>
                            <div class="row-container">
                                <div class="left-field">New Reservation Price (Per Hour)</div>
                                <div class="right-field">
                                    <input type="number" id="newPrice" name="newPrice">
                                </div>
                            </div>
                            <div class="row-container">
                                <div class="left-field">New Calculated Minimum Coaching Session Price (Per Hour)</div>
                                <div class="right-field">
                                    <input id="newCoachingSessionPrice" readonly>
                                </div>
                            </div>
                            <div class="row-container">
                                <div class="left-field">New Maximum Number of Players</div>
                                <div class="right-field">
                                    <input type="number" id="newMaxPlayers" name="newMaxPlayers" min="1" max="100">
                                </div>
                            </div>
                            <div class="note">
                                Keep the field empty that you do not want to change.
                            </div>
                            <div class="msg" id="msg">  
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
        <div id="authFormDiv" class="content-box">
            <form>
                <p style="text-align:center">Please Authenticate Yourself<br>to Make Changes</p>
                <p style="text-align:center"><i class="fas fa-user-lock" style="font-size:1.5rem"></i></p>
                <p id="authMsg" style="text-align:center"></p>
                <div style="display:flex; flex-direction:column">
                    <input type="text" name="username" id="username" placeholder="Username" required minlength="6" maxlength="15">
                    <input type="password" name="password" id="password" placeholder="Password" required>

                    <div class="btn-container">
                        <button id="togglePasswordBtn">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="submit">
                            <i class="fas fa-sign-in-alt"></i>
                        </button>
                    </div>
                    <div id="altMsg"></div>
                </div>
            </form>
        </div>
    </body>
    <script type="module" src="/js/owner/sports.js"></script>
    <script type="module" src="/js/owner/change_reservation_price.js"></script>
    <script type="module" src="/js/general/notifications.js"></script>
</html>