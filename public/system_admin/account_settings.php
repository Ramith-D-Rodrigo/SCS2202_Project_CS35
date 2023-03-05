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
            <form action="../../controller/system_admin/change_login_controller.php" method="post">
                <div class="row-container">
                    <div class="left-side"> Current Email: </div>
                    <div class="right-side"><input readonly id="currEmail"></input>
                    </div>    
                </div>
                <div class="row-container">
                    <div class="left-side"> New Email: </div>
                    <div class="right-side">
                    <input required
                    name="newEmail" id="newEmail"
                    type="email"></input>
                    </div>    
                </div>
                <div class="row-container">
                    <div class="left-side"> New Password: </div>
                    <div class="right-side"><input required
                        name="newPwd" id="password"
                        type="password"
                        pattern="(?=.*\d)(?=.*[A-Z]).{8,}" 
                        minlength="8"
                        required title="Password length must be atleast 8 characters. Must include an uppercase letter and a number">
                    </input>
                    <button class="togglePassword"> Show Password</button>
                    </div>    
                </div>
                <div class="row-container">
                    <div class="left-side"> Confirm Password: </div>
                    <div class="right-side"><input type="password" required name="confirmPwd" id="cPassword"></input>
                    <button class="togglePassword"> Show Password</button>
                    </div>    
                </div>
                <input hidden name="role" id="role"></input>
                <div class="err-msg" id="err-msg">
                    <?php 
                        if(isset($_SESSION['emailError'])){
                            echo $_SESSION['emailError'];
                            echo '<br>';
                            unset($_SESSION['emailError']);
                        }
                    ?>
                </div>
                <div class="success-msg">
                        <?php 
                            if(isset($_SESSION['successMsg'])){
                                echo $_SESSION['successMsg'];
                                echo '<br>';
                                unset($_SESSION['successMsg']);
                            }
                        ?>
                </div>
                <div class="row-container" style="justify-content:flex-end">
                    <button  onclick="window.location.href='../../public/system_admin/account_settings.php'">Cancel</button>
                    <button name="confirmBtn" type="submit" id="confirmBtn" onclick="return validateForm(event)">Confirm Changes</button>
                </div>
            </form>   
        </div>
    </main>
    
</body>
<script src="/js/system_admin/change_logins_handle.js"></script>
<!-- <script src="/js/system_admin/account_settings.js"></script> -->
</html>