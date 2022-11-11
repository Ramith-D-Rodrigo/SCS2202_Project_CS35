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
            require_once("../general/header.php");
        ?>
        <div>
            <form action="/controller/receptionist/req_maintenance_controller.php" method="post" id="reqForm">
                <label> Maintenance Reason : </label> 
                <textarea 
                rows='5' 
                name='reason' 
                id='reason' 
                required > </textarea>    
                
                <br>
                    <?php 
                        $sql = "SELECT DISTINCT sport.sport_name from sport INNER JOIN sports_court ON sport.sport_id = sports_court.sport_id INNER JOIN staff ON sports_court.branch_id = staff.branch_id WHERE staff.staff_id = 0x11ed60c6bc55d9b8b16d34e6d70e248d";
                        $sportNames = mysqli_query($connection,$sql);
                    ?>
                    Sport Name :
                    
                    <select name="sportName">
                        <?php
                            while ($spName = mysqli_fetch_array(
                            $sportNames,MYSQLI_ASSOC)):;
                        ?>
                        <option value="<?php echo $spName['sport_name'];
                        ?>">
                        <?php echo $spName['sport_name'];
                        ?>
                        </option>
                        <?php
                        endwhile;
                        ?>
                        <option value="">NULL</option>
                    </select>
                    <br>
                    <?php 
                        $sql = "SELECT DISTINCT sports_court.court_name from sport INNER JOIN sports_court ON sport.sport_id = sports_court.sport_id INNER JOIN staff ON sports_court.branch_id = staff.branch_id WHERE staff.staff_id = 0x11ed60c6bc55d9b8b16d34e6d70e248d ";
                        $coNames = mysqli_query($connection,$sql);
                    ?>
                    Sport Court Name :
                    
                    <select name="courtName">
                        <?php
                            while ($coName = mysqli_fetch_array(
                            $coNames,MYSQLI_ASSOC)):;
                        ?>
                        <option value="<?php echo $coName['court_name'];
                        ?>">
                        <?php echo $coName['court_name'];
                        ?>
                        </option>
                        <?php
                        endwhile;
                        ?>
                        <option value="">NULL</option>
                    </select>    
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
                            header("Refresh: 3; URL =/index.php");   //have to change
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
        <?php
            require_once("../general/footer.php");
        ?>
    </body>
    <script src="/js/receptionist/maintenance_validation.js"></script>
</html>