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
                    <table class="form-type">
                        <tr>
                            <td>
                                Name  
                            </td>
                            <td>
                                : Example name
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Date of Birth 
                            </td>
                            <td>
                                : Example Birthday
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contact Number 
                            </td>
                            <td>
                                : <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Home Address 
                            </td>
                            <td>
                                : <textarea></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Weight 
                            </td>
                            <td>
                                : <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Height  
                            </td>
                            <td>
                                : <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Gender  
                            </td>
                            <td>
                                : Example Gender
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Current Email Address  
                            </td>
                            <td>
                                : Example Email
                            </td>
                        </tr>
                        <tr>
                            <td>
                                New Email Address  
                            </td>
                            <td>
                                : <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Username  
                            </td>
                            <td>
                                : Example Username
                            </td>
                        </tr>
                        <tr>
                            <td>
                                New Password
                            </td>
                            <td>
                                : <input type="text"><button>Show Password</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Confirm New Password
                            </td>
                            <td>
                                : <input type="text"><button>Show Password</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan = "2">
                                Medical Concerns : 
                                <br>
                                Example medical concern
                            </td>
                        </tr>
                    </table>
                </div>                
            </div>

        </main>

        <?php require_once("../../public/general/footer.php"); ?>
    </body>
    <script src="/js/user/account_links.js"></script>
</html>