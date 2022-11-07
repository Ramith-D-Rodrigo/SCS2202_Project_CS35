<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <title>Search a Sport</title>
    </head>

    <body>
        <?php
            require_once("header.php");
        ?>
        <main>
            <div class="search">
                    <form action="/controller/general/search_controller.php" method="post" id="searchBar">
                        <input type="text" name="sportName" placeholder="Search a Sport" pattern="[a-zA-Z]+" title="Enter The Name Correctly" required>
                        <button type="submit" onclick="return searchValidation(event)">Search</button>
                    </form>
            </div>
            <div class="content-box">

                <?php
                    if(isset($_SESSION['searchErrorMsg'])){
                ?>      <div class="err-msg"><?php echo $_SESSION['searchErrorMsg']; ?></div>
                <?php
                        //unset($_SESSION['searchErrorMsg']); //Unset for future searching
                    }
                    else if(isset($_SESSION['searchResult'])){
                        foreach($_SESSION['searchResult'] as $result){ //traverse the result
                ?>
                        <div class ="search_result">
                            Branch : <?php echo $result['location']; ?>
                            <br>
                            Sport : <?php echo $result['sport_name']; ?>
                            <br>
                            Number of Courts : <?php echo $result['num_of_courts']; ?>
                            <button class="btn" style="margin-left:10px">Make a Reservation</button>
                            <br>
                        </div>
                <?php
                        } 
                        //print_r($_SESSION['searchResult']);
                        //unset($_SESSION['searchResult']);    //unset for future searching
                    }
                ?>
            </div>
        </main>
        <?php
            require_once("footer.php");
        ?>
    </body>
</html>