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
            <form method="POST" action="../../controller/system_admin/system_maintenance_controller.php">
                <div class="row-container">
                    <div class="left-side">Starting Date: </div>
                    <div class="right-side"><input required type="date" name="startingDate" id="startingDate"></div>
                </div>
                <div class="row-container">
                    <div class="left-side">Starting Time: </div>
                    <div class="right-side"><input required type="time" name="startingTime" id="startingTime"></div>
                </div>
                <div class="row-container">
                    <div class="left-side">Expected Down Time: </div>
                    <div class="right-side" style="display:flex;flex-direction:row">
                        <input style="width: 100px;" required type="number" 
                        name="Hrs" id="Hrs" placeholder="Hrs"
                        min="0" max="168"> </input>
                        <input style="width: 15px;" readonly value=":"></input>
                        <input style="width: 100px;" required type="number" 
                        id="Mins" name="Mins" placeholder="Mins"
                        min="0" max="59"></input>
                    </div>
                </div>
                <div class="row-container" style="justify-content: flex-end;">
                    <button onclick="return validateForm(event)" type="submit">Add</button> 
                    <button  onclick="window.location.href='/public/system_admin/add_system_maintenance.php'">Cancel</button>
                </div>
                <div id="err-msg" class="err-msg">
                    <?php
                        if(isset($_SESSION['maintenanceErr'])){
                            echo $_SESSION['maintenanceErr'];
                            echo '<br>';
                            unset ($_SESSION['maintenanceErr']);
                        }
                    ?>

                </div>
                <div id="successmsg" class="success-msg">
                    <?php 
                        if(isset($_SESSION['successMsg'])){
                            echo $_SESSION['successMsg'];
                            echo '<br>';
                            unset($_SESSION['successMsg']);
                        }
                    ?>
                </div>
            </form>
        </div>
    </main>
    <?php
        require_once("../../public/general/footer.php");
    ?>
</body>
    <script src="/js/system_admin/sys_maintenance_validation.js"></script>
</html>