<?php
    session_start();
    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the coach is not logged in
        header("Location: /index.php");
        exit();
    }

    if($_SESSION['userrole'] !== 'coach'){   //not an coach (might be another actor)
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
    <link rel="stylesheet" href="../../styles/coach/viewing_session.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../../styles/coach/coach.css">


    <title>Dashboard</title>
</head>

<body>
    <?php
        require_once("dashboard_header.php");
    ?>

    
    <main>
    <div class="main-body">

        <div class="flex-container">
            <div class="tabs">
                <div>Session Information</div>

                Session ID      : <outout type="text" name="session_id" ></outout> <br>
                Time Slot       : <outout type="text" name="time_slot" ></outout> <br>
                Day             : <outout type="text" name="day" ></outout> <br>
                Court           : <outout type="text" name="court" ></outout> <br>
                Branch          : <outout type="text" name="branch" ></outout> <br>
                Session Fee     : <outout type="text" name="session_fee" ></outout> <br>
                Monthly Payment : <outout type="text" name="monthly_payment" ></outout> <br>

                        <div><button>Send Message</button></div>
                        <div><button>View Request</button></div>
                        <div><button>Make Payment</button></div>
                        <div><button>Income & Payment</button></div>
                        <div><button>Cancel Session</button></div>
            </div>

            <div class="tabs">
                <div>Registered Students</div>
                <div><outout type="text" name="stname1" value="st"></outout>  <button>View more</button></div>
                <div><outout type="text" name="stname2" value="st"></outout>  <button>View more</button></div>
                <div><outout type="text" name="stname3" value="st"></outout>  <button>View more</button></div>
                <div><outout type="text" name="stname4" value="st"></outout>  <button>View more</button></div>



            </div>


        </div>


    </div>
    </main>
    <?php
     require_once("../../public/general/footer.php");
    ?>
</body>

</html>