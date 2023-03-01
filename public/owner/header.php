<header>
    <div class='header-top'>
        <div> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/public/owner/owner_dashboard.php'){
                    echo "Welcome, ".$_SESSION['username'];
                }
            ?>
        </div>
        <div>
            <div style="float:right" id="logout">
            <?php
                if($_SERVER['REQUEST_URI'] !== '/public/owner/owner_dashboard.php'){
            ?>
                <button class ='btn' onclick="window.location.href='/public/owner/owner_dashboard.php'">Dashboard <i class="fa-solid fa-square"></i></button>
            <?php
                }
            ?>
                <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout_controller.php'">Log Out<i class="fa-solid fa-right-from-bracket" style="margin: 0 10px"></i></button>
            </div>
        </div>
    </div>

    
</header>
