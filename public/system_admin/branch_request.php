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
    <title>Branch Request</title>
</head>
<body>
    <?php
        require_once("dashboard_header.php")
    ?>
    <main class="body-container">
        <div>
            <form action="../../controller/system_admin/request_handle_controller.php" method="POST">
                <div class="content-box" id="branch_request">
                    <div class="row-container">
                        <div class="left-side">
                            Reqeust Sent Date: 
                        </div>
                        <div class="right-side">
                            <input readonly id="date"></input>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-side">
                            Branch Location: 
                        </div>
                        <div class="right-side">
                            <input readonly name="address" id="city"></input>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-side">
                            Branch Address: 
                        </div>
                        <div class="right-side">
                            <input readonly id="address"></input>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-side">
                            Branch Email:  
                        </div>
                        <div class="right-side">
                            <input readonly id="emailAddress"></input>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-side">
                            Opening Time: 
                        </div>
                        <div class="right-side">
                            <input readonly id="openTime"></input>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-side">
                            Closing Time: 
                        </div>
                        <div class="right-side">
                            <input readonly id="closeTime"></input>
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-side">
                            Contact Number(s):
                        </div>
                        <div class="right-side">
                            <input readonly id="contactNum"></input>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:row">
                        <div style="width:50%"> Sport(s): 
                            <select id="sports">
                                <option value="">Select Sport..</option>
                            </select>   
                        </div> 
                        <div style="width:50%;margin-top:15px"> No. of Courts: <output readonly id="courts"></output> 
                        </div>       
                    </div>
                    <input hidden name="branchID" id="branchID"></input>
                    <div style="display:flex;flex-direction:row;justify-content:flex-end;margin-top:5%">
                            <button type="submit" id ="cancelBtn" name="decision" value="Decline">Decline</button>
                            <button type="submit" id="acceptBtn" name="decision" value="Accept">Accept</button>
                    </div>
                </div>
            </form>
            <div id="success-msg"> </div>
            <div class="err-msg" id="err-msg">
                <?php
                    if(isset($_SESSION['branchExistError'])){
                        echo $_SESSION['branchExistError'];
                        echo '<br>';
                        unset($_SESSION['branchExistError']);
                    }
                ?>
            </div>
        </div>
    </main>
    <?php
        require_once("../general/footer.php");
    ?>
</body>
<script src="/js/system_admin/branch_request.js"></script>
</html>