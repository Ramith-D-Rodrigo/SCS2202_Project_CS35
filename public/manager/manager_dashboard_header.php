
<header>
<div class='header-top'>
    <div>
        <?php
           
            if(isset($_SESSION['userid']) && isset($_SESSION['branchID'])){ //manager logged in       
                echo "Welcome, ".$_SESSION['username'];
        ?> 
    </div>
    <div>         
        <h4 style="float:center"><?php  echo "Branch : ".$_SESSION['city']; ?> </h4>
    </div>

    <div>
        <button style="float:right" class ="btn" id="logout" onclick="window.location.href='/controller/general/logout.php'">Log Out<img src="/styles/icons/logout_icon.svg" class="acc-img"></button>
        <?php
            }
            else{

        ?>
        <button style="float:right" class="btn" id="login" onclick="window.location.href='/public/general/login.php'">Log in<img src="/styles/icons/login_icon.svg" class="acc-img"></button>
        <?php
            }
        ?>
    </div>
         
</div>
</header>
