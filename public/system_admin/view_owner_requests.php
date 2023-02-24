<?php
    session_start();
    if(!(isset($_SESSION['userid']) && isset($_SESSION['userrole']))) {
        header("Location: /public/general/login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/general/styles.css">
    <link rel="stylesheet" href="/styles/general/staff.css">
    <link rel="stylesheet" href="/styles/system_admin/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>View Owner Requests</title>
</head>
<body>
    <?php
        require_once("dashboard_header.php")
    ?>
    <main class="body-container">
        <div class="content-box">
            <div id="err-msg">
            </div>
            <div id="requests" style="display:flex;flex-direction:column">
            </div>
        </div>
    </main>
    <?php
        require_once("../general/footer.php");
    ?>
</body>
<script src="/js/system_admin/view_owner_requests.js"></script>
</html>