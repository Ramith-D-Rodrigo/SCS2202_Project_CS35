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
        <title>Our Sports</title>
    </head>
    <body>
        <?php
            require_once("header.php");
        ?>
        <main>
            <div class="content-box">
                <?php
                    if(isset($_SESSION['our_Sports'])){
                        foreach($_SESSION['our_Sports'] as $sport){
                ?>
                        <form class="search_result">
                            Sport : <?php echo $sport['sport_name'] ?>
                            <br>
                            Reservation Price : Rs .<?php echo $sport['reserve_price'] ?> per hour
                            <br>
                            Available Branches : 
                            <select required>
                                <option value=""></option>
                                <?php foreach($sport['providing_branches'] as $branches){
                                ?>
                                    <option value="<?php echo $branches['branch_id']?>"><?php echo $branches['branch_name']?></option>
                            <?php
                                }
                            ?>
                            </select>
                            <br>
                            <button type="submit">Make a Reservation</button>
                        </form>
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