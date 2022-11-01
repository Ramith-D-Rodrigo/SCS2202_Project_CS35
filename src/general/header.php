<div class='header'>
    <div class='header-title'>
        <div> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/index.php'){    //home page
                    echo "Welcome";
                }
            ?>
        </div>
        <div> <!--- sports complex name -->
            <t>Sports Complex</t>
        </div>
    </div>

    <div class="header-links">
        <a href="/index.php">Home</a>
        <a href="/src/general/our_sports.php">Our Sports</a>
        <a href="/src/general/our_branches.php">Our Branches</a>
        <a href="/src/general/reg_coaches.php">Registered Coaches</a>
        <a href="/src/general/our_feedback.php">Our Feedback</a>
        <a href="/src/general/about_us.php">About Us</a>
        <a href="/src/general/login.php">Log in</a>
        <a href="/src/general/register.php">Register</a>
    </div>
</div>
