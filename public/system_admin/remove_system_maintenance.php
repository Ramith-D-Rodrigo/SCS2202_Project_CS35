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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove System Maintenance</title>
    <link rel="stylesheet" href="/styles/general/styles.css">
    <link rel="stylesheet" href="/styles/general/staff.css">
    <link rel="stylesheet" href="/styles/system_admin/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>
    <?php
        require_once("dashboard_header.php");
    ?>
    <main class="body-conatainer" style="display:flex;justify-content:center;">
        <div id="err-msg" style="display:flex;margin-top:45%;height:10%">
        </div>
        <div id="maintenance">
        </div>
        <div id="overlay"></div>
        <div id="warning-msg" style="display:flex;flex-direction:row;display:none">
            <button id="Yes"><i class="fa-solid fa-check"></i></button>
            <button id="No"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div id="success-msg">
        </div>
    </main>
    <?php
        require_once("../../public/general/footer.php");
    ?>
</body>
    <script src="/js/system_admin/view_sys_maintenance.js"></script>
    <script type="module" src="/js/general/notifications.js"></script>
</html>