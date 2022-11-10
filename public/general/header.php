<header>
    <div class='header-top'>
        <div> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/index.php'){    //home page
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
                else if($_SERVER['REQUEST_URI'] === '/public/general/search_results.php'){  //search sport
                    echo "Search a Sport";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/reservation_schedule.php'){  //Reservation Schedule
                    echo "Reservation Schedule";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/user/reservation_history.php'){  //reservation history
                    echo "Reservation History";
                }
            ?>
        </div>
        <div> <!--- sports complex name -->
           Example Sports Complex
        </div>
        <div>
        <?php
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //user logged in
        ?>  
            <div style="float:right" id="accountIcons">
                <?php if(isset($_SESSION['userProfilePic'])){?>
                    
                    <button class ="btn" id='profileBtn'><img src="/public/user/profile_images/<?php echo $_SESSION['userProfilePic']?>" class="acc-img"></button>
                <?php
                }
                else{
                ?>
                    <button class ="btn" id='profileBtn'><img src="/styles/icons/profile_icon.svg" class="acc-img"></button>
                <?php
                }
                ?>
                <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>
            </div>
        <?php
            }
            else{
        ?>
            <div style="float:right" id="userOptions">
                <button class="btn" id ="register" onclick="window.location.href='/public/general/register.php'">Register<img src="/styles/icons/register_icon.svg" class="acc-img"></button>
                <button class="btn" id="login" onclick="window.location.href='/public/general/login.php'">Log in<img src="/styles/icons/login_icon.svg" class="acc-img"></button>
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
            <a href="/index.php">Ongoing Sessions</a>
            <a href="/index.php">Left Sessions</a>
            <a href="/controller/user/reservation_history_controller.php">Reservation History</a>
            <a href="/index.php">Edit Profile</a>
        </div>
    </nav>
</header>
