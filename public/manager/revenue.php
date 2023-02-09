<?php
  session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Revenue</title>
  <link rel="stylesheet" href="/styles/manager/revenue.css" />
  <link rel="stylesheet" href="/styles/general/styles.css" />
  <link rel="stylesheet" href="/styles/general/staff.css" />
</head>
<body>
<?php
    require_once("manager_header.php");
?>
<main>
    <div class="flex-container">
        <div class=tabs>
            <div>Total Revenue</div> 
            <div class="from_to">
                <div id="but_From">From:Date
                    <input type="date" value="" id="FromDate">
                </div>
                <div id="but_To">Close:Date
                    <input type="date" value="" id="ToDate">
                </div>
            </div>
            <div>Rs.________</div>
            <div>
                <button id="GenerateReport">Generate Report</button>
            </div>
        </div>

        <div class=tabs>
            <div>Revenue by Court Reservation</div> 
            <div class="start_end">
                <div id="but_Start">From:Date
                    <input type="date" value="" id="StartDate">
                </div>    
                <div id="but_End">Close:Date
                    <input type="date" value=" " id="EndDate">
                </div>
            </div>
            
            <div id="Sport">
            <select required name="sport">
                        <option value="">Sports</option>
                        <option value="Badminton" <?php if (isset($_SESSION['sport'])) {
                                                        if ($_SESSION['sport'] === "Badminton") {
                                                            echo 'selected';
                                                        }
                                                    } ?>>Badminton</option>
                        <option value="Basketball" <?php if (isset($_SESSION['sport'])) {
                                                        if ($_SESSION['sport'] === "Basketball") {
                                                            echo 'selected';
                                                        }
                                                    } ?>>Basketball</option>
            </select>
            </div>
            <div>Rs.________</div>
            <div>
                <button id="GenerateReport">Generate Report</button>
            </div>
        </div>
          
    </div>     
    <div class="flex-container">
        <div class=tabs>
            <div>Revenue by Coaching Sessions</div> 
            <div class="starting_ending">
                <div id="but_Starting">From:Date
                    <input type="date" value="" id="StartingDate">
                </div>
                <div id="but_Ending">Close:Date
                    <input type="date" value="" id="EndingDate">
                </div>
            </div>

            <div id=sport>
            <select required name="sport">
                        <option value="">Sports</option>
                        <option value="Badminton" <?php if (isset($_SESSION['sport'])) {
                                                        if ($_SESSION['sport'] === "Badminton") {
                                                            echo 'selected';
                                                        }
                                                    } ?>>Badminton</option>
                        <option value="Basketball" <?php if (isset($_SESSION['sport'])) {
                                                        if ($_SESSION['sport'] === "Basketball") {
                                                            echo 'selected';
                                                        }
                                                    } ?>>Basketball</option>
            </select>
            </div>

            <div>Rs.________</div>
            <div>
                <button id="GenerateReport">Generate Report</button>
            </div>
        </div>

        <div class=tabs>
            <div>Discount History</div>       
            <button  onclick="window.location.href='manager_add_new_discount.php'" id ="ADD">Add New Discount</button>
            <button  onclick="window.location.href='discount_history.php'" id = "VIEW">View More</button>
        </div>
         
    </div>    
    
</main>

<?php
    require_once("../general/footer.php");
?>
</body>
</html>