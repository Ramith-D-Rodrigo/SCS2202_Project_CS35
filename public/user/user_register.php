<?php
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: TRUE)){ //cannot access (NOT operator)
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
                <link rel="stylesheet" href="/styles/general/styles.css">
                <link rel="stylesheet" href="/styles/user/user_register.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <title>User Registration</title>
            </head>
            <body>
            <?php
                require_once("../general/header.php");
            ?>
                <main>
                    <div class='body-container'>
                        <div class="content-box">
                            <form>
                                <div class="row-container">
                                    <div class="left-field">Name </div>
                                    <div class="right-field">
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
                                    </div>
                                </div>
                                
                                
                                <div class="row-container">
                                    <div class="left-field">Date of Birth  </div>
                                    <div class="right-field">                        
                                        <input type="date"
                                                id ="bday" 
                                                name="birthday" 
                                                required style="flex:none"> 
                                    </div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">Contact Number </div>
                                    <div class="right-field">
                                        <input type="text"
                                            pattern="[0-9]{10,11}" 
                                            name="contactNum"
                                            id="usercontact"
                                            required>
                                    </div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">Home Address </div>
                                    <div class="right-field">                            
                                        <textarea 
                                            name="homeAddress"
                                            id="homeAddress" 
                                            required
                                            ></textarea>
                                    </div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">Height  </div>
                                    <div class="right-field">
                                        <input 
                                            type="text" 
                                            placeholder="Optional (centimeters)" 
                                            min="0" 
                                            pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
                                            id="height"
                                            name="height">
                                    </div>
                                </div>
                                
                                
                                <div class="row-container">
                                    <div class="left-field">Weight </div>
                                    <div class="right-field">
                                        <input 
                                            type="text" 
                                            placeholder="Optional (kilograms)" 
                                            min="0"
                                            pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
                                            id="weight"
                                            name="weight">
                                    </div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">Gender </div>
                                    <div class="right-field">
                                        <label>
                                            <input type="radio" name="gender" value="m" required> Male
                                        </label>
                                        <label>
                                            <input type="radio" name="gender" value="f"> Female
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="row-container">
                                    <div class="left-field">Email Address </div>
                                    <!-- pattern indicates that it must follow somename@topleveldomain.domain-->
                                    <div class="right-field">
                                        <input 
                                            type="email" 
                                            name="emailAddress"
                                            id="emailAddress"
                                            required> 
                                    </div>
                                </div>    


                                <div class="row-container">
                                    <div class="left-field">Username </div>
                                    <div class="right-field">
                                        <input 
                                            type="text" 
                                            required 
                                            minlength="6" 
                                            maxlength="15"
                                            pattern="^[a-z]([a-z0-9_]){5,15}"
                                            name="username"
                                            id="username"
                                            title="Minimum length of 6 and Maximum of 15. Must start with a letter and all letters should be lowercase. Only letters, numbers and '_' allowed">
                                    </div>
                                </div>
                                
                                
                                <div class='row-container'>
                                    <div class="left-field">Password </div>
                                    <div class="right-field">
                                        <input 
                                            type="password"  
                                            pattern="(?=.*\d)(?=.*[A-Z]).{8,}" 
                                            minlength="8"
                                            id="password"
                                            name="password"
                                            required title="Password length must be atleast 8 characters. Must include an uppercase letter and a number"> 
                                        <button class="togglePassword"> Show Password</button>
                                    </div>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">Confirm Password </div>
                                    <div class="right-field">
                                        <input type="password" id="passwordConfirm" required name="passwordConfirm"> <button class="togglePassword"> Show Password</button>
                                    </div>
                                </div>

                                <div id="medCon">
                                    <div class="title">
                                        Medical Concerns  (Maximum of 5 | Please Add one Concern per Field)
                                    </div>
                                    <button id="medConbtn"> Add </button>
                                </div>

                                <div class="row-container">
                                    <div class="left-field">Upload a Profile Picture</div>
                                    <div class="right-field">
                                        <input type=file name="user_pic" accept=".jpg, .jpeg, .png" id="user_profile_pic" title="Maximum File Size 2MB. Only Accepts JPG, PNG" style="width:100%">
                                    </div>
                                </div>
                                
                                

                                <div id="emergencyDetails">
                                    <div class="title">Emergency Contact Details</div>
                                    <div id="emergencydetail1">
                                        <div class="row-container">
                                            <div class="left-field">Name </div>
                                            <div class="right-field"><input type="text" name="name1" pattern ="[a-zA-Z ]+" required></div>
                                        </div>

                                        <div class="row-container">
                                            <div class="left-field">Relationship </div>
                                            <div class="right-field">
                                                <select required name="relationship1">
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
                                            <div class="left-field">Contact Number </div>
                                            <div class="right-field">
                                                <input 
                                                    type="text" 
                                                    min="0" 
                                                    name="emgcontactNum1" 
                                                    required 
                                                    pattern="[0-9]{10,11}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="option-btn">
                                    Want to Add More? (Maximum of 3)
                                    <button id="emergencyDetailsbtn">Add More</button>
                                </div>
                                <div id="mailVerificationBox"></div>
                                <div id="errmsg" class="err-msg"></div>
                                <div id="successmsg" class="success-msg"></div>
                                <div class="btn-container">
                                    <button type="submit" id="registerBtn"  name= "regSubmitBtn" value="submit" onclick="return validateForm(event)"> Register </button>
                                </div>
                            </form>                    
                        </div>
                    </div>
                </main>

            <?php
                require_once("../general/footer.php");
            ?>

            </body>
            <script src="/js/user/user_register_form.js"></script>
            <script src="/js/user/user_register_form_handle.js"></script>
            <script src="/js/user/user_register_validation.js"></script>
        </html>
    <?php
    }
?>