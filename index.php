<?php
    session_start();
    require_once("src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: FALSE)){       //cannot access (NOT operator)
        Security::redirectUserBase();
    }
    else{
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Sports Complex</title>
                <link rel="stylesheet" href="./styles/general/styles.css">
                <link rel="stylesheet" href="./styles/general/index.css">
                <link rel="stylesheet" href="./styles/general/notification.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
            </head>
            <body>
                <?php
                    require_once("./public/general/header.php");
                ?>
                <main>
                    <div class="search">
                        <form action="/public/general/search_results.php" method="get" id="searchBar" style="min-width:80%">
                            <input class="search-input" type="text" name="sportName" placeholder="Search a Sport" pattern="[a-zA-Z]+" title="Enter The Name Correctly" required>
                            <button class ="search-icon-btn" type="submit" onclick="return searchValidation(event)">Search</button>
                        </form>
                    </div>
                    <div class="slider">
                        <div class="slides">
                            <input type="radio" name="radio-btn" id="radio1">
                            <input type="radio" name="radio-btn" id="radio2">
                            <div class="slide first">
                                <img class="landing-img" id="landing-img1" src="/styles/landing_res.png">
                                <button id="reservationBtn" onclick="window.location.href='/public/general/our_sports.php'">Make a Reservation Now!</button>
                            </div>
                            <div class="slide">
                                <img class="landing-img" id="landing-img2" src="/styles/landing_coach.png">
                                <button id="coachBtn" onclick="window.location.href='/public/general/reg_coaches.php'">Choose Your Trainer!</button>
                            </div>
                            <div class="navigation-auto">
                                <div class="auto-btn1"></div>
                                <div class="auto-btn2"></div>
                            </div>
                        </div>
                        <div class="navigation-manual">
                            <label for="radio1" class="manual-btn active"></label>
                            <label for="radio2" class="manual-btn"></label>
                        </div>
                    </div>
                </main>
                <?php
                    require_once("./public/general/footer.php");
                ?>
            </body>
            <script src="/js/general/search_validation.js"></script>
            <script src="/js/general/index_animation.js"></script>
            <script src="/js/user/account_links.js"></script>
            <script type="module" src="/js/general/notifications.js"></script>
        </html>

    <?php
    }
?>

