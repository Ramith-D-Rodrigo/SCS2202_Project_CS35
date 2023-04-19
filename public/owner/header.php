<header>
    <div class='header-top'>
        <div> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/public/owner/owner_dashboard.php'){
                    echo "Welcome, ".$_SESSION['username'];
                }
                if(str_contains($_SERVER['REQUEST_URI'],'/public/owner/branch_details.php')){
                    echo "Branch Details";
                }
                if(str_contains($_SERVER['REQUEST_URI'],'/public/owner/sports.php')){
                    echo "Sports";
                }
                if(str_contains($_SERVER['REQUEST_URI'],'/public/owner/add_new_branch.php')){
                    echo "Request to Add a New Branch";
                }
                if(str_contains($_SERVER['REQUEST_URI'],'/public/owner/add_new_sport.php')){
                    echo "Add a New Sport";
                }
                if(str_contains($_SERVER['REQUEST_URI'],'/public/owner/view_manager_requests.php')){
                    echo "View Manager Requests";
                }
            ?>
        </div>
        <div>
            <div style="float:right" id="accountIcons">
            <input type="checkbox" class="dropdown-check" id="notificationCheck">
                <div class='notification-container'>
                    <label for="notificationCheck">
                        <i class="fa-solid fa-bell btn bell"></i>
                        <i class="fa-solid fa-plus notification-count" id="notificationCount"></i>
                    </label>
                    <ul class="dropdown">
                    </ul>
                </div>
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
