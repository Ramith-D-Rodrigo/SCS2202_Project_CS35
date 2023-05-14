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
                <link rel="stylesheet" href="/styles/general/credits.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>Credits</title>
            </head>
            <body>
                <?php
                    require_once("../../public/general/header.php");
                ?>
                <main>
                    <div class="content-box">
                        <div style="text-align:center"> Credits for Sources </div>
                    <ul>
                        <li>
                            Register User Image : <a href="https://www.freepik.com/free-vector/self-confidenceconcept-illustration_15109971.htm#query=strength&position=41&from_view=search&track=sph">Image by storyset</a> on Freepik
                        </li>
                        <li>
                            Register Coach Image : <a href="https://www.freepik.com/free-vector/coach-concept-illustration_13549602.htm#page=2&query=basketball%20coach&position=0&from_view=search&track=sph">Image by storyset</a> on Freepik
                        </li>
                                <li>
                            Results Icon : <a href="https://www.flaticon.com/free-icons/no-results" title="no results icons">No results icons created by Freepik - Flaticon</a>
                                </li> 
                        <li>
                            Landing Page 1st Image : Image by <a href="https://www.freepik.com/free-psd/basketball-player-horizontal-banner_8381258.htm#page=5&query=sports%20complex&position=11&from_view=search&track=sph">Freepik</a>
                        </li>
                        <li>
                            Landing Page 2nd Image : Image by <a href="https://www.freepik.com/free-psd/feminine-football-banner-template_15554540.htm#page=2&query=sports%20complex&position=36&from_view=search&track=sph">Freepik</a>
                        </li>
                        <li>
                            Background Image : <a href="https://www.freepik.com/free-vector/physical-activity-seamless-pattern_2874264.htm">Image by macrovector</a> on Freepik
                        </li>
                        <li>
                            Volleyball Photo by <a href="https://unsplash.com/@miguelteirlinck?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Miguel Teirlinck</a> on <a href="https://unsplash.com/photos/VDkRsT649C0?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>
                        </li>
                        <li>
                            Table Tennis Photo by Anna Shvets: <a href="https://www.pexels.com/photo/table-tennis-rackets-3846048/">Pexels</a>
                        </li>
                        <li>
                           Forgot password image: <a href="https://www.freepik.com/free-vector/mobile-login-concept-illustration_4957136.htm#query=login&position=0&from_view=search&track=sph">Image by storyset</a> on Freepik
                        </li>
                        <li>
                           Swimming photo : Image by <a href="https://www.freepik.com/free-photo/high-angle-male-swimmer-water-pool_10296697.htm#query=swimming&position=22&from_view=search&track=sph">Freepik</a>
                        </li>
                        <li>
                            Tennis photo : <a href="https://www.freepik.com/free-photo/tennis-racket-new-tennis-ball-freshly-painted-tennis-court_10138885.htm#query=tennis&position=32&from_view=search&track=sph">Image by standret</a> on Freepik
                        </li>
                        <li>
                            Bowling photo : <a href="https://www.freepik.com/free-photo/this-is-gonna-be-strike-rear-particle-view-man-casual-clothes-playing-bowling-club_9690945.htm#query=bowling&position=1&from_view=author">Image by standret</a> on Freepik
                        </li>
                        <li>
                            Football photo : Photo by <a href="https://unsplash.com/@concoyne?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Connor Coyne</a> on <a href="https://unsplash.com/photos/OgqWLzWRSaI?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>
    
                        </li>
                    </ul>
            </div>
                </main>
                
                <?php
                    require_once("../../public/general/footer.php");
                ?>
            </body>
        </html>

    <?php
    }
?>