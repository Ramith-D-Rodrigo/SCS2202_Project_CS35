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
       <title>Manager Log In</title>
    </head>

    <body>
        <?php
            require_once("../general/header.php");
        ?>
        <main class="body-container">
            <div class="content-box">
                <form action="/controller/manager/login_controller.php" method="post" id="loginForm">
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
                    <div id="msgbox">
                        <?php
                           if(isset($_SESSION['errMsg'])){
                               echo $_SESSION['errMsg'];
                               echo '<br>';
                               unset($_SESSION['errMsg']);
                           }

                           if(isset($_SESSION['LogInsuccessMsg'])){
                              echo $_SESSION['LogInsuccessMsg'];
                              echo '<br> You will be Redirected to the Home page. Please Wait';
                              unset($_SESSION['LogInsuccessMsg']);
                              header("Refresh: 3; URL =/index.php");
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
                                ?>> Log in </button>
                    </div>
                </form>
            </div>
        </main>
        <?php
            require_once("../general/footer.php");
        ?>
    </body>
</html>
