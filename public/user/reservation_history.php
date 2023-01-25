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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="stylesheet" href="/styles/user/cancel_reservation.css">
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
        <div id="authFormDiv" class="content-box">
                <form>
                    <p style="text-align:center">Please Authenticate Yourself<br>to Cancel the Reservation</p>
                    <p style="text-align:center"><i class="fas fa-user-lock" style="font-size:1.5rem"></i></p>
                    <p id="authMsg" style="text-align:center"></p>
                    <div style="display:flex; flex-direction:column">
                        <input type="text" name="username" id="username" placeholder="Username" required minlength="6" maxlength="15">
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <div class="err-msg"></div>
                        <div class="success-msg"></div>

                        <div style="display:flex; flex-direction:row; justify-content:space-between">
                            <button style="width:25%;" type="submit">
                                <i class="fas fa-sign-in-alt"></i>
                            </button>
                            <button style="width:25%;" id="authCancel">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div id="altMsg"></div>
                    </div>
                </form>
        </div>

        <div class="content-box" id="msgBox">
            <div style="text-align:center">
                <div id="msg" style="display:flex; flex-direction:column"> ajhsdgajsdg jha jhsdg ajhs jhdasg jhd a</div>
            </div>
            <div style="text-align:center; margin-top: 3rem">
                <span id="dismiss">
                    Dismiss <i class="fas fa-times"></i>
                </span>
            </div>
        </div>
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
    <script type="module" src="/js/user/reservation_history.js"></script>
</html>