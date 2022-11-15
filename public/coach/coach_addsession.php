<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../../styles/coach/styles.css">
     <!-- <link rel="stylesheet" href="../../styles/coach/coach_dashboard.css">  -->

    <title>ADD session</title>
</head>

<body>
    <?php
    require_once("header.php");
    ?>

<main>
    <div class="main-body">

    <label>Select Branch : </label>
        <select names ="branch" id="branch">
                    <option value ="branch 1">branch 1</option>
                    <option value ="branch 2">branch 2</option>
                    <option value ="branch 3">branch 3</option>

                 </select>
                 <br>

     <label>Select Court : </label>
        <select names ="Court" id="Court">
                    <option value ="Court 1">Court 1</option>
                    <option value ="Court 2">Court 2</option>
                    <option value ="Court 3">Court 3</option>

                 </select>
                 <br>

    <label>Select Day : </label>
        <select names ="Day" id="Day">
                    <option value ="monday">Monday</option>
                    <option value ="tuesday">Tuesday</option>
                    <option value ="wednesday">Wednesday</option>
                    <option value ="thursday">Thursday</option>
                    <option value ="friday">Friday</option>
                    <option value ="saturday">Saturday</option>
                    <option value ="sunday">Sunday</option>

                 </select>
                 <br>

         <label>Select timeslot : </label>
        <select names ="timeslot" id="timeslot">
                    <option value ="0800-1000">0800-1000</option>
                    <option value ="1200-1400">1200-1400</option>
                    <option value ="1500-1800">1500-1800</option>

                 </select>
                 <br>

                 <label>Enter session fee : </label>
                     <input type="number" name "session_fee" >
                    <br>
                    
                <label>Monthly payment: ______________ </label>
                     
                        <br>
                        <br>

                     <h5>Only limited (number) students can join the sessionn</h5>

                <div class="Add">
                    <button>
                        ADD
                    </button>
                 </div>

                 <div class="Cancel">
                    <button>
                        Cancel
                    </button>
                 </div>




        
                
    </div>
</main>

        <?php
            require_once("../general/footer.php");
        ?>

</body>

</html>