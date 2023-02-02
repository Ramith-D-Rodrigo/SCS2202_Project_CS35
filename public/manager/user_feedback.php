<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>User Feedback</title>
    <link rel="stylesheet" href="/styles/manager/user_feedback.css" />
    <link rel="stylesheet" href="/styles/general/styles.css" />
</head>

<body>
    <?php
    require_once("manager_header.php");
    ?>
    <main class="body_container">
        <div class="content_box">
            <div id="current">Current Rating:
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
            </div>
            <div id="Table">
                <table style="width:95% ">
                    <tr>
                        <th id="date">Date</th>
                        <th id="starting">Feedback and Review</th>
                        <th id="ending">User Rating</th>
                    </tr>
                    <tr>
                        <td id="One"></td>
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