
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

</head>
<body>
<?php
        require_once("dashboard_header.php");
?>
<main >
    <div class="flex-container">
            <div class=tabs>
                <div> Reservations</div> 
                <div> <button onclick="window.location.href='/public/receptionist/view_reservations.php'"> View More </button> </div>
            </div>
            <div class=tabs>
                <div> Onsite Reservation</div> 
                <div> <button> Add </button> </div>
            </div>
            <div class=tabs>
                <div>Branch Details</div> 
                <div> <button onclick="window.location.href='/public/receptionist/edit_branch.php'"> Edit</button> </div>
            </div>   
        </div>
        <div class="flex-container">
            <div class=tabs>
                <div> View Profiles</div> 
                <div> 
                    <button onclick="window.location.href='/public/receptionist/view_coach_profiles.php'"> View Coach Profiles </button> 
                    <button onclick="window.location.href='/public/receptionist/view_user_profiles.php'"> View User Profiles   </button> 
                </div>
            </div>
            <div class=tabs>
                <div>Request Maintenance</div> 
                <div> <button onclick="window.location.href='/public/receptionist/request_maintenance.php'" > Add </button> </div>
            </div>  
        </div>
    </div>
</main>
<?php
        require_once("../general/footer.php");
?>
</body>
</html>
