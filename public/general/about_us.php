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
                <title>About Us</title>
            </head>
            <body>
                    <?php
                        require_once("header.php");
                    ?>
                    About Us
                    <br>
                    <?php
                        require_once("footer.php");
                    ?>
            </body>
            <script src="/js/user/account_links.js"></script>
        </html>
    <?php
    }
?>