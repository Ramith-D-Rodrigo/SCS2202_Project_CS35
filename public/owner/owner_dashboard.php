<?php
    session_start();
   // if(!(isset($_SESSION['username']) && isset($_SESSION['userrole']) && $_SESSION['userrole'] === 'coach')){
   //     header("Location: /index.php");
    //    exit();
 //   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Owner's Dashboard</title>
  <link rel="stylesheet" href="/styles/owner/owner_dashboard.css" />
  <link rel="stylesheet" href="/styles/general/styles.css" />
</head>
<body>
<?php
        require_once("dashboard_header.php");
?>
<main>
    <div class="flex-container">
            <div class=tabs>
                <div> Total Revenue for this month</div> 
                <div> <button> View Branch wise </button> </div>
            </div>
            <div class=tabs>
                <div> Branch details</div> 
                <div> <button> View more info </button> </div>
            </div>
            <div class=tabs>
                <div>Branch Feedback</div> 
                <div> <button> View more info </button> </div>

            </div>   
        </div>
        <div class="flex-container">
            <div class=tabs>
                <div> Manage request</div> 
                <div>  
                    <button> View more </button> 
                </div>
            </div>
            <div class=tabs>
                <div> Sports</div> 
                <div>  
                    <button> View more </button> 
                </div>
            </div>
            <div class=tabs>
                <div>Request Maintenance</div> 
                <!-- <div> <button onclick="window.location.href='/controller/receptionist/drop_down_list_controller.php'" > Add </button> </div> -->
            </div>  
        </div>
    </div>
</main>
<?php
        require_once("../general/footer.php");
?>
</body>
</html>
