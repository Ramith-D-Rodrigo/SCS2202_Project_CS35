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
                <button id="AddDiscount">Add New Discount </button>
                <button id="viewMore"> View More </button>
             </div>
         </div>

         <div class=tabs>
            <div>Branch Status</div> 
            <div>Open/Closed/Maintanance</div> 
            <div> <button> Edit Time </button> </div>
         </div>
         
         <div class=tabs>
            <div> Sports Courts</div> 
            <div> <button onclick="window.location.href='/controller/manager/view_sport_court_controller.php'"> View More</button> </div>
         </div> 
    </div>     
    <div class="flex-container">
        <div class=tabs>
            <div>User Feedback and Reviews</div> 
            <div> <button> View More </button> </div>
         </div>

         <div class=tabs>
            <div>Registered Coaches</div> 
            <div> <button> View More </button> </div>
         </div>
         
         <div class=tabs>
            <div> Maintanance Request</div> 
            <div> <button> View More</button> </div>
         </div> 
    </div>    
    
</main>

<?php
    require_once("../general/footer.php");
?>
</body>
</html>