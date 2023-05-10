<?php
    session_start();

    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the coach is not logged in
        header("Location: /index.php");
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
        <link rel="stylesheet" href="/styles/coach/edit_profile.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="stylesheet" href="../../styles/coach/coach.css">

        <title>Edit Profile</title>
    </head>
    <body>
        <?php
            require_once("dashboard_header.php");
        ?>
         <main>
            <div class="body-container" style="flex-direction:column">
                <div class="content-box" style="min-width:40%">
                    <form id="editForm">
                        <div>
                            <div id="profilePicField" class="row-container"></div>
                            <div id="profilePicUpload" class="row-container">
                                <button id="profilePicUploadBtn">
                                    <i class="fas fa-image" style="font-size:1.5rem; margin-right:0.25rem"></i>
                                    <i class="fas fa-upload" style="font-size:1.5rem; margin-left:0.25rem"></i>
                                    <input type="file" 
                                    name="profilePic" 
                                    id="profilePicUploadInput" 
                                    accept=".jpg, .jpeg, .png" 
                                    title="Maximum File Size 2MB. Only Accepts JPG, PNG"
                                    style="display:none;">
                                </button>
                            </div>
                        </div>

                        <div class="row-container">
                            <div class="left-field">First Name</div>
                            <div class="right-field" id="nameField"><output></output></div>
                        </div>
                        <div class="row-container">
                            <div class="left-field">Last Name</div>
                            <div class="right-field" id="nameField"><output></output></div>
                        </div>

                        <div class="row-container">
                            <div class="left-field">
                                Date of Birth
                            </div>
                            <div class="right-field" id="birthdayField"><output> </output></div>
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
                                Gender
                            </div>
                            <div class="right-field" id="genderField"><output> </output></div>
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
                            <div class="right-field" id="usernameField"><output> </output></div>
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

                        
                        <div class="err-msg" id="errMsg"></div>
                        <div class="sucess-msg" id="successMsg"></div>
                        <div class="btn-container">
                            <button type="submit" id="submitBtn" onclick="return validateChanges(event)">Save Changes <i class="fa-solid fa-floppy-disk"></i></button>
                        </div>
                    </form>
                </div>

                <div class="content-box" style="min-width:40%">
                    <form id="credentialForm">
                        <div style="text-align:center">Deactvate Account</div>
                        <div class="row-container">
                            <div class="left-field">
                               
                            </div>
                            <div class="right-field" id="currentEmailField">
                            </div>
                        </div>

                        <div class="row-container">
                            <div class="left-field">
                                Enter username
                            </div>
                            <div class="right-field">
                                <input type="email" 
                                        name="email"
                                        id="emailAddress">
                            </div>
                        </div>

                        

                        <div class="row-container">
                            <div class="left-field">
                                Enter Password
                            </div>
                            <div class="right-field">
                                <input type="password" name="newPassword" id="password" pattern="(?=.*\d)(?=.*[A-Z]).{8,}" minlength="8"><button class="togglePassword"><i class="fa-solid fa-eye"></i></button>
                            </div>
                        </div>

                       
                        <div class="btn-container">
                            <button type="submit" id="submitBtn2" onclick="return validateEmailPasswordForm(event)">Deactvate Account <i class="fa-solid fa-floppy-disk"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php
            require_once("../../public/general/footer.php");
        ?>
    </body>
    <!-- <script src="/js/user/account_links.js"></script>
    <script src="/js/general/our_feedback.js"></script> -->
</html>