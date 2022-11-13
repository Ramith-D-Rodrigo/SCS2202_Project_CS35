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
        <div > <!--- sports complex name -->
           Welcome_______
        </div>
        <div>
        <?php
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //user logged in
        ?>  
            <div style="float:right" id="logout">
                <button class ="btn" onclick="window.location.href='/controller/general/logout.php'"><img src="/styles/icons/profile_icon.svg" class="acc-img"></button>
                <button class ="btn" onclick="window.location.href='/controller/general/logout.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>
            </div>
        <?php
            }
            else{
        ?>
            <div style="float:right" id="login">
                <button class="btn" onclick="window.location.href='/public/general/register.php'">Notification</button>
                <button class="btn" onclick="window.location.href='/public/general/login.php'">Logout</button>
            </div>
        <?php
            }
        ?>
        </div>
    </div>

</header>
