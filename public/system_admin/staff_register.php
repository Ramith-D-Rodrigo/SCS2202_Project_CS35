<?php
    session_start();
    if(!(isset($_SESSION['userid']) && isset($_SESSION['userrole']))) {
        header("Location: /public/system_admin/admin_login.php");
        exit();
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
    <form  action="/controller/system_admin/register_controller.php" method="post">
        <div class="row-container">
            <div class="left-side"> Staff Role : </div>
            <div class="right-side"> <select id="roles" name="staffRole">
                <option value="receptionist">Receptionist</option>
                <option value="manager">Manager</option>
            </select> 
            </div>
        </div>
        <div class="row-container">
            <div class="left-side"> Registering Branch :  </div>
            <div class="right-side"> <select name="branchName" id="branchName">
            </select>
            </div>
        </div>     
        <div class="row-container">
            <div class="left-side"> Name : </div>
            <div class="right-side" style="display:flex;flex-direction:column">
            <div > <input type="text" 
            pattern="[a-zA-Z]+" 
            name="firstName"
            id="firstName" 
            required placeholder="First Name"
            value=<?php if(isset($_SESSION['firstName'])) echo htmlspecialchars($_SESSION['firstName'], ENT_QUOTES)?>> </div>
            
            <div>
            <input type="text" 
            pattern="[a-zA-Z]+" 
            name="lastName"
            id="lastName" 
            required 
            placeholder="Last Name"
            value=<?php if(isset($_SESSION['lastName'])) echo htmlspecialchars($_SESSION['lastName'], ENT_QUOTES)?>> </div>
            </div>
        </div>
        <div class="row-container">
            <div class="left-side"> Date of Birth : </div>
            <div class="right-side"> <input type="date"
            id ="bday" 
            name="birthday" 
            required
            value=<?php if(isset($_SESSION['birthday'])) echo htmlspecialchars($_SESSION['birthday'], ENT_QUOTES)?>>  </div>
        </div>

        <div class="row-container">
            <div class="left-side"> Contact Number : </div>
            <div class="right-side"> <input type="text"
            pattern="[0-9]{10,11}" 
            name="contactNum"
            id="staffcontact"
            required
            value=<?php if(isset($_SESSION['contactNum'])) echo htmlspecialchars($_SESSION['contactNum'], ENT_QUOTES)?>>  </div>
        </div>
        
        <div class="row-container">
            <div class="left-side"> Email Address : </div>
            <!-- pattern indicates that it must follow somename@topleveldomain.domain-->
            <div class="right-side"> <input 
            type="email" 
            name="emailAddress"
            id="emailAddress"
            required
            value=<?php if(isset($_SESSION['emailAddress'])) echo htmlspecialchars($_SESSION['emailAddress'], ENT_QUOTES)?>> </div>
        </div>

        <div class="row-container">
            <div class="left-side"> Gender : </div>
            <div class="right-side" style="display:flex;flex-direction:row;margin-top:2px">
            <div> <input type="radio" name="gender" value="m" required <?php if(isset($_SESSION['gender'])){if($_SESSION['gender'] === 'm') echo 'checked';}?>> Male </div>
            <div> <input type="radio" name="gender" value="f"<?php if(isset($_SESSION['gender'])){if($_SESSION['gender'] === 'f') echo 'checked';}?>> Female </div> 
            </div>
        </div>

        <div class="row-container">
            <div class="left-side"> Username :  </div>
            <div class="right-side"> <input 
            type="text" 
            required 
            minlength="6" 
            maxlength="15"
            pattern="^[a-z]([a-z0-9_]){5,15}"
            name="username"
            id="username"
            title="Minimum length of 6 and Maximum of 15. Must start with a letter and all letters should be lowercase. Only letters, numbers and '_' allowed"
            > </div>
        </div>
        <div class="row-container">
            <div class="left-side"> Password : </div>
            <div class="right-side"> <input 
            type="password"  
            pattern="(?=.*\d)(?=.*[A-Z]).{8,}" 
            minlength="8"
            id="password"
            name="password"
            required title="Password length must be atleast 8 characters. Must include an uppercase letter and a number"> 
            <button class="togglePassword"> Show Password</button> </div> 
        </div>
        <div class="row-container">
            <div class="left-side"> Confirm Password : </div>
            <div class="right-side"> <input type="password" id="cPassword" required>  <button class="togglePassword"> Show Password</button> </div> <br> 
        </div>
        <div  id="errmsg" class="err-msg">
            <?php
                if(isset($_SESSION['numberError'])){
                    echo($_SESSION['numberError']);
                    echo '<br>';
                    unset($_SESSION['numberError']);
                }
                if(isset($_SESSION['emailError'])){
                    echo $_SESSION['emailError'];
                    echo '<br>';
                    unset($_SESSION['emailError']);
                }
                if(isset($_SESSION['usernameError'])){
                    echo $_SESSION['usernameError'];
                    echo '<br>';
                    unset($_SESSION['usernameError']);
                }
                if(isset($_SESSION['staffError'])){
                    echo $_SESSION['staffError'];
                    echo '<br>';
                    unset($_SESSION['staffError']);
                }
                ?>
                
            <div id="successmsg" class="success-msg">
                <?php
                    if(isset($_SESSION['RegsuccessMsg'])){
                        echo $_SESSION['RegsuccessMsg'];
                        echo '<br>';
                        unset($_SESSION['RegsuccessMsg']);
                    }
                ?>
                </div>
            </div>

            <button type="submit" id="register"  name= "regSubmitBtn" value="submit" onclick="return validateForm(event)"> Register Staff</button>
        </form>
    </div>
    </main>

    <?php
        require_once("../general/footer.php");
    ?>

    </body>
    <script src="/js/system_admin/get_all_branches.js"></script>
    <script src="/js/system_admin/staff_register_form_handle.js"></script>
    <script src="/js/system_admin/staff_register_validation.js"></script>
</html>
