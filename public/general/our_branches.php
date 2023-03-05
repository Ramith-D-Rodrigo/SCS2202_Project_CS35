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
                <link rel="stylesheet" href="/styles/general/our_branches.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

                <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css">

                <title>Our Branches</title>
            </head>
            <body>
                    <?php
                        require_once("header.php");
                    ?>
                    <main>
                        <div class="body-container" id="branches" style="flex-direction:column">

                        </div>
                    </main>
                    <?php
                        require_once("footer.php");
                    ?>
                    <div class="map-container content-box">
                        <div id="map"></div>
                        <div class="google-link">
                            <a href="">Open in <i class="fa-brands fa-google"></i> Maps</a>
                        </div>
                    </div>
            </body>
            <script src="/js/user/account_links.js"></script>
            <script type="module" src="/js/general/our_branchs.js"></script>
        </html>
    <?php
    }
?>