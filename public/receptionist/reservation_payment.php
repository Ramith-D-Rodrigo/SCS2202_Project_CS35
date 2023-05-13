<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
        Security::redirectUserBase();
        die();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/general/styles.css">
    <link rel="stylesheet" href="/styles/general/staff.css">
    <link rel="stylesheet" href="/styles/receptionist/receptionist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Reservation Payment</title>
</head>
<body>
    <?php
        require_once("dashboard_header.php");
    ?>
    <main class="body-container">
        <div style="display: flex;flex-direction:column">
            <div class="content-box" id="paymentReceipt">
                <h2 style="text-align: center;font-size:larger"><u>Payment Receipt</u></h2>
                <div id="branchInfo" style="display:flex;justify-content:flex-start">
                    <div class="row-container" style="justify-content:flex-start;">
                        <div class="left-side" style="width:38%"> 
                            Reservation Holder: <br>
                            Contact Number: <br>
                            Reservation ID: <br>
                            Receptionist ID: <br>
                            Branch Location: <br>
                            Branch Number: <br>
                            Generated At: <br>
                        </div>
                        <div class="right-side" style="margin-left:0px;width:51%">
                            <div id="name"> </div>
                            <div id="contactNum"> </div>
                            <div id="resID"> </div>
                            <div id="recID">  </div>
                            <div id="branchLoc">  </div>
                            <div id="branchNum"> </div>
                            <div id="time"> </div>
                        </div>
                    </div>
                </div>
                <table style="display: table !important;width:70%;text-align:left;margin-top:20px;background-color: #cddbde;border-radius:0px">
                    <tr>
                        <th style="font-style:italic;font-size:15px">Attribute</th>
                        <th style="font-style:italic;font-size:15px">Description</th>
                    </tr>
                    <tr>
                        <td>Sport</td>
                        <td><div id="sport"></div></td>
                    </tr>
                    <tr>
                        <td>Sport Court</td>
                        <td><div id="sportCourt"></div></td>
                    </tr>
                    <tr>
                        <td>Reserved Date</td>
                        <td><div id="resDate"></div></td>
                    </tr>
                    <tr>
                        <td>Starting Time</td>
                        <td><div id="startT"></div></td>
                    </tr>
                    <tr>
                        <td>Ending Time</td>
                        <td><div id="endT"></div></td>
                    </tr>
                    <tr>
                        <td>Number of People</td>
                        <td><div id="peopleCount"></div></td>
                    </tr>
                    <tr>
                        <td>Reservation Fee</td>
                        <td><div id="resFee">  Rs. </div></td>
                    </tr>
                </table>
                <div style="text-align:center; font-style:italic; margin-top:20px; font-size:smaller">This is a computer generated receipt</div>
                <div style="text-align:center; font-style:italic;font-size:smaller" id="fullBranchAddress"></div>
                <div style="text-align:center; font-style:italic;font-size:smaller" id="emailAddress"></div>
                <div style="color:black;font-size:smaller;text-align:center">
                    Powered by <img src="/styles/NewLogoDesign4.png" style="height:20px;margin-top:10px">
                </div>
                <div id="err-msg">
                </div>
            </div>
            <div style="display:flex;flex-direction:row;justify-content:flex-end">
                <button onclick="printReceipt()" class="btn" style="background-color:white;color:black;margin-top:20px"> Print <i class="fa-solid fa-print"></i> </button>
                <button onclick="saveReservation()" class="btn" style="background-color:white;color:black;margin-top:20px"> Save & Exit <i class="fa-solid fa-floppy-disk"></i> </button>
                <button onclick="window.location.href='../receptionist/onsite_reservation_entry.php'" class="btn" style="background-color:white;color:black;margin-top:20px">Cancel Reservation <i class="fa-solid fa-trash"></i> </button>
            </div>
        </div>
    </main>
    <?php
        require_once("../general/footer.php");
    ?>
</body>
    <script type="module" src="/js/receptionist/reservation_info.js"></script>
    <script src="/js/receptionist/make_reservation.js"></script>
    <script type="module" src="/js/general/notifications.js"></script>
</html>