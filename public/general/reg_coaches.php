<?php
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: FALSE)){ //cannot access (NOT operator)
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
                <link rel="stylesheet" href="/styles/general/styles.css">
                <link rel="stylesheet" href="/styles/general/reg_coaches.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
                <title>Registered Coaches</title>
            </head>
            <body>
                <?php
                    require_once("header.php");
                ?>
                <main>
                    <div class="body-container">
                        <div class="content-box">
                            <div id="filter">
                                Filter By 
                                <select id="sportSelect">
                                    <option value="">Sport</option>
                                </select>

                                Show 
                                <select id="showSelect">
                                    <option value="">All</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="body-container" id="coachList">
                    </div>
                </main>
                <?php
                    require_once("footer.php");
                ?>
            </body>
            <script src="/js/user/account_links.js"></script>
            <script src="/js/general/reg_coaches.js"></script>
            <script type="module" src="/js/general/notifications.js"></script>
        </html>

    <?php
    }
?>