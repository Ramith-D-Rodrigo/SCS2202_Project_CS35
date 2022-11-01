<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Registration</title>
    </head>
    <body>
    <?php
        require_once("../general/header.php");
    ?>

    <div>
        <form action="./register_controller.php" method="post">
            Name:
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
            id="usercontact"
            required
            value=<?php if(isset($_SESSION['contactNum'])) echo htmlspecialchars($_SESSION['contactNum'], ENT_QUOTES)?>> 
            <br>

            Home Address : 
            <textarea 
            name="homeAddress"
            id="homeAddress" 
            required
            ><?php if(isset($_SESSION['homeAddress'])) echo htmlspecialchars($_SESSION['homeAddress'], ENT_QUOTES)?></textarea>
            <br>

            Height : 
            <input 
            type="text" 
            placeholder="Optional (centimeters)" 
            min="0" 
            pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
            id="height"
            name="height"
            value=<?php if(isset($_SESSION['height'])) echo htmlspecialchars($_SESSION['height'], ENT_QUOTES)?>>

            Weight : 
            <input 
            type="text" 
            placeholder="Optional (kilograms)" 
            min="0"
            pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
            id="weight"
            name="weight"
            value=<?php if(isset($_SESSION['weight'])) echo htmlspecialchars($_SESSION['weight'], ENT_QUOTES)?>> 
            <br>
            
            <label for="gender">
                Gender : 
                    <input type="radio" name="gender" value="m" required <?php if($_SESSION['gender'] === 'm') echo 'checked'?>> Male
                    <input type="radio" name="gender" value="f"<?php if($_SESSION['gender'] === 'f') echo 'checked'?>> Female <br>
            </label>

            Email Address : 
            <!-- pattern indicates that it must follow somename@topleveldomain.domain-->
            <input 
            type="email" 
            name="emailAddress"
            id="emailAddress"
            required
            value=<?php if(isset($_SESSION['emailAddress'])) echo htmlspecialchars($_SESSION['emailAddress'], ENT_QUOTES)?>> 
            <br>

            Username : 
            <input 
            type="text" 
            required 
            minlength="6" 
            maxlength="15"
            pattern="^[a-z]([a-z0-9_]){5,14}[a-z]$"
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
            <div id="medCon">
                Medical Concerns : (Maximum of 5 | Please Add one Concern per Field)<br>
                <button id="medConbtn"> Add </button>
            </div>
            <div id="emergencyDetails">
                Emergency Contact Details: <br>
                Name: <input type="text" name="name1" required value=<?php if(isset($_SESSION['name1'])) echo htmlspecialchars($_SESSION['name1'], ENT_QUOTES) ?>> <br>
                Relationship: <input type="text" name="relationship1" required pattern="[a-zA-Z]{3,15}" value=<?php if(isset($_SESSION['relationship1'])) echo htmlspecialchars($_SESSION['relationship1'], ENT_QUOTES) ?>> <br>
                Contact Number: <input type="text" min="0" name="emgcontactNum1" required pattern="[0-9]{10,11}" value=<?php if(isset($_SESSION['emgcontactNum1'])) echo htmlspecialchars($_SESSION['emgcontactNum1'], ENT_QUOTES) ?>> <br>
                Want to Add More? (Maximum of 3)
                <br>
                <button id="emergencyDetailsbtn">Add More</button>
            </div>
            <div id="errmsg">
                <?php
                    if(isset($_SESSION['emailError'])){
                        echo $_SESSION['emailError'];
                    }
                    if(isset($_SESSION['usernameError'])){
                        echo $_SESSION['usernameError'];
                    }
                ?>
            </div>

            <button type="submit" id="register"  name= "regSubmitBtn" value="submit" onclick="return validateForm(event)"> Register </button>
        </form>
    </div>


    <?php
        require_once("../general/footer.php");
    ?>

    </body>
    <script src="/js/user/user_register_form_handle.js"></script>
    <script src="/js/user/user_register_validation.js"></script>
</html>
