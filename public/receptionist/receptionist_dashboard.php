<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Receptionist's Dashboard</title>
  <link rel="stylesheet" href="/styles/receptionist/receptionist_dashboard.css" />
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
                <div> <button> Edit </button> </div>
            </div>   
        </div>
        <div class="flex-container">
            <div class=tabs>
                <div> View Profiles</div> 
                <div> 
                    <button> View Coach Profiles </button> 
                    <button> View User Profiles   </button> 
                </div>
            </div>
            <div class=tabs>
                <div>Request Maintenance</div> 
                <div> <button href="/controller/receptionist/edit_branch_controller.php"> Add </button> </div>
            </div>  
        </div>
    </div>
</main>
<?php
        require_once("../general/footer.php");
?>
</body>
</html>
