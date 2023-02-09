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
    

        <div class="flex-container">
            <div class="tabs">
                <div>Session Information</div>

                Session ID      : <output type="text" name="session_id" ></output> 
                Time Slot       : <output type="text" name="time_slot" ></output> 
                Day             : <output type="text" name="day" ></output> 
                Court           : <output type="text" name="court" ></output> 
                Branch          : <output type="text" name="branch" ></output> 
                Session Fee     : <output type="text" name="session_fee" ></output> 
                Monthly Payment : <output type="text" name="monthly_payment" ></output> 

                <div class="tabs-btn">
                        <div ><button>Send Message</button></div>
                        <div ><button>View Request</button></div>
                        <div ><button>Make Payment</button></div>
                        <div class="tabs-btn1" >
                            <div ><button>Income & Payment</button></div>
                            <div ><button>Cancel Session</button></div> 
                        </div>
                    </div>

            </div>
            

            <div class="tabs">
                <div>Registered Students</div>
                <div><outout type="text" name="stname1" value="st" ></outout>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><outout type="text" name="stname2" value="st"></outout>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><outout type="text" name="stname3" value="st"></outout>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><outout type="text" name="stname4" value="st"></outout>  <button onclick="window.location.href='student_profile.php'">View more</button></div>



            </div>


        </div>


    
    </main>
    <?php
     require_once("../../public/general/footer.php");
    ?>
</body>

</html>