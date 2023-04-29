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
    <link rel="stylesheet" href="/styles/general/staff.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>View Discount Request</title>
</head>
<body>
    <?php
        require_once("header.php"); 
    ?>
    <main class="body-container">
        <div class="content-box" style="width:40%">
            <form action="" method="POST">
                <div class="row-container">
                    <div class="left-field">
                        Branch Name: 
                    </div>
                    <div class="right-field">
                        <input type="text" id="branch" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Managed By:
                    </div>
                    <div class="right-field">
                        <input type="text" id="manager" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Sport: 
                    </div>
                    <div class="right-field">
                        <input type="text" id="sport" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Existing Number of Courts:
                    </div>
                    <div class="right-field">
                        <input type="text" id="exCourts" readonly>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Photos:
                    </div>
                    <div class="right-field" id="photos">
                        
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-field">
                        Decision: 
                    </div>
                    <div class="right-field">
                    <textarea id="decision" required></textarea>
                    </div>
                </div>
                <div style="color: red;text-align: center;" id="err-msg"></div>
                <div style="color: green;text-align: center;" id="success-msg"></div>
                <br>
                <div class="row-container" style="width:106%;justify-content:flex-end">
                    <button id="decline" value="Declined">Decline</button>
                    <button id="accept" value="Accepted">Accept</button>
                </div>
            </form>
        </div>
    </main>
    <?php 
        require_once("../../public/general/footer.php");
    ?>

</body>
<script src="/js/owner/view_court_request.js"></script>
</html>