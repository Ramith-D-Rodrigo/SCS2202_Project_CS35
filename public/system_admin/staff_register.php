<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['admin'])){
        Security::redirectUserBase();
        die();
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <link rel="stylesheet" href="/styles/general/staff.css">
        <link rel="stylesheet" href="/styles/system_admin/staff_register.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>Register Staff</title>
    </head>
    <body>
    <?php
        require_once("dashboard_header.php");
    ?>
    <main class="body-container">
    <div class="content-box">
    <form>
        <div class="row-container">
            <div class="left-field"> Staff Role : </div>
            <div class="right-field"> <select id="roles">
                <option value="receptionist">Receptionist</option>
                <option value="manager">Manager</option>
            </select> 
            </div>
        </div>
        <div class="row-container">
            <div class="left-field"> Registering Branch :  </div>
            <div class="right-field"> <select id="branchName">
            </select>
            </div>
        </div>     
        <div class="row-container">
            <div class="left-field"> Name : </div>
            <div class="right-field" style="display:flex;flex-direction:column">
            <input type="text" 
            pattern="[a-zA-Z]+" 
            id="firstName" 
            required placeholder="First Name"> 
            
            
            <input type="text" 
            pattern="[a-zA-Z]+" 
            id="lastName" 
            required 
            placeholder="Last Name"> </div>
            
        </div>
        <div class="row-container">
            <div class="left-field"> Date of Birth : </div>
            <div class="right-field"> <input type="date"
            id ="bday"  
            required>  </div>
        </div>

        <div class="row-container">
            <div class="left-field"> Contact Number : </div>
            <div class="right-field"> <input type="text"
            minlength="10"
            maxlength="10"
            pattern="[0-9]{10,11}"
            id="staffContact"
            required>  </div>
        </div>
        
        <div class="row-container">
            <div class="left-field"> Email Address : </div>
            <!-- pattern indicates that it must follow somename@topleveldomain.domain-->
            <div class="right-field"> <input 
            type="email" 
            id="emailAddress"
            required> </div>
        </div>

        <div class="row-container">
            <div class="left-field"> Gender : </div>
            <div class="right-field" style="display:flex;flex-direction:row;margin-top:2px">
                <div> <input type="radio" id="male" value="m"> Male </div>
                <div> <input type="radio" id="female" value="f"> Female </div> 
            </div>
        </div>

        <div class="row-container">
            <div class="left-field"> Username :  </div>
            <div class="right-field"> <input 
            type="text" 
            required 
            minlength="6" 
            maxlength="15"
            pattern="^[a-z]([a-z0-9_]){5,15}"
            id="username"
            title="Minimum length of 6 and Maximum of 15. Must start with a letter and all letters should be lowercase. Only letters, numbers and '_' allowed"
            > </div>
        </div>
        <div class="row-container">
            <div class="left-field"> Password : </div>
            <div class="right-field"> <input 
            type="password"  
            pattern="(?=.*\d)(?=.*[A-Z]).{8,}" 
            minlength="8"
            id="password"
            required title="Password length must be atleast 8 characters. Must include an uppercase letter and a number"> 
            </div>
            
        </div>
        <div style="display:flex;justify-content:flex-end">
            <button class="togglePassword"> Show Password</button>
        </div>
        
        <div class="row-container">
            <div class="left-field"> Confirm Password : </div>
            <div class="right-field"> <input type="password" id="cPassword" required>  
            </div> <br> 
        </div>
        <div style="display:flex;justify-content:flex-end">
            <button class="togglePassword"> Show Password</button>
        </div>
        <div id="errmsg">
        </div> 
            <div style="display:flex;justify-content:flex-end">
                <button id="register"  onclick="return validateForm(event)"> Register Staff</button>
            </div>
        </form>
    </div>
    <div id="overlay"></div>       
    <div id="successmsg"></div>
    </main>

    <?php
        require_once("../general/footer.php");
    ?>
    </body>
    <script src="/js/system_admin/get_all_branches.js"></script>
    <script src="/js/system_admin/staff_register_form_handle.js"></script>
    <script src="/js/system_admin/staff_register_validation.js"></script>
    <script type="module" src="/js/general/notifications.js"></script>
</html>
