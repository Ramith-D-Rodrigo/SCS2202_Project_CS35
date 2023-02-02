<?php
    session_start();

    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the coach is not logged in
        header("Location: /index.php");
        exit();
    }

    // if($_SESSION['userrole'] !== 'coach'){   //not an coach (might be another actor)
    //     header("Location: /index.php");
    //     exit();
    // }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <link rel="stylesheet" href="/styles/coach/coach_feedback.css">
        <title>Coach Feedback</title>
    </head>
    <body>
        <?php
            require_once("dashboard_header.php");
        ?>
        <main>
            <div class="content-box" style="align-items:center">
                <div>
                    Filter By Branch:
                    <select id="branchFilter">
                        <option value="">All</option>
                    </select>
                </div>
                <div id="feedbackTableContainer" style="width:100%">
                    <table style="width:100%">
                        <thead>
                            <tr class="headRow">
                                <th>Date</th>
                                <th>Feedback</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2023.05.13</td>
                                <td>Good</td>
                                <td>***</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php
            require_once("../../public/general/footer.php");
        ?>
    </body>
    <!-- <script src="/js/user/account_links.js"></script>
    <script src="/js/general/our_feedback.js"></script> -->
</html>