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
        <meta charset="UTF-8" />
        <title>Owner's Dashboard</title>
        <link rel="stylesheet" href="/styles/general/styles.css" />
        <link rel="stylesheet" href="/styles/owner/owner_dashboard.css" />
        <link rel="stylesheet" href="/styles/general/staff.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    </head>

    <title>Dashboard</title>

    <body>
        <?php
                require_once("header.php");
        ?>
        <main class="body-container dashboard-cards">
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
                <div class="card-title">Recent Feedback</div> 
                <div id="feedbacks" class="card-content"></div>
            </div>
            <div class="content-box single-card">
                <div class="card-title"> Manager Requests</div> 
                <div id="requests" class="card-content"></div>
                <div class="card-button">  
                    <button> View More </button> 
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
                <div class="card-title"> Make a Request </div> 
            </div>
        </main>
        <?php
                require_once("../general/footer.php");
        ?>
    </body>
    <script type="module" src="/js/owner/dashboard.js"></script>
</html>
