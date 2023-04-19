<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Owner's Dashboard</title>
        <link rel="stylesheet" href="/styles/owner/styles.css" />
        <link rel="stylesheet" href="/styles/owner/owner_dashboard.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    </head>

    <body>
        <?php
                require_once("header.php");
        ?>
        <main>
            <div class="body-container dashboard-cards">
                <div class="content-box single-card revenue-card" >
                    <div class="card-title"> Total Revenue for This Month</div> 
                    <div id="revenue" class="card-content"></div>
                    <div class="card-button"> 
                        <button> View Branch Wise </button> 
                    </div>
                </div>
                <div class="content-box single-card">
                    <div class="card-title"> Branches</div> 
                    <div id="branches" class="card-content"></div>
                    <div class="card-button"> 
                        <button onclick="window.location.href='/public/owner/branch_details.php'"> View More </button> 
                    </div>
                </div>
                <div class="content-box single-card">
                    <div class="card-title">Recent Feedbacks</div> 
                    <div id="feedbacks" class="card-content"></div>
                </div>
                <div class="content-box single-card">
                    <div class="card-title"> Manager Requests</div> 
                    <div id="requests" class="card-content"></div>
                    <div class="card-button">  
                        <button onclick="window.location.href='/public/owner/view_manager_requests.php'"> View More </button> 
                    </div>
                </div>    
                <div class="content-box single-card">
                    <div class="card-title"> Sports</div> 
                    <div id="sports" class="card-content"></div>
                    <div class="card-button">  
                        <button onclick="window.location.href='/public/owner/sports.php'"> View More </button> 
                    </div>
                </div>
                <div class="content-box single-card">
                    <div class="card-title"> Quick Links </div> 
                    <div class="btn-container card-content several-btns">
                        <button onclick="window.location.href='/public/owner/add_new_branch.php'"> Add New Branch <i class="fa-solid fa-building-circle-arrow-right"></i></button>
                        <button onclick="window.location.href='/public/owner/add_new_sport.php'"> Add New Sport <i class="fa-solid fa-basketball"></i> <i class="fa-solid fa-circle-plus"></i></button>
                    </div>
                </div>
            </div>
        </main>
        <?php
                require_once("../general/footer.php");
        ?>
    </body>
    <script type="module" src="/js/owner/dashboard.js"></script>
    <script type="module" src="/js/general/notifications.js"></script>
</html>
