<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Registered Coaches</title>
    <link rel="stylesheet" href="/styles/manager/registered_coaches.css" />
    <link rel="stylesheet" href="/styles/general/styles.css" />
    <link rel="stylesheet" href="/styles/general/staff.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>

<body>
    <?php
    require_once("manager_header.php");
    ?>
    <main class="body_container">
        <div class="content_box" style="overflow:scroll">
            <div class="content_box">

                <div id="Filter">Filter by:

                    <select required name="sport">
                        <option value="">Choose </option>
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

                    <div id="Sub">
                        <form action="">
                            <input type="text" placeholder="Enter Name" id="Enter" name="search">
                            <button type="submit">submit</button>
                        </form>
                    </div>
                </div>

                <?php

                if (isset($_SESSION['coachObj'])) {
                    foreach ($_SESSION['coachObj'] as $registeredCoachObj) {
                        echo "Name: " . $registeredCoachObj['firstName']." " .$registeredCoachObj['lastName'] ."<br>";
                        "<br>";
                        echo "Sport Name: " . $registeredCoachObj['sportName'] . "<br>";
                
                        
                    }
                }
                ?>
                </form>
            </div>
    </main>
    <?php
    require_once("../general/footer.php");
    ?>
</body>

</html>