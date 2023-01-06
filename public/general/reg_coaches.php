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
        <link rel="stylesheet" href="/styles/general/reg_coaches.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Registered Coaches</title>
    </head>
    <body>
        <?php
            require_once("header.php");
        ?>
        <main class="body-container">
            <div class="content-box" style="align-items:center">
                <div id="filter">
                    Filter By : 
                    <select id="sportSelect">
                        <option value="">Sport</option>
                    </select>
                </div>
                <div id="coachList">
                </div>
            </div>
        </main>
        <?php
            require_once("footer.php");
        ?>
    </body>
    <script src="/js/user/account_links.js"></script>
    <script src="/js/general/reg_coaches.js"></script>
</html>