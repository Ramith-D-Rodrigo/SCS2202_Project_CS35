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
    <link rel="stylesheet" href="/styles/general/staff.css">
    <link rel="stylesheet" href="/styles/receptionist/receptionist.css">
    <link rel="stylesheet" href="/styles/receptionist/viewReservations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> 
    <title>Cancel Reservations</title>
</head>
<body>
    <?php
        require_once("dashboard_header.php");
    ?>
    <main class="body-container">
        <div id="searchResults" style="display:flex;flex-direction:column">
        </div>
        <div id="overlay"></div>
        <div id="warning-msg" style="display:flex;flex-direction:row;display:none">
            <button id="Yes"><i class="fa-solid fa-check"></i></button>
            <button id="No"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div id="success-msg">
        </div>
        <div id="err-msg"></div>
    </main>
    <?php
        require_once("../general/footer.php");
    ?>
</body>
<script src="/js/receptionist/get_onsite_reservations.js"></script>
</html>