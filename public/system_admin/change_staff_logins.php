<?php
    session_start();
    if(!(isset($_SESSION['userid']) && isset($_SESSION['userrole']))) {
        header("Location: /public/system_admin/admin_login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Staff Login Details</title>
    <link rel="stylesheet" href="/styles/general/styles.css">
    <link rel="stylesheet" href="/styles/general/staff.css">
    <link rel="stylesheet" href="/styles/system_admin/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>
    <?php
        require_once("dashboard_header.php");
    ?>
    <main class="body-container" style="display:flex;flex-direction:column">
        <div class="content-box">
            <div style="display:flex;flex-direction:row">
                <div class="row-container" style="margin-right:-100px;display:flex;align-items:center;flex-direction:row">
                    <div> Staff Role: </div>
                    <div>
                        <select name="staffRole" id="staffRole">
                            <option value="">Choose Role</option>
                            <option value="receptionist">Receptionist</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>
                </div>
                <div class="row-container" style="margin-left:-100px;display:flex;align-items:center;flex-direction:row">
                    <div> Registered Branch: </div>
                    <div>
                        <select name="branch" id="branch">
                            <option value="">Choose Branch</option>
                        </select>
                    </div>
                </div>
            </div> 
            <div class="row-container">
                    <div class="left-side"> Username: </div>
                    <div class="right-side"><input readonly id="username"></input>
                    </div>    
                </div>
            <div class="row-container">
                <div class="left-side"> Current Email: </div>
                <div class="right-side"><input readonly id="currEmail"></input>
                </div>    
            </div>
            <form action="../../controller/system_admin/change_login_controller.php" method="post">
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
                    name="newPwd" id="newPwd"
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
                    <div class="right-side"><input type="password" required name="confirmPwd" id="confirmPwd"></input>
                    <button class="togglePassword"> Show Password</button>
                    </div>    
                    <!-- <div><button type="submit" id="viewBtn" >Show Password</button></div> -->
                </div>
                <div  id="errmsg" class="err-msg">
                    <?php 
                        if(isset($_SESSION['emailError'])){
                            echo $_SESSION['emailError'];
                            echo '<br>';
                            unset($_SESSION['emailError']);
                        }
                    ?>
                </div>
                <div class="row-container">
                    <div class="left-side"> 
                        <button type="submit" id="viewBtn" >Cancel</button>
                    </div>
                    <div class="right-side">
                        <button type="submit" id="viewBtn" onclick="return validateForm(event)" style="margin-left:-100px">Confirm</button>
                    </div>    
                </div>
            </form>
        </div>
    </main>
    <?php
        require_once("../../public/general/footer.php");
    ?>
</body>
    <script src="/js/system_admin/staff_login_details.js"></script>
    <script src="/js/system_admin/login_details_form_handle.js"></script>
</html>