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
        <link rel="stylesheet" href="/styles/coach/income_payment.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="stylesheet" href="../../styles/coach/coach.css">

        <title>Income & Payment</title>
    </head>
    <body>
        <?php
            require_once("dashboard_header.php");
        ?>
     <main>
       <div class="flex-container" >            
              <div class="tabs">
                <div>Income</div>
                  <div>
                    <select class="select">
                        <option>Date period</option>
                    </select>
                      <div class="ul"> 
                        <ul>
                            <li><output></output></li><br>
                            <li><output></output></li><br>
                            <li><output></output></li><br>
                            <li><output></output></li>

                        </ul>
                      </div>
                  </div>
              </div>

            <div class="tabs">
                <div>Payment</div>
                 <div>
                     <select class="select">
                        <option>Session</option>
                     </select>
                       <div class="ul"> 
                            <ul>
                                <li><output></output></li><br>
                                <li><output></output></li><br>
                                <li><output></output></li><br>
                                <li><output></output></li>

                            </ul>
                        </div>
                 </div>
            </div>
              
        </div>
     </main>
        <?php
            require_once("../../public/general/footer.php");
        ?>
    </body>
    <!-- <script src="/js/user/account_links.js"></script>
    <script src="/js/general/our_feedback.js"></script> -->
</html>