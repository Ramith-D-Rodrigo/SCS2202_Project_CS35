<?php 
    session_start();
    if(!(isset($_SESSION['userid']) && isset($_SESSION['userrole']))) {
        header("Location: /public/system_admin/admin_login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin's Dashboard</title>
  <link rel="stylesheet" href="/styles/system_admin/admin_dashboard.css">
  <link rel="stylesheet" href="/styles/general/styles.css">
  <link rel="stylesheet" href="/styles/general/staff.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

</head>
<body>
<?php
        require_once("dashboard_header.php");
?>
<main>
    <div class="long-container">
        <div class=longTab>
            <div> System Maintenance</div> 
            <div> <button onclick="window.location.href='/public/system_admin/remove_system_maintenance.php'"> Finish </button> </div>
            <div> <button onclick="window.location.href='/public/system_admin/add_system_maintenance.php'"> Add </button> </div>
        </div>
    </div>
    <div class="long-container">
        <div class=longTab>
            <div> Owner Requests</div> 
            <div> <button onclick="window.location.href='/public/system_admin/view_owner_requests.php'"> View More </button> </div>
        </div>
    </div>
    <div class="flex-container">
        <div class=tabs>
            <div>Register Staff</div> 
            <div> <button onclick="window.location.href= '/public/system_admin/staff_register.php'" > Proceed </button> </div>
        </div> 
        <div class=tabs>
            <div>Change Staff Login Details</div> 
            <div> <button onclick="window.location.href='/public/system_admin/change_staff_logins.php'" > Proceed </button> </div>
        </div>
        <div class=tabs>
            <div>Deactivate Staff Accounts</div> 
            <div> <button onclick="window.location.href='/public/system_admin/deactivate_account.php'" > Proceed </button> </div>
        </div>   
    </div>
</div>
</main>
<?php
        require_once("../general/footer.php");
?>
</body>
</html>
