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
    <link rel="stylesheet" href="/styles/general/styles.css">
    <link rel="stylesheet" href="/styles/general/notification.css">
    <link rel="stylesheet" href="/styles/general/staff.css">
    <link rel="stylesheet" href="/styles/owner/view_revenue.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>View Revenue</title>
</head>
<body>
    <?php
        require_once("header.php"); 
    ?>
    <main class="body-container">
        <div style="display:flex;flex-direction:column">
            <div class="content lCard">
                <div> <h1>Total Revenue</h1> </div>
                <div style="display:flex;flex-direction:row;justify-content:space-between">
                    <div style="display:flex;flex-direction:column">
                        <div class="row-container">
                            <div class="left-attribute">From: </div>
                            <div class="right-attribute"> <input type="date" name="from" id="from1"> </div>
                        </div>
                        <div class="row-container">
                            <div class="left-attribute">To: </div>
                            <div class="right-attribute"> <input type="date" name="to" id="to1"> </div>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column">
                        <div>
                            Branch: 
                            <select id="branch1">
                                <option value="">Choose a branch..</option>
                            </select>
                        </div>
                        <div>
                            Sport: 
                            <select style="margin-left:10%" id="sport1">
                                <option value="all">All Sports</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="barChart" class="chart"> 
                    <canvas id="myChart"></canvas>
                </div>
                <div style="color: red;text-align: center;" id="err-msg1"></div>
            </div>
            <div style="display: flex;flex-direction:row;justify-content:space-around">
                <div class="content sCard">
                    <h2>Revenue By Coaching Sessions</h2>
                    <div style="display:flex;flex-direction:row;justify-content:space-between">
                        <div style="display:flex;flex-direction:column">
                            <div class="row-container">
                                <div class="left-attribute">From: </div>
                                <div class="right-attribute"> <input type="date" name="from" id="from2"> </div>
                            </div>
                            <div class="row-container">
                                <div class="left-attribute">To: </div>
                                <div class="right-attribute"> <input type="date" name="to" id="to2"> </div>
                            </div>
                        </div>
                        <div style="display:flex;flex-direction:column">
                            <div> Branch:   
                                <select id="branch2">
                                    <option value="">Choose a Branch..</option>
                                </select>
                            </div>
                            <div>
                                Sport: 
                                <select style="margin-left:10%" id="sport2">
                                    <option value="all">All Sports</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="barChart2" class="chart"> 
                        <canvas id="myChart2"></canvas>
                    </div>
                    <div style="color: red;text-align: center;" id="err-msg2"></div>
                </div>
                <div class="content sCard">
                    <h2>Revenue By Court Reservation</h2>
                    <div style="display:flex;flex-direction:row;justify-content:space-between">
                        <div style="display:flex;flex-direction:column">
                            <div class="row-container">
                                <div class="left-attribute">From: </div>
                                <div class="right-attribute"> <input type="date" name="from" id="from3"> </div>
                            </div>
                            <div class="row-container">
                                <div class="left-attribute">To: </div>
                                <div class="right-attribute"> <input type="date" name="to" id="to3"> </div>
                            </div>
                        </div>
                        <div style="display:flex;flex-direction:column">
                            <div>
                                Branch: 
                                <select id="branch3">
                                    <option value="">Choose a Branch..</option>
                                </select>
                            </div>
                            <div>
                                Sport: 
                                <select style="margin-left:10%" id="sport3">
                                    <option value="all">All Sports</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="barChart3" class="chart"> 
                        <canvas id="myChart3"></canvas>
                    </div>
                    <div style="color: red;text-align: center;" id="err-msg3"></div>
                </div>
            </div>
        </div>
        
        
    </main>
    <?php 
        require_once("../../public/general/footer.php");
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/js/owner/view_total_revenue.js"></script>
<script src="/js/owner/court_reservation_revenue.js"></script>
<script src="/js/owner/coach_session_revenue.js"></script>
</html>