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
            <form id="branchForm" method="post">
                <div class="row-container">
                    <div class="left-field"> Branch Location (Main City): </div>
                    <div class="right-field" id="location"> 
                    </div>
                </div>
                <br>
                <div class="row-container">
                    <div class="left-field"> Branch Contact Number(s) : <br> 
                        <p style="font-size:10px;font-style:italic">Only the second number can be changed</p>
                    </div>
                    <div class="right-field" id="numbers" style="display:flex;flex-direction:column;justify-content:center">
                    </div>
                </div>
                <div style="margin-left:400px"> <button type ="submit" 
                    id ="ChangeNumBtn"> Change </button> </div>
                
                
                <div class="row-container" id="newNumberField">
                    <div class="left-field" id="numberLSide"> Con. Number to Replace: </div>
                    <div class="right-field" id="numberRSide"><input
                    name = "newNumber"
                    id="newNumber" 
                    type="text"
                    pattern="[0-9]{10,11}"
                    placeholder="New Contact Number"
                    > </div>
                </div>
                <br>
                <div class="row-container">
                    <div class="left-field"> Branch Email : </div>
                    <div class="right-field" style="width:55%" id="email">  </div>
                </div>
                <div div style="margin-left:400px"> <button type ="submit" 
                    id="EmailChangeBtn"> Change </button> 
                </div>
                <div class="row-container" id="newEmailField">
                    <div class="left-field" id="emailLSide"> Email Address to Replace: </div>
                    <div class="right-field" style="width:55%" id="emailRSide"> <input
                    type="email"
                    name="newEmail"
                    id="newEmail" 
                    placeholder="New Email Address"
                    > </div>
                </div>
                <br>
                <div>
                    <div> Branch Photos : </div>
                    <br>
                    <div id="photo" style="display:flex;justify-content:space-between;width:500px;height:220px;overflow-x:scroll">
                    </div>  
                </div>
                <div class="row-container">
                    <div class="left-field">Add More Branch Photos</div> 
                    <div class="right-field"><input name="branchPic" type="file" accept="image/*" id="newPhoto"></div>
                </div>
                <div id="err-msg" class="err-msg"></div>
                <div style="display:flex;flex-direction:row">  
                    <div style="display:flex;justify-content:left">
                        <button type="button" onclick="window.location.href='/public/receptionist/edit_branch.php'">Cancel</button>
                    </div>
                    <div style="display:flex;justify-content:right">
                        <button 
                        id ="changeBtn">Apply Changes</button>
                    </div>
                </div>
            </form>
            </div>
            <div id="overlay"></div>
            <div id="success-msg"></div>
        </main>
        <?php
            require_once("../general/footer.php");
        ?>
    </body>
    <script src="/js/receptionist/edit_branch_entry.js"></script>
    <script src="/js/receptionist/edit_branch_config.js"></script>
    <script type="module" src="/js/general/notifications.js"></script>
</html