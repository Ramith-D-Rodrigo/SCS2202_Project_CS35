<?php
    session_start();
    if(!(isset($_SESSION['userid']) && isset($_SESSION['userrole']))) {
        header("Location: /public/receptionist/receptionist_login.php");
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
    <link rel="stylesheet" href="/styles/receptionist/receptionist.css" />
    <title>View Coach Profiles</title>
</head>
<body>
    <?php
        require_once("dashboard_header.php");
    ?>
    <main class="body-container">
    <div class="content-box" id="search_results">
        <div id="err-msg">
        </div>
    </div>
    </main>
    <?php
        require_once("../general/footer.php");
    ?>    
</body>
<script src="/js/receptionist/view_coach_profiles.js"></script>
</html>