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
            First Name : <input type="text" name="firstName" required> <br>
            Last Name : <input type="text" name="lastName" required> <br>
            Date of Birth : <input type="date" id ="bday" name="birthday" required> <br>
            Contact Number : <input type="number" min="0" name="contactNum" required> <br>
            Home Address : <textarea name="homeAddress" required> </textarea><br>
            Height : <input type="number" placeholder="Optional (centimeters)" min="0" name="height"> <br>
            Weight : <input type="number" placeholder="Optional (kilograms)" min="0" name="weight"> <br>
            Gender : 
                <input type="radio" name="gender" value="m"> Male
                <input type="radio" name="gender" value="f"> Female <br>
            Email Address : <input type="email" name="emailAddress" required> <br>
            Username : <input type="text" required minlength="6"> Minimum length of 6<br>
            <div>
                Password : <input type="password" minlength="8" required> <button class="togglePassword"> Show Password</button> Password length must be atleast 8 characters. Must include a capital letter, number<br>
            </div>
            <div>
                Confirm Password : <input type="password" required> <button class="togglePassword"> Show Password</button> <br>
            </div>
            <div id="medCon">
                Medical Concerns : (Maximum of 5)<br>
                <button id="medConbtn"> Add </button>
            </div>
            <div id="emergencyDetails">
                Emergency Contact Details: <br>
                Name: <input type="text" name="name" required> <br>
                Relationship: <input type="text" name="relationship" required> <br>
                Contact Number: <input type="number" min="0" name="contactNum" required> <br>
                Want to Add More? (Maximum of 3)
                <br>
                <button id="emergencyDetailsbtn">Add More</button>
            </div>

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
