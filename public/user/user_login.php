<?php
    session_start();
    if(isset($_SESSION['userrole']) && isset($_SESSION['userid'])){  //if the user is logged in previously (not at the login time)
        header("Location: /index.php"); //the user shouldn't be able to access the login page
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <title>User Log In</title>
    </head>

    <body>
        <?php
         require_once("../general/header.php");
        ?>
        <main class="body-container">
            <div class="content-box">
                <form action="/controller/general/login_controller.php" method="post" id="loginForm">
                    Username : 
                    <input
                    type="text" 
                    required 
                    minlength="6" 
                    maxlength="15"
                    pattern="^[a-z]([a-z0-9_]){5,15}"
                    name="username"
                    id="username">
                    <br>

                    <div>
                    Password : 
                        <input 
                        type="password"  
                        id="password"
                        name="password"
                        required> 
                        <button id="togglePassword">Show Password</button><br>
                    </div>
                    <div class='err-msg' id="errmsgbox">
                    </div>
                    <div class='success-msg' id='successmsgbox'>
                    </div>
                    <div class="btn-container">
                        <button type="submit" 
                            id="loginBtn"  
                            name= "loginSubmitBtn" 
                            value="submit" 
                            onclick="return validateForm(event)"> Log in </button>
                    </div>
                </form>
                <div class="btn-container">
                    New User? <button onclick="window.location.href='/public/general/register.php'" id="regBtn">Register</button>
                </div>
            </div>
        </main>
        <?php
            require_once("../general/footer.php");
        ?>
    </body>
    <script src="/js/general/login_form.js"></script>
    <script src="/js/user/coach_login_handle.js"></script>
    <script src="/js/user/coach_login_validation.js"></script>
</html>