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
        <title>Log in page</title>
    </head>
    <body>
            <?php
                require_once("header.php");
            ?>
            <a href="../user/user_login.php" style="color:black"> Log in as an User</a>
            <br>
            <?php
                require_once("footer.php");
            ?>
    </body>
</html>