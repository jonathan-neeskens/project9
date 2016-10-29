<?php include "includes/head.php" ?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">

    <div class="innerCanvas">
        <a href="menus.php"> <i class="fa fa-arrow-left fa-3x"></i></a>
        <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
        <div class="inside_innerCanvas">
            <h2> Reservering wijzigen </h2>
<!--            <?php
//            if(isset($_POST["change"])){
//                change_menu($_GET['id'], $_POST['name'], $_POST['price'], 'no');
//            }
//
//            if(isset($_POST["availability"])){
//                change_menu($_GET['id'], $_POST['name'], $_POST['price'], $_POST['availability']);
//            }
//
//            $query1 = mysqli_query($link, "SELECT * FROM menu WHERE id = $_GET[id]");
//            $row1 = mysqli_fetch_assoc($query1)
//
//
//            ?>-->
            <form method="POST">
                <input type="text" required name="name" value="<?php echo $row1['name'] ?>"><br>
                <input type="text" required name="price" value="<?php echo $row1['price'] ?>"><br>
                <input type="text" required name="price" value="<?php echo $row1['price'] ?>"><br>

                <br>
                <input type="submit" name="change" value="Wijzigingen opslaan (Tijdelijke knop)">
            </form>
        </div>
    </div>

</div>
</body>
</html>

