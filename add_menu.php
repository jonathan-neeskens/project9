<?php include "includes/head.php" ?>
<body>
<?php include "includes/menu.php" ?>
<div class="canvas bit-90">

    <div class="innerCanvas">
        <a href="menus.php"> <i class="fa fa-arrow-left fa-3x"></i></a>
        <a href="#"> <i class="fa fa-floppy-o fa-3x"></i> </a>
        <div class="inside_innerCanvas">
            <h2> Nieuw menu toevoegen </h2>
            <?php
            if(isset($_POST["save"])){
                create_menu($_POST['name'], $_POST['price']);
            }
            ?>
            <form method="POST">
                <input type="text" required name="name" placeholder="Naam"><br>
                <input type="text" required name="adress" placeholder="Prijs"><br>
                <input type="submit" name="save" value="Opslaan (Tijdelijke knop)">
            </form>
        </div>
    </div>

</div>
</body>
</html>
