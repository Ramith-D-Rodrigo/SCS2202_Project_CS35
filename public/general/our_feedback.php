<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <title>Our Feedback</title>
    </head>
    <body>
        <?php
            require_once("header.php");
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
                            <tr>
                                <th>Date</th>
                                <th>Branch</th>
                                <th>Feedback</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php
            require_once("footer.php");
        ?>
    </body>
    <script src="/js/user/account_links.js"></script>
    <script src="/js/general/our_feedback.js"></script>
</html>