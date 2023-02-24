<?php
    session_start();
    if(!(isset($_SESSION['userid']) && isset($_SESSION['userrole']))) {   //check whether receptionist is logged in correctly
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
            <form action="/controller/receptionist/req_maintenance_controller.php" method="post" id="reqForm">
                <div class="row-container">
                    <div class="left-side"> Maintenance Reason : </div>
                    <div class="right-side">
                        <!-- <textarea 
                        required></textarea> -->
                         
                        <input
                        required 
                        name='reason' 
                        id='reason'
                        value=<?php if(isset($_SESSION['reason'])) echo htmlspecialchars($_SESSION['reason'], ENT_QUOTES)?>>    
                    </div>
                </div>  
                <div class="row-container">
                    <div class="left-side"> Sport Name :  </div>
                    <div class="right-side">
                        <select required name="sportName" id="sportName">  
                        </select>
                    </div>
                </div> 
                <div class="row-container">
                    <div class="left-side"> Sport Court Name :  </div>
                    <div class="right-side"> 
                        <select required name="courtName" id="courtName">
                        </select> 
                    </div> 
                </div>     
                <div class="row-container">
                    <div class="left-side"> Starting Date : </div>
                    <div class="right-side"> <input type="date"
                        id ="sDate" 
                        name="sDate" 
                        required
                        value=<?php if(isset($_SESSION['sDate'])) echo htmlspecialchars($_SESSION['sDate'], ENT_QUOTES)?>> </div>
                </div> 
                <div class="row-container">
                    <div class="left-side"> Ending Date : </div>
                    <div class="right-side"> <input type="date"
                        id ="eDate" 
                        name="eDate" 
                        required
                        value=<?php if(isset($_SESSION['eDate'])) echo htmlspecialchars($_SESSION['eDate'], ENT_QUOTES)?>> </div>
                </div> 
                <div id="errmsg" class="err-msg">
                    <?php
                        if(isset($_SESSION['errMsg'])){
                            echo $_SESSION['errMsg'];
                            echo '<br>';
                            unset($_SESSION['errMsg']);
                        }
                        if(isset($_SESSION['slotUnavailability'])){
                            echo $_SESSION['slotUnavailability'];
                            echo '<br>';
                            unset($_SESSION['slotUnavailability']);
                        }
                        if(isset($_SESSION['courtUnavailability'])){
                            echo $_SESSION['courtUnavailability'];
                            echo '<br>';
                            unset($_SESSION['courtUnavailability']);
                        }
                        
                    ?>
                </div>
                <div id="errmsg2" class="err-msg"></div>
                <div id="successmsg" class="success-msg">
                    <?php
                        if(isset($_SESSION['RequestsuccessMsg'])){
                            echo $_SESSION['RequestsuccessMsg'];
                            //echo '<br> You will be Redirected to the Dashboard. Please Wait';
                            unset($_SESSION['RequestsuccessMsg']);
                            //header_remove();
                            //header("Refresh: 3; URL =/public/receptionist/receptionist_dashboard.php");  //redirect to dashboard
                        }
                    ?>
                </div>
                <button type="submit" 
                    id="login"  
                    name= "reqSubmitBtn" 
                    value="submit" 
                    onclick="return validateForm(event)"
                > Submit </button>
            </form>
        </div>
        </main>
        <?php
            require_once("../general/footer.php");
        ?>
        <script src="/js/receptionist/maintenance_entry_results.js"></script>
        <script src="/js/receptionist/maintenance_validation.js"></script>
    </body>

</html>