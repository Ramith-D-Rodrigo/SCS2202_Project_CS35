<?php
    session_start();
    require_once("../../src/receptionist/dbconnection.php");
    // if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is not logged in
    //     header("Location: /index.php");
    //     exit();
    // }

    // if($_SESSION['userrole'] !== 'receptionist'){   //not an user (might be another actor)
    //     header("Location: /index.php");
    //     exit();
    // }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <title>Request Maintenance</title>
    </head>

    <body>
        <?php
             require_once("dashboard_header.php");
        ?>
        <main class="body-container">
        <div class="content-box">
            <form action="/controller/receptionist/req_maintenance_controller.php" method="post" id="reqForm">
                <label> Maintenance Reason : 
                <!-- <textarea 
                rows='1' 
                name='reason' 
                id='reason' 
                required > </textarea>     -->
                <input 
                name="reason" 
                id="reason" 
                required> </input>
                </label> 
                <br>
            <?php
                if(isset($_SESSION['searchErrorMsg'])){
            ?>      <div class="err-msg"><?php echo $_SESSION['searchErrorMsg']; ?></div>
            <?php
                }
                else if(isset($_SESSION['sportResult'])){
            ?>
                    Sport Name :  
                    <select name="sportName" id="sportName" onchange="checkAll()">
                    <?php 
                    $nameArray =  $_SESSION['sportResult'];
                    foreach($nameArray as $name) {
                        ?> 
                        <option id="sportOption" value="<?php echo $name; ?>">                            
                        <?php echo $name; ?>                           
                        </option>
                        
                    <?php
                    }
                }
                    ?> 
                        <option id="sportAllOption"  value="">ALL</option>
                    </select>  
                    <br>
                    <?php
                if(isset($_SESSION['searchErrorMsg'])){
            ?>      <div class="err-msg"><?php echo $_SESSION['searchErrorMsg']; ?></div>
            <?php
                }
                else if(isset($_SESSION['courtResult'])){
            ?>
                    Sport Court Name :  
                    <select name="courtName" id="courtName">
                    <?php 
                    $courtArray =  $_SESSION['courtResult'];
                    foreach($courtArray as $court) {
                        ?> 
                        <option id="courtOption" value="<?php echo $court; ?>">                            
                        <?php echo $court; ?>                           
                        </option>
                        
                    <?php
                    }
                }
                    ?> 
                        <option id="courtAllOption" value="">ALL</option>
                    </select>  
                    <br>   
                <div>
                Starting Date :
                <input type="date"
                    id ="sDate" 
                    name="sDate" 
                    required
                    value=<?php if(isset($_SESSION['sDate'])) echo htmlspecialchars($_SESSION['sDate'], ENT_QUOTES)?>> 
                <br> 
                Ending Date : 
                <input type="date"
                    id ="eDate" 
                    name="eDate" 
                    required
                    value=<?php if(isset($_SESSION['eDate'])) echo htmlspecialchars($_SESSION['eDate'], ENT_QUOTES)?>> 
                <br> 
                <div id="msgbox">
                    <?php
                        if(isset($_SESSION['errMsg'])){
                            echo $_SESSION['errMsg'];
                            echo '<br>';
                            unset($_SESSION['errMsg']);
                        }

                        if(isset($_SESSION['LogInsuccessMsg'])){
                            echo $_SESSION['LogInsuccessMsg'];
                            echo '<br> You will be Redirected to the Dashboard. Please Wait';
                            unset($_SESSION['LogInsuccessMsg']);
                            header("Refresh: 3; URL =/public/receptionist/receptionist_dashboard.php");   //have to change
                        }
                    ?>
                </div>
                <button type="submit" 
                    id="login"  
                    name= "reqSubmitBtn" 
                    value="submit" 
                    onclick="return validateForm(event)"
                > Submit </button>
            </form>
        </div>
        </main>
        <?php
            require_once("../general/footer.php");
        ?>
    </body>
    <script src="/js/receptionist/maintenance_validation.js"></script>
</html>