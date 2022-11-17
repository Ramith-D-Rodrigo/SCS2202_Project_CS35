<?php
    session_start();
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/styles/general/styles.css">
        <link rel="stylesheet" href="/styles/general/content_icons.css">
        <title>Our Sports</title>
    </head>
    <body>
        <?php
            require_once("header.php");
        ?>
        <main style="display:flex; justify-content:center; align-items:center;">
            <div class="content-box sports-content-box">
                <?php
                    if(isset($_SESSION['our_Sports'])){
                        foreach($_SESSION['our_Sports'] as $sport){
                ?>
                        <div class="sports-row">
                            <div class="sport-icon-container">
                                <img class ="sport-icon" src="/styles/icons/sports/<?php echo strtolower($sport['sport_name']).'.jpg'?>" onerror="this.src='/styles/icons/no-results.png'"/>
                            </div>
                            
                            <div>
                                <form class="search_result" method="post" action="/controller/general/user_selection_controller.php">
                                    Sport : <?php echo $sport['sport_name'] ?>
                                    <br>
                                    Reservation Price : Rs .<?php echo $sport['reserve_price'] ?> per hour
                                    <br>
                                    Available Branches : 
                                    <select required name="selected_branch">
                                        <option value=""></option>
                                        <?php foreach($sport['providing_branches'] as $branches){
                                        ?>
                                            <option value="<?php echo $branches['branch_id']?>"><?php echo $branches['branch_name']?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                    <br>
                                    <button type="submit" name="selectedSportBtn" value="<?php echo $sport['sport_id']?>">Make a Reservation</button>
                                </form>
                            </div>
                        </div>

                <?php
                        }   

                    }
                ?>
            </div>
        </main> 

        <?php
            require_once("footer.php");
        ?>
    </body>
    <script src="/js/user/account_links.js"></script>
</html>