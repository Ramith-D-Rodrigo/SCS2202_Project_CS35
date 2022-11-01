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
        <title>User Log In</title>
    </head>

    <body>
        <?php
            require_once("../general/header.php");
        ?>
        <div>
            <form>
                Username : 
                <input
                type="text" 
                required 
                minlength="6" 
                maxlength="15"
                pattern="^[a-z]([a-z0-9_]){5,15}"
                name="username"
                id="username"
                value=<?php if(isset($_SESSION['username'])) echo htmlspecialchars($_SESSION['username'], ENT_QUOTES)?>>
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
                <div id="errmsg">
                    <?php
                        if(isset($_SESSION['usernameError'])){
                            echo $_SESSION['usernameError'];
                            echo '<br>';
                        }
                        if(isset($_SESSION['passwordError'])){
                            echo $_SESSION['passwordError'];
                            echo '<br>';
                        }

                        if(isset($_SESSION['successMsg'])){
                            echo $_SESSION['successMsg'];
                            echo '<br>';
                        }
                    ?>
                </div>
                <button type="submit" id="login"  name= "loginSubmitBtn" value="submit" onclick="return validateForm(event)"> LOG IN </button>
            </form>
        </div>

        <?php
            require_once("../general/footer.php");
        ?>
    </body>
    <script src="/js/user/user_login_handle.js"></script>
    <script src="/js/user/user_login_validate.js"></script>
</html>