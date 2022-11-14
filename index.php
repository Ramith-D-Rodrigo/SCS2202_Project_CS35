<<<<<<< HEAD
<?php
    session_start();
    foreach($_SESSION as $key => $value){
        if($key === 'userrole' || $key === 'userid' || $key === 'userProfilePic'){   //unset other variables like register prefillings
            continue;
        }
        unset($_SESSION[$key]);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sports Complex</title>
        <link rel="stylesheet" href="./styles/general/styles.css">
    </head>
    <body>
        <?php
            require_once("./public/general/header.php");
        ?>
        <main>
            <div class="search">
                <form action="/controller/general/search_controller.php" method="post" id="searchBar" style="min-width:80%">
                    <input class="search-input" type="text" name="sportName" placeholder="Search a Sport" pattern="[a-zA-Z]+" title="Enter The Name Correctly" required>
                    <button class ="search-icon-btn" type="submit" onclick="return searchValidation(event)">Search</button>
                </form>
            </div>
        </main>
        <?php
            require_once("./public/general/footer.php");
        ?>
    </body>
    <script src="/js/general/search_validation.js"></script>
    <script src="/js/user/account_links.js"></script>
=======
<?php
    session_start();
    foreach($_SESSION as $key => $value){
        if($key === 'userrole' || $key === 'userid'){   //unset other variables like register prefillings
            continue;
        }
        unset($_SESSION[$key]);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sports Complex</title>
        <link rel="stylesheet" href="./styles/general/styles.css">
    </head>
    <body>
        <?php
            require_once("./public/general/header.php");
        ?>
        <main>
            <div class="search">
                <form action="/controller/general/search_controller.php" method="post" id="searchBar">
                    <input type="text" name="sportName" placeholder="Search a Sport" pattern="[a-zA-Z]+" title="Enter The Name Correctly" required>
                    <button type="submit" onclick="return searchValidation(event)">Search</button>
                </form>

                <!-- <button class ="btn" onclick="window.location.href='/SCS2202_Project_CS35/public/owner/owner_dashboard.php'">test</button> -->
            </div>
        </main>

        
        <?php
            require_once("./public/general/footer.php");
        ?>
    </body>
    <script src="/js/general/search_validation.js"></script>
>>>>>>> dhanuka_branch
</html>