<header>
    <div class='header-top'>
        <div> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/public/manager/manager_dashboard.php'){  //manager dashboard
                    echo "Welcome, ".$_SESSION['username'];
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/manager_login.php'){  //staff login
                    echo "Manager Login";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/manager_add_court.php'){  //addcourt
                    echo "Add New Court";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/sport_court.php'){  //sportcourt
                    echo "Sport Court";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/coach_profile.php'){  //coachprofile
                    echo "Coach Profile";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/discount_history.php'){  //discountHistory
                    echo "Discount History";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/manager_edit_time.php'){  //edittime
                    echo "Edit Time";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/manager_add_new_discount.php'){  //addnewdiscount
                    echo "Add New Discount";
                }
                
            ?>
        </div>
        <div style="align-items:center;">
            <?php    
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //manager logged in     
                echo "Branch: ".$_SESSION['city'];
            ?>
        </div>
        <div style="align-items:flex-end;">
            <?php
                if($_SERVER['REQUEST_URI'] === '/public/manager/manager_dashboard.php'){  //Check whether the manager is in the dashboard
            ?>
                    <button style="float:right" class ="btn" id="logout" onclick="window.location.href=''"><img src="/styles/icons/bell_icon.svg" class="acc-img"></button>
                    <button style="float:right" class ="btn" id="logout" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>        
            <?php 
                } else { 
            ?>
                    <button style="float:right" class ="btn" id="logout" onclick="window.location.href=''"><img src="/styles/icons/bell_icon.svg" class="acc-img"></button>
                    <button style="float:right" class ="btn" id="logout" onclick="window.location.href='/public/manager/manager_dashboard.php'">Dashboard<img src="/styles/icons/dashboard_icon.svg" class="dash-img"></button>
                    <button style="float:right" class ="btn" id="logout" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>        
            <?php
                }
            }
            ?>
        </div>    
    </div>
</header>
