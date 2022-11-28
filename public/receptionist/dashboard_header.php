<header>
    <div class='header-top'>
        <div> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/public/receptionist/receptionist_dashboard.php'){  //receptionist dashboard
                    echo "Welcome, ".$_SESSION['username'];
                }
                else if($_SERVER['REQUEST_URI'] === '/public/receptionist/receptionist_login.php'){  //staff login
                    echo "Receptionist Login";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/receptionist/request_maintenance.php'){  //request maintenance
                    echo "Request Maintenance";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/receptionist/edit_branch.php'){  //edit branch
                    echo "Edit Branch";
                }
            ?>
        </div>
        <div style="align-items:center;">
            <?php    
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //receptionist logged in     
                echo "Branch: ".$_SESSION['branchName'];
            ?>
        </div>
        <div style="align-items:flex-end;">
            <?php
                if($_SERVER['REQUEST_URI'] === '/public/receptionist/receptionist_dashboard.php'){  //Check whether the receptionist is in the dashboard
            ?>
                    <button style="float:right" class ="btn" id="logout" onclick="window.location.href=''"><img src="/styles/icons/bell_icon.svg" class="acc-img"></button>
                    <button style="float:right" class ="btn" id="logout" onclick="window.location.href='/controller/general/logout.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>        
            <?php 
                } else { 
            ?>
                    <button style="float:right" class ="btn" id="logout" onclick="window.location.href=''"><img src="/styles/icons/bell_icon.svg" class="acc-img"></button>
                    <button style="float:right" class ="btn" id="logout" onclick="window.location.href='/public/receptionist/receptionist_dashboard.php'">Dashboard<img src="/styles/icons/dashboard_icon.svg" class="dash-img"></button>
                    <button style="float:right" class ="btn" id="logout" onclick="window.location.href='/controller/general/logout.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>        
            <?php
                }
            }
            ?>
        </div>    
    </div>
</header>
