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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> 
    <title>Select Sport</title>
</head>
<body>
    <?php
        require_once("dashboard_header.php");
    ?>
    <main class="body-container">
        <form method="get" action="onsite_reservation.php">
            <div class="row-container" style=" background-color: #ECFCFF;border-radius:25px;padding:20px">
                <div class="left-side" style="width:200px;margin-left:10%">
                    Sport: 
                </div>
                <div class="right-side" style="margin-left:0px;margin-right:-20px">
                    <select id="sport">
                        <option value="">Select Sport...</option>
                    </select>
                </div>  
                <button type="submit" name="sportID" id="sportID" style="width:600px">
                View Reservation</button>  
            </div>
        </form>
    </main>
    <?php
        require_once("../general/footer.php");
    ?>
</body>
<script src="/js/receptionist/onsite_reservation_entry.js"></script>
</html>