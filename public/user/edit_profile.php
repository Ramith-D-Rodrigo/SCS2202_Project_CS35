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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    </head>
    <body>
        <?php   require_once("../../public/general/header.php"); ?>

        <main>
            <div class="body-container">
                <form class="content-box" id="editForm">

                    <div>
                        <div id="profilePicField" style="display:flex; justify-content:center; margin: 10px 0;"></div>
                        <div id="profilePicUpload" style="display:flex; justify-content:center; margin: 10px 0">
                            <button id="profilePicUploadBtn">
                                <i class="fas fa-image" style="font-size:1.5rem; margin-right:0.25rem"></i>
                                <i class="fas fa-upload" style="font-size:1.5rem; margin-left:0.25rem"></i>
                                <input type="file" 
                                name="profilePicUpload" 
                                id="profilePicUploadInput" 
                                accept=".jpg, .jpeg, .png" 
                                title="Maximum File Size 2MB. Only Accepts JPG, PNG"
                                style="display:none;">
                            </button>
                        </div>
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
                        <textarea class="right-field" name="homeAddress" id="userHomeAddress" required></textarea>
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
                            <input type="password" name="newPassword"><button class="togglePassword"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field">
                            Confirm New Password
                        </div>
                        <div class="right-field">
                            <input type="password" name="newPasswordConfirm"><button class="togglePassword"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field" style="text-align:center">
                            Medical Concerns <button id="medicalConcernBtn"><i class="fa-solid fa-circle-plus"></i></button>
                        </div>
                    </div>

                    <div class="row-container">
                        <div class="left-field" id="medicalConcernsField" style="width:100%"></div>
                    </div>

                    <div id="emergencyDetails">
                        <div style="text-align:center">Emergency Contact Details</div>
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

                    <div class="btn-container">
                        <button type="submit" id="submitBtn">Save Changes <i class="fa-solid fa-floppy-disk"></i></button>
                    </div>
                </form>                
            </div>

        </main>

        <?php require_once("../../public/general/footer.php"); ?>
    </body>
    <script src="/js/user/edit_profile_handle.js"></script>
    <script src="/js/user/edit_profile_getdetails.js"></script>
    <script src="/js/user/account_links.js"></script>
</html>