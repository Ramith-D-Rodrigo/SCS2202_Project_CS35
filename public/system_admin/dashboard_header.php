<header>
    <div class='header-top'>
        <div style="align-items:flex-start"> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/public/system_admin/admin_dashboard.php'){  //admin dashboard
                    echo "Welcome, ".$_SESSION['username'];
                }
                else if($_SERVER['REQUEST_URI'] === '/public/system_admin/admin_login.php'){  //admin login
                    echo "Admin Login";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/system_admin/staff_register.php'){  //staff register
                    echo "Staff Register";
                }
            ?>
        </div>
        <div style="align-items:flex-end">
            <?php
            
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){    //admin logged in     
              
                if($_SERVER['REQUEST_URI'] === '/public/system_admin/admin_dashboard.php'){    //Check whether the admin is in the dashboard
            ?>
                <div style="float:right">
                    <button class ="btn" id="logout" onclick="window.location.href=''"><img src="/styles/icons/bell_icon.svg" class="acc-img"></button>
                    <button class ="btn" id="logout" onclick="window.location.href=''">Settings<img src="/styles/icons/settings_icon.svg" class="acc-img"></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>        
                </div>
                    
            <?php 
                } else { 
            ?>
                <div style="float:right">
                    <button class ="btn" id="logout" onclick="window.location.href=''"><img src="/styles/icons/bell_icon.svg" class="acc-img"></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/public/system_admin/admin_dashboard.php'"><img src="/styles/icons/dashboard_icon.svg" class="dash-img"></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>        
                </div>
                    
            <?php
                }
            }
            ?>
        </div>    
    </div>
</header>
