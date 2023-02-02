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
        <link rel="stylesheet" href="/styles/coach/student_request.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="stylesheet" href="../../styles/coach/coach.css">

        <title>Student's Requesst </title>
    </head>
    <body>
        <?php
            require_once("dashboard_header.php");
        ?>
      <main>
        <div class="container">
            <table>
                <tbody>
                    <thead>
                        <th>Sent Date</th>
                        <th>Student Name</th>
                        <th>Message</th>
                        <th>Profile</th>
                        <th></th>
                        
                    </thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><button>profile</button></td>
                        <td>
                            <div class="tabs1">
                                <button >Accept</button>
                                <button >Decline</button>
                                <input type="text" placeholder="reason"></input>
                            </div>
                        </td>
                        
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><button>profile</button></td>
                        <td>
                            <div class="tabs1">
                                <button >Accept</button>
                                <button >Decline</button>
                                <input type="text" placeholder="reason"></input>
                            </div>
                        </td>
                        
                        
                    </tr>
                    
                </tbody>
            </table>
        </div>
     </main>  
        <?php
            require_once("../../public/general/footer.php");
        ?>
    </body>
    <!-- <script src="/js/user/account_links.js"></script>
    <script src="/js/general/our_feedback.js"></script> -->
</html>