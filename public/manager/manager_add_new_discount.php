<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Add New Discount</title>
    <link rel="stylesheet" href="/styles/manager/manager_add_new_discount.css" />
    <link rel="stylesheet" href="/styles/general/styles.css" />
    <link rel="stylesheet" href="/styles/general/staff.css" />

</head>

<body>
    <?php
    require_once("manager_header.php");
    ?>
    <main class="body_container">
        <div class="content_box">
            <div class="start_close">
                <div id="but_Open">Starting Date:
                    <input type="date" value="" id="StartDate">
                </div>
                <div id="but_Close">Closing Date:
                    <input type="date" value="" id="CloseDate">
                </div>
            </div>

            <div id="but_Discount">Discount Percentage:
                <input type="text" value="Enter Here" id="Percentage">
            </div>


            <div class="ReservationPrice">
                <div id="Reservation">Reservation Price with Entered value:
                    <input type="text" value="" id="Price">

                    <select required name="sport">
                        <option value="">Choose Sports</option>
                        <option value="Badminton" <?php if (isset($_SESSION['sport'])) {
                                                        if ($_SESSION['sport'] === "Badminton") {
                                                            echo 'selected';
                                                        }
                                                    } ?>>Badminton</option>
                        <option value="Basketball" <?php if (isset($_SESSION['sport'])) {
                                                        if ($_SESSION['sport'] === "Basketball") {
                                                            echo 'selected';
                                                        }
                                                    } ?>>Basketball</option>
                    </select>

                </div>
            </div>

            <div class="button">
                <div>
                    <button >Add</button>
                </div>
                <div>
                    <button onclick="window.location.href='manager_dashboard.php'">Cancel</button>
                </div>
            </div>
        </div>


    </main>

    <?php
    require_once("../general/footer.php");
    ?>
</body>

</html>