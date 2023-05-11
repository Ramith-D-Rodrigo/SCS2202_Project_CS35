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
    <title>Account Settings</title>
    <link rel="stylesheet" href="/styles/general/styles.css">
    <link rel="stylesheet" href="/styles/general/staff.css">
    <link rel="stylesheet" href="/styles/system_admin/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>
    <?php
        require_once("dashboard_header.php");
    ?>
    <main class="body-container">
        <div class="content-box">
            <form>
                <div class="row-container">
                    <div class="left-side"> Current Email: </div>
                    <div class="right-side"><input readonly id="currEmail"></input>
                    </div>    
                </div>
                <div class="row-container">
                    <div class="left-side"> New Email: 
                        <p style="font-size:10px;font-style:italic">Leave it empty if you don't want to change</p>
                    </div>
                    <div class="right-side">
                    <input
                    id="newEmail"
                    type="email"></input>
                    </div>    
                </div>
                <div class="row-container">
                    <div class="left-side"> New Password: 
                        <p style="font-size:10px;font-style:italic">Leave it empty if you don't want to change</p>
                    </div>
                    <div class="right-side"><input
                        id="password"
                        type="password"
                        pattern="(?=.*\d)(?=.*[A-Z]).{8,}" 
                        minlength="8"
                        title="Password length must be atleast 8 characters. Must include an uppercase letter and a number">
                        </input>
                        <button class="togglePassword">Show Password</button>
                    </div>
                </div>
                
                <div class="row-container">
                    <div class="left-side"> Confirm Password: </div>
                    <div class="right-side"><input type="password"  id="cPassword"></input>
                        <button class="togglePassword">Show Password</button>
                    </div>    
                </div>
                <input hidden id="role"></input>
                <div id="err-msg" style="color:red;text-Align:center";>
                </div>
                
                <div class="row-container" style="justify-content:flex-end">
                    <button  onclick="window.location.href='../../public/system_admin/account_settings.php'">Cancel</button>
                    <button  id="confirmBtn" onclick="validateForm(event)">Confirm Changes</button>
                </div>
            </form>   
        </div>
        <div id="overlay"></div>
        <div id="success-msg"></div>
    </main>
    
</body>
<script src="/js/system_admin/change_logins_handle.js"></script>
<script type="module" src="/js/general/notifications.js"></script>
<!-- <script src="/js/system_admin/account_settings.js"></script> -->
</html>