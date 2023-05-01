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
                <link rel="stylesheet" href="/styles/general/about_us.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

                <title>About Us</title>
            </head>
            <body>
                <?php
                    require_once("header.php");
                ?>
                <main>
                    <div class="content-box">
                        <div class="description">
                                We are a sports complex that provides a variety of sports facilities for our members. We have a variety of sports. We also provide
                                a variety of sports equipment for our members to use. It is important to know that we are not limited to only one location. We have
                                multiple locations across the country. 
                                <br>
                                More information about our branches can be found in Our Branches page.
                                <div class='img-container'>
                                    <div id='branch-img-container'>
                                    </div>
                                    <div id='court-img-container'>
                                    </div>
                                </div>
                                <br>
                                We are also open to the public. Our aim is to provide a safe and fun environment for our members.
                                The purpose of this website is to allow our members to book courts online seamlessly and to allow them to view the availability of courts without having to visit the sports complex or call us.
                                <div class='img-container'>
                                    <img src="/uploads/gifs/reservation.gif" alt="reservation" class="gif">
                                </div>
                                <br>
                                Not only that, Personal Trainers/Coaches can register on our website and provide their services to our members by booking coaching sessions.
                                We provide facilities to our members to join coaching sessions with their favourite coaches via our website.
                                <div class='img-container'>
                                    <img src="/uploads/gifs/reg_coaches.gif" alt="reg_coaches" class="gif">
                                </div>
                                <br>
                                Your feedback is important to us. Be sure to leave us a feedback once you have checked in with your reservation.
                                <div class='img-container'>
                                    <img src="/uploads/gifs/feedback.gif" alt="reg_coaches" class="gif">
                                </div>
                                <br>
                                <div class="last-msg">We hope you enjoy your time with us.
                                    <i class="fas fa-heart last-emoji"></i>
                                </div>
                                
                        </div>
                    </div>
                </main>

                <?php
                    require_once("footer.php");
                ?>
            </body>
            <script src="/js/user/account_links.js"></script>
            <script type="module" src="/js/general/notifications.js"></script>
            <script type="module" src="/js/general/about_us.js"></script>
        </html>

    <?php
    }
?>