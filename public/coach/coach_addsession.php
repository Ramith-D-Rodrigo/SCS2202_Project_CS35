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
                        <option value ="branch 1">branch 1</option>
                        <option value ="branch 2">branch 2</option>
                        <option value ="branch 3">branch 3</option>

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

            <label>Select timeslot : 
                <select names ="timeslot" id="timeslot">
                        <option value ="0800-1000">0800-1000</option>
                        <option value ="1200-1400">1200-1400</option>
                        <option value ="1500-1800">1500-1800</option>

                </select> 
            </label>

            <br>

            <label>Enter session fee : <input type="number" name "session_fee" > </label>
            <input type="text"
                        pattern="[0-9]" 
                        name="session_fee"
                        id="session_fee"
                        required
                        value=<?php if(isset($_SESSION['session_fee'])) echo htmlspecialchars($_SESSION['session_fee'], ENT_QUOTES)?>>
                
            <br>
                
            <label> Monthly payment :  ______________ </label>
            
            <br>
            <br>

            <h5>Only limited (number) students can join the sessionn</h5>

            
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

</body>

</html>