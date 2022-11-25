<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Profile</title>
        <link rel="stylesheet" href="/styles/general/styles.css">
        <link rel="stylesheet" href="/styles/user/edit_profile.css">
    </head>
    <body>
        <?php   require_once("../../public/general/header.php"); ?>

        <main>
            <div class="body-container">
                <div class="content-box">

                    <div>
                        <div id="profilePicField" style="display:flex; justify-content:center; margin: 10px 0"></div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Name
                        </div>
                        <div class="right-field" id="nameField">
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Date of Birth
                        </div>
                        <div class="right-field" id="birthdayField">
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Contact Number
                        </div>
                        <input class="right-field" type="text" name="contactNum"
                                pattern="[0-9]{10,11}" 
                                id="usercontact"
                                required>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Home Address
                        </div>
                        <textarea class="right-field" name="homeAddress" id="userHomeAddress"></textarea>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Weight (kg)
                        </div>
                        <input type="text" 
                                name="weight" 
                                placeholder="Optional (kilograms)" 
                                min="0"
                                pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
                                id="weight"
                                class="right-field">
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Weight (cm)
                        </div>
                        <input type="text" 
                                class="right-field"
                                name="height" 
                                min="0" 
                                pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
                                id="height">
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Gender
                        </div>
                        <div class="right-field" id="genderField">
                    </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Current Email Address
                        </div>
                        <div class="right-field" id="currentEmailField">
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            New Email Address
                        </div>
                        <input type="email" 
                                name="emailAddress"
                                id="emailAddress"
                                class="right-field">
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Username
                        </div>
                        <div class="right-field" id="usernameField">
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            New Password
                        </div>
                        <div class="right-field">
                            <input type="password" name="newPassword"><button class="togglePassword">Show Password</button>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Confirm New Password
                        </div>
                        <div class="right-field">
                            <input type="password" name="newPasswordConfirm"><button class="togglePassword">Show Password</button>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field" style="width:100%">
                            Medical Concerns <button id="medicalConcernBtn">Add</button>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field" id="medicalConcernsField"></div>
                    </div>

                    <div class="row-container">
                        <div class="left-field" style="width:100%">
                            Emergency Contact Details
                        </div>
                    </div>
                    <div class="row-container">
                        <div class="left-field">
                            Name
                        </div>
                        <div class="right-field">
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Relationship
                        </div>
                        <div class="right-field">
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Contact Number
                        </div>
                        <div class="right-field">
                        </div>
                    </div>

                    <div>Want to Add More ? <button>Add More</button></div>

                    <div class="btn-container">
                        <button>Save Changes</button>
                    </div>
                </div>                
            </div>

        </main>

        <?php require_once("../../public/general/footer.php"); ?>
    </body>
    <script src="/js/user/edit_profile_handle.js"></script>
    <script src="/js/user/edit_profile_getdetails.js"></script>
    <script src="/js/user/account_links.js"></script>
</html>