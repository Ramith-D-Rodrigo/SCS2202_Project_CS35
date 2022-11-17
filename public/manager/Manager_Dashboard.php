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
    require_once("manager_dashboard_header.php");
?>
<main>
    <div class="flex-container">
        <div class=tabs>
            <div>Revenue for this Month</div> 
            <div>Rs.________</div>
            <div> <button>Add New Discount </button>
            <div> <button> View More </button> </div>
         </div>

         <div class=tabs>
            <div>Branch Status</div> 
            <div>Open/Closed/Maintanance</div> 
            <div> <button> Edit Time </button> </div>
         </div>
         
         <div class=tabs>
            <div> Sports Courts</div> 
            <div> <button> Add New </button> </div>
            <div> <button> View More</button> </div>
         </div> 
    </div>     
    <div class="flex-container">
        <div class=tabs>
            <div>User Feedback and Reviews</div> 
            <div> <button> View More </button> </div>
         </div>

         <div class=tabs>
            <div>Registerde Coaches</div> 
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
