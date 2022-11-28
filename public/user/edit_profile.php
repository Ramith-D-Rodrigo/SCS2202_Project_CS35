<?php
    session_start();

    $infoObject = json_decode($_SESSION['profileInfo']);
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
                    <table class="form-type">
                        <tr>
                            <td>
                                Name  
                            </td>
                            <td>
                                <div style="margin-left:10px">
                                    <?php echo $infoObject -> fName . " " . $infoObject -> lName?>
                                </div>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Date of Birth 
                            </td>
                            <td>
                                <div style="margin-left:10px">
                                    <?php echo $infoObject -> dob?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contact Number 
                            </td>
                            <td>
                                <input type="text" name="contactNum"
                                pattern="[0-9]{10,11}" 
                                id="usercontact"
                                required 
                                value="<?php echo $infoObject -> contactNo?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Home Address 
                            </td>
                            <td>
                                <textarea name="homeAddress"><?php echo htmlspecialchars_decode($infoObject -> homeAddress, ENT_QUOTES)?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Weight (kg)
                            </td>
                            <td>
                                <input type="text" 
                                name="weight" 
                                placeholder="Optional (kilograms)" 
                                min="0"
                                pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
                                id="weight"
                                value="<?php echo $infoObject -> weight?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Height (cm)
                            </td>
                            <td>
                                <input type="text" 
                                name="height" 
                                min="0" 
                                pattern = "[1-9][0-9]*(?:\.[1-9][0-9])*"
                                id="height"
                                value="<?php echo $infoObject -> height?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Gender  
                            </td>
                            <td>
                                <div style="margin-left:10px">
                                    <?php if($infoObject -> gender === 'm'){ echo 'Male';}else{ echo 'Female';}?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Current Email Address  
                            </td>
                            <td>
                                <div style="margin-left:10px">
                                    <?php echo $infoObject -> email?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                New Email Address  
                            </td>
                            <td>
                                <input type="email" 
                                name="emailAddress"
                                id="emailAddress">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Username  
                            </td>
                            <td>
                                <div style="margin-left:10px">
                                    <?php echo $infoObject -> username?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                New Password
                            </td>
                            <td>
                                <input type="password" name="newPassword"><button class="togglePassword">Show Password</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Confirm New Password
                            </td>
                            <td>
                                <input type="password" name="newPasswordConfirm"><button class="togglePassword">Show Password</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "2">
                                Medical Concerns  <button id="medicalConcernBtn">Add</button>
                            </td>
                        </tr>
                        <tr>                       
                            <td colspan="2">
                                <ol style="margin-left:25px" id="medicalConcernList"><?php
                                    $i = 1;
                                    foreach($infoObject -> medicalConcerns as $concern){?>
                                    <li>
                                        <?php 
                                            echo $concern -> medical_concern;             
                                        ?><button class ="concernRemoveBtn" id="concernRemoveBtn<?php echo $i++?>">Remove</button>
                                    </li>
                                <?php
                                    }
                                ?></ol>
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "2">
                                Profile Picture
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if(isset($infoObject -> profilePic)){
                                ?>
                                    <img src="/public/user/profile_images/<?php echo $infoObject -> profilePic?>" style="width:200px; display:block;"/>
                                <?php
                                }
                                else{
                                    echo "Not uploaded";
                                }
                                ?>
                            </td>
                            <td>
                                <input type="file" name="profilePic" accept=".jpg, .jpeg, .png" id="user_profile_pic" title="Maximum File Size 2MB. Only Accepts JPG, PNG">
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "2">
                                Emergency Contact Details 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Name
                            </td>
                            <td>
                                <input type="text" name="emgName1" value="<?php echo $infoObject -> dependents[0] -> name?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Relationship
                            </td>
                            <td>
                                <input type="text" name="emgRelation1" value="<?php echo $infoObject -> dependents[0] -> relationship?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contact Number
                            </td>
                            <td>
                                <input type="text" name="emgContact1" value="<?php echo $infoObject -> dependents[0] -> contact_num?>">
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "2">
                                Want to Add More ? <button>Add More</button>
                            </td>
                        </tr>
                    </table>
                    <div class="btn-container">
                        <button>Save Changes</button>
                    </div>
                </div>                
            </div>

        </main>

        <?php require_once("../../public/general/footer.php"); ?>
    </body>
    <script src="/js/user/edit_profile_handle.js"></script>
    <script src="/js/user/account_links.js"></script>
</html>