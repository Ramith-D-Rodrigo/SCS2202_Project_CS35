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
                <select name ="branch" id="branch">
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
                <select name ="court" id="Court">
                <?php
                        foreach($BranchesWithCourts as $i){
                            foreach($i['courts'] as $j){
                            ?> <option value=<?php echo $j['id']?>><?php echo $j['name']?></option>
                            <?php
                                $k++;
                            }
                        }
                        ?> 
                </select> 
            </label>

                    <br>

            <label>Select Day : 
                <select name ="day" id="Day">
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

            <label for="StartingTime"> 
                Starting Time : 
                <input type="time" name="StartingTime" required id="StartingTime" >

            </label>

            <label for ="EndingTime">  
                Ending Time : 
                <input type="time" name="EndingTime" required id="EndingTime" >

            </label>

            <br>

            <label for="session_fee">Enter session fee : 
            <input type="text"
                        pattern="[0-9]+" 
                        name="session_fee"
                        id="session_fee"
                        required  
                        value=<?php if(isset($_SESSION['session_fee'])) echo htmlspecialchars($_SESSION['session_fee'], ENT_QUOTES)?>>
           </label>
                
            <br>
                
            <label id="m_payment" for="monthly_payment"> Monthly payment :
                        <input name= "monthly_payment" id="monthly_payment"></input>
             </label>
            
            <br>
            <br>

           <div> <h5>Only limited <?php echo $_SESSION["max_no_of_students"]?> students can join the sessionn</h5> </div>

     
            <div id="errmsg" class="err-msg">   </div>
                               
            <div id="errmsg1" class="err-msg"> </div>

                               
           <div>Minimum Coaching Session Price : <output id="min_coaching_session_price"><?php echo $_SESSION["min_coaching_session_price"]?></output></div>

            <div hidden ><output id="reservation_price" ><?php echo $_SESSION["reservation_price"]?></output></div>

            <div  hidden ><output id="max_no_of_students"><?php echo $_SESSION["max_no_of_students"]?></output></div>

            <div  hidden><output id="opening_time"  ><?php echo $_SESSION["opening_time"]?></output></div>

            <div hidden ><output id="closing_time"><?php echo $_SESSION["closing_time"]?></output></div>


            
                
            <div id="successmsg" class="success-msg"><?php
                    
                ?>
            </div>

            
            
                <button class =" " type="submit" value="submit">ADD</button>   
                <button class =" " onclick="window.location.href='/public/coach/coach_session.php'">Cancel</button>
            
        </form>  
        </div>

    
    


        
                
    </div>
</main>

        <?php
            require_once("../general/footer.php");
        ?>

    <script src="/js/coach/add_session_validation.js"></script>
    <!-- <script src="/js/coach/add_new_session_controller.js"></script> -->

</body>

</html>