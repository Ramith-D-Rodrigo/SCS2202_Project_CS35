<?php
    session_start();
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
            <div class="landing-imgs">
                <div class="landing-img" id="landing-img1">
                        <button id="reservationBtn" onclick="window.location.href='/public/general/our_sports.php'">Make a Reservation Now!</button>
                </div>
                <div class="landing-img" id="landing-img2">
                    <button id="coachBtn" onclick="window.location.href='/public/general/reg_coaches.php'">Choose Your Trainer!</button>
                </div>
            </div>
        </main>
        <?php
            require_once("./public/general/footer.php");
        ?>
    </body>
    <script src="/js/general/search_validation.js"></script>
    <script src="/js/user/account_links.js"></script>
</html>