
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
  <link rel="stylesheet" href="/styles/receptionist/receptionist.css" />
  <link rel="stylesheet" href="/styles/general/styles.css" />
</head>
<body>
<?php
        require_once("dashboard_header.php");
?>
<main>
    <div class="flex-container">
            <div class=tabs>
                <div> Reservations</div> 
                <div> <button> View More </button> </div>
            </div>
            <div class=tabs>
                <div> Onsite Reservation</div> 
                <div> <button> Add </button> </div>
            </div>
            <div class=tabs>
                <div>Branch Details</div> 
                <div> <button onclick="window.location.href='/public/receptionist/edit_branch.php'"> Edit </button> </div>
            </div>   
        </div>
        <div class="flex-container">
            <div class=tabs>
                <div> View Profiles</div> 
                <div> 
                    <button> View Coach Profiles </button> 
                    <button onclick="window.location.href='/controller/receptionist/view_sProfiles_controller.php'"> View User Profiles   </button> 
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
