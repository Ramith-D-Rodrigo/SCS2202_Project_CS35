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
        <link rel="stylesheet" href="/styles/owner/add_new_sport.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>Add New Sport</title>
    </head>
    <body>
        <?php require_once("header.php"); ?>

        <main class="body-container">
            <div class="content-box">
                <form id="sportForm">
                    <div class="row-container">
                        <div class="left-field">Name</div>
                        <div class="right-field">
                            <input type="text" name="name" id="name" required pattern="^[A-Z][a-zA-Z ]*$" title="First letter must be capital">
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">Description</div>
                        <div class="right-field">
                            <textarea name="description" id="description" cols="30" rows="8"></textarea>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">Reservation Price (Per Hour)</div>
                        <div class="right-field">
                            <input  name="reservationPrice" id="reservationPrice" required pattern="^[0-9]+$">
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">Re-enter Reservation Price</div>
                        <div class="right-field">
                            <input  name="reReservationPrice" id="reReservationPrice" required>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">Maximum Number of Players</div>
                        <div class="right-field">
                            <input type="number" name="maxPlayers" id="maxPlayers">
                        </div>
                    </div>

                    <div class="note">
                        Leave the Maximum Number of Players field empty, if you do not want coaching sessions for this sport.
                    </div>
                    <div class="msg"></div>
                    <div class="btn-container">
                        <button type="submit">Add</button>
                    </div>
                </form>
            </div>
        </main>
        <?php require_once("../../public/general/footer.php"); ?>

        <div id="authFormDiv" class="content-box">
            <form>
                <p style="text-align:center">Please Authenticate Yourself<br>to Add a New Sport</p>
                
                <p style="text-align:center"><i class="fas fa-user-lock" style="font-size:1.5rem"></i></p>
                <p id="authMsg" style="text-align:center"></p>
                <div style="display:flex; flex-direction:column">
                    <input type="text" name="username" id="username" placeholder="Username" required minlength="6" maxlength="15">
                    <input type="password" name="password" id="password" placeholder="Password" required>

                    <p style="text-align:center; margin-top:1rem; font-size:1.2rem">PLEASE DOUBLE CHECK THE INFORMATION THAT YOU HAVE PROVIDED</p>
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

    <script type="module" src="/js/owner/add_new_sport.js"></script>
    <script type="module" src="/js/general/notifications.js"></script>
</html>