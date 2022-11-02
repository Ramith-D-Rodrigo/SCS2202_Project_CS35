<header>
    <div class='header-top'>
        <div> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/index.php'){    //home page
                    echo "Welcome";
                }
                else if($_SERVER['REQUEST_URI'] === '/src/general/login.php' || $_SERVER['REQUEST_URI'] === '/src/user/user_login.php'){    //login
                    echo "Log In";
                }
                else if($_SERVER['REQUEST_URI'] === '/src/general/register.php'){   //register
                    echo "Register";
                }
                else if($_SERVER['REQUEST_URI'] === '/src/user/user_register.php'){ //user register
                    echo "User Registration";
                }
                else if($_SERVER['REQUEST_URI'] === '/src/general/our_branches.php'){ //user register
                    echo "Our Branches";
                }
                else if($_SERVER['REQUEST_URI'] === '/src/general/our_feedback.php'){ //user register
                    echo "Our Feedback";
                }
                else if($_SERVER['REQUEST_URI'] === '/src/general/reg_caoches.php'){ //user register
                    echo "Registered Coaches";
                }
                else if($_SERVER['REQUEST_URI'] === '/src/general/about_us.php'){ //user register
                    echo "About Us";
                }
            ?>
        </div>
        <div> <!--- sports complex name -->
           Example Sports Complex
        </div>
        <div>
        <?php
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //user logged in
        ?>  <button class ="btn" onclick="window.location.href='/src/general/logout.php'" style="float:right">LOG OUT</button>
        <?php
            }
            else{
        ?>
            <button class="btn" onclick="window.location.href='/src/general/register.php'">REGISTER</button>
            <button class="btn" onclick="window.location.href='/src/general/login.php'">LOG IN</button>
        <?php
            }
        ?>
        </div>
    </div>

    <nav class="header-links">
        <a href="/index.php">Home</a>
        <a href="/src/general/our_sports.php">Our Sports</a>
        <a href="/src/general/our_branches.php">Our Branches</a>
        <a href="/src/general/reg_coaches.php">Registered Coaches</a>
        <a href="/src/general/our_feedback.php">Our Feedback</a>
        <a href="/src/general/about_us.php">About Us</a>
    </nav>
</header>
