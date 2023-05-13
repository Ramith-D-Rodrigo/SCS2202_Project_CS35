<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
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
        <link rel="stylesheet" href="/styles/general/staff.css">
        <link rel="stylesheet" href="/styles/receptionist/maintenance.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>Request Maintenance</title>
    </head>

    <body>
        <?php
             require_once("dashboard_header.php");
        ?>
        <main class="body-container">
        <div class="content-box">
            <form id="reqForm">
                <div class="row-container">
                    <div class="left-field"> Maintenance Reason : </div>
                    <div class="right-field">
                        <!-- <textarea 
                        required></textarea> --> 
                        <input
                        required  
                        id='reason'>    
                    </div>
                </div>  
                <div class="row-container">
                    <div class="left-field"> Sport Name :  </div>
                    <div class="right-field">
                        <select required id="sportName">  
                        </select>
                    </div>
                </div> 
                <div class="row-container">
                    <div class="left-field"> Sport Court Name :  </div>
                    <div class="right-field"> 
                        <select required id="courtName">
                        </select> 
                    </div> 
                </div>     
                <div class="row-container">
                    <div class="left-field"> Starting Date : </div>
                    <div class="right-field"> <input type="date"
                        id ="sDate" 
                        required> </div>
                </div> 
                <div class="row-container">
                    <div class="left-field"> Ending Date : </div>
                    <div class="right-field"> <input type="date"
                        id ="eDate" 
                        required> </div>
                </div> 
                <div id="errMsg" class="err-msg"></div>
                <div style="display:flex;justify-content:flex-end">
                    <button  
                        id="submitBtn"   
                        onclick="validateForm(event)"> Submit </button>    
                </div>
            </form>
        </div>
        <div id="overlay"></div>
        <div id="successMsg"></div>
        </main>
        <?php
            require_once("../general/footer.php");
        ?>
        <script src="/js/receptionist/maintenance_entry_results.js"></script>
        <script src="/js/receptionist/maintenance_validation.js"></script>
        <script src="/js/receptionist/maintenance_submission.js"></script>
        <script type="module" src="/js/general/notifications.js"></script>
    </body>

</html>