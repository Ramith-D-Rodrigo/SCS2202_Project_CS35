<?php
    session_start();
    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the coach is not logged in
        header("Location: /index.php");
        exit();
    }

    if($_SESSION['userrole'] !== 'coach'){   //not an coach (might be another actor)
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
        <link rel="stylesheet" href="/styles/coach/coaching_session.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="stylesheet" href="../../styles/coach/coach.css">

        <title>Coaching Session</title>
    </head>
    <body>
        <?php
            require_once("dashboard_header.php");
        ?>
        <main>
        <div class="flex-container">
            <div class="tabs add_session">
                
                <div><button class =" " onclick="window.location.href='/controller/coach/add_new_session_entry_controller.php'">Add session</button></div>
            </div>
        </div>    
            <div class="content-box">
                <?php
                    if(!isset($_SESSION['sessionDetails'])){    //coach hasn't any session yet ?>
                        <div class="err-msg">
                            No session yet
                        </div>
                    <?php
                    }
                    else{
                        $i = 1; //for each session of user
                    ?>
                        <table>
                            <tbody>
                                <tr>
                                    <th>Session ID</th>
                                    <th>Court</th>
                                    <th>Branch</th>
                                    <th>Timeslot</th>
                                    <th>Day</th>
                                    <th>Fee</th>
                                    <th>
                                       
                                    </th>
                                    
                                </tr>
                            <!--LINE 63 to 74 for hard coding for presentation after presentation delete this-->
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button onclick="window.location.href='viewing_session.php'">View session</button>
                                    </td>
                                </tr>

                           <!-- <?php foreach($_SESSION['sessionDetails'] as $row){
                                    
                                    ?>
                                <tr>
                                    <td><?php echo $row -> session_id ?></td>
                                    <td><?php echo $row -> court_name ?></td>
                                    <td><?php echo $row -> city ?></td>
                                    <td><?php echo $row -> starting_time."-".$row -> ending_time ?></td>
                                    <td><?php echo $row -> day ?></td>
                                    <td><?php echo "Rs.".$row -> coach_monthly_payment ?></td>
                                    <tr><button onclick="window.location.href='viewing_session.php'">View session</button></tr>
                                    
                                    
                                </tr>
                                <?php
                            } ?>-->
                            </tbody>
                        </table>
                           <?php
                    } ?> 
            </div>
        </main>
        <?php
            require_once("../../public/general/footer.php");
           
        ?>    
    </body>
   
</html>