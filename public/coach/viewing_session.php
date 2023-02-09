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
                <div> <h3>Session Information</h3> </div>

             <div > <label> Session ID: </label>  <input readonly type="text" name="session_id" ></input> </div>
             <div > <label>  Time Slot :</label>  <input readonly type="text" name="time_slot" ></input> </div>
             <div > <label>  Day : </label>  <input readonly type="text" name="day" ></input> </div>
             <div > <label>  Court : </label>  <input readonly type="text" name="court" ></input> </div>
             <div > <label>  Branch : </label>  <input readonly type="text" name="branch" ></input> </div>
             <div > <label>  Session Fee : </label>  <input readonly type="text" name="session_fee" ></input> </div>
             <div > <label>  Monthly Payment : </label>  <input readonly type="text" name="monthly_payment" ></input> </div> 

                <div class="tabs-btn">
                        <div ><button onclick="window.location.href='notify_student.php'">Send Message</button></div>
                        <div ><button onclick="window.location.href='student_request.php'">View Request</button></div>
                        <div ><button onclick="window.location.href=''">Make Payment</button></div>
                        <div class="tabs-btn1" >
                            <div ><button onclick="window.location.href='income_payment.php'">Income & Payment</button></div>
                            <div ><button onclick="window.location.href='coach_dashboard.php'">Cancel Session</button></div> 
                        </div>
                    </div>

            </div>
            

            <div class="tabs">
                <div><h3>Registered Students</h3></div>
                <div><input readonly type="text" name="stname1"  ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname2" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname3" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname4" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname1"  ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname2" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname3" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>
                <div><input readonly type="text" name="stname4" ></input>  <button onclick="window.location.href='student_profile.php'">View more</button></div>



            </div>


        </div>


    
    </main>
    <?php
     require_once("../../public/general/footer.php");
    ?>
</body>

</html>