<?php
  session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Receptionist Request</title>
    <link rel="stylesheet" href="/styles/manager/manager_handle_receptionist_request.css" />
    <link rel="stylesheet" href="/styles/general/styles.css" />
    <link rel="stylesheet" href="/styles/general/staff.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  </head>

   <body>
      <?php
        require_once("manager_header.php");
      ?>
        <main class="body_container">
            <!-- <div class="content_box"> -->
                <table id="Table" style="width:90%">
                    <tr>
                        <th>Reason</th>
                        <th>Starting<br>Date</th>
                        <th>Ending<br>Date</th>
                        <th>Sport<br>Name</th>
                        <th>Sport Court<br>Name</th>
                        <th>Status</th>
                        <th>Requested<br>by</th>
                        <th>Dession</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> 
                            <select required name="decision">
                            <option value="">Choose </option>
                            <option value="Ok" <?php if(isset($_SESSION['decision'])){
                                if($_SESSION['decision'] === "Ok"){
                                echo 'selected';
                                }
                            }?>>Ok</option>
                            <option value="Cancel" <?php if(isset($_SESSION['decision'])){
                                if($_SESSION['decision'] === "Cancel"){
                                echo 'selected';
                                }
                            }?>>Cancel</option>
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> 
                            <select required name="decision">
                            <option value="">Choose </option>
                            <option value="Ok" <?php if(isset($_SESSION['decision'])){
                                if($_SESSION['decision'] === "Ok"){
                                echo 'selected';
                                }
                            }?>>Ok</option>
                            <option value="Cancel" <?php if(isset($_SESSION['decision'])){
                                if($_SESSION['decision'] === "Cancel"){
                                echo 'selected';
                                }
                            }?>>Cancel</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> 
                            <select required name="decision">
                            <option value="">Choose </option>
                            <option value="Ok" <?php if(isset($_SESSION['decision'])){
                                if($_SESSION['decision'] === "Ok"){
                                echo 'selected';
                                }
                            }?>>Ok</option>
                            <option value="Cancel" <?php if(isset($_SESSION['decision'])){
                                if($_SESSION['decision'] === "Cancel"){
                                echo 'selected';
                                }
                            }?>>Cancel</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> 
                            <select required name="decision">
                            <option value="">Choose </option>
                            <option value="Ok" <?php if(isset($_SESSION['decision'])){
                                if($_SESSION['decision'] === "Ok"){
                                echo 'selected';
                                }
                            }?>>Ok</option>
                            <option value="Cancel" <?php if(isset($_SESSION['decision'])){
                                if($_SESSION['decision'] === "Cancel"){
                                echo 'selected';
                                }
                            }?>>Cancel</option>
                            </select>
                        </td>
                    </tr>
                </table>
        </main>
        <?php
          require_once("../general/footer.php");
        ?>
    </body>
</html>  