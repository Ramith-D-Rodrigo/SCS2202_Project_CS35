<?php
    session_start();
    if(!(isset($_SESSION['userid']) && isset($_SESSION['userrole']))) {
        header("Location: /public/receptionist/receptionist_login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Receptionist's Dashboard</title>
  <link rel="stylesheet" href="/styles/general/styles.css">
  <link rel="stylesheet" href="/styles/general/staff.css">
  <link rel="stylesheet" href="/styles/receptionist/receptionistDashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

</head>
<body>
<?php
        require_once("dashboard_header.php");
?>
<main>
    <div class="body-container dashboard-cards">
            <div  class="content-box single-card">
                <div class="card-title"> Reservations</div> 
                <div id="reservations"></div>
                <div class="card-button"> <button onclick="window.location.href='/public/receptionist/view_reservations.php'"> View More </button> </div>
            </div>
            <div  class="content-box single-card">
                <div> Onsite Reservation</div> 
                <div id="onlineR"></div>
                <div class="card-button"> 
                    <button onclick="window.location.href='/public/receptionist/onsite_reservation_entry.php'"> Add </button> 
                    <button onclick="window.location.href='/public/receptionist/cancel_onsite_reservations.php'"> Cancel </button>
                </div>
                
            </div>
            <div class="content-box single-card">
                <div>Branch Details</div> 
                <div id="branch"></div>
                <div> <button onclick="window.location.href='/public/receptionist/edit_branch.php'"> Edit</button> </div>
            </div>   
            <div  class="content-box single-card">
                <div> View Profiles</div> 
                <div id="profiles"></div>
                <div> 
                    <button onclick="window.location.href='/public/receptionist/view_coach_profiles.php'"> View Coach Profiles </button> 
                    <button onclick="window.location.href='/public/receptionist/view_user_profiles.php'"> View User Profiles   </button> 
                </div>
            </div>
            <div class="content-box single-card">
                <div>Request Maintenance</div> 
                <div id="maintenance"></div>
                <div> <button onclick="window.location.href='/public/receptionist/request_maintenance.php'" > Add </button> </div>
            </div>  

    </div>
</main>
<?php
        require_once("../general/footer.php");
?>
</body>
</html>
