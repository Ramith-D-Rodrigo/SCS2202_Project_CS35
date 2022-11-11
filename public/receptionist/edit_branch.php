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
        <title>Edit Branch</title>
    </head>

    <body>
        <?php
            require_once("../general/header.php");
        ?>
        <main>
        <div class="content-box">
            <?php
                if(isset($_SESSION['searchErrorMsg'])){
            ?>      <div class="err-msg"><?php echo $_SESSION['searchErrorMsg']; ?></div>
            <?php
                }
                else if(isset($_SESSION['searchResult'])){
                    foreach($_SESSION['searchResult'] as $result){ //traverse the result
            ?>
                    <form class ="edit_branch" action="/controller/receptionist/edit_branch_controller.php" method="post">
                        Branch Location: <?php echo $result[0]; ?>
                        <br>
                        Branch Contact Number(s) : <?php echo $result[2][0]; ?> 
                        <button type ="submit" 
                        name ="AddBtn"> Add </button>
                        <br>
                        Branch Email : <?php echo $result[1]; ?>
                        <button type ="submit" 
                        name ="ChangeBtn"> Change </button>
                        <br>
                        Branch Photos : 
                        <br>
                        
                        <button style="margin-left:10px" 
                        type ="submit" 
                        name ="reserveBtn" 
                        value="submit">Apply Changes</button>
                    </form>
            <?php
                    }     
                }
            ?>
            </div>
        </main>
        <?php
            require_once("../general/footer.php");
        ?>
    </body>
</html>