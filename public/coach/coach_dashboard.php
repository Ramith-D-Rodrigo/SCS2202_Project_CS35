<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/coach/styles.css">
    <link rel="stylesheet" href="../../styles/coach/coach_dashboard.css">

    <title>Dashboard</title>
</head>

<body>
    <?php
    require_once("header.php");
    ?>

    
    <main>
    <div class="main-body">





        <div class="today-Session">
            <div class="header">
                <h2>Today Session</h2>
            </div>

            <div class="contentSection">
                <ul>
                    <li>Coffee</li>
                    <li>Tea</li>
                    <li>Milk</li>
                </ul>

            </div>

            <div class="viewMoreButton">
                <button>
                    View More Info
                </button>
            </div>

        </div>


        <div class="payment-income">
            <div class="header">
                <h2> payment & Income </h2>
            </div>

            <div class="contentSection">
                <ul>
                    <li>Coffee</li>
                    <li>Tea</li>
                    <li>Milk</li>
                </ul>
            </div>

            <div class="viewMoreButton">
                <button>
                    View More Info
                </button>
            </div>

        </div>


        <div class="feedback">
            <div class="header">
                <h2> feedback & Reviews </h2>
            </div>


            <div class="contentSection">
                <ul>
                    <li>Coffee</li>
                    <li>Tea</li>
                    <li>Milk</li>
                </ul>
            </div>

            <div class="viewMoreButton">
                <button>
                    View More Info
                </button>
            </div>
        </div>

    </div>
    </main>
    <?php
    require_once("footer.php");
    ?>
</body>

</html>