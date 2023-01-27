<?php
    session_start();
    if((isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is logged in
        header("Location: /index.php"); //the user shouldn't be able to access the register page
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>Password Reset</title>
    </head>
    <body>
        <?php
         require_once("../general/header.php");
        ?>
        <main class="body-container">
            <div class="content-box">
               
                <form>
                    <div id="inputDiv">
                        Enter your Email Address or Username :
                        <input placeholder="Email Address or Username" name="userInput" id="userInput" required minlength="5">
                    </div>
                    <div class='err-msg' id="errmsgbox">
                    </div>
                    <div class='success-msg' id='successmsgbox'>
                    </div>
                    <div class="btn-container" id="btnContainer">
                        <button type="submit" 
                            id="checkBtn"  
                            name= "checkSubmitBtn"
                            value="submit" 
                            onclick="return validateForm(event)"> Check </button>
                    </div>
                </form>
                <div id="resetBox"></div>
            </div>
        </main>
        <?php
            require_once("../general/footer.php");
        ?>
    </body>

    <script src="/js/general/password_reset.js"></script>
</html>