<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search a Sport</title>
    </head>

    <body>
        <?php
            require_once("header.php");
        ?>
        <div>
            <?php
                if(isset($_SESSION['searchErrorMsg'])){
                    echo $_SESSION['searchErrorMsg'];
                    unset($_SESSION['searchErrorMsg']); //Unset for future searching
                }
                else if(isset($_SESSION['description'])){
                    echo $_SESSION['description'];
                    unset($_SESSION['description']);    //unset for future searching
                }
            ?>
        </div>

        <?php
            require_once("footer.php");
        ?>
    </body>
</html>