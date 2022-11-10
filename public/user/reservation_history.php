<?php
    session_start();
    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is not logged in
        header("Location: /index.php");
        exit();
    }

    if($_SESSION['userrole'] !== 'user'){   //not an user (might be another actor)
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
        <title>Reservation History</title>
    </head>
    <body>
        <?php
            require_once("../../public/general/header.php");
        ?>
        <main>
            <div class="content-box">
                <?php
                    if(!isset($_SESSION['reservationHistory'])){    //user has not made any reservations ?>
                        <div class="err-msg">
                            You have not made any reservations yet.
                        </div>
                    <?php
                    }
                    else{
                    ?>
                        <table>
                            <tr>
                                <th>Reservation ID</th>
                                <th>Date</th>
                                <th>Time Period</th>
                                <th>Sport</th>
                                <th>Branch</th>
                                <th>Court</th>
                                <th>Payment Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        <?php foreach($_SESSION['reservationHistory'] as $row){?>
                        <tr>
                            <td><?php echo $row -> reservation_id?></td>
                            <td><?php echo $row -> date?></td>
                            <td><?php echo $row -> time_period?></td>
                            <td><?php echo $row -> sport_name?></td>
                            <td><?php echo $row -> city?></td>
                            <td><?php echo $row -> court_name?></td>
                            <td><?php echo $row -> payment_amount?></td>
                            <td><?php echo $row -> status?></td>
                            <td>Buttons</td>
                        </tr>
                        <?php
                        }
                        ?>
                        </table>
                    <?php
                    }
                    ?>
            </div>
        </main>
        <?php
            require_once("../../public/general/footer.php");
        ?>    
    </body>
    <script src="/js/user/account_links.js"></script>
</html>