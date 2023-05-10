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
    <title>Deactivate Staff Account</title>
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
                            <select name="branchName" id="branchName">
                                <option value="">Choose Branch</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row-container">
                    <div class="left-side" > Email Address: </div>
                    <div class="right-side"><input readonly id="email"></input>
                    </div>    
                </div>
                <div class="row-container">
                    <div class="left-side"> First Name: </div>
                    <div class="right-side"><input readonly id="fName"></input>
                    </div>    
                </div>
                <div class="row-container">
                    <div class="left-side"> Last Name: </div>
                    <div class="right-side"><input readonly id="lName"></input>
                    </div>    
                </div>
                <div class="row-container">
                    <div class="left-side"> Username: </div>
                    <div class="right-side"><input readonly id="username"></input>
                    </div>    
                </div>
                <div class="row-container">
                    <div class="left-side"> Contact No: </div>
                    <div class="right-side"><input readonly id="contactN"></input>
                    </div>    
                </div>
                <div class="row-container">
                    <div class="left-side"> Joined Date: </div>
                    <div class="right-side"><input readonly id="jDate"></input>
                    </div>    
                </div>
                <div class="err-msg" id="err-msg">
                </div>
                <div class="row-container" style="justify-content: flex-end;">
                    <button id="deactivateBtn">Deactivate Account</button>
                </div>
            </form>
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
        require_once("../general/footer.php");
    ?>
</body>
    <script src="/js/system_admin/get_all_branches.js"></script>
    <script src="/js/system_admin/account_info.js"></script>
    <script src="/js/system_admin/deactivate_account.js"></script>
</html>