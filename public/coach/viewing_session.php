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
                <div> <h2>Session Information</h2> </div>

              <label> Session ID: </label>  <input readonly type="text" name="session_id" ></input> 
              <label>  Time Slot :</label>  <input readonly type="text" name="time_slot" ></input> 
              <label>  Day : </label>  <input readonly type="text" name="day" ></input> 
              <label>  Court : </label>  <input readonly type="text" name="court" ></input> 
              <label>  Branch : </label>  <input readonly type="text" name="branch" ></input> 
              <label>  Session Fee : </label>  <input readonly type="text" name="session_fee" ></input> 
              <label>  Monthly Payment : </label>  <input readonly type="text" name="monthly_payment" ></input> 

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
                <div><h2>Registered Students</h2></div>
                <div><input readonly type="text" name="stname1"  ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname2" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname3" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname4" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <!-- <div><input readonly type="text" name="stname1"  ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname2" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname3" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname4" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div> -->



            </div>


        </div>


    
    </main>
    <?php
     require_once("../../public/general/footer.php");
    ?>
</body>

</html>