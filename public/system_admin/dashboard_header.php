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
                else if($_SERVER['REQUEST_URI'] === '/public/system_admin/change_staff_logins.php'){  //change staff login details
                    echo "Change Login Details";
                }
            ?>
        </div>
        <div style="align-items:flex-end">
            <?php
            
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){    //admin logged in     
              
                if($_SERVER['REQUEST_URI'] === '/public/system_admin/admin_dashboard.php'){    //Check whether the admin is in the dashboard
            ?>
                <div style="float:right">
                    <button class ="btn" id="" onclick="window.location.href=''"><i class="fa-solid fa-bell"></i></button>
                    <button class ="btn" id="" onclick="window.location.href=''">Settings<i class="fa-solid fa-gear" style="margin: 0 5px"></i></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<i class="fa-solid fa-right-from-bracket" style="margin: 0 5px"></i></button>        
                </div>
                    
            <?php 
                } else { 
            ?>
                <div style="float:right">
                    <button class ="btn" id="" onclick="window.location.href=''"><i class="fa-solid fa-bell"></i></button>
                    <button class ="btn" id="" onclick="window.location.href='/public/system_admin/admin_dashboard.php'"><i class="fa-solid fa-house"></i></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<i class="fa-solid fa-right-from-bracket" style="margin: 0 10px"></i></button>        
                </div>
                    
            <?php
                }
            }
            ?>
        </div>    
    </div>
</header>
