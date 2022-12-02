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
        <title>Search a Sport</title>
    </head>

    <body>
        <?php
            require_once("header.php");
        ?>
        <main>
            <div class="search">
                    <form action="/controller/general/search_controller.php" method="post" id="searchBar" style="min-width: 80%;">
                        <input class="search-input" type="text" name="sportName" placeholder="Search a Sport" pattern="[a-zA-Z]+" title="Enter The Name Correctly" required>
                        <button type="submit" class="search-icon-btn" onclick="return searchValidation(event)">Search</button>
                    </form>
            </div>
            <div style="display:flex; flex-direction:row; justify-content:space-between">
                <div class="content-box" style="flex:auto;" id="searchResult"></div>
            </div>

        </main>
        <?php
            require_once("footer.php");
        ?>
    </body>
    <script src="/js/user/account_links.js"></script>
    <script src="/js/general/search_results.js"></script>
</html>