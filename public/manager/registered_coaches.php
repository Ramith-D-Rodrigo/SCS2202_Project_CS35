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
</head>

<body>
    <?php
    require_once("manager_header.php");
    ?>
    <main class="body_container">
        <div class="content_box">
          
                <div id ="Filter">Filter by:
                    
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

                <div id="Image">
                    <img src=" C:\Users" width="250" height="250" id="img">

                <div id="SportName">
                Name:
                    <input type="text" pattern="[a-zA-Z]+" name="Name" id="Name" value="mithilan">
                
                <br>
                Sport:
                    <input type="text" pattern="[a-zA-Z]+" name="Sport" id="name" value="football">
                <br>    
                    <button   onclick="window.location.href='coach_profile.php'" type="submit" id="but_Add">View Profile</button>
                    
                </div>
                </div>

                <div class="success-msg">
                    <?php
                    if (isset($_SESSION['resultMsg'])) {
                        echo $_SESSION['resultMsg'];
                        unset($_SESSION['resultMsg']);
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

</html>