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
        <form action="" method="post">
            Name:
            <input type="text" 
            pattern="[a-zA-Z]+" 
            name="firstName"
            id="firstName" 
            required placeholder="First Name">

            <input type="text" 
            pattern="[a-zA-Z]+" 
            name="lastName"
            id="lastName" 
            required 
            placeholder="Last Name">
            <br>

            Date of Birth : 
            <input type="date"
            id ="bday" 
            name="birthday" 
            required> 
            <br>

            Contact Number : 
            <input type="text"
            pattern="[0-9]{10,11}" 
            name="contactNum"
            id="usercontact"
            required> 
            <br>

            Home Address : 
            <textarea 
            name="homeAddress" 
            required> 
            </textarea>
            <br>

            Height : 
            <input 
            type="text" 
            placeholder="Optional (centimeters)" 
            min="0" 
            pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
            name="height">

            Weight : 
            <input 
            type="text" 
            placeholder="Optional (kilograms)" 
            min="0"
            pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
            name="weight"> 
            <br>
            
            <label for="gender">
                Gender : 
                    <input type="radio" name="gender" value="m"> Male
                    <input type="radio" name="gender" value="f"> Female <br>
            </label>

            Email Address : 
            <!-- pattern indicates that it must follow somename@topleveldomain.domain-->
            <input 
            type="email" 
            name="emailAddress"
            pattern="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/"
            required> 
            <br>

            Username : 
            <input 
            type="text" 
            required 
            minlength="6" 
            maxlength="15"
            pattern="^[a-z]([a-z0-9_]){5,14}[a-z]$"
            title="Minimum length of 6 and Maximum of 15. Must start with a letter and all letters should be lowercase. Only letters, numbers and '_' allowed">
            <br>
            
            <div>
                Password : 
                <input 
                type="password"  
                pattern="(?=.*\d)(?=.*[A-Z]).{8,}" 
                minlength="8" 
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
                Name: <input type="text" name="name" required> <br>
                Relationship: <input type="text" name="relationship" required pattern="[a-zA-Z]{3,15}"> <br>
                Contact Number: <input type="text" min="0" name="contactNum" required pattern="[0-9]{10,11}"> <br>
                Want to Add More? (Maximum of 3)
                <br>
                <button id="emergencyDetailsbtn">Add More</button>
            </div>
            <div id="errmsg"></div>

            <button type="submit" id="register" onclick="return validateForm(event)"> Register </button>
        </form>
    </div>


    <?php
        require_once("../general/footer.php");
    ?>

    </body>
    <script src="/js/user/user_register_form_handle.js"></script>
    <script src="/js/user/user_register_validation.js"></script>
</html>
