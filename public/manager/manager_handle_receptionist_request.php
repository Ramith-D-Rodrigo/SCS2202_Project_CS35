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
  </head>

   <body>
      <?php
        require_once("manager_handle_receptionist_request_header.php");
      ?>
        <main class="body_container">
            <div class="content_box">
                <table style="width:90%">
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