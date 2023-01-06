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
    <title>User Profile</title>
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
            else if(isset($_SESSION['userProfile'])){
                $userDetails = $_SESSION['userProfile'][0];
        ?>
                <?php if(isset($userDetails->profile_photo)){?>
                    <div style="display:flex; justify-content:center;margin-bottom:30px"><img src="/styles/icons/<?php echo $userDetails->profile_photo?>" class="branch-img" style="border: solid thin black"></div>
                <?php
                }
                else{
                ?>
                    <div style="display:flex; justify-content:center;margin-bottom:30px"><img src="/styles/icons/profile_icon.svg" class="branch-img"></div>
                <?php
                }
                ?>
                <br>
                <div class="row-container">
                    <div class="left-side"> Name: </div>
                    <div class="right-side"> <output> <?php echo $userDetails->first_name." ".$userDetails->last_name ?> </output> </div>
                </div>
                <br>
                <div class="row-container">
                    <div class="left-side"> Gender: </div>
                    <div class="right-side"> <output> 
                    <?php
                        if($userDetails->gender==='m') echo "Male"; else echo "Female"; 
                    ?> </output> </div>
                </div>
                <br>
                <div class="row-container">
                    <div class="left-side"> Birthday: </div>
                    <div class="right-side"> <output> <?php echo $userDetails->birthday ?> </output> </div>
                </div>
                <br>
                <div class="row-container">
                    <div class="left-side"> Contact Number: </div>
                    <div class="right-side"> <output> <?php echo $userDetails->contact_num ?> </output> </div>
                </div>
                <br>
                <div class="row-container">
                    <div class="left-side"> Home Address: </div>
                    <div class="right-side"> <textarea readonly> <?php echo $userDetails->home_address ?> </textarea></div>
                </div>
                <br>
                <div class="row-container">
                    <div class="left-side"> Height: </div>
                    <div class="right-side"> <output> 
                    <?php 
                        if(isset($userDetails->height)) echo $userDetails->height." cm"; else echo "Not mentioned";  
                    ?> </output> </div>
                </div>
                <div class="row-container">
                    <div class="left-side"> Weight: </div>
                    <div class="right-side"> <output>
                    <?php 
                        if(isset($userDetails->weight)) echo $userDetails->weight." kg"; else echo "Not mentioned"; 
                    ?>
                    </output> </div>
                </div>
            
            <u> Emergency Details </u>
            <?php
                $dependents = $_SESSION['userProfile'][2];
            ?>
                <?php
                    foreach($dependents as $row){ ?>
                        <div class="row-container">
                            <div class="left-side"> Name: </div>
                            <div class="right-side"> <output> <?php echo $row['name'] ?> </output> </div>
                        </div>
                        <div class="row-container">
                            <div class="left-side">  Relationship:  </div>
                            <div class="right-side"> <output><?php echo $row['relationship'] ?> </output>  </div>
                        </div>
                        <div class="row-container">
                            <div class="left-side">  Contact Number: </div>
                            <div class="right-side"> <output> <?php echo $row['contact_num'] ?> </output> </div>    
                        </div>
                        <p> -------------------------------------</p>
                <?php
                    }
                    $medicalC = $_SESSION['userProfile'][1];
                ?>
                    <u> Medical Concerns </u> 
                    <?php
                        if(count($medicalC)===0) {
                    ?>     <div class="row-container"> <div class="left-side"> <output> <?php echo "No medical concerns mentioned"; ?> </output> </div> </div> 
                    <?php
                        }
                        else{
                            foreach($medicalC as $row) { ?>
                               <div class="row-container"> <div class="left-side"> <output> <?php echo $row['medical_concern'] ?> </output>  </div> </div>
                                <br>
                    <?php
                            }
                        }  
        }
        ?>
    </div>
    </main>
    
</body>
</html>