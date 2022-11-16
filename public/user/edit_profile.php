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
                                <input type="text" name="contactNum" value="<?php echo $infoObject -> contactNo?>">
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
                                Weight 
                            </td>
                            <td>
                                <input type="text" name="weight" value="<?php echo $infoObject -> weight?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Height  
                            </td>
                            <td>
                                <input type="text" name="height" value="<?php echo $infoObject -> height?>">
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
                                <input type="text" name="newEmail">
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
                                Medical Concerns  <button>Add</button>
                                <br>
                                Example medical concern
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
                                <input type="file" name="profilePic">
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
                                <input type="text" name="emgName1">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Relationship
                            </td>
                            <td>
                                <input type="text" name="emgRelation1">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contact Number
                            </td>
                            <td>
                                <input type="text" name="emgContact1">
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