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
            First Name : <input type="text"> <br>
            Last Name : <input type="text"> <br>
            Date of Birth : <input type="date" id ="bday"> <br>
            Contact Number : <input type="number" min="0"> <br>
            Home Address : <textarea> </textarea><br>
            Height : <input type="number" placeholder="Optional (centimeters)" min="0"> <br>
            Weight : <input type="number" placeholder="Optional (kilograms)" min="0"> <br>
            Gender : 
                <input type="radio" name="gender" value="m"> Male
                <input type="radio" name="gender" value="f"> Female <br>
            Email Address : <input type="email"> <br>
            Username : <input type="text"> <br>
            <div>
                Password : <input type="password"> <button class="togglePassword"> Show Password</button> Password length must be greater than 8 characters. Must include a capital letter, number<br>
            </div>
            <div>
                Confirm Password : <input type="password"> <button class="togglePassword"> Show Password</button> <br>
            </div>
            <div id="medCon">
                Medical Concerns : (Maximum of 5)<br>
                <button id="medConbtn"> Add </button>
            </div>
            <div id="emergencyDetails">
                Emergency Contact Details: <br>
                Name: <input type="text"> <br>
                Relationship: <input type="text"> <br>
                Contact Number: <input type="number" min="0"> <br>
                Want to Add More? (Maximum of 3)
                <br>
                <button id="emergencyDetailsbtn">Add More</button>
            </div>

            <button type="submit" id="register"> Register </button>
        </form>
    </div>


    <?php
        require_once("../general/footer.php");
    ?>

    </body>
    <script src="/js/user/user_register.js"></script>
</html>
