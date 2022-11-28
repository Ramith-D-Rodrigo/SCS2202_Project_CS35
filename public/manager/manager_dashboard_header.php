<?php
    session_start();
?>
<header>
    <div class='header-top'>
        <div>
            Welcome,___ Branch:___
        </div>
        <div>
        <?php
            if(isset($_SESSION['userid']) && isset($_SESSION['userrole'])){ //user logged in
        ?>  <button class ="btn" onclick="window.location.href='/controller/general/logout.php'" style="float:right">LOG OUT</button>
        <?php
            }
            else{
        ?>
           
            <button class="btn" onclick="window.location.href='/public/general/login.php'">LOG IN</button>
        <?php
            }
        ?>
        </div>
    </div>
</header>