<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['admin'])){
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
    <title>Add System Maintenance</title>
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
                    <div class="left-side">Starting Date: </div>
                    <div class="right-side"><input required type="date" id="startingDate"></div>
                </div>
                <div class="row-container">
                    <div class="left-side">Starting Time: </div>
                    <div class="right-side"><input required type="time" id="startingTime"></div>
                </div>
                <div class="row-container">
                    <div class="left-side">Expected Down Time: </div>
                    <div class="right-side" style="display:flex;flex-direction:row">
                        <input style="width: 100px;" required type="number" 
                        id="Hrs" placeholder="Hrs"
                        min="0" max="168"> </input>
                        <input style="width: 15px;" readonly value=":"></input>
                        <input style="width: 100px;" required type="number" 
                        id="Mins" placeholder="Mins"
                        min="0" max="59"></input>
                    </div>
                </div>
                <div id="err-msg" class="err-msg">
                </div>
                <div class="row-container" style="justify-content: flex-end;">
                    <button onclick="validateForm(event)">Add</button> 
                    <button  onclick="window.location.href='/public/system_admin/add_system_maintenance.php'">Cancel</button>
                </div>
            </form>
        </div>
        <div id="overlay"></div>
        <div id="success-msg">
        </div>
    </main>
    <?php
        require_once("../../public/general/footer.php");
    ?>
</body>
    <script src="/js/system_admin/sys_maintenance_validation.js"></script>
    <script type="module" src="/js/general/notifications.js"></script>
</html>