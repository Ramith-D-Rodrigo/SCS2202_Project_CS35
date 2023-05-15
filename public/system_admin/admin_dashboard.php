<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['admin'])){
        Security::redirectUserBase();
        die();
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
    <div class="body-container dashboard-cards">
        <div class="content-box single-card">
            <div class="card-title">Branch Details</div> 
            <div id="branch" class="card-content"></div>
            <div class="card-button"> <button onclick="window.location.href='/public/receptionist/edit_branch.php'"> Edit</button> </div>
        </div>   
        <div class="content-box single-card">
            <div class="card-title"> System Maintenance</div> 
            <div id="maintenance" class="card-content"></div>
            <div class="card-button"> 
                <button onclick="window.location.href='/public/system_admin/remove_system_maintenance.php'"> Finish </button> 
                <button onclick="window.location.href='/public/system_admin/add_system_maintenance.php'"> Add </button>
            </div>
        </div>
        <div class="content-box single-card">
            <div class="card-title"> Owner Requests</div> 
            <div id="requests" class="card-content"></div>
            <div class="card-button"> 
                <button onclick="window.location.href='/public/system_admin/view_owner_requests.php'"> View More </button> 
            </div>
        </div>
        <div class="content-box single-card">
            <div class="card-title">Register Staff</div> 
            <div id="register" class="card-content"></div>
            <div class="card-button"> 
                <button onclick="window.location.href= '/public/system_admin/staff_register.php'" > Proceed </button> 
            </div>
        </div>
        <div class="content-box single-card">
            <div class="card-title">Change Staff Login Details</div> 
            <div id="changeLog" class="card-content"></div>
            <div class="card-button"> 
                <button onclick="window.location.href='/public/system_admin/change_staff_logins.php'" > Proceed </button> 
            </div>
        </div>
        <div class="content-box single-card">
            <div class="card-title">Deactivate Staff Accounts</div>
            <div id="deStaff" class="card-content"></div> 
            <div class="card-button"> 
                <button onclick="window.location.href='/public/system_admin/deactivate_account.php'" > Proceed </button>
             </div>
        </div>  
    </div>
</main>
<?php
        require_once("../general/footer.php");
?>
</body>
<script type="module" src="/js/general/notifications.js"></script>
</html>
