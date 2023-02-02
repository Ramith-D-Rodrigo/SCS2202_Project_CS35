<?php
    session_start();

    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the coach is not logged in
        header("Location: /index.php");
        exit();
    }

    // if($_SESSION['userrole'] !== 'coach'){   //not an coach (might be another actor)
    //     header("Location: /index.php");
    //     exit();
    // }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <link rel="stylesheet" href="/styles/coach/student_profile.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

        <title>Student Profile </title>
    </head>
    <body>
        <?php
            require_once("dashboard_header.php");
        ?>
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
                            <div class="left-field">Name</div>
                            <div class="right-field" id="nameField"><output></output></div>
                        </div>

                        <div class="row-container">
                            <div class="left-field">
                                Age:
                            </div>
                            <div class="right-field" id="birthdayField"><output> </output></div>
                        </div>

                        <div class="row-container">
                            <div class="left-field">
                                Gender:
                            </div>
                            <div class="right-field" id="genderField"><output> </output></div>
                        </div>

                        <div class="row-container">
                            <div class="left-field">
                                Contact Number:
                            </div>
                            <div class="right-field" id=""><output> </output></div>
                        </div>
                        
                        <div class="row-container">
                            <div class="left-field">
                                Email Address:
                            </div>
                            <div class="right-field" id=""><output> </output></div>
                        </div>

                        <div class="row-container">
                            <div class="left-field">
                                Weight:
                            </div>
                            <div class="right-field" id=""><output> </output></div>
                        </div>

                        <div class="row-container">
                            <div class="left-field">
                                Height:
                            </div>
                            <div class="right-field" id=""><output> </output></div>
                        </div>

                        <div class="row-container">
                            <div class="left-field">
                                Medical Concern:
                            </div>
                            <div class="right-field">
                                <select ><option>Choose One </option></select>
                            </div>
                        </div>

                        <div style="text-align:center">Emergency Contact Details</div>

                        <div class="row-container">
                                    <div class="left-field">
                                        Relationship
                                    </div>
                                    <div class="right-field">
                                        <select required name="relationship1" id="relationship1"> 
                                            <option value="">Choose One</option>
                                            
                                        </select>
                                    </div>
                                </div>

                        <div id="emergencyDetails">
                            <div id="emergencydetail1">
                                <div class="row-container">
                                    <div class="left-field">
                                        Name:
                                    </div>
                                    <div class="right-field" id=""><output> </output></div>
                                </div>
                                

                                <div class="row-container">
                                    <div class="left-field">
                                        Contact Number
                                    </div>
                                    <div class="right-field" id=""><output> </output></div>

                                    </div>
                                </div>
                            </div>

                        

                        
                        <div class="err-msg" id="errMsg"></div>
                        <div class="sucess-msg" id="successMsg"></div>
                    </form>
                </div>

                
                    </form>
                </div>
            </div>
        </main>
        <?php
            require_once("../../public/general/footer.php");
        ?>
    </body>
        <?php
            require_once("../../public/general/footer.php");
        ?>
    </body>
    <!-- <script src="/js/user/account_links.js"></script>
    <script src="/js/general/our_feedback.js"></script> -->
</html>