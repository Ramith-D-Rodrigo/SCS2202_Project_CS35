<?php
  session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Add New Court</title>
    <link rel="stylesheet" href="/styles/manager/manager_add_court.css" />
    <link rel="stylesheet" href="/styles/general/styles.css" />
  </head>

   <body>
      <?php
        require_once("manager_add_court_header.php");
      ?>
        <main class="body_container">
          <div class="content_box">
            <form action="/controller/manager/manager_addcourt_controller.php" method="POST">
          <div>Sports:
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
         
          <div>Court Name:
            <input type="text" pattern="[a-zA-Z]+" name="courtName"id="courtName" required  value=<?php if(isset($_SESSION['courtName'])) echo htmlspecialchars($_SESSION['courtName'], ENT_QUOTES)?>>
          </div>
         
          <div>Photo:
            <input type=file name="Court_pic" accept=".jpg, .jpeg, .png" id="Court_pic" title="Maximum File Size 2MB. Only Accepts JPG, PNG">
          </div>
          <div>
          <img src=" C:\Users"  width="250" height="250" id="img">
          </div>
          <div>
            <button type="submit" id="but_Add">Add</button>
            <button id="but_Cancel">Cancel</button>
          </div>
          </form>
          </div>
        </main>
        <?php
          require_once("../general/footer.php");
        ?>
    </body>
</html>    



