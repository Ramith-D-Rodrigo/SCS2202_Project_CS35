<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
        Security::redirectUserBase();
        die();
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
                    <div id="reservations" class="card-content"></div>
                    <div class="card-button"> <button onclick="window.location.href='/public/receptionist/view_reservations.php'"> View More </button> </div>
                </div>
                <div class="content-box single-card">
                    <div class="card-title"> Onsite Reservation</div> 
                    <div id="onlineR" class="card-content"></div>
                    <div class="card-button"> 
                        <button onclick="window.location.href='/public/receptionist/onsite_reservation_entry.php'"> Add </button> 
                        <button onclick="window.location.href='/public/receptionist/cancel_onsite_reservations.php'"> Cancel </button>
                    </div>
                    
                </div>
                <div class="content-box single-card">
                    <div class="card-title">Branch Details</div> 
                    <div id="branch" class="card-content"></div>
                    <div class="card-button"> <button onclick="window.location.href='/public/receptionist/edit_branch.php'"> Edit</button> </div>
                </div>   
                <div class="content-box single-card">
                    <div class="card-title"> View Profiles</div> 
                    <div id="profiles" class="card-content"></div>
                    <div class="card-button"> 
                        <button onclick="window.location.href='/public/receptionist/view_coach_profiles.php'"> View Coach Profiles </button> 
                        <button onclick="window.location.href='/public/receptionist/view_user_profiles.php'"> View User Profiles   </button> 
                    </div>
                </div>
                <div class="content-box single-card">
                    <div class="card-title">Revenue</div> 
                    <div id="revenue" class="card-content"></div>
                    <div class="card-button"> <button onclick="window.location.href='/public/receptionist/branch_revenue.php'" > View More </button> </div>
                </div> 
                <div class="content-box single-card">
                    <div class="card-title">Request Maintenance</div> 
                    <div id="maintenance" class="card-content"></div>
                    <div class="card-button"> <button onclick="window.location.href='/public/receptionist/request_maintenance.php'" > Add </button> </div>
                </div>   
            </div>
        </main>
    <?php
            require_once("../general/footer.php");
    ?>
    </body>
<script type="module" src="/js/general/notifications.js"></script>
</html>
