<?php
    session_start();

    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the coach is not logged in
        header("Location: /index.php");
        exit();
    }

    // if($_SESSION['userrole'] !== 'coach'){   //not an coach (might be another actor)
    //     header("Location: /index.php");
    //     exit();
    // }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <link rel="stylesheet" href="/styles/coach/notify_student.css">
        <title>Notify Student</title>
    </head>
    <body>
        <?php
            require_once("dashboard_header.php");
        ?>
        <div class="container">
            <div class="h3" ><h3>Message</h3></div>
            <div class="label">
                <label>Session ID :</label>
                <label>Branch ID :</label>
            </div>
            <div class="input"> <input type="text" class="msg" placeholder="Type your message here"> </div>
            <div class="button">
                <button>send</button>
                <button>cancel</button>

            </div>

        </div>
       
        <?php
            require_once("../../public/general/footer.php");
        ?>
    </body>
    <!-- <script src="/js/user/account_links.js"></script>
    <script src="/js/general/our_feedback.js"></script> -->
</html>