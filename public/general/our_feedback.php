<?php
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: FALSE)){ //cannot access (NOT operator)
        Security::redirectUserBase();
    }
    else{
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="/styles/general/styles.css">
                <link rel="stylesheet" href="/styles/general/our_feedback.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                <title>Our Feedback</title>
            </head>
            <body>
                <?php
                    require_once("header.php");
                ?>
                <main>
                    <div class="content-box">
                        <div style="display:flex; flex-direction:row; justify-content:space-around">
                            <div>
                                <input placeholder="Search a Feedback" id="feedbackSearch">
                            </div>
                            <div>
                                Filter By Branch:
                                <select id="branchFilter">
                                    <option value="">All</option>
                                </select>
                            </div>
                            <div>
                                Filter By Rating:
                                <select id="ratingFilter">
                                    <option value="">All</option>
                                    <option value="5">5</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                        </div>

                        <div id="feedbackTableContainer" style="width:100%">
                            <table style="width:100%">
                                <thead>
                                    <tr class="headRow">
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
    <?php
    }
?>