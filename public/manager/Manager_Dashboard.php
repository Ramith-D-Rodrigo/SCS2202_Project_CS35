<?php
  session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manager Dashboard</title>
  <link rel="stylesheet" href="/styles/manager/manager_dashboard.css" />
  <link rel="stylesheet" href="/styles/general/styles.css" />
  <link rel="stylesheet" href="/styles/general/staff.css" />
</head>
<body>
<?php
    require_once("manager_header.php");
?>
<main>
    <div class="flex-container">
        <div class=tabs>
            <div>Revenue for this Month</div> 
            <div>Rs.________</div>
            <div>
                <button  onclick="window.location.href='manager_add_new_discount.php'" id="AddDiscount">Add New Discount </button>
                <button  onclick="window.location.href='revenue.php'" id="viewMore"> View More </button>
            </div>
        </div>

        <div class=tabs>
            <div>Branch Status</div> 
            <div>Open/Closed/Maintanance</div> 
            <div> <button onclick="window.location.href='manager_edit_time.php'"> Edit Time </button> </div>
        </div>
         
        <div class=tabs>
            <div> Sports Courts</div> 
            <div> <button onclick="window.location.href='/controller/manager/view_sport_court_controller.php'"> View More</button> </div>
        </div> 
    </div>     
    <div class="flex-container">
        <div class=tabs>
            <div>User Feedback and Reviews</div> 
            <div> <button onclick="window.location.href='user_feedback.php'"> View More </button> </div>
        </div>

        <div class=tabs>
            <div>Registered Coaches</div> 
            <div> <button onclick="window.location.href='registered_coaches.php'"> View More </button> </div>
        </div>
         
        <div class=tabs>
            <div> Maintanance Request</div> 
            <div> <button  onclick="window.location.href='manager_handle_receptionist_request.php'"> View More</button> </div>
        </div> 
    </div>    
    
</main>

<?php
    require_once("../general/footer.php");
?>
</body>
</html>