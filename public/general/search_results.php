<?php
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: FALSE, acceptingUserRoles:['user'])){ //cannot access (NOT operator)
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
                <link rel="stylesheet" href="/styles/general/reg_coaches.css">
                <link rel="stylesheet" href="/styles/general/our_branches.css">
                <link rel="stylesheet" href="/styles/general/search_results.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
                <title>Search a Sport</title>
            </head>

            <body>
                <?php
                    require_once("header.php");
                ?>
                <main>
                    <div class="search">
                        <input type="checkbox" id="searchCheck">
                        <div class="search-box">
                            <form action="/public/general/search_results.php" method="get" id="searchBar" style="min-width:80%">
                                <input class="search-input" type="text" name="sportName" placeholder="Search a Sport" pattern="[a-zA-Z]+" title="Enter The Name Correctly" required>
                                <label for="searchCheck" class="search-icon">
                                    <i class="fa-solid fa-magnifying-glass" ></i>
                                </label>
                            </form>
                        </div>
                    </div>
                    <div class="search-results">
                        <div class="content-box" style="flex:auto;" id="searchResult"></div>
                    </div>

                </main>
                <?php
                    require_once("footer.php");
                ?>
            </body>
            <script src="/js/user/account_links.js"></script>
            <script type="module" src="/js/general/search_results.js"></script>
            <script type="module" src="/js/general/notifications.js"></script>
        </html>
    <?php
    }
?>
