<header>
    <div class='header-top'>
        <div> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/public/manager/Manager_Dashboard.php'){  //manager dashboard
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
                else if($_SERVER['REQUEST_URI'] === '/public/manager/manager_handle_receptionist_request.php'){  //Handle Receptionist Request
                    echo "Handle Receptionist Request";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/registered_coaches.php'){  //registered coaches
                    echo "Registered Coaches";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/revenue.php'){  //revenue
                    echo "Revenue";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/user_feedback.php'){  //user feedback
                    echo "User Feedback";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/user_profile.php'){  //user profile
                    echo "User Profile";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/manager/user_profiles.php'){  //user profiles
                    echo "User Profiles";
                }
            ?>
        </div>
        <div style="align-items:center;">
            <?php    
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //manager logged in     
                echo "Branch: ".$_SESSION['city'];
            ?>
        </div>
        <?php
                if($_SERVER['REQUEST_URI'] === '/public/manager/manager_dashboard.php'){  //Check whether the manager is in the dashboard
            ?>
                <div style="float:right;" >
                    <button class ="btn" id="" onclick="window.location.href=''"><i class="fa-solid fa-bell"></i></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<i class="fa-solid fa-right-from-bracket" style="margin: 0 10px"></i></button>        
                </div>
                    
            <?php 
                } else { 
            ?>
                <div style="float:right;" >
                    <button class ="btn" id="" onclick="window.location.href=''"><i class="fa-solid fa-bell"></i></button>
                    <button class ="btn" id="" onclick="window.location.href='/public/manager/manager_dashboard.php'"><i class="fa-solid fa-house"></i></button>
                    <button class ="btn" id="" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<i class="fa-solid fa-right-from-bracket" style="margin: 0 10px"></i></button>        
                </div>
                    
            <?php
                }
            }
            ?>
        </div>    
    </div>
</header>
