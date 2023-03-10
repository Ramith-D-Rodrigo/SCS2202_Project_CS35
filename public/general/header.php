<header>
    <div class='header-top'>
        <div> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/index.php' || $_SERVER['REQUEST_URI'] === '/'){    //home page
                    echo "Welcome";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/login.php' || $_SERVER['REQUEST_URI'] === '/public/user/user_login.php'){    //login
                    echo "Log In";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/register.php'){   //register
                    echo "Register";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/user/user_register.php'){ //user register
                    echo "User Registration";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/our_branches.php'){ //user register
                    echo "Our Branches";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/our_sports.php'){ //user register
                    echo "Our Sports";
                }
                else if($_SERVER['REQUEST_URI'] === 'public/general/our_feedback.php'){ //user register
                    echo "Our Feedback";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/reg_coaches.php'){ //user register
                    echo "Registered Coaches";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/about_us.php'){ //user register
                    echo "About Us";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/general/search_results.php')){  //search sport
                    echo "Search a Sport";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/general/reservation_schedule.php')){  //Reservation Schedule
                    echo "Reservation Schedule";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/user/reservation_history.php'){  //reservation history
                    echo "Reservation History";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/general/coach_profile.php')){  //coach profile
                    echo "Coach Profile";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/general/our_feedback.php')){  //feedback page
                    echo "Our Feedback";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/user/edit_profile.php')){  //edit profile
                    echo "Edit Profile";
                }
                else if(str_contains($_SERVER['REQUEST_URI'],'/public/user/coaching_sessions.php')){  //coaching sessions
                    echo "Coaching Sessions";
                }
            ?>
        </div>
        <div style="text-align:center"> <!--- sports complex name -->
           Example Sports Complex
        </div>
        <div>
        <?php
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //user logged in
        ?>  
            <div style="float:right" id="accountIcons">
                <input type="checkbox" class="dropdown-check" id="notificationCheck">
                <div class='notification-container'>
                    <label for="notificationCheck">
                        <i class="fa-solid fa-bell btn bell"></i>
                        <i class="notification-count" id="notificationCount"></i>
                    </label>
                    <ul class="dropdown">
                    </ul>
                </div>
                <?php if(isset($_SESSION['userProfilePic'])){?>
                    
                    <button class ="btn" id='profileBtn'><img src="<?php echo $_SESSION['userProfilePic']?>" class="acc-img" style="border: solid thin black"></button>
                <?php
                }
                else{
                ?>
                    <button class ="btn" id='profileBtn'><i class="fa-solid fa-circle-user"></i></button>
                <?php
                }
                ?>
                <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<i class="fa-solid fa-right-from-bracket" style="margin: 0 10px"></i></button>
            </div>
        <?php
            }
            else{
        ?>
            <div style="float:right" id="userOptions">
                <button class="btn" id ="register" onclick="window.location.href='/public/general/register.php'">Register<i class="fa-solid fa-user-plus" style="margin: 0 10px"></i></button>
                <button class="btn" id="login" onclick="window.location.href='/public/general/login.php'">Log in<i class="fa-solid fa-right-to-bracket" style="margin: 0 10px"></i></button>
            </div>
        <?php
            }
        ?>
        </div>
    </div>

    <nav class="header-links">
        <a href="/index.php">Home</a>
        <a href="/public/general/our_sports.php">Our Sports</a>
        <a href="/public/general/our_branches.php">Our Branches</a>
        <a href="/public/general/reg_coaches.php">Registered Coaches</a>
        <a href="/public/general/our_feedback.php">Our Feedback</a>
        <a href="/public/general/about_us.php">About Us</a>
        <div id="profile-links" style="float:right; margin-right:20px; display:none">
            <a href="/public/user/coaching_sessions.php">Coaching Sessions</a>
            <a href="/public/user/reservation_history.php">Reservation History</a>
            <a href="/public/user/edit_profile.php">Edit Profile</a>
        </div>
    </nav>
</header>
