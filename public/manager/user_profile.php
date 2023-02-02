<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>User Profile</title>
    <link rel="stylesheet" href="/styles/manager/user_profile.css" />
    <link rel="stylesheet" href="/styles/general/styles.css" />
</head>

<body>
    <?php
    require_once("manager_header.php");
    ?>
    <main class="body_container">
        <div class="content_box">


            <div id="Image">
                <img src=" C:\Users" width="250" height="250" id="img">

                <div id="Name">
                    Name:
                    <input type="text" pattern="[a-zA-Z]+" name="Name" id="name" value="">
                    <br>

                    Gernder:
                    <input type="text" name="Gender" id="Gender" value="">
                    <br>

                    Age:
                    <input type="text" name="Age" id="Age" value="">
                    <br>

                    Email:
                    <input type="email" name="email_address" id="Email" value="">
                </div>

                <div>
                   <div id="home"> Home Address:</div> 
                    <textarea id ="area" name="homeAddress"></textarea>
                    <br>

                    Height:
                    <input type="text" id="height" name="height">
                    Weight:
                    <input type="text" id="weight" name="weight">
                    <br>

                    Medical Concern:
                    <br>

                    <div id="Emergency">
                        Emergency Contact Details:

                        <select required name="relationship1">
                            <option value="">Relationship</option>
                            <option value="Mother">Mother</option>
                            <option value="Father">Father</option>
                            <option value="Sibling 1">Sibling 1</option>
                            <option value="Sibling 2">Sibling 2</option>
                            <option value="Friend 1">Friend 1</option>
                            <option value="Friend 2">Friend 2</option>
                            <option value="Partner">Partner</option>
                        </select>
                        <br>


                    </div>
                </div>
            </div>
        </div>

        <div class="success-msg">
            <?php
            if (isset($_SESSION['resultMsg'])) {
                echo $_SESSION['resultMsg'];
                unset($_SESSION['resultMsg']);
            }
            ?>
        </div>
        </form>
        </div>
    </main>
    <?php
    require_once("../general/footer.php");
    ?>
</body>

</html>