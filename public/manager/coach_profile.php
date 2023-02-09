<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Coach Profile</title>
    <link rel="stylesheet" href="/styles/manager/coach_profile.css" />
    <link rel="stylesheet" href="/styles/general/styles.css" />
    <link rel="stylesheet" href="/styles/general/staff.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>

<body>
    <?php
    require_once("manager_header.php");
    ?>
    <main>
        <div class="flex-contain">
            <div class=tabs>
                <div id="Image">
                    <img src=" C:\Users" width="250" height="250" id="img">
                </div>

                <div style="margin-bottom:10px"id="Name">
                    <div>
                        Name:
                    </div>
                    <div>
                        Coach ID:
                    </div>
                    <div>
                        Age:_______
                        <!-- </div>
                        <div> -->
                        Gender:
                    </div>
                    <div>
                        Sport:
                    </div>
                </div>

                <div id="Qual">
                    <div>
                        Qualifications:
                    </div>
                    <div>
                        Session Branches:
                    </div>
                    <div>
                        Coaching Session:
                    </div>
                    <div>
                        Email:
                    </div>
                    <div>
                        Contact Number:
                    </div>
                    <div id="Rating">
                        Rating:
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                </div>

            </div>

            <div class=tabs>
                <div id="Feedback">Student Feedback</div>
                <div id="Friend">Friendly. Teaches you from the beginning
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                </div>
                <div id="Cool"> Very cool. I love the way he teaches!
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                </div>

            </div>

        </div>

    </main>

    <?php
    require_once("../general/footer.php");
    ?>
</body>

</html>