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
        <link rel="stylesheet" href="/styles/general/our_branches.css">

        <title>Our Branches</title>
    </head>
    <body>
            <?php
                require_once("header.php");
            ?>
            <main class="body-container">
                <div class="content-box" id="branches">
                </div>
            </main>
            <?php
                require_once("footer.php");
            ?>
    </body>
    <script src="/js/user/account_links.js"></script>
    <script src="/js/general/our_branchs.js"></script>
</html>