<?php
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: TRUE)){ //cannot access (NOT operator)
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
                <link rel="stylesheet" href="/styles/general/register_page.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
                <title>Registration</title>
            </head>

            <body>
                <?php
                    require_once("header.php");
                ?>
                <main style="display:flex; justify-content:center; align-items:center">
                    <div class="content-box">
                        <div>
                            <div style="text-align:center; margin: 20px;">Which One?</div>
                            <div class="register-options-container">
                                <div class="register-option">
                                    <img src="/styles/icons/user.svg" class="register-imgs">
                                    Register as a User
                                    <button onclick="window.location.href='/public/user/user_register.php'">REGISTER</button>
                                </div>
                                <div class="register-option">
                                    <img src="/styles/icons/coach.svg" class="register-imgs">
                                    Register as a Coach
                                    <button onclick="window.location.href='/public/coach/coach_register.php'">REGISTER</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php
                    require_once("footer.php");
                ?>
            </body>
            <script src="/js/user/account_links.js"></script>
        </html>
    <?php
    }
?>