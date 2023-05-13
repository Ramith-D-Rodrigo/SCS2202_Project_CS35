<header>
    <div class='header-top'>
        <div class="header-top-left"> <!-- For the current visiting page of the site -->
            <?php
                if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/receptionist_dashboard.php')){  //receptionist dashboard
                    echo "Welcome, ".$_SESSION['username'];
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/receptionist_login.php')){  //staff login
                    echo "Receptionist Login";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/request_maintenance.php')){  //request maintenance
                    echo "Request Maintenance";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/edit_branch.php')){  //edit branch
                    echo "Edit Branch";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/view_user_profiles.php')){  //view user profiles
                    echo "View User Profiles";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/user_profile.php')){  //view selected profile
                    echo "User Profile";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/view_coach_profiles.php')){  //view coach profiles
                    echo "View Coach Profiles";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/coach_profile.php')){  //view selected profile
                    echo "Coach Profile";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/view_reservations.php')){   //view today's reservations
                    echo "Reservations";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/onsite_reservation_entry.php')){   //select sport for onsite r.
                    echo "Select Sport";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/onsite_reservation.php')){   //make onsite reservation
                    echo "Make Onsite Reservation";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/reservation_payment.php')){   //payment receipt
                    echo "Reservation Payment";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/cancel_onsite_reservations.php')){   //cancel onsite reservations
                    echo "Cancel Onsite Reservations";
                }
            ?>
        </div>
        <div class="header-top-middle">
            <?php    
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //receptionist logged in     
                echo "Branch: ".$_SESSION['branchName'];
            ?>
        </div>
        <div class="header-top-right">
            <?php
                if(str_contains($_SERVER['REQUEST_URI'],'/public/receptionist/receptionist_dashboard.php')){  //Check whether the receptionist is in the dashboard
            ?>
                <div style="float:right" >
                    <button class ="btn" id="" onclick="window.location.href=''"><i class="fa-solid fa-bell"></i></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<i class="fa-solid fa-right-from-bracket" style="margin: 0 10px"></i></button>        
                </div>
                    
            <?php 
                } else { 
            ?>
                <div style="float:right" >
                    <button class ="btn" id="" onclick="window.location.href=''"><i class="fa-solid fa-bell"></i></button>
                    <button class ="btn" id="" onclick="window.location.href='/public/receptionist/receptionist_dashboard.php'"><i class="fa-solid fa-house"></i></button>
                    <button class ="btn" id="" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<i class="fa-solid fa-right-from-bracket" style="margin: 0 10px"></i></button>        
                </div>
                    
            <?php
                }
            }
            ?>
        </div>    
    </div>
</header>
