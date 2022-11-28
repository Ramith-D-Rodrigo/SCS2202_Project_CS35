<?php
    session_start();
    if((isset($_SESSION['userrole']) && isset($_SESSION['userid']) && !isset($_SESSION['LogInsuccessMsg']))){  //if the receptionist is already logged in 
        header("Location: /public/receptionist/receptionist_dashboard.php"); //the receptionist shouldn't be able to access the login page
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
        <title>Receptionist Log In</title>
    </head>

    <body>
        <?php
            require_once("dashboard_header.php");
        ?>
        <main class="body-container">
        <div class="content-box">
            <form action="/controller/receptionist/login_controller.php" method="post" id="loginForm">
                <div>   
                    Username : 
                    <input
                    type="text" 
                    required 
                    minlength="6" 
                    maxlength="15"
                    pattern="^[a-z]([a-z0-9_]){5,15}"
                    name="username"
                    id="username">
                </div> 
                <br>
                <div>
                    Password : 
                    <input 
                    type="password"  
                    pattern="(?=.*\d)(?=.*[A-Z]).{8,}" 
                    minlength="8"
                    id="password"
                    name="password"
                    required> 
                    <button id="togglePassword">Show Password</button><br>
                </div>
                <div class = 'err-msg' id="msgbox">
                    <?php
                        if(isset($_SESSION['errMsg'])){
                            echo $_SESSION['errMsg'];
                            echo '<br>';
                            unset($_SESSION['errMsg']);
                        }
                    ?>
                </div>
                <div class = 'success-msg' id="msgbox">
                    <?php
                        if(isset($_SESSION['LogInsuccessMsg'])){
                            echo $_SESSION['LogInsuccessMsg'];
                            echo '<br> You will be Redirected to the Dashboard. Please Wait...';
                            unset($_SESSION['LogInsuccessMsg']);
                            header("Refresh: 3; URL =/public/receptionist/receptionist_dashboard.php");   
                        }
                    ?>
                </div>
                <div class="btn-container">
                    <button type="submit" 
                        id="login"  
                        name= "loginSubmitBtn" 
                        value="submit" 
                        onclick="return validateForm(event)"
                        <?php
                        if(isset($_SESSION['userrole'])){
                        ?>
                            disabled
                        <?php
                        }
                        else{
                        ?> 
                            
                        <?php
                        }
                    ?>> LOG IN </button>
                </div>    
            </form>
        </div>
        </main>
        <?php
            require_once("../general/footer.php");
        ?>
    </body>
    <script src="/js/receptionist/receptionist_login_handle.js"></script>
    <script src="/js/receptionist/receptionist_login_validation.js"></script>
</html>