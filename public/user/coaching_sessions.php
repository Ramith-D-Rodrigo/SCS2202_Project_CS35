<?php
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){ //cannot access (NOT operator)
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
                <link rel="stylesheet" href="/styles/general/our_sports.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>Our Sports</title>
            </head>
            <body>
                <?php
                    require_once("../../public/general/header.php");
                ?>
                <main>
                    <div class="body-container">
                        <div class="content-box" style="flex-direction:row">
                            <div>
                                Status
                                <select id="statusFilter">
                                    <option value="all">All</option>
                                    <option value="pending">Pending</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="left">Left</option>
                                </select>
                            </div>

                            <div>
                                Sport
                                <select id="sportFilter">
                                    <option value="all">All</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="body-container" id="coachingSessionsContainer">
                    </div>
                </main> 

                <?php
                    require_once("../../public/general/footer.php");
                ?>
            </body>
            <script src="/js/user/account_links.js"></script>
            <script type="module" src="/js/user/coaching_sessions.js"></script>
        </html>
    <?php
    }
?>