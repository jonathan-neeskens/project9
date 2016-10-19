    <?php include "includes/head.php" ?>
    <body>
    <?php include "includes/menu.php" ?>
    <div class="canvas bit-90">

        <div class="innerCanvas">
            <a href="customers.php"> <i class="fa fa-arrow-left fa-3x"></i></a>
            <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
            <div class="inside_innerCanvas">
                <h2> Gebruiker wijzigen </h2>
                <?php
                if(isset($_POST["change"])){
                    change_user($_GET['id'], $_POST['name'], $_POST['adress'], $_POST['city'], $_POST['mail'], $_POST['phone']);
                }

                elseif(isset($_POST["delete"])){
                    delete_user($_GET['id']);
                }

                $query1 = mysqli_query($link, "SELECT * FROM customer WHERE id = $_GET[id]");
                $row1 = mysqli_fetch_assoc($query1)


                ?>
                <form method="POST">
                    <input type="text" required name="name" value="<?php echo $row1['name'] ?>"><br>
                    <input type="text" required name="adress" value="<?php echo $row1['adress'] ?>"><br>
                    <input type="text" required name="city" value="<?php echo $row1['city'] ?>"><br>
                    <input type="email" required name="mail" value="<?php echo $row1['mail'] ?>"><br>
                    <input type="tel" required name="phone" value="<?php echo $row1['phone'] ?>"><br>
                    <input type="submit" name="change" value="Wijzigingen opslaan (Tijdelijke knop)"> <br>
                    <input type="submit" class="delete" name="delete" value="Gebruiker verwijderen (tijdelijke knop)">
                </form>
            </div>
        </div>

    </div>
    </body>
    </html>

