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
    <link rel="stylesheet" href="/styles/receptionist/receptionist.css" />
    <title>View User Profiles</title>
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
            else if(isset($_SESSION['profileResults'])){ 
                $profilesArray = $_SESSION['profileResults']; 
                $i = 0;
                foreach($profilesArray as $row) { ?>
                <form class="search_result" action="/controller/receptionist/view_sProfile_controller.php" method="POST">
                <div class="row-container">
                    <div class="left-side">
                        <?php if(isset($row['profile'])){?>
                            <img src="/styles/icons/sports/basketball.jpg" class="branch-img" style="border: solid thin black">
                        <?php
                        }
                        else{
                        ?>
                            <img src="/styles/icons/profile_icon.svg" class="branch-img">
                        <?php
                        }
                        ?>
                    </div>
                    <div class="right-side" style="margin-top: 60px;">
                        Name: <?php echo $row['fName']." ".$row['lName'] ?>
                        <br>
                        Contact Number: <?php echo $row['contactN'] ?>
                        <br>   
                        <button type="submit"
                        name = 'viewBtn'
                        value="<?php echo $i ?>"> View Profile </button>
                    </div>
                    <br>
                </div>
                </form>    
                <?php
                $i++; // increment the $i to get track of the index of the array   
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