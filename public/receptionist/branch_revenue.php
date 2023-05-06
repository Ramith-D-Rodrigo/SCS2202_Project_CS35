<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
        Security::redirectUserBase();
        die();
    }
?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <link rel="stylesheet" href="/styles/general/staff.css">
        <link rel="stylesheet" href="/styles/receptionist/revenue.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    </head>
    <title>
        Branch Revenue
    </title>
    <body>
        <?php
            require_once("dashboard_header.php");
        ?>
        <main class="body-container">
            <div class="content-box">
                <div class="all-filter-container">
                    <div class="filter-container">
                        Sport
                        <select id="sport-filter" class="filter">
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>

                <div class="all-filter-container">
                    <div class="filter-container">
                        From 
                        <input type="date" id="from-date" class="filter">
                    </div>

                    <div class="filter-container">
                        To
                        <input type="date" id="to-date" class="filter">
                    </div>
                </div>

                <div class="all-filter-container">
                    <div class="filter-container">
                        <label for="all-revenue" class="filter">
                            <input type="checkbox" name="all-revenue" id="all-revenue" value="all-revenue" checked>
                            All
                        </label>
                        <label for="reservations" class="filter">
                            <input type="checkbox" name="reservations" id="reservation" value="reservation" checked>
                            Reservations
                        </label>
                        <label for="coachingSessions" class="filter">
                            <input type="checkbox" name="coachingSessions" id="coachingsession" value="coachingsession" checked>
                            Coaching Sessions
                        </label>
                    </div>
                </div>
                <div class="revenue-container">
                    <canvas id="revenue">
                    </div>
                </div>
            </div>
        </main>
        <?php
            require_once("../../public/general/footer.php");
        ?>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" src="/js/receptionist/branch_revenue.js"></script>
</html>