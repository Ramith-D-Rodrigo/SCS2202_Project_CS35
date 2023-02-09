<?php
session_start();
require_once("../../src/manager/manager_dbconnection.php");
require_once("../../src/general/uuid.php");

// require_once("../../controller/manager/view_time_controller.php")

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Edit Opening & Closing Time</title>
    <link rel="stylesheet" href="/styles/manager/manager_edit_time.css" />
    <link rel="stylesheet" href="/styles/general/styles.css" />
    <link rel="stylesheet" href="/styles/general/staff.css" />

</head>

<body>
    <?php
    require_once("manager_header.php");

    ?>

    <main class="body_container">
        <div class="content_box">
            <div class="open_close">
                <div id="but_Open">Current Opening Time:
                    <input type="text" value="" id="OpenTime">
                </div>
                <div id="but_Close">Current Closing Time:
                    <input type="text" value="" id="CloseTime">
                </div>

                <div id="but_Duration">Opening Duration:
                    <input type="text" value="" id="Duration">
                </div>
            </div>

            <div class="NewOpenClose">
                <div id="but_NewOpen">New Opening Time:
                    <input type="time" value="" id="NewOpen">
                </div>
                <div id="but_NewClose">New ClosingTime:
                    <input type="time" value="" id="Newclose">
                </div>
            </div>

            <div class="button">
                <div>
                    <button>Change</button>
                </div>
                <div>
                    <button onclick="window.location.href='manager_dashboard.php'">Cancel</button>
                </div>
            </div>


        </div>


    </main>

    <?php

    if (isset($_SESSION['branchTime'])) {
        foreach ($_SESSION['branchTime'] as $currTime) {

            echo  $currTime['openingTime'];
            echo  $currTime['closingTime'];
        }
    }
    ?>
    <?php
    require_once("../general/footer.php");
    ?>
</body>

</html>