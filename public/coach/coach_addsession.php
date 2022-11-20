<?php
    session_start();

    $BranchesWithCourts = $_SESSION['BranchesWithCourts'];

    ?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../../styles/coach/styles.css">
     <link rel="stylesheet" href="../../styles/general/styles.css">
     <!-- <link rel="stylesheet" href="../../styles/coach/coach_dashboard.css">  -->

    <title>ADD session</title>
</head>

<body>
    <?php
    require_once("header.php");
    ?>

<main>
    <div class='body-container'>
    <div class="content-box">
        <form action="/controller/coach/add_new_session_controller.php" method="POST">
            <label>Select Branch : 
                <select names ="branch" id="branch">
                        <?php
                        foreach($BranchesWithCourts as $i){
                            ?> <option value=<?php echo $i[0]['id'] ?>><?php echo $i[0]['city'] ?></option>
                            <?php
                        }
                        ?> 
                </select>
            </label>
                
                    <br>

            <label>Select Court :
                <select names ="Court" id="Court">
                        <option value ="Court 1">Court 1</option>
                        <option value ="Court 2">Court 2</option>
                        <option value ="Court 3">Court 3</option>

                </select> 
            </label>

                    <br>

            <label>Select Day : 
                <select names ="Day" id="Day">
                        <option value ="monday">Monday</option>
                        <option value ="tuesday">Tuesday</option>
                        <option value ="wednesday">Wednesday</option>
                        <option value ="thursday">Thursday</option>
                        <option value ="friday">Friday</option>
                        <option value ="saturday">Saturday</option>
                        <option value ="sunday">Sunday</option>

                </select>
            </label>

                    <br>

            <label> 
                Starting Time : 
                <input type="time" name="StartingTime" required id="StartingTime" min="08:00 AM" max="04:00 PM">

            </label>

            <label>  
                Ending Time : 
                <input type="time" name="EndingTime" required id="EndingTime" min="08:00 AM" max="04:00 PM">

            </label>

            <br>

            <label>Enter session fee : 
            <input type="text"
                        pattern="[0-9]" 
                        name="session_fee"
                        id="session_fee"
                        required
                        value=<?php if(isset($_SESSION['session_fee'])) echo htmlspecialchars($_SESSION['session_fee'], ENT_QUOTES)?>>
                
            <br>
                
            <label id="monthly_payment"> Monthly payment : <input type="text" name="monthly_payment" required id="monthly_payment" > </label>
            
            <br>
            <br>

            <h5>Only limited (number) students can join the sessionn</h5>
            
            <div id="errmsg" class="err-msg"><?php
                    
                    ?>          
                               
            </div>

            <div id="min_coaching_session_price" hidden ><?php echo $BranchesWithCourts["min_coaching_session_price"]?></div>

            <div id="reservation_price" hidden ><?php echo $BranchesWithCourts["reservation_price"]?></div>

            <div id="max_no_of_students" hidden ><?php echo $BranchesWithCourts["max_no_of_students"]?></div>

            
                
            <div id="successmsg" class="success-msg"><?php
                    
                ?>
            </div>

            
            <button type="submit">
                ADD
            </button>
        
 
        
            <button>
                Cancel
            </button>
            
        </div>

    </form>
    


        
                
    </div>
</main>

        <?php
            require_once("../general/footer.php");
        ?>

    <script src="/js/coach/add_session_validation.js"></script>
</body>

</html>