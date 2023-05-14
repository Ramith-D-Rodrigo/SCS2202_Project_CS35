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
                <link rel="stylesheet" href="/styles/general/login.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>Log in</title>
            </head>
            <body>
                <?php
                require_once("../general/header.php");
                ?>
                <main class="body-container">
                    <div class="content-box login-box">
                        <div class="login-img-container">
                            <img class="login-img" src="/styles/login_img.webp">
                        </div>
                        <div class="login-form">
                            <form id="loginForm">
                                <div class="credentials">
                                    <div class="username">
                                        Username  
                                        <input
                                        type="text" 
                                        required 
                                        minlength="6" 
                                        maxlength="15"
                                        pattern="^[a-z]([a-z0-9_]){5,15}"
                                        name="username"
                                        id="username">
                                    </div>
                                    <div class="password">
                                        Password  
                                            <input 
                                            type="password"  
                                            id="password"
                                            name="password"
                                            required> 
                                            <button id="togglePassword"><i class="fa-solid fa-eye"></i></button>
                                    </div>
                                </div> 
                                <div class='err-msg msg' id="errmsgbox">
                                </div>
                                <div class='success-msg msg' id='successmsgbox'>
                                </div>
                                <div class="btn-container">
                                    <button type="submit" 
                                        id="loginBtn"  
                                        name= "loginSubmitBtn" 
                                        value="submit" 
                                        onclick="return validateForm(event)"> Log in </button>
                                </div>
                            </form>
                            <div id="accActivationBox"></div>
                                <div class="btn-container">
                                    Forgot Password? <button onclick="window.location.href='/public/general/password_reset.php'" id="forBtn">Click Here</button>
                                </div>
                                <div class="btn-container">
                                    New User? <button onclick="window.location.href='/public/general/register.php'" id="regBtn">Register</button>
                                </div>
                            </div>
                        </div>

                </main>
                <?php
                    require_once("../general/footer.php");
                ?>
            </body>
            <script src="/js/general/login_form.js"></script>
            <script type="module" src="/js/general/login_handle.js"></script>
            <script src="/js/general/login_validation.js"></script>
        </html>
    <?php
    }
?>

