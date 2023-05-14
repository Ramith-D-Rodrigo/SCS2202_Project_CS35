<header>
    <div class='header-top'>
        <div style="display:flex;justify-content:flex-start"> <!-- For the current visiting page of the site -->
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
                else if($_SERVER['REQUEST_URI'] === '/public/system_admin/deactivate_account.php'){  //deactivate staff accounts
                    echo "Deactivate Staff Accounts";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/system_admin/view_owner_requests.php'){  //to view owner requests
                    echo "Owner Requests";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/system_admin/add_system_maintenance.php'){  //add system maintenance
                    echo "Add System Maintenance";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/system_admin/branch_request.php?'){  //to view particular branch request
                    echo "Branch Request";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/system_admin/account_settings.php'){  //to view particular branch request
                    echo "Account Settings";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/system_admin/remove_system_maintenance.php'){  //to view particular branch request
                    echo "View System Maintenance";
                }
            ?>
        </div>
        <div style="display:flex;justify-content:flex-end">
            <?php
            
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){    //admin logged in     
              
                if($_SERVER['REQUEST_URI'] === '/public/system_admin/admin_dashboard.php'){    //Check whether the admin is in the dashboard
            ?>
                <div style="float:right">
                    <input type="checkbox" class="dropdown-check" id="notificationCheck">
                    <div class='notification-container'>
                        <label for="notificationCheck">
                            <i class="fa-solid fa-bell btn bell"></i>
                            <i class="notification-count" id="notificationCount"></i>
                        </label>
                        <ul class="dropdown">
                        </ul>
                    </div>
                    <button class ="btn" id="" onclick="window.location.href='/public/system_admin/account_settings.php'">Settings<i class="fa-solid fa-gear" style="margin: 0 5px"></i></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<i class="fa-solid fa-right-from-bracket" style="margin: 0 5px"></i></button>        
                </div>
                    
            <?php 
                } else { 
            ?>
                <div style="float:right">
                <input type="checkbox" class="dropdown-check" id="notificationCheck">
                    <div class='notification-container'>
                        <label for="notificationCheck">
                            <i class="fa-solid fa-bell btn bell"></i>
                            <i class="notification-count" id="notificationCount"></i>
                        </label>
                        <ul class="dropdown">
                        </ul>
                    </div>
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
