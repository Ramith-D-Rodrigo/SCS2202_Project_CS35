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
            <form type="POST" action="/src/system_admin/system_maintenance_controller.php">
                <div class="row-container">
                    <div class="left-side">Starting Date: </div>
                    <div class="right-side"><input required type="date" name="startingDate" id="startingDate"></div>
                </div>
                <div class="row-container">
                    <div class="left-side">Starting Time: </div>
                    <div class="right-side"><input required type="time" placeholder="Hrs:Mins AM/PM" name="startingTime" id="startingTime"></div>
                </div>
                <div class="row-container">
                    <div class="left-side">Expected Down Time: </div>
                    <div class="right-side"><input required name="mainTime" 
                    id="mainTime" placeholder="Hrs:Mins Format"></div>
                </div>
                <div class="row-container" style="justify-content: flex-end;">
                    <button onclick="return validateForm(event)" type="submit" class="viewBtn">Add</button> 
                    <button class="viewBtn" onclick="window.location.href='/public/system_admin/add_system_maintenance.php'">Cancel</button>
                </div>
            </form>
            <div id="err-msg">

            </div>
            <div id="successmsg" class="success-msg">
            </div>
        </div>
    </main>
    <?php
        require_once("../../public/general/footer.php");
    ?>
</body>
    <script src="/js/system_admin/sys_maintenance_validation.js"></script>
</html>