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
        <title>Edit Branch</title>
    </head>

    <body>
        <?php
            require_once("dashboard_header.php");
        ?>
        <main class="body-container">
            <div class="content-box">
            <form class ="reg-form" action="/controller/receptionist/branch_changes_controller.php" method="post">
                <div class="row-container">
                    <div class="left-side"> Branch Location: </div>
                    <div class="right-side" id="location"> 
                    </div>
                </div>
                <br>
                <div class="row-container">
                    <div class="left-side"> Branch Contact Number(s) : </div>
                    <div class="right-side" id="numbers" style="display:flex;flex-direction:column;justify-content:center">
                    </div>
                </div>
                <div style="margin-left:400px"> <button type ="submit" 
                    id ="ChangeNumBtn"> Change </button> </div>
                
                
                <div class="row-container" id="newNumberField;" >
                    <div class="left-side" id="numberLSide"> Con. Number to Replace: </div>
                    <div class="right-side" id="numberRSide"><input
                    id="newNumber"
                    name="newContactN" 
                    pattern="[0-9]{10,11}"
                    placeholder="New Contact Number"
                    > </div>
                </div>
                <br>
                <div class="row-container">
                    <div class="left-side"> Branch Email : </div>
                    <div class="right-side" id="email">  </div>
                </div>
                <div div style="margin-left:400px"> <button type ="submit" 
                    id="EmailChangeBtn"> Change </button> 
                </div>
                <div class="row-container" id="newEmailField;" >
                    <div class="left-side" id="emailLSide"> Email Address to Replace: </div>
                    <div class="right-side" id="emailRSide"> <input
                    type="email"
                    id="newEmail" 
                    name="newEmail"
                    placeholder="New Email Address"
                    > </div>
                </div>
                <br>
                <div>
                    <div> Branch Photos : </div>
                    <br>
                    <div id="photo" style="width: 100%;height:150px;overflow-y:scroll;">
                    </div>  
                </div>
                <div style="display:flex;flex-direction:row">
                    
                    <div style="display:flex;justify-content:left">
                        <button type="button" onclick="window.location.href='/public/receptionist/edit_branch.php'">Cancel</button>
                    </div>
                    <div style="display:flex;justify-content:right">
                        <button  
                        type ="submit" 
                        name ="reserveBtn" 
                        value="submit">Apply Changes</button>
                    </div>
                </div>
                <div  id="errmsg" class="err-msg">
                    <?php
                        if(isset($_SESSION['numberError'])){
                            echo($_SESSION['numberError']);
                            echo '<br>';
                            unset($_SESSION['numberError']);
                        }
                        if(isset($_SESSION['emailError'])){
                            echo $_SESSION['emailError'];
                            echo '<br>';
                            unset($_SESSION['emailError']);
                        }
                        if(isset($_SESSION['updateError'])){
                            echo $_SESSION['updateError'];
                            echo '<br>';
                            unset($_SESSION['updateError']);
                        }
                    ?>
                </div>
                <div id="successmsg" class="success-msg">
                    <?php
                        if(isset($_SESSION['UpdatesuccessMsg'])){
                            echo $_SESSION['UpdatesuccessMsg'];
                            echo '<br>';
                            unset($_SESSION['UpdatesuccessMsg']);
                        }
                    ?>
                </div>
            </form>
            </div>
        </main>
        <?php
            require_once("../general/footer.php");
        ?>
    </body>
    <script src="/js/receptionist/edit_branch_entry.js"></script>
    <script src="/js/receptionist/edit_branch_config.js"></script>
</html