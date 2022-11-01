<header>
    <div class='header-top'>
        <div> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/index.php'){    //home page
                    echo "Welcome";
                }
            ?>
        </div>
        <div> <!--- sports complex name -->
           Example Sports Complex
        </div>
        <div>
            <button class="btn">REGISTER</button>
            <button class="btn">LOG IN</button>
        </div>
    </div>

    <nav class="header-links">
        <a href="/index.php">Home</a>
        <a href="/src/general/our_sports.php">Our Sports</a>
        <a href="/src/general/our_branches.php">Our Branches</a>
        <a href="/src/general/reg_coaches.php">Registered Coaches</a>
        <a href="/src/general/our_feedback.php">Our Feedback</a>
        <a href="/src/general/about_us.php">About Us</a>

        <?php
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //user logged in
        ?>  <button onclick="window.location.href='/src/general/logout.php'">LOG OUT</button>
        <?php
            }
            else{
        ?>
            <a href="/src/general/login.php">Log in</a>
            <a href="/src/general/register.php">Register</a>
        <?php
            }
        ?>
    </nav>
</header>
