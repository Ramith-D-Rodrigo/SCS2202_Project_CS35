<?php
    session_start();
    if(!(isset($_SESSION['username']) && isset($_SESSION['userrole']) && $_SESSION['userrole'] === 'coach')){
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
    <link rel="stylesheet" href="../../styles/general/styles.css">
    <link rel="stylesheet" href="../../styles/coach/coach_dashboard.css">

    <title>Dashboard</title>
</head>

<body>
    <?php
    require_once("header.php");
    ?>

    
    <main>
    <div class="main-body">





        <div class="flex-container">
            <div class="tabs">
                <div>Today Session</div>
                <div><button onclick="window.location.href='/controller/coach/coaching_session_controller.php'">View more</button></div>
            </div>

            <div class="tabs">
                <div>Payment</div>
                <div><button>View more</button></div>
            </div>

            <div class="tabs">
                <div>Feedback</div>
                <div><button>View more</button></div>
            </div>

        </div>




        

           

    </div>
    </main>
    <?php
    require_once("footer.php");
    ?>
</body>

</html>