<?php
  session_start(); 
  require_once("../../src/manager/manager_dbconnection.php");
  require_once("../../src/general/uuid.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Sport Court</title>
    <link rel="stylesheet" href="/styles/manager/sport_court.css" />
    <link rel="stylesheet" href="/styles/general/styles.css" />
    <link rel="stylesheet" href="/styles/general/staff.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  </head>

   <body>
      <?php
        require_once("manager_header.php");
      ?>
        <main class="body_container">
          <div class="content_box" style="overflow:scroll">
            <div id="but_Filt">Filter by:</div>
            <div id="but_Choose">
              <select required name="sport">
                <option value="">Choose </option>
              </select>
            </div>
            <div>
              <button onclick="window.location.href='manager_add_court.php'"id="but_AddCourt">  Add New Court</button>
            </div>
         
            <?php
           
              if(isset($_SESSION['branchCourts'])){
                foreach($_SESSION['branchCourts'] as $currCourt){
                  echo "Sport : ".$currCourt['sport']."<br>";
                  echo "Court Name : ".$currCourt['courtName']."<br>";
                  echo "Photo : ".$currCourt['photo']."<br>";
                  if($currCourt['status'] === 'p'){
                    echo "Status : Pending<br><br>";
                  }
                  else{
                    echo "Status : Accepted<br><br>";
                  }
                  // echo "Status : ".$currCourt['status']."<br>";
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