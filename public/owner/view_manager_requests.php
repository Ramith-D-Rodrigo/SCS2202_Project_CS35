<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
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
    <link rel="stylesheet" href="/styles/general/styles.css">
    <link rel="stylesheet" href="/styles/general/notification.css">
    <link rel="stylesheet" href="/styles/owner/view_requests.css">
    <link rel="stylesheet" href="/styles/general/staff.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>View Manager Requests</title>
</head>
<body>
    <?php
        require_once("header.php"); 
    ?>
    <main class="body-container" style="display:flex;flex-direction:column">
        <div id="discount_results" style="display:flex;flex-direction:column">
            <div class="content-box" id="discountTitle" style="display:flex;justify-content:left;width:50%">New Discount Requests</div>
        </div>
        <div id="court_results" style="display:flex;flex-direction:column">
            <div class="content-box" id="courtTitle" style="display:flex;justify-content:left;margin-left:10%;width:50%">New Court Requests</div>
        </div>
    </main>
    <?php
        require_once("../../public/general/footer.php");
    ?>
</body>
<script src="/js/owner/get_manager_requests.js"></script>
</html>