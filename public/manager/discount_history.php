<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Discount History</title>
  <link rel="stylesheet" href="/styles/manager/discount_history.css" />
  <link rel="stylesheet" href="/styles/general/styles.css" />
  <link rel="stylesheet" href="/styles/general/staff.css" />

</head>

<body>
  <?php
  require_once("manager_header.php");
  ?>
  <main class="body_container">
    <div class="content_box">
      <button  onclick="window.location.href='manager_add_new_discount.php'" id="discount">Add New Discount</button>
      <button id="report">Generate Report</button>
      <div id="table">
        <table style="width:95% ">
          <tr>
            <th id="percentage">Discount Percentage</th>
            <th id="starting">Starting Date</th>
            <th id="ending">Ending Date</th>
            <th id="added">Added By</th>

          </tr>
          <tr>
            <td id="one"></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>


        </table>
      </div>
    </div>
  </main>
  <?php
  require_once("../general/footer.php");
  ?>
</body>

</html>