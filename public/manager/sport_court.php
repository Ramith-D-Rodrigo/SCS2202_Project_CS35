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
  </head>

   <body>
      <?php
        require_once("sport_court_header.php");
      ?>
        <main class="body_container">
          <div class="content_box">
          <div>Filder by:
            <select required name="sport">
              <option value="">Choose </option>
              <option value="Badminton" <?php if(isset($_SESSION['sport'])){
                if($_SESSION['sport'] === "Badminton"){
                  echo 'selected';
                }
              }?>>Badminton</option>
              <option value="Basketball" <?php if(isset($_SESSION['sport'])){
                if($_SESSION['sport'] === "Basketball"){
                  echo 'selected';
                }
              }?>>Basketball</option>
              <option value="Tennis" <?php if(isset($_SESSION['sport'])){
                if($_SESSION['sport'] === "Tennis"){
                  echo 'selected';
                }
              }?>>Tennis</option>
            </select>
          </div>
          <div>
          <button>  Add New Court</button>
          </div>
          
          <div>
          <div>
          <img src=" C:\Users"  width="100" height="100">
          </div>
          <!-- <div>Photo:
            <input type=file name="Court_pic" accept=".jpg, .jpeg, .png" id="Court_pic" title="Maximum File Size 2MB. Only Accepts JPG, PNG">
          </div> -->
          <?php
          $sportSql = sprintf("SELECT * FROM `sports_court`"); 
  
          $sportResult = $connection -> query($sportSql);
          $sportR = mysqli_fetch_assoc($sportResult);
          while ($row = $sportResult -> fetch_assoc() ){
            echo '<div>
            Sport:';
            $sportSq = sprintf("SELECT `sport_name` FROM `sport` WHERE `sport_ID` = '%s'",
            $connection -> real_escape_string($sportR['sport_id'])); 
  
            $sportResult2 = $connection -> query($sportSq);
            $sportR2 = mysqli_fetch_assoc($sportResult2);
          echo ' '. $sportR2['sport_name'] . '<br>Court Name: ' . $row['court_name'] . '<br>Court ID: ' . bin_to_uuid($row['court_id'], $connection) . ' <br>
            <button>View Reservation Schedule</button>  
            </div>
            <div>
            <img src=" C:\Users"  width="100" height="100">
            </div>';
          }?>
            
          </div>
          </div>
        </main>
        <?php
          require_once("../general/footer.php");
        ?>
    </body>
</html>    