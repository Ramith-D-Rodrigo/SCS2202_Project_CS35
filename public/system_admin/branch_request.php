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
            <div id="err-msg">
            </div>
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
                        <input readonly id="city"></input>
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
                        <!-- <div > -->
                        <div style="width:50%"> Sport(s): 
                            <select id="sports">
                                <option value="">Select Sport..</option>
                            </select>   
                        </div> 
                        <!-- </div> 
                        <div > -->
                            <!-- <div> </div>  -->
                            <div style="width:50%"> No. of Courts: <output readonly id="courts"></output> </div>
                        <!-- </div> -->
                        
                </div>
            </div>
        </div>
    </main>
    <?php
        require_once("../general/footer.php");
    ?>
</body>
</html>