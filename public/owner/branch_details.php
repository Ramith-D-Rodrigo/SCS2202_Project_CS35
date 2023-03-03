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
        <link rel="stylesheet" href="/styles/owner/branch_details.css">
        <link rel="stylesheet" href="/styles/general/staff.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>Branch Details</title>
    </head>

    <body>
        <?php require_once("header.php"); ?>

        <main class="body-container">
            <div class="content-box">
                <div class="options">
                    <select id="branchFilter">
                        <option value="">Branch</option>
                    </select>
                    <button id="addBranch">
                        New Branch ?
                        <i class="fa-solid fa-building-circle-arrow-right"></i>
                    </button>
                </div>

                <form id="branchContainer">
                    <div class="row-container">
                        <div class="left-field">
                            Address
                        </div>
                        <div class="right-field">
                            <textarea id="address" readonly></textarea>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-field">
                            Manager
                        </div>
                        <div class="right-field">
                            <input type="text" id="manager" readonly>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-field">
                            Receptionist
                        </div>
                        <div class="right-field">
                            <input type="text" id="receptionist" readonly>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-field">
                            Started Date
                        </div>
                        <div class="right-field">
                            <input type="text" id="startDate" readonly>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-field">
                            Opening Time
                        </div>
                        <div class="right-field">
                            <input type="text" id="openingTime" readonly>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-field">
                            Closing Time
                        </div>
                        <div class="right-field">
                            <input type="text" id="closingTime" readonly>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-field">
                            Email Address
                        </div>
                        <div class="right-field">
                            <input type="text" id="email" readonly>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-field">
                            Contact Numbers
                        </div>
                        <div class="right-field">
                            <select id="contactNumbers" readonly>
                            </select>
                        </div>
                    </div>
                    <div class="row-container sport-view">
                        <div class="left-field">
                            Providing Sports
                        </div>
                        <div class="right-field">
                            <select type="text" id="sports" readonly>
                            </select>
                            <div id="courtDiv">
                                Number of Courts <input id="courtCount">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="content-box">
                <div class="card-title">Feedback</div>
                <div id="currRating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <div id="userFeedback" class="card-content">
                </div>
            </div>
        </main>

        <?php require_once("../../public/general/footer.php"); ?>
    </body>
    <script type="module" src="/js/owner/branch_details.js"></script>
</html>