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
                else if($_SERVER['REQUEST_URI'] === 'public/general/our_feedback.php'){ //user register
                    echo "Our Feedback";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/reg_caoches.php'){ //user register
                    echo "Registered Coaches";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/about_us.php'){ //user register
                    echo "About Us";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/general/search_results.php'){  //search sport
                    echo "Search a Sport";
                }
            ?>
        </div>
        <div> <!--- sports complex name -->
           Example Sports Complex
        </div>
        <div>
        <?php
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //user logged in
        ?>  <button class ="btn" onclick="window.location.href='/controller/general/logout.php'" style="float:right">LOG OUT</button>
        <?php
            }
            else{
        ?>
            <button class="btn" onclick="window.location.href='/public/general/register.php'">REGISTER</button>
            <button class="btn" onclick="window.location.href='/public/general/login.php'">LOG IN</button>
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
    </nav>
</header>
