<?php
    session_start();
    if(!(isset($_SESSION['userid']) && isset($_SESSION['userrole']))) {
        header("Location: /public/receptionist/receptionist_login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <title>Edit Branch</title>
    </head>

    <body>
        <?php
            require_once("dashboard_header.php");
        ?>
        <main class="body-container">
        <div class="content-box">
            <?php
                if(isset($_SESSION['searchErrorMsg'])){
            ?>      <div class="err-msg">
                    <?php 
                        echo $_SESSION['searchErrorMsg']; 
                        unset($_SESSION['searchErrorMsg']);
                    ?>
                    </div>
            <?php
                }
                else if(isset($_SESSION['searchResult'])){
                    // foreach($_SESSION['searchResult'] as $result){ //traverse the result
            ?>
                    <form class ="edit_branch" action="/controller/receptionist/edit_branch_controller.php" method="post">
                        Branch Location: <output> <?php echo $_SESSION['searchResult'][0]; ?> </output>
                        <br>
                        Branch Contact Number(s) :  
                        <?php 
                        $numArray =  $_SESSION['searchResult'][2];
                        foreach($numArray as $number) {
                            ?> <output> <?php echo $number; ?> </output> <?php
                        }
                         ?>  
                        <button type ="submit" 
                        name ="AddBtn"> Add New</button>
                        <br>
                        Branch Email : <output> <?php echo $_SESSION['searchResult'][1]; ?> </output>
                        <button type ="submit" 
                        name ="ChangeBtn"> Change </button>
                        <br>
                        Branch Photos :
                        <br>
                        <?php 
                        $photoArray =  $_SESSION['searchResult'][3];
                        foreach($photoArray as $photo) {
                            ?> <img class="branch-img" src= <?php echo $photo; ?>> <?php
                        }
                        ?>  
                        <br>
                        
                        <button style="margin-left:10px" 
                        type ="submit" 
                        name ="reserveBtn" 
                        value="submit">Apply Changes</button>
                    </form>
            <?php
                        
                }
            ?>
            </div>
        </main>
        <?php
            require_once("../general/footer.php");
        ?>
    </body>
</html>