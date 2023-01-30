<?php
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){ //cannot access (NOT operator)
        Security::redirectUserBase();
    }
    else{
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
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
            </head>
            <body>
                <?php   require_once("../../public/general/header.php"); ?>

                <main>
                    <div class="body-container" style="flex-direction:column">
                        <div class="content-box" style="min-width:40%">
                            <form id="editForm">
                                <div id="profilePicField" class="row-container">
                                    <img id="profilePicImg">
                                    <input type="file" 
                                    name="profilePic" 
                                    id="profilePicUploadInput" 
                                    accept=".jpg, .jpeg, .png" 
                                    title="Maximum File Size 2MB. Only Accepts JPG, PNG"
                                    style="display:none;">
                                </div>

                                <div class="row-container">
                                    <div class="left-field">Name</div>
                                    <div class="right-field" id="nameField"></div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">
                                        Date of Birth
                                    </div>
                                    <div class="right-field" id="birthdayField"></div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">
                                        Contact Number
                                    </div>
                                    <div class="right-field">
                                        <input type="text" name="contactNo"
                                            pattern="[0-9]{10,11}" 
                                            id="usercontact"
                                            required>
                                    </div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">
                                        Home Address
                                    </div>
                                    <div class="right-field">
                                        <textarea name="homeAddress" id="userHomeAddress" required></textarea>
                                    </div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">
                                        Weight (kg)
                                    </div>
                                    <div class="right-field">
                                        <input type="text" 
                                                name="weight" 
                                                min="0"
                                                pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
                                                id="weight">
                                    </div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">
                                        Height (cm)
                                    </div>
                                    <div class="right-field">
                                        <input type="text" 
                                                name="height" 
                                                min="0" 
                                                pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
                                                id="height">
                                    </div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">
                                        Gender
                                    </div>
                                    <div class="right-field" id="genderField"></div>
                                </div>

                                <div style="text-align:center">
                                    Medical Concerns <button id="medicalConcernBtn"><i class="fa-solid fa-circle-plus"></i></button>
                                </div>

                                <div id="medicalConcernsField" style="width:100%">
                                </div>

                                <div style="text-align:center">Emergency Contact Details</div>

                                <div id="emergencyDetails">
                                    <div id="emergencydetail1">
                                        <div class="row-container">
                                            <div class="left-field">
                                                Name
                                            </div>
                                            <div class="right-field">
                                                <input required type="text" name="name1" id="name1" pattern="[a-zA-Z ]+">
                                            </div>
                                        </div>

                                        <div class="row-container">
                                            <div class="left-field">
                                                Relationship
                                            </div>
                                            <div class="right-field">
                                                <select required name="relationship1" id="relationship1"> 
                                                    <option value="">Choose One</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Sibling 1">Sibling 1</option>
                                                    <option value="Sibling 2">Sibling 2</option>
                                                    <option value="Friend 1">Friend 1</option>
                                                    <option value="Friend 2">Friend 2</option>
                                                    <option value="Partner">Partner</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row-container">
                                            <div class="left-field">
                                                Contact Number
                                            </div>
                                            <div class="right-field">
                                                <input required type="text" name="contact1" id="contact1" pattern="[0-9]{10,11}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align:center">Want to Add More ? <button id="emergencyDetailsBtn"><i class="fa-solid fa-circle-plus"></i></button></div>
                                <div class="err-msg" id="errMsg"></div>
                                <div class="success-msg" id="successMsg"></div>
                                <div class="btn-container">
                                    <button type="submit" id="submitBtn" onclick="return validateChanges(event)">Save Changes <i class="fa-solid fa-floppy-disk"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="content-box" style="min-width:40%">
                            <form id="credentialForm">
                                <div style="text-align:center">Change Email / Password</div>
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
                                    <div class="right-field">
                                        <input type="email" 
                                                name="email"
                                                id="emailAddress">
                                    </div>
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
                                        <input type="password" name="newPassword" id="password" pattern="(?=.*\d)(?=.*[A-Z]).{8,}" minlength="8"><button class="togglePassword"><i class="fa-solid fa-eye"></i></button>
                                    </div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">
                                        Confirm New Password
                                    </div>
                                    <div class="right-field">
                                        <input type="password" name="newPasswordConfirm" id="confirmPassword"><button class="togglePassword"><i class="fa-solid fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="btn-container">
                                    <button type="submit" id="submitBtn2" onclick="return validateEmailPasswordForm(event)">Save Changes <i class="fa-solid fa-floppy-disk"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>

                <?php require_once("../../public/general/footer.php"); ?>
            </body>
            <script src="/js/user/edit_profile_handle.js"></script>
            <script src="/js/user/edit_profile_getdetails.js"></script>
            <script src="/js/user/account_links.js"></script>
        </html>
    <?php
    }
?>