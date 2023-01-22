<header>
    <div class='header-top'>
        <div style="align-items:flex-start"> <!-- For the current visiting page of the site -->
            <?php
                if($_SERVER['REQUEST_URI'] === '/public/coach/coach_dashboard.php'){  //coach dashboard
                    echo "Dashboard";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/coach/coach_addsession.php'){  //coach add session
                    echo "Add New Session";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/coach/coach_session.php'){  //coaching sessions
                    echo "Coaching Sessions";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/coach/coach_feedback.php'){  //coach feedback
                    echo "Coach Feedback";
                }
                else if($_SERVER['REQUEST_URI'] === '/public/coach/viewing_session.php'){  //view session
                    echo "Viewing Session";
                }
            ?>
        </div>
        <div style="align-items:flex-end">
            <?php
            
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){    //coach logged in     
              
                if($_SERVER['REQUEST_URI'] === '/public/coach/coach_dashboard.php'){    //Check whether the coach is in the dashboard
            ?>
                <div style="float:right">
                    <button class ="btn" id="logout" onclick="window.location.href=''"><img src="/styles/icons/bell_icon.svg" class="acc-img"></button>
                    <button class ="btn" id="logout" onclick="window.location.href=''"><img src="/styles/icons/profile_icon.svg" class="acc-img"></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>        
                </div>
                    
            <?php 
                } else { 
            ?>
                <div style="float:right">
                    <button class ="btn" id="logout" onclick="window.location.href=''"><img src="/styles/icons/bell_icon.svg" class="acc-img"></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/public/coach/coach_dashboard.php'"><img src="/styles/icons/dashboard_icon.svg" class="dash-img"></button>
                    <button class ="btn" id="logout" onclick="window.location.href='/controller/general/logout.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>        
                </div>
                    
            <?php
                }
            }
            ?>
        </div>    
    </div>
</header>
