<header>
    <div class='header-top'>
        <div class="header-top-left"> <!-- For the current visiting page of the site -->
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
        <div class="header-top-middle"> <!--- sports complex name -->
           Example Sports Complex
        </div>
        <div class="header-top-right">
        <?php
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //user logged in
        ?>  
            <div id="accountIcons" class="header-right">
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
            <div style="float:right" id="userOptions" class="header-right">
                <button class="btn" id ="register" onclick="window.location.href='/public/general/register.php'">Register<i class="fa-solid fa-user-plus" style="margin: 0 10px"></i></button>
                <button class="btn" id="login" onclick="window.location.href='/public/general/login.php'">Log in<i class="fa-solid fa-right-to-bracket" style="margin: 0 10px"></i></button>
            </div>
        <?php
            }
        ?>
            <div>
                <input type="checkbox" class="nav-checkbox" id="navCheckbox">
                <label for="navCheckbox" class="nav-check-btn">
                    <i class="fa-solid fa-bars"></i>
                </label>
            </div>
        </div>
    </div>

    <nav class="header-links">
        <ul>
            <li>
                <a href="/index.php">Home</a>
            </li>
            <li>
                <a href="/public/general/our_sports.php">Our Sports</a>
            </li>
            <li>
                <a href="/public/general/our_branches.php">Our Branches</a>
            </li>
            <li>
                <a href="/public/general/reg_coaches.php">Registered Coaches</a>
            </li>
            <li>
                <a href="/public/general/our_feedback.php">Our Feedback</a>
            </li>
            <li>
                <a href="/public/general/about_us.php">About Us</a>
            </li>
            <?php
                if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //user logged in
            ?>
                 <li class="profile-links">
                    <a href="/public/user/edit_profile.php">Edit Profile</a>
                </li>
                <li class="profile-links">
                    <a href="/public/user/coaching_sessions.php">Coaching Sessions</a>
                </li>
                <li class="profile-links">
                    <a href="/public/user/reservation_history.php">Reservation History</a>
                </li>
                <li class="session-links-responsive">
                    <a href="/controller/general/logout_controller.php">Log out</a>
                </li>
            <?php
                }
                else{
            ?>
                <li class="session-links-responsive">
                    <a href="/public/general/register.php">Register</a>
                </li>
                <li class="session-links-responsive">
                    <a href="/public/general/login.php">Log in</a>
                </li>
            <?php
                }
            ?>
        </ul>
    </nav>
</header>
