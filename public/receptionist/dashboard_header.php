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
                else if($_SERVER['REQUEST_URI'] === '/public/receptionist/view_user_profiles.php'){  //edit branch
                    echo "View User Profiles";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/receptionist/user_profile.php'){  //edit branch
                    echo "User Profile";
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
                <div style="float:right" >
                    <button class ="btn" id="logout" onclick="window.location.href=''"><img src="/styles/icons/bell_icon.svg" class="acc-img"></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>        
                </div>
                    
            <?php 
                } else { 
            ?>
                <div style="float:right" >
                    <button class ="btn" id="logout" onclick="window.location.href=''"><img src="/styles/icons/bell_icon.svg" class="acc-img"></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/public/receptionist/receptionist_dashboard.php'"><img src="/styles/icons/dashboard_icon.svg" class="dash-img"></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>        
                </div>
                    
            <?php
                }
            }
            ?>
        </div>    
    </div>
</header>
