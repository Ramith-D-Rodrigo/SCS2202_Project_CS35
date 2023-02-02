<header>
    <div class='header-top'>
        <div> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/index.php'){    //home page
                    echo "Welcome";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/login.php' || $_SERVER['REQUEST_URI'] === '/public/coach/coach_login.php'){    //login
                    echo "Log In";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/register.php'){   //register
                    echo "Register";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/coach/coach_register.php'){ //coach register
                    echo "Coach Registration";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/our_branches.php'){ //our_branches
                    echo "Our Branches";
                }
                else if($_SERVER['REQUEST_URI'] === 'public/general/our_feedback.php'){ //our_feedback
                    echo "Our Feedback";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/reg_caoches.php'){ //registered_caoches
                    echo "Registered Coaches";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/about_us.php'){ //about_us
                    echo "About Us";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/search_results.php'){  //search sport
                    echo "Search a Sport";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/coach/coach_dashboard.php'){
                    echo "Welcome, ".$_SESSION['username'];
                }
                
            ?>
        </div>
        <div>
        <?php
            if(isset($_SESSION['username']) && isset($_SESSION['userrole'])){ //coach logged in
        ?>     
            <div style="float:right" id="logout">
                <button class ="btn" onclick="window.location.href='/public/coach/coach_dashboard.php'"><img src="/styles/icons/search_icon.svg" class="acc-img"></button>

                <button class ="btn"><img src="/styles/icons/profile_icon.svg" class="acc-img"></button>
                <button class ="btn" onclick="window.location.href='/controller/general/logout.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>
            </div>
        <?php
            }
            else{
        ?>
            <div style="float:right" id="login">
                
                <button class="btn" onclick="window.location.href='/public/general/login.php'">Register</button>
                <button class="btn" onclick="window.location.href='/public/general/login.php'">Login</button>
            </div>
        <?php
            }
        ?>
        </div>
    </div>

    <nav class="header-links">
        <a href="/public/general/our_sports.php">Our Sports</a>
        <a href="/public/general/our_branches.php">Our Branches</a>
        <a href="/public/general/reg_coaches.php">Registered Coaches</a>
        <a href="/public/general/our_feedback.php">Our Feedback</a>
        <a href="/public/general/about_us.php">About Us</a>
    </nav>
</header>
