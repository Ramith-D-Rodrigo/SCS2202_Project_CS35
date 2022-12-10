<?php
    session_start();
    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is not logged in
        header("Location: /index.php");
        exit();
    }

    if($_SESSION['userrole'] !== 'user'){   //not an user (might be another actor)
        header("Location: /index.php");
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
        <title>Reservation History</title>
    </head>
    <body>
        <?php
            require_once("../../public/general/header.php");
        ?>
        <main>
            <div class="content-box" style="overflow-x:auto;" id="reservationHistoryBox">
            </div>
        </main>
        <?php
            require_once("../../public/general/footer.php");
            if(isset($_SESSION['reserveCancelSuccess'])){   //cancel alert
                $msg = $_SESSION['reserveCancelSuccess'];
                echo "<script type='text/javascript'>alert('$msg');</script>";
                unset($_SESSION['reserveCancelSuccess']);
            }
            else if(isset($_SESSION['reserveCancelError'])){
                $msg = $_SESSION['reserveCancelError'];
                echo "<script type='text/javascript'>alert('$msg');</script>";
                unset($_SESSION['reserveCancelSuccess']);
            }
        ?>    
    </body>
    <script src="/js/user/account_links.js"></script>
    <script src="/js/user/reservation_history.js"></script>
</html>