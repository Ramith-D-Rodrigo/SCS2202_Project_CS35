<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin's Dashboard</title>
  <link rel="stylesheet" href="/styles/system_admin/admin_dashboard.css" />
  <link rel="stylesheet" href="/styles/general/styles.css" />
</head>
<body>
<?php
        require_once("dashboard_header.php");
?>
<main>
    <div class="long-container">
        <div class=longTab>
            <div> System Maintenance</div> 
            <div> <button> Finish </button> </div>
            <div> <button> Add </button> </div>
        </div>
    </div>
    <div class="long-container">
        <div class=longTab>
            <div> Owner Requests</div> 
            <div> <button> View More </button> </div>
        </div>
    </div>
    <div class="flex-container">
        <div class=tabs>
            <div>Register Staff</div> 
            <div> <button onclick="window.location.href= '/controller/system_admin/drop_down_list_controller.php'" > Proceed </button> </div>
        </div> 
        <div class=tabs>
            <div>Change Staff Login Details</div> 
            <div> <button onclick="window.location.href" > Proceed </button> </div>
        </div>
        <div class=tabs>
            <div>Deactivate Staff Accounts</div> 
            <div> <button onclick="window.location.href" > Proceed </button> </div>
        </div>   
    </div>
</div>
</main>
<?php
        require_once("../general/footer.php");
?>
</body>
</html>
