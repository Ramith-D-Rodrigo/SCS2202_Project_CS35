<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <title>Register Staff</title>
    </head>
    <body>

    <div>
        <form action="/controller/system_admin/register_controller.php" method="post">

            <!-- Staff role and registering branch has to be displayed as dropdowns -->
            Branch Name : 
            <input type="text" 
            pattern="[a-zA-Z]+" 
            name="branchName"
            id="branchName" 
            required placeholder="Branch Name"
            value=<?php if(isset($_SESSION['branchName'])) echo htmlspecialchars($_SESSION['branchName'], ENT_QUOTES)?>>
            <br>
            Staff Role : 
            <input type="text" 
            pattern="[a-zA-Z]+" 
            name="staffRole"
            id="staffRole" 
            required placeholder="Staff Role"
            value=<?php if(isset($_SESSION['staffRole'])) echo htmlspecialchars($_SESSION['staffRole'], ENT_QUOTES)?>>
            <br>
            Name :
            <input type="text" 
            pattern="[a-zA-Z]+" 
            name="firstName"
            id="firstName" 
            required placeholder="First Name"
            value=<?php if(isset($_SESSION['firstName'])) echo htmlspecialchars($_SESSION['firstName'], ENT_QUOTES)?>>

            <input type="text" 
            pattern="[a-zA-Z]+" 
            name="lastName"
            id="lastName" 
            required 
            placeholder="Last Name"
            value=<?php if(isset($_SESSION['lastName'])) echo htmlspecialchars($_SESSION['lastName'], ENT_QUOTES)?>>
            <br>

            Date of Birth : 
            <input type="date"
            id ="bday" 
            name="birthday" 
            required
            value=<?php if(isset($_SESSION['birthday'])) echo htmlspecialchars($_SESSION['birthday'], ENT_QUOTES)?>> 
            <br>

            Contact Number : 
            <input type="text"
            pattern="[0-9]{10,11}" 
            name="contactNum"
            id="staffcontact"
            required
            value=<?php if(isset($_SESSION['contactNum'])) echo htmlspecialchars($_SESSION['contactNum'], ENT_QUOTES)?>> 
            <br>

            Email Address : 
            <!-- pattern indicates that it must follow somename@topleveldomain.domain-->
            <input type="email" 
            pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/."
            name="emailAddress"
            id="emailAddress"
            required
            value=<?php if(isset($_SESSION['emailAddress'])) echo htmlspecialchars($_SESSION['emailAddress'], ENT_QUOTES)?>> 
            <br>

            <label for="gender">
                Gender : 
                    <input type="radio" name="gender" value="m" required <?php if(isset($_SESSION['gender'])){if($_SESSION['gender'] === 'm') echo 'checked';}?>> Male
                    <input type="radio" name="gender" value="f"<?php if(isset($_SESSION['gender'])){if($_SESSION['gender'] === 'f') echo 'checked';}?>> Female <br>
            </label>

            Username : 
            <input 
            type="text" 
            required 
            minlength="6" 
            maxlength="15"
            pattern="^[a-z]([a-z0-9_]){5,15}"
            name="username"
            id="username"
            title="Minimum length of 6 and Maximum of 15. Must start with a letter and all letters should be lowercase. Only letters, numbers and '_' allowed"
            value=<?php if(isset($_SESSION['username'])) echo htmlspecialchars($_SESSION['username'], ENT_QUOTES)?>>
            <br>
            
            <div>
                Password : 
                <input 
                type="password"  
                pattern="(?=.*\d)(?=.*[A-Z]).{8,}" 
                minlength="8"
                id="password"
                name="password"
                required title="Password length must be atleast 8 characters. Must include an uppercase letter and a number"> 
                <button class="togglePassword"> Show Password</button><br>
            </div>
            <div>
                Confirm Password : <input type="password" required> <button class="togglePassword"> Show Password</button> <br>
            </div>
            <div id="errmsg">
                <?php
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
                    if(isset($_SESSION['RegsuccessMsg'])){
                        echo $_SESSION['RegsuccessMsg'];
                        echo '<br>';
                        unset($_SESSION['RegsuccessMsg']);
                    }
                ?>
            </div>

            <button type="submit" id="register"  name= "regSubmitBtn" value="submit" onclick="return validateForm(event)"> Register Staff</button>
        </form>
    </div>


    <?php
        require_once("../general/footer.php");
    ?>

    </body>
    <script src="/js/system_admin/staff_register_form_handle.js"></script>
    <script src="/js/system_admin/staff_register_validation.js"></script>
</html>