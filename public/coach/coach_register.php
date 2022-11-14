<?php
    // session_start();
    // if((isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is logged in
    //     header("Location: /index.php"); //the user shouldn't be able to access the register page
    //     exit();
    // }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../styles/coach//coach_register.css">
        <!-- <link rel="stylesheet" href="/styles/general/styles.css"> -->
        <!-- <link rel="stylesheet" href="/styles/user/user_register.css"> -->
        <title>coach Registration</title>
    </head>
    <body>
    <?php
        // require_once("../general/header.php");
        require_once("../general/header.php");

    ?>
        <main>
            <div class='body-container'>
                <div class="content-box">
                    <form action="/controller/user/register_controller.php" method="post" enctype="multipart/form-data">
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
                        id="usercontact"
                        required
                        value=<?php if(isset($_SESSION['contactNum'])) echo htmlspecialchars($_SESSION['contactNum'], ENT_QUOTES)?>> 
                        <br>
                        <div style="display:flex; flex-direction: row">
                            Home Address : 
                            <textarea 
                            name="homeAddress"
                            id="homeAddress" 
                            required
                            ><?php if(isset($_SESSION['homeAddress'])) echo htmlspecialchars($_SESSION['homeAddress'], ENT_QUOTES)?></textarea>
                        </div>

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
                                <input type="radio" name="gender" value="m" required <?php if(isset($_SESSION['gender'])){if($_SESSION['gender'] === 'm') echo 'checked';}?>> Male
                                <input type="radio" name="gender" value="f"<?php if(isset($_SESSION['gender'])){if($_SESSION['gender'] === 'f') echo 'checked';}?>> Female <br>
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
                        <div id="medCon">
                            Medical Concerns : (Maximum of 5 | Please Add one Concern per Field)<br>
                            <button id="medConbtn"> Add </button>
                        </div>
                        Upload a Profile Picture
                        <input type=file name="user_pic" accept=".jpg, .jpeg, .png" id="user_profile_pic" title="Maximum File Size 2MB. Only Accepts JPG, PNG">

                        <div id="emergencyDetails">
                            Emergency Contact Details: <br>
                            Name: <input type="text" name="name1" required value=<?php if(isset($_SESSION['name1'])) echo htmlspecialchars($_SESSION['name1'], ENT_QUOTES) ?>> <br>
                            Relationship: 
                            <select required name="relationship1">
                                <option value="">Choose One</option>
                                <option value="Mother" <?php if(isset($_SESSION['relationship1'])){
                                        if($_SESSION['relationship1'] === "Mother"){
                                            echo 'selected';
                                        }
                                    }?>>Mother</option>
                                <option value="Father" <?php if(isset($_SESSION['relationship1'])){
                                        if($_SESSION['relationship1'] === "Father"){
                                            echo 'selected';
                                        }
                                    }?>>Father</option>
                                <option value="Sibling 1" <?php if(isset($_SESSION['relationship1'])){
                                        if($_SESSION['relationship1'] === "Sibling 1"){
                                            echo 'selected';
                                        }
                                    }?>>Sibling 1</option>
                                <option value="Sibling 2" <?php if(isset($_SESSION['relationship1'])){
                                        if($_SESSION['relationship1'] === "Sibling 2"){
                                            echo 'selected';
                                        }
                                    }?>>Sibling 2</option>
                                <option value="Friend 1" <?php if(isset($_SESSION['relationship1'])){
                                        if($_SESSION['relationship1'] === "Friend 1"){
                                            echo 'selected';
                                        }
                                    }?>>Friend 1</option>
                                <option value="Friend 2" <?php if(isset($_SESSION['relationship1'])){
                                        if($_SESSION['relationship1'] === "Friend 2"){
                                            echo 'selected';
                                        }
                                    }?>>Friend 2</option>
                                <option value="Partner" <?php if(isset($_SESSION['relationship1'])){
                                        if($_SESSION['relationship1'] === "Partner"){
                                            echo 'selected';
                                        }
                                    }?>>Partner</option>
                            </select>
                            <br>
                            Contact Number: <input type="text" min="0" name="emgcontactNum1" required pattern="[0-9]{10,11}" value=<?php if(isset($_SESSION['emgcontactNum1'])) echo htmlspecialchars($_SESSION['emgcontactNum1'], ENT_QUOTES) ?>> <br>
                            Want to Add More? (Maximum of 3)
                            <br>
                            <button id="emergencyDetailsbtn">Add More</button>
                        </div>
                        <div id="errmsg" class="err-msg"><?php
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
                                if(isset($_SESSION['RegUnsuccessMsg'])){
                                    echo $_SESSION['RegUnsuccessMsg'];
                                    echo '<br>';
                                    unset($_SESSION['RegUnsuccessMsg']);
                                }
                                else{
                                    echo '';
                                }
                            ?></div>
                        <div id="successmsg" class="success-msg"><?php
                                if(isset($_SESSION['RegsuccessMsg'])){
                                    echo $_SESSION['RegsuccessMsg'];
                                    echo '<br>';
                                    unset($_SESSION['RegsuccessMsg']);
                                }
                            ?></div>
                        <div class="btn-container">
                            <button type="submit" id="register"  name= "regSubmitBtn" value="submit" onclick="return validateForm(event)"> Register </button>
                        </div>
                    </form>                    
                </div>
            </div>
        </main>

    <?php
        require_once("../general/footer.php");
    ?>

    </body>
    <script src="/js/user/user_register_form_handle.js"></script>
    <script src="/js/user/user_register_validation.js"></script>
</html>
