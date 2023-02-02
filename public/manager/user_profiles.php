<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>User Profiles</title>
    <link rel="stylesheet" href="/styles/manager/user_profiles.css" />
    <link rel="stylesheet" href="/styles/general/styles.css" />
</head>

<body>
    <?php
    require_once("manager_header.php");
    ?>
    <main class="body_container">
        <div class="content_box">
                <div id="Sub_Ent">
                    <form action="">
                        <input type="text" placeholder="Enter Username or Name" id="Enter" name="search">
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
                Username:
                    <input type="text" pattern="[a-zA-Z]+" name="Sport" id="name" value="football">
                Age:
                    <input type="text" pattern="[0-9]+" name="Sport" id="Age" value="20">
                <br>    
                    <button  onclick="window.location.href='user_profile.php'" type="submit" id="but_Add">View Profile</button>
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